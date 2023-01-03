@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Student Name: {{$script->rel_to_student->name}}</h5>
                    <p class="card-text">
                        @if (session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>

                        @endif
                    </p>
                    <form action="{{route('individual.marking.post')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" name="id" value="{{$script->id}}">
                            <label for="" class="form-label"> Question Title:</label>
                             <b>{{$script->rel_to_question->title}}</b>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Answer:</label>
                            <textarea  readonly class="form-control"> {{$script->answer}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Marks Obtained</label>
                            <input type="text" id="mark" name="mark" value="{{$script->mark}}"  class="form-control">
                            <div class="mb-2">
                                <p class="text-danger" id="error">{{session('error')}}</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" id="button" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

