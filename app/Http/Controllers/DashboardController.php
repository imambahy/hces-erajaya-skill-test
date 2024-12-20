<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Division;
use App\Models\Level;
use App\Models\Gender;

class DashboardController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        $divisions = Division::all();
        $levels = Level::all();
        $genders = Gender::all();

        return view('dashboard', compact('companies', 'divisions', 'levels', 'genders'));
    }
}
