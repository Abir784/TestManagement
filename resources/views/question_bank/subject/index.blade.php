
@extends('dashboard.haeder')

@section('content')
<div class="flex-container">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>{{'Subjects'}}
                    </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="col">Subject Name</th>
                            <th class="col">Description</th>
                            <th class="col">Created At</th>
                            <th class="col">Action</th>
                        </tr>
                        @forelse ($subjects as $subject )
                        <tr>
                            <td>{{$subject->name}}</td>
                            <td>{{$subject->desp !=null ? $subject->desp : 'N/A'}}</td>
                            <td>{{($subject->created_at)->format('d/m/Y')}}</td>
                            <td><a href="{{route('subject.delete', $subject->id)}}" class="mr-2 btn btn-outline-danger btn-rounded show_confirm"> Delete</a>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="4">No data </td>
                        </tr>

                        @endforelse



                    </table>

                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-default">
                    <h3>{{'Create Subject'}}
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{route('subject.store')}}" method="POST">
                        @csrf
                        <div class="mb-3 form-group">
                            <label for="" id="" class="form-label">
                                <b>Subject Name:</b>
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
  title: 'Subject Added successfully'
})
</script>
@endif

@endsection
