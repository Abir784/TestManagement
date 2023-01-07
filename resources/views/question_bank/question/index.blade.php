
@extends('dashboard.haeder')

@section('content')
<div class="container-flex">


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-default">
                    <h3 id="q_title">{{'Create Matching Questions'}}
                    </h3>
                    <button class="ml-2 btn btn-primary" value="1">MCQ</button>
                    <button class="ml-2 btn btn-primary" value="2">Descriptive</button>
                    <button class="ml-2 btn btn-primary" value="3">Fill in blank</button>
                    <button class="ml-2 btn btn-primary" value="4">Matching</button>
                </div>
                <div class="card-body">
                        <form action="{{route('question.post')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="module_id" value="{{$module_id}}" id="">
                            <div class="fields">
                                <p class='text-danger'>*If there are more than one answers in the question please separate the answers with Hash(#) , if there is partial marking please give the marks for each option in order separated by Hash(#).</p>
                                <input type='hidden' name='type' value='MATCH' >
                                <div class="mb-3 form-group">

                                    <label for=""><b>Create Matching:</b></label>
                                    <textarea name="title" id="editor" class="form-control"></textarea>
                                    @error('title')
                                    <b class="text-danger"> {{$message}} </b>
                                    @enderror
                                </div>

                                <div class="mb-3 form-group">
                                    <label for="" class="form-label">Answers</label>
                                    <input type="text" name="answers" id="" class="form-control form-control-rounded">
                                    @error('answers')
                                    <b class="text-danger"> {{$message}} </b>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label for="" class="form-label"><b>Total Marks:</b></label>
                                    <input type="text" name="marks"  class="form-control">
                                    @error('marks')
                                    <b class="text-danger">  {{$message}} </b>
                                    @enderror
                                </div>
                            </div>

                            <div class='mb-3 form-group'>
                                <button class='btn btn-success btn-rounded' type='submit'>Submit</button>

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
$(document).ready(function(){
    $('button').click(function(){
        var val = $(this).val();
        if (val==1){
            data="<p class='text-danger'>If there are more than one answers in the question please separate the answers with Hash(#) , if there is partial marking please give the marks for each option in order separated by Hash(#).</p><input type='hidden' name='type' value='MCQ' id='><div class='mb-3 form-group'><label for=' class='form-label'><b>Question Title:</b></label><textarea name='title' id='editor1' value='{{ old('title') }}' class='form-control form-control-rounded'></textarea>@error('title')<b class='mb-2 text-danger'>{{$message}}</b> @enderror</div><div class='mb-3 form-group'><label for='' class='form-label'><b>  Options:</b> </label><textarea value='{{ old('option')}}'  name='option' id='editor2' class='form-control form-control-rounded'></textarea>@error('option1')<b class='mt-2 text-danger'>{{$message}}</b>@enderror</div><div class='mb-3 form-group'><label for='' class='form-label'><b> Correct Answers:</b> </label><textarea value='{{ old('correct_answer')}}'  name='correct_answer' id='editor2' class='form-control form-control-rounded'></textarea>@error('correct_answer')<b class='mt-2 text-danger'>{{$message}}</b>@enderror</div><div class='mr-3 form-group'><label class='form-label'><b>Marks:</b></label><input required type='text' name='marks' class='form-control form-control-rounded'></div>"
            $('.fields').html(data);
            $('#q_title').html('Create MCQ Questions')


        }else if (val==2) {
            var data="<input type='hidden' name='type' value='DESC'><div class='m-3 form-group><label class='form-label'><b>Enter Question:</b></label><textarea required id='editor1' type=text name=title class='form-control form-control-rounded'></textarea><div class='mr-3 form-group'><label class='form-label'><b>Marks:</b></label><input type='text' required name='marks' class='form-control form-control-rounded'></div>";
            $('.fields').html(data);
            $('#q_title').html('Create Descriptive Questions')
        }else if(val==3){
            var data="<p class='text-danger'>*If there are more than one answers in the question please separate the answers with Hash(#) , if there is partial marking please give the marks for each option in order separated by Hash(#).</p><input type='hidden' name='type' value='FILL'><div class='m-3 form-group><label class='form-label'><b>Fill in the Blanks:</b></label><textarea required id='editor1' type=text name=title class='form-control form-control-rounded'></textarea><div class='mt-3 form-group'><label class='form-label'><b>Answers:</b></label><input name='answer' required class='form-control form-control-rounded' type='text'></div><div class='mr-3 form-group'><label class='form-label'><b>Marks:</b></label><input required type='text' name='marks' class='form-control form-control-rounded'></div>";
            $('.fields').html(data);
            $('#q_title').html('Create Fill In The Blank Questions')
        }else if(val==4){
            location.reload();
        };
    })
});
</script>


<script>

ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );

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
