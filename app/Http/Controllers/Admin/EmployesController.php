<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployesController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['departement', 'roles', 'conges'])
            ->whereHas('roles', function($query) {
                $query->where('name', 'employee');
            });

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('registration_number', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%")
                  ->orWhereHas('departement', function($deptQuery) use ($search) {
                      $deptQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by department
        if ($request->has('department') && !empty($request->department)) {
            $query->whereHas('departement', function($deptQuery) use ($request) {
                $deptQuery->where('id', $request->department);
            });
        }

        // Sort functionality
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        
        // Validate sort field
        $allowedSortFields = ['name', 'email', 'registration_number', 'hire_date', 'phone', 'city'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'name';
        }

        if ($sortField === 'department') {
            $query->join('departements', 'users.departement_id', '=', 'departements.id')
                  ->orderBy('departements.name', $sortDirection)
                  ->select('users.*');
        } else {
            $query->orderBy($sortField, $sortDirection);
        }

        $employes = $query->get();

        // If it's an AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'employes' => $employes,
                'total' => $employes->count()
            ]);
        }

        // Get departments for filter dropdown
        $departments = Departement::all();

        return view('admin.employes.index', compact('employes', 'departments'));
    }

    public function create()
    {
        $departements = \App\Models\Departement::all();
        return view('admin.employes.create', compact('departements'));
    }

    public function show(string $id)
    {
        $employe = User::with(['departement', 'roles'])->findOrFail($id);
        $departements = Departement::all();
        return view('admin.employes.show', compact('employe', 'departements'));
    }

    public function edit($id)
    {
        $employe = User::with(['departement', 'roles'])->findOrFail($id);
        $departements = Departement::select('id', 'name')->get();

        return view('admin.employes.edit', compact('employe', 'departements'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255',
            'departement_id' => 'required|integer|exists:departements,id',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[2-4][0-9]{7}$/',
            'hire_date' => 'required|date'
        ]);

        DB::transaction(function() use ($validated, $id) {
            $employe = User::findOrFail($id);
            $departement = Departement::findOrFail($validated['departement_id']);

            $employe->departement()->associate($departement);
            $employe->update([
                'name' => $validated['name'],
                'address' => $validated['address'],
                'registration_number' => $validated['registration_number'],
                'city' => $validated['city'],
                'hire_date' => $validated['hire_date'],
                'phone' => $validated['phone'],
            ]);
        });

        return redirect()->route('admin.employes.index')
            ->with('success', 'Employé modifié avec succès');
    }

    public function destroy($id)
    {
        $employe = User::findOrFail($id);
        $employe->delete();

        return redirect()->route('admin.employes.index')
            ->with('success', 'Employé supprimé avec succès');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'registration_number' => 'required|unique:users',
            'departement' => 'required|exists:departements,id',
            'hire_date' => 'required|date',
            'phone' => 'required|regex:/^[2-4][0-9]{7}$/',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $path = $request->file('image')
            ? $request->file('image')->store('images', 'public')
            : 'images/default-avatar.png';

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'image' => $path,
            'password' => bcrypt($validated['password']),
            'registration_number' => $validated['registration_number'],
            'hire_date' => $validated['hire_date'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'departement_id' => $validated['departement'],
        ]);

        $user->assignRole('employee');

        return redirect()->route('admin.employes.index')
            ->with('message', '✅ تم إضافة الموظف بنجاح!');
    }
}
