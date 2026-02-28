<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    /** @use HasFactory<\Database\Factories\JobOrderFactory> */
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'assigned_to',
        'assigned_by',
        'assigned_at',
        'status',
        'priority',
    ];

    public function complaint(){
        return $this->belongsTo(Complaint::class);
    }

    public function assignedTo(){
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function assignedBy(){
        return $this->belongsTo(Employee::class, 'assigned_by');
    }

    public function completionReport(){
        return $this->hasOne(CompletionReport::class);
    }
}
