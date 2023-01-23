@extends('dashboard.haeder')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Student List</h3><br>
                    </div>

                    <table class="table table-striped">
                        <tr>

                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>

                        @forelse ($admins as $key=>$admin )
                       @if (!$admin->role == 0)
                        <tr>

                                <td>{{$admin->name}}</td>
                                <td>{{$admin->email}}</td>
                                @if (($admin->role) == 1)
                                <td>Admin</td>
                                @else
                                <td>Instructor</td>
                                @endif

                                <td>
                                    <a href="{{route('admin.delete', $admin->id)}}" class="mr-2 btn btn-outline-danger btn-rounded show_confirm"> Delete</a>
                                    <a href="{{route('admin.edit', $admin->id)}}" class="mr-2 btn btn-outline-info btn-rounded show_confirm"> Edit</a>
                                </td>
                        </tr>
                       @endif
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
