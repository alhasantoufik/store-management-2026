@extends('backend.app')
@section('title','All Expense Report')
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
    <h4>All Expenses</h4>

    <!-- Filter Form -->
    <div class="mb-3">
        <div class="row g-2 align-items-end">


            <div class="col-md-2">
                <label class="form-label">From</label>
                <input type="date" id="from" class="form-control">
            </div>

            <div class="col-md-2">
                <label class="form-label">To</label>
                <input type="date" id="to" class="form-control">
            </div>

            <div class="col-md-2">
                <label class="form-label">Category</label>
                <select id="category_id" class="form-control select2" onchange="loadFields(this.value)">
                    <option value="">All</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Field</label>
                <select id="cost_field_id" class="form-control select2">
                    <option value="">All</option>
                    @foreach($fields as $field)
                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Expense By</label>
                <select id="cost_by" class="form-control select2">
                    <option value="">All</option>
                    @foreach($costBys as $cb)
                    <option value="{{ $cb }}">{{ $cb }}</option>
                    @endforeach
                </select>
            </div>



            <div class="col-md-2 d-grid">
                <label class="form-label invisible">Filter</label>
                <button class="btn btn-success" onclick="filterCost()">
                    Filter
                </button>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary" onclick="printReport()">
                    Print Report
                </button>
            </div>

        </div>
    </div>

    <!-- Report Table -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Field</th> <!-- NEW -->
                    <th>Amount</th>
                    <th>Expense By</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($costs as $cost)
                <tr>
                    <td>{{ $loop->iteration + $costs->firstItem() - 1 }}</td> <!-- Serial number -->
                    <td>{{ $cost->category->name }}</td>
                    <td>{{ optional($cost->field)->name }}</td>
                    <td>{{ number_format($cost->amount, 2) }} Tk.</td>
                    <td>{{ $cost->cost_by }}</td>
                    <td>{{ $cost->date }}</td>
                </tr>
                @php $total += $cost->amount; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>

                    <th colspan="3" class="text-end">Total</th>
                    <th>{{ number_format($total,2) }}</th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script>
    $(document).ready(function() {

        $('#category_id').select2({
            placeholder: "Search Category",
            allowClear: true
        });

    })

    $(document).ready(function() {

        $('#cost_field_id').select2({
            placeholder: "Search Field",
            allowClear: true
        });

    })
    $(document).ready(function() {

        $('#cost_by').select2({
            placeholder: "Search Expense By",
            allowClear: true
        });

    })
</script>
<script>
    function filterCost() {
        let category = $('#category_id').val();
        let cost_field = $('#cost_field_id').val();
        let cost_by = $('#cost_by').val();
        let from = $('#from').val();
        let to = $('#to').val();
        let query = '?';
        if (category) query += 'category_id=' + category + '&';
        if (cost_field) query += 'cost_field_id=' + cost_field + '&';
        if (cost_by) query += 'cost_by=' + cost_by + '&';
        if (from && to) query += 'from=' + from + '&to=' + to + '&';
        window.location.href = "{{ route('cost.all') }}" + query;
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

<script>
    function printReport() {
        // Table er HTML niye print korbo
        let printContents = document.querySelector('.table-responsive').innerHTML;
        let originalContents = document.body.innerHTML;

        document.body.innerHTML = `
        <html>
        <head>
            <title>Expense Report</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #000; padding: 8px; text-align: center; }
                th { background-color: #f0f0f0; }
                tfoot th { text-align: right; }
            </style>
        </head>
        <body>
            <h3>Expense Report</h3>
            ${printContents}
        </body>
        </html>
    `;

        window.print(); // print dialog open
        document.body.innerHTML = originalContents; // page restore
        location.reload(); // optional, reload page to restore JS functionality
    }
</script>
@endpush