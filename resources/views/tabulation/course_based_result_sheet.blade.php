@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">


              <h5 class="card-title">Course wise Result Sheet</h5>
              <div class="mb-3">
                <a href="{{url('admin/course_wise_result_sheet/download/'.$course_name.'/'.$batch_name)}}">Download Report </a>

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
                                <th >SL</th>
                                <th >Name</th>
                                <th >Registration No</th>
                                <th >CGPA</th>
                                <th >Grade</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($students_result as $key=>$results )
                        <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$results['student_name']}}</td>
                                <td>{{$results['id']}}</td>
                                <td>{{number_format($results['cgpa'],2)}}</td>
                             @if (($results['cgpa']) == 0)

                                    <td align="center">{{'F'}}</td>

                            @elseif (($results['cgpa']) >= 2.50 && ($results['cgpa']) <=2.74 )

                                    <td align="center">{{'C+'}}</td>

                            @elseif (($results['cgpa']) >= 2.75 && ($results['cgpa']) <=2.99 )

                                    <td align="center">{{'B-'}}</td>

                            @elseif (($results['cgpa']) >= 3.00 && ($results['cgpa']) <=3.24 )

                                    <td align="center">{{'B'}}</td>

                            @elseif (($results['cgpa']) >= 3.25 && ($results['cgpa']) <=3.49 )

                                    <td align="center">{{'B+'}}</td>

                            @elseif (($results['cgpa']) >= 3.50 && ($results['cgpa']) <=3.74 )

                                    <td align="center">{{'A-'}}</td>

                            @elseif (($results['cgpa']) >= 3.75 && ($results['cgpa']) <=3.99 )

                                    <td align="center">{{'A'}}</td>

                            @elseif (($results['cgpa']) >= 4.00 )

                                    <td align="center">{{'A+'}}</td>
                            @else
                               <td colspan="5"  align="center">{{'Unsatisfactory'}}</td>
                            @endif
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
