@extends('dashboard.haeder')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Questions(Specific)</h5>
                    <p class="card-text">


                        <a href="{{route('quiz.indipendent.question.index',$quiz_id)}}" class="btn btn-primary">Back</a>


                    </p>
                    <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Question Title</th>
                            </tr>
                        </thead>
                        <form action="{{route('independent.add.quiz.question.post')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="quiz_id" value="{{$quiz_id}}">
                            <tbody>
                                @forelse ($questions as $key=>$question)
                                    <tr>
                                        <td><input type="checkbox" required class='' name="question_id[]" value="{{$question->id}}"></td>
                                        <td>{!! $question->title !!}</td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="2">
                                                  No Questions Added Yet
                                        </td>
                                    </tr>
                                @endforelse

                                @php
                                  $count=count($questions)

                                @endphp



                                <tr>
                                    <td>
                                        @if ( $count != 0)
                                        <button class="btn btn-success" type="submit">Submit </button>
                                        @endif
                                   </td>
                                </tr>
                            </tbody>


                        </form>


                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
