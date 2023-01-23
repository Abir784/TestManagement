<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvidualTestResult extends Model
{
    protected $guarded =['id'];
    use HasFactory;
    public function rel_to_quiz(){
        return $this->belongsTo(IndividualTest::class, 'quiz_id', 'id');
    }
}
