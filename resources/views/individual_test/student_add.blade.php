@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <a href="{{url('admin/index/invidual_test')}}" class="btn btn-primary mb-2"> Back</a>
                    <h4 class="card-title">Student List</h4>
                    <table class="table table-light">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse (App\Models\IndividualTestStudents::where('quiz_id',$id)->get() as $key=>$students )
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$students->student_name->name}}</td>
                                <td><a href="" class="btn btn-danger">Delete</a></td>
                            </tr>

                            @empty
                            <tr>
                                <td>No data found</td>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title"><h5>Add Students</h5></div>
                    <form action="{{route('individual.student.post')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control form-control-rounded" value="{{$id}}"  name="quiz_id">

                        <div class="mb-3 form-group">
                            <label for="" class="form-label">Enter Registration No./Email:</label>
                            <input type="text" class="form-control form-control-rounded" value="{{old('student_id')}}" name="student_id">
                            @if (session('error'))
                            <p class="text-danger mt-2"> {{session('error')}}</p>
                          @endif
                        </div>

                        <div class="mb-3 form-group">
                            <button type="submit" class="btn btn-danger btn-danger-rounded">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
