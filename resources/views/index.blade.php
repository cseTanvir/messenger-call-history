<!DOCTYPE html>
<html>
<head>
    <title>Call Duration Analysis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dark.css') }}">
</head>
<body>
<div class="container-fluid">
    <h1>Call Duration Analysis</h1>
    <form method="POST" action="{{ route('upload') }}" enctype="multipart/form-data" id="upload-form">
        @csrf
        <label for="json-file" title="Please input messenger chat with at least one call.">Upload JSON file:</label>
        <input type="file" name="file" id="json-file">
        <button id="analyze-btn" type="submit"><span id="analyze">Analyze</span> <span id="spinner" style="display:none;" class="spinner-border spinner-border-lg text-light" role="status"></span></button>
    </form>

    @if($errors->has('error'))
        <div class="alert alert-danger mx-auto text-center" style="max-width: 600px;">
            {{ $errors->first('error') }}
        </div>
    @endif
    @error('file')
    <div class="alert alert-danger mx-auto text-center" style="max-width: 600px;">
        {{ $message }}
    </div>
    @enderror
</div>
<script>
    const analyzeBtn = document.querySelector('#analyze-btn');
    const analyze = document.querySelector('#analyze');
    const spinner = document.querySelector('#spinner');
    const form = document.querySelector('#upload-form');

    analyzeBtn.addEventListener('click', function (e) {
        e.preventDefault();
        analyze.style.display = 'none';
        spinner.style.display = 'inline-block';
        analyzeBtn.disabled = true;
        form.submit();
    });

    form.addEventListener('submit', function() {
        analyze.style.display = 'none';
        spinner.style.display = 'inline-block';
        analyzeBtn.disabled = true;
    });
</script>
</body>
</html>
