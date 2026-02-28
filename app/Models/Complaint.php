<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    /** @use HasFactory<\Database\Factories\ComplaintFactory> */
    use HasFactory;
    use softDeletes;

    protected $fillable =[
        'title',
        'status',
        'description',
        'category_id',
        'user_id',
        'area',
        'district',
        'street',
        'building_no',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function jobOrder(){
        return $this->hasOne(JobOrder::class);
    }

    public function feedback(){
        return $this->hasMany(Feedback::class);
    }

    public function reopenedComplaint(){
        return $this->belongsTo(Complaint::class, 'reopened_from_id');
    }
}
