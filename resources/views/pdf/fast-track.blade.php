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
    <h1>APPLICANT INFORMATION</h1>

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
    </table>

    @if ($arrival)
        <h1>FAST TRACK SERVICE ({{ $order->timeSlot->type }})</h1>

        <table>
            <tr>
                <th scope="row" align="left">Entry port</th>
                <td>{{ $order->fastTrackEntryPort->name }}</td>
            </tr>
            <tr>
                <th scope="row" align="left">Time slot</th>
                <td>{{ $order->timeSlot->name }} ({{$order->timeSlot->start_time}} to {{$order->timeSlot->end_time}})</td>
            </tr>
            <tr>
                <th scope="row" align="left">Arrival date</th>
                <td>{{ \Carbon\Carbon::parse($order->fast_track_date)->format('d M Y') }}</td>
            </tr>
            <tr>
                <th scope="row" align="left">Arrival time</th>
                <td>{{ $order->fast_track_time }}</td>
            </tr>
            <tr>
                <th scope="row" align="left">Flight number</th>
                <td>{{ $order->fast_track_flight_number }}</td>
            </tr>
        </table>
    @endif

    @if ($departure)
        <h1>FAST TRACK SERVICE ({{ $order->timeSlotDeparture->type }})</h1>

        <table>
            <tr>
                <th scope="row" align="left">Exit port</th>
                <td>{{ $order->fastTrackExitPort->name }}</td>
            </tr>
            <tr>
                <th scope="row" align="left">Time slot</th>
                <td>{{ $order->timeSlotDeparture->name }} ({{$order->timeSlotDeparture->start_time}} to {{$order->timeSlotDeparture->end_time}})</td>
            </tr>
            <tr>
                <th scope="row" align="left">Departure date</th>
                <td>{{ \Carbon\Carbon::parse($order->fast_track_departure_date)->format('d M Y') }}</td>
            </tr>
            <tr>
                <th scope="row" align="left">Departure time</th>
                <td>{{ $order->fast_track_departure_time }}</td>
            </tr>
            <tr>
                <th scope="row" align="left">Flight number</th>
                <td>{{ $order->fast_track_flight_number_departure }}</td>
            </tr>
        </table>
    @endif
</body>

</html>