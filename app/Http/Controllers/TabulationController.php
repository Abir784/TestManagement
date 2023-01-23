<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseBasedAssignmentSubmission;
use App\Models\CourseBasedQuizQuestion;
use App\Models\CourseBasedTest;
use App\Models\CourseBasedTestResult;
use App\Models\CoursedBasedAssignment;
use App\Models\CoursedBasedDescriptiveAnswer;
use App\Models\Student;
use Illuminate\Http\Request;
use PDF;
use Svg\Tag\Rect;

use function PHPUnit\Framework\returnCallback;

class TabulationController extends Controller
{
    function course_wise_tabulation_marks_index(){

                $courses=Course::all();
                return view('tabulation.marks',
            [
                'courses'=>$courses,
            ]);
    }

    function course_wise_tabulation_marks_post(Request $request){


        $request->validate([
            'course_id'=>'required',
            'batch_id'=>'required',
        ],[
            'course_id.required'=>'you have to choose a course',
            'batch_id.required'=>'you have to choose a batch',
        ]);





        $students=Student::where('course_id',$request->course_id)->where('batch_id',$request->batch_id)->get();

        $quizzes=CourseBasedTest::where('course_id',$request->course_id)->where('batch_id',$request->batch_id)->get();
        $assignments=CoursedBasedAssignment::where('course_id',$request->course_id)->where('batch_id',$request->batch_id)->get();




        $students_result=[];
        foreach ($students as $student){

            $assignments_result=CourseBasedAssignmentSubmission::where('student_id',$student->id)->get();
            $quiz_results=CourseBasedTestResult::where('student_id',$student->id)->get();
            $written_answer=CoursedBasedDescriptiveAnswer::where('student_id',$student->id)->get();
            $main_result=[];
            foreach($quiz_results as $result){
                $main_result[$result->quiz_id]=($result->total_marks);
                foreach($written_answer as $answer){
                    if($result->quiz_id == $answer->quiz_id){
                        $main_result[$result->quiz_id]+=($answer->mark);
                    }else{
                        $main_result[$result->quiz_id]+=0;

                    }
                }
            }



            if($main_result != null){
                $quizzes_results=[];
                foreach($quizzes as $key=>$quiz){

                    $questions=CourseBasedQuizQuestion::where('quiz_id',$quiz->id)->get();

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
                            'quiz_id'=>$quiz->id,
                            'gpa'=>$gpa,
                            'mark_obtained'=>$marks,
                        );

                    }else{
                        $quizzes_results[]=array(
                            'quiz_id'=>$quiz->id,
                            'gpa'=>0,
                            'mark_obtained'=>0,
                        );

                    }

                }

                $assignment_marks=0;
                $assignment_results=[];
                foreach($assignments as $assignment){
                    foreach($assignments_result as $result){
                        if($assignment->id == $result->assignment_id){
                            $assignment_marks=$result->mark;
                        }
                    }


                    $full_assignment_marks=$assignment->full_marks;




                    if($assignment_marks >= (0.8*$full_assignment_marks)){
                        $gpa=4;
                        $grade="A+";
                    }elseif (($assignment_marks>=0.75*$full_assignment_marks) && ($assignment_marks<(0.80*$full_assignment_marks))) {
                        $gpa=((($assignment_marks-($full_assignment_marks*0.75))/5)*0.24)+3.75;
                        $grade="A";
                    }elseif(($assignment_marks>=0.70*$full_assignment_marks) && ($assignment_marks<(0.75*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.70))/5)*0.24)+3.50;
                        $grade="A-";
                    }elseif(($assignment_marks>=0.65*$full_assignment_marks) && ($assignment_marks<(0.70*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.65))/5)*0.24)+3.25;
                        $grade="B+";
                    }elseif(($assignment_marks>=0.60*$full_assignment_marks) && ($assignment_marks<(0.65*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.60))/5)*0.24)+3.00;
                        $grade="B";
                    }elseif(($assignment_marks>=0.55*$full_assignment_marks) && ($assignment_marks<(0.60*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.55))/5)*0.24)+2.75;
                        $grade="B-";
                    }elseif(($assignment_marks>=0.50*$full_assignment_marks) && ($assignment_marks<(0.55*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.50))/5)*0.24)+2.50;
                        $grade="C+";
                    }elseif($assignment_marks<0.50*$full_assignment_marks){
                        $gpa=0;
                        $grade="F";
                    }else{
                        $gpa=0;
                        $grade="Absent";
                    }

                    $assignment_results[]=array(
                        'assignmnet_id'=>$assignment->id,
                        'marks_obtained'=>$assignment_marks,
                        'gpa'=>$gpa,
                        'grade'=>$grade,
                    );
                }


                $students_result[]=[
                    'student_name'=>$student->name,
                    'id'=>$student->registration_no,
                    'quiz_marks'=>$quizzes_results,
                    'assignment_marks'=>$assignment_results,


                ];
            }

        }



        return view('tabulation.course_based_tabulation_sheet_marks',
        [
            'course_name'=>$request->course_id,
            'batch_name'=>$request->batch_id,
            'students_result'=>$students_result,
            'quizzes'=>$quizzes,
            'assignments'=>$assignments,
        ]);








    }
    function course_wise_tabulation_marks_pdf($course_id,$batch_id){


        $students=Student::where('course_id',$course_id)->where('batch_id',$batch_id)->get();

        $quizzes=CourseBasedTest::where('course_id',$course_id)->where('batch_id',$batch_id)->get();
        $assignments=CoursedBasedAssignment::where('course_id',$course_id)->where('batch_id',$batch_id)->get();




        $students_result=[];
        foreach ($students as $student){

            $assignments_result=CourseBasedAssignmentSubmission::where('student_id',$student->id)->get();
            $quiz_results=CourseBasedTestResult::where('student_id',$student->id)->get();
            $written_answer=CoursedBasedDescriptiveAnswer::where('student_id',$student->id)->get();
            $main_result=[];
            foreach($quiz_results as $result){
                $main_result[$result->quiz_id]=($result->total_marks);
                foreach($written_answer as $answer){
                    if($result->quiz_id == $answer->quiz_id){
                        $main_result[$result->quiz_id]+=($answer->mark);
                    }else{
                        $main_result[$result->quiz_id]+=0;

                    }
                }
            }



            if($main_result != null){
                $quizzes_results=[];
                foreach($quizzes as $key=>$quiz){

                    $questions=CourseBasedQuizQuestion::where('quiz_id',$quiz->id)->get();

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
                            'quiz_id'=>$quiz->id,
                            'gpa'=>$gpa,
                            'mark_obtained'=>$marks,
                        );

                    }else{
                        $quizzes_results[]=array(
                            'quiz_id'=>$quiz->id,
                            'gpa'=>0,
                            'mark_obtained'=>0,
                        );

                    }

                }

                $assignment_marks=0;
                $assignment_results=[];
                foreach($assignments as $assignment){
                    foreach($assignments_result as $result){
                        if($assignment->id == $result->assignment_id){
                            $assignment_marks=$result->mark;
                        }
                    }


                    $full_assignment_marks=$assignment->full_marks;




                    if($assignment_marks >= (0.8*$full_assignment_marks)){
                        $gpa=4;
                        $grade="A+";
                    }elseif (($assignment_marks>=0.75*$full_assignment_marks) && ($assignment_marks<(0.80*$full_assignment_marks))) {
                        $gpa=((($assignment_marks-($full_assignment_marks*0.75))/5)*0.24)+3.75;
                        $grade="A";
                    }elseif(($assignment_marks>=0.70*$full_assignment_marks) && ($assignment_marks<(0.75*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.70))/5)*0.24)+3.50;
                        $grade="A-";
                    }elseif(($assignment_marks>=0.65*$full_assignment_marks) && ($assignment_marks<(0.70*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.65))/5)*0.24)+3.25;
                        $grade="B+";
                    }elseif(($assignment_marks>=0.60*$full_assignment_marks) && ($assignment_marks<(0.65*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.60))/5)*0.24)+3.00;
                        $grade="B";
                    }elseif(($assignment_marks>=0.55*$full_assignment_marks) && ($assignment_marks<(0.60*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.55))/5)*0.24)+2.75;
                        $grade="B-";
                    }elseif(($assignment_marks>=0.50*$full_assignment_marks) && ($assignment_marks<(0.55*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.50))/5)*0.24)+2.50;
                        $grade="C+";
                    }elseif($assignment_marks<0.50*$full_assignment_marks){
                        $gpa=0;
                        $grade="F";
                    }else{
                        $gpa=0;
                        $grade="Absent";
                    }

                    $assignment_results[]=array(
                        'assignmnet_id'=>$assignment->id,
                        'marks_obtained'=>$assignment_marks,
                        'gpa'=>$gpa,
                        'grade'=>$grade,
                    );
                }


                $students_result[]=[
                    'student_name'=>$student->name,
                    'id'=>$student->registration_no,
                    'quiz_marks'=>$quizzes_results,
                    'assignment_marks'=>$assignment_results,


                ];
            }

        }
        $data=[
            'course_name'=>$course_id,
            'batch_name'=>$batch_id,
            'students_result'=>$students_result,
            'quizzes'=>$quizzes,
            'assignments'=>$assignments,
        ];



        $pdf = PDF::loadView('tabulation.tabulation_marksheets.course_based_tabulation_sheet_marks', $data);

        return $pdf->download("Tabulation".now().'.pdf');


    }
    function course_wise_tabulation_grades_index(){
        $courses=Course::all();
        return view('tabulation.grades',
    [
        'courses'=>$courses,
    ]);


    }
    function course_wise_tabulation_grades_post(Request $request){
        $request->validate([
            'course_id'=>'required',
            'batch_id'=>'required',
        ],[
            'course_id.required'=>'you have to choose a course',
            'batch_id.required'=>'you have to choose a batch',
        ]);





        $students=Student::where('course_id',$request->course_id)->where('batch_id',$request->batch_id)->get();

        $quizzes=CourseBasedTest::where('course_id',$request->course_id)->where('batch_id',$request->batch_id)->get();
        $assignments=CoursedBasedAssignment::where('course_id',$request->course_id)->where('batch_id',$request->batch_id)->get();




        $students_result=[];
        foreach ($students as $student){

            $assignments_result=CourseBasedAssignmentSubmission::where('student_id',$student->id)->get();
            $quiz_results=CourseBasedTestResult::where('student_id',$student->id)->get();
            $written_answer=CoursedBasedDescriptiveAnswer::where('student_id',$student->id)->get();
            $main_result=[];
            foreach($quiz_results as $result){
                $main_result[$result->quiz_id]=($result->total_marks);
                foreach($written_answer as $answer){
                    if($result->quiz_id == $answer->quiz_id){
                        $main_result[$result->quiz_id]+=($answer->mark);
                    }else{
                        $main_result[$result->quiz_id]+=0;

                    }
                }
            }



            if($main_result != null){
                $quizzes_results=[];
                foreach($quizzes as $key=>$quiz){

                    $questions=CourseBasedQuizQuestion::where('quiz_id',$quiz->id)->get();

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
                            'quiz_id'=>$quiz->id,
                            'gpa'=>$gpa,
                            'mark_obtained'=>$marks,
                        );

                    }else{
                        $quizzes_results[]=array(
                            'quiz_id'=>$quiz->id,
                            'gpa'=>0,
                            'mark_obtained'=>0,
                        );

                    }

                }

                $assignment_marks=0;
                $assignment_results=[];
                foreach($assignments as $assignment){
                    foreach($assignments_result as $result){
                        if($assignment->id == $result->assignment_id){
                            $assignment_marks=$result->mark;
                        }
                    }


                    $full_assignment_marks=$assignment->full_marks;




                    if($assignment_marks >= (0.8*$full_assignment_marks)){
                        $gpa=4;
                        $grade="A+";
                    }elseif (($assignment_marks>=0.75*$full_assignment_marks) && ($assignment_marks<(0.80*$full_assignment_marks))) {
                        $gpa=((($assignment_marks-($full_assignment_marks*0.75))/5)*0.24)+3.75;
                        $grade="A";
                    }elseif(($assignment_marks>=0.70*$full_assignment_marks) && ($assignment_marks<(0.75*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.70))/5)*0.24)+3.50;
                        $grade="A-";
                    }elseif(($assignment_marks>=0.65*$full_assignment_marks) && ($assignment_marks<(0.70*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.65))/5)*0.24)+3.25;
                        $grade="B+";
                    }elseif(($assignment_marks>=0.60*$full_assignment_marks) && ($assignment_marks<(0.65*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.60))/5)*0.24)+3.00;
                        $grade="B";
                    }elseif(($assignment_marks>=0.55*$full_assignment_marks) && ($assignment_marks<(0.60*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.55))/5)*0.24)+2.75;
                        $grade="B-";
                    }elseif(($assignment_marks>=0.50*$full_assignment_marks) && ($assignment_marks<(0.55*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.50))/5)*0.24)+2.50;
                        $grade="C+";
                    }elseif($assignment_marks<0.50*$full_assignment_marks){
                        $gpa=0;
                        $grade="F";
                    }else{
                        $gpa=0;
                        $grade="Absent";
                    }

                    $assignment_results[]=array(
                        'assignmnet_id'=>$assignment->id,
                        'marks_obtained'=>$assignment_marks,
                        'gpa'=>$gpa,
                        'grade'=>$grade,
                    );
                }


                $students_result[]=[
                    'student_name'=>$student->name,
                    'id'=>$student->registration_no,
                    'quiz_marks'=>$quizzes_results,
                    'assignment_marks'=>$assignment_results,


                ];
            }

        }



        return view('tabulation.course_based_tabulation_sheet_grade',
        [
            'course_name'=>$request->course_id,
            'batch_name'=>$request->batch_id,
            'students_result'=>$students_result,
            'quizzes'=>$quizzes,
            'assignments'=>$assignments,
        ]);




    }
    function course_wise_tabulation_grades_pdf($course_id,$batch_id){


        $students=Student::where('course_id',$course_id)->where('batch_id',$batch_id)->get();

        $quizzes=CourseBasedTest::where('course_id',$course_id)->where('batch_id',$batch_id)->get();
        $assignments=CoursedBasedAssignment::where('course_id',$course_id)->where('batch_id',$batch_id)->get();




        $students_result=[];
        foreach ($students as $student){

            $assignments_result=CourseBasedAssignmentSubmission::where('student_id',$student->id)->get();
            $quiz_results=CourseBasedTestResult::where('student_id',$student->id)->get();
            $written_answer=CoursedBasedDescriptiveAnswer::where('student_id',$student->id)->get();
            $main_result=[];
            foreach($quiz_results as $result){
                $main_result[$result->quiz_id]=($result->total_marks);
                foreach($written_answer as $answer){
                    if($result->quiz_id == $answer->quiz_id){
                        $main_result[$result->quiz_id]+=($answer->mark);
                    }else{
                        $main_result[$result->quiz_id]+=0;

                    }
                }
            }



            if($main_result != null){
                $quizzes_results=[];
                foreach($quizzes as $key=>$quiz){

                    $questions=CourseBasedQuizQuestion::where('quiz_id',$quiz->id)->get();

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
                            'quiz_id'=>$quiz->id,
                            'gpa'=>$gpa,
                            'mark_obtained'=>$marks,
                        );

                    }else{
                        $quizzes_results[]=array(
                            'quiz_id'=>$quiz->id,
                            'gpa'=>0,
                            'mark_obtained'=>0,
                        );

                    }

                }

                $assignment_marks=0;
                $assignment_results=[];
                foreach($assignments as $assignment){
                    foreach($assignments_result as $result){
                        if($assignment->id == $result->assignment_id){
                            $assignment_marks=$result->mark;
                        }
                    }


                    $full_assignment_marks=$assignment->full_marks;




                    if($assignment_marks >= (0.8*$full_assignment_marks)){
                        $gpa=4;
                        $grade="A+";
                    }elseif (($assignment_marks>=0.75*$full_assignment_marks) && ($assignment_marks<(0.80*$full_assignment_marks))) {
                        $gpa=((($assignment_marks-($full_assignment_marks*0.75))/5)*0.24)+3.75;
                        $grade="A";
                    }elseif(($assignment_marks>=0.70*$full_assignment_marks) && ($assignment_marks<(0.75*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.70))/5)*0.24)+3.50;
                        $grade="A-";
                    }elseif(($assignment_marks>=0.65*$full_assignment_marks) && ($assignment_marks<(0.70*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.65))/5)*0.24)+3.25;
                        $grade="B+";
                    }elseif(($assignment_marks>=0.60*$full_assignment_marks) && ($assignment_marks<(0.65*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.60))/5)*0.24)+3.00;
                        $grade="B";
                    }elseif(($assignment_marks>=0.55*$full_assignment_marks) && ($assignment_marks<(0.60*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.55))/5)*0.24)+2.75;
                        $grade="B-";
                    }elseif(($assignment_marks>=0.50*$full_assignment_marks) && ($assignment_marks<(0.55*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.50))/5)*0.24)+2.50;
                        $grade="C+";
                    }elseif($assignment_marks<0.50*$full_assignment_marks){
                        $gpa=0;
                        $grade="F";
                    }else{
                        $gpa=0;
                        $grade="Absent";
                    }

                    $assignment_results[]=array(
                        'assignmnet_id'=>$assignment->id,
                        'marks_obtained'=>$assignment_marks,
                        'gpa'=>$gpa,
                        'grade'=>$grade,
                    );
                }


                $students_result[]=[
                    'student_name'=>$student->name,
                    'id'=>$student->registration_no,
                    'quiz_marks'=>$quizzes_results,
                    'assignment_marks'=>$assignment_results,


                ];
            }

        }
        $data=[
            'course_name'=>$course_id,
            'batch_name'=>$batch_id,
            'students_result'=>$students_result,
            'quizzes'=>$quizzes,
            'assignments'=>$assignments,
        ];



        $pdf = PDF::loadView('tabulation.tabulation_marksheets.course_based_tabulation_sheet_grade', $data);

        return $pdf->download("Tabulation".now().'.pdf');
    }
    function course_wise_result_sheet_index(){
        $courses=Course::all();
        return view('tabulation.result_sheet',[
            'courses'=>$courses,
        ]);
    }
    function course_wise_result_sheet_post(Request $request){
        $request->validate([
            'course_id'=>'required',
            'batch_id'=>'required',
        ],[
            'course_id.required'=>'you have to choose a course',
            'batch_id.required'=>'you have to choose a batch',
        ]);





        $students=Student::where('course_id',$request->course_id)->where('batch_id',$request->batch_id)->get();

        $quizzes=CourseBasedTest::where('course_id',$request->course_id)->where('batch_id',$request->batch_id)->get();
        $assignments=CoursedBasedAssignment::where('course_id',$request->course_id)->where('batch_id',$request->batch_id)->get();




        $students_result=[];
        foreach ($students as $student){

            $assignments_result=CourseBasedAssignmentSubmission::where('student_id',$student->id)->get();
            $quiz_results=CourseBasedTestResult::where('student_id',$student->id)->get();
            $written_answer=CoursedBasedDescriptiveAnswer::where('student_id',$student->id)->get();
            $main_result=[];
            foreach($quiz_results as $result){
                $main_result[$result->quiz_id]=($result->total_marks);
                foreach($written_answer as $answer){
                    if($result->quiz_id == $answer->quiz_id){
                        $main_result[$result->quiz_id]+=($answer->mark);
                    }else{
                        $main_result[$result->quiz_id]+=0;

                    }
                }
            }



            if($main_result != null){
                $quizzes_results=[];
                $cgpa=0;
                $i=0;
                foreach($quizzes as $key=>$quiz){

                    $questions=CourseBasedQuizQuestion::where('quiz_id',$quiz->id)->get();

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

                       $cgpa+=$gpa;

                    }else{
                        $cgpa+=0;

                    }
                    $i+=1;

                }

                $assignment_marks=0;
                $assignment_results=[];
                foreach($assignments as $assignment){
                    foreach($assignments_result as $result){
                        if($assignment->id == $result->assignment_id){
                            $assignment_marks=$result->mark;
                        }
                    }


                    $full_assignment_marks=$assignment->full_marks;




                    if($assignment_marks >= (0.8*$full_assignment_marks)){
                        $gpa=4;
                        $grade="A+";
                    }elseif (($assignment_marks>=0.75*$full_assignment_marks) && ($assignment_marks<(0.80*$full_assignment_marks))) {
                        $gpa=((($assignment_marks-($full_assignment_marks*0.75))/5)*0.24)+3.75;
                        $grade="A";
                    }elseif(($assignment_marks>=0.70*$full_assignment_marks) && ($assignment_marks<(0.75*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.70))/5)*0.24)+3.50;
                        $grade="A-";
                    }elseif(($assignment_marks>=0.65*$full_assignment_marks) && ($assignment_marks<(0.70*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.65))/5)*0.24)+3.25;
                        $grade="B+";
                    }elseif(($assignment_marks>=0.60*$full_assignment_marks) && ($assignment_marks<(0.65*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.60))/5)*0.24)+3.00;
                        $grade="B";
                    }elseif(($assignment_marks>=0.55*$full_assignment_marks) && ($assignment_marks<(0.60*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.55))/5)*0.24)+2.75;
                        $grade="B-";
                    }elseif(($assignment_marks>=0.50*$full_assignment_marks) && ($assignment_marks<(0.55*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.50))/5)*0.24)+2.50;
                        $grade="C+";
                    }elseif($assignment_marks<0.50*$full_assignment_marks){
                        $gpa=0;
                        $grade="F";
                    }else{
                        $gpa=0;
                        $grade="Absent";
                    }

                   $cgpa+=$gpa;
                   $i+=1;
                }


                $students_result[]=[
                    'student_name'=>$student->name,
                    'id'=>$student->registration_no,
                    'cgpa'=>$cgpa/$i,
                ];
            }

        }



        return view('tabulation.course_based_result_sheet',
        [
            'course_name'=>$request->course_id,
            'batch_name'=>$request->batch_id,
            'students_result'=>$students_result,

        ]);
    }
    function course_wise_result_sheet_pdf($course_id,$batch_id){
        $students=Student::where('course_id',$course_id)->where('batch_id',$batch_id)->get();

        $quizzes=CourseBasedTest::where('course_id',$course_id)->where('batch_id',$batch_id)->get();
        $assignments=CoursedBasedAssignment::where('course_id',$course_id)->where('batch_id',$batch_id)->get();




        $students_result=[];
        foreach ($students as $student){

            $assignments_result=CourseBasedAssignmentSubmission::where('student_id',$student->id)->get();
            $quiz_results=CourseBasedTestResult::where('student_id',$student->id)->get();
            $written_answer=CoursedBasedDescriptiveAnswer::where('student_id',$student->id)->get();
            $main_result=[];
            foreach($quiz_results as $result){
                $main_result[$result->quiz_id]=($result->total_marks);
                foreach($written_answer as $answer){
                    if($result->quiz_id == $answer->quiz_id){
                        $main_result[$result->quiz_id]+=($answer->mark);
                    }else{
                        $main_result[$result->quiz_id]+=0;

                    }
                }
            }



            if($main_result != null){
                $quizzes_results=[];
                $cgpa=0;
                $i=0;
                foreach($quizzes as $key=>$quiz){

                    $questions=CourseBasedQuizQuestion::where('quiz_id',$quiz->id)->get();

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

                       $cgpa+=$gpa;

                    }else{
                        $cgpa+=0;

                    }
                    $i+=1;

                }

                $assignment_marks=0;
                $assignment_results=[];
                foreach($assignments as $assignment){
                    foreach($assignments_result as $result){
                        if($assignment->id == $result->assignment_id){
                            $assignment_marks=$result->mark;
                        }
                    }


                    $full_assignment_marks=$assignment->full_marks;




                    if($assignment_marks >= (0.8*$full_assignment_marks)){
                        $gpa=4;
                        $grade="A+";
                    }elseif (($assignment_marks>=0.75*$full_assignment_marks) && ($assignment_marks<(0.80*$full_assignment_marks))) {
                        $gpa=((($assignment_marks-($full_assignment_marks*0.75))/5)*0.24)+3.75;
                        $grade="A";
                    }elseif(($assignment_marks>=0.70*$full_assignment_marks) && ($assignment_marks<(0.75*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.70))/5)*0.24)+3.50;
                        $grade="A-";
                    }elseif(($assignment_marks>=0.65*$full_assignment_marks) && ($assignment_marks<(0.70*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.65))/5)*0.24)+3.25;
                        $grade="B+";
                    }elseif(($assignment_marks>=0.60*$full_assignment_marks) && ($assignment_marks<(0.65*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.60))/5)*0.24)+3.00;
                        $grade="B";
                    }elseif(($assignment_marks>=0.55*$full_assignment_marks) && ($assignment_marks<(0.60*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.55))/5)*0.24)+2.75;
                        $grade="B-";
                    }elseif(($assignment_marks>=0.50*$full_assignment_marks) && ($assignment_marks<(0.55*$full_assignment_marks))){
                        $gpa=((($assignment_marks-($full_assignment_marks*0.50))/5)*0.24)+2.50;
                        $grade="C+";
                    }elseif($assignment_marks<0.50*$full_assignment_marks){
                        $gpa=0;
                        $grade="F";
                    }else{
                        $gpa=0;
                        $grade="Absent";
                    }

                   $cgpa+=$gpa;
                   $i+=1;
                }


                $students_result[]=[
                    'student_name'=>$student->name,
                    'id'=>$student->registration_no,
                    'cgpa'=>$cgpa/$i,
                ];
            }

            $data=[
                'course_name'=>$course_id,
                'batch_name'=>$batch_id,
                'students_result'=>$students_result,
            ];

        }

        $pdf = PDF::loadView('tabulation.tabulation_marksheets.course_based_result_sheet', $data);

        return $pdf->download("Tabulation"."-".now().'.pdf');


    }
    function course_wise_exam_attendace_sheet_index(){
        $courses=Course::all();
        return view('tabulation.attandence_sheets.attendance_index',[
            'courses'=>$courses,
        ]);

    }
    function course_wise_exam_attendace_sheet_post(Request $request){
        $request->validate([

            'course_id'=>'required',
            'batch_id'=>'required',
            'quiz_id'=>'required',
        ]);


        $students=Student::where('course_id',$request->course_id)->where('batch_id',$request->batch_id)->get();
        $attendances=[];
        foreach($students as $student){
            if(CourseBasedTestResult::where('student_id',$student->id)->where('quiz_id',$request->quiz_id)->exists()){
                $attendances[]=[
                    'name'=>$student->name,
                    'id'=>$student->registration_no,
                    'status'=>"Present",
                ];
            }else{
                $attendances[]=[
                    'name'=>$student->name,
                    'id'=>$student->registration_no,
                    'status'=>"Absent",
                ];
            }
        }

        return view('tabulation.attandence_sheets.course_wise_exam_attendance_sheet',[
            'attendances'=>$attendances,
            'course_id'=>$request->course_id,
            'batch_id'=>$request->batch_id,
            'quiz_id'=>$request->quiz_id,
        ]);


    }
    function course_wise_exam_attendace_sheet_pdf($course_id,$batch_id,$quiz_id){


        $students=Student::where('course_id',$course_id)->where('batch_id',$batch_id)->get();
        $attendances=[];
        foreach($students as $student){
            if(CourseBasedTestResult::where('student_id',$student->id)->where('quiz_id',$quiz_id)->exists()){
                $attendances[]=[
                    'name'=>$student->name,
                    'id'=>$student->registration_no,
                    'status'=>"Present",
                ];
            }else{
                $attendances[]=[
                    'name'=>$student->name,
                    'id'=>$student->registration_no,
                    'status'=>"Absent",
                ];
            }
        }

        $data=[

            'attendances'=>$attendances,
            'course_id'=>$course_id,
            'batch_id'=>$batch_id,
            'quiz_id'=>$quiz_id,
        ];
        $pdf = PDF::loadView('tabulation.attendance_sheet_pdf.course_wise_attandance_sheet', $data);

        return $pdf->download("Tabulation"."-".now().'.pdf');


    }
    function individual_attendance_sheet_index(){
        return view('tabulation.attandence_sheets.individual_attendance_index');
    }
    function individual_attendance_sheet_post(Request $request){
        $request->validate([
            'student_id'=>'required',
        ]);
        $student=Student::where('registration_no',$request->student_id)->first();
        if($student != null){
            $quizzes=CourseBasedTest::where('course_id',$student->course_id)->where('batch_id',$student->batch_id)->get();

            $attendances=[
                's_id'=>$student->id,
                'name'=>$student->name,
                'id'=>$student->registration_no,
                'course_name'=>$student->course_name->name,
                'batch_name'=>$student->batch_name->batch_name,
                'tests'=>array(),
            ];
            foreach($quizzes as $quiz){
                if(CourseBasedTestResult::where('student_id',$student->id)->where('quiz_id',$quiz->id)->exists()){
                    $attendances['tests'][]=[
                        'quiz_name'=> $quiz->name,
                        'start_date'=> $quiz->start_date,
                        'status'=> 'Present',
                    ];

                }else{
                    $attendances['tests'][]=[
                        'quiz_name'=> $quiz->name,
                        'start_date'=> $quiz->start_date,
                        'status'=> "Absent",
                    ];

                }

            }


           return view('tabulation.attandence_sheets.individual_attandance_sheet',[
                  'attendances'=>$attendances,
           ]);


        }else{
            return back()->with('error',"No Data Found");
        }

    }
    function individual_attendance_sheet_pdf($id){

        $student=Student::where('id',$id)->first();
        $quizzes=CourseBasedTest::where('course_id',$student->course_id)->where('batch_id',$student->batch_id)->get();

        $attendances=[

            'name'=>$student->name,
            'id'=>$student->registration_no,
            'course_name'=>$student->course_name->name,
            'batch_name'=>$student->batch_name->batch_name,
            'tests'=>array(),
        ];
        foreach($quizzes as $quiz){
            if(CourseBasedTestResult::where('student_id',$student->id)->where('quiz_id',$quiz->id)->exists()){
                $attendances['tests'][]=[
                    'quiz_name'=> $quiz->name,
                    'start_date'=> $quiz->start_date,
                    'status'=> 'Present',
                ];

            }else{
                $attendances['tests'][]=[
                    'quiz_name'=> $quiz->name,
                    'start_date'=> $quiz->start_date,
                    'status'=> "Absent",
                ];

            }

        }
        $data=[
            'attendances'=>$attendances
        ];
        $pdf = PDF::loadView('tabulation.attendance_sheet_pdf.individual_attandance_sheet', $data);

        return $pdf->download("Tabulation"."-".now().'.pdf');

    }

    function course_wise_attendance_sheet_index(){
        $courses=Course::all();
        return view('tabulation.attandence_sheets.course_wise_attandance_index',[
            'courses'=>$courses,
        ]);
    }
    function course_wise_attendance_sheet_post(Request $request){
        $request->validate([

            'course_id'=>'required',
            'batch_id'=>'required',

        ]);

        $course_id=$request->course_id;
        $batch_id=$request->batch_id;
        $students=Student::where('course_id',$course_id)->where('batch_id',$batch_id)->get();
        $quizzes=CourseBasedTest::where('course_id',$course_id)->where('batch_id',$batch_id)->get();


        return view('tabulation.attandence_sheets.course_wise_attandance_sheet',[
            'course_id'=>$course_id,
            'batch_id'=>$batch_id,
            'students'=>$students,
            'quizzes'=>$quizzes,
        ]);


    }
    function course_wise_attendance_sheet_pdf($course_id,$batch_id){
        $students=Student::where('course_id',$course_id)->where('batch_id',$batch_id)->get();
        $quizzes=CourseBasedTest::where('course_id',$course_id)->where('batch_id',$batch_id)->get();

        $data=[

            'course_id'=>$course_id,
            'batch_id'=>$batch_id,
            'students'=>$students,
            'quizzes'=>$quizzes,
        ];
        $pdf = PDF::loadView('tabulation.attendance_sheet_pdf.course_wise_attandance_sheet2', $data);

        return $pdf->download("Tabulation"."-".now().'.pdf');


    }
    function course_wise_absent_sheet_index(){
        $courses=Course::all();
        return view('tabulation.attandence_sheets.course_wise_absent_list_index',[
            'courses'=>$courses,
        ]);
    }
    function course_wise_absent_sheet_post(Request $request){
        $request->validate([
            'course_id'=>'required',
            'batch_id'=>'required',

        ]);
        $course_id=$request->course_id;
        $batch_id=$request->batch_id;
        $students=Student::where('course_id',$course_id)->where('batch_id',$batch_id)->get();
        $quizzes=CourseBasedTest::where('course_id',$course_id)->where('batch_id',$batch_id)->get();

        $absent_list=[];
        foreach($students as $student){
            foreach($quizzes as $quiz){
                if(CourseBasedTestResult::where('quiz_id',$quiz->id)->where('student_id',$student->id)->doesntExist()){
                    $absent_list[]=[
                        'student_name'=>$student->name,
                        'id'=>$student->registration_no,
                        'email'=>$student->email,
                        'phone'=>$student->phone_no,
                        'quiz_name'=>$quiz->name,

                    ];

                }
            }
        }

        return view('tabulation.attandence_sheets.course_wise_absent_list',[
            'course_id'=>$course_id,
            'batch_id'=>$batch_id,
            'absent_list'=>$absent_list,
        ]);




    }
    function course_wise_absent_sheet_pdf($course_id,$batch_id){
        $students=Student::where('course_id',$course_id)->where('batch_id',$batch_id)->get();
        $quizzes=CourseBasedTest::where('course_id',$course_id)->where('batch_id',$batch_id)->get();

        $absent_list=[];
        foreach($students as $student){
            foreach($quizzes as $quiz){
                if(CourseBasedTestResult::where('quiz_id',$quiz->id)->where('student_id',$student->id)->doesntExist()){
                    $absent_list[]=[
                        'student_name'=>$student->name,
                        'id'=>$student->registration_no,
                        'email'=>$student->email,
                        'phone'=>$student->phone_no,
                        'quiz_name'=>$quiz->name,

                    ];

                }
            }
        }

        $data=[
            'course_id'=>$course_id,
            'batch_id'=>$batch_id,
            'absent_list'=>$absent_list,
        ];

        $pdf = PDF::loadView('tabulation.attendance_sheet_pdf.course_wise_absent_sheet', $data);

        return $pdf->download("Tabulation"."-".now().'.pdf');




    }
    function course_wise_exam_schedule_index(){
        $courses=Course::all();
        return view('tabulation.exam_schedule.exam_schedule_index',[
            'courses'=>$courses,
        ]);
    }
    function course_wise_exam_schedule_post(Request $request){
        $request->validate([
            'course_id'=>'required',
            'batch_id'=>'required',
        ],[
            'course_id.required'=>'Course name is required',
            'batch_id.required'=>'Batch name is required',
        ]);
        $course_id=$request->course_id;
        $batch_id=$request->batch_id;
        $modules=array();

        $tests=CourseBasedTest::where('course_id',$course_id)->where('batch_id',$batch_id)->get();
        $quiz_info=[];
        foreach($tests as $test){
            $mcq_marks=0;
            $mcq=0;
            $match_marks=0;
            $match=0;
            $fill_marks=0;
            $fill=0;
            $desc_marks=0;
            $desc=0;

            $questions=CourseBasedQuizQuestion::where('quiz_id',$test->id)->get();
            foreach($questions as $question){
              if($question->rel_to_question->type == "MCQ"){
                $mcq_marks+=($question->rel_to_question->total_marks);
                $mcq+=1;


              }elseif($question->rel_to_question->type == "MATCH"){
                $match_marks+=($question->rel_to_question->total_marks);
                $match=+1;




              }elseif($question->rel_to_question->type == "FILL"){
                $fill_marks+=($question->rel_to_question->total_marks);
                $fill+=1;



              }elseif($question->rel_to_question->type == "DESC"){
                $desc_marks+=($question->rel_to_question->total_marks);
                $desc+=1;



              }

              $modules[]=$question->rel_to_question->rel_to_module->name;






            }

            $quiz_info[]=[
                'id'=>$test->id,
                'quiz_name'=>$test->name,
                'desc'=>$desc,
                'mcq'=>$mcq,
                'fill'=>$fill,
                'match'=>$match,
                'desc_marks'=>$desc_marks,
                'mcq_marks'=>$mcq_marks,
                'fill_marks'=>$fill_marks,
                'match_marks'=>$match_marks,
                'time'=>$test->time,
                'date'=>$test->start_date,
                'module'=>array_unique($modules),

              ];



        }



        return view('tabulation.exam_schedule.exam_schedule_sheet',[
            'quiz_info'=>$quiz_info,
            'course_id'=>$course_id,
            'batch_id'=>$batch_id,
            'assignments'=>CoursedBasedAssignment::where('course_id',$course_id)->where('batch_id',$batch_id)->get(),
            'assignment_full_mark'=>CoursedBasedAssignment::where('course_id',$course_id)->where('batch_id',$batch_id)->sum('full_marks'),
          ]);
    }
    function course_wise_exam_schedule_pdf ($course_id,$batch_id){


        $modules=array();

        $tests=CourseBasedTest::where('course_id',$course_id)->where('batch_id',$batch_id)->get();
        $quiz_info=[];
        foreach($tests as $test){
            $mcq_marks=0;
            $mcq=0;
            $match_marks=0;
            $match=0;
            $fill_marks=0;
            $fill=0;
            $desc_marks=0;
            $desc=0;

            $questions=CourseBasedQuizQuestion::where('quiz_id',$test->id)->get();
            foreach($questions as $question){
              if($question->rel_to_question->type == "MCQ"){
                $mcq_marks+=($question->rel_to_question->total_marks);
                $mcq+=1;


              }elseif($question->rel_to_question->type == "MATCH"){
                $match_marks+=($question->rel_to_question->total_marks);
                $match=+1;




              }elseif($question->rel_to_question->type == "FILL"){
                $fill_marks+=($question->rel_to_question->total_marks);
                $fill+=1;



              }elseif($question->rel_to_question->type == "DESC"){
                $desc_marks+=($question->rel_to_question->total_marks);
                $desc+=1;



              }

              $modules[]=$question->rel_to_question->rel_to_module->name;






            }

            $quiz_info[]=[
                'id'=>$test->id,
                'quiz_name'=>$test->name,
                'desc'=>$desc,
                'mcq'=>$mcq,
                'fill'=>$fill,
                'match'=>$match,
                'desc_marks'=>$desc_marks,
                'mcq_marks'=>$mcq_marks,
                'fill_marks'=>$fill_marks,
                'match_marks'=>$match_marks,
                'time'=>$test->time,
                'date'=>$test->start_date,
                'module'=>array_unique($modules),

              ];



        }



        $data=[
            'quiz_info'=>$quiz_info,
            'course_id'=>$course_id,
            'batch_id'=>$batch_id,
            'assignments'=>CoursedBasedAssignment::where('course_id',$course_id)->where('batch_id',$batch_id)->get(),
            'assignment_full_mark'=>CoursedBasedAssignment::where('course_id',$course_id)->where('batch_id',$batch_id)->sum('full_marks'),
        ];


        $pdf = PDF::loadView('tabulation.exam_schedule_pdf.exam_schedule_sheet', $data);

        return $pdf->download("Exam-Schedule"."-".now().'.pdf');


    }
    function course_wise_exam_date_range_schedule_index(){
        return view('tabulation.exam_schedule.exam_schedule_date_range_index');
    }

    function course_wise_exam_date_range_schedule_post(Request $request){
        $request->validate([
            'from'=>'required',
            'to'=>'required',
        ],[
            'from.required'=>'From date is required',
            'to.required'=>'To date is required',
        ]);

        $from=$request->from;
        $to=$request->to;


        $tests=CourseBasedTest::where('start_date','>=',$from)->where('start_date',"<=",$to)->get();


        $exam_schedules=[];
        $dates=[];
       foreach($tests as $key=>$test){
        if(!array_key_exists($test->batch_id,$exam_schedules)){
            $exam_schedules[$test->batch_id]=[
                'course_name'=>$test->rel_to_course->name,
                'batch_name'=>$test->rel_to_batch->batch_name,
                'tests'=>array(),
            ];
            array_push($exam_schedules[$test->batch_id]['tests'],
            ['start_date'=>$test->start_date,
              'start_time'=>$test->start_time,
              "end_date"=>$test->end_date,
              "end_time"=>$test->end_time,

        ]);


        }else{
            array_push($exam_schedules[$test->batch_id]['tests'],
            [
                "start_date"=>$test->start_date,
                'start_time'=>$test->start_time,
                "end_date"=>$test->end_date,
                "end_time"=>$test->end_time,

            ]);



        }
        $dates[]=$test->start_date;

       }



       return view('tabulation.exam_schedule.exam_schedule_date_range_sheet',[
        'exam_schedules'=>$exam_schedules,
        'dates'=>$dates,
        'from'=>$from,
        'to'=>$to,
       ]);
    }
    function course_wise_exam_date_range_schedule_pdf($from,$to){



        $tests=CourseBasedTest::where('start_date','>=',$from)->where('start_date',"<=",$to)->get();


        $exam_schedules=[];
        $dates=[];
       foreach($tests as $key=>$test){
        if(!array_key_exists($test->batch_id,$exam_schedules)){
            $exam_schedules[$test->batch_id]=[
                'course_name'=>$test->rel_to_course->name,
                'batch_name'=>$test->rel_to_batch->batch_name,
                'tests'=>array(),
            ];
            array_push($exam_schedules[$test->batch_id]['tests'],
            [  'test_name'=>$test->name,
              'start_date'=>$test->start_date,
              'start_time'=>$test->start_time,
              "end_date"=>$test->end_date,
              "end_time"=>$test->end_time,

        ]);


        }else{
            array_push($exam_schedules[$test->batch_id]['tests'],
            [  'test_name'=>$test->name,
                "start_date"=>$test->start_date,
                'start_time'=>$test->start_time,
                "end_date"=>$test->end_date,
                "end_time"=>$test->end_time,

            ]);



        }
        $dates[]=$test->start_date;

       }

       $data=[
        'exam_schedules'=>$exam_schedules,
        'dates'=>$dates,
        'from'=>$from,
        'to'=>$to,
       ];

       $pdf = PDF::loadView('tabulation.exam_schedule_pdf.exam_schedule_date_range_sheet', $data);

       return $pdf->download("Exam-Schedule"."-".now().'.pdf');



    }
    function course_wise_exam_postponed_list_index(){
        return view('tabulation.exam_schedule.postponed_exam_list_index');
    }
    function course_wise_exam_postponed_list_post(Request $request){

        $from=$request->from;
        $to=$request->to;

        $tests=CourseBasedTest::where('postponed_date','>=',$from)->where('postponed_date',"<=",$to)->get();

        $postponed_exam_list=[];
        foreach($tests as $test){
            $postponed_exam_list[]=[
                'course_name'=>$test->rel_to_course->name,
                'batch_name'=>$test->rel_to_batch->batch_name,
                'quiz_name'=>$test->name,
                'scheduled_date'=>$test->postponed_date,
                'new_date'=>$test->start_date,
                'reason'=>$test->postponed_reason,
            ];
        }


        return view('tabulation.exam_schedule.postponed_exam_list',[
            'from'=>$from,
            'to'=>$to,
            'postponed_exam_list'=>$postponed_exam_list,

        ]);



    }
    function course_wise_exam_postponed_list_pdf($from,$to){


        $tests=CourseBasedTest::where('postponed_date','>=',$from)->where('postponed_date',"<=",$to)->get();

        $postponed_exam_list=[];
        foreach($tests as $test){
            $postponed_exam_list[]=[
                'course_name'=>$test->rel_to_course->name,
                'batch_name'=>$test->rel_to_batch->batch_name,
                'quiz_name'=>$test->name,
                'scheduled_date'=>$test->postponed_date,
                'new_date'=>$test->start_date,
                'reason'=>$test->postponed_reason,
            ];
        }

        $data=[

            'postponed_exam_list'=>$postponed_exam_list,
        ];

        $pdf = PDF::loadView('tabulation.exam_schedule_pdf.postponed_exam_list', $data);

        return $pdf->download("PostponedExamList"."-".now().'.pdf');



    }




}
