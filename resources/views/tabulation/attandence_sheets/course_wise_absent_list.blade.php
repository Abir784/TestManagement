@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Course Wise Absent List</h5>
                <div class="mb-3">
                    <a href="{{url('admin/course_wise_absent_sheet/download/'.$course_id.'/'.$batch_id)}}">Download Report</a>
                </div>

<pre>
    <h4>
        Course Name:{{App\Models\Course::where('id',$course_id)->first()->name}}
        Batch No:{{App\Models\Batch::where('id',$batch_id)->first()->batch_name}}

    </h4>

</pre>
                    <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Registration No.</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Absent Exam Title</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absent_list as $key=>$absent )
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$absent['student_name']}}</td>
                                <td>{{$absent['id']}}</td>
                                <td>{{$absent['email']}}</td>
                                <td>{{$absent['phone']}}</td>
                                <td>{{$absent['quiz_name']}}</td>
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
