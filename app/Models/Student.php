<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $guarded =['id'];
    public function course_name(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function batch_name(){
        return $this->belongsTo(Batch::class, 'batch_id', 'id');
    }
}

