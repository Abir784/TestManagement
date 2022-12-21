<?php

namespace App\Http\Controllers;

use App\Models\IndividualTest;
use App\Models\IndividualTestDescriptiveAnswer;
use App\Models\IndividualTestQuestion;
use App\Models\IndividualTestStudents;
use App\Models\InvidualTestResult;
use App\Models\Student;
use App\Models\subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class IndividualTestController extends Controller
{
    function index(){
        return view('individual_test.index');
    }
    function QuizPost(Request $request){
        $request->validate([
            'name'=>'required',
            'introduction_text'=>'required',
            'passing_comment'=>'required',
            'failing_comment'=>'required',
            'time'=>'required',
            'start_date'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'end_date'=>'required',
            'pass_marks'=>'required',
        ]);
       IndividualTest::create([
        'name'=>$request->name,
        'time'=>$request->time,
        'introduction_text'=>$request->introduction_text,
        'passing_comments'=>$request->passing_comment,
        'failing_comments'=>$request->failing_comment,
        'start_date'=>$request->start_date,
        'start_time'=>$request->start_time,
        'end_date'=>$request->end_date,
        'end_time'=>$request->end_time,
        'pass_marks'=>$request->pass_marks,
        'created_at'=>Carbon::now(),
       ]);

       return back()->with('success',"Done");
    }
    function student_add_index($id){

        return view('individual_test.student_add',[
            'id'=>$id,
        ]);
    }
    function StudentPost(Request $request){
        $student=$request->student_id;
        if(Student::where('registration_no',$student)->exists() || Student::where('email',$student)->exists() ){
            if(is_numeric($student)){
                $student_info=Student::where('registration_no',$student)->first();
                $student_id=$student_info->id;

            }else{
                $student_info=Student::where('email',$student)->first();
                $student_id=$student_info->id;
            }
            IndividualTestStudents::create([
                'quiz_id'=>$request->quiz_id,
                'student_id'=>$student_id,
                'created_at'=>Carbon::now(),
            ]);
            return back();

        }else{
            return back()->with('error','Student data not found');
        }

    }
        function QuestionIndex($id){
            $subjects=subject::select('id','name')->get();
            return view('individual_test.question_add',
            [
                'subjects'=>$subjects,
                'id'=>$id,
            ]);
      }
    function QuestionPost(Request $request){
        $questions=Question::where('module_id',$request->module_id)->get();
        if(((int)($request->q_no )> count($questions)) || ((int) $request->q_no<0)){
            return back()->with('error','Question limit exceded');
        }else{
            $questions=Question::where('module_id',$request->module_id)->inRandomOrder()->take($request->q_no)->get();
            foreach($questions as $question){
                IndividualTestQuestion::create([
                    'quiz_id'=>$request->quiz_id,
                    'question_id'=>$question->id,
                    'created_at'=>Carbon::now(),
                ]);

            }
            return back()->with('success','Data Added');
        }
    }

        function SpecificQuizQuestionPost(Request $request){
            $request->validate([
                'subject_id'=>'required',
                'module_id'=>'required',
            ],
        [
            'subject_id.required'=>'Subject must be selected',
            'module_id.required'=>'MOdule must be selected',
        ]);
        $questions= Question::select('id','title')->where('module_id',$request->module_id)->get();
        return view('individual_test.question_specific_add',
            [
                'questions'=>$questions,
                'quiz_id'=>$request->quiz_id,
            ]);
        }
        function SpecificQuizQuestionAdd(Request $request){

            $questions=$request->question_id;
            $quiz_id=$request->quiz_id;

            foreach($questions as $question){
                IndividualTestQuestion::create([
                    'quiz_id'=>$quiz_id,
                    'question_id'=>$question,
                    'created_at'=>Carbon::now(),
                ]);
            }
            return redirect(route('individual.test.question.index',$quiz_id))->with('success','Question Added Succesfully');
        }
        function QuestionShow($id){
            $questions=IndividualTestQuestion::select('question_id','id')->where('quiz_id',$id)->get();

            return view('individual_test.show_questions',[
                'questions'=>$questions,
            ]);

        }

        function ExamIndex($id){
            $questions=IndividualTestQuestion::where('quiz_id',$id)->get();
            $quiz=IndividualTest::where('id',$id)->first();
            return view('individual_test.exam_page',
          [
              'questions'=>$questions,
              'id'=>$id,
              'time'=>$quiz->time,
          ]);
        }
        function DescriptiveMarkingIndex(){
            $submissions=IndividualTestDescriptiveAnswer::all();
            return view('individual_test.descriptive_index',[
                'submissions'=>$submissions,
            ]);
        }
}
