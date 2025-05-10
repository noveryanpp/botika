<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];

    public function positions()
    {
        return $this->hasMany(Position::class);
    }
    
    public function employeeJobs()
    {
        return $this->hasMany(EmployeeJob::class);
    }
}
