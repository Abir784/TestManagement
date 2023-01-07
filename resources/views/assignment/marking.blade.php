@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><b class="m-auto">Assignment Marking</b></h5>
                    <div class="mb-3">
                        Student Name: {{$script->rel_to_student->name}} <br>
                        <a href="{{asset('assets/uploads/assignment_submissions/'.$script->file_name)}}">Download Script</a>
                    </div>

                    <form action="{{route('assignment.marking.post')}}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <input type="hidden" name="id" value="{{$script->id}}">
                        <div class="mb-3">
                            <label for="" class="form-label">Mark</label>
                            <input type="integer" name="mark" id="" class="form-control">
                        </div>
                        @if (session('error'))
                          <p class="m-auto text-danger">{{session('error')}}</p>

                        @endif
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
