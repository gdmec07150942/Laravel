<!-- resources/views/dev/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Executor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 4rem;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .btn-custom {
            min-width: 120px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mb-4">SQL Executor</h1>

    <form method="POST" action="{{ route('execute.sql') }}">
        @csrf
        <div class="mb-3">
            <label for="sql" class="form-label">SQL Query</label>
            <textarea name="sql" id="sql" rows="5" class="form-control">{{ old('sql') }}</textarea>
        </div>
        <div class="mb-3">
            <button type="submit" name="execute" class="btn btn-primary btn-custom">Execute</button>
            <button type="submit" name="export_excel" class="btn btn-success btn-custom">Export Excel</button>
            <button type="submit" name="export_json" class="btn btn-info btn-custom">Export JSON</button>
        </div>
    </form>

    @if(isset($error))
        <div class="alert alert-danger mt-3">
            <strong>Error:</strong> {{ $error }}
        </div>
    @endif

    @if(isset($result) && !isset($error))
        <h3 class="mt-5">Result:</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
