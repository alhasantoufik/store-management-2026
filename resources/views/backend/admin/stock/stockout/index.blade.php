@extends('backend.app')
@section('title', 'Stock Out Management')
@section('page-content')

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Stock Out List</h4>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('stock.out.index') }}" class="row g-2 align-items-end">
                        <div class="col-md-3 col-sm-6">
                            <label for="voucher_no" class="form-label fw-bold small">Voucher No</label>
                            <input type="text" name="voucher_no" id="voucher_no" value="{{ request('voucher_no') }}" class="form-control" placeholder="Search by voucher">
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label for="start_date" class="form-label fw-bold small">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-control">
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label for="end_date" class="form-label fw-bold small">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control">
                        </div>

                        <div class="col-md-3 col-sm-6 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <a href="{{ route('stock.out.index') }}" class="btn btn-secondary w-100">
                                <i class="fas fa-undo"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light text-nowrap">
                        <tr>
                            <th width="50">SL</th>
                            <th>Voucher No</th>
                            <th>Total Quantity</th>
                            <th>Total Price</th>
                            <th>Date</th>
                            <th width="160" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockOuts as $key => $stock)
                        <tr id="row-{{ $stock->voucher_no }}">
                            <td>{{ $key + 1 }}</td>
                            <td><strong>{{ $stock->voucher_no }}</strong></td>
                            <td>{{ $stock->total_quantity }}</td>
                            <td>{{ number_format($stock->total_price, 2) }}</td>
                            <td class="text-nowrap">{{ \Carbon\Carbon::parse($stock->in_date)->format('d M, Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('stock.out.show', $stock->voucher_no) }}" class="btn btn-sm btn-info text-white" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('stock.out.edit', $stock->voucher_no) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" onclick="deleteStockOut('{{ $stock->voucher_no }}')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No data found</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="2" class="text-end">Total:</td>
                            <td>{{ $stockOuts->sum('total_quantity') }}</td>
                            <td>{{ number_format($stockOuts->sum('total_price'), 2) }}</td>
                            <td colspan="2"></td>
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
                },
                error: function() {
                    alert('Error deleting the record.');
                }
            });
        }
    }

    // Client-side quick search
    $(document).ready(function() {
        $('#voucher_no').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $('table tbody tr').filter(function() {
                // index 1 check kore voucher column er jonno
                $(this).toggle($(this).find('td:eq(1)').text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endpush