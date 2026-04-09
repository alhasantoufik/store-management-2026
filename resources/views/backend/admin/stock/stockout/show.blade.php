@extends('backend.app')
@section('title', 'Stock Out Details')
@section('page-content')

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Stock Out Details - Voucher: {{ $voucherNo }}</h4>
        <a href="{{ route('stock.out.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockItems as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->product->name ?? 'N/A' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->total_price / $item->quantity, 2) }}</td>
                            <td>{{ number_format($item->total_price, 2) }}</td>
                            <td>{{ $item->note ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-end">Total:</th>
                        <th>{{ $stockItems->sum('quantity') }}</th>
                        <th></th>
                        <th>{{ number_format($stockItems->sum('total_price'), 2) }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection