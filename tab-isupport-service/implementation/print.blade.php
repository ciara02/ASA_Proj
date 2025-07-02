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
                <th>Project Code</th>
                    <th>Project Name</th>
                    <th>Date Filed</th>
                    <th>Business Unit</th>
                    <th>Product Line</th>
                    <th>Service Category</th>
                    <th>OR</th>
                    <th>INV</th>
                    <th>MBS</th>
                    <th>PO</th>
                    <th>SO</th>
                    <th>FT</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Project Amount</th>
                    <th>Completed</th>
                    <th>Reseller</th>
                    <th>End User</th>
                    <th>Project Manday</th>

                    {{-- leave empty for now --}}
                    <th>Mandays</th>
                    <th>Doer & Engineers</th>

                    <th>Finance Status</th>
                    <th>Sign-off Status</th>
                    <th>Special Instruction</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($implementationProjects))
                    @foreach ($implementationProjects as $project)
                        <tr>
                            <td>{{ $project->proj_code }}</td>
                            <td>{{ $project->proj_name }}</td>
                            <td>{{ $project->created_date }}</td>
                            <td>{{ $project->business_unit_id }}</td>
                            <td>{{ $project->product_line }}</td>
                            <td>{{ $project->service_category }}</td>
                            <td>{{ $project->original_receipt }}</td>
                            <td>{{ $project->inv }}</td>
                            <td>{{ $project->mbs }}</td>
                            <td>{{ $project->po_number }}</td>
                            <td>{{ $project->so_number }}</td>
                            <td>{{ $project->ft_number }}</td>
                            <td>{{ $project->proj_startDate }}</td>
                            <td>{{ $project->proj_endDate }}</td>
                            <td>{{ number_format($project->proj_amount, 2) }}</td>
                            <td>{{ $project->status }}</td>
                            <td>{{ $project->reseller }}</td>
                            <td>{{ $project->endUser }}</td>
                            <td>{{ $project->manday }}</td>
                            <td></td>
                            <td></td>
                            <td>{{ optional($project->financial_status)->payment_status }}</td>
                            <td>{{ $project->signoff }}</td>
                            <td>{!! nl2br($project->special_instruction) !!}</td>
                        </tr>
                    @endforeach
                @endif
        </tbody>
    </table>
</body>

</html>
