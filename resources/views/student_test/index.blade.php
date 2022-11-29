@extends('dashboard.haeder')
@section('content')
  <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quizzes</h5>
                    <p class="card-text"></p>

                    <div class="row">
                        @forelse ($independent_quiz as $quiz )
                        <div class="col-md-3">
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
                                       Start Time: {{Carbon\Carbon::parse($quiz->start_date)->format('d-M |h:i A')}} <br>
                                       End Time: {{Carbon\Carbon::parse($quiz->end_date)->format('d-M |h:i A')}}

                                    </div>
                                    <div class="d-flex align-items-center">

                                        <a href="{{route('student.exam.index',$quiz->id)}}" class="btn btn-primary ml-auto">Take Quiz</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                      @empty


                      @endforelse
                   </div>



                </div>
            </div>
        </div>
    </div>
  </div>


@endsection
