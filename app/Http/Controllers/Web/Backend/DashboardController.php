<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Collector;
use App\Models\User;
use App\Models\Receiver;
use App\Models\Cost;
use App\Models\Lead;
use App\Models\SubDistrict;
use App\Models\Transaction;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $total_users = User::whereNot('email', 'admin@developer.com')->count();
        return view('backend.layouts.index', [
            'total_users' => $total_users,
            
        ]);
    }
}
