@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{url('student/generate/marksheet_2')}}">Download Marksheet</a>
                    </div>
                    <h5 class="card-title">
<pre>
Name:              {{$student->name}}
Registration No:   {{$student->registration_no}}
Course Name:       {{$student->course_name->name}}
Course code:       {{$student->course_name->course_code}}
Batch Number:      {{$student->batch_name->batch_name}}
</pre>
                    </h5>

                      <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>Test Name</th>
                                <th>Full Mark</th>
                                <th>Marks Obtained</th>
                                <th>GPA</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=0;
                                $cgpa=0;

                            @endphp
                            @foreach ($quizzes_results as $result )
                            @php
                            $cgpa+=$result['gpa'];
                            $i+=1;

                            @endphp
                            <tr>
                                <td>{{$result['name']}}</td>
                                <td>{{$result['full_marks']}}</td>
                                <td>{{$result['mark_obtained']}}</td>
                                <td>{{number_format($result['gpa'],2)}}</td>
                                <td>{{$result['grade']}}</td>

                            </tr>
                            @endforeach
                        </tbody>


                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
