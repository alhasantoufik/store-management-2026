@extends('backend.app')
@section('title', 'Stock Report')
@section('page-content')
<style>
    /* Select2 এর উচ্চতা বুটস্ট্র্যাপের ইনপুটের সমান করার জন্য */
    .select2-container .select2-selection--single {
        height: 38px !important;
        /* বুটস্ট্র্যাপ ৪/৫ এর স্ট্যান্ডার্ড হাইট */
        display: flex;
        align-items: center;
        border: 1px solid #dee2e6;
        /* বর্ডারের রঙ ইনপুটের মতো রাখা */
    }

    /* টেক্সটকে সেন্টারে রাখার জন্য */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important;
        padding-left: 12px;
    }

    /* ড্রপডাউন অ্যারো (Arrow) এর পজিশন ঠিক করার জন্য */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
</style>
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Stock Report</h4>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('stock.report') }}" class="row g-3 mb-4">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="product_id" class="form-label">Product</label>
                    <select name="product_id" id="product_id" class="form-control select2">
                        <option value="">All Products</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-control select2">
                        <option value="">All Types</option>
                        <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Stock In</option>
                        <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Stock Out</option>
                        <option value="return" {{ request('type') == 'return' ? 'selected' : '' }}>Return</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="voucher_no" class="form-label">Voucher No</label>
                    <input type="text" name="voucher_no" id="voucher_no"
                        class="form-control"
                        placeholder="e.g. IN20260400001"
                        value="{{ request('voucher_no') }}">
                </div>


                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-50">Filter</button>
                    <a href="{{ route('stock.report') }}" class="btn btn-secondary w-50">Reset</a>
                </div>
            </form>
            <div class="mb-3 text-end">
                <button class="btn btn-primary" onclick="printStockReport()">
                    <i class="fas fa-print me-1"></i> Print Report
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>Sl</th>
                            <th>Product</th>
                            <th>Voucher No</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                            <th>Previous Stock</th>
                            <th>Current Stock</th>
                            <th>Date</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $page = request()->get('page', 1);
                        $perPage = $transactions->perPage();
                        $total = $transactions->total();
                        $sl = $total - (($page - 1) * $perPage);

                        $totalQuantity = 0;
                        $totalAmount = 0;
                        @endphp

                        @forelse($transactions as $index => $t)
                        @php
                        $totalQuantity += $t->quantity;
                        $totalAmount += $t->total_price;
                        @endphp
                        <tr>
                            <td>{{ $sl-- }}</td>
                            <td>{{ $t->product->name ?? '-' }}</td>
                            <td>{{ $t->voucher_no }}</td>
                            <td>{{ ucfirst($t->type) }}</td>
                            <td>{{ $t->quantity }}</td>
                            <td>{{ number_format($t->total_price / max($t->quantity,1), 2) }} Tk.</td>
                            <td>{{ number_format($t->total_price, 2) }} Tk.</td>
                            <td>{{ $t->previous_stock }}</td>
                            <td>{{ $t->current_stock }}</td>
                            <td>{{ \Carbon\Carbon::parse($t->in_date)->format('Y-m-d') }}</td>
                            <td>{{ $t->note ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">No transactions found</td>
                        </tr>
                        @endforelse
                    </tbody>

                    @if($transactions->count() > 0)
                    <tfoot>
                        <tr class="table-secondary fw-bold">
                            <td colspan="4" class="text-end">Total:</td>
                            <td>{{ $totalQuantity }}</td>
                            <td></td>
                            <td>{{ number_format($totalAmount, 2) }} Tk.</td>
                            <td colspan="4"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>

                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script>
    $(document).ready(function() {
        if ($.isFunction($.fn.select2)) {
            $('.select2').select2({
                placeholder: "Select Product",
                allowClear: true
            });
        }
    });
    $(document).ready(function() {
        if ($.isFunction($.fn.select2)) {
            $('#type').select2({
                placeholder: "Select Type",
                allowClear: true
            });
        }
    });
</script>
<script>
    $('#voucher_no').on('keyup', function() {
        let value = $(this).val();

        if (value.length >= 2 || value.length === 0) {
            $(this).closest('form').submit();
        }
    });
</script>

<script>
    function printStockReport() {
        // Print korar section select
        let printSection = document.querySelector('.table-responsive').innerHTML;
        let originalContent = document.body.innerHTML;

        document.body.innerHTML = `
        <html>
        <head>
            <title>Stock Report</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h3 { text-align: center; margin-bottom: 20px; }
                table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                th, td { border: 1px solid #000; padding: 8px; text-align: center; }
                th { background-color: #f0f0f0; }
                tfoot td { font-weight: bold; }
                .text-end { text-align: right; }
                .text-left { text-align: left; }
            </style>
        </head>
        <body>
            <h3>Stock Report</h3>
            ${printSection}
        </body>
        </html>
    `;

        window.print(); // browser print dialog open
        document.body.innerHTML = originalContent; // restore original page
        location.reload(); // restore JS & pagination
    }
</script>
@endpush