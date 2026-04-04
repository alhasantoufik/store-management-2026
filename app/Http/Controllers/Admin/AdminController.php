<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsLimit;
use App\Models\SmsLog;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            try {
                $query = User::where('role', 'admin')->whereNot('email', 'admin@admin.com')->whereNot('email', 'admin@developer.com')->latest();
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
                        return '
                            <div class="d-flex gap-2">
                                <a href="' . route('admin.admins.edit', $data->id) . '" 
                                   class="btn btn-sm btn-primary text-white px-3 py-2" 
                                   title="Edit">
                                    <i class="fa fa-edit me-1"></i>
                                </a>

                                <button onclick="showDeleteConfirm(' . $data->id . ')" 
                                        class="btn btn-sm btn-danger text-white px-3 py-2" 
                                        title="Delete">
                                    <i class="fa fa-trash me-1"></i>
                                </button>
                            </div>
                        ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } catch (Exception $e) {
                Log::error('Admin DataTable Error: ' . $e->getMessage());
                return response()->json(['error' => 'Server error'], 500);
            }
        }

        return view('backend.admin.admins.index');
    }

    public function create(): View
    {
        return view('backend.admin.admins.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin'
            ]);
            return redirect()->route('admin.admins.index')->with('t-success', 'Admin created successfully.');
        } catch (Exception $e) {
            Log::error('Admin Store Error: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Something went wrong.');
        }
    }

    public function edit(int $id): View
    {
        $admin = User::findOrFail($id);
        return view('backend.admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $admin = User::findOrFail($id);
            $admin->name = $request->name;
            $admin->email = $request->email;
            if ($request->password) {
                $admin->password = Hash::make($request->password);
            }
            $admin->save();

            return redirect()->route('admin.admins.index')->with('t-success', 'Admin updated successfully.');
        } catch (Exception $e) {
            Log::error('Admin Update Error: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Update failed.');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $admin = User::findOrFail($id);
            $admin->delete();
            return response()->json(['success' => true, 'message' => 'Admin deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Admin Delete Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Delete failed.'], 500);
        }
    }

    public function smsSummary()
    {
        // 🔹 Total Sent SMS (only successful)
        $totalSent = SmsLog::where('status', 'SUCCESS')->sum('sms_count');

        // 🔹 Total SMS added by admin from sms_limits table
        $totalLimit = SmsLimit::sum('sms');

        // 🔹 Remaining SMS = Total Limit - Total Sent
        $remaining = $totalLimit - $totalSent;

        // 🔹 Total SMS (can be just totalLimit or totalSent + remaining, both same)
        $totalSms = $totalSent + $remaining;

        return view('backend.admin.sms_settings.summary', [
            'totalSent' => $totalSent,
            'remaining' => $remaining,
            'totalSms'  => $totalSms,
        ]);
    }

    public function sendSingleSms(Request $request)
    {
        // Validate input
        $request->validate([
            'mobile'  => 'required|numeric',
            'message' => 'required|string|max:1600',
        ]);

        // 🔹 Calculate remaining SMS
        $totalSent = SmsLog::where('status', 'SUCCESS')->sum('sms_count');
        $totalLimit = SmsLimit::sum('sms');
        $remainingSms = $totalLimit - $totalSent;

        if ($remainingSms <= 0) {
            // No remaining SMS, stop sending
            return redirect()->back()->with('error', 'SMS not sent. Remaining SMS is 0.');
        }

        // Prepare API request
        $response = Http::asForm()
            ->withOptions(['verify' => false]) // SSL verification off
            ->post('https://portal.adnsms.com/api/v1/secure/send-sms', [
                'api_key'       => config('services.sms.api_key'),
                'api_secret'    => config('services.sms.api_secret'),
                'request_type'  => 'SINGLE_SMS',
                'message_type'  => 'UNICODE', // TEXT or UNICODE
                'mobile'        => $request->mobile,
                'message_body'  => $request->message,
            ]);

        $result = $response->json();

        // Determine status
        $status = ($result['api_response_code'] ?? 0) == 200 ? 'SUCCESS' : 'FAILED';

        // Dynamic SMS Count Calculation
        $messageLength = mb_strlen($request->message, 'UTF-8');
        $smsCount = ceil($messageLength / 51);

        // Log the SMS attempt
        SmsLog::create([
            'mobile'    => $request->mobile,
            'message'   => $request->message,
            'status'    => $status,
            'sms_count' => $smsCount,
        ]);

        if ($status === 'SUCCESS') {
            return redirect()->back()->with('success', 'SMS sent successfully!');
        } else {
            $errorMsg = $result['api_response_message'] ?? 'SMS sending failed';
            return redirect()->back()->with('error', $errorMsg);
        }
    }

    public function smsModule(Request $request)
    {
        if ($request->isMethod('post')) {
            $latestSms = SmsLimit::latest()->first();
            $previous_sms = $latestSms ? $latestSms->sms : 0;

            $sms = $request->amount * 2; // 1 taka = 2 sms

            SmsLimit::create([
                'date' => Carbon::now()->format('Y-m-d'),
                'previous_sms' => $previous_sms,
                'amount' => $request->amount,
                'sms' => $sms,
            ]);

            return redirect()->back()->with('success', 'SMS Limit updated successfully!');
        }

        $smsLimits = SmsLimit::latest()->get();
        $latestSms = $smsLimits->first();

        return view('backend.admin.sms_settings.sms_limits', [
            'smsLimits' => $smsLimits,
            'currentDate' => Carbon::now()->format('Y-m-d'),
            'previousSms' => $latestSms ? $latestSms->sms : 0,
        ]);
    }

    public function sendMessages(Request $request)
    {
        $query = SmsLog::query();

        // Date range filter
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        $smsLogs = $query->latest()->paginate(50);

        return view('backend.admin.sms_settings.index', compact('smsLogs'));
    }

    public function sendBulkSms(Request $request)
    {
        $request->validate([
            'mobile' => 'required|string',
            'message' => 'required|string|max:1600',
        ]);

        // 🔹 Calculate Remaining SMS
        $totalSent = SmsLog::where('status', 'SUCCESS')->sum('sms_count');
        $totalLimit = SmsLimit::sum('sms');
        $remainingSms = $totalLimit - $totalSent;

        if ($remainingSms <= 0) {
            return redirect()->back()->with('error', 'SMS not sent. Remaining SMS is 0.');
        }

        $response = Http::asForm()
            ->withOptions(['verify' => false])
            ->post('https://portal.adnsms.com/api/v1/secure/send-sms', [
                'api_key'        => config('services.sms.api_key'),
                'api_secret'     => config('services.sms.api_secret'),
                'request_type'   => 'GENERAL_CAMPAIGN',
                'message_type'   => 'UNICODE',
                'mobile'         => $request->mobile,
                'message_body'   => $request->message,
                'isPromotional'  => 0,
                'campaign_title' => 'Bulk SMS Campaign',
            ]);

        $result = $response->json();

        $status = ($result['api_response_code'] ?? 0) == 200 ? 'SUCCESS' : 'FAILED';

        // 🔹 Count numbers
        $numbers = explode(',', $request->mobile);
        $totalNumbers = count($numbers);

        // 🔹 Calculate SMS count
        $messageLength = mb_strlen($request->message, 'UTF-8');
        $smsPerNumber = ceil($messageLength / 51);

        $totalSmsUsed = $smsPerNumber * $totalNumbers;

        foreach ($numbers as $number) {

            SmsLog::create([
                'mobile' => trim($number),
                'message' => $request->message,
                'status' => $status,
                'sms_count' => $smsPerNumber,
            ]);
        }

        if ($status === 'SUCCESS') {
            return redirect()->back()->with('success', 'Bulk SMS sent successfully!');
        } else {
            return redirect()->back()->with('error', $result['api_response_message'] ?? 'SMS failed');
        }
    }
}
