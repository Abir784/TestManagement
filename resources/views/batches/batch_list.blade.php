@extends('dashboard.haeder')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10">
            <div class="card">

                <div class="card-body">
                    <div class="card-title">
                        <h3>Batch List</h3>
                    </div>

                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>Course Name</th>
                            <th>Batch Name</th>
                            <th>Start date</th>
                            <th>Action</th>
                        </tr>

                        @forelse ($batch_info as $key=>$batch )

                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$batch->rel_to_course->name}}</td>
                            <td>{{$batch->batch_name}}</td>
                            <td>{{Carbon\Carbon::parse($batch->start_date)->format('d,M-y')}}</td>
                            <td>
                                <a href="{{route('batch.delete', $batch->id)}}" class="mr-2 btn btn-outline-danger btn-rounded show_confirm"> Delete</a>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-warning"> No data to show</td>
                        </tr>

                        @endforelse


                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js_code')
@if(session('success'))
<script>
$(document).ready(function(){
    Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'Your data has been deleted',
  showConfirmButton: false,
  timer: 2500
})
});
</script>
@endif
@endsection
