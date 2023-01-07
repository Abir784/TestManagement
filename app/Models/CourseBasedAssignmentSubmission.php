<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseBasedAssignmentSubmission extends Model
{
    use HasFactory;
    protected $guarded =['idha'];
    public function rel_to_student(){
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    public function rel_to_assignment(){
        return $this->belongsTo(CoursedBasedAssignment::class, 'assignment_id', 'id');
    }
}
