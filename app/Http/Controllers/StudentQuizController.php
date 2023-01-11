<?php

namespace App\Http\Controllers;

use App\Models\CourseBasedAssignmentSubmission;
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
use PDF;

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
                                if($option->id == $input['answer__'.$ques->id][$key]){
                                    $marks+=($ques->marks);
                                }
                            }
                        }
                    }

                }
                else{
                $options=QuestionOptions::where('question_id',$ques->id)->where('right_answer',1)->get();
                        if(array_key_exists('answer__'.$ques->id, $input)) {
                            if(count($input['answer__'.$ques->id])>count($options)){
                                $marks+=0;
                            }else{
                                foreach($options as $key=>$option){
                                    foreach($input['answer__'.$ques->id] as $answer){
                                        if($option->id == $answer){
                                            $marks+=($option->marks);

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

                if( $input['answer__'.$ques->id] != null){

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
        }
        if($request->quiz_type ==1){
            $student=Student::where('user_id',Auth::id())->first();
            IndependentTestResult::create([
                'student_id'=>$student->id,
                'quiz_id'=>$input['quiz_id'],
                'total_marks'=>$marks,
                'created_at'=>Carbon::now(),
            ]);


        }elseif($request->quiz_type ==2){
            $student=Student::where('user_id',Auth::id())->first();
            CourseBasedTestResult::create([
                'student_id'=>$student->id,
                'quiz_id'=>$input['quiz_id'],
                'total_marks'=>$marks,
                'created_at'=>Carbon::now(),
            ]);


        }else{
            $student=Student::where('user_id',Auth::id())->first();
            InvidualTestResult::create([
                'student_id'=>$student->id,
                'quiz_id'=>$input['quiz_id'],
                'total_marks'=>$marks,
                'created_at'=>Carbon::now(),
            ]);


        }
        $data=$marks;
        return redirect('/')->with('success',$data);
    }


    function AssignmentIndex(){
            $student=Student::where('user_id',Auth::id())->first();


            $assignments=CoursedBasedAssignment::where('course_id',$student->course_id)->where('batch_id',$student->batch_id)->where('deadline','>=',Carbon::now()->format('Y-m-d'))->get();
            return view('assignment.student_index',
        [
            'assignments'=>$assignments,
            'student'=>$student,
        ]);
    }

    function generateMarksheet(){

        $student=Student::where('user_id',Auth::user()->id)->first();
        $quizzes=IndependentTest::all();
        $quiz_results=IndependentTestResult::where('student_id',$student->id)->get();
        $written_answer=IndependentDescriptiveAnswer::where('student_id',$student->id)->get();


        $main_result=[];
        foreach($quiz_results as $result){
            $main_result[$result->quiz_id]=($result->total_marks);
            foreach($written_answer as $answer){
                if($result->quiz_id == $answer->quiz_id){
                    $main_result[$result->quiz_id]+=($answer->mark);
                }
            }
        }


        $quizzes_results=[];
        foreach($quizzes as $key=>$quiz){

            $questions=IndependentTestQuestions::where('quiz_id',$quiz->id)->get();

            $full_marks=0;
            foreach($questions as $question){
                $full_marks+=($question->rel_to_question->total_marks);

            }
            $marks=0;
            if(array_key_exists($quiz->id,$main_result)){
                $marks=$main_result[$quiz->id];

                if($marks >= (0.8*$full_marks)){
                    $gpa=4;
                    $grade="A+";
                }elseif (($marks>=0.75*$full_marks) && ($marks<(0.80*$full_marks))) {
                    $gpa=((($marks-($full_marks*0.75))/5)*0.24)+3.75;
                    $grade="A";
                }elseif(($marks>=0.70*$full_marks) && ($marks<(0.75*$full_marks))){
                    $gpa=((($marks-($full_marks*0.70))/5)*0.24)+3.50;
                    $grade="A-";
                }elseif(($marks>=0.65*$full_marks) && ($marks<(0.70*$full_marks))){
                    $gpa=((($marks-($full_marks*0.65))/5)*0.24)+3.25;
                    $grade="B+";
                }elseif(($marks>=0.60*$full_marks) && ($marks<(0.65*$full_marks))){
                    $gpa=((($marks-($full_marks*0.60))/5)*0.24)+3.00;
                    $grade="B";
                }elseif(($marks>=0.55*$full_marks) && ($marks<(0.60*$full_marks))){
                    $gpa=((($marks-($full_marks*0.55))/5)*0.24)+2.75;
                    $grade="B-";
                }elseif(($marks>=0.50*$full_marks) && ($marks<(0.55*$full_marks))){
                    $gpa=((($marks-($full_marks*0.50))/5)*0.24)+2.50;
                    $grade="C+";
                }elseif($marks<0.50*$full_marks){
                    $gpa=0;
                    $grade="F";
                }else{
                    $gpa=0;
                    $grade="Absent";
                }

                $quizzes_results[]=array(
                    'name'=>$quiz->name,
                    'gpa'=>$gpa,
                    'mark_obtained'=>$marks,
                    'full_marks'=>$full_marks,
                    'grade'=>$grade,
                );

            }

        }

       $data=[
        'student'=>$student,
            'quizzes_results'=>$quizzes_results,
       ];

        $pdf = PDF::loadView('marksheet_2', $data);

        return $pdf->download($student->name."_".$student->registration_no.'_'.now().'.pdf');


    }

}


