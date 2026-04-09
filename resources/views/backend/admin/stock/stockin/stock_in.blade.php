@extends('backend.app')
@section('title', 'Stock In Management')
@section('page-content')

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Stock In List</h4>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="voucher_no" class="form-control" placeholder="Search by Voucher No">
                </div>
                <div class="col-md-3">
                    <input type="date" id="from_date" class="form-control">
                </div>
                <div class="col-md-3">
                    <input type="date" id="to_date" class="form-control">
                </div>
                <div class="col-md-2">
                    <button id="searchBtn" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="50">SL</th>
                        <th>Voucher No</th>
                        <th>Total Quantity</th>
                        <th>Total Price</th>
                        <th>Date</th>
                        <th width="150" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockIns as $key => $stock)
                    <tr id="row-{{ $stock->voucher_no }}">
                        <td>{{ $key + 1 }}</td>
                        <td><strong>{{ $stock->voucher_no }}</strong></td>
                        <td>{{ $stock->total_quantity }}</td>
                        <td>{{ number_format($stock->total_price, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($stock->in_date)->format('d M, Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('stock.in.edit', $stock->voucher_no) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button class="btn btn-sm btn-danger" onclick="deleteStock('{{ $stock->voucher_no }}')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-end">Total:</th>
                        <th>{{ $stockIns->sum('total_quantity') }}</th>
                        <th>{{ number_format($stockIns->sum('total_price'), 2) }}</th>
                        <th colspan="2"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function deleteStock(voucherNo) {
        if (confirm('Are you sure you want to delete this stock in?')) {
            let url = "{{ route('stock.in.delete', ':voucherNo') }}".replace(':voucherNo', voucherNo);
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    $('#row-' + voucherNo).fadeOut(400, function() {
                        $(this).remove();
                    });
                }
            });
        }
    }


    $('#searchBtn').on('click', function() {
        fetchStockIns();
    });

    // Optional: Live search as user types
    $('#voucher_no').on('keyup', function() {
        fetchStockIns();
    });

    function fetchStockIns() {
        let voucherNo = $('#voucher_no').val();
        let fromDate = $('#from_date').val();
        let toDate = $('#to_date').val();

        $.ajax({
            url: "{{ route('stock.in.search') }}",
            type: "GET",
            data: {
                voucher_no: voucherNo,
                from_date: fromDate,
                to_date: toDate
            },
            success: function(data) {
                $('tbody').html(data);
            }
        });
    }
</script>
@endpush