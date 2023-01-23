<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseBasedAssignmentSubmission;
use App\Models\CourseBasedQuizQuestion;
use App\Models\CourseBasedTest;
use App\Models\CourseBasedTestResult;
use App\Models\CoursedBasedAssignment;
use App\Models\CoursedBasedDescriptiveAnswer;
use App\Models\IndependentTestQuestions;
use App\Models\Question;
use App\Models\Student;
use App\Models\subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class StudentCourseBasedTestController extends Controller
{
    public function Ajax(Request $request){

        $send_to_cat='<option value="">---Select Quiz name---</option>';
        $quizzes = CourseBasedTest::where('course_id',$request->batch_id)->get();
        foreach($quizzes as $quiz){
            $send_to_cat.='<option value="'.$quiz->id.' ">'.$quiz->name .'</option>';
        }
        echo $send_to_cat;


    }

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
    function DescriptiveMarkingIndex(){
        $submissions=CoursedBasedDescriptiveAnswer::where('status',0)->get();
        return view('course_based_test.descriptive_index',[
            'submissions'=>$submissions,
        ]);
    }
    function DescriptiveMarkingMarking($id){
        $script=CoursedBasedDescriptiveAnswer::where('id',$id)->first();
        return view('course_based_test.marking',[
            'script'=>$script,
        ]);
    }
    function DescriptiveMarkingMarkingPost(Request $request){
        $question=CoursedBasedDescriptiveAnswer::where('id',$request->id)->first();

        if($request->mark > $question->rel_to_question->marks){
            return back()->with('error','Full marks for this question is '.$question->rel_to_question->marks);
        }else{
            $question->update([
                'mark'=>$request->mark,
                'status'=>1,
                'updated_at'=>now(),
            ]);
            return redirect(url('admin/CourseBased/DescriptiveAnswerMarking/Index'));
        }

    }
    function edit($id){
        $quiz=CourseBasedTest::where('id',$id)->first();
        return view('course_based_test.edit',[
            'quiz'=>$quiz,
        ]);

    }
    function update(Request $request){

        $scheduled_date=CourseBasedTest::where('id',$request->id)->first()->start_date;
        CourseBasedTest::find($request->id)->update([
            'postponed_reason'=>$request->reason,
            'postponed_date'=>$scheduled_date,
            'start_date'=>$request->start_date,
            'start_time'=>$request->start_time,
            'end_date'=>$request->end_date,
            'end_time'=>$request->end_time,

            'updated_at'=>Carbon::now(),
        ]);

        return redirect(url('admin/index/course_based_test'))->with('update','Successfull');
    }
    function delete($id){
        $questions=CourseBasedQuizQuestion::where('quiz_id',$id)->get();
        foreach($questions as $question){
            $question->delete();
        }


        CourseBasedTest::find($id)->delete();
        return back();

    }
    function QuestionDelete($id){
        CourseBasedQuizQuestion::find($id)->delete();
        return back();
    }
    public function generateMarksheet()
    {

        $student=Student::where('user_id',Auth::user()->id)->first();
        $quizzes=CourseBasedTest::where('course_id',$student->course_id)->where('batch_id',$student->batch_id)->get();
        $assignments=CoursedBasedAssignment::where('course_id',$student->course_id)->where('batch_id',$student->batch_id)->get();
        $quiz_results=CourseBasedTestResult::where('student_id',$student->id)->get();
        $assignments_result=CourseBasedAssignmentSubmission::where('student_id',$student->id)->get();
        $written_answer=CoursedBasedDescriptiveAnswer::where('student_id',$student->id)->get();


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
                    'name'=>$quiz->name,
                    'gpa'=>$gpa,
                    'mark_obtained'=>$marks,
                    'full_marks'=>$full_marks,
                    'grade'=>$grade,
                );

            }else{
                $quizzes_results[]=array(
                    'name'=>$quiz->name,
                    'gpa'=>0,
                    'mark_obtained'=>"Absent",
                    'full_marks'=>$full_marks,
                    'grade'=>'N/A',
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
                'name'=>$assignment->title,
                'full_marks'=>$assignment->full_marks,
                'marks_obtained'=>$assignment_marks,
                'gpa'=>$gpa,
                'grade'=>$grade,
            );
        }
        $data=[
                'student'=>$student,
                'quizzes_results'=>$quizzes_results,
                'assignment_results'=>$assignment_results,
        ];



        $pdf = PDF::loadView('marksheet', $data);

        return $pdf->download($student->name."_".$student->registration_no.'_'.now().'.pdf');

    }
}
