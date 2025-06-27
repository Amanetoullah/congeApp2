<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EmployeCongeMail;
use App\Notifications\CongeStatusNotification;
use Illuminate\Http\Request;
use App\Models\Conge;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CongeController extends Controller
{
    public function index()
    {
        $conges = Conge::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.conges.index', compact('conges'));
    }

    public function refuser(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $conge = Conge::with('user')->findOrFail($id);
            
            // Vérifier si le congé est déjà traité
            if ($conge->statut !== 'En attente') {
                return redirect()->back()->with('error', 'Cette demande de congé a déjà été traitée.');
            }

            // Mettre à jour le statut
            $conge->update([
                'statut' => 'Refuser',
                'remarque' => $request->input('remarque', 'Demande refusée par l\'administrateur')
            ]);

            // Envoyer la notification
            $conge->user->notify(new CongeStatusNotification($conge));

            // Envoyer l'email
            try {
                Mail::queue(new EmployeCongeMail(
                    $conge->user,
                    $conge->statut,
                    $conge->remarque ?? 'Demande refusée par l\'administrateur',
                    route('employes.conge.index')
                ));
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'envoi de l\'email de refus: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->back()->with('success', 'Demande de congé refusée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors du refus du congé: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Erreur lors du traitement de la demande de congé.');
        }
    }

    public function accepter(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $conge = Conge::with('user')->findOrFail($id);
            
            // Vérifier si le congé est déjà traité
            if ($conge->statut !== 'En attente') {
                return redirect()->back()->with('error', 'Cette demande de congé a déjà été traitée.');
            }

            // Mettre à jour le statut
            $conge->update([
                'statut' => 'Approuve',
                'remarque' => $request->input('remarque', 'Demande approuvée par l\'administrateur')
            ]);

            // Envoyer la notification
            $conge->user->notify(new CongeStatusNotification($conge));

            // Envoyer l'email
            try {
                Mail::queue(new EmployeCongeMail(
                    $conge->user,
                    $conge->statut,
                    $conge->remarque ?? 'Demande approuvée par l\'administrateur',
                    route('employes.conge.index')
                ));
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'envoi de l\'email d\'approbation: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->back()->with('success', 'Demande de congé approuvée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de l\'approbation du congé: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Erreur lors du traitement de la demande de congé.');
        }
    }

    public function show($id)
    {
        try {
            $conge = Conge::with('user')->findOrFail($id);
            return view('admin.conges.show', compact('conge'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Demande de congé introuvable.');
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $conge = Conge::findOrFail($id);
            
            // Vérifier si le congé peut être supprimé
            if ($conge->statut !== 'En attente') {
                return redirect()->back()->with('error', 'Seules les demandes en attente peuvent être supprimées.');
            }

            $conge->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Demande de congé supprimée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la suppression du congé: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Erreur lors de la suppression de la demande de congé.');
        }
    }
}
