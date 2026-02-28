<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletionReport extends Model
{
    /** @use HasFactory<\Database\Factories\CompletionReportFactory> */
    use HasFactory;

    protected $fillable =[
        'job_order_id',
        'employee_id',
        'supervisor_comments',
        'completion_time_from',
        'completion_time_to',
        'image',
    ];

    public function jobOrder(){
        return $this->belongsTo(JobOrder::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
