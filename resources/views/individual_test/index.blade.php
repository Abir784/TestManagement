
@extends('dashboard.haeder')

@section('content')
<div class="container-flex">
    <div class="row">
        <div class="col-lg-8">
            <div class="card-header"></div>
            <div class="card-body">
                <table class="table table-light">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Quiz Name</th>
                            <th>Full Marks</th>

                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (App\Models\IndividualTest::all() as $key=>$test)

                        @php
                        $questions=App\Models\IndividualTestQuestion::where('quiz_id',$test->id)->get();
                        $full_marks=0;
                        foreach ($questions as $question) {
                            $full_marks+=$question->rel_to_question->total_marks;
                        }


                    @endphp
                        <tr>
                            <td>{{$key+1 }}</td>
                            <td>{{ $test->name}}</td>
                            <td>{{ $full_marks}}</td>

                            <td>@if (($test->start_date > Carbon\Carbon::now()->format('Y-m-d') && $test->start_time >  Carbon\Carbon::now()->format('H:i:s')) || $test->start_date > Carbon\Carbon::now()->format('Y-m-d'))
                                {{'Starts at '.Carbon\Carbon::parse($test->start_date)->format('d-M-Y').','.Carbon\Carbon::parse($test->start_time)->format('h:i A')}}
                              @elseif (($test->start_date <= Carbon\Carbon::now()->format('Y-m-d') && $test->start_time <=  Carbon\Carbon::now()->format('H:i:s')) && ($test->end_date >= Carbon\Carbon::now()->format('Y-m-d') && $test->end_time > Carbon\Carbon::now()->format('H:i:s')) || ($test->end_date >= Carbon\Carbon::now()->format('Y-m-d')) )
                                {{'Exam Ongoing'}}
                              @else
                               {{'Expired'}}

                              @endif
                            </td>
                            <td><a href="{{route('individual.test.question.index',$test->id)}}" class="btn btn-outline-primary btn-rounded mb-2"> Add<br>Questions</a>
                            <a href="{{route('quiz.individual.question.show',$test->id)}}" class="btn btn-outline-warning btn-rounded mb-2"> Show<br>Questions</a>
                            <a href="{{route('individual.student.index',$test->id)}}" class="btn btn-outline-success btn-rounded mb-2">Add<br>Students</a>
                            {{-- <a href="{{route('individualquiz.delete',$test->id)}}" class="btn btn-outline-danger btn-rounded mb-2">Delete</a> --}}
                            <a href="{{route('individualquiz.edit',$test->id)}}" class="btn btn-outline-secondary btn-rounded mb-2">Edit</a>
                            </td>


                        </tr>

                        @empty
                        <tr>
                            <td colspan="5">No Tests Created Yet</td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>

            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">

                <div class="card-body">
                    <div class="card-title">
                        <h3 class="m-auto">Create Individual Test</h3>
                      </div>
                        <form action="{{route('indiviual_test.post')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Test Title:</label>
                                <input value="{{old('name')}}" type="text" required name="name" class="form-control form-control-rounded">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Introduction Text:</label>
                                <input value="{{old('introduction_text')}}"  type="text" required name="introduction_text" class="form-control form-control-rounded">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Passing Comment:</label>
                                <input value="{{old('passing_comment')}}" type="text" required name="passing_comment" class="form-control form-control-rounded">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Fail Comment:</label>
                                <input type="text" value="{{old('failing_comment')}}"required name="failing_comment" class="form-control form-control-rounded">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Time:(Minutes)</label>
                                <input type="integer" value="{{old('time')}}"  required name="time" class="form-control form-control-rounded">
                            </div>
                            <div class="row form-group">
                                <div class="m-3 form-group">
                                    <label for="" class="form-label">Start Date:</label>
                                    <input type="date" value="{{old('start_date')}}" required name="start_date" class="form-control form-control-rounded">
                                </div>

                                <div class="m-3 form-group">
                                    <label for="" class="form-label">Start time:</label>
                                    <input type="time" value="{{old('start_time')}}" required name="start_time" class="form-control form-control-rounded">
                                </div>

                                <div class="m-3 form-group">
                                    <label for="" class="form-label">End Date:</label>
                                    <input type="date" value="{{old('end_date')}}" required name="end_date" class="form-control form-control-rounded">
                                </div>

                                <div class="m-3 form-group">
                                    <label for="" class="form-label">End time:</label>
                                    <input type="time" value="{{old('end_time')}}" required name="end_time" class="form-control form-control-rounded">
                                </div>
                            </div>

                          
                            <div class="m-3 form-group">
                                <button type="submit" class="btn btn-success btn-rounded">Submit</button>
                            </div>
                        </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_code')

@if (session('success'))

<script>
 const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 2500,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
Toast.fire({
  icon: 'success',
  title: 'Quiz Added successfully'
})
</script>


@endif

@if (session('update'))

<script>
 const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 2500,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
Toast.fire({
  icon: 'success',
  title: 'Quiz Updated successfully'
})
</script>


@endif


@endsection
