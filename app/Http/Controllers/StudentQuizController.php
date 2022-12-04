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

        // dd(Carbon::now());
        dd(Carbon::now()->format('Y-m-d'),Carbon::now()->format('h:i:s'));
        // $independent_quiz=IndependentTest::whereDate('session_start_date', Carbon::create($request->start, $request->user()->timezone)->toDateString())
        // ->whereTime('session_start_date', '>=', Carbon::create($request->start, $request->user()->timezone)->toTimeString())
        // ->whereTime('session_start_date', '<=', Carbon::create($request->end, $request->user()->timezone)->toTimeString());


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
            if($ques->type == "MCQ"){
                $options=QuestionOptions::where('question_id',$ques->id)->get();
                print_r($options);


            }elseif($ques->type == "MATCH"){


            }elseif($ques->type == "FILL"){


            }else{

            }

        }


    }
}
