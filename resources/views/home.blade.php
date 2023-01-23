@extends('dashboard.haeder')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                {{"----Your Info----"}}<br>
                {{"Name: ". Auth::user()->name}} <br>
                {{"Email: ". Auth::user()->email}} <br>
                @if (Auth::user()->role ==0)
                {{"Role: ". 'Super Admin'}}
                @elseif (Auth::user()->role ==1)
                {{"Role: ". 'Admin'}}
                @else
                {{"Role: ". 'Instructor'}}


                @endif
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
