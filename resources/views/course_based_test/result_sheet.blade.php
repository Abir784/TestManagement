@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
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
                            @foreach ($quizzes_results as $result )
                            <tr>
                                <td>{{$result['name']}}</td>
                                <td>{{$result['full_marks']}}</td>
                                <td>{{$result['mark_obtained']}}</td>
                                <td>{{$result['gpa']}}</td>
                                <td>{{$result['grade']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <thead class="thead-light">
                            <th colspan="5" class="text-center">Assignments</th>
                        </thead>
                        <tbody>
                            @foreach ( $assignment_results as $result )
                                <tr>
                                    <td>{{$result['name']}}</td>
                                    <td>{{$result['full_marks']}}</td>
                                    <td>{{$result['marks_obtained']}}</td>
                                    <td>{{$result['gpa']}}</td>
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
