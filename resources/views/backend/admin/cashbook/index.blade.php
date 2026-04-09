@extends('backend.app')
@section('title','CashBook')
@section('page-content')

<div class="container-fluid mt-3">
    <h4 class="fw-bold mb-3">CashBook</h4>

    {{-- Quick Date Filters --}}
    <div class="mb-3">
        <a href="{{ route('cashbook.index', ['days' => 7]) }}" class="btn btn-sm btn-outline-primary shadow-sm">Last 7 Days</a>
        <a href="{{ route('cashbook.index', ['days' => 15]) }}" class="btn btn-sm btn-outline-warning shadow-sm">Last 15 Days</a>
        <a href="{{ route('cashbook.index', ['days' => 30]) }}" class="btn btn-sm btn-outline-success shadow-sm">Last 30 Days</a>
    </div>

    {{-- Totals --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-white bg-danger">
                <div class="card-body">
                    <h6 class="card-title opacity-75">Total Stock Cost</h6>
                    <h3 class="fw-bold">৳ {{ number_format($totalCostIn, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-white bg-success">
                <div class="card-body">
                    <h6 class="card-title opacity-75">Total Income</h6>
                    <h3 class="fw-bold">৳ {{ number_format($totalIncome, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-white bg-warning">
                <div class="card-body">
                    <h6 class="card-title opacity-75">Other Expense</h6>
                    <h3 class="fw-bold">৳ {{ number_format($totalOtherCost, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-white bg-primary">
                <div class="card-body">
                    <h6 class="card-title opacity-75">Balance</h6>
                    <h3 class="fw-bold">৳ {{ number_format($profit, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <select name="product_id" id="product_id" class="form-select select2 border-0 bg-light">
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="start_date" class="form-control border-0 bg-light" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" name="end_date" class="form-control border-0 bg-light" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary px-4 shadow-sm w-50">Filter</button>
                    <a href="{{ route('cashbook.index') }}" class="btn btn-secondary px-4 shadow-sm w-50">Clear</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-pills mb-3 border-bottom pb-2" id="cashbookTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold" id="in-tab" data-bs-toggle="tab" data-bs-target="#stock-in" type="button">Stock In</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="out-tab" data-bs-toggle="tab" data-bs-target="#stock-out" type="button">Stock Out</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="return-tab" data-bs-toggle="tab" data-bs-target="#returns" type="button">Returns</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="cost-tab" data-bs-toggle="tab" data-bs-target="#costs" type="button">Expense</button>
        </li>
    </ul>

    {{-- Tab Contents --}}
    <div class="tab-content card border-0 shadow-sm p-3">

        {{-- Stock In --}}
        <div class="tab-pane fade show active" id="stock-in">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Voucher No</th>
                            <th>Product</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Purchase Price</th>
                            <th class="text-end">Total Price</th>
                            <th class="text-end text-muted">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sumInQty = 0; $sumInTotal = 0; @endphp
                        @foreach($stockIn as $key => $t)
                            @php $sumInQty += $t->quantity; $sumInTotal += $t->total_price; @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="fw-bold">{{ $t->voucher_no }}</td>
                                <td>{{ $t->product->name ?? '-' }}</td>
                                <td class="text-center">{{ $t->quantity }}</td>
                                <td class="text-end text-muted">{{ number_format($t->product->product_price ?? 0, 2) }}</td>
                                <td class="text-end fw-bold text-dark">{{ number_format($t->total_price, 2) }}</td>
                                <td class="text-end text-muted">{{ \Carbon\Carbon::parse($t->in_date)->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-secondary fw-bold">
                        <tr>
                            <td colspan="3" class="text-end">Grand Total:</td>
                            <td class="text-center">{{ $sumInQty }}</td>
                            <td></td>
                            <td class="text-end text-danger">৳ {{ number_format($sumInTotal, 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Stock Out --}}
        <div class="tab-pane fade" id="stock-out">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Voucher No</th>
                            <th>Product</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Purchase</th>
                            <th class="text-end">Sale</th>
                            <th class="text-end">Total Price</th>
                            <th class="text-end text-muted">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sumOutQty = 0; $sumOutTotal = 0; @endphp
                        @foreach($stockOut as $key => $t)
                            @php $sumOutQty += $t->quantity; $sumOutTotal += $t->total_price; @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="fw-bold">{{ $t->voucher_no }}</td>
                                <td>{{ $t->product->name ?? '-' }}</td>
                                <td class="text-center">{{ $t->quantity }}</td>
                                <td class="text-end text-muted">{{ number_format($t->product->product_price ?? 0, 2) }}</td>
                                <td class="text-end text-muted">{{ number_format($t->product->sale_price ?? 0, 2) }}</td>
                                <td class="text-end fw-bold text-dark">{{ number_format($t->total_price, 2) }}</td>
                                <td class="text-end text-muted">{{ $t->in_date->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-secondary fw-bold">
                        <tr>
                            <td colspan="3" class="text-end">Grand Total:</td>
                            <td class="text-center">{{ $sumOutQty }}</td>
                            <td colspan="2"></td>
                            <td class="text-end text-success">৳ {{ number_format($sumOutTotal, 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Returns --}}
        <div class="tab-pane fade" id="returns">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Voucher No</th>
                            <th>Product</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Sale Price</th>
                            <th class="text-end">Total Price</th>
                            <th class="text-end text-muted">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sumRetQty = 0; $sumRetTotal = 0; @endphp
                        @foreach($returns as $key => $t)
                            @php $sumRetQty += $t->quantity; $sumRetTotal += $t->total_price; @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="fw-bold">{{ $t->voucher_no }}</td>
                                <td>{{ $t->product->name ?? '-' }}</td>
                                <td class="text-center">{{ $t->quantity }}</td>
                                <td class="text-end text-muted">{{ number_format($t->product->sale_price ?? 0, 2) }}</td>
                                <td class="text-end fw-bold text-dark">{{ number_format($t->total_price, 2) }}</td>
                                <td class="text-end text-muted">{{ $t->in_date->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-secondary fw-bold">
                        <tr>
                            <td colspan="3" class="text-end">Grand Total:</td>
                            <td class="text-center">{{ $sumRetQty }}</td>
                            <td></td>
                            <td class="text-end text-warning">৳ {{ number_format($sumRetTotal, 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Costs --}}
        <div class="tab-pane fade" id="costs">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Field</th>
                            <th class="text-end">Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sumCost = 0; @endphp
                        @foreach($costs as $key => $cost)
                            @php $sumCost += $cost->amount; @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $cost->category->name ?? '-' }}</td>
                                <td>{{ $cost->field->name ?? '-' }}</td>
                                <td class="text-end">৳ {{ number_format($cost->amount, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($cost->date)->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-secondary fw-bold">
                        <tr>
                            <td colspan="3" class="text-end">Grand Total:</td>
                            <td class="text-end text-danger">৳ {{ number_format($sumCost, 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
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
        $('#product_id').select2({
            placeholder: "Search Product",
            allowClear: true
        });
    });
</script>
@endpush