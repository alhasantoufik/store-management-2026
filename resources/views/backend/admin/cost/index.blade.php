@extends('backend.app')
@section('title','All Expenses')
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
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark m-0">Costs</h4>

        <button class="btn btn-info px-4 shadow-sm" onclick="addCost()">
            <i class="fas fa-plus-circle me-1"></i> Add Expense
        </button>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-end">
                <div class="col-6 col-sm-6 col-md-2">
                    <label class="form-label small fw-bold text-muted">From Date</label>
                    <input type="date" id="from" class="form-control form-control-sm" placeholder="From Date">
                </div>

                <div class="col-6 col-sm-6 col-md-2">
                    <label class="form-label small fw-bold text-muted">To Date</label>
                    <input type="date" id="to" class="form-control form-control-sm" placeholder="To Date">
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label small fw-bold text-muted">Category</label>
                    <select id="filter_category" class="form-select form-select-sm select2">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label small fw-bold text-muted">Field</label>
                    <select id="filter_field" class="form-select form-select-sm select2">
                        <option value="">Select Field</option>
                        @foreach($fields as $field)
                        <option value="{{ $field->id }}">{{ $field->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-2">
                    <div class="row g-2">
                        <div class="col-6 col-md-6">
                            <button class="btn btn-info btn-sm w-100 text-white" onclick="filterCost()">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                        </div>
                        <div class="col-6 col-md-6">
                            <a class="btn btn-secondary btn-sm w-100" href="{{ route('cost.index') }}">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="table-responsive">
        <table class="table table-bordered mt-2">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Field</th> <!-- NEW -->
                    <th>Amount</th>
                    <th>Expense By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="cost_table">
                @foreach($costs as $cost)
                <tr id="row-{{ $cost->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cost->date }}</td>
                    <td>{{ $cost->category->name ?? ''}}</td>
                    <td>{{ $cost->field->name ?? '' }}</td>
                    <td>{{ $cost->amount }} Tk.</td>
                    <td>{{ $cost->cost_by }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editCost({{ $cost->id }})">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteCost({{ $cost->id }})">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <th colspan="4" class="text-end">Total:</th>
                    <th>
                        {{ $costs->sum('amount') }} Tk.
                    </th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="costModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="costForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Expense</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="cost_id">
                    <div class="form-group">
                        <label>Category</label>
                        <select id="cost_category_id" class="form-control" onchange="loadFields(this.value)">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Field</label>
                        <select id="cost_field_id" class="form-control">
                            <option value="">-- Select Field --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" id="amount" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Expense By</label>
                        <input type="text" id="cost_by" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" id="date" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script>
    $(document).ready(function() {

        $('.select2').select2({
            placeholder: "Select Category",
            allowClear: true
        });

    })
    $(document).ready(function() {

        $('#filter_field').select2({
            placeholder: "Select Field",
            allowClear: true
        });

    })
</script>
<script>
    function addCost() {
        $('#cost_id').val('');
        $('#cost_category_id').val('');
        $('#amount').val('');
        $('#cost_by').val('');
        $('#date').val('');
        $('#costModal .modal-title').text('Add Cost');
        $('#costModal').modal('show');
    }

    $('#costForm').submit(function(e) {
        e.preventDefault();
        let id = $('#cost_id').val();
        let url = id ?
            "{{ route('cost.update', ['id' => ':id']) }}".replace(':id', id) :
            "{{ route('cost.store') }}";

        $.post(url, {
            _token: "{{ csrf_token() }}",
            cost_category_id: $('#cost_category_id').val(),
            cost_field_id: $('#cost_field_id').val(), // ✅ new
            amount: $('#amount').val(),
            cost_by: $('#cost_by').val(),
            date: $('#date').val()
        }, function(res) {
            location.reload();
        });
    });

    function editCost(id) {
        let url = "{{ route('cost.edit', ['id' => ':id']) }}".replace(':id', id);
        $.get(url, function(res) {
            $('#cost_id').val(res.id);
            $('#cost_category_id').val(res.cost_category_id);
            $('#cost_field_id').val(res.cost_field_id); // ✅ new
            loadFields(res.cost_category_id);
            $('#amount').val(res.amount);
            $('#cost_by').val(res.cost_by);
            $('#date').val(res.date);
            $('#costModal .modal-title').text('Edit Cost');
            $('#costModal').modal('show');
        });
        setTimeout(() => {
            $('#cost_field_id').val(res.cost_field_id);
        }, 300);
    }

    function deleteCost(id) {

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            if (result.isConfirmed) {

                let url = "{{ route('cost.delete', ['id' => ':id']) }}".replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {

                        $('#row-' + id).remove();

                        Swal.fire(
                            'Deleted!',
                            'Cost has been deleted.',
                            'success'
                        );
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Something went wrong.',
                            'error'
                        );
                    }
                });
            }
        });
    }

    function filterCost() {
        let category = $('#filter_category').val();
        let field = $('#filter_field').val();
        let from = $('#from').val();
        let to = $('#to').val();
        let query = '?';

        if (category) query += 'category_id=' + category + '&';
        if (field) query += 'field_id=' + field + '&';
        if (from && to) query += 'from=' + from + '&to=' + to + '&';

        window.location.href = "{{ route('cost.index') }}" + query.slice(0, -1);
    }

    function loadFields(category_id) {
        if (!category_id) {
            $('#cost_field_id').html('<option value="">-- Select Field --</option>');
            return;
        }

        let url = "{{ route('cost.get.fields', ':id') }}".replace(':id', category_id);

        $.get(url, function(res) {
            let options = '<option value="">-- Select Field --</option>';
            res.forEach(field => {
                options += `<option value="${field.id}">${field.name}</option>`;
            });
            $('#cost_field_id').html(options);
        });
    }
</script>
@endpush