@extends('dashboard.haeder')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Assignments</h5>
                    <div class="row">
                    @forelse ($assignments as $assignment )

                    <div class="col-md-3">
                        <div class="card card__course">
                            <div class="card-header card-header-large card-header-dark bg-warning d-flex justify-content-center">
                                <a class="card-header__title  justify-content-center align-self-center d-flex flex-column" href="">
                                    <span></span>
                                    <span class="course__title">{{$assignment->title}}</span>
                                    <span class="course__subtitle">{{$assignment->full_marks}}</span>
                                </a>
                            </div>
                        @if (App\Models\CourseBasedAssignmentSubmission::where('student_id',$student['id'])->where('assignment_id',$assignment->id)->exists())
                        <div class="p-3">
                            <div class="d-flex align-items-center">
                               <b>Submitted</b>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="p-3">
                        <div class="mb-2">
                            Deadline:{{Carbon\Carbon::parse($assignment->deadline)->format("d-M-y")}}
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="{{asset('assets/uploads/assignments/'.$assignment->file_name)}}" download="" class="btn btn-primary m-2">Download</a>
                            <a href="{{ route('assignment.student.index',$assignment->id)}}" class="btn btn-warning m-2">Submit</a>
                        </div>
                    </div>
                </div>

                    @endif
                   </div>
                    @empty
                      <p class="m-auto">No Assignments for today</p>
                    @endforelse
                </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
