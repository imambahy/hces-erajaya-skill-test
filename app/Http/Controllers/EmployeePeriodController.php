<?php

namespace App\Http\Controllers;

use App\Models\EmployeePeriod;
use Illuminate\Http\Request;

class EmployeePeriodController extends Controller
{
    public function filter(Request $request)
    {
        $query = EmployeePeriod::query();

        if ($request->has('company_id') && $request->company_id) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->has('division_id') && $request->division_id) {
            $query->where('division_id', $request->division_id);
        }

        if ($request->has('level_id') && $request->level_id) {
            $query->where('level_id', $request->level_id);
        }

        if ($request->has('gender_id') && $request->gender_id) {
            $query->where('gender_id', $request->gender_id);
        }

        $data = $query->with(['employee', 'division', 'company', 'level'])
            ->get()
            ->groupBy('period')
            ->map(function ($group) {
                return [
                    'period' => $group->first()->period,
                    'employee_count' => $group->count(),
                ];
            })
            ->values();

        return response()->json($data);
    }
}
