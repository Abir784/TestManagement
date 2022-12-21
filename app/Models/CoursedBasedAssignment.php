<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursedBasedAssignment extends Model
{
    use HasFactory;
    protected $guarded =['id'];

    public function rel_to_course(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function rel_to_batch(){
        return $this->belongsTo(Batch::class, 'batch_id', 'id');
    }
}
