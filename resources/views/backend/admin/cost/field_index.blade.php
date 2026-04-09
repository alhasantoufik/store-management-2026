@extends('backend.app')
@section('title','Expense Field')
@section('page-content')

<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>Cost Fields</h4>
        <button class="btn btn-info" onclick="addField()"> <i class="fas fa-plus-circle me-1"></i>Add Field</button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fields as $field)
                <tr id="row-{{ $field->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $field->category->name }}</td>
                    <td>{{ $field->name }}</td>
                    <td>
                        <button onclick="editField({{ $field->id }})" class="btn btn-warning btn-sm">Edit</button>
                        <button onclick="deleteField({{ $field->id }})" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="fieldModal">
    <div class="modal-dialog">
        <form id="fieldForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Field</h5>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="field_id">

                    <div class="mb-2">
                        <label>Category</label>
                        <select id="cost_category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>Field Name</label>
                        <input type="text" id="name" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function addField() {
        $('#field_id').val('');
        $('#name').val('');
        $('#cost_category_id').val('');
        $('#fieldModal .modal-title').text('Add Field');
        $('#fieldModal').modal('show');
    }

    $('#fieldForm').submit(function(e) {
        e.preventDefault();

        let id = $('#field_id').val();

        let url = id ?
            "{{ route('cost.field.update', ':id') }}".replace(':id', id) :
            "{{ route('cost.field.store') }}";

        $.post(url, {
            _token: "{{ csrf_token() }}",
            name: $('#name').val(),
            cost_category_id: $('#cost_category_id').val()
        }, function(res) {
            location.reload();
        });
    });

    function editField(id) {
        let url = "{{ route('cost.field.edit', ':id') }}".replace(':id', id);

        $.get(url, function(res) {
            $('#field_id').val(res.id);
            $('#name').val(res.name);
            $('#cost_category_id').val(res.cost_category_id);

            $('#fieldModal .modal-title').text('Edit Field');
            $('#fieldModal').modal('show');
        });
    }

   function deleteField(id) {

    let url = "{{ route('cost.field.delete', ':id') }}".replace(':id', id);

    Swal.fire({
        title: 'Are you sure?',
        text: "This field will be deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function() {

                    // smooth remove
                    $('#row-' + id).fadeOut(400, function() {
                        $(this).remove();
                    });

                    // toast style success
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Field deleted successfully',
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
                error: function() {

                    Swal.fire(
                        'Error!',
                        'Something went wrong!',
                        'error'
                    );
                }
            });
        }
    });
}
</script>
@endpush