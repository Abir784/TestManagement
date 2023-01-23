
@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>{{'Edit Administrators'}}
                        </h3>
                    </div>
                    <form action="{{route('admin.update')}}" method="POST">
                        <input type="hidden" value="{{$id}}" name="id">
                        @csrf
                        <div class="mb-3 form-group">

                            <label for="" class="form-label">
                                <b>Name:</b>
                            </label>
                            <input type="text" value="{{ $admin->name }}" name="name" class="form-control form-control-rounded">
                            @error('name')
                            <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Email:</b>
                            </label>
                            <input type="email" value="{{  $admin->email }}" name="email" class="form-control form-control-rounded" required>
                            @error('email')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>

                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Role:</b>
                            </label>
                            <select name="role" id="" class="form-control form-control-rounded" required>
                                <option value="{{  $admin->role }}">---Select Role---</option>

                                <option value="1">Admin</option>
                                <option value="3">Instructor</option>
                            </select>
                            @error('role')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Password</b>
                            </label>
                            <input type="text" name="password" class="form-control form-control-rounded" >
                            @error('password')
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
  title: 'Successfully Upadated'
})
</script>
@endif

@endsection
