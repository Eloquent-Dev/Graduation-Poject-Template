<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class JobTitleApprovalController extends Controller
{
    public function index()
    {
        $employees = Employee::whereNotNull('pending_job_title')->with('user')->get();
        return view('admin.job_title.index', compact('employees'));
    }

    public function approve(Request $request, Employee $employee)
    {
        $finalTitle = $request->input('job_title', $employee->pending_job_title);
        $employee->update(['job_title' => $finalTitle, 'pending_job_title' => null]);
        return redirect()->route('admin.job-title.index')->with('success', 'Job title approved successfully.');
    }

    public function reject(Employee $employee)
    {
        $employee->update(['pending_job_title' => null]);
        return back()->with('info', "Change request rejected.");
    }
}
