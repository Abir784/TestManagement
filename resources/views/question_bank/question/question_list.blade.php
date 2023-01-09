@extends('dashboard.haeder')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><h3>Question</h3></div>
                <div class="card-body">
                    <table class="table table-light">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Question Name</th>
                                <th>Question Type</th>
                                <th>Answers</th>
                                <th>Total Marks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $key=>$data )
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td>{!! $data['title'] !!}</td>
                                <td>{!! $data['type'] !!}</td>
                                <td>
                                    @if ($data['count']>0)
                                      @if ($data['type']=='MATCH')
                                      @foreach ($data['options'] as $key=>$option  )
                                        @if (($key+1)==count($data['options']))

                                        {{$option['option_title']}}

                                        @else
                                        {{$option['option_title'].'-'}}
                                        @endif


                                      @endforeach


                                      @else

                                      @foreach ($data['options'] as $option)
                                      @if ($option['right_answer']==1)

                                      {!! $option['option_title'].'<button class="m-2 btn btn-sm btn-success" disable></button><br>' !!}

                                      @else
                                      {!! $option['option_title'].'<br>' !!}
                                      @endif

                                      @endforeach
                                      @endif

                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>
                                    {{-- @if ($data['full_marks']!=0)
                                      {{$data['full_marks']}}

                                    @else
                                    {{$data['option_full_mark']}}
                                    @endif --}}
                                    {{$data['total_marks']}}
                                </td>
                                <td>
                                    <a href="{{route('question.delete', $data['question_id'])}}" class="btn btn-danger"> Delete</a>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="5"> No Data</td>
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
