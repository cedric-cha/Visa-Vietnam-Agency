<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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
    </style>
</head>

<body>
    <table>
        <tr>
            <th scope="col">Applicant</th>
            <th scope="col">Processing time</th>
            <th scope="col">Purpose</th>
            <th scope="col">Visa type</th>
            <th scope="col">Entry port</th>
            <th scope="col">Arrival date</th>
            <th scope="col">Departure date</th>
        </tr>

        <tr>
            <td>{{ $order->applicant->full_name }}</td>
            <td>{{ $order->processingTime->description ?? 'N/A' }}</td>
            <td>{{ $order->purpose->description ?? 'N/A' }}</td>
            <td>{{ $order->visaType->description ?? 'N/A' }}</td>
            <td>
                @if ($order->entryPort)
                    ({{ $order->entryPort->type }}) {{ $order->entryPort->name }}
                @else
                    N/A
                @endif
            </td>
            <td>
                @if ($order->arrival_date)
                    {{ \Carbon\Carbon::parse($order->arrival_date)->format('d M Y') }}
                @else
                    N/A
                @endif
            </td>
            <td>
                @if ($order->departure_date)
                    {{ \Carbon\Carbon::parse($order->departure_date)->format('d M Y') }}
                @else
                    N/A
                @endif
            </td>
        </tr>
    </table>

    <br>

    <table>
        <tr>
            <th scope="col">Fast track entry port</th>
            <th scope="col">Fast track date</th>
            <th scope="col">Time slot</th>
        </tr>

        <tr>
            <td>
                @if ($order->fastTrackEntryPort)
                    {{ $order->fastTrackEntryPort->name }}
                @else
                    N/A
                @endif
            </td>
            <td>
                @if ($order->fast_track_date)
                    {{ \Carbon\Carbon::parse($order->fast_track_date)->format('d M Y') }}
                @else
                    N/A
                @endif
            </td>
            <td>
                @if ($order->timeSlot)
                    {{ $order->timeSlot->name }} ({{$order->timeSlot->start_time}} to {{$order->timeSlot->end_time}})
                @else
                    N/A
                @endif
            </td>
        </tr>
    </table>
</body>

</html>