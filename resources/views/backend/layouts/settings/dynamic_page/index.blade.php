@extends('backend.app')
@section('title', 'Dynamic Pages')

@section('page-content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-sm-nowrap flex-wrap">
        <div class="d-flex flex-column align-items-start justify-content-center me-2 flex-wrap">
            <h1 class="text-dark fw-bold fs-2">@yield('title')</h1>
            <ul class="breadcrumb fw-semibold fs-base ps-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item text-muted">@yield('title')</li>
            </ul>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card p-4">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="fw-semibold">All Dynamic Pages</h5>
            <a href="{{ route('dynamic_page.create') }}" class="btn btn-primary btn-lg">Add New Page</a>
        </div>

        <div class="table-responsive">
            <table id="data-table" class="table table-bordered align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Page Title</th>
                        <th>Page Content</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('style')
<!-- DataTables Bootstrap 5 CSS -->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<style>
    /* DataTables Pagination Styling */
    .dataTables_paginate .pagination {
        margin-top: 1rem;
        justify-content: flex-end;
    }
    .dataTables_paginate .page-item .page-link {
        border-radius: 0.25rem;
        margin: 0 3px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        color: #01081e;
        background-color: #edf1fd;
        border: 1px solid #ccd7fc;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
    }
    .dataTables_paginate .page-item.active .page-link {
        background-color: #3085d6;
        border-color: #3085d6;
        color: #fff;
    }
    .dataTables_paginate .page-item:hover .page-link {
        background-color: #ccd7fc;
        border-color: #ccd7fc;
        color: #01081e;
    }
    .dataTables_paginate .page-item.disabled .page-link {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
        cursor: not-allowed;
    }
    /* Font Awesome icons for prev/next buttons */
    .dataTables_paginate .page-item.previous .page-link {
        position: relative;
        padding-left: 2rem;
    }
    .dataTables_paginate .page-item.next .page-link {
        position: relative;
        padding-right: 2rem;
    }
    .dataTables_paginate .page-item.previous .page-link::before {
        content: "\f053";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
    }
    .dataTables_paginate .page-item.next .page-link::before {
        content: "\f054";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
    }
    /* Ensure table styling aligns with theme */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
        font-family: 'Poppins', sans-serif;
    }
    .dataTables_wrapper .dataTables_info {
        font-family: 'Poppins', sans-serif;
        color: #01081e;
    }
</style>
@endpush

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('dynamic_page.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'page_title', name: 'page_title'},
            {data: 'page_content', name: 'page_content', orderable: false, searchable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        language: {
            processing: `<div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>`
        }
    });

    window.showStatusChangeAlert = function(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to change the status?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, change it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                let url = '{{ route("dynamic_page.status", ":id") }}'.replace(':id', id);
                $.get(url, function(resp) {
                    if (resp.success) {
                        toastr.success(resp.message);
                        table.ajax.reload();
                    } else {
                        toastr.error(resp.message || 'Status update failed.');
                    }
                }).fail(() => {
                    toastr.error('Something went wrong.');
                });
            } else {
                // Revert checkbox state if user cancels
                $('#statusSwitch' + id).prop('checked', !$('#statusSwitch' + id).prop('checked'));
            }
        });
    }

    window.showDeleteConfirm = function(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This record will be permanently deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                let url = '{{ route("dynamic_page.destroy", ":id") }}'.replace(':id', id);
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function(resp) {
                        if (resp.success) {
                            toastr.success(resp.message);
                            table.ajax.reload();
                        } else {
                            toastr.error(resp.message || 'Delete failed.');
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong.');
                    }
                });
            }
        });
    }
});
</script>
@endpush