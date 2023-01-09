<?php

namespace App\Http\Controllers;

use App\Models\CourseBasedAssignmentSubmission;
use App\Models\CoursedBasedAssignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    function Index(){

        $submissions=CourseBasedAssignmentSubmission::where('status',0)->get();
        return view('assignment.assignment_index',[
            'submissions'=>$submissions,
        ]);

    }
    function Marking($id){
        $script=CourseBasedAssignmentSubmission::where('id',$id)->first();
        return view('assignment.marking',
        [
            'script'=>$script,
        ]);
    }
    function MarkingPost(Request $request){
       $assignment=CourseBasedAssignmentSubmission::where('id',$request->id)->first();
       if($request->mark > $assignment->rel_to_assignment->full_marks){
         return back()->with('error','Full marks for this assignment is '. $assignment->rel_to_assignment->full_marks);
       }else{
        $assignment->update([
            'mark'=>$request->mark,
            'status'=>1,
        ]);
        return redirect(url('admin/Assignment/Index'));

       }
    }


}
