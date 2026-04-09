@extends('backend.app')
@section('title', 'Dashboard')

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
            <!-- Total Users -->
            <!-- <div class="col-md-3 mt-4">
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
            </div> -->

            <div class="col-md-3 mt-4">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ $totalProducts }}</h1>
                            <h5 class="text-muted">Total Products</h5>
                        </div>
                        <div>
                            <i class="fas fa-box fa-3x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- আজকের স্টক ইন -->
            <div class="col-md-3 mt-4">
                <a href="{{ route('stock.index') }}?type=in" style="text-decoration: none;">
                    <div class="card shadow-sm dashboard-card">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h1 class="fw-bold">{{ $today_stock_in }}</h1>
                                <h5 class="text-muted">Today's Stock In</h5>
                            </div>
                            <div>
                                <i class="fas fa-boxes fa-3x text-success"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- আজকের স্টক আউট -->
            <div class="col-md-3 mt-4">
                <a href="{{ route('stockOut.index') }}?type=out" style="text-decoration: none;">
                    <div class="card shadow-sm dashboard-card">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h1 class="fw-bold">{{ $today_stock_out }}</h1>
                                <h5 class="text-muted">Today's Stock Out</h5>
                            </div>
                            <div>
                                <i class="fas fa-truck fa-3x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- আজকের স্টক রিটার্ন -->
            <div class="col-md-3 mt-4">
                <a href="{{ route('stockReturn.index') }}?type=return" style="text-decoration: none;">
                    <div class="card shadow-sm dashboard-card">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h1 class="fw-bold">{{ $today_stock_return }}</h1>
                                <h5 class="text-muted">Today's Stock Return</h5>
                            </div>
                            <div>
                                <i class="fas fa-undo fa-3x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-md-3 mt-4">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ number_format($todayStockInCost, 2) }} Tk.</h1>
                            <h5 class="text-muted">Today's Total Cost</h5>
                        </div>
                        <div>
                            <i class="fas fa-money-bill-wave fa-3x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mt-4">
                <div class="card shadow-sm dashboard-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h1 class="fw-bold">{{ number_format($todayProfit, 2) }} Tk.</h1>
                            <h5 class="text-muted">Today's Balance</h5>
                        </div>
                        <div>
                            <i class="fas fa-chart-line fa-3x text-primary"></i>
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