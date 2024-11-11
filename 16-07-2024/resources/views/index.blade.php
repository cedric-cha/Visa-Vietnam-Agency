@extends('layout')

@section('title', 'E-Visa Vietnam Online - Application Form')

@section('content')
    <form action="{{ url('/orders') }}" method="POST" id="order-form" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-7">
                <div class="card border-0 p-3">
                    <div class="card-body">
                        <p class="fw-bold">1. Contact Information</p>

                        <div class="row mb-3">
                            <div class="col-md mb-3 mb-md-0">
                                <label for="full_name" class="form-label">Full name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter full name" value="{{ old('full_name') }}" required autofocus>
                                @error('full_name')
                                <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md">
                                <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                <select class="form-select" id="country" name="country" required>
                                    <option value="">Select country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country') === (string) $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md mb-3 mb-md-0">
                                <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Enter date of birth" value="{{ old('date_of_birth') }}" required>
                                @error('date_of_birth')
                                <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md">
                                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">Select gender</option>
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender }}" {{ old('gender') === $gender ? 'selected' : '' }}>{{ ucfirst($gender) }}</option>
                                    @endforeach
                                </select>
                                @error('gender')
                                <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md mb-3 mb-md-0">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md">
                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="{{ old('address') }}" required>
                                @error('address')
                                <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md mb-3 mb-md-0">
                                <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter phone number" value="{{ old('phone_number') }}" required>
                                @error('phone_number')
                                <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md"></div>
                        </div>

                        <p class="fw-bold mt-4">2. Passport Information</p>

                        <div class="row mb-3">
                            <div class="col-md mb-3 mb-md-0">
                                <div class="form-group">
                                    <label for="passport_number" class="form-label">Passport Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="passport_number" name="passport_number" placeholder="Enter passport number" value="{{ old('passport_number') }}" required>
                                    @error('passport_number')
                                    <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="passport_expiration_date" class="form-label">Passport Expiration Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="passport_expiration_date" name="passport_expiration_date" placeholder="Enter passport expiry" value="{{ old('passport_expiration_date') }}" required>
                                    @error('passport_expiration_date')
                                    <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md mb-3 mb-md-0">
                                <div class="form-group mb-3">
                                    <label for="photo" class="form-label">Portrait Photo <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required value="{{ old('photo') }}">
                                    @error('photo')
                                    <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="position-relative" id="photo_preview"></div>
                            </div>
                            <div class="col-md">
                                <div class="form-group mb-3">
                                    <label for="passport_image" class="form-label">Passport Image <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="passport_image" name="passport_image" accept="image/*" required value="{{ old('passport_image') }}">
                                    @error('passport_image')
                                    <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="position-relative" id="passport_image_preview"></div>
                            </div>
                        </div>

                        <p class="fw-bold mt-4">3. Visa Options</p>

                        <div class="row mb-3">
                            <div class="col-md mb-3 mb-md-0">
                                <label for="processing_time_id" class="form-label">Processing Time <span class="text-danger">*</span></label>
                                <select class="form-select" id="processing_time_id" name="processing_time_id" required>
                                    <option value="">Select processing time</option>
                                    @foreach ($processingTime as $option)
                                        <option value="{{ $option->id }}" {{ old('processing_time_id') == $option->id ? 'selected' : '' }}>{{ $option->description }}</option>
                                    @endforeach
                                </select>
                                @error('processing_time_id')
                                <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md">
                                <label for="purpose_id" class="form-label">Purpose <span class="text-danger">*</span></label>
                                <select class="form-select" id="purpose_id" name="purpose_id" required>
                                    <option value="">Select purpose</option>
                                    @foreach ($purposes as $option)
                                        <option value="{{ $option->id }}" {{ old('purpose_id') == $option->id ? 'selected' : '' }}>
                                            {{ $option->description }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('purpose_id')
                                <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md mb-3 mb-md-0">
                                <label for="visa_type_id" class="form-label">Visa Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="visa_type_id" name="visa_type_id" required>
                                    <option value="">Select visa type</option>
                                    @foreach ($visaTypes as $option)
                                        <option value="{{ $option->id }}" {{ old('visa_type_id') == $option->id ? 'selected' : '' }}>
                                            {{ $option->description }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('visa_type_id')
                                <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md">
                                <label for="entry_port_id" class="form-label">Entry Port <span class="text-danger">*</span></label>
                                <select class="form-select" id="entry_port_id" name="entry_port_id" required>
                                    <option value="">Select entry port</option>
                                    @foreach ($entryPorts as $group)
                                        <optgroup label="{{ $group['type'] }}">
                                            @foreach ($group['entryPorts'] as $entryPort)
                                                <option value="{{ $entryPort['id'] }}" {{ old('entry_port_id') === (string) $entryPort['id'] ? 'selected' : '' }}>
                                                    {{ $entryPort['name'] }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('entry_port_id')
                                <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md mb-3 mb-md-0">
                                <label for="arrival_date" class="form-label">Arrival date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="arrival_date" name="arrival_date" placeholder="Enter arrival date" required value="{{ old('arrival_date') }}">
                                @error('arrival_date')
                                <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md">
                                <label for="departure_date" class="form-label">Departure date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="departure_date" name="departure_date" placeholder="Enter departure date" required value="{{ old('departure_date') }}">
                                @error('departure_date')
                                <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 my-3 my-md-0">
                <div class="card border-0 p-3 sticky-top">
                    <div class="card-body">
                        <p class="fw-bold">Checkout Summary</p>

                        <div class="mb-3">
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

                            <hr>

                            <div class="d-flex justify-content-between">
                                <p class="mb-0">Processing Time</p>
                                <p class="mb-0" style="color: #118793;">
                                    <span id="processing_time_description">N/A</span> + $<span id="processing_time_fees">0.00</span>
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

                        <hr>

                        <div class="d-flex justify-content-between">
                            <p class="mb-0">Sub-total</p>
                            <p class="mb-0" style="color: #118793;">
                                $<span id="total_fees">0.00</span>
                            </p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p class="mb-0">Discount</p>
                            <p class="mb-0" style="color: #118793;" id="discount">-0%</p>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <p class="mb-0">Total</p>
                            <p class="mb-0" style="color: #118793;">
                                $<span id="total_fees_discount">0.00</span>
                            </p>
                        </div>

                        <div>
                            <div class="d-flex align-items-center justify-content-between">
                                <input type="text" class="form-control me-1" id="voucher" name="voucher" placeholder="Enter voucher code" value="{{ old('voucher') }}">
                                <button type="button" class="btn text-white ms-1" style="background-color: #118793" id="voucher-button">Apply</button>
                            </div>
                            @error('voucher')
                            <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3 p-3" style="background-color: #F1F1F1;">
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="termsCheck">
                                <label for="termsCheck" class="form-check-label">
                                    <span>I have read and understood the</span>
                                    <a href="#" class="text-decoration-none" target="_blank" style="color: #118793;">Terms and Agreements</a>
                                </label>
                            </div>

                            <button type="submit" class="btn w-100" style="background-color: #118793" disabled id="order-form-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1"/>
                                </svg>
                                <span class="ms-2 text-white">Confirm payment</span>
                            </button>
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
            const getTotalFees = ()  => {
                const totalFees = parseInt(document.querySelector('#processing_time_fees').textContent) +
                    parseInt(document.querySelector('#purpose_fees').textContent) +
                    parseInt(document.querySelector('#visa_type_fees').textContent)

                return totalFees.toFixed(2)
            }

            if (document.querySelector('#arrival_date').value) {
                document.querySelector('#selected_arrival_date').textContent = moment(document.querySelector('#arrival_date').value).format('ll')
            }

            if (document.querySelector('#departure_date').value) {
                document.querySelector('#selected_departure_date').textContent = moment(document.querySelector('#departure_date').value).format('ll')
            }

            if (document.querySelector('#entry_port_id').value) {
                fetch("{{ url('/api/entry-ports') }}/" + document.querySelector('#entry_port_id').value)
                    .then(res => res.json())
                    .then(data => document.querySelector('#selected_entry_port').textContent = `(${data.type}) ` + data.name)
            }

            if (document.querySelector('#processing_time_id').value) {
                fetch("{{ url('/api/processing-time') }}/" + document.querySelector('#processing_time_id').value)
                    .then(res => res.json())
                    .then(data => {
                        document.querySelector('#processing_time_description').textContent = data.description;
                        document.querySelector('#processing_time_fees').textContent = data.fees.toFixed(2);
                        document.querySelector('#total_fees').textContent = getTotalFees();
                        document.querySelector('#total_fees_discount').textContent = getTotalFees();
                        document.querySelector('#voucher-button').click();
                    });
            }

            if (document.querySelector('#purpose_id').value) {
                fetch("{{ url('/api/purposes') }}/" + document.querySelector('#purpose_id').value)
                    .then(res => res.json())
                    .then(data => {
                        document.querySelector('#purpose_description').textContent = data.description;
                        document.querySelector('#purpose_fees').textContent = data.fees.toFixed(2);
                        document.querySelector('#total_fees').textContent = getTotalFees();
                        document.querySelector('#total_fees_discount').textContent = getTotalFees();
                        document.querySelector('#voucher-button').click();
                    });
            }

            if (document.querySelector('#visa_type_id').value) {
                fetch("{{ url('/api/visa-types') }}/" + document.querySelector('#visa_type_id').value)
                    .then(res => res.json())
                    .then(data => {
                        document.querySelector('#visa_type_description').textContent = data.description;
                        document.querySelector('#visa_type_fees').textContent = data.fees.toFixed(2);
                        document.querySelector('#total_fees').textContent = getTotalFees();
                        document.querySelector('#total_fees_discount').textContent = getTotalFees();
                        document.querySelector('#voucher-button').click();
                    });
            }

            document
                .querySelector('#voucher-button')
                .addEventListener('click', () => {

                    if (document.querySelector('#voucher').value === '') {
                        document.querySelector('#total_fees_discount').textContent = getTotalFees()
                    } else {
                        document.querySelector('#voucher-button').innerHTML = '<div class="spinner-border spinner-border-sm text-light" role="status"></div>'

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
                .querySelector('#order-form')
                .addEventListener('submit', e => {
                    e.preventDefault()
                    document.querySelector('#order-form-button').innerHTML = '<div class="spinner-border spinner-border-sm text-light" role="status"></div>'
                    e.target.submit()
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
                .querySelector('#termsCheck')
                .addEventListener('change', e => {
                    document.querySelector('#order-form-button').disabled = !e.target.checked
                })

            document
                .querySelector('#arrival_date')
                .addEventListener('change', e => {
                    document.querySelector('#selected_arrival_date').textContent = moment(e.target.value).format('ll')
                })

            document
                .querySelector('#departure_date')
                .addEventListener('change', e => {
                    document.querySelector('#selected_departure_date').textContent = moment(e.target.value).format('ll')
                })

            document
                .querySelector('#entry_port_id')
                .addEventListener('change', e => {
                    if (e.target.value) {
                        fetch("{{ url('/api/entry-ports') }}/" + e.target.value)
                            .then(res => res.json())
                            .then(data => document.querySelector('#selected_entry_port').textContent = `(${data.type}) ` + data.name)
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
                    }
                })
        })
    </script>
@endpush