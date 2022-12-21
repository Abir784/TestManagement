<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseBasedQuizQuestion;
use App\Models\CourseBasedTest;
use App\Models\CourseBasedTestResult;
use App\Models\Question;
use App\Models\Student;
use App\Models\subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentCourseBasedTestController extends Controller
{
    function index(){

        $course=Course::all();
        return view('course_based_test.index',[
            'course'=>$course,
        ]);
    }
    function QuizPost(Request $request){
        CourseBasedTest::create([
            'name'=>$request->name,
            'course_id'=>$request->course_id,
            'batch_id'=>$request->batch_id,
            'time'=>$request->time,
            'introduction_text'=>$request->introduction_text,
            'passing_comments'=>$request->passing_comment,
            'failing_comments'=>$request->failing_comment,
            'pass_marks'=>$request->pass_marks,
            'start_date'=>$request->start_date,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
            'end_date'=>$request->end_date,
            'created_at'=>Carbon::now(),
        ]);
      return back()->with('success','Done');
    }
    function QuestionIndex($id){
        $subjects=subject::select('id','name')->get();
        return view('course_based_test.question_add',
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
                CourseBasedQuizQuestion::create([
                    'quiz_id'=>$request->quiz_id,
                    'question_id'=>$question->id,
                    'created_at'=>Carbon::now(),
                ]);

            }
            return back()->with('success','Data Added');
        }
    }

    function SpecificQuizQuestionPost(Request $request){

        // dd($request->all());
        $request->validate([
            'subject_id'=>'required',
            'module_id'=>'required',
        ],
    [
        'subject_id.required'=>'Subject must be selected',
        'module_id.required'=>'MOdule must be selected',
    ]);
    $questions= Question::select('id','title')->where('module_id',$request->module_id)->get();
    return view('course_based_test.question_specific_add',
        [
            'questions'=>$questions,
            'quiz_id'=>$request->quiz_id,
        ]);
    }
    function SpecificQuizQuestionAdd(Request $request){

        $questions=$request->question_id;
        $quiz_id=$request->quiz_id;

        foreach($questions as $question){
            CourseBasedQuizQuestion::create([
                'quiz_id'=>$quiz_id,
                'question_id'=>$question,
                'created_at'=>Carbon::now(),
            ]);
        }
        return redirect(route('quiz.course_based.question.index',$quiz_id))->with('success','Question Added Succesfully');
    }
    function QuestionShow($id){
        $questions=CourseBasedQuizQuestion::select('question_id','id')->where('quiz_id',$id)->get();

        return view('course_based_test.show_questions',[
            'questions'=>$questions,
        ]);

    }
    function ExamIndex($id){
        $questions=CourseBasedQuizQuestion::where('quiz_id',$id)->get();
        $quiz=CourseBasedTest::where('id',$id)->first();
        return view('course_based_test.exam_page',
      [
          'questions'=>$questions,
          'id'=>$id,
          'time'=>$quiz->time,
      ]);
    }
    function ExamTimeout($id){
        $student=Student::where('user_id',Auth::id())->first();
        CourseBasedTestResult::create([
            'student_id'=>$student->id,
            'quiz_id'=>$id,
            'total_marks'=>0,
            'created_at'=>Carbon::now(),

        ]);

        return redirect('/')->with('timeout',"Sorry, you couldn't Submit on time <br> thats why you have got 0 marks. ");
    }
}
