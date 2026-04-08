@extends('backend.app')
@section('title','Profit Report')

@section('page-content')

<div class="container-fluid mt-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark">Profit Report</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('profit.report') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Voucher No</label>
                        <input type="text" name="voucher_no" class="form-control"
                            value="{{ request('voucher_no') }}" placeholder="Ex: V-1001">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">From Date</label>
                        <input type="date" name="from_date" class="form-control"
                            value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">To Date</label>
                        <input type="date" name="to_date" class="form-control"
                            value="{{ request('to_date') }}">
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary px-4"><i class="fas fa-search me-1"></i> Search</button>
                        <a href="{{ route('profit.report') }}" class="btn btn-danger px-4 ml-2">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Voucher No</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Total Quantity</th>
                            <th class="text-end">Total Sale Price</th>
                            <th class="text-end">Total Purchase Price</th>
                            <th class="text-end">Profit / Loss</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $totalQty = 0;
                            $totalSale = 0;
                            $totalPurchase = 0;
                            $totalProfit = 0;
                        @endphp

                        @forelse($profits as $item)
                        @php 
                            $totalQty += $item->total_qty;
                            $totalSale += $item->total_sale_price;
                            $totalPurchase += $item->total_product_price;
                            $totalProfit += $item->profit;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $item->voucher_no }}</td>
                            <td class="text-center">
                                @if($item->type == 'out')
                                <span class="bg-success-subtle text-success border border-success-subtle px-4">Sale</span>
                                @else
                                <span class="bg-warning-subtle text-warning border border-warning-subtle px-4">Return</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->total_qty }}</td>
                            <td class="text-end">{{ number_format($item->total_sale_price, 2) }}</td>
                            <td class="text-end">{{ number_format($item->total_product_price, 2) }}</td>
                            <td class="text-end fw-bold {{ $item->profit >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($item->profit, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No Data Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                    
                    @if($profits->count() > 0)
                    <tfoot class="table-secondary fw-bold">
                        <tr>
                            <td colspan="3" class="text-end">Grand Total:</td>
                            <td class="text-center">{{ $totalQty }}</td>
                            <td class="text-end">{{ number_format($totalSale, 2) }}</td>
                            <td class="text-end">{{ number_format($totalPurchase, 2) }}</td>
                            <td class="text-end {{ $totalProfit >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($totalProfit, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection