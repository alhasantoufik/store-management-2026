@extends('backend.app')
@section('title', 'Stock Out Management')
@section('page-content')

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Stock Out List</h4>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('stock.out.index') }}" class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label for="voucher_no" class="form-label">Voucher No</label>
                            <input type="text" name="voucher_no" id="voucher_no" value="{{ request('voucher_no') }}" class="form-control" placeholder="Search by voucher">
                        </div>

                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control">
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                            <a href="{{ route('stock.out.index') }}" class="btn btn-secondary w-100">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
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
                        @foreach($stockOuts as $key => $stock)
                        <tr id="row-{{ $stock->voucher_no }}">
                            <td>{{ $key + 1 }}</td>
                            <td><strong>{{ $stock->voucher_no }}</strong></td>
                            <td>{{ $stock->total_quantity }}</td>
                            <td>{{ number_format($stock->total_price, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($stock->in_date)->format('d M, Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('stock.out.edit', $stock->voucher_no) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="deleteStockOut('{{ $stock->voucher_no }}')">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <th colspan="2" class="text-end">Total:</th>
                            <th>
                                {{ $stockOuts->sum('total_quantity') }}
                            </th>
                            <th>
                                {{ number_format($stockOuts->sum('total_price'), 2) }}
                            </th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function deleteStockOut(voucher_no) {
        if (confirm('Are you sure you want to delete this voucher?')) {
            let url = "{{ route('stock.out.delete', ':voucher_no') }}".replace(':voucher_no', voucher_no);
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    $('#row-' + voucher_no).fadeOut(400, function() {
                        $(this).remove();
                    });
                }
            });
        }
    }
</script>
<script>
    $(document).ready(function() {
        $('#voucher_no').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $('table tbody tr').filter(function() {
                $(this).toggle($(this).find('td:eq(1)').text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endpush