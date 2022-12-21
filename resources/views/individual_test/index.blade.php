
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
                            <th>Pass Marks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (App\Models\IndividualTest::all() as $key=>$test)
                        <tr>
                            <td>{{$key+1 }}</td>
                            <td>{{ $test->name}}</td>
                            <td>{{ $test->pass_marks}}</td>
                            <td><a href="{{route('individual.test.question.index',$test->id)}}" class="btn btn-primary m-2"> Add Questions</a>
                            <a href="{{route('quiz.individual.question.show',$test->id)}}" class="btn btn-warning m-2"> Show Questions</a>
                            <a href="{{route('individual.student.index',$test->id)}}" class="btn btn-success m-2">Add Students</a>
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
                        <h3>Create Individual Test</h3>
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
                                <label for="" class="form-label">Pass Marks:</label>
                                <input type="number" value="{{old('pass_marks')}}" required name="pass_marks" class="form-control form-control-rounded">
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

<script>
    $('#course_id').change(function(){
        var course_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

     $.ajax({
        type:'POST',
        url:'/getBatch',
        data:{'course_id':course_id},
        success:function(data){
            $('#batch_id').html(data);
        }
    });
})
</script>


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

@endsection
