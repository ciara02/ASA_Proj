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
    <h1 class="text-center">ASA (Automated Support Activity)- Certifications</h1>
    {{-- <p>{{ $columnOrderArray }}</p> --}}
    <button class="print-btn custom-flex" style="margin-top: 1rem" onclick="window.print()">
        <i class="bi bi-printer-fill"></i>
        <span>Print</span>
    </button>

    <table class="table-for-print" id="printTable">
        <thead>
            <tr>
                <th style="width:10%">Release Status</th>
                <th style="width:10%">Incentive Status</th>
                <th style="width:10%">Date</th>
                <th style="width:10%">Engineer</th>
                <th style="width:10%">Type</th>
                <th style="width:10%">Exam Type</th>
                <th>Incentive Details</th>
                <th>Amount</th>
                <th style="width:10%">Product Line</th>
                <th>Title</th>
                <th>Exam Code</th>
                <th>Score</th>
                <th>Takes</th>
            </tr>
        </thead>

        <tbody>
            @if (isset($incentives))
                @foreach ($incentives as $incentive)
                    <tr class="clickable-row" data-toggle="modal"
                        data-refNo="{{ $incentive->ar_refNo . '|' . $incentive->ProductCode . '|' . $incentive->program_name . '|' . $incentive->report_name . '|' . $incentive->status_name }} "
                        data-ar-take-status="{{ $incentive->ar_takeStatus }}"
                        data-target="#certificationModal{{ $incentive->id }}">
                        <td class="release-status"></td>
                        <td class="incentive-status">{{ $incentive->incStatus_name }}</td>
                        <td class="date">{{ $incentive->ar_activityDate }}</td>
                        <td class="engr">{{ $incentive->engr_name }}</td>
                        <td class="type">{{ $incentive->type_name }}</td>
                        <td class="exam_type">{{ $incentive->exam_name }}</td>
                        <td class="incentive-details">{{ $incentive->incDetails_name }}</td>
                        <td class="amt">
                            {{ empty($incentive->ar_incAmount) ? 0 : $incentive->ar_incAmount }}

                        </td>
                        <td class="prod_Line" style="height: 50px; white-space: pre-wrap;">
                            {{ $incentive->ProductLine }}</td>
                        <td class="inc_title" style="width: 10%; max-width: 100px; white-space: normal;">
                            {{ $incentive->ar_title }}
                        </td>
                        <td class="exam_code" style="width: 10%;">{{ $incentive->ar_examName }}</td>
                        <td class="score">{{ $incentive->ar_score }}</td>
                        <td class="takes" id="takeStatus">
                            {{ $incentive->ar_takeStatus }}
                            {{ $incentive->ar_takeStatus == 1 ? 'take' : 'takes' }}

                        </td>

                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the column order array from PHP
            var columnOrder = @json($columnOrderArray);

            // Select the table element
            var table = document.getElementById('printTable');
            var tbody = table.getElementsByTagName('tbody')[0];

            // Reorder the columns
            Array.from(tbody.rows).forEach(function(row) {
                var cells = Array.from(row.cells);
                row.innerHTML = ''; // Clear the row
                
                columnOrder.forEach(function(index) {
                    row.appendChild(cells[index]);
                });
            });
        });
    </script> --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the column order array from PHP
            var columnOrder = @json($columnOrderArray);

            // Select the table element
            var table = document.getElementById('printTable');
            var thead = table.getElementsByTagName('thead')[0];
            var tbody = table.getElementsByTagName('tbody')[0];

            // Reorder the columns in the body
            Array.from(tbody.rows).forEach(function(row) {
                var cells = Array.from(row.cells);
                row.innerHTML = ''; // Clear the row

                columnOrder.forEach(function(index) {
                    row.appendChild(cells[index]);
                });
            });

            // Reorder the columns in the header
            var headerRow = thead.getElementsByTagName('tr')[0];
            var headerCells = Array.from(headerRow.cells);
            headerRow.innerHTML = ''; // Clear the header row

            columnOrder.forEach(function(index) {
                headerRow.appendChild(headerCells[index]);
            });
        });
    </script>

</body>

</html>
