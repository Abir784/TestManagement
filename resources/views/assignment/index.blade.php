
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
                            <th>Assignment Title</th>
                            <th>Course Name</th>
                            <th>Batch Name</th>
                            <th>Deadline</th>
                            <th>Full Marks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (App\Models\CoursedBasedAssignment::all() as $key=>$test)
                        <tr>
                            <td>{{$key+1 }}</td>
                            <td>{{ $test->title}}</td>
                            <td>{{ $test->rel_to_course->name}}</td>
                            <td>{{ $test->rel_to_batch->batch_name}}</td>
                            <td>{{  Carbon\Carbon::parse($test->deadline)->format('d-M-y')}}</td>
                            <td>{{ $test->full_marks}}</td>
                            <td>
                                    <a href="#" class="btn btn-danger btn-rounded">Delete</a>
                            </td>



                        </tr>

                        @empty
                        <tr>
                            <td colspan="5">No Assignment Created Yet</td>
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
                        <form action="{{route('course_based_assigmnet.post')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Assignment Title:</label>
                                <input type="text" value="{{old('name')}}" required name="name" class="form-control form-control-rounded">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Course Name:</label>
                                <select name="course_id"  id="course_id" class="form-control form-control-rounded" id="">
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
                                <label for="" class="form-label">Upload File:</label>
                                <input type="file" name="file" class="form-control form-control-rounded" id="">
                            </div>
                            @error('file')
                              <p class="text-danger">{{$message}}</p>

                            @enderror
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">
                                    Deadline
                                </label>
                                <input type="date" value="{{old('deadline')}}" name="deadline" class="form-control form-control-rounded" id="">
                            </div>


                            <div class="m-3 form-group">
                                <label for="" class="form-label">Full Marks:</label>
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
  title: ' Added successfully'
})
</script>
@endif

@endsection
