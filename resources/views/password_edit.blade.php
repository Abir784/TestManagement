@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Change Password</h5>
                    <p class="card-text">
                        <form action="{{route('student_edit_individual.update')}}" method="POST">

                            @csrf
                            @if (session('success'))
                              <div class="alert alert-primary">
                                  {{session('success')}}

                              </div>

                            @endif
                            <input type="hidden" name="id" id="" value="{{$admin->id}}">
                            <div class="mb-3">
                                <label for="" class="form-label">Name:</label>
                                <input type="text" class="form-control" value="{{$admin->name}}" readonly id="">

                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Email</label>
                                <input type="email" readonly class="form-control" value="{{$admin->email}}" id="">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Enter Old Password</label>
                                <input type="password" name="old_password" class="form-control" required value="" id="">
                                @error('old_password')

                                {{$message}}
                             @enderror
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control" required value="" id="">
                                @error('password')

                                  {{$message}}
                               @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required value="" id="">
                                @error('password_confirmation')

                                   {{$message}}
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="sumbit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
