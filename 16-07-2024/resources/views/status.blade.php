@extends('layout', ['order' => $order])

@section('title', 'E-Visa Vietnam Online - Check Status')

@section('content')
    @isset($order)
    @else
    <div class="mx-0 mx-md-5">
        <form action="{{ url('orders/status') }}" method="POST" id="check-order-form">
            @csrf

            <div class="row mb-3">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <label for="reference" class="form-label">Order Reference <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="reference" value="{{ old('reference', request()->get('reference', '')) }}" required autofocus name="reference">
                    @error('reference')
                    <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" value="{{ old('password', request()->get('password', '')) }}" required name="password">
                    @error('password')
                    <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-center mb-5">
                <button type="submit" class="btn text-white" style="background-color: #118793" id="check-order-button">
                    Check my order status
                </button>
            </div>
        </form>
    </div>
    @endisset
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('#check-order-form').addEventListener('submit', e => {
                e.preventDefault()
                document.querySelector('#check-order-button').innerHTML = '<div class="spinner-border spinner-border-sm text-light" role="status"></div>'
                e.target.submit()
            })
        })
    </script>
@endpush
