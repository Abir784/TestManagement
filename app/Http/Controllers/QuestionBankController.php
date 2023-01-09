<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionModules;
use App\Models\QuestionOptions;
use App\Models\subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Print_;
use Symfony\Component\Console\Question\Question as QuestionQuestion;
use Termwind\Question as TermwindQuestion;

use function GuzzleHttp\Promise\all;

class QuestionBankController extends Controller
{
    function SubjectIndex(){
        $subjects=subject::all();
        return view('question_bank.subject.index',[
            'subjects'=>$subjects,
        ]);
    }
    function SubjectPost(Request $request){
        $request->validate([
            'name'=>'required',

        ],
    [
        'name.required'=>"Subject Name is required",
    ]);
    subject::create([
        'name'=>$request->name,
        'desp'=>$request->desp,
        'created_at'=>Carbon::now(),
    ]);
    return back()->with('success','Successfully Added ');

    }
    function SubjectDelete($id){
        subject::find($id)->delete();
        return back();
    }
    function ModuleIndex(){

        $subjects=subject::select('id','name')->get();
        $modules=QuestionModules::all();
        return view('question_bank.module.index',
    [
        'subjects'=>$subjects,
        'modules'=>$modules,
    ]);

    }
    function ModulePost(Request $request){
        $request->validate([
            'subject_id'=>'required',
            'name'=>'required',
        ],[
            'subject_id.required'=>'Select a Subject Name',
            'name.required'=>'Module name is Required',
        ]);

        $module_names=explode('#',$request->name);
           foreach($module_names as $module){
               QuestionModules::create([
                   'subject_id'=>$request->subject_id,
                   'name'=>$module,
                   'desp'=>$request->desp,
                   'created_at'=>Carbon::now(),
                ]);
            }
          return back()->with('success','Successfully Done');

    }
    function ModuleDelete($id){
        QuestionModules::find($id)->delete();
        return back();
    }
    function QuestionIndex($id){

      return view('question_bank.question.index',[
        'module_id'=>$id,
      ]);
    }
    function QuestionPost(Request $request){
        if($request->type == 'MCQ'){

         $input=$request->all();
        $marks=explode('#', $input['marks']);
        $total_marks=array_sum($marks);

        $answers=explode('#',$input['correct_answer']);
        $options=explode('#',$input['option']);

              if(count($answers)==1){
                            $question_id=Question::insertGetId([
                            'module_id'=>$request->module_id,
                            'type'=>$request->type,
                            'title'=>$request->title,
                            'marks'=>$request->marks,
                            'total_marks'=>$total_marks,
                            'created_at'=>Carbon::now(),
                        ]);

                        foreach($options as $option){
                            $right_answer=($option==$input['correct_answer']) ? 1 : 0;
                            QuestionOptions::create([
                                'question_id'=>$question_id,
                                'option_title'=>$option,
                                'right_answer'=>$right_answer,
                                'created_at'=>Carbon::now(),
                            ]);
                        }


            } elseif(count($answers)==2){
               if(count($marks)==1){
                            $question_id=Question::insertGetId([
                                'module_id'=>$request->module_id,
                                'type'=>$request->type,
                                'title'=>$request->title,
                                'marks'=>$marks[0],
                                'total_marks'=>$total_marks,
                                'created_at'=>Carbon::now(),
                            ]);

                            foreach($options as $option){
                                $right_answer=(($option==$answers[0]) || ($option==$answers[1])) ? 1 : 0;
                                QuestionOptions::create([
                                    'question_id'=>$question_id,
                                    'option_title'=>$option,
                                    'right_answer'=>$right_answer,
                                    'created_at'=>Carbon::now(),
                                ]);
                            }
                }else{
                        $question_id=Question::insertGetId([
                            'module_id'=>$request->module_id,
                            'type'=>$request->type,
                            'title'=>$request->title,
                            'marks'=>0,
                            'total_marks'=>$total_marks,
                            'created_at'=>Carbon::now(),
                        ]);


                        foreach($options as $key=>$option){
                         $right_answer=(($option==$answers[0]) || ($option==$answers[1])) ? 1 : 0;
                         if(array_key_exists($key,$marks)){
                            $option_marks=$marks[$key];
                        }else{
                            $option_marks=0;
                        }
                            QuestionOptions::create([
                                'question_id'=>$question_id,
                                'option_title'=>$option,
                                'marks'=>$option_marks,
                                'right_answer'=>$right_answer,
                                'created_at'=>Carbon::now(),
                            ]);
                        }

                }
          }elseif(count($answers)==3){
                    if(count($marks)==1){
                        $question_id=Question::insertGetId([
                            'module_id'=>$request->module_id,
                            'type'=>$request->type,
                            'title'=>$request->title,
                            'marks'=>$marks[0],
                            'total_marks'=>$total_marks,
                            'created_at'=>Carbon::now(),
                        ]);

                        foreach($options as $key=>$option){
                            $right_answer=(($option==$answers[0]) || ($option==$answers[1]) || ($option==$answers[2]) ) ? 1 : 0;
                               QuestionOptions::create([
                                   'question_id'=>$question_id,
                                   'option_title'=>$option,
                                   'right_answer'=>$right_answer,
                                   'created_at'=>Carbon::now(),
                               ]);
                           }



                        }else{
                            $question_id=Question::insertGetId([
                                'module_id'=>$request->module_id,
                                'type'=>$request->type,
                                'title'=>$request->title,
                                'marks'=>0,
                                'total_marks'=>$total_marks,
                                'answer_explaination'=>$request->answer_explanation,
                                'created_at'=>Carbon::now(),
                            ]);


                            foreach($options as $key=>$option){
                                $right_answer=(($option==$answers[0]) || ($option==$answers[1]) || ($option==$answers[2]) ) ? 1 : 0;
                                if(array_key_exists($key,$marks)){
                                    $option_marks=$marks[$key];
                                }else{
                                    $option_marks=0;
                                }
                                   QuestionOptions::create([
                                       'question_id'=>$question_id,
                                       'option_title'=>$option,
                                       'marks'=>$option_marks,
                                       'right_answer'=>$right_answer,
                                       'created_at'=>Carbon::now(),
                                   ]);
                               }

                        }
            }elseif(count($answers)==4){

                        if(count($marks)==1){
                            $question_id=Question::insertGetId([
                                'module_id'=>$request->module_id,
                                'type'=>$request->type,
                                'title'=>$request->title,
                                'marks'=>$marks[0],
                                'total_marks'=>$total_marks,
                                'created_at'=>Carbon::now(),
                            ]);


                            foreach($options as $key=>$option){
                                $right_answer=(($option==$answers[0]) || ($option==$answers[1]) || ($option==$answers[2]) || ($option==$answers[3]) ) ? 1 : 0;

                                   QuestionOptions::create([
                                       'question_id'=>$question_id,
                                       'option_title'=>$option,
                                       'right_answer'=>$right_answer,
                                       'created_at'=>Carbon::now(),
                                   ]);
                               }

                    }else{
                        $question_id=Question::insertGetId([
                            'module_id'=>$request->module_id,
                            'type'=>$request->type,
                            'title'=>$request->title,
                            'marks'=>0,
                            'total_marks'=>$total_marks,
                            'created_at'=>Carbon::now(),
                        ]);


                        foreach($options as $key=>$option){
                            $right_answer=(($option==$answers[0]) || ($option==$answers[1]) || ($option==$answers[2]) || ($option==$answers[3]) ) ? 1 : 0;
                            if(array_key_exists($key,$marks)){
                                $option_marks=$marks[$key];
                            }else{
                                $option_marks=0;
                            }
                               QuestionOptions::create([
                                   'question_id'=>$question_id,
                                   'option_title'=>$option,
                                   'marks'=>$option_marks,
                                   'right_answer'=>$right_answer,
                                   'created_at'=>Carbon::now(),
                               ]);
                           }
                    }
            }else{
                return back()->with('error',"System made for 4 options");
            }
        }elseif ($request->type == "DESC") {
            Question::create([
                'module_id'=>$request->module_id,
                'title'=>$request->title,
                'type'=>$request->type,
                'marks'=>$request->marks,
                'total_marks'=>$request->marks,
                'created_at'=>Carbon::now(),
            ]);

        }
        elseif ($request->type=="FILL"){
            $input=$request->all();
            $answers=explode('#',$input['answer']);
            $marks=explode('#',$input['marks']);
            $total_marks=array_sum($marks);

            if(count($marks)==1){
                    $question_id=Question::insertGetId([
                        'module_id'=>$input['module_id'],
                        'title'=>$input['title'],
                        'type'=>$input['type'],
                        'marks'=>$input['marks'],
                        'total_marks'=>$total_marks,
                        'created_at'=>Carbon::now(),
                    ]);
                    foreach($answers as $answer){
                        QuestionOptions::create([
                            'question_id'=>$question_id,
                            'option_title'=>$answer,
                            'right_answer'=>1,
                            'created_at'=>Carbon::now(),
                        ]);
                    }
            }else{

                    $question_id=Question::insertGetId([
                        'module_id'=>$input['module_id'],
                        'title'=>$input['title'],
                        'marks'=>0,
                        'total_marks'=>$total_marks,
                        'type'=>$input['type'],
                        'created_at'=>Carbon::now(),
                    ]);

                    foreach($answers as $i=>$answer){
                        if(array_key_exists($i,$marks)){
                            $option_marks=$marks[$i];
                        }else{
                            $option_marks=0;
                        }

                        QuestionOptions::create([
                            'question_id'=>$question_id,
                            'option_title'=>$answer,
                            'right_answer'=>1,
                            'marks'=>$option_marks,
                            'created_at'=>Carbon::now(),
                        ]);
                    }

           }
        }else{
            $request->validate([
                'title'=>'required',
                'marks'=>'required',
            ]);

                $input=$request->all();
                $marks=explode('#',$input['marks']);
                $total_marks=array_sum($marks);

                if(count($marks)==1){
                    $question_id=Question::insertGetId([
                        'module_id'=>$request->module_id,
                        'type'=>$request->type,
                        'title'=>$request->title,
                        'marks'=>$request->marks,
                        'total_marks'=>$total_marks,
                        'created_at'=>Carbon::now(),
                    ]);

                    $answers=explode('#',$input['answers']);
                    foreach($answers as $answer){
                        QuestionOptions::create([
                            'question_id'=>$question_id,
                            'option_title'=>$answer,
                            'right_answer'=>1,
                            'created_at'=>Carbon::now(),
                        ]);

                    }

                }else{

                        $question_id=Question::insertGetId([
                            'module_id'=>$request->module_id,
                            'type'=>$request->type,
                            'title'=>$request->title,
                            'marks'=>0,
                            'total_marks'=>$total_marks,
                            'created_at'=>Carbon::now(),
                        ]);
                        $answers=explode('#',$input['answers']);
                        foreach($answers as $i=>$answer){
                            if(array_key_exists($i,$marks)){
                                $option_marks=$marks[$i];
                            }else{
                                $option_marks=0;
                            }
                            QuestionOptions::create([
                                'question_id'=>$question_id,
                                'option_title'=>$answer,
                                'marks'=>$option_marks,
                                'right_answer'=>1,
                                'created_at'=>Carbon::now(),
                            ]);

                        }
                }
        }

        return back()->with('success','success');
     }

     function QuestionShow($id){
        $questions=Question::where('module_id',$id)->get();

        $data=[];
        foreach($questions as $key=>$question){
            $options=QuestionOptions::select('option_title','right_answer','marks')->where('question_id',$question->id)->get();

            $option_data=[];
            $full=$question->total_marks;

            foreach($options as $k=>$option){

                $option_data[$k]=[
                    'option_title'=>$option->option_title,
                    'marks'=>$option->marks,
                    'right_answer'=>$option->right_answer,
                ];


            }
            $data[$key]=[
                'question_id'=>$question->id,
                'title'=>$question->title,
                'type'=>$question->type,
                'options'=>$option_data,
                'full_marks'=>$question->marks,
                'count'=>count($options),
                'total_marks'=>$full,

            ];
           }
        return view('question_bank.question.question_list',[
            'data'=>$data,
        ]);



     }
     function QuestionDelete($id){
       $options= QuestionOptions::where('question_id',$id)->get();
        foreach($options as $option){
            $option->delete();
        }
        Question::find($id)->delete();

        return back();
     }

}









