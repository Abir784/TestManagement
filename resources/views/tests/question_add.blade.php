@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Questions(Specific)</h5>
                    <p class="card-text">

                        <form action="{{route('independent.specific.quiz.question.post')}}" method="POST" enctype="multipart/form-data" >
                          @csrf
                          <div class="mb-3 form-group">
                            <input type="hidden" name="quiz_id" value="{{$id}}">
                            <label for="" class="form-lable">Select Question Subject </label>
                            <select name="subject_id" class="form-control form-control-rounded" id="subjectid">
                                <option value="">--select subject--</option>
                                @foreach ($subjects as $subject )
                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                                @endforeach
                            </select>
                            @error('subject_id')
                            <b class="text-red">{{$message}}</b>
                            @enderror
                        </div>


                        <div class="mb-3 form-group">
                            <label for="" class="form-lable">Select Module </label>
                            <select name="module_id" class="form-control form-control-rounded" id="module_id">
                                <option value="">--Select module--</option>
                            </select>
                            @error('module_id')
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
        <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Questions(Random)</h5>
                        <p class="card-text">

                            <form action="{{route('independent.quiz.question.post')}}" method="POST" enctype="multipart/form-data" >
                              @csrf
                              <div class="mb-3 form-group">
                                <input type="hidden" name="quiz_id" value="{{$id}}">
                                <label for="" class="form-lable">Select Question Subject </label>
                                <select name="subject_id" required class="form-control form-control-rounded" id="subjectid2">
                                    <option value="">--select subject--</option>
                                    @foreach ($subjects as $subject )
                                    <option value="{{$subject->id}}">{{$subject->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-lable">Select Module </label>
                                <select name="module_id" required  class="form-control form-control-rounded" id="module_id2">
                                    <option value="">--Select module--</option>
                                </select>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="">Question Number</label>
                                <input type="number" required  value="" name="q_no" class="form-control" >

                            </div>
                            @if (session('error'))
                            <div class="alert alert-danger">{{session('error')}}</div>

                            @endif
                            <div class="mb-3 form-group">
                                <button class="btn btn-success btn-rounded">Submit</button>
                            </div>

                            </form>

                        </p>
                    </div>
                </div>
        </div>
    </div>

</div>
@endsection
@section('js_code')
<script>
    $('#subjectid').change(function(){
        var subject_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

     $.ajax({
        type:'POST',
        url:'/getModule',
        data:{'subject_id':subject_id},
        success:function(data){
            $('#module_id').html(data);
        }
    });
})
</script>

<script>
    $('#subjectid2').change(function(){
        var subject_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

     $.ajax({
        type:'POST',
        url:'/getModule',
        data:{'subject_id':subject_id},
        success:function(data){
            $('#module_id2').html(data);
        }
    });
})
</script>
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
       title: 'Question Added successfully'
    })
   </script>
@endif

@endsection
