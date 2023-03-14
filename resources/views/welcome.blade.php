<!DOCTYPE html>
<html>
<head>
	<title>Upload JSON</title>
	<style type="text/css">
		body {
			font-family: sans-serif;
			margin: 0;
			padding: 0;
			background-color: #f5f5f5;
		}

		.container {
			max-width: 800px;
			margin: 0 auto;
			padding: 20px;
			background-color: #fff;
			box-shadow: 0 0 10px rgba(0,0,0,.1);
			border-radius: 5px;
			margin-top: 50px;
			text-align: center;
		}

		h1 {
			margin-top: 0;
			font-weight: normal;
			color: #333;
		}

		form {
			margin-top: 20px;
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		label {
			display: block;
			margin-bottom: 10px;
			color: #666;
		}

		input[type="submit"] {
			background-color: #007bff;
			color: #fff;
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			transition: background-color .2s ease;
			font-size: 16px;
			margin-top: 20px;
		}

		input[type="submit"]:hover {
			background-color: #0069d9;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Upload JSON File</h1>
		<form method="post" action="{{ route('upload') }}" enctype="multipart/form-data">
			@csrf
			<label for="file">Select a JSON file:</label>
			<input type="file" name="file" id="file">
			<input type="submit" value="Upload">
		</form>

        @if (isset($output))
        <h2>Output:</h2>
        <pre>{{ $output }}</pre>
    @endif
	</div>
</body>
</html>
