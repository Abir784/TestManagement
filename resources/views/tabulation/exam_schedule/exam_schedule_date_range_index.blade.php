@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Exam Schedule [Date Range]</h5>
                    <p class="card-text">
                     <form action="{{url('admin/course_wise_exam_date_range_schedule/post')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">From Date:</label>
                            <input type="date" class="form-control" name="from">
                            @error('from')
                              <p class="text-danger">{{$message}}</p>

                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="" class="form-label">To Date:</label>
                            <input type="date" class="form-control" name="to">
                            @error('to')
                            <p class="text-danger">{{$message}}</p>

                          @enderror
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>


                     </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
