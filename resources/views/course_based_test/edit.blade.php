@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><h3>Postpone Course Based Quiz</h3></h5>
                </div>
                <div class="card-body">
                    <form action="{{route('course_based_quiz.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$quiz->id}}" >
                        <div class="row form-group">
                            <div class="m-3 form-group">
                                <label for="" class="form-label"> New Start Date:</label>
                                <input type="date" value="{{$quiz->start_date}}" required name="start_date" class="form-control form-control-rounded">
                            </div>

                            <div class="m-3 form-group">
                                <label for="" class="form-label">New Start time:</label>
                                <input type="time" value="{{$quiz->start_time}}" required name="start_time" class="form-control form-control-rounded">
                            </div>

                            <div class="m-3 form-group">
                                <label for="" class="form-label">New End Date:</label>
                                <input type="date" value="{{$quiz->end_date}}" required name="end_date" class="form-control form-control-rounded">
                            </div>

                            <div class="m-3 form-group">
                                <label for="" class="form-label">New End time:</label>
                                <input type="time" value="{{$quiz->end_time}}" required name="end_time" class="form-control form-control-rounded">
                            </div>
                            <div class="m-3 form-group">
                                <label for="" class="form-label">Reason/Remarks:</label>
                                <input type="text" class="form-control form-control-rounded" name="reason">
                            </div>
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
