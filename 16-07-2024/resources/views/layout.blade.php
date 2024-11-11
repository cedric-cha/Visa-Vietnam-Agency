<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <meta name='robots' content='max-image-preview:large' />
    <link rel="alternate" type="application/rss+xml" title="Evisa Vietnam &raquo; Flux" href="https://evisa-vietnam-online.com/feed/" />
    <link rel="alternate" type="application/rss+xml" title="Evisa Vietnam &raquo; Flux des commentaires" href="https://evisa-vietnam-online.com/comments/feed/" />
    <link rel="icon" href="https://evisa-vietnam-online.com/wp-content/uploads/2024/03/cropped-evisa-vietnam-1024X686-32x32.jpg" sizes="32x32" />
    <link rel="icon" href="https://evisa-vietnam-online.com/wp-content/uploads/2024/03/cropped-evisa-vietnam-1024X686-192x192.jpg" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://evisa-vietnam-online.com/wp-content/uploads/2024/03/cropped-evisa-vietnam-1024X686-180x180.jpg" />
    <meta name="msapplication-TileImage" content="https://evisa-vietnam-online.com/wp-content/uploads/2024/03/cropped-evisa-vietnam-1024X686-270x270.jpg" />

    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background-color: #F1F1F1">
    <div class="container">
        <div class="vstack mt-5 mb-4 gap-3">
            <a href="https://evisa-vietnam-online.com/" class="mb-3 text-center text-decoration-none fw-bold" style="color: #118793">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                     class="bi bi-arrow-left" view-box="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg>
                <span class="ms-2">Go back home</span>
            </a>

            <div class="text-center">
                <img src="{{ asset('img/logo.jpg')}}" alt="Logo" style="width: 250px"/>
            </div>
            <h1 class="text-center h4">@yield('title')</h1>
        </div>

        <div class="py-3">
            @if ($message = session()->pull('success'))
                <div class="alert alert-success show alert-dismissible mb-4" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($message = session()->pull('error'))
                <div class="alert alert-danger show alert-dismissible mb-4" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($message = session()->pull('warning'))
                <div class="alert alert-warning show alert-dismissible mb-4" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger show alert-dismissible mb-4" role="alert">
                An unexpected error has occurred. Please review your application information and try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- @isset($order)
        <div class="container-fluid">
            <div class="table-responsive py-3">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Reference</th>
                        <th scope="col">Applicant</th>
                        <th scope="col">Processing time</th>
                        <th scope="col">Purpose</th>
                        <th scope="col">Visa type</th>
                        <th scope="col">Entry port</th>
                        <th scope="col">Arrival date</th>
                        <th scope="col">Departure date</th>
                        <th scope="col">Total fees</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $status = match ($order->status) {
                            \App\Enums\OrderStatus::PENDING->value => 'text-bg-warning',
                            \App\Enums\OrderStatus::TRANSACTION_SUCCESS->value => 'text-bg-success',
                            \App\Enums\OrderStatus::PROCESSED->value => 'text-bg-success',
                            \App\Enums\OrderStatus::TRANSACTION_CANCELED->value => 'text-bg-info',
                            \App\Enums\OrderStatus::TRANSACTION_FAILED->value => 'text-bg-danger',
                            \App\Enums\OrderStatus::TRANSACTION_IN_PROGRESS->value => 'text-bg-warning',
                            \App\Enums\OrderStatus::CANCELLED->value => 'text-bg-danger',
                            default => 'text-bg-info',
                        };
                    @endphp

                    <tr>
                        <td>{{ $order->reference }}</td>
                        <td>{{ $order->applicant->full_name }}</td>
                        <td>{{ $order->processingTime->description }}</td>
                        <td>{{ $order->purpose->description }}</td>
                        <td>{{ $order->visaType->description }}</td>
                        <td>({{ $order->entryPort->type }}) {{ $order->entryPort->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->arrival_date)->format('M d Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->departure_date)->format('M d Y') }}</td>

                        @if ($order->total_fees_with_discount)
                        <td>${{ number_format($order->total_fees_with_discount, 2) }}</td>
                        @else
                        <td>${{ number_format($order->total_fees, 2) }}</td>
                        @endif

                        <td>
                            <span class="badge {{ $status }}" style="opacity: 0.5">
                                {{ $order->status }}
                            </span>
                        </td>

                        @isset($order->visa_pdf)
                            <td>
                                <a href="{{ url('storage/' . $order->visa_pdf) }}" target="_blank" class="btn btn-sm text-white" style="background-color: #118793">
                                    Download
                                </a>
                            </td>
                        @else
                            <td>-</td>
                        @endisset
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endisset -->





    @isset($order)

    @php
                        $status = match ($order->status) {
                            \App\Enums\OrderStatus::PENDING->value => 'text-bg-warning',
                            \App\Enums\OrderStatus::TRANSACTION_SUCCESS->value => 'text-bg-success',
                            \App\Enums\OrderStatus::PROCESSED->value => 'text-bg-success',
                            \App\Enums\OrderStatus::TRANSACTION_CANCELED->value => 'text-bg-info',
                            \App\Enums\OrderStatus::TRANSACTION_FAILED->value => 'text-bg-danger',
                            \App\Enums\OrderStatus::TRANSACTION_IN_PROGRESS->value => 'text-bg-warning',
                            \App\Enums\OrderStatus::CANCELLED->value => 'text-bg-danger',
                            default => 'text-bg-info',
                        };
                    @endphp

    <div class="container">
        <table class="table">
                    <thead>

                    @isset($order->visa_pdf)
                    <tr>  
                        <th scope="col">Your Evisa is ready</th>
                        
                            <td>
                                <a href="{{ url('storage/' . $order->visa_pdf) }}" target="_blank" class="btn btn-sm text-white" style="background-color: red">
                                    Download your Evisa
                                </a>
                            </td>
                        
                        
                    </tr>
                    @endisset

                    <tr>
                        <th scope="col">Reference</th>
                        <td>{{ $order->reference }}</td>
                    <tr>

                    <tr>
                        <th scope="col">Applicant</th>
                        <td>{{ $order->applicant->full_name }}</td>
                    <tr> 
                    <tr>  
                        <th scope="col">Processing time</th>
                        <td>{{ $order->processingTime->description }}</td>
                    <tr> 
                    <tr>  
                        <th scope="col">Purpose</th>
                        <td>{{ $order->purpose->description }}</td>
                    <tr> 
                    <tr>      
                        <th scope="col">Visa type</th>
                        <td>{{ $order->visaType->description }}</td>
                    <tr> 
                    <tr>  
                        <th scope="col">Entry port</th>
                        <td>({{ $order->entryPort->type }}) {{ $order->entryPort->name }}</td>
                    <tr> 
                    <tr>  
                        <th scope="col">Arrival date</th>
                        <td>{{ \Carbon\Carbon::parse($order->arrival_date)->format('M d Y') }}</td>
                    <tr> 
                    <tr>  
                        <th scope="col">Departure date</th>
                        <td>{{ \Carbon\Carbon::parse($order->departure_date)->format('M d Y') }}</td>
                    <tr> 
                    <tr>  
                        <th scope="col">Total fees</th>
                        @if ($order->total_fees_with_discount)
                        <td>${{ number_format($order->total_fees_with_discount, 2) }}</td>
                        @else
                        <td>${{ number_format($order->total_fees, 2) }}</td>
                        @endif
                    <tr> 
                    <tr>  
                        <th scope="col">Status</th>
                        <td>
                            <span class="badge {{ $status }}" style="opacity: 0.5">
                                {{ $order->status }}
                            </span>
                        </td>
                    <tr> 
                    
                    </thead>
                    <tbody>
                </table>
                    </div>

                    @endisset






















    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.30.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function displayAlertMessage(message, type = 'warning', reload = false) {
            Swal.fire({
                text: message,
                icon: type,
                confirmButtonColor: '#0099DD',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then((result) => {
                if (reload && result.isConfirmed) {
                    document.location.reload()
                }
            })
        }
    </script>

    @stack('scripts')
</body>

</html>
