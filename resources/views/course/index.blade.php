
@extends('dashboard.haeder')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header bg-default">
                    <h3>{{'Add Courses'}}
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{route('course.post')}}" method="POST">
                        @csrf
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Course Name:</b>
                            </label>
                            <input type="text"  name="course_name" id="" class="form-control form-control-rounded ">
                            @error('course_name')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" class="form-label">
                              <b>  Course Code:</b>
                            </label>
                            <input type="text"  name="course_code" id="" class="form-control form-control-rounded ">
                            @error('course_code')
                             <b class="mt-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" class="form-label">
                               <b>Comment</b>
                            </label><br>
                            <textarea name="comment" class="form-control form-control-rounded " id="" ></textarea>
                            @error('comment')
                              <b class="mt-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <button class="btn btn-success btn-rounded" type="submit">Submit</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_code')
@if (session('sucess'))

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
  title: 'Course Added successfully'
})
</script>
@endif

@endsection
