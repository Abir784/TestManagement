@extends('dashboard.haeder')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header"><h3>Course List</h3></div>
                <div class="card-body">

                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>Course Name</th>
                            <th>Course Code</th>
                            <th>Number Of Exams</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>

                        @forelse ($course_info as $key=>$course )

                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$course->name}}</td>
                            <td>{{$course->course_code}}</td>
                            <td>{{$course->number_of_exams}}</td>
                            <td>{{($course->created_at)->format('d M,Y')}}</td>
                            <td>
                                <a href="{{route('course.delete', $course->id)}}" class="mr-2 btn btn-outline-danger btn-rounded show_confirm"> Delete</a>
                                <a href="{{route('course.edit', $course->id)}}" class="mr-2 btn btn-outline-info btn-rounded show_confirm"> Edit</a>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5"> No data to show</td>
                        </tr>

                        @endforelse


                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js_code')
@if(session('sucess'))
<script>
$(document).ready(function(){
    Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'Your data has been deleted',
  showConfirmButton: false,
  timer: 2500
})
});
</script>
@endif
@endsection
