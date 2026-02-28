<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /** @use HasFactory<\Database\Factories\SectionFactory> */
    use HasFactory;

    protected $fillable = ['name', 'dept_id'];

    public function department(){
        return $this->belongsTo(Department::class, 'dept_id');
    }

    public function divisions(){
        return $this->hasMany(Division::class);
    }
}
