@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Individual Exam Attendance Sheet</h5>
                    <p class="card-text">
                        <form action="{{url('admin/individual_attendance_sheet/post')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Enter Student's Resgistration No\Id:</label>
                                <input type="text" name="student_id" class="form-control">
                                @if (session('error'))
                                  <p class="text-danger">{{session('error')}}</p>
                                @endif
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
