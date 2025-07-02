<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merit and Demerit Request</title>
    <style>
        .container {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #010058;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Merit and Demerit Request Disapproved</h1>
        </div>
        <div class="content">
            <p>Good Day,</p> 
            <p>This is to inform you that a merit and demerit request (ID: <b>{{ $record->id }}</b>) has been disapproved by <b>{{ Auth::user()->name }}</b>.</p>
            <p>The request is associated with the Engineer name: <b>{{ $record->engineer }}</b></p>
            <p>You can view the request by clicking the link below:</p>
            <p><a href="{{ $editUrl }}" class="button">View Request Here</a></p>
        </div>
        <div class="footer">
            <p>Thank you for your attention.</p>
            <p>Automated Support Activity</p>
        </div>
        <div class="logo">
            <img src="{{ asset('assets/img/email_logo.png') }}" alt="Logo"  width="200" height="auto">
        </div>
        <table style="background-color: #6EFF5D;">
            <thead>
                <tr>
                    <th style="width: 50%; font-size: 25px;">MERIT / DEMERIT FORM</th>
                    <td style="width: 50%;">Author: <b>{{ $record->author }}</b></td>
                </tr>
                <tr>
                    <td>Type:
                        <input type="radio" id="Merit" {{ $record->type == 1 ? 'checked' : '' }} disabled> <label for="Merit">Merit</label>
                        <input type="radio" id="Demerit" {{ $record->type == 0 ? 'checked' : '' }} disabled> <label for="Demerit">Demerit</label>
                    </td>
                    <td>Created on: <b>{{ $record->created_date }}</b></td>
                </tr>
            </thead>
        </table>
        
        <table style="background-color: #6EFF5D;">
            <tbody>
                <tr>
                    <td>Who:</td>
                    <td><b>{{ $record->engineer }}</b></td>
                </tr>
                <tr>
                    <td>Details:</td>
                    <td>
                        <b>{{ $record->details }}</b>
                        <div><i>Violation or recognition details</i></div>
                    </td>
                </tr>
                <tr>
                    <td>Severity:</td>
                    <td>
                        <input type="radio" id="l1" {{ $record->points == 1 ? 'checked' : '' }} disabled> <label for="l1">Level 1</label>
                        <input type="radio" id="l2" {{ $record->points == 2 ? 'checked' : '' }} disabled> <label for="l2">Level 2</label>
                        <input type="radio" id="l3" {{ $record->points == 3 ? 'checked' : '' }} disabled> <label for="l3">Level 3</label>
                        <input type="radio" id="l4" {{ $record->points == 4 ? 'checked' : '' }} disabled> <label for="l4">Level 4</label>
                        <div><b>{{ number_format($record->points, 2) }}</b> <i>Point/s</i></div>
                        <div><b>{{ number_format($record->amount, 2) }}</b> <i>Amount</i></div>
                    </td>
                </tr>
                <tr>
                    <td>Defense:</td>
                    <td><b>{{ $record->defense }}</b></td>
                </tr>

                <tr>
                    <td>Attachments:</td>
                    <td><b>Click the request link to view any attachments, if available</b></td>
                </tr>
            </tbody>
        </table>

        <div class="form-group" style="margin-left: 10%;">
            Status: <b>{{ $record->status }}</b>
        </div>
    </div>
</body>
</html>
