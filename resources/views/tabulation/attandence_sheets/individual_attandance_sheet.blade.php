@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{url('admin/individual_attendance_sheet/download/'.$attendances['s_id'])}}">Download Report</a>
                    </div>
                    <h5 class="card-title">Individual Attandance Sheet</h5>
                    <p class="card-text">


<pre>
<h4>
Name of Delegate: {{$attendances['name']}}
Course Name: {{$attendances['course_name']}}
Batch No: {{$attendances['batch_name']}}
</h4>


</pre>
                     <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Exam Title</th>
                                <th>Date Of Exam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances['tests'] as $key=>$tests)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$tests['quiz_name']}}</td>
                                <td>{{Carbon\Carbon::parse($tests['start_date'])->format('d-M-Y')}}</td>
                                <td>{{$tests['status']}}</td>
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
