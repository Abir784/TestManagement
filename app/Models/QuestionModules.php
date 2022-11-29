<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionModules extends Model
{
    use HasFactory;
    protected $guarded =['id'];
    function rel_to_subject(){
        return $this->belongsTo(subject::class, 'subject_id', 'id');
    }
}
