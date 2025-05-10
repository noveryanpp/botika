<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'description', 'division_id'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function employeeJobs()
    {
        return $this->hasMany(EmployeeJob::class);
    }
}
