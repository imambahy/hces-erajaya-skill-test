<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'division_id',
        'company_id',
        'gender_id',
        'level_id',
        'period',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
