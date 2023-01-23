
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

		<title>Exam Schedule</title>

		<!-- Favicon -->
		<link rel="icon" href="./images/favicon.png" type="image/x-icon" />

		<!-- Invoice styling -->
	 <style>

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
				border-collapse: collapse;
			}
			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}
			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}
			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}
			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}
			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}
			.invoice-box table tr.heading td {
				background: rgb(159, 99, 99);
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}
			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}
			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}
			.invoice-box table tr.item.last td {
				border-bottom: none;
			}
			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}
			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}
				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}
		</style>
	</head>

<body>
    <div class="invoice-box">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
<pre>
<h3>
Course Name: {{App\Models\Course::where('id',$course_id)->first()->name}}
Batch No: {{App\Models\Batch::where('id',$batch_id)->first()->batch_name}}
</h3>
</pre>
                        <table border="1" align="left">
                            <thead class="thead-light">
                                <tr>
                                    <th rowspan="2" >Name Of Assesment</th>
                                    <th  rowspan="2">Syllabus Covered</th>
                                    <th colspan="4" class="text-center">No of Questions</th>
                                    <th colspan="4" class="text-center" >Marks</th>
                                    <th rowspan="2">Time</th>
                                    <th rowspan="2">Date</th>
                                </tr>
                                <tr>



                                    <th  align="center">Desciptive</th>
                                    <th align="center">MCQ</th>
                                    <th align="center">Fill In the Blanks</th>
                                    <th align="center">Matching</th>
                                    <th align="center">Desciptive</th>
                                    <th align="center">MCQ</th>
                                    <th align="center">Fill In the Blanks</th>
                                    <th align="center">Matching</th>

                                </tr>

                            </thead>
                            <tbody>
                                @php
                                    $total_marks=0;
                                @endphp
                            @foreach ($quiz_info as $quiz )
                            <tr>

                                <td align="center">{{$quiz['quiz_name']}}</td>
                                <td align="center">
                                    @foreach ($quiz['module'] as $module)
                                        {{$module}}<br>
                                    @endforeach
                                </td>
                                <td align="center">{{$quiz['desc']}}</td>
                                <td align="center">{{$quiz['mcq']}}</td>
                                <td align="center">{{$quiz['fill']}}</td>
                                <td align="center">{{$quiz['match']}}</td>


                                <td align="center">{{$quiz['desc_marks']}}</td>
                                <td align="center">{{$quiz['mcq_marks']}}</td>
                                <td align="center">{{$quiz['fill_marks']}}</td>
                                <td align="center">{{$quiz['match_marks']}}</td>

                                <td align="center">{{$quiz['time']}} Min</td>
                                <td align="center">{{Carbon\Carbon::parse($quiz['date'])->format('d-M-Y')}}</td>
                                @php
                                    $total_marks+=($quiz['desc_marks']+$quiz['mcq_marks']+$quiz['fill_marks']+$quiz['match_marks']);
                                @endphp
                            </tr>

                            @endforeach
                            @foreach ($assignments as $assignment )
                            <tr>
                                <td align="center"> <b>Assignment:</b> {{$assignment->title}}</td>
                                <td align="center" colspan="10" class="text-center" >Marks: {{$assignment->full_marks}}</td>
                                <td align="center"> <b>Deadline: </b> {{Carbon\Carbon::parse($assignment->deadline)->format('d-M-Y')}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <th  colspan="12" class="text-center">Total Mark = {{$total_marks+$assignment_full_mark}}</th>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

