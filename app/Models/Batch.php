<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Batch extends Model
{
    use HasFactory;
    protected $guarded =['id'];

    public function rel_to_course(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
        }

}
