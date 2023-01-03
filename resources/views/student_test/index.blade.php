@extends('dashboard.haeder')
@section('content')
  <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <p class="card-text">Free Tests</p>
                    <div class="row">
                        @php
                            $student=App\Models\Student::where('user_id',Auth::id())->first();

                        @endphp
                        @forelse ($independent_quiz as $quiz )
                        <div class="col-md-3">
                            @if (App\Models\IndependentTestResult::where('student_id',$student->id ?? 0)->where('quiz_id',$quiz->id ?? 0)->doesntExist())
                            <div class="card card__course">
                                <div class="card-header card-header-large card-header-dark bg-success d-flex justify-content-center">
                                    <a class="card-header__title  justify-content-center align-self-center d-flex flex-column" href="student-course.html">
                                        <span></span>
                                        <span class="course__title">{{$quiz->name}}</span>
                                        <span class="course__subtitle">{{$quiz->introduction_text}}</span>
                                    </a>
                                </div>
                                <div class="p-3">
                                    <div class="mb-2">
                                    Start Time: {{Carbon\Carbon::parse($quiz->start_date)->format('d-M')}} | {{Carbon\Carbon::parse($quiz->start_time)->format('h:i A')}}<br>
                                    End Time: {{Carbon\Carbon::parse($quiz->end_date)->format('d-M')}} | {{Carbon\Carbon::parse($quiz->end_time)->format('h:i A')}}

                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="{{route('student.exam.index',$quiz->id)}}" class="btn btn-primary ml-auto">Take Quiz</a>
                                    </div>
                                </div>
                            </div>
                        @else

                        <div class="card card__course">
                            <div class="card-header card-header-large card-header-dark bg-success d-flex justify-content-center">
                                <a class="card-header__title  justify-content-center align-self-center d-flex flex-column" href="student-course.html">
                                    <span></span>
                                    <span class="course__title">{{$quiz->name}}</span>
                                    <span class="course__subtitle">{{$quiz->introduction_text}}</span>
                                </a>
                            </div>
                            <div class="p-3">
                                <div class="mb-2">


                                </div>
                                <div class="d-flex align-items-center">
                                    Exam Taken Already
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @empty
                    <p class="m-auto">No Tests for today.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
  </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <p class="card-text">Course Based Tests</p>
                    <div class="row">

                                @forelse ($course_based_quiz as $quiz )
                                @if (App\Models\CourseBasedTestResult::where('student_id',$student->id)->where('quiz_id',$quiz->id)->doesntExist())
                                <div class="col-md-3">
                                    <div class="card card__course">
                                        <div class="card-header card-header-large card-header-dark bg-danger d-flex justify-content-center">
                                            <a class="card-header__title  justify-content-center align-self-center d-flex flex-column" href="#">
                                                <span></span>
                                                <span class="course__title">{{$quiz->name}}</span>
                                                <span class="course__subtitle">{{$quiz->introduction_text}}</span>
                                            </a>
                                        </div>
                                        <div class="p-3">
                                            <div class="mb-2">
                                            Start Time: {{Carbon\Carbon::parse($quiz->start_date)->format('d-M')}} | {{Carbon\Carbon::parse($quiz->start_time)->format('h:i A')}}<br>
                                            End Time: {{Carbon\Carbon::parse($quiz->end_date)->format('d-M')}} | {{Carbon\Carbon::parse($quiz->end_time)->format('h:i A')}}

                                            </div>
                                            <div class="d-flex align-items-center">
                                                <a href="{{route('student.course_based.exam.index',$quiz->id)}}" class="btn btn-primary ml-auto">Take Quiz</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @else

                                <div class="col-md-3">
                                    <div class="card card__course">
                                        <div class="card-header card-header-large card-header-dark bg-danger d-flex justify-content-center">
                                            <a class="card-header__title  justify-content-center align-self-center d-flex flex-column" href="student-course.html">
                                                <span></span>
                                                <span class="course__title">{{$quiz->name}}</span>
                                                <span class="course__subtitle">{{$quiz->introduction_text}}</span>
                                            </a>
                                        </div>
                                        <div class="p-3">
                                            <div class="mb-2">
                                            Start Time: {{Carbon\Carbon::parse($quiz->start_date)->format('d-M')}} | {{Carbon\Carbon::parse($quiz->start_time)->format('h:i A')}}<br>
                                            End Time: {{Carbon\Carbon::parse($quiz->end_date)->format('d-M')}} | {{Carbon\Carbon::parse($quiz->end_time)->format('h:i A')}}

                                            </div>
                                            <div class="d-flex align-items-center">
                                                Exam Taken Already
                                                </div>
                                        </div>
                                   </div>
                                </div>
                                @endif

                                @empty
                                <p class="m-auto">No Tests for today.</p>
                                @endforelse
                          </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <p class="card-text">Individual Tests</p>
                    <div class="row">
                                @php
                                    $student=App\Models\Student::where('user_id',Auth::id())->first();
                                @endphp
                                @forelse ($invidual_test as $quiz )
                                @if(App\Models\IndividualTestStudents::where('quiz_id',$quiz->id)->where('student_id',$student->id)->exists())
                                @if (App\Models\InvidualTestResult::where('student_id',$student->id)->where('quiz_id',$quiz->id)->doesntExist())
                                <div class="col-md-3">
                                    <div class="card card__course">
                                        <div class="card-header card-header-large card-header-dark bg-warning d-flex justify-content-center">
                                            <a class="card-header__title  justify-content-center align-self-center d-flex flex-column" href="student-course.html">
                                                <span></span>
                                                <span class="course__title">{{$quiz->name}}</span>
                                                <span class="course__subtitle">{{$quiz->introduction_text}}</span>
                                            </a>
                                        </div>
                                        <div class="p-3">
                                            <div class="mb-2">
                                            Start Time: {{Carbon\Carbon::parse($quiz->start_date)->format('d-M')}} | {{Carbon\Carbon::parse($quiz->start_time)->format('h:i A')}}<br>
                                            End Time: {{Carbon\Carbon::parse($quiz->end_date)->format('d-M')}} | {{Carbon\Carbon::parse($quiz->end_time)->format('h:i A')}}

                                            </div>
                                            <div class="d-flex align-items-center">
                                                <a href="{{route('student.individual.exam.index',$quiz->id)}}" class="btn btn-primary ml-auto">Take Quiz</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    @else
                                <div class="col-md-3">
                                    <div class="card card__course">
                                        <div class="card-header card-header-large card-header-dark bg-warning d-flex justify-content-center">
                                            <a class="card-header__title  justify-content-center align-self-center d-flex flex-column" href="student-course.html">
                                                <span></span>
                                                <span class="course__title">{{$quiz->name}}</span>
                                                <span class="course__subtitle">{{$quiz->introduction_text}}</span>
                                            </a>
                                        </div>
                                        <div class="p-3">
                                            <div class="mb-2">
                                            Start Time: {{Carbon\Carbon::parse($quiz->start_date)->format('d-M')}} | {{Carbon\Carbon::parse($quiz->start_time)->format('h:i A')}}<br>
                                            End Time: {{Carbon\Carbon::parse($quiz->end_date)->format('d-M')}} | {{Carbon\Carbon::parse($quiz->end_time)->format('h:i A')}}

                                            </div>
                                            <div class="d-flex align-items-center">
                                                Exam Taken Already
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @else
                                   <p class="m-auto">No tests for today</p>
                                @endif
                                @empty
                                <p class="m-auto">No Tests for today.</p>
                                @endforelse
                    </div>
                    </div>
                </div>
            </div>
        </div>


  </div>
</div>


@endsection


