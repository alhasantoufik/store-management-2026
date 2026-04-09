@extends('backend.app')
@section('title', 'Add Cost')
@section('page-content')

<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-ligh">
            <h5 class="mb-0">Add New Cost</h5>
        </div>

        <div class="card-body">
            <form id="costForm">
                @csrf

                <div class="row">

                    {{-- Category --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <select name="cost_category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Field --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Field</label>
                        <select name="cost_field_id" class="form-control" required>
                            <option value="">Select Field</option>
                            @foreach($fields as $field)
                                <option value="{{ $field->id }}">
                                    {{ $field->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" name="amount" class="form-control" required>
                    </div>

                    {{-- Cost By --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cost By</label>
                        <input type="text" name="cost_by" class="form-control" required>
                    </div>

                    {{-- Date --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>

                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-info">
                        Save Cost
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection


@push('script')
<script>
    $('#costForm').submit(function(e){
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('cost.store') }}",
            type: "POST",
            data: formData,
            success: function(response){

                toastr.success(response.success); // ✅ toaster

                $('#costForm')[0].reset();
            },
            error: function(err){
                console.log(err);

                // validation error handle
                if (err.responseJSON && err.responseJSON.errors) {
                    $.each(err.responseJSON.errors, function(key, value){
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('Something went wrong!');
                }
            }
        });
    });
</script>
@endpush