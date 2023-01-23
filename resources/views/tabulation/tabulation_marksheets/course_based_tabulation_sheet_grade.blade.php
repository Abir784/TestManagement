
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

		<title>Tabulation</title>

		<!-- Favicon -->
		<link rel="icon" href="./images/favicon.png" type="image/x-icon" />

		<!-- Invoice styling -->
		<style>
			/*  */
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
Course Name: {{App\Models\Course::where('id',$course_name)->first()->name}}
Batch No: {{App\Models\Batch::where('id',$batch_name)->first()->batch_name}}
</h3>
</pre>
                        <table class="table table-light"  border="1">
                            <thead class="thead-light" >
                                <tr>
                                    <th rowspan="2">SL</th>
                                    <th rowspan="2">Name</th>
                                    <th rowspan="2">Registration No</th>
                                    <th colspan="{{count($quizzes)+2+count($assignments)}}" class="text-center">Marks</th>
                                </tr>
                                <tr>
                                    @foreach ($quizzes as $quiz )

                                    <th>{{$quiz->name}}</th>

                                    @endforeach
                                    @foreach ($assignments as $assignment )
                                    <th>{{$assignment->title}}</th>
                                    @endforeach
                                    <th>CGPA</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students_result as $key=>$results )
                             <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$results['student_name']}}</td>
                                    <td>{{$results['id']}}</td>
                                    @php
                                        $cgpa=0;
                                        $i=0;
                                    @endphp

                                    @foreach ($results['quiz_marks'] as $quiz_marks)
                                    <td>{{number_format($quiz_marks['gpa'],2)}}</td>
                                    @php
                                        $cgpa+=$quiz_marks['gpa'];
                                        $i+=1;
                                    @endphp

                                    @endforeach


                                    @foreach ($results['assignment_marks'] as $assignment)
                                    <td>{{number_format($assignment['gpa'],2)}}</td>
                                    @php
                                    $cgpa+=$assignment['gpa'];
                                    $i+=1;
                                    @endphp
                                    @endforeach
                                    <td>{{number_format($cgpa/$i,2)}}</td>
                                    @if (($cgpa/$i) == 0)

                                        <td   align="center">{{'F'}}</td>

                                    @elseif (($cgpa/$i) >= 2.50 && ($cgpa/$i) <=2.74 )

                                            <td   align="center">{{'C+'}}</td>

                                    @elseif (($cgpa/$i) >= 2.75 && ($cgpa/$i) <=2.99 )

                                            <td   align="center">{{'B-'}}</td>

                                    @elseif (($cgpa/$i) >= 3.00 && ($cgpa/$i) <=3.24 )

                                            <td   align="center">{{'B'}}</td>

                                    @elseif (($cgpa/$i) >= 3.25 && ($cgpa/$i) <=3.49 )

                                            <td   align="center">{{'B+'}}</td>

                                    @elseif (($cgpa/$i) >= 3.50 && ($cgpa/$i) <=3.74 )

                                            <td   align="center">{{'A-'}}</td>

                                    @elseif (($cgpa/$i) >= 3.75 && ($cgpa/$i) <=3.99 )

                                            <td   align="center">{{'A'}}</td>

                                    @elseif (($cgpa/$i) >= 4.00 )

                                            <td   align="center">{{'A+'}}</td>
                                    @else
                                           <td align="center">{{'Unsatisfactory'}}</td>
                                    @endif

                             </tr>
                                @endforeach
                            </tbody>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

