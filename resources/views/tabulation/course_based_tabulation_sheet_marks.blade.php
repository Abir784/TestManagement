@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">


              <h5 class="card-title">Course wise Tabulation Sheet [Marks]</h5>
              <div class="mb-3">
                <a href="{{url('admin/course_wise_tabulation_marks/download/'.$course_name.'/'.$batch_name)}}">Download Report </a>

              </div>
<pre>
<h4>
Course Name: {{App\Models\Course::where('id',$course_name)->first()->name}}
Batch No: {{App\Models\Batch::where('id',$batch_name)->first()->batch_name}}
</h4>
</pre>
                    <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th rowspan="2">SL</th>
                                <th rowspan="2">Name</th>
                                <th rowspan="2">Registration No</th>
                                <th colspan="{{count($quizzes)+2+count($assignments)}}" class="text-center">Marks</th>
                            </tr>
                            <tr>
                                @foreach ($quizzes as $quiz )

                                <th>{{$quiz->name}}</th>

                                @endforeach
                                @foreach ($assignments as $assignment )
                                   <th>{{$assignment->title}}</th>
                                @endforeach
                                <th>CGPA</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students_result as $key=>$results )
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$results['student_name']}}</td>
                                <td>{{$results['id']}}</td>
                                @php
                                    $cgpa=0;
                                    $i=0;
                                @endphp

                                @foreach ($results['quiz_marks'] as $quiz_marks)
                                  <td>{{$quiz_marks['mark_obtained']}}</td>
                                  @php
                                      $cgpa+=$quiz_marks['gpa'];
                                      $i+=1;
                                  @endphp

                                @endforeach


                                @foreach ($results['assignment_marks'] as $assignment)
                                  <td>{{$assignment['marks_obtained']}}</td>
                                  @php
                                  $cgpa+=$assignment['gpa'];
                                  $i+=1;
                                 @endphp
                                @endforeach
                                <td>{{number_format($cgpa/$i,2)}}</td>
                                @if (($cgpa/$i) == 0)

                                    <td colspan="5"  align="center">{{'F'}}</td>

                            @elseif (($cgpa/$i) >= 2.50 && ($cgpa/$i) <=2.74 )

                                    <td colspan="5"  align="center">{{'C+'}}</td>

                            @elseif (($cgpa/$i) >= 2.75 && ($cgpa/$i) <=2.99 )

                                    <td colspan="5"  align="center">{{'B-'}}</td>

                            @elseif (($cgpa/$i) >= 3.00 && ($cgpa/$i) <=3.24 )

                                    <td colspan="5"  align="center">{{'B'}}</td>

                            @elseif (($cgpa/$i) >= 3.25 && ($cgpa/$i) <=3.49 )

                                    <td colspan="5"  align="center">{{'B+'}}</td>

                            @elseif (($cgpa/$i) >= 3.50 && ($cgpa/$i) <=3.74 )

                                    <td colspan="5"  align="center">{{'A-'}}</td>

                            @elseif (($cgpa/$i) >= 3.75 && ($cgpa/$i) <=3.99 )

                                    <td colspan="5"  align="center">{{'A'}}</td>

                            @elseif (($cgpa/$i) >= 4.00 )

                                    <td colspan="5"  align="center">{{'A+'}}</td>
                            @else
                               <td colspan="5"  align="center">{{'Unsatisfactory'}}</td>
                            @endif

                            </tr>
                            @endforeach
                        </tbody>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
