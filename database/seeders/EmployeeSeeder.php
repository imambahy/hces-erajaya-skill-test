<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeePeriod;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i=0; $i < 100; $i++) {
            $employee = Employee::create([
                'employee_number'   => $faker->numberBetween(100000, 200000),
                'employee_name'     => $faker->name,
                'employee_address'  => $faker->address
            ]);

            for ($i=1; $i < 13 ; $i++) { 
                EmployeePeriod::create([
                    'employee_id'   => $employee->id,
                    'division_id'   => rand(1, 6),
                    'company_id'    => rand(1, 6),
                    'gender_id'     => rand(1, 6),
                    'level_id'      => rand(1, 6),
                    'period'        => '2024'.$i
                ]);
            }
        }
    }
}
