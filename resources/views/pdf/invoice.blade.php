<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice</title>

    <style>
        body {
            background: #fff none;
            font-family: DejaVu Sans, 'sans-serif';
            font-size: 12px;
        }

        .container {
            padding-top: 30px;
        }

        .table th {
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            padding: 8px 8px 8px 0;
            vertical-align: bottom;
        }

        .table tr.row td {
            border-bottom: 1px solid #ddd;
        }

        .table td {
            padding: 8px 8px 8px 0;
            vertical-align: top;
        }

        .table th:last-child,
        .table td:last-child {
            padding-right: 0;
        }

        .dates {
            color: #555;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <table style="margin-left: auto; margin-right: auto;" width="100%">
            <tr valign="top">
                <td></td>
                <td align="center">
                    <img style="width: 180px" alt="logo ocinformatics" src="{{ public_path('/img/ocinformatics_logo.png') }}" />
                </td>
                <td></td>
            </tr>

            <tr valign="top">
                <td></td>
                <td align="center">
                    <span style="font-size: 15px">Invoice N°<strong>{{ str_pad(rand(1000, 9000), 5, '0', STR_PAD_LEFT) }}</strong></span>
                </td>
                <td></td>
            </tr>

            <br>
            <br>

            <tr valign="top">
                <td align="left">
                    {{ $order->applicant->full_name }}

                    @if(!is_null($order->applicant->country))
                        {{ $order->applicant->country }}
                    @endif
                </td>

                <td></td>

                <td align="right">
                    Date: {{ \Carbon\Carbon::parse($order->created_at)->locale('en')->isoFormat('D MMM YYYY') }}
                </td>
            </tr>

            <br>
            <br>

            <tr>
                <td colspan="3">
                    <table width="100%" class="table" border="0">
                        <tr>
                            <th align="left">Booking item</th>
                            <th align="right">Qty</th>
                            <th align="right">Discount</th>
                            <th align="right">Price</th>
                        </tr>

                        @if ($order->hasService(\App\Enums\OrderServiceType::EVISA->value))
                        <tr class="row">
                            <td>
                                E-Visa {{ $order->visaType->description }} {{ $order->purpose->description }} <br>
                                Arrival to {{ $order->entryPort->name }} on {{ \Carbon\Carbon::parse($order->arrival_date)->locale('en')->isoFormat('Do MMM YYYY') }}
                            </td>

                            <td align="right">1</td>
                            <td align="right">-</td>
                            <td align="right">
                                ${{ number_format(($order->purpose?->fees ?? 0) +
                                ($order->processingTime?->fees ?? 0) +
                                ($order->visaType?->fees ?? 0)) }}
                            </td>
                        </tr>
                        @endif

                        @if ($order->hasService(\App\Enums\OrderServiceType::FAST_TRACK->value))
                            @if (! is_null($order->fastTrackEntryPort))
                            <tr class="row">
                                <td>
                                    Fast Track arrival to {{ $order->fastTrackEntryPort->name }} on {{ \Carbon\Carbon::parse($order->fast_track_date)->locale('en')->isoFormat('Do MMM YYYY') }}
                                </td>

                                <td align="right">1</td>
                                <td align="right">-</td>
                                <td align="right">${{ number_format($order->timeSlot->fees, 2) }}</td>
                            </tr>
                            @endif

                            @if (! is_null($order->fastTrackExitPort))
                                <tr class="row">
                                    <td>
                                        Fast Track departure from {{ $order->fastTrackExitPort->name }} on {{ \Carbon\Carbon::parse($order->fast_track_departure_date)->locale('en')->isoFormat('Do MMM YYYY') }}
                                    </td>

                                    <td align="right">1</td>
                                    <td align="right">-</td>
                                    <td align="right">${{ number_format($order->timeSlotDeparture->fees, 2) }}</td>
                                </tr>
                            @endif
                        @endif

                        <tr>
                            <td align="right">
                                <strong>Total Price</strong>
                            </td>
                            <td></td>
                            <td align="right">
                                {{ $order->voucher?->discount ?? 0 }}%
                            </td>
                            <td align="right">
                                <strong>${{ number_format($order->total_fees_with_discount ?? $order->total_fees, 2) }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <br>
            <br>
            <br>

            <tr valign="top">
                <td></td>
                <td></td>
                <td align="right">
                    <img style="width: 200px" alt="signature" src="{{ public_path('/img/stamp.png') }}" />
                </td>
            </tr>

            <br>

            <tr valign="top">
                <td align="left">
                    <strong>OC Informatics CO. LTD</strong><br>
                    D31, Valencia Riverside<br>
                    1000 Nguyen Duy Trinh Street<br>
                    Phi Huu Ward<br>
                    Thu Duc City<br>
                    Ho Chi Minh City<br>
                    Vietnam
                </td>
                <td></td>
                <td>
                    Phone : +84 028 6681 0085<br>
                    Whatsapp : +33 602721098<br>
                    info@ocinformatics.com<br><br>
                    https://ocinformatics.com
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
