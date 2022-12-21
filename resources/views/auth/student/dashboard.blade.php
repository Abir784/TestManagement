@extends('dashboard.haeder')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <div class="mb-3">
                        @if (session('success'))
                          <div class="alert alert-success">
                              {{session('success')[1]}}
                             <br>Your tentative mark is {{session('success')[0]}}.
                          </div>

                        @endif
                        @if (session('timeout'))
                        <div class="alert alert-danger">
                           {!! session('timeout') !!}
                        </div>
                      @endif
                    </div>
                <div class="card-title">{{ __('Dashboard') }}</div>
                {{"----Your Info----"}}<br>
                {{"Name: ". Auth::user()->name}} <br>
                {{"Email: ". Auth::user()->email}} <br>
                {{"Role: ". 'Student'}}
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



