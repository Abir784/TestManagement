@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{url('admin/course_wise_exam_postponed_list/download/'.$from.'/'.$to)}}">Download Report </a>

                      </div>
                    <h5 class="card-title">Postponed Exam List</h5>
                    <p class="card-text">
                        <table class="table table-light">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Course Name</th>
                                    <th>Batch Name</th>
                                    <th>Exam  Name</th>
                                    <th>Scheduled Date</th>
                                    <th>New Date</th>
                                    <th>Reason/Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($postponed_exam_list as $key=>$exam)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$exam['course_name']}}</td>
                                    <td>{{$exam['batch_name']}}</td>
                                    <td>{{$exam['quiz_name']}}</td>
                                    <td>{{Carbon\Carbon::parse($exam['scheduled_date'])->format('d-M-Y')}}</td>
                                    <td>{{Carbon\Carbon::parse($exam['new_date'])->format('d-M-Y')}}</td>
                                    <td>{{$exam['reason']}}</td>
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
