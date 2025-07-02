<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link href="{{ asset('assets/tab-layout/stylebase.css') }}" rel="stylesheet">

    {{-- Bootstrap icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <h1 class="text-center">ASA (Automated Support Activity)- Implementation Report</h1>

    <button class="print-btn custom-flex" style="margin-top: 1rem" onclick="window.print()">
        <i class="bi bi-printer-fill"></i>
        <span>Print</span>
    </button>

    <table class="table-for-print">
        <thead>
            <tr>
                <th>Engineer</th>
                <th>Date</th>
                <th>Status</th>
                <th>Type</th>
                <th>Points</th>
                <th>Details</th>
                <th>Author</th>
                <th>Counter Explanation</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($records))
                @foreach ($records as $record)
                    <tr>
                        <td>{{ $record->engineer }}</td>
                        <td>{{ $record->created_date }}</td>
                        <td>{{ $record->status }}</td>
                        <td>
                            {{ $record->type == 1 ? 'Merit' : ($record->type == 0 ? 'Demerit' : 'Unknown Type') }}
                        </td>
                        <td>{{ $record->points }}</td>
                        <td>{{ $record->details }}</td>
                        <td>{{ $record->author }}</td>
                        <td>{{ $record->defense }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>

</html>
