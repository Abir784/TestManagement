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

                             <br>Your tentative mark is {{session('success')}}.
                          </div>

                        @endif

                    </div>
                <div class="card-title">{{ __('Dashboard') }}</div>
                {{"----Your Info----"}}<br>
                {{"Name: ". Auth::user()->name}} <br>
                {{"Email: ". Auth::user()->email}} <br>
                @if(Auth::user()->role == 2)
                {{"Role: ". 'Student'}}
                @elseif (Auth::user()->role == 3)
                {{"Role: ". 'Instructor'}}

                @endif
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



