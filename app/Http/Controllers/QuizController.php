<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CoursedBasedAssignment;
use App\Models\IndependentDescriptiveAnswer;
use App\Models\IndependentTest;
use App\Models\IndependentTestQuestions;
use App\Models\Question;
use App\Models\QuestionModules;
use App\Models\subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

use function GuzzleHttp\Promise\all;

class QuizController extends Controller
{
    function QuizIndex(){

        return view('tests.index');
     }

     function QuizPost(Request $request){
        IndependentTest::create([
            'name'=>$request->name,
            'introduction_text'=>$request->introduction_text,
            'passing_comment'=>$request->pass_comment,
            'failing_comment'=>$request->failing_comment,
            'time'=>$request->time,
            'start_date'=>$request->start_date,
            'start_time'=>$request->start_time,
            'end_date'=>$request->end_date,
            'end_time'=>$request->end_time,
            'pass_marks'=>$request->pass_marks,
            'status'=>0,
            'created_at'=>Carbon::now(),
        ]);

        return back()->with('success','Successful');

     }
     function IndependentQuestionIndex($id){
        $subjects=subject::select('id','name')->get();
        return view('tests.question_add',
    [
        'subjects'=>$subjects,
        'id'=>$id,
    ]);
     }
    function Ajax(Request $request){
        $send_to_cat='<option value="">---Select module---</option>';
        $Modules = QuestionModules::where('subject_id',$request->subject_id)->get();
        foreach($Modules as $module){
            $send_to_cat.='<option value="'.$module->id.' ">'.$module->name .'</option>';
        }
        echo $send_to_cat;

    }
    function InpendentQuestionPost(Request $request){

        $questions=Question::where('module_id',$request->module_id)->get();

        if(((int)($request->q_no )> count($questions)) || ((int) $request->q_no<0)){
            return back()->with('error','Question limit exceded');
        }else{
            $questions=Question::where('module_id',$request->module_id)->inRandomOrder()->take($request->q_no)->get();
            foreach($questions as $question){
                IndependentTestQuestions::create([
                    'quiz_id'=>$request->quiz_id,
                    'question_id'=>$question->id,
                    'created_at'=>Carbon::now(),
                ]);

            }
            return back()->with('success','Data Added');
        }

    }
    function InpendentSpecificQuestionPost(Request $request){
        $request->validate([
            'subject_id'=>'required',
            'module_id'=>'required',
        ],
    [
        'subject_id.required'=>'Subject must be selected',
        'module_id.required'=>'MOdule must be selected',
    ]);
    $questions= Question::select('id','title')->where('module_id',$request->module_id)->get();
    return view('tests.question_specific_add',
        [
            'questions'=>$questions,
            'quiz_id'=>$request->quiz_id,
        ]);

    }

    function IndependentSpecificQuizQuestionAdd(Request $request){
        $questions=$request->question_id;
        $quiz_id=$request->quiz_id;

        foreach($questions as $question){
            IndependentTestQuestions::create([
                'quiz_id'=>$quiz_id,
                'question_id'=>$question,
                'created_at'=>Carbon::now(),
            ]);
        }
        return redirect(route('quiz.indipendent.question.index',$quiz_id))->with('success','Question Added Succesfully');
    }
    function IndependentQuestionShow($id){
        $questions=IndependentTestQuestions::select('question_id','id')->where('quiz_id',$id)->get();

        return view('tests.show_questions',[

            'questions'=>$questions,
        ]);



    }
    function StatusChange($id){


        $test=IndependentTest::where('id',$id)->first();

        if( $test->status == 0){

            IndependentTest::where('id',$id)->update([
                'status'=>1,
            ]);
        }else{

            IndependentTest::where('id',$id)->update([
                'status'=>0,
            ]);

        }
        return back();

    }

    function AssignmentIndex(){
        $course=Course::all();
        return view('assignment.index',[
            'course'=>$course,
        ]);

    }
    function AssignmentPost(Request $request){
       $request->validate([
        'file'=>'required|mimes:pdf|max:10240'


       ],
    [
        'file.required'=>'You have to upload a file',
    ]);
        $id=CoursedBasedAssignment::insertGetId([
            'title'=>$request->name,
            'course_id'=>$request->course_id,
            'batch_id'=>$request->batch_id,
            'deadline'=>$request->deadline,
            'full_marks'=>$request->pass_marks,
            'created_at'=>Carbon::now(),
        ]);

        $extention=$request->file->getClientOriginalExtension();
        $file_name=$id.".".$extention;

        $request->file->move(public_path('assets/uploads/assignments/'.$file_name));

        CoursedBasedAssignment::where('id',$id)->update([

            'file_name'=>$file_name,
            'updated_at'=>Carbon::now(),
        ]);

        return back();
    }
    function DescriptiveMarkingIndex(){
        $submissions=IndependentDescriptiveAnswer::where('status',0)->get();
        return view('tests.descriptive_index',[
            'submissions'=>$submissions,
        ]);
    }
    function DescriptiveMarkingMarking($id){
        $script=IndependentDescriptiveAnswer::where('id',$id)->first();
        // dd($script);
        return view('tests.marking',[
            'script'=>$script,
        ]);
    }
    function DescriptiveMarkingMarkingPost(Request $request){
        $question=IndependentDescriptiveAnswer::where('id',$request->id)->first();

        if($request->mark > $question->rel_to_question->marks){
            return back()->with('error','Full marks for this question is '.$question->rel_to_question->marks);
        }else{
            $question->update([
                'mark'=>$request->mark,
                'status'=>1,
                'updated_at'=>now(),
            ]);
            return back()->with('success','Successfully Examined');
        }

    }

}
