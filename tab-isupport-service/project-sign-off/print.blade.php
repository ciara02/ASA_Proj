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
    <h1 class="text-center">ASA (Automated Support Activity)- Project Sign-off Report</h1>

    <button class="print-btn custom-flex" style="margin-top: 1rem" onclick="window.print()">
        <i class="bi bi-printer-fill"></i>
        <span>Print</span>
    </button>

    <table class="table-for-print">
        <thead>
            <tr>
                <th>Date Created</th>
                <th>Project Name</th>
                <th>Business Unit</th>
                <th>Product Line</th>
                <th>Service Category</th>
                <th>OR</th>
                <th>INV</th>
                <th>MBS</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Reseller</th>
                <th>End User</th>
                <th>Project Manager</th>
                <th>Project Member</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($projects))
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->created_date }}</td>
                        <td>{{ $project->proj_name }}</td>
                        <td>{{ $project->business_unit }}</td>
                        <td>{{ $project->product_line }}</td>
                        <td>{{ $project->service_category }}</td>
                        <td>{{ $project->original_receipt }}</td>
                        <td>{{ $project->inv }}</td>
                        <td>{{ $project->mbs }}</td>
                        <td>{{ $project->proj_startDate }}</td>
                        <td>{{ $project->proj_endDate }}</td>
                        <td>{{ $project->reseller }}</td>
                        <td>{{ $project->endUser }}</td>
                        <td>{{ $project->PM }}</td>
                        <td>{{ $project->ProjectMember }}</td>
                        <td>
                            @switch($project->status)
                                @case(1)
                                    Draft
                                @break

                                @case(2)
                                    For Approval
                                @break

                                @case(3)
                                    Approved
                                @break

                                @case(4)
                                    Disapproved
                                @break

                                @default
                                    Unknown Status
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>

</html>
