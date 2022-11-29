<?php

namespace App\Http\Controllers;

use App\Models\IndependentTest;
use App\Models\IndependentTestQuestions;
use App\Models\Question;
use App\Models\QuestionModules;
use App\Models\subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;

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
            'passing_comments'=>$request->pass_comment,
            'failing_comments'=>$request->failing_comment,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
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


        // print_r($request->all());

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
}
