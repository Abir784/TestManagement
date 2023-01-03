@extends('dashboard.haeder')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Independent Descriptive Answers Marking</h5>
                    <p class="card-text"></p>
                   <table class="table table-light">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Quiz Title </th>
                            <th>Question Title</th>
                            <th>Full Marks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $key=>$answer )
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$answer->rel_to_student->name}}</td>
                            <td>{{$answer->rel_to_quiz->name}}</td>
                            <td>{{$answer->rel_to_question->title}}</td>
                            <td>{{$answer->rel_to_question->marks}}</td>
                            <td><a href="{{route('independent.marking',$answer->id)}}" class="btn btn-primary mr-3">Examine</a></td>
                        </tr>

                        @empty
                        <tr>
                            <td class="m-auto">No Submissions Yet</td>
                        </tr>

                        @endforelse
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
