
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
                            <th>Course Name</th>
                            <th>Batch Name</th>
                            <th>Pass Marks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (App\Models\CourseBasedTest::all() as $key=>$test)
                        <tr>
                            <td>{{$key+1 }}</td>
                            <td>{{ $test->name}}</td>
                            <td>{{ $test->rel_to_course->name}}</td>
                            <td>{{ $test->rel_to_batch->batch_name}}</td>
                            <td>{{ $test->pass_marks}}</td>
                            <td><a href="{{route('quiz.course_based.question.index',$test->id)}}" class="btn btn-primary mb-2"> Add Questions</a>
                                <a href="{{route('quiz.course_based.question.show',$test->id)}}" class="btn btn-warning mb-2"> Show Questions</a>
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
                <div class="card-header bg-default">
                    <h3 id="q_title">{{'Create Course Based Test'}}
                    </h3>
                </div>
                <div class="card-body">
                        <form action="{{route('course_based_quiz.post')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Test Title:</label>
                                <input type="text" required name="name" class="form-control form-control-rounded">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Course Name:</label>
                                <select name="course_id" id="course_id" class="form-control form-control-rounded" id="">
                                    <option value="">---Select Course Name---</option>
                                    @foreach ($course as $course )
                                    <option value="{{$course->id}}">{{$course->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Batch Name:</label>
                                <select name="batch_id" id="batch_id" class="form-control form-control-rounded" id="">
                                    <option value="">---Select Batch Name---</option>

                                </select>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Introduction Text:</label>
                                <input type="text" required name="introduction_text" class="form-control form-control-rounded">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Passing Comment:</label>
                                <input type="text" required name="passing_comment" class="form-control form-control-rounded">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Fail Comment:</label>
                                <input type="text" required name="failing_comment" class="form-control form-control-rounded">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Time:</label>
                                <input type="integer" required name="time" class="form-control form-control-rounded">
                            </div>
                            <div class="row form-group">
                                <div class="m-3 form-group">
                                    <label for="" class="form-label">Start Date:</label>
                                    <input type="date" required name="start_date" class="form-control form-control-rounded">
                                </div>

                                <div class="m-3 form-group">
                                    <label for="" class="form-label">Start time:</label>
                                    <input type="time" required name="start_time" class="form-control form-control-rounded">
                                </div>

                                <div class="m-3 form-group">
                                    <label for="" class="form-label">End Date:</label>
                                    <input type="date" required name="end_date" class="form-control form-control-rounded">
                                </div>

                                <div class="m-3 form-group">
                                    <label for="" class="form-label">End time:</label>
                                    <input type="time" required name="end_time" class="form-control form-control-rounded">
                                </div>
                            </div>

                            <div class="m-3 form-group">
                                <label for="" class="form-label">Pass Marks:</label>
                                <input type="number" required name="pass_marks" class="form-control form-control-rounded">
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
