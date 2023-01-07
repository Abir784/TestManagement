<?php

namespace App\Http\Controllers;

use App\Models\CourseBasedAssignmentSubmission;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    function AssignmentIndex($id){
        return view('assignment.assignment_submission',[
            'id'=>$id,
        ]);

    }
    function AssignmentPost(Request $request){
        $request->validate([
            'file'=>'required|mimes:pdf,csv,xlxx,docs|max:2080'
        ],[
            'file.required'=>'This field is required',
          ]
    );
    $student=Student::where('user_id',Auth::id())->first();
     $id=CourseBasedAssignmentSubmission::insertGetId([
        'assignment_id'=>$request->id,
        'student_id'=>$student->id,
        'created_at'=>now(),
     ]);
     $extention=$request->file->getClientOriginalExtension();
     $file_name=$id."-".$student->id.".".$extention;

     $request->file->move(public_path('assets/uploads/assignment_submissions'),$file_name);

     CourseBasedAssignmentSubmission::where('id',$id)->update([
         'file_name'=>$file_name,
         'updated_at'=>now(),
     ]);
     return redirect(route('student.assignment.index'));
    }
}
