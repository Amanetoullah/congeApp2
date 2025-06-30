<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Departement;
use App\Models\Conge;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $stats = [
            'total_employees' => User::role('employee')->count(),
            'total_departments' => Departement::count(),
            'total_conges' => Conge::count(),
        ];
        return view('admin.home', compact('stats'));
    }
}
