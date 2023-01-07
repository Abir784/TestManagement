@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><h3>Edit Individual Quiz</h3></h5>
                </div>
                <div class="card-body">
                    <form action="{{route('individualquiz.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$quiz->id}}" >
                        <div class="mb-3 form-group">
                            <label for="" class="form-label">Test Title:</label>
                            <input type="text" required name="name" value="{{$quiz->name}}" class="form-control form-control-rounded">
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" class="form-label">Introduction Text:</label>
                            <input type="text" required value="{{$quiz->introduction_text}}" name="introduction_text" class="form-control form-control-rounded">
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" class="form-label">Passing Comment:</label>
                            <input type="text" required value="{{$quiz->passing_comments}}" name="pass_comment" class="form-control form-control-rounded">
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" class="form-label">Fail Comment:</label>
                            <input type="text" required value="{{$quiz->failing_comments}}" name="failing_comment" class="form-control form-control-rounded">
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" class="form-label">Time(In Minutes):</label>
                            <input type="integer" required name="time" value="{{$quiz->time}}" class="form-control form-control-rounded">
                        </div>

                        <div class="row form-group">
                            <div class="m-3 form-group">
                                <label for="" class="form-label">Start Date:</label>
                                <input type="date" value="{{$quiz->start_date}}" required name="start_date" class="form-control form-control-rounded">
                            </div>

                            <div class="m-3 form-group">
                                <label for="" class="form-label">Start time:</label>
                                <input type="time" value="{{$quiz->start_time}}" required name="start_time" class="form-control form-control-rounded">
                            </div>

                            <div class="m-3 form-group">
                                <label for="" class="form-label">End Date:</label>
                                <input type="date" value="{{$quiz->end_date}}" required name="end_date" class="form-control form-control-rounded">
                            </div>

                            <div class="m-3 form-group">
                                <label for="" class="form-label">End time:</label>
                                <input type="time" value="{{$quiz->end_time}}" required name="end_time" class="form-control form-control-rounded">
                            </div>
                        </div>

                        <div class="m-3 form-group">
                            <label for="" class="form-label">Pass Marks:</label>
                            <input type="number" required value="{{$quiz->pass_marks}}"name="pass_marks" class="form-control form-control-rounded">
                        </div>
                        <div class="m-3 form-group">
                            <button type="submit" class="btn btn-success btn-rounded">Submit</button>
                        </div>
                    </form>

                </div>



            </div>
        </div>
    </div>
</div>

@endsection
