<?php

namespace App\Http\Controllers;

use App\Models\CourseBasedTest;
use App\Models\CourseBasedTestResult;
use App\Models\CoursedBasedAssignment;
use App\Models\CoursedBasedDescriptiveAnswer;
use App\Models\IndependentDescriptiveAnswer;
use App\Models\IndependentTest;
use App\Models\IndependentTestQuestions;
use App\Models\IndependentTestResult;
use App\Models\IndividualTest;
use App\Models\IndividualTestDescriptiveAnswer;
use App\Models\InvidualTestResult;
use App\Models\Question;
use App\Models\QuestionOptions;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Generator\StringManipulation\Pass\Pass;
use PHPUnit\Framework\Constraint\Count;

class StudentQuizController extends Controller
{
    function QuizIndex(){

         //for checking the student id
         $student=Student::where('user_id',Auth::id())->first();

          //Getting the current time
          $date=Carbon::now()->format('Y-m-d');
          $time=Carbon::now()->format('H:i:s');


          //Independent Tests
          $independent=IndependentTest::where('start_date','<=',$date)->where('end_date','>=',$date)->get();
          $independent_quiz=[];
          foreach($independent as $key=>$quiz){
             if(Carbon::parse($quiz->start_date)->isToday() && Carbon::parse($quiz->end_date)->isToday()){
                if($quiz->start_time <= $time && $quiz->end_time > $time){
                    $independent_quiz[]=$quiz;
                }
             }elseif(Carbon::parse($quiz->start_date)->isToday() && !Carbon::parse($quiz->end_date)->isToday() ){
                if($quiz->start_time <= $time){
                    $independent_quiz[]=$quiz;
                }
             }elseif( !Carbon::parse($quiz->start_date)->isToday() && Carbon::parse($quiz->end_date)->isToday()){
                if($quiz->end_time > $time){
                    $independent_quiz[]=$quiz;

                }
             }else{
                $independent_quiz[]=$quiz;
             }
          }




           //Course Based Tests

         $course_based=CourseBasedTest::where('course_id',$student->course_id)->where('batch_id',$student->batch_id)->where('start_date','<=',$date)->where('end_date','>=',$date)->get();
          $course_based_quiz=[];
          foreach($course_based as $key=>$quiz){
             if(Carbon::parse($quiz->start_date)->isToday() && Carbon::parse($quiz->end_date)->isToday()){
                if($quiz->start_time <= $time && $quiz->end_time > $time){
                    $course_based_quiz[]=$quiz;
                }
             }elseif(Carbon::parse($quiz->start_date)->isToday() && !Carbon::parse($quiz->end_date)->isToday() ){
                if($quiz->start_time <= $time){
                    $course_based_quiz[]=$quiz;
                }
             }elseif( !Carbon::parse($quiz->start_date)->isToday() && Carbon::parse($quiz->end_date)->isToday()){
                if($quiz->end_time > $time){
                    $course_based_quiz[]=$quiz;

                }
             }else{
                $course_based_quiz[]=$quiz;
             }
          }



              //Indivdiual Tests
          $invidual=IndividualTest::where('start_date','<=',$date)->where('end_date','>=',$date)->get();
          $invidual_test=[];
          foreach($invidual as $key=>$quiz){
             if(Carbon::parse($quiz->start_date)->isToday() && Carbon::parse($quiz->end_date)->isToday()){
                if($quiz->start_time <= $time && $quiz->end_time > $time){
                    $invidual_test[]=$quiz;
                }
             }elseif(Carbon::parse($quiz->start_date)->isToday() && !Carbon::parse($quiz->end_date)->isToday() ){
                if($quiz->start_time <= $time){
                    $invidual_test[]=$quiz;
                }
             }elseif( !Carbon::parse($quiz->start_date)->isToday() && Carbon::parse($quiz->end_date)->isToday()){
                if($quiz->end_time > $time){
                    $invidual_test[]=$quiz;

                }
             }else{
                $invidual_test[]=$quiz;
             }
          }

        return view('student_test.index',[
            'invidual_test'=>$invidual_test,
            'independent_quiz'=>$independent_quiz,
            'course_based_quiz'=>$course_based_quiz,
        ]);
    }
    function ExamIndex($id){
      $questions=IndependentTestQuestions::where('quiz_id',$id)->get();
      $quiz=IndependentTest::where('id',$id)->first();


      return view('student_test.exam_page',
    [
        'questions'=>$questions,
        'id'=>$id,
        'time'=>$quiz->time,
    ]);
    }
    function ExamPost(Request $request){
        $input=$request->all();
        $marks=0;
        foreach($request->question_id as $question){
            $ques=Question::where('id',$question)->first();
            if($ques->type == "MCQ"){

                $options=QuestionOptions::where('question_id',$ques->id)->where('right_answer',1)->get();

                if($ques->marks != 0){
                    if(array_key_exists('answer__'.$ques->id, $input)) {
                        if(count($input['answer__'.$ques->id])>count($options)){
                            $marks+=0;
                        }else{
                            foreach($options as $key=>$option){
                                if($option->id != $input['answer__'.$ques->id][$key]){
                                    $marks+=0;
                                }else{
                                    $marks+=$ques->marks;
                                }
                            }
                        }
                    }

                }else{
                         $options=QuestionOptions::where('question_id',$ques->id)->where('right_answer',1)->get();

                        if(array_key_exists('answare_'.$ques->id, $input)) {
                            if(count($input['answer__'.$ques->id])>count($options)){
                                $marks+=0;
                            }else{
                                foreach($options as $key=>$option){
                                    foreach($input['answer__'.$ques->id] as $answer){
                                        if($option->id == $answer){
                                            $marks+=$option->marks;

                                        }else{
                                            $marks+=0;
                                        }

                                    }
                                }
                            }
                        }
                }
            }elseif($ques->type == "MATCH"){
                    $options=QuestionOptions::where('question_id',$ques->id)->get();
                    if($ques->marks != 0){
                        $flag=True;
                        foreach($options as $key=>$option){
                            if($option->option_title != $input['answer__'.$ques->id][$key]){
                                $flag=False;
                                break;
                            }
                        }
                        if($flag==True){
                            $marks+=$ques->marks;
                        }

                    }else{
                        foreach($options as $key=>$option){
                            if($option->option_title == $input['answer__'.$ques->id][$key]){
                                $marks+=$option->marks;
                            }
                        }
                    }
            }elseif($ques->type == "FILL"){
                $options=QuestionOptions::where('question_id',$ques->id)->get();
                if($ques->marks != 0){
                    $flag=True;
                    foreach($options as $key=>$option){
                        if($option->option_title != $input['answer__'.$ques->id][$key]){
                            $flag=False;
                            break;
                        }
                    }
                    if($flag==True){
                        $marks+=$ques->marks;
                    }

                }else{
                    foreach($options as $key=>$option){
                        if($option->option_title == $input['answer__'.$ques->id][$key]){
                            $marks+=$option->marks;
                        }
                    }
                }


            }else{
                 if($request->quiz_type ==1){
                    $student=Student::where('user_id',Auth::id())->first();
                    IndependentDescriptiveAnswer::create([
                        'student_id'=>$student->id,
                        'quiz_id'=>$input['quiz_id'],
                        'question_id'=>$ques->id,
                        'answer'=>$input['answer__'.$ques->id],
                        'mark'=>0,
                        'created_at'=>Carbon::now(),
                    ]);

                 }elseif($request->quiz_type ==2){
                    $student=Student::where('user_id',Auth::id())->first();
                    CoursedBasedDescriptiveAnswer::create([
                        'student_id'=>$student->id,
                        'quiz_id'=>$input['quiz_id'],
                        'question_id'=>$ques->id,
                        'answer'=>$input['answer__'.$ques->id],
                        'mark'=>0,
                        'created_at'=>Carbon::now(),
                    ]);

                 }else{
                    $student=Student::where('user_id',Auth::id())->first();
                    IndividualTestDescriptiveAnswer::create([
                        'student_id'=>$student->id,
                        'quiz_id'=>$input['quiz_id'],
                        'question_id'=>$ques->id,
                        'answer'=>$input['answer__'.$ques->id],
                        'mark'=>0,
                        'created_at'=>Carbon::now(),
                    ]);

                 }
            }
        }
        if($request->quiz_type ==1){
            $student=Student::where('user_id',Auth::id())->first();
            IndependentTestResult::create([
                'student_id'=>$student->id,
                'quiz_id'=>$input['quiz_id'],
                'total_marks'=>$marks,
                'created_at'=>Carbon::now(),
            ]);

            $quiz=IndependentTest::where('id',$input['quiz_id'])->first();
            if($marks >= $quiz->pass_marks){
                $comment=$quiz->passing_comments;

            }else{

                $comment=$quiz->failing_comments;

            }
        }elseif($request->quiz_type ==2){
            $student=Student::where('user_id',Auth::id())->first();
            CourseBasedTestResult::create([
                'student_id'=>$student->id,
                'quiz_id'=>$input['quiz_id'],
                'total_marks'=>$marks,
                'created_at'=>Carbon::now(),
            ]);

            $quiz=CourseBasedTest::where('id',$input['quiz_id'])->first();
            if($marks >= $quiz->pass_marks){
                $comment=$quiz->passing_comments;

            }else{

                $comment=$quiz->failing_comments;

            }
        }else{
            $student=Student::where('user_id',Auth::id())->first();
            InvidualTestResult::create([
                'student_id'=>$student->id,
                'quiz_id'=>$input['quiz_id'],
                'total_marks'=>$marks,
                'created_at'=>Carbon::now(),
            ]);

            $quiz=IndividualTest::where('id',$input['quiz_id'])->first();
            if($marks >= $quiz->pass_marks){
                $comment=$quiz->passing_comments;

            }else{

                $comment=$quiz->failing_comments;

            }
        }
        $data=[$marks,$comment];
        return redirect('/')->with('success',$data);
    }
    function AssignmentIndex(){
            $student=Student::where('user_id',Auth::id())->first();

            $assignments=CoursedBasedAssignment::where('course_id',$student->course_id)->where('batch_id',$student->batch_id)->get();
            return view('assignment.student_index',
        [
            'assignments'=>$assignments,
        ]);
    }

}


