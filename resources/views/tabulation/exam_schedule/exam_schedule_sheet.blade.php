@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">


              <h5 class="card-title">Exam Schedule</h5>
              <div class="mb-3">
                <a href="{{url('admin/course_wise_exam_schedule/download/'.$course_id.'/'.$batch_id)}}">Download Report </a>

              </div>
<pre>
<h4>
Course Name: {{App\Models\Course::where('id',$course_id)->first()->name}}
Batch No: {{App\Models\Batch::where('id',$batch_id)->first()->batch_name}}
</h4>
</pre>
                    <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th >Name Of Assesment</th>
                                <th >Syllabus Covered</th>
                                <th colspan="4" class="text-center">No of Questions</th>
                                <th colspan="4" class="text-center" >Marks</th>
                                <th>Time</th>
                                <th>Date</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Desciptive</th>
                                <th>MCQ</th>
                                <th>Fill In the Blanks</th>
                                <th>Matching</th>

                                <th>Desciptive</th>
                                <th>MCQ</th>
                                <th>Fill In the Blanks</th>
                                <th>Matching</th>
                                <th></th>
                                <th></th>
                            </tr>

                        </thead>
                        <tbody>
                            @php
                                $total_marks=0;
                            @endphp
                        @foreach ($quiz_info as $quiz )
                        <tr>

                            <td>{{$quiz['quiz_name']}}</td>
                            <td>
                                @foreach ($quiz['module'] as $module)
                                    {{$module}}<br>
                                @endforeach
                            </td>
                            <td>{{$quiz['desc']}}</td>
                            <td>{{$quiz['mcq']}}</td>
                            <td>{{$quiz['fill']}}</td>
                            <td>{{$quiz['match']}}</td>


                            <td>{{$quiz['desc_marks']}}</td>
                            <td>{{$quiz['mcq_marks']}}</td>
                            <td>{{$quiz['fill_marks']}}</td>
                            <td>{{$quiz['match_marks']}}</td>
                            <td>{{$quiz['time']}} Min</td>
                            <td>{{Carbon\Carbon::parse($quiz['date'])->format('d-M-Y')}}</td>
                            @php
                                $total_marks+=($quiz['desc_marks']+$quiz['mcq_marks']+$quiz['fill_marks']+$quiz['match_marks']);
                            @endphp
                        </tr>

                        @endforeach
                        @foreach ($assignments as $assignment )
                        <tr>
                            <td> <b>Assignment:</b> {{$assignment->title}}</td>
                            <td colspan="10" align="center" >Marks: {{$assignment->full_marks}}</td>
                            <td> <b>Deadline: </b> {{Carbon\Carbon::parse($assignment->deadline)->format('d-M-Y')}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="12" align="center">Total Mark = {{$total_marks+$assignment_full_mark}}</th>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
