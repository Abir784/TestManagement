<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function  __construct($course_id,$batch_id)
    {
        $this->course_id= $course_id;
        $this->batch_id= $batch_id;
    }

    public function collection(Collection $collection)
    {
        foreach($collection as $row){
            $user=User::create([
                'name'=>$row['name'],
                'email'=>$row['email'],
                'role'=>2,
                'password'=>Hash::make($row['registration_no']),
                'created_at'=>Carbon::now(),
            ]);
            Student::create([
                'name'=>$row['name'],
                'user_id'=>$user->id,
                'email'=>$row['email'],
                'registration_no'=>$row['registration_no'],
                'phone_no'=>$row['phone_no'],
                'course_id'=> $this->course_id,
                'batch_id'=> $this->batch_id,
                'country'=>$row['country'],
            ]);
        }
    }
}
