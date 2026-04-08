@extends('backend.app')
@section('title','All Costs')
@section('page-content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark m-0">Costs</h4>

        <button class="btn btn-success px-4 shadow-sm" onclick="addCost()">
            <i class="fas fa-plus-circle me-1"></i> Add Expense
        </button>
    </div>

    <div class="mb-2">
        <select id="filter_category" class="form-control select2 d-inline-block w-auto">
            <option value="">Select Category</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <input type="date" id="from" class="form-control d-inline-block w-auto">
        <input type="date" id="to" class="form-control d-inline-block w-auto">
        <button class="btn btn-success" onclick="filterCost()">Filter</button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered mt-2">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Field</th> <!-- NEW -->
                    <th>Amount</th>
                    <th>Expense By</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="cost_table">
                @foreach($costs as $cost)
                <tr id="row-{{ $cost->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cost->category->name ?? ''}}</td>
                    <td>{{ $cost->field->name ?? '' }}</td>
                    <td>{{ $cost->amount }} Tk.</td>
                    <td>{{ $cost->cost_by }}</td>
                    <td>{{ $cost->date }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editCost({{ $cost->id }})">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteCost({{ $cost->id }})">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script>
    $(document).ready(function() {

        $('.select2').select2({
            placeholder: "Select Category",
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
        if (confirm('Are you sure?')) {
            let url = "{{ route('cost.delete', ['id' => ':id']) }}".replace(':id', id);
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    $('#row-' + id).remove();
                }
            });
        }
    }

    function filterCost() {
        let category = $('#filter_category').val();
        let from = $('#from').val();
        let to = $('#to').val();
        let query = '?';
        if (category) query += 'category_id=' + category + '&';
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