<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    function rel_to_module(){
        return $this->belongsTo(QuestionModules::class, 'module_id', 'id');


    }
}
