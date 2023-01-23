@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Certificate</h5>
                    <p class="card-text">

                        <div class="mb-3">
                            @if ($bool)
                              <img src="{{asset('certificates/'.$image_name)}}" class="text-center" height="700px" width="500px" alt="{{$image_name}}">

                              <div class="m-3">
                                <a href="{{asset('certificates/'.$image_name)}}" download="" class="btn btn-primary">Download Certificate</a>
                              </div>
                            @else
                            <h4>You have to attend all assesments to get a certificate..</h4>
                            @endif
                        </div>



                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
