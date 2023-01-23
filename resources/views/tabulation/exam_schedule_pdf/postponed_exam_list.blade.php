
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

		<title>Postponed Exam List</title>

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
                     <u>Postponed Exam List</u>
                            </h3>
                            </pre>
                        <table border="1" align="left">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Course Name</th>
                                    <th>Batch Name</th>
                                    <th>Exam  Name</th>
                                    <th>Scheduled Date</th>
                                    <th>New Date</th>
                                    <th>Reason/Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($postponed_exam_list as $key=>$exam)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$exam['course_name']}}</td>
                                    <td>{{$exam['batch_name']}}</td>
                                    <td>{{$exam['quiz_name']}}</td>
                                    <td>{{Carbon\Carbon::parse($exam['scheduled_date'])->format('d-M-Y')}}</td>
                                    <td>{{Carbon\Carbon::parse($exam['new_date'])->format('d-M-Y')}}</td>
                                    <td>{{$exam['reason']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

