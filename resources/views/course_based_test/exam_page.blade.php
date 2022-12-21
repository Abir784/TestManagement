
@extends('dashboard.haeder')

@section('content')


<div class="container-fluid page__container">
    <div class="mb-6 float-end">
        <h5>Time Left:</h5>
       <h6><p id="timer" class="float-end"></p></h6>
    </div>
    <div id="questions_wrapper">

    <form id="exam_form" action="{{route('student.exam.post')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="quiz_id" value="{{$id}}">
        <input type="hidden" name="quiz_type" value="2">


        @foreach ($questions as $key=>$question )


        <input type="hidden" name="question_id[]" value="{{$question->question_id}}">
        <div class="card mb-4" data-position="1" data-question-id="1">
            <div class="card-header d-flex justify-content-between">

                <div class="d-flex align-items-center ">

                    <span class="question_handle btn btn-sm btn-secondary">
                        <i class="material-icons">menu</i>
                    </span>
                    <div class="h4 m-0 ml-4">Q {{$key+1}}: {!! $question->rel_to_question->title !!}</div>
                </div>
            </div>
            <div class="card-body">

                <div id="answerWrapper_1" class="mb-4">
                    <div class="row mb-1">
                        <div class="col"><strong></strong></div>
                        <div class="col text-right"><strong></strong></div>
                    </div>
                    @if ($question->rel_to_question->type =='MCQ')
                    <ul class="list-group" id="answer_container_1">
                        @foreach (App\Models\QuestionOptions::where('question_id',$question->rel_to_question->id)->get() as $options)

                        <li class="list-group-item d-flex" data-position="1" data-answer-id="1" data-question-id="1">
                            <span class="mr-2"><i class="material-icons text-light-gray">menu</i></span>
                            <div>
                               {{$options->option_title}}
                            </div>
                            <div class="ml-auto">
                                <input type="checkbox" name="answer_.{{$question->question_id}}[]" value="{{$options->id}}">
                            </div>
                        </li>
                        @endforeach

                    </ul>

                    @elseif ($question->rel_to_question->type =="DESC")
                      <textarea class="form-control" name="answer_.{{$question->question_id}}"></textarea>
                    @elseif ($question->rel_to_question->type == "MATCH")
                      @php
                      $option_count=count(App\Models\QuestionOptions::where('question_id',$question->rel_to_question->id)->get());
                      @endphp
                      @for ($i=1;$i<=$option_count;$i++)
                            <div class="mt-3">

                            {{'Answer No.'.$i}} <input class="form-control" type="text" name="answer_.{{$question->question_id}}[]">
                            </div>
                      @endfor
                    @elseif ($question->rel_to_question->type == "FILL")

                    @php
                    $option_count=count(App\Models\QuestionOptions::where('question_id',$question->rel_to_question->id)->get());
                    @endphp
                    @for ($i=1;$i<=$option_count;$i++)
                          <div class="mt-3">

                          {{'Answer No.'.$i}} <input class="form-control" type="text" name="answer_.{{$question->question_id}}[]">
                          </div>
                    @endfor


                    @endif



                </div>
            </div>
        </div>
        @endforeach
        <div class="mb-3">
            <button type="submit" class="btn btn-success">Submit</button>

        </div>

    </form>


    </div>
</div>


</div>
<!-- // END drawer-layout__content -->

<div class="mdk-drawer  js-mdk-drawer" id="default-drawer" data-align="start">
<div class="mdk-drawer__content">
    <div class="sidebar sidebar-light sidebar-left bg-white" data-perfect-scrollbar>


        <div class="sidebar-block p-0 m-0">
            <div class="d-flex align-items-center sidebar-p-a border-bottom bg-light">
                <a href="#" class="flex d-flex align-items-center text-body text-underline-0">
                    <span class="avatar avatar-sm mr-2">
                        <span class="avatar-title rounded-circle bg-soft-secondary text-muted">AD</span>
                    </span>
                    <span class="flex d-flex flex-column">
                        <strong>Adrian Demian</strong>
                        <small class="text-muted text-uppercase">Instructor</small>
                    </span>
                </a>
                <div class="dropdown ml-auto">
                    <a href="#" data-toggle="dropdown" data-caret="false" class="text-muted"><i class="material-icons">more_vert</i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="student-dashboard.html">Dashboard</a>
                        <a class="dropdown-item" href="student-profile.html">My profile</a>
                        <a class="dropdown-item" href="student-edit-account.html">Edit account</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" rel="nofollow" data-method="delete" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('js_code')
<script>
  const myTimeout = setTimeout(myGreeting, {{$time}}*60000);

        function myGreeting() {

            // window.location.replace("/student/CourseBased/Quiz/timeout/"+{{$id}});
            document.getElementById("exam_form").submit();

        }
</script>
<script>
    setInterval(displayHello, 1000);
    var start={{$time}}*60;


    function displayHello() {
       start-=1;
      document.getElementById("timer").innerHTML = start+" Seconds";
    }
    </script>
@endsection
