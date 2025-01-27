<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        table,
        th,
        td {
            border: 1px solid black !important;
            border-collapse: collapse !important;
        }

        table {
            width: 100% !important;
        }

        h1 {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 2em;
        }
    </style>
</head>

<body>
    <h1>E-VISA SERVICE</h1>

    <table>
        <tr>
            <th scope="row" align="left">Full name</th>
            <td>{{ $order->applicant->full_name }}</td>
        </tr>
        <tr>
            <th scope="row" align="left">Date of birth</th>
            <td>{{ \Carbon\Carbon::parse($order->applicant->date_of_birth)->format('d M Y') }}</td>
        </tr>
        <tr>
            <th scope="row" align="left">Gender</th>
            <td>{{ $order->applicant->gender }}</td>
        </tr>
        <tr>
            <th scope="row" align="left">Email address</th>
            <td>{{ $order->applicant->email }}</td>
        </tr>
        <tr>
            <th scope="row" align="left">Address</th>
            <td>{{ $order->applicant->address }}</td>
        </tr>
        <tr>
            <th scope="row" align="left">Phone number</th>
            <td>{{ $order->applicant->phone_number }}</td>
        </tr>
        <tr>
            <th scope="row" align="left">Passport number</th>
            <td>{{ $order->applicant->passport_number }}</td>
        </tr>
        <tr>
            <th scope="row" align="left">Passport expiration date</th>
            <td>{{ \Carbon\Carbon::parse($order->applicant->passport_expiration_date)->format('d M Y') }}</td>
        </tr>
        <tr>
            <th scope="row" align="left">Country</th>
            <td>{{ $order->applicant->country ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th scope="row" align="left">Processing time</th>
            <td>{{ $order->processingTime->description ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th scope="row" align="left">Purpose</th>
            <td>{{ $order->purpose->description ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th scope="row" align="left">Visa type</th>
            <td>{{ $order->visaType->description ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th scope="row" align="left">Entry port</th>
            <td>
                @if ($order->entryPort)
                    ({{ $order->entryPort->type }}) {{ $order->entryPort->name }}
                @else
                    N/A
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" align="left">Arrival date</th>
            <td>
                @if ($order->arrival_date)
                    {{ \Carbon\Carbon::parse($order->arrival_date)->format('d M Y') }}
                @else
                    N/A
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" align="left">Departure date</th>
            <td>
                @if ($order->departure_date)
                    {{ \Carbon\Carbon::parse($order->departure_date)->format('d M Y') }}
                @else
                    N/A
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" align="left">Address (Vietnam)</th>
            <td>{{ $order->applicant->address_vietnam }}</td>
        </tr>
    </table>
</body>

</html>