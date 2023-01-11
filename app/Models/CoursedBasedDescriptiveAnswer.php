<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursedBasedDescriptiveAnswer extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function rel_to_student(){
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    public function rel_to_question(){
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
    public function rel_to_quiz(){
        return $this->belongsTo(CourseBasedTest::class, 'quiz_id', 'id');
    }

}
