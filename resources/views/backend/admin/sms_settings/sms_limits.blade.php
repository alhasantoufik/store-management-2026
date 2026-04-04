@extends('backend.app')
@section('title', 'SMS Limit')
@section('page-content')

<div class="container mt-4">
    <div class="row">
        <!-- Left Form -->
        <div class="col-md-4">
            <div class="card shadow p-3">
                <h3><strong>Set SMS Limit</strong></h3>
                <br>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('admin.sms.module') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label>Date</label>
                        <input type="text" class="form-control" value="{{ $currentDate }}" readonly>
                    </div>
                    <div class="mb-2">
                        <label>Previous SMS</label>
                        <input type="text" class="form-control" value="{{ $previousSms }}" readonly>
                    </div>
                    <div class="mb-2">
                        <label>Amount (Taka)</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>SMS (1 Taka = 2 SMS)</label>
                        <input type="text" id="calculated_sms" class="form-control" value="0" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary w-40">Add SMS</button>
                </form>
            </div>
        </div>

        <!-- Right Table -->
        <div class="col-md-8">
            <div class="card shadow p-3">
                <h5><strong>SMS History</strong></h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>SMS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($smsLimits as $key => $sms)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $sms->date }}</td>
                            <td>{{ $sms->amount }}</td>
                            <td>{{ $sms->sms }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total</th>
                            <th>{{ $smsLimits->sum('amount') }}</th>
                            <th>{{ $smsLimits->sum('sms') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- JS for live SMS calculation -->
<script>
    const amountInput = document.querySelector('input[name="amount"]');
    const smsInput = document.getElementById('calculated_sms');

    amountInput.addEventListener('input', function() {
        smsInput.value = this.value * 2;
    });
</script>

@endsection