@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{url("admin/course_wise_exam_date_range_schedule/download/".$from."/".$to)}}">Download Report</a>
                    </div>
                    <h5 class="card-title">Exam Schedule [Date Range]</h5>
                    <p class="card-text">
                        <table class="table table-light">
                            <thead class="thead-light">
                                   <th>Course Name</th>
                                   <th>Batch Name</th>
                                   <th class="text-center" colspan="{{count($dates)}}">Date & Time</th>
                            </thead>
                            <tbody>
                                @foreach ($exam_schedules as  $exams )
                                <tr>
                                    <td>
                                        {{$exams['course_name']}}
                                    </td>

                                    <td>
                                        {{$exams['batch_name']}}
                                    </td>
                                    @foreach ($exams['tests'] as $exam )
                                       <td>
                                           From: ({{Carbon\Carbon::parse($exam['start_date'])->format('d-M-Y')}}|{{Carbon\Carbon::parse($exam['start_time'])->format('h:i A')}})<br>To:({{Carbon\Carbon::parse($exam['end_date'])->format('d-M-Y')}}|{{Carbon\Carbon::parse($exam['end_time'])->format('h:i A')}})
                                       </td>

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
