<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    /** @use HasFactory<\Database\Factories\FeedbackFactory> */
    use HasFactory;

    protected $fillable =[
        'complaint_id',
        'rating',
        'quality_comment',
        'speed_rating',
    ];

    public function complaint(){
        return $this->belongsTo(Complaint::class);
    }
}
