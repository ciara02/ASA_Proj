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

    <h1 class="text-center">ASA (Automated Support Activity)- Activity Completion Acceptance Report</h1>

    <button class="print-btn custom-flex" style="margin-top: 1rem" onclick="window.print()">
        <i class="bi bi-printer-fill"></i>
        <span>Print</span>
    </button>

    <table class="table-for-print">
        <thead>
            <tr>
                <th>Date</th>
                <th>Engineer</th>
                <th>Activity Reference #</th>
                <th>Activity Details</th>
                <th>Reseller</th>
                <th>End User</th>
                <th>Category</th>
                <th>Activity Type</th>
                <th>Product Line</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Project Name</th>
                <th>Reseller Contact</th>
                <th>End User Contact</th>
                <th>Date Created</th>
                <th>Activity Done</th>
                <th>Approver Name</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($reports))
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $report->ar_activityDate }}</td>
                        <td>{{ optional($report->ActCompletionEngr)->engr_name }}</td>
                        <td>{{ $report->ar_refNo }}</td>
                        <td>{{ $report->ar_activity }}</td>
                        <td>{{ $report->ar_resellers }}</td>
                        <td>{{ $report->ar_endUser }}</td>
                        <td>{{ optional($report->ActCompletioncategory)->report_name }}</td>
                        <td>{{ optional($report->ActCompletionActivityType)->type_name }}</td>
                        <td>{{ optional($report->ActCompletionproductLines)->ProductLine }}</td>
                        <td>{{ optional($report->ActCompletionStatus)->aa_status }}</td>
                        <td>{{ optional($report->ActCompletionStatus)->aa_created_by }}</td>
                        <td>{{ optional($report->ActCompletionProjectList)->proj_name }}</td>
                        <td>{{ optional($report->ActCompletionProjectList)->rs_contact }}</td>
                        <td>{{ optional($report->ActCompletionProjectList)->eu_contact }}</td>
                        <td>
                            {{ optional($report->ActCompletionStatus)->aa_date_created ? date('Y-m-d', strtotime(optional($report->ActCompletionStatus)->aa_date_created)) : '' }}
                        </td>
                        <td style="line-height: 1;">{!! nl2br(e(str_replace('<br />', "\n", $report->ar_activityDone))) !!}</td>

                        <td>{{ optional($report->ActCompletionStatus->Approval)->aaa_name }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>

</html>
