<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualTestQuestion extends Model
{
    protected $guarded =['id'];
    use HasFactory;
    public function rel_to_question(){
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
}
