
@extends('dashboard.haeder')

@section('content')
<div class="container">
    <div class="row">



        <div class="col-lg-8">
            <div class="card">

                <div class="card-body">
                    <div class="card-title">
                        <h3>{{'Add Students'}}
                        </h3>
                    </div>
                    <form action="{{route('add_student.post')}}" method="POST">
                        @csrf
                        <div class="mb-3 form-group">

                            <label for="" class="form-label">
                                <b>Student Name:</b>
                            </label>
                            <input type="text" value="{{ old('name') }}" name="name" class="form-control form-control-rounded">
                            @error('name')
                            <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Email:</b>
                            </label>
                            <input type="email" value="{{ old('email') }}" name="email" class="form-control form-control-rounded" required>
                            @error('email')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>

                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Registration No:</b>
                            </label>
                            <input type="text" value="{{ old('registration_no') }}" name="registration_no" class="form-control form-control-rounded" required>
                            @error('registration_no')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Phone No:</b>
                            </label>
                            <input type="text" value="{{ old('phone_no') }}"   name="phone_no" class="form-control form-control-rounded" required>
                            @error('phone_no')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Course Name:</b>
                            </label>
                           <select name="course_id" id="course_id" class="form-control form-control-rounded">
                            <option value="">--Select course name--</option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                           </select>
                            @error('course_id')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Batch Name:</b>
                            </label>
                           <select name="batch_id" id="batch_id" class="form-control form-control-rounded">
                            <option value="">--select Batch name--</option>
                           </select>
                            @error('batch_id')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Country:</b>
                            </label>
                           <select name="country" id="" class="form-control form-control-rounded">
                            <option value="">--Select country--</option>
                            @foreach ($country as $country )
                            <option value="{{ $country->name }}">{{ $country->name }}</option>

                            @endforeach
                           </select>
                            @error('country')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>

                        <div class="mb-3 form-group">
                            <button class="btn btn-success btn-rounded" type="submit">Submit</button>

                        </div>
                    </form>


                </div>

            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                       <h3>Bulk Student Upload</h3>
                    </div>
                    <div class="mb-5">
                        <a href="{{route('student.export')}}" class="btn btn-primary float-right">Sample Download</a>
                    </div>
                    <form action="{{route('student.import')}}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                               Course Name:
                            </label>
                           <select name="course_id" id="course_id2" class="form-control form-control-rounded">
                            <option value="">--Select course name--</option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                           </select>
                            @error('course_id')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                Batch Name:
                            </label>
                           <select name="batch_id" id="batch_id2" class="form-control form-control-rounded">
                            <option value="">--select Batch name--</option>
                           </select>
                            @error('batch_id')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Upload a csv file:</label>
                        <input type="file" class="form-control" name="student_file">
                        @error('student_file')
                                <b class="mb-2 text-danger">{{$message}}</b>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>

                    </form>
                </div>

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
    $('#course_id2').change(function(){
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
            $('#batch_id2').html(data);
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
  title: 'Student Added successfully'
})
</script>
@endif

@endsection
