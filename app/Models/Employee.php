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
        'dept_id',
        'job_title',
        'dispatch_area',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function assignedJobs(){
        return $this->hasMany(JobOrder::class, 'assigned_to');
    }

    public function createdJobs(){
        return $this->hasMany(JobOrder::class, 'assigned_by');
    }

    public function completionReports(){
        return $this->hasMany(CompletionReport::class);
    }

    public function adminReports(){
        return $this->hasMany(AdminReport::class);
    }
}
