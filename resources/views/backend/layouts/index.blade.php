@extends('backend.app')
@section('title', 'ড্যাশবোর্ড')

@section('page-content')

<style>
    .dashboard-card {
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dashboard-card .card-body {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dashboard-card h1 {
        font-size: 32px;
        line-height: 1;
    }

    .dashboard-card i {
        opacity: 0.85;
    }
</style>

<section class="mt-0">
    <div class="container-fluid">
        <div class="row">

            <!-- মোট ব্যবহারকারী -->
            <div class="col-md-3 mt-4">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ $total_users }}</h1>
                            <h5 class="text-muted">মোট ব্যবহারকারী</h5>
                        </div>
                        <div>
                            <i class="fas fa-users fa-3x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@endpush