<?php

namespace App\Http\Controllers\Web\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class DynamicPageController extends Controller
{
    /**
     * Display a listing of dynamic pages.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            try {
                $query = DynamicPage::query()->latest();
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->editColumn('page_content', function ($data) {
                        $text = strip_tags($data->page_content);
                        return strlen($text) > 80 ? substr($text, 0, 80) . '...' : $text;
                    })
                    ->addColumn('status', function ($data) {
                        $checked = $data->status === 'active' ? 'checked' : '';
                        return '
                            <div class="form-check form-switch form-switch-lg">
                                <input onclick="showStatusChangeAlert(' . $data->id . ')" 
                                       type="checkbox" 
                                       class="form-check-input" 
                                       id="statusSwitch' . $data->id . '" 
                                       ' . $checked . '>
                            </div>';
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <div class="btn-group btn-group-sm">
                                <a href="' . route('dynamic_page.edit', $data->id) . '" 
                                   class="btn btn-primary text-white" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button onclick="showDeleteConfirm(' . $data->id . ')" 
                                        class="btn btn-danger text-white" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>';
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            } catch (Exception $e) {
                Log::error('DataTable Error: ' . $e->getMessage());
                return response()->json(['error' => 'Server error'], 500);
            }
        }

        return view('backend.layouts.settings.dynamic_page.index');
    }

    /**
     * Show the form for creating a new page.
     */
    public function create(): View
    {
        return view('backend.layouts.settings.dynamic_page.create');
    }

    /**
     * Store a newly created page in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'page_title' => 'required|string|max:255',
            'page_content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DynamicPage::create([
                'page_title' => $request->page_title,
                'page_slug' => Str::slug($request->page_title),
                'page_content' => $request->page_content,
                'status' => 'active',
            ]);

            return redirect()->route('dynamic_page.index')->with('t-success', 'Dynamic Page created successfully.');
        } catch (Exception $e) {
            Log::error('Store Dynamic Page Error: ' . $e->getMessage());
            return redirect()->route('dynamic_page.index')->with('t-error', 'Something went wrong.');
        }
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit(int $id): View
    {
        $data = DynamicPage::findOrFail($id);
        return view('backend.layouts.settings.dynamic_page.edit', compact('data'));
    }

    /**
     * Update the specified page in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'page_title' => 'required|string|max:255',
            'page_content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $page = DynamicPage::findOrFail($id);
            $page->update([
                'page_title' => $request->page_title,
                'page_slug' => Str::slug($request->page_title),
                'page_content' => $request->page_content,
            ]);

            return redirect()->route('dynamic_page.index')->with('t-success', 'Dynamic Page updated successfully.');
        } catch (Exception $e) {
            Log::error('Update Dynamic Page Error: ' . $e->getMessage());
            return redirect()->route('dynamic_page.index')->with('t-error', 'Update failed.');
        }
    }

    /**
     * Toggle the status of the specified page via AJAX.
     */
    public function status(int $id): JsonResponse
    {
        try {
            $page = DynamicPage::findOrFail($id);
            $page->status = $page->status === 'active' ? 'inactive' : 'active';
            $page->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (Exception $e) {
            Log::error('Status Update Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Status update failed.'], 500);
        }
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $page = DynamicPage::findOrFail($id);
            $page->delete();

            return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Delete Dynamic Page Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Delete failed.'], 500);
        }
    }
}