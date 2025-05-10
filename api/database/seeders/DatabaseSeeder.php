<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Division;
use App\Models\EmployeeJob;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Division::factory(5)->create();

        Position::factory(15)->create();
    
        Employee::factory(30)->create();
    
        EmployeeJob::factory(35)->create();
    }
}
