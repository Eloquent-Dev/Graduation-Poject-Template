<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'division_id',
        'job_title',
        'pending_job_title',
        'dispatch_area',
        'duty_status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function division(){
        return $this->belongsTo(Division::class);
    }

    public function assignedJobOrders(){
        return $this->belongsToMany(JobOrder::class, 'employee_job_order')
        ->withPivot('worker_status')
        ->withTimestamps();
    }

    public function dispatchedJobsBy(){
        return $this->hasMany(JobOrder::class, 'assigned_by');
    }

    public function approvedComplaintsBy(){
        return $this->hasMany(Complaint::class, 'approved_by');
    }

    public function rejectedComplaintsBy(){
        return $this->hasMany(Complaint::class, 'rejected_by');
    }

    public function completionReports(){
        return $this->hasMany(CompletionReport::class);
    }

    public function adminReports(){
        return $this->hasMany(AdminReport::class);
    }
}
