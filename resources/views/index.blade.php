@extends('layout')

@section('title', 'E-Visa Vietnam Online - Application Form')

@section('content')
    <form action="{{ url('/orders') }}" method="POST" id="order-form" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-7">
                <div class="card border-0 p-3">
                    <div class="card-body">
                        <p class="fw-bold">What service are you interested in ?</p>

                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="service" id="evisa-service" value="evisa" checked>
                                <label class="form-check-label" for="evisa-service">E-Visa service</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="service" id="fast-track-service" value="fast_track">
                                <label class="form-check-label" for="fast-track-service">Fast Track service</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="service" id="evisa-fast-track-service" value="evisa_fast_track">
                                <label class="form-check-label" for="evisa-fast-track-service">E-Visa + Fast Track services</label>
                            </div>
                        </div>

                        <p class="fw-bold">Contact Information</p>

                        <div class="row mb-3">
                            <div class="col-md mb-3 mb-md-0">
                                <label for="full_name" class="form-label">Full name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter full name" required autofocus>
                                <div class="invalid-feedback full_name-error" style="display: none"></div>
                            </div>

                            <div class="col-md">
                                <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Enter date of birth" required>
                                <div class="invalid-feedback date_of_birth-error" style="display: none"></div>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-md mb-3 mb-md-0">
                                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">Select gender</option>
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender }}">
                                            {{ ucfirst($gender) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback gender-error" style="display: none"></div>
                            </div>

                            <div class="col-md">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                                <div class="invalid-feedback email-error" style="display: none"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md mb-3 mb-md-0">
                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required>
                                <div class="invalid-feedback address-error" style="display: none"></div>
                            </div>

                            <div class="col-md">
                                <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter phone number" required>
                                <div class="invalid-feedback phone_number-error" style="display: none"></div>
                            </div>
                        </div>

                        <p class="fw-bold mt-4">Passport Information</p>

                        <div class="row mb-3">
                            <div class="col-md mb-3 mb-md-0">
                                <div class="form-group">
                                    <label for="passport_number" class="form-label">Passport Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="passport_number" name="passport_number" placeholder="Enter passport number" required>
                                    <div class="invalid-feedback passport_number-error" style="display: none"></div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="passport_expiration_date" class="form-label">Passport Expiration Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="passport_expiration_date" name="passport_expiration_date" placeholder="Enter passport expiry" required>
                                    <div class="invalid-feedback passport_expiration_date-error" style="display: none"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md mb-3 mb-md-0">
                                <div class="form-group mb-3">
                                    <label for="photo" class="form-label">Portrait Photo <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
                                    <div class="invalid-feedback photo-error" style="display: none"></div>
                                </div>
                                <div class="position-relative" id="photo_preview"></div>
                            </div>
                            <div class="col-md">
                                <div class="form-group mb-3">
                                    <label for="passport_image" class="form-label">Passport Image <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="passport_image" name="passport_image" accept="image/*" required>
                                    <div class="invalid-feedback passport_image-error" style="display: none"></div>
                                </div>
                                <div class="position-relative" id="passport_image_preview"></div>
                            </div>
                        </div>

                        <p class="fw-bold mt-4">Flight Information</p>

                        <div class="form-group mb-3">
                            <label for="flight_ticket_image" class="form-label">Flight Ticket Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="flight_ticket_image" name="flight_ticket_image" accept="image/*">
                            <div class="invalid-feedback flight_ticket_image-error" style="display: none"></div>
                        </div>
                        <div class="position-relative" id="flight_ticket_image_preview"></div>

                        <div id="evisa-service-options" style="{{ !str_contains(old('service', 'evisa'), 'evisa') ? 'display: none' : "" }}">
                            <p class="fw-bold mt-4">Visa Options</p>

                            <div class="row mb-3">
                                <div class="col-md mb-3 mb-md-0">
                                    <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                    <select class="form-select" id="country" name="country" required>
                                        <option value="">Select country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback country-error" style="display: none"></div>
                                </div>

                                <div class="col-md">
                                    <label for="processing_time_id" class="form-label">Processing Time <span class="text-danger">*</span></label>
                                    <select class="form-select" id="processing_time_id" name="processing_time_id">
                                        <option value="">Select processing time</option>
                                        @foreach ($processingTime as $option)
                                            <option value="{{ $option->id }}">
                                                {{ $option->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback processing_time_id-error" style="display: none"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3 mb-md-0">
                                    <label for="purpose_id" class="form-label">Purpose <span class="text-danger">*</span></label>
                                    <select class="form-select" id="purpose_id" name="purpose_id">
                                        <option value="">Select purpose</option>
                                        @foreach ($purposes as $option)
                                            <option value="{{ $option->id }}">
                                                {{ $option->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback purpose_id-error" style="display: none"></div>
                                </div>

                                <div class="col-md">
                                    <label for="visa_type_id" class="form-label">Visa Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="visa_type_id" name="visa_type_id">
                                        <option value="">Select visa type</option>
                                        @foreach ($visaTypes as $option)
                                            <option value="{{ $option->id }}">
                                                {{ $option->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback visa_type_id-error" style="display: none"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3 mb-md-0">
                                    <label for="arrival_date" class="form-label" id="arrival_date_label">Arrival date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="arrival_date" name="arrival_date" placeholder="Enter arrival date">
                                    <div class="invalid-feedback arrival_date-error" style="display: none"></div>
                                </div>

                                <div class="col-md">
                                    <label for="departure_date" class="form-label">Departure date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="departure_date" name="departure_date" placeholder="Enter departure date">
                                    <div class="invalid-feedback departure_date-error" style="display: none"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md mb-3 mb-md-0">
                                    <label for="entry_port_id" class="form-label" id="entry_port_label">Entry Port <span class="text-danger">*</span></label>
                                    <select class="form-select" id="entry_port_id" name="entry_port_id">
                                        <option value="">Select entry port</option>
                                        @foreach ($entryPorts as $group)
                                            <optgroup label="{{ $group['type'] }}">
                                                @foreach ($group['entryPorts'] as $entryPort)
                                                    <option value="{{ $entryPort['id'] }}">
                                                        {{ $entryPort['name'] }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback entry_port_id-error" style="display: none"></div>
                                </div>

                                <div class="col-md">
                                    <label for="address_vietnam" class="form-label">Address (Vietnam) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="address_vietnam" name="address_vietnam" placeholder="Enter address" required>
                                    <div class="invalid-feedback address_vietnam-error" style="display: none"></div>
                                </div>
                            </div>
                        </div>

                        <div id="fast-track-service-options" style="{{ !str_contains(old('service', 'evisa'), 'fast_track') ? 'display: none' : "" }}">
                            <p class="fw-bold mt-4">Fast Track Options</p>

                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="checkbox" name="fast_track_arrival_option" id="fast_track_arrival_option" value="Arrival" checked>
                                <label class="form-check-label" for="fast_track_arrival_option">On Arrival</label>
                            </div>

                            <div id="fast_track_arrival_options">
                                <div class="row mb-3">
                                    <div class="col-md mb-3 mb-md-0">
                                        <label for="fast_track_entry_port_id" class="form-label">Entry Port <span class="text-danger">*</span></label>

                                        <select class="form-select" id="fast_track_entry_port_id" name="fast_track_entry_port_id">
                                            <option value="">Select entry port</option>
                                            @foreach ($fastTrackEntryPorts as $group)
                                                <optgroup label="{{ $group['type'] }}">
                                                    @foreach ($group['entryPorts'] as $entryPort)
                                                        <option value="{{ $entryPort['id'] }}">
                                                            {{ $entryPort['name'] }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback fast_track_entry_port_id-error" style="display: none"></div>
                                    </div>

                                    <div class="col-md">
                                        <label for="time_slot_id" class="form-label">Arrival time slot <span class="text-danger">*</span></label>
                                        <select class="form-select" id="time_slot_id" name="time_slot_id">
                                            <option value="">Select time slot</option>
                                            @foreach ($timeSlots as $timeSlot)
                                                <option value="{{ $timeSlot->id }}">
                                                    {{ $timeSlot->name }} ({{ $timeSlot->start_time }} to {{ $timeSlot->end_time }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback time_slot_id-error" style="display: none"></div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md mb-3 mb-md-0">
                                        <label for="fast_track_date" class="form-label">Arrival date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="fast_track_date" name="fast_track_date">
                                        <div class="invalid-feedback fast_track_date-error" style="display: none"></div>
                                    </div>

                                    <div class="col-md">
                                        <label for="fast_track_date" class="form-label">Arrival time <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" id="fast_track_time" name="fast_track_time">
                                        <div class="invalid-feedback fast_track_time-error" style="display: none"></div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md mb-3 mb-md-0">
                                        <label for="fast_track_flight_number" class="form-label">Arrival flight number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="fast_track_flight_number" name="fast_track_flight_number" placeholder="Enter flight number">
                                        <div class="invalid-feedback fast_track_flight_number-error" style="display: none"></div>
                                    </div>

                                    <div class="col-md"></div>
                                </div>
                            </div>

                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="checkbox" name="fast_track_departure_option" id="fast_track_departure_option" value="Departure">
                                <label class="form-check-label" for="fast_track_departure_option">On Departure</label>
                            </div>

                            <div id="fast_track_departure_options" style="display: none">
                                <div class="row mb-3">
                                    <div class="col-md mb-3 mb-md-0">
                                        <label for="fast_track_entry_port_id" class="form-label">Exit Port <span class="text-danger">*</span></label>

                                        <select class="form-select" id="fast_track_exit_port_id" name="fast_track_exit_port_id">
                                            <option value="">Select exit port</option>
                                            @foreach ($fastTrackExitPorts as $group)
                                                <optgroup label="{{ $group['type'] }}">
                                                    @foreach ($group['exitPorts'] as $entryPort)
                                                        <option value="{{ $entryPort['id'] }}">
                                                            {{ $entryPort['name'] }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback fast_track_exit_port_id-error" style="display: none"></div>
                                    </div>

                                    <div class="col-md">
                                        <label for="time_slot_id" class="form-label">Departure time slot <span class="text-danger">*</span></label>
                                        <select class="form-select" id="time_slot_departure_id" name="time_slot_departure_id">
                                            <option value="">Select time slot</option>
                                            @foreach ($timeSlotsDeparture as $timeSlot)
                                                <option value="{{ $timeSlot->id }}">
                                                    {{ $timeSlot->name }} ({{ $timeSlot->start_time }} to {{ $timeSlot->end_time }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback time_slot_departure_id-error" style="display: none"></div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md mb-3 mb-md-0">
                                        <label for="fast_track_date" class="form-label">Departure date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="fast_track_departure_date" name="fast_track_departure_date">
                                        <div class="invalid-feedback fast_track_departure_date-error" style="display: none"></div>
                                    </div>

                                    <div class="col-md">
                                        <label for="fast_track_date" class="form-label">Departure time <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" id="fast_track_departure_time" name="fast_track_departure_time">
                                        <div class="invalid-feedback fast_track_departure_time-error" style="display: none"></div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                <div class="col-md mb-3 mb-md-0">
                                    <label for="fast_track_flight_number_departure" class="form-label">Departure flight number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="fast_track_flight_number_departure" name="fast_track_flight_number_departure" placeholder="Enter flight number">
                                    <div class="invalid-feedback fast_track_flight_number_departure-error" style="display: none"></div>
                                </div>

                                <div class="col-md"></div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 my-3 my-md-0">
                <div class="sticky-top">
                    <div class="card border-0 p-3">
                        <div class="card-body">
                            <p class="fw-bold">Checkout Summary</p>

                            <div class="mb-3">
                                <p class="fw-bold mb-0">E-Visa service</p>

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Arrival date</p>
                                    <p class="mb-0" style="color: #118793;" id="selected_arrival_date">N/A</p>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Departure date</p>
                                    <p class="mb-0" style="color: #118793;" id="selected_departure_date">N/A</p>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Entry port</p>
                                    <p class="mb-0" style="color: #118793;" id="selected_entry_port">N/A</p>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Processing Time</p>
                                    <p class="mb-0" style="color: #118793;">
                                        <span id="processing_time_description">N/A</span> + $<span
                                            id="processing_time_fees">0.00</span>
                                    </p>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Purpose</p>
                                    <p class="mb-0" style="color: #118793;">
                                        <span id="purpose_description">N/A</span> + $<span id="purpose_fees">0.00</span>
                                    </p>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Visa Type</p>
                                    <p class="mb-0" style="color: #118793;">
                                        <span id="visa_type_description">N/A</span> + $<span id="visa_type_fees">0.00</span>
                                    </p>
                                </div>
                            </div>

                            <hr style="border: 1px solid black">

                            <div class="mb-3">
                                <p class="fw-bold mb-0">Fast Track service</p>

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Arrival time slot</p>
                                    <p class="mb-0" style="color: #118793;">
                                        <span id="time_slot_description">N/A</span> + $<span id="time_slot_fees">0.00</span>
                                    </p>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Entry Port</p>
                                    <p class="mb-0" style="color: #118793;" id="selected_fast_track_entry_port">N/A</p>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Arrival Date</p>
                                    <p class="mb-0" style="color: #118793;" id="selected_fast_track_date">N/A</p>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Arrival Time</p>
                                    <p class="mb-0" style="color: #118793;" id="selected_fast_track_time">N/A</p>
                                </div>

                                <hr style="border-style: dashed">

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Departure time slot</p>
                                    <p class="mb-0" style="color: #118793;">
                                        <span id="time_slot_departure_description">N/A</span> + $<span id="time_slot_departure_fees">0.00</span>
                                    </p>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Exit Port</p>
                                    <p class="mb-0" style="color: #118793;" id="selected_fast_track_exit_port">N/A</p>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Departure Date</p>
                                    <p class="mb-0" style="color: #118793;" id="selected_fast_track_departure_date">N/A</p>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Departure Time</p>
                                    <p class="mb-0" style="color: #118793;" id="selected_fast_track_departure_time">N/A</p>
                                </div>
                            </div>

                            <hr style="border: 1px solid black">

                            <div class="d-flex justify-content-between">
                                <p class="fw-bold mb-0">Sub-total</p>
                                <p class="mb-0" style="color: #118793;">
                                    $<span id="total_fees">0.00</span>
                                </p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="fw-bold mb-0">Discount</p>
                                <p class="mb-0" style="color: #118793;" id="discount">-0%</p>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <p class="fw-bold mb-0">Total</p>
                                <p class="mb-0" style="color: #118793;">
                                    $<span id="total_fees_discount">0.00</span>
                                </p>
                            </div>

                            <div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <input type="text" class="form-control me-1" id="voucher" name="voucher" placeholder="Enter voucher code">
                                    <button type="button" class="btn text-white ms-1" style="background-color: #118793" id="voucher-button">Apply</button>
                                </div>
                                <div class="invalid-feedback voucher-error" style="display: none"></div>
                            </div>

                            <div class="mt-3 p-3" style="background-color: #F1F1F1;">
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="termsCheck">
                                    <label for="termsCheck" class="form-check-label">
                                        <span>I have read and understood the</span>
                                        <a href="#" class="text-decoration-none" target="_blank" style="color: #118793;">Terms and Agreements</a>
                                    </label>
                                </div>

                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                    <button class="btn" type="button" id="reload-security-code">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                            <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                                            <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
                                        </svg>
                                    </button>
                                    <div id="security-code" class="me-3 py-1 px-5 rounded text-decoration-line-through text-white" style="background-color: #118793"></div>
                                    <input type="text" class="form-control" id="security-code-input" autocomplete="off" placeholder="Enter security code">
                                </div>

                                <button type="submit" class="btn w-100" style="background-color: #118793" disabled id="order-form-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1" />
                                    </svg>
                                    <span class="ms-2 text-white">Confirm payment</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 mt-3 p-3">
                        <div class="card-body">
                            <p class="fw-bold">How did you hear about us ?</p>

                            <div class="d-flex align-items-center justify-content-between">
                                <select class="form-select me-1" id="feedback">
                                    <option value="">Select an option</option>
                                    @foreach ($feedbacks as $feedback)
                                        <option value="{{ $feedback->id }}">
                                            {{ $feedback->title }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn text-white ms-1" style="background-color: #118793" id="feedback-button">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const getTotalFees = () => {
                const totalFees = parseInt(document.querySelector('#processing_time_fees').textContent) +
                    parseInt(document.querySelector('#purpose_fees').textContent) +
                    parseInt(document.querySelector('#visa_type_fees').textContent) +
                    parseInt(document.querySelector('#time_slot_fees').textContent) +
                    parseInt(document.querySelector('#time_slot_departure_fees').textContent)

                return totalFees.toFixed(2)
            }

            document
                .querySelector('#voucher-button')
                .addEventListener('click', () => {
                    if (document.querySelector('#voucher').value === '') {
                        document.querySelector('#total_fees_discount').textContent = getTotalFees()
                    } else {
                        document.querySelector('#voucher-button').innerHTML =
                            '<div class="spinner-border spinner-border-sm text-light" role="status"></div>'

                        fetch("{{ url('/api/voucher') }}/" + document.querySelector('#voucher').value)
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'error') {
                                    return displayAlertMessage(data.message, 'error')
                                }

                                const discount = parseInt(data.message)
                                const totalFees = getTotalFees()
                                const totalFeesDiscount = totalFees - ((discount * totalFees) / 100)

                                document.querySelector('#discount').textContent = `-${discount}%`
                                document.querySelector('#total_fees_discount').textContent = `${totalFeesDiscount.toFixed(2)}`
                            })
                            .finally(() => document.querySelector('#voucher-button').innerHTML = 'Apply')
                    }
                })

            document
                .querySelector('#feedback-button')
                .addEventListener('click', () => {
                    if (document.querySelector('#feedback').value !== '') {
                        document.querySelector('#feedback-button').innerHTML =
                            '<div class="spinner-border spinner-border-sm text-light" role="status"></div>'

                        fetch("{{ url('/api/feedback') }}/" + document.querySelector('#feedback').value)
                            .then(res => res.json())
                            .then(data => displayAlertMessage(data.message, data.status))
                            .finally(() => {
                                document.querySelector('#feedback-button').innerHTML = 'Submit'
                                document.querySelector('#feedback').value = ''
                            })
                    }
                })

            document
                .querySelector('#order-form-button')
                .addEventListener('click', e => {
                    e.preventDefault()

                    if ((
                            document.querySelector('#fast-track-service').checked ||
                            document.querySelector('#evisa-fast-track-service').checked
                        ) && (
                            ! document.querySelector('#fast_track_arrival_option').checked &&
                            ! document.querySelector('#fast_track_departure_option').checked
                    )) {
                        return displayAlertMessage('You must select at least one of the fast track option', 'error')
                    }

                    if (document.querySelector('#security-code').textContent !== document.querySelector('#security-code-input').value) {
                        document.querySelector('#security-code-input'). focus()
                        return displayAlertMessage('Invalid security code', 'error')
                    }

                    sendRequest(document.querySelector('#order-form'), e.target)
                })

            document
                .querySelector('#passport_image')
                .addEventListener('change', e => {
                    document.querySelector('#passport_image_preview').innerHTML = `
                        <img src="${URL.createObjectURL(e.target.files[0])}" width="300" alt="Passport image"/>
                    `
                })

            document
                .querySelector('#photo')
                .addEventListener('change', e => {
                    document.querySelector('#photo_preview').innerHTML = `
                        <img src="${URL.createObjectURL(e.target.files[0])}" width="100" alt="Photo"/>
                    `
                })

            document
                .querySelector('#flight_ticket_image')
                .addEventListener('change', e => {
                    document.querySelector('#flight_ticket_image_preview').innerHTML = `
                        <img src="${URL.createObjectURL(e.target.files[0])}" width="300" alt="Flight ticket image"/>
                    `
                })

            document
                .querySelector('#termsCheck')
                .addEventListener('change', e => document.querySelector('#order-form-button').disabled = !e.target.checked)

            document
                .querySelector('#arrival_date')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        document.querySelector('#selected_arrival_date').textContent = moment(e.target.value).format('ll')
                    } else {
                        document.querySelector('#selected_arrival_date').textContent = 'N/A'
                    }
                })

            document
                .querySelector('#departure_date')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        document.querySelector('#selected_departure_date').textContent = moment(e.target.value).format('ll')
                    } else {
                        document.querySelector('#selected_departure_date').textContent = 'N/A'
                    }
                })

            document
                .querySelector('#fast_track_date')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        document.querySelector('#selected_fast_track_date').textContent = moment(e.target.value).format('ll')
                    } else {
                        document.querySelector('#selected_fast_track_date').textContent = 'N/A'
                    }
                })

            document
                .querySelector('#fast_track_time')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        document.querySelector('#selected_fast_track_time').textContent = e.target.value
                    } else {
                        document.querySelector('#selected_fast_track_time').textContent = 'N/A'
                    }
                })

            document
                .querySelector('#fast_track_departure_date')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        document.querySelector('#selected_fast_track_departure_date').textContent = moment(e.target.value).format('ll')
                    } else {
                        document.querySelector('#selected_fast_track_departure_date').textContent = 'N/A'
                    }
                })

            document
                .querySelector('#fast_track_departure_time')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        document.querySelector('#selected_fast_track_departure_time').textContent = e.target.value
                    } else {
                        document.querySelector('#selected_fast_track_departure_time').textContent = 'N/A'
                    }
                })

            document
                .querySelector('#entry_port_id')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        fetch("{{ url('/api/entry-ports') }}/" + e.target.value)
                            .then(res => res.json())
                            .then(data => document.querySelector('#selected_entry_port').textContent = data.name)
                    } else {
                        document.querySelector('#selected_entry_port').textContent = 'N/A'
                    }
                })

            document
                .querySelector('#fast_track_entry_port_id')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        fetch("{{ url('/api/entry-ports') }}/" + e.target.value)
                            .then(res => res.json())
                            .then(data => document.querySelector('#selected_fast_track_entry_port').textContent = data.name)
                    } else {
                        document.querySelector('#selected_fast_track_entry_port').textContent = 'N/A'
                    }
                })

            document
                .querySelector('#fast_track_exit_port_id')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        fetch("{{ url('/api/entry-ports') }}/" + e.target.value)
                            .then(res => res.json())
                            .then(data => document.querySelector('#selected_fast_track_exit_port').textContent = data.name)
                    } else {
                        document.querySelector('#selected_fast_track_exit_port').textContent = 'N/A'
                    }
                })

            document
                .querySelector('#processing_time_id')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        fetch("{{ url('/api/processing-time') }}/" + e.target.value)
                            .then(res => res.json())
                            .then(data => {
                                document.querySelector('#processing_time_description').textContent = data.description
                                document.querySelector('#processing_time_fees').textContent = data.fees.toFixed(2)
                                document.querySelector('#total_fees').textContent = getTotalFees()
                                document.querySelector('#total_fees_discount').textContent = getTotalFees()
                                document.querySelector('#voucher-button').click()
                            })
                    } else {
                        document.querySelector('#processing_time_description').textContent = 'N/A'
                        document.querySelector('#processing_time_fees').textContent = '0.00'
                        document.querySelector('#total_fees').textContent = getTotalFees()
                        document.querySelector('#total_fees_discount').textContent = getTotalFees()
                        document.querySelector('#voucher-button').click()
                    }
                })

            document
                .querySelector('#time_slot_id')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        fetch("{{ url('/api/time-slots') }}/" + e.target.value)
                            .then(res => res.json())
                            .then(data => {
                                document.querySelector('#time_slot_description').textContent = data.name + `(${data.start_time} to ${data.end_time})`
                                document.querySelector('#time_slot_fees').textContent = data.fees.toFixed(2)
                                document.querySelector('#total_fees').textContent = getTotalFees()
                                document.querySelector('#total_fees_discount').textContent = getTotalFees()
                                document.querySelector('#voucher-button').click()
                            })
                    } else {
                        document.querySelector('#time_slot_description').textContent = 'N/A'
                        document.querySelector('#time_slot_fees').textContent = '0.00'
                        document.querySelector('#total_fees').textContent = getTotalFees()
                        document.querySelector('#total_fees_discount').textContent = getTotalFees()
                        document.querySelector('#voucher-button').click()
                    }
                })

            document
                .querySelector('#time_slot_departure_id')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        fetch("{{ url('/api/time-slots') }}/" + e.target.value)
                            .then(res => res.json())
                            .then(data => {
                                document.querySelector('#time_slot_departure_description').textContent = data.name + `(${data.start_time} to ${data.end_time})`
                                document.querySelector('#time_slot_departure_fees').textContent = data.fees.toFixed(2)
                                document.querySelector('#total_fees').textContent = getTotalFees()
                                document.querySelector('#total_fees_discount').textContent = getTotalFees()
                                document.querySelector('#voucher-button').click()
                            })
                    } else {
                        document.querySelector('#time_slot_departure_description').textContent = 'N/A'
                        document.querySelector('#time_slot_departure_fees').textContent = '0.00'
                        document.querySelector('#total_fees').textContent = getTotalFees()
                        document.querySelector('#total_fees_discount').textContent = getTotalFees()
                        document.querySelector('#voucher-button').click()
                    }
                })

            document
                .querySelector('#purpose_id')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        fetch("{{ url('/api/purposes') }}/" + e.target.value)
                            .then(res => res.json())
                            .then(data => {
                                document.querySelector('#purpose_description').textContent = data.description
                                document.querySelector('#purpose_fees').textContent = data.fees.toFixed(2)
                                document.querySelector('#total_fees').textContent = getTotalFees()
                                document.querySelector('#total_fees_discount').textContent = getTotalFees()
                                document.querySelector('#voucher-button').click()
                            })
                    } else {
                        document.querySelector('#purpose_description').textContent = 'N/A'
                        document.querySelector('#purpose_fees').textContent = '0.00'
                        document.querySelector('#total_fees').textContent = getTotalFees()
                        document.querySelector('#total_fees_discount').textContent = getTotalFees()
                        document.querySelector('#voucher-button').click()
                    }
                })

            document
                .querySelector('#visa_type_id')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        fetch("{{ url('/api/visa-types') }}/" + e.target.value)
                            .then(res => res.json())
                            .then(data => {
                                document.querySelector('#visa_type_description').textContent = data.description
                                document.querySelector('#visa_type_fees').textContent = data.fees.toFixed(2)
                                document.querySelector('#total_fees').textContent = getTotalFees()
                                document.querySelector('#total_fees_discount').textContent = getTotalFees()
                                document.querySelector('#voucher-button').click()
                            })
                    } else {
                        document.querySelector('#visa_type_description').textContent = 'N/A'
                        document.querySelector('#visa_type_fees').textContent = '0.00'
                        document.querySelector('#total_fees').textContent = getTotalFees()
                        document.querySelector('#total_fees_discount').textContent = getTotalFees()
                        document.querySelector('#voucher-button').click()
                    }
                })

            document
                .querySelector('#fast_track_departure_option')
                .addEventListener('change', e => {
                    if (! e.target.checked) {
                        document.querySelector('#fast_track_exit_port_id').value = ''
                        document.querySelector('#selected_fast_track_exit_port').textContent = 'N/A'
                        document.querySelector('#fast_track_exit_port_id').click()

                        document.querySelector('#fast_track_departure_date').value = ''
                        document.querySelector('#selected_fast_track_departure_date').textContent = 'N/A'
                        document.querySelector('#fast_track_departure_date').click()

                        document.querySelector('#fast_track_departure_time').value = ''
                        document.querySelector('#selected_fast_track_departure_time').textContent = 'N/A'
                        document.querySelector('#fast_track_departure_time').click()

                        document.querySelector('#time_slot_departure_id').value = ''
                        document.querySelector('#time_slot_departure_description').textContent = 'N/A'
                        document.querySelector('#time_slot_departure_fees').textContent = '0.00'
                        document.querySelector('#time_slot_departure_id').click()

                        document.querySelector('#total_fees').textContent = getTotalFees()
                        document.querySelector('#total_fees_discount').textContent = getTotalFees()
                        document.querySelector('#voucher-button').click()

                        document.querySelector('#fast_track_departure_options').style.display = 'none'
                    } else {
                        document.querySelector('#fast_track_departure_options').style.display = 'block'
                    }
                })

            document
                .querySelector('#fast_track_arrival_option')
                .addEventListener('change', e => {
                    if (! e.target.checked) {
                        document.querySelector('#fast_track_entry_port_id').value = ''
                        document.querySelector('#selected_fast_track_entry_port').textContent = 'N/A'
                        document.querySelector('#fast_track_entry_port_id').click()

                        document.querySelector('#fast_track_date').value = ''
                        document.querySelector('#selected_fast_track_date').textContent = 'N/A'
                        document.querySelector('#fast_track_date').click()

                        document.querySelector('#fast_track_time').value = ''
                        document.querySelector('#selected_fast_track_time').textContent = 'N/A'
                        document.querySelector('#fast_track_time').click()

                        document.querySelector('#time_slot_id').value = ''
                        document.querySelector('#time_slot_description').textContent = 'N/A'
                        document.querySelector('#time_slot_fees').textContent = '0.00'
                        document.querySelector('#time_slot_id').click()

                        document.querySelector('#total_fees').textContent = getTotalFees()
                        document.querySelector('#total_fees_discount').textContent = getTotalFees()
                        document.querySelector('#voucher-button').click()

                        document.querySelector('#fast_track_arrival_options').style.display = 'none'
                    } else {
                        document.querySelector('#fast_track_arrival_options').style.display = 'block'
                    }
                })

            document
                .querySelectorAll('input[name="service"]')
                .forEach(el => {
                    el.addEventListener('click', e => {
                        if (e.currentTarget.id === 'evisa-service') {
                            document.querySelector('#evisa-service-options').style.display = 'block'
                            document.querySelector('#fast-track-service-options').style.display = 'none'

                            document.querySelector('#fast_track_entry_port_id').value = ''
                            document.querySelector('#selected_fast_track_entry_port').textContent = 'N/A'
                            document.querySelector('#fast_track_entry_port_id').click()

                            document.querySelector('#fast_track_exit_port_id').value = ''
                            document.querySelector('#selected_fast_track_exit_port').textContent = 'N/A'
                            document.querySelector('#fast_track_exit_port_id').click()

                            document.querySelector('#fast_track_date').value = ''
                            document.querySelector('#selected_fast_track_date').textContent = 'N/A'
                            document.querySelector('#fast_track_date').click()

                            document.querySelector('#fast_track_time').value = ''
                            document.querySelector('#selected_fast_track_time').textContent = 'N/A'
                            document.querySelector('#fast_track_time').click()

                            document.querySelector('#fast_track_departure_date').value = ''
                            document.querySelector('#selected_fast_track_departure_date').textContent = 'N/A'
                            document.querySelector('#fast_track_departure_date').click()

                            document.querySelector('#fast_track_departure_time').value = ''
                            document.querySelector('#selected_fast_track_departure_time').textContent = 'N/A'
                            document.querySelector('#fast_track_departure_time').click()

                            document.querySelector('#time_slot_id').value = ''
                            document.querySelector('#time_slot_description').textContent = 'N/A'
                            document.querySelector('#time_slot_fees').textContent = '0.00'
                            document.querySelector('#time_slot_id').click()

                            document.querySelector('#time_slot_departure_id').value = ''
                            document.querySelector('#time_slot_departure_description').textContent = 'N/A'
                            document.querySelector('#time_slot_departure_fees').textContent = '0.00'
                            document.querySelector('#time_slot_departure_id').click()

                            document.querySelector('#total_fees').textContent = getTotalFees()
                            document.querySelector('#total_fees_discount').textContent = getTotalFees()
                            document.querySelector('#voucher-button').click()

                            document.querySelector("#entry_port_label").style.display = 'block'
                            document.querySelector("#arrival_date_label").style.display = 'block'
                            document.querySelector("#arrival_date").style.display = 'block'
                            document.querySelector("#entry_port_id").style.display = 'block'
                        } else if (e.currentTarget.id === 'fast-track-service') {
                            document.querySelector('#fast-track-service-options').style.display = 'block'
                            document.querySelector('#evisa-service-options').style.display = 'none'

                            document.querySelector('#entry_port_id').value = ''
                            document.querySelector('#selected_entry_port').textContent = 'N/A'
                            document.querySelector('#entry_port_id').click()

                            document.querySelector('#arrival_date').value = ''
                            document.querySelector('#selected_arrival_date').textContent = 'N/A'
                            document.querySelector('#arrival_date').click()

                            document.querySelector('#departure_date').value = ''
                            document.querySelector('#selected_departure_date').textContent = 'N/A'
                            document.querySelector('#departure_date').click()

                            document.querySelector('#visa_type_id').value = ''
                            document.querySelector('#visa_type_description').textContent = 'N/A'
                            document.querySelector('#visa_type_fees').textContent = '0.00'
                            document.querySelector('#visa_type_id').click()

                            document.querySelector('#purpose_id').value = ''
                            document.querySelector('#purpose_description').textContent = 'N/A'
                            document.querySelector('#purpose_fees').textContent = '0.00'
                            document.querySelector('#purpose_id').click()

                            document.querySelector('#processing_time_id').value = ''
                            document.querySelector('#processing_time_description').textContent = 'N/A'
                            document.querySelector('#processing_time_fees').textContent = '0.00'
                            document.querySelector('#processing_time_id').click()

                            document.querySelector('#flight_ticket_image').value = null
                            document.querySelector('#flight_ticket_image_preview').innerHTML = ''

                            document.querySelector('#total_fees').textContent = getTotalFees()
                            document.querySelector('#total_fees_discount').textContent = getTotalFees()
                            document.querySelector('#voucher-button').click()
                        } else {
                            document.querySelector('#fast-track-service-options').style.display = 'block'
                            document.querySelector('#evisa-service-options').style.display = 'block'
                        }
                    })
                })
        })

        //https://gist.github.com/RhythmShahriar/6bac24d4698fcd7e330d6da67198f4f5
        function generateCode() {
            const chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
            let result = ''

            for (let i = 6; i > 0; --i) {
                result += chars[Math.round(Math.random() * (chars.length - 1))]
            }

            return result
        }

        document.querySelector('#security-code').textContent = generateCode()

        document
            .querySelector('#reload-security-code')
            .addEventListener('click', () => document.querySelector('#security-code').textContent = generateCode())
    </script>
@endpush
