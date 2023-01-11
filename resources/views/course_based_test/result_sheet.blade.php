@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{url('student/generate/marksheet')}}">Download Marksheet</a>
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
                        <thead class="thead-light">
                            <th colspan="5" class="text-center">Assignments</th>
                        </thead>
                        <tbody>
                            @foreach ( $assignment_results as $result )
                            @php
                            $cgpa+=$result['gpa'];
                            $i+=1;
                            @endphp
                                <tr>
                                    <td>{{$result['name']}}</td>
                                    <td>{{$result['full_marks']}}</td>
                                    <td>{{$result['marks_obtained']}}</td>
                                    <td>{{number_format($result['gpa'],2)}}</td>
                                    <td>{{$result['grade']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <thead class="thead-light">
                            <th colspan="5" class="text-center">CGPA(Out of 4)</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center">{{number_format($cgpa/$i,2)}}</td>
                            </tr>
                        </tbody>
                        <thead class="thead-light">
                            <th colspan="5" class="text-center">Letter Grade</th>
                        </thead>
                        <tbody>
                            @if (($cgpa/$i) == 0)
                                <tr>
                                    <td colspan="5" class="text-center">{{'F'}}</td>
                                </tr>
                            @elseif (($cgpa/$i) >= 2.50 && ($cgpa/$i) <=2.74 )
                                <tr>
                                    <td colspan="5" class="text-center">{{'C+'}}</td>
                                </tr>
                            @elseif (($cgpa/$i) >= 2.75 && ($cgpa/$i) <=2.99 )
                                <tr>
                                    <td colspan="5" class="text-center">{{'B-'}}</td>
                                </tr>
                             @elseif (($cgpa/$i) >= 3.00 && ($cgpa/$i) <=3.24 )
                                <tr>
                                    <td colspan="5" class="text-center">{{'B'}}</td>
                                </tr>
                            @elseif (($cgpa/$i) >= 3.25 && ($cgpa/$i) <=3.49 )
                                <tr>
                                    <td colspan="5" class="text-center">{{'B+'}}</td>
                                </tr>
                            @elseif (($cgpa/$i) >= 3.50 && ($cgpa/$i) <=3.74 )
                                <tr>
                                    <td colspan="5" class="text-center">{{'A-'}}</td>
                                </tr>
                             @elseif (($cgpa/$i) >= 3.75 && ($cgpa/$i) <=3.99 )
                                <tr>
                                    <td colspan="5" class="text-center">{{'A'}}</td>
                                </tr>
                            @elseif (($cgpa/$i) >= 4.00 )
                                <tr>
                                    <td colspan="5" class="text-center">{{'A+'}}</td>
                                </tr>

                            @endif
                        </tbody>

                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
