@extends('backend.app')
@section('title', 'SMS Settings')
@section('page-content')
<div class="container mt-4">

    <!-- 🔹 SMS Summary Cards -->
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h5 class="text-muted">Total SMS</h5>
                    <h2 class="fw-bold text-primary">{{ $totalSms }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h5 class="text-muted">Total Sent SMS</h5>
                    <h2 class="fw-bold text-success">{{ $totalSent }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h5 class="text-muted">Remaining SMS</h5>
                    <h2 class="fw-bold text-danger">{{ $remaining }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔹 Single SMS Form -->
    <div class="row mt-5">

        <!-- 🔹 Single SMS -->
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Send Single SMS</h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.sms.single.send') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" placeholder="017XXXXXXXX">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message</label>

                            <textarea
                                name="message"
                                id="singleMessage"
                                class="form-control"
                                rows="4"></textarea>

                            <div class="mt-2 d-flex justify-content-between">
                                <small>Characters:
                                    <span id="singleChar">0</span>
                                </small>

                                <small class="text-primary">
                                    SMS:
                                    <span id="singleSms">0</span>
                                </small>
                            </div>

                        </div>

                        <button class="btn btn-success">Send SMS</button>

                    </form>

                </div>
            </div>
        </div>


        <!-- 🔹 Bulk SMS -->
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Send Bulk SMS</h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.sms.bulk.send') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Mobile Numbers</label>

                            <textarea
                                name="mobile"
                                class="form-control"
                                rows="3"
                                placeholder="017XXXXXXX,018XXXXXXX,016XXXXXXX"></textarea>

                            <small class="text-muted">
                                Separate numbers with comma (,)
                            </small>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Message</label>

                            <textarea
                                name="message"
                                id="bulkMessage"
                                class="form-control"
                                rows="4"></textarea>

                            <div class="mt-2 d-flex justify-content-between">
                                <small>
                                    Characters:
                                    <span id="bulkChar">0</span>
                                </small>

                                <small class="text-primary">
                                    SMS:
                                    <span id="bulkSms">0</span>
                                </small>
                            </div>
                        </div>

                        <button class="btn btn-danger">
                            Send Bulk SMS
                        </button>

                    </form>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    function smsCounter(textarea, charEl, smsEl) {

        textarea.addEventListener('input', function () {

            let length = [...this.value].length;

            charEl.textContent = length;

            let sms = Math.ceil(length / 51);

            smsEl.textContent = length > 0 ? sms : 0;

        });

    }

    smsCounter(
        document.getElementById('singleMessage'),
        document.getElementById('singleChar'),
        document.getElementById('singleSms')
    );

    smsCounter(
        document.getElementById('bulkMessage'),
        document.getElementById('bulkChar'),
        document.getElementById('bulkSms')
    );

});
</script>
@endpush