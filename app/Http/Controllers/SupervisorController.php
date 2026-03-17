<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use Illuminate\Http\Request;
use App\Models\CompletionReport;

class SupervisorController extends Controller
{
    public function createCompletionReport(JobOrder $jobOrder){
        $employeeId = auth()->user()->employee->id;

        if(!$jobOrder->workers->contains($employeeId)){
            abort(403,'You are not assigned to manage this Job Order.');
        }

        if($jobOrder->status === 'resolved'){
            return redirect()->route('worker.assignments')->with('error','This job order is already resolved');
        }

        return view('supervisor.completion.create',compact('jobOrder'));
    }

    public function storeCompletionReport(Request $request,JobOrder $jobOrder){
        $employeeId = auth()->user()->employee->id;

        if(!$jobOrder->workers->contains($employeeId)){
            abort(403,'Unauthorized action.');
        }

        $request->validate([
            'supervisor_comments' => 'required|string|min:10|max:1000',
            'completion_image' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
            'accountability_check' => 'accepted'
        ]);

        $imagePath = null;

        if($request->hasFile('completion_image')){
            $imagePath = $request->file('completion_image')->store('completions','public');
        }

        CompletionReport::create([
            'image_path' => $imagePath,
            'job_order_id' => $jobOrder->id,
            'reported_by' => $employeeId,
            'supervisor_comments' => $request->supervisor_comments,
            'started_at' => $jobOrder->created_at,
            'completed_at' => now(),
        ]);

        $jobOrder->update([
            'status' => 'under_review',
            'supervisor_comments' => $request->supervisor_comments,
            'completed_at' => now()
        ]);

        $jobOrder->complaint->update([
            'status' => 'under_review'
        ]);

        $jobOrder->workers()->updateExistingPivot($jobOrder->workers->pluck('id'),[
            'worker_status' => 'off_site'
        ]);

        return redirect()->route('worker.assignments')->with('success','Completion Report submitted! The job is now under review by administration.');
    }
}
