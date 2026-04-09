@extends('backend.app')
@section('title', 'All Stock Returns')
@section('page-content')

<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">All Stock Returns</h4>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('stockReturn.all') }}" class="row g-2 mb-4">
                <div class="col-md-3 col-sm-6">
                    <input type="text" name="voucher_no" class="form-control" placeholder="Search Voucher No"
                        value="{{ request('voucher_no') }}">
                </div>

                <div class="col-md-3 col-sm-6">
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" title="Start Date">
                </div>

                <div class="col-md-3 col-sm-6">
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" title="End Date">
                </div>

                <div class="col-md-3 col-sm-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('stockReturn.all') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-undo"></i> Reset
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light text-nowrap">
                        <tr>
                            <th width="50">#</th>
                            <th>Voucher No</th>
                            <th>Product</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Total Price</th>
                            <th>Date</th>
                            <th width="160" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $grandQty = 0;
                        $grandTotal = 0;
                        @endphp

                        @forelse($returns as $return)
                        @php
                        $grandQty += $return->total_qty;
                        $grandTotal += $return->total_price;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $return->voucher_no }}</strong></td>
                            <td>
                                @php
                                $products = \App\Models\StockTransaction::where('voucher_no', $return->voucher_no)
                                ->with('product')->get();
                                @endphp
                                <small>
                                    @foreach($products as $p)
                                    {{ $p->product->name ?? 'N/A' }}@if(!$loop->last), @endif
                                    @endforeach
                                </small>
                            </td>
                            <td class="text-center">{{ $return->total_qty }}</td>
                            <td class="text-end">{{ number_format($return->total_price, 2) }}</td>
                            <td class="text-nowrap">{{ date('d M, Y', strtotime($return->in_date)) }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('stockReturn.show', $return->voucher_no) }}" class="btn btn-sm btn-info text-white" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('stockReturn.edit', $return->voucher_no) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('stockReturn.delete', $return->voucher_no) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure? This will revert stock.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No stock returns found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($returns->count())
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="3" class="text-end text-uppercase">Total</td>
                            <td class="text-center">{{ $grandQty }}</td>
                            <td class="text-end">{{ number_format($grandTotal, 2) }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Live Search on Voucher No input
    let voucherInput = document.querySelector('input[name="voucher_no"]');
    voucherInput.addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            let voucherCell = row.cells[1].textContent.toLowerCase();
            if(voucherCell.includes(value)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>
@endpush