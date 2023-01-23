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
use PDF;

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
            $submissions=IndividualTestDescriptiveAnswer::where('status',0)->get();
            return view('individual_test.descriptive_index',[
                'submissions'=>$submissions,
            ]);
        }
        function DescriptiveMarkingMarking($id){
            $script=IndividualTestDescriptiveAnswer::where('id',$id)->first();
            // dd($script);
            return view('individual_test.marking',[
                'script'=>$script,
            ]);
        }
        function DescriptiveMarkingMarkingPost(Request $request){
            $question=IndividualTestDescriptiveAnswer::where('id',$request->id)->first();

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
    function edit($id){
        $quiz=IndividualTest::find($id)->first();
        return view('individual_test.edit',[
            'quiz'=>$quiz,
        ]);
    }
    function update(Request $request){

        IndividualTest::find($request->id)->update([
            'name'=>$request->name,
            'introduction_text'=>$request->introduction_text,
            'passing_comments'=>$request->pass_comment,
            'failing_comments'=>$request->failing_comment,
            'time'=>$request->time,
            'start_date'=>$request->start_date,
            'start_time'=>$request->start_time,
            'end_date'=>$request->end_date,
            'end_time'=>$request->end_time,
            'pass_marks'=>$request->pass_marks,
            'created_at'=>Carbon::now(),
        ]);

        return redirect(url('admin/index/invidual_test'))->with('update','Successfull');
    }
    function delete($id){
        $questions=IndividualTestQuestion::where('quiz_id',$id)->get();
        foreach($questions as $question){
            $question->delete();
        }
        //Deleting Students of Individual students tables
        $students=IndividualTestStudents::where('quiz_id',$id)->get();
        foreach($students as $student){
            $student->delete();
        }

        IndividualTest::find($id)->delete();
        return back();

    }

    function QuestionDelete($id){
        IndividualTestQuestion::find($id)->delete();
        return back();
    }


    function Marksheetgenerate(){

        $student=Student::where('user_id',Auth::user()->id)->first();
        $quiz_results=InvidualTestResult::where('student_id',$student->id)->get();
        $written_answer=IndividualTestDescriptiveAnswer::where('student_id',$student->id)->get();


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
        foreach($quiz_results as $key=>$quiz){


            $questions=IndividualTestQuestion::where('quiz_id',$quiz->quiz_id)->get();


            $full_marks=0;
            foreach($questions as $question){

                $full_marks+=($question->rel_to_question->total_marks);


            }

            $marks=0;
            if(array_key_exists($quiz->quiz_id,$main_result)){
                $marks=$main_result[$quiz->quiz_id];
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
                    'name'=>$quiz->rel_to_quiz->name,
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

        $pdf = PDF::loadView('marksheet_3', $data);

        return $pdf->download($student->name."_".$student->registration_no.'_'.now().'.pdf');

    }


}
