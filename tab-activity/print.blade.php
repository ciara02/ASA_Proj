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
    {{-- <div class="custom-flex">
        <p>{{ now()->format('m/d/y, g:i A') }}</p>
        <p style="margin-left: auto">ASA (Automated Support Activity)- Activity Report</p>
    </div> --}}

    <h1 class="text-center">ASA (Automated Support Activity)- Activity Report</h1>

    <button class="print-btn custom-flex" style="margin-top: 1rem" onclick="window.print()">
        <i class="bi bi-printer-fill"></i>
        <span>Print</span>
    </button>

    <table class="table-for-print">
        <thead>
            <tr>
                <th>Date</th>
                <th>Reference #</th>
                <th>Engineer</th>
                <th>From</th>
                <th>To</th>
                <th>Category</th>
                <th>Activity Type</th>
                <th>Product Line</th>
                <th>Activity Details</th>
                <th>Reseller</th>
                <th>Venue</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($act_report))
                @foreach ($act_report as $report)
                    <tr>
                        <td>{{ $report->ar_activityDate }}</td>
                        <td>{{ $report->ar_refNo }}</td>
                        <td>{{ $report->act_reportEngr ? $report->act_reportEngr->engr_name : '' }}</td>
                        <td>{{ $report->timeFrom ? $report->timeFrom->key_time : '' }}</td>
                        <td>{{ $report->timeTo ? $report->timeTo->key_time : '' }}</td>
                        <td>{{ $report->category ? $report->category->report_name : '' }}</td>
                        <td>{{ $report->activitytype ? $report->activitytype->type_name : '' }}</td>
                        <td>{{ $report->prod_line ? $report->prod_line->ProductLine : '' }}</td>
                        <td>{{ $report->ar_activity }}</td>
                        <td>{{ $report->ar_resellers }}</td>
                        <td>{{ $report->ar_venue }}</td>
                        <td>{{ $report->statustype ? $report->statustype->status_name : '' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>

</html>
