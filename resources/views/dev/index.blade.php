<!-- resources/views/dev/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Executor</title>
</head>
<body>
<h1>SQL Executor</h1>

<form method="POST" action="/dev">
    @csrf
    <textarea name="sql" rows="10" cols="50"></textarea><br>
    <button type="submit">Execute</button>
</form>

@if(isset($error))
    <h3 style="color: red;">Error: {{ $error }}</h3>
@endif

@if(isset($result))
    <h3>Result:</h3>
    <pre>{{ print_r($result, true) }}</pre>
@endif
</body>
</html>
