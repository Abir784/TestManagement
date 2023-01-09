@extends('dashboard.haeder')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Test Questions</h5>
                    <p class="card-text">

                        <a href="{{route('individual_test.index')}}" class="btn btn-primary">Back</a>

                    </p>

                    <table class="table table-light">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Questions</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $questions as $key=>$question)

                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{!! $question->rel_to_question->title !!}</td>
                                <td><a href="{{route('individual_test_question.delete',$question->id)}}" class="btn btn-outline-danger btn-rounded">Delete</a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2">
                                    No Questions Added Yet
                                </td>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
