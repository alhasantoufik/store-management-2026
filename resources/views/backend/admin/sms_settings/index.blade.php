@extends('backend.app')

@section('title', 'SMS Logs')

@section('page-content')

<div class="container mt-4">

    <div class="card shadow p-4">

        <h4 class="mb-4">SMS Summary</h4>

        <!-- Date Filter -->
        <form method="GET" action="{{ route('admin.sms.send') }}">
            <div class="row mb-4">

                <div class="col-md-3">
                    <label>From Date</label>
                    <input type="date" name="from_date" class="form-control"
                        value="{{ request('from_date') }}">
                </div>

                <div class="col-md-3">
                    <label>To Date</label>
                    <input type="date" name="to_date" class="form-control"
                        value="{{ request('to_date') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-70">Search</button>
                </div>

            </div>
        </form>

        <!-- 📄 SMS Table -->
        <div class="table-responsive">
            <table class="table table-bordered">

                <thead class="table-light">
                    <tr>
                        <th>Sl.</th>
                        <th>Date</th>
                        <th>Mobile</th>
                        <th>Message</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($smsLogs as $key => $sms)

                    <tr>
                        <td>{{ $smsLogs->firstItem() + $key }}</td>
                        <td>{{ $sms->created_at->format('d M Y, h:i A') }}</td>
                        <td>{{ $sms->mobile }}</td>
                        <td>{{ $sms->message }}</td>
                        <td>
                            <span class="badge bg-success">
                                {{ $sms->status }}
                            </span>
                        </td>
                        
                    </tr>

                    @empty

                    <tr>
                        <td colspan="5" class="text-center">
                            No SMS Found
                        </td>
                    </tr>

                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $smsLogs->withQueryString()->links() }}
        </div>

    </div>

</div>

@endsection