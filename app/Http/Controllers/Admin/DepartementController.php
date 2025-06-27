<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartementController extends Controller
{
    public function index()
    {
        $departements = Departement::with('users')->orderBy('name')->get();
        return view('admin.departement.index', compact('departements'));
    }

    public function create()
    {
        return view('admin.departement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departements',
            'description' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Le nom du département est requis.',
            'name.unique' => 'Ce nom de département existe déjà.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'description.max' => 'La description ne doit pas dépasser 500 caractères.',
        ]);

        try {
            DB::beginTransaction();

            $departement = Departement::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.departement.index')
                ->with('success', 'Département créé avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating department: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création du département : ' . $e->getMessage());
        }
    }

    public function show(Departement $departement)
    {
        $departement->load('users');
        return view('admin.departement.show', compact('departement'));
    }

    public function edit(Departement $departement)
    {
        return view('admin.departement.edit', compact('departement'));
    }

    public function update(Request $request, Departement $departement)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departements,name,' . $departement->id,
            'description' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Le nom du département est requis.',
            'name.unique' => 'Ce nom de département existe déjà.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'description.max' => 'La description ne doit pas dépasser 500 caractères.',
        ]);

        try {
            DB::beginTransaction();

            $departement->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.departement.index')
                ->with('success', 'Département mis à jour avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating department: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour du département : ' . $e->getMessage());
        }
    }

    public function destroy(Departement $departement)
    {
        try {
            DB::beginTransaction();

            // Check if department has users
            if ($departement->users()->count() > 0) {
                throw new \Exception('Impossible de supprimer ce département car il contient des employés.');
            }

            $departement->delete();

            DB::commit();

            return redirect()
                ->route('admin.departement.index')
                ->with('success', 'Département supprimé avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting department: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Erreur lors de la suppression du département : ' . $e->getMessage());
        }
    }
}
