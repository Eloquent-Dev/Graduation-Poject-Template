<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;

    protected $fillable = ['name', 'status'];

    public function employees(){
        return $this->hasMany(Employee::class);
    }

    public function sections(){
        return $this->hasMany(Section::class, 'dept_id');
    }

    public function categories(){
        return $this->hasMany(Category::class, 'dept_id');
    }
}
