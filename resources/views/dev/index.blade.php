<!-- resources/views/dev/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Executor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>SQL Executor</h1>

    <form method="POST" action="/dev">
        @csrf
        <div class="mb-3">
            <label for="sql" class="form-label">SQL Query</label>
            <textarea name="sql" id="sql" rows="5" class="form-control">{{ old('sql') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Execute</button>
    </form>

    @if(isset($error))
        <div class="alert alert-danger mt-3">
            <strong>Error:</strong> {{ $error }}
        </div>
    @endif

    @if(isset($result))
        <h3 class="mt-5">Result:</h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    @if(!empty($result->first()))
                        @foreach(array_keys((array)$result->first()) as $column)
                            <th>{{ $column }}</th>
                        @endforeach
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($result as $row)
                    <tr>
                        @foreach((array)$row as $column)
                            <td>{{ $column }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $result->appends(['sql' => request()->input('sql')])->links() }}
        </div>
    @endif
</div>
</body>
</html>
