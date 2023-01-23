@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Course wise Exam Attendance</h5>
                <div class="mb-3">
                    <a href="{{url('admin/course_wise_exam_attendace_sheet/download/'.$course_id.'/'.$batch_id."/".$quiz_id)}}">Download Report</a>
                </div>

<pre>
    <h4>
        Course Name:{{App\Models\Course::where('id',$course_id)->first()->name}}
        Batch No:{{App\Models\Batch::where('id',$batch_id)->first()->batch_name}}
        Exam name:{{App\Models\CourseBasedTest::where('id',$quiz_id)->first()->name}}
        Exam date:{{Carbon\Carbon::parse(App\Models\CourseBasedTest::where('id',$quiz_id)->first()->start_date)->format('d-M-Y')}}
    </h4>

</pre>
                    <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Registration No.</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $key=>$attendance )
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$attendance['name']}}</td>
                                <td>{{$attendance['id']}}</td>
                                <td>{{$attendance['status']}}</td>
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
