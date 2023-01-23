@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{url('admin/course_wise_attendance_sheet/download/'.$course_id.'/'.$batch_id)}}">Download Report</a>
                    </div>
                    <h5 class="card-title">Course Wise Attandance Sheet [All Exams]</h5>
                    <p class="card-text">


<pre>
<h4>
Course Name: {{App\Models\Course::where('id',$course_id)->first()->name}}
Batch No: {{App\Models\Batch::where('id',$batch_id)->first()->batch_name}}
</h4>


</pre>
                     <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Id</th>
                                @foreach ($quizzes as $quiz )

                                <th>{{$quiz->name}}</th>
                                @endforeach

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $key=>$student)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$student->name}}</td>
                                <td>{{$student->registration_no}}</td>
                                @foreach ($quizzes as $quiz )
                                   @if (App\Models\CourseBasedTestResult::where('quiz_id',$quiz->id)->where('student_id',$student->id)->exists())
                                      <td>Present</td>
                                    @else
                                      <td>Absent</td>
                                   @endif
                                @endforeach
                            </tr>
                            @endforeach

                        </tbody>
                     </table>


                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
