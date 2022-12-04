@extends('dashboard.haeder')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-14">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Student List</h3><br>
                    </div>

                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Registration no.</th>
                            <th>Phone no.</th>
                            <th>Course Name</th>
                            <th>Batch Name</th>
                            <th>Enrolled At</th>
                            <th>Action</th>
                        </tr>

                        @forelse ($students as $key=>$student )
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$student->name}}</td>
                            <td>{{$student->email}}</td>
                            <td>{{$student->registration_no}}</td>
                            <td>{{$student->phone_no}}</td>
                            <td>{{$student->course_name->name}}</td>
                            <td>{{$student->batch_name->batch_name}}</td>
                            <td>{{($student->created_at)->format('d M,Y')}}</td>
                            <td>
                                <a href="{{route('student.delete', $student->user_id)}}" class="mr-2 btn btn-outline-danger btn-rounded show_confirm"> Delete</a>
                                {{-- <a href="#" class="mr-2 btn btn-outline-info btn-rounded show_confirm"> Edit</a> --}}
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="9"> No data to show</td>
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
@if(session('success'))
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
