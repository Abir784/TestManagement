
@extends('dashboard.haeder')

@section('content')
<div class="container-flex">
    <div class="row">
        <div class="col-lg-8">
            <div class="card-header"></div>
            <div class="card-body">
                <table class="table table-light">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Quiz Name</th>
                            <th>Pass Marks</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (App\Models\IndependentTest::all() as $key=>$test)
                        <tr>
                            <td>{{$key+1 }}</td>
                            <td>{{ $test->name}}</td>
                            <td>{{ $test->pass_marks}}</td>
                            <td> <a href="{{route('quiz.statuschange',$test->id)}}" class="btn btn-success">{{($test->status!=0)?'Active':'Not Active'}}</a></td>
                            <td><a href="{{route('quiz.indipendent.question.index',$test->id)}}" class="btn btn-primary"> Add Questions</a>
                                <a href="{{route('quiz.indipendent.question.show',$test->id)}}" class="btn btn-warning"> Show Questions</a>
                            </td>


                        </tr>

                        @empty
                        <tr>
                            <td colspan="5">No Tests Created Yet</td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>

            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-default">
                    <h3 id="q_title">{{'Create Independent Test'}}
                    </h3>
                </div>
                <div class="card-body">
                        <form action="{{route('quiz.post')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Test Title:</label>
                                <input type="text" required name="name" class="form-control form-control-rounded">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Introduction Text:</label>
                                <input type="text" required name="introduction_text" class="form-control form-control-rounded">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Passing Comment:</label>
                                <input type="text" required name="pass_comment" class="form-control form-control-rounded">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Fail Comment:</label>
                                <input type="text" required name="failing_comment" class="form-control form-control-rounded">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Show Scores:</label>
                                <select name="show_scores" id="" class="form-control form-control-rounded">
                                    <option value="">--Select--</option>
                                    <option value="1">
                                        YES
                                    </option>
                                    <option value="0">
                                        NO
                                    </option>
                                </select>
                            </div>
                            <div class="row form-group">
                                <div class="m-3 form-group">
                                    <label for="" class="form-label">Start Date:</label>
                                    <input type="date" required name="start_date" class="form-control form-control-rounded">
                                </div>

                                <div class="m-3 form-group">
                                    <label for="" class="form-label">Start time:</label>
                                    <input type="time" required name="start_time" class="form-control form-control-rounded">
                                </div>

                                <div class="m-3 form-group">
                                    <label for="" class="form-label">End Date:</label>
                                    <input type="date" required name="end_date" class="form-control form-control-rounded">
                                </div>

                                <div class="m-3 form-group">
                                    <label for="" class="form-label">End time:</label>
                                    <input type="time" required name="end_time" class="form-control form-control-rounded">
                                </div>
                            </div>

                            <div class="m-3 form-group">
                                <label for="" class="form-label">Pass Marks:</label>
                                <input type="number" required name="pass_marks" class="form-control form-control-rounded">
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

@section('js_code')

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
  title: 'Quiz Added successfully'
})
</script>
@endif

@endsection
