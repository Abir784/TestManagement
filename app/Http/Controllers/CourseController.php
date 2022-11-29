<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Batch;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    function index(){
        return view('course.index');
    }
    function StoreCourse(Request $request){
        $request->validate([
            'course_name'=>'required',
            'course_code'=>'required',
            'comment'=>'max:600',
        ],[
            'course_name.required'=>'Course Name is Required',
            'course_code.required'=>'Course Code is Required',
        ]);

        Course::create([
            'name'=>$request->course_name,
            'course_code'=>$request->course_code,
            'comment'=>$request->comment,
            'created_at'=>Carbon::now(),
        ]);

        return back()->with('sucess','Course Added Successfully');


    }
    function showCourse(){
        $course_info=Course::all();
        return view('course.course_list',["course_info"=>$course_info,]);
    }
    function CourseDelete($id){
        Course::find($id)->delete();
        return back()->with('sucess','Deleted Successfully');
    }
    function CourseEdit($id){
        $course=Course::where('id',$id)->first();

        return view('course.edit',[
            'course'=>$course,
            'id'=>$id,
        ]);

    }
    function UpdateCourse(Request $request){
        $request->validate([
            'course_name'=>'required',
            'course_code'=>'required',
            'comment'=>'max:600',
        ],[
            'course_name.required'=>'Course Name is Required',
            'course_code.required'=>'Course Code is Required',
        ]);

        $course=Course::where('id',$request->id)->first();
           $course->update([
            'name'=>$request->course_name,
            'course_code'=>$request->course_code,
            'comment'=>$request->comment,
            'updated_at'=>Carbon::now(),
        ]);

        return back()->with('sucess','Course Updated Successfully');

    }
    function IndexBatch(){
              $courses=Course::select('id','name')->get();
                return view('batches.index',
            [
                'courses'=>$courses,
            ]);
    }
    function CreateBatch(Request $request){
        $request->validate([
            'batch_name'=>'required',
            'course_id'=>'required',
            'start_date'=>'required',
        ],
    [
        'batch_name.required'=>'Batch name is requied',
        'course_id.required'=>'Course name is requied',
        'start_date.required'=>'Start date is requied',
    ]);

    Batch::create([
        'batch_name'=>$request->batch_name,
        'course_id'=>$request->course_id,
        'start_date'=>$request->start_date,
        'created_at'=>Carbon::now(),
    ]);

    return back()->with('success','Batch added Successfully');

    }
    function showBatch(){
        $batch_info=Batch::all();
        return view('batches.batch_list',
        [
           'batch_info'=>$batch_info,
        ]);
    }
    function DeleteBatch($id){
        Batch::find($id)->delete();

        return back()->with('success','Sweertalert');
    }

    public function Ajax(Request $request){

        $send_to_cat='<option value="">---Select Batch name---</option>';
        $batches = Batch::where('course_id',$request->course_id)->get();
        foreach($batches as $batch){
            $send_to_cat.='<option value="'.$batch->id.' ">'.$batch->batch_name .'</option>';
        }
        echo $send_to_cat;


    }
}
