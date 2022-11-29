@extends('dashboard.haeder')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <table class="table table-">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $key=>$user)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                @if ($user->role==1)
                                <td>{{"Admin"}}</td>

                                @else
                                <td>{{"Student"}}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
