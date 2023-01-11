

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

		<title>{{$student->name."_".$student->registration_no.'_'.now()}}</title>

		<!-- Favicon -->
		<link rel="icon" href="./images/favicon.png" type="image/x-icon" />

		<!-- Invoice styling -->
		<style>
			body {
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				text-align: center;
				color: rgb(255, 12, 12);
			}
			body h1 {
				font-weight: 300;
				margin-bottom: 0px;
				padding-bottom: 0px;
				color: #000;
			}
			body h3 {
				font-weight: 300;
				margin-top: 10px;
				margin-bottom: 20px;
				font-style: italic;
				color: #555;
			}
            body h2 {
				font-weight: 300;
				margin-top: 10px;
				margin-bottom: 20px;
				font-style: italic;
				color: #555;
			}
			body a {
				color: #06f;
			}
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(238, 168, 5, 0.925);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}
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
            <h2 align="center"><u>Free Tests Evaluation</u></h2>
			<table>
				<tr class="top">
					<td colspan="2">
						<table>
                            <tr>
<pre>
Name:              {{$student->name}}
Registration No:   {{$student->registration_no}}
Course Name:       {{$student->course_name->name}}
Course code:       {{$student->course_name->course_code}}
Batch Number:      {{$student->batch_name->batch_name}}
</pre>
        <pre>
            <table class="table table-light" border="2">
                <thead class="thead-dark" border="2">
                    <tr>
                        <th>Test Name</th>
                        <th>Full Mark</th>
                        <th>Marks Obtained</th>
                        <th>GPA</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=0;
                        $cgpa=0;

                    @endphp
                    @foreach ($quizzes_results as $result )
                    @php
                    $cgpa+=$result['gpa'];
                    $i+=1;

                    @endphp
                    <tr>
                        <td align="center">{{$result['name']}}</td>
                        <td align="center">{{$result['full_marks']}}</td>
                        <td align="center">{{$result['mark_obtained']}}</td>
                        <td align="center">{{number_format($result['gpa'],2)}}</td>
                        <td align="center">{{$result['grade']}}</td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </pre>
                </tr>
            </table>
        </td>
    </tr>
</table>


		</div>
	</body>
</html>
