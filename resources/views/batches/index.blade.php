
@extends('dashboard.haeder')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header bg-default">
                    <h3>{{'Add Batches'}}
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{route('batch.create')}}" method="POST">
                        @csrf
                        <div class="mb-3 form-group">

                            <label for="" class="form-label">
                                <b>Batch Name</b>
                            </label>
                            <input type="text" name="batch_name" class="form-control form-control-rounded">
                            @error('batch_name')
                            <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Course Name:</b>
                            </label>
                            <select name="course_id" id="" class="form-control form-control-rounded">
                                <option value="">--Select Course Name--</option>
                                @forelse ($courses as $course )
                                  <option value="{{$course->id}}"> {{$course->name}}</option>
                                @empty

                                <option value=""> No Courses Added Yet</option>

                                @endforelse
                            </select>
                            @error('course_id')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>

                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Start Date:</b>
                            </label>
                            <input type="date" class="form-control form-control-rounded" name="start_date" >
                            @error('start_date')
                                <b class="mb-2 text-danger">{{$message}}</b>
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
  title: 'Batch Added successfully'
})
</script>
@endif

@endsection
