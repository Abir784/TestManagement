<?php

namespace App\Http\Controllers;

use App\Models\IndependentTest;
use App\Models\IndependentTestQuestions;
use App\Models\Question;
use App\Models\QuestionOptions;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentQuizController extends Controller
{
    function QuizIndex(){
        $independent_quiz=IndependentTest::whereDate('start_date','>=',Carbon::now())->whereDate('end_date','<=',Carbon::now())->get();


        return view('student_test.index',[
            'independent_quiz'=>$independent_quiz,
        ]);
    }
    function ExamIndex($id){
        $questions=IndependentTestQuestions::where('quiz_id',$id)->get();

      return view('student_test.exam_page',
    [
        'questions'=>$questions,
    ]);
    }
    function ExamPost(Request $request){

        $input=$request->all();


        foreach($request->question_id as $question){
            $ques=Question::where('id',$question)->first();
            // if($ques->type == "MCQ"){
            //     if ($ques->marks !=0 && count($input['answer__'.$question])>1){
            //         echo 'Yes';

            //     }else{
            //         echo 'NO';

            //     }




            // }elseif($ques->type == "MATCH"){


            // }elseif($ques->type == "FILL"){


            // }else{

            // }

        }


    }
}
