
@extends('dashboard.haeder')

@section('content')
<div class="flex-container">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>{{'Modules'}}
                    </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="col">Subject Name</th>
                            <th class="col">Module Name</th>
                            <th class="col">Description</th>
                            <th class="col">Created At</th>
                            <th class="col">Action</th>
                        </tr>
                        @forelse ($modules as $module )
                        <tr>
                            <td>{{$module->rel_to_subject->name}}</td>
                            <td>{{$module->name}}</td>
                            <td>{{$module->desp !=null ? $module->desp : 'N/A'}}</td>
                            <td>{{($module->created_at)->format('d/m/Y')}}</td>
                            <td ><a href="{{route('module.delete', $module->id)}}" class="m-2 btn btn-outline-danger btn-rounded show_confirm"> Delete</a>
                                <a href="{{route('question.index', $module->id)}}" class="m-2 btn btn-outline-primary btn-rounded show_confirm">Add Questions</a>
                                <a href="{{route('question.show',$module->id)}}" class="m-2 btn btn-outline-warning btn-rounded show_confirm">Show Questions</a>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="5">No data </td>
                        </tr>

                        @endforelse



                    </table>

                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-default">
                    <h3>{{'Create Modules'}}
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{route('module.post')}}" method="POST">
                        @csrf
                        <div class="mb-3 form-group">
                            <label for="" class="form-label">
                                <b>Subject Name:</b>
                            </label>
                            <select name="subject_id"  class="form-control form-control-rounded" id="">
                                <option value="">--Choose Subject--</option>
                                @foreach ($subjects as $subject )
                                  <option value="{{$subject->id}}">{{$subject->name}}</option>
                                @endforeach
                            </select>
                            @error('subject_id')
                            <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Module Name:</b>
                            </label>
                            <input type="text" value="{{ old('name')}}"  name="name" id="" class="form-control form-control-rounded ">
                            @error('name')
                                <b class="mb-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="" class="form-label">
                              <b>  Description:</b>
                            </label>
                            <input type="text" value="{{ old('desp')}}"  name="desp" id="" class="form-control form-control-rounded ">
                            @error('desp')
                             <b class="mt-2 text-danger">{{$message}}</b>
                            @enderror
                        </div>

                        <div class="mb-3 form-group">
                            <button class="btn btn-success btn-rounded" type="submit">Submit</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_code')
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
  title: 'Module Added successfully'
})
</script>
@endif

@endsection
