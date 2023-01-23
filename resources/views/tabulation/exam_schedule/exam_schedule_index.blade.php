@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Exam Schedules</h5>
                    <p class="card-text">

                        <form action="{{url('admin/course_wise_exam_schedule/post')}}" method="POST" enctype="multipart/form-data" >
                          @csrf
                          <div class="mb-3 form-group">
                            <label for="" class="form-lable">Select Course </label>
                            <select name="course_id" class="form-control form-control-rounded" id="course_id">
                                <option value="">--Select Course Name--</option>
                                @foreach ($courses as $course )
                                <option value="{{$course->id}}">{{$course->name}}</option>
                                 @endforeach
                            </select>
                            @error('course_id')
                            <b class="text-red">{{$message}}</b>
                            @enderror
                        </div>


                        <div class="mb-3 form-group">
                            <label for="" class="form-lable">Select Batch </label>
                            <select name="batch_id" class="form-control form-control-rounded" id="batch_id">
                                <option value="">--Select Batch Name--</option>
                            </select>
                            @error('batch_id')
                            <b class="text-red">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <button class="btn btn-success btn-rounded">Submit</button>
                        </div>

                     </form>

                    </p>
                </div>
            </div>
        </div>
</div>
@endsection
@section('js_code')
<script>
    $('#course_id').change(function(){
        var course_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

     $.ajax({
        type:'POST',
        url:'/getBatch',
        data:{'course_id':course_id},
        success:function(data){
            $('#batch_id').html(data);
        }
    });
})
</script>

<script>
    $('#batch_id').change(function(){
        var batch_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

     $.ajax({
        type:'POST',
        url:'/getQuiz',
        data:{'batch_id':batch_id},
        success:function(data){
            $('#quiz_id').html(data);
        }
    });
})
</script>




@endsection
