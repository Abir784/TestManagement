
@extends('dashboard.haeder')

@section('content')
<div class="container">
    <div class="row">



        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">
                    <div class="card-title">
                        <h3>{{'Edit Student Information'}}
                        </h3>
                    </div>
                    <form action="{{route('student.update')}}" method="POST">
                        @csrf
                        <div class="mb-3 form-group">

                            <input type="hidden" name="user_id" value="{{$student->user_id}}">
                            <label for="" class="form-label">
                                <b>Student Name:</b>
                            </label>
                            <input type="text" value="{{$student->name}}" required name="name" class="form-control form-control-rounded">
                            @error('name')
                            <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Email:</b>
                            </label>
                            <input type="email" value="{{$student->email}}" required name="email" class="form-control form-control-rounded" required>
                            @error('email')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>

                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Registration No:</b>
                            </label>
                            <input type="text" value="{{$student->registration_no}}" required name="registration_no" class="form-control form-control-rounded" required>
                            @error('registration_no')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Phone No:</b>
                            </label>
                            <input type="text" value="{{$student->phone_no}}"  required name="phone_no" class="form-control form-control-rounded" required>
                            @error('phone_no')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>

                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>New Password:</b>
                            </label>
                            <input type="password" class="form-control form-control-rounded" name="password">
                            @error('country')
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
  title: 'Student Updated successfully'
})
</script>
@endif

@endsection
