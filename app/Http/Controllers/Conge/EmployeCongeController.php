<?php

namespace App\Http\Controllers\Conge;

use App\Http\Controllers\Controller;
use App\Mail\AdminCongeMail;
use App\Models\Conge;
use App\Service\AdminService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmployeCongeController extends Controller
{
    public AdminService $adminservice;

    public function __construct(AdminService $adminservice)
    {
        $this->adminservice = $adminservice;
    }

    public function index()
    {
        $user = Auth::user();
        $conges = $user->conges()->orderBy('created_at', 'desc')->get();
        return view("employee-views.conges.index", compact("conges"));
    }

    public function create()
    {
        return view('employee-views.conges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:Congé annuel,Congé maladie,Congé maternité,Congé paternité,Congé exceptionnel',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'justificatif' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120', // 5MB max
            'motif' => 'nullable|string|max:500',
            'confirmation' => 'required',
        ], [
            'type.required' => 'Le type de congé est requis.',
            'type.in' => 'Le type de congé sélectionné n\'est pas valide.',
            'date_debut.required' => 'La date de début est requise.',
            'date_debut.after_or_equal' => 'La date de début doit être aujourd\'hui ou une date future.',
            'date_fin.required' => 'La date de fin est requise.',
            'date_fin.after_or_equal' => 'La date de fin doit être égale ou postérieure à la date de début.',
            'justificatif.file' => 'Le justificatif doit être un fichier.',
            'justificatif.mimes' => 'Le justificatif doit être au format PDF, JPG, PNG, DOC ou DOCX.',
            'justificatif.max' => 'Le justificatif ne doit pas dépasser 5MB.',
            'motif.max' => 'Le motif ne doit pas dépasser 500 caractères.',
            'confirmation.required' => 'Vous devez confirmer que les informations sont exactes.',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            
            \Log::info('Creating leave request for user: ' . $user->id, [
                'type' => $request->type,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'has_justificatif' => $request->hasFile('justificatif')
            ]);

            // Check if user has pending requests (optional - uncomment if needed)
            // if ($user->conges()->where('statut', 'En attente')->count() > 0) {
            //     throw new Exception('Vous avez déjà une demande en cours.');
            // }

            // Handle justificatif upload
            $justificatifPath = null;
            if ($request->hasFile('justificatif')) {
                $justificatifPath = $request->file('justificatif')->store('justificatifs', 'public');
                \Log::info('File uploaded: ' . $justificatifPath);
            }

            // Create the congé
            $congeData = [
                'type' => $request->type,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'motif' => $request->motif,
                'justificatif' => $justificatifPath,
                'user_id' => $user->id,
                'statut' => 'En attente',
            ];
            
            \Log::info('Creating congé with data:', $congeData);
            
            $conge = Conge::create($congeData);
            
            \Log::info('Congé created successfully with ID: ' . $conge->id);

            // Send email notification to admins
            try {
                $admins = $this->adminservice->getAdmins();
                \Log::info('Found ' . $admins->count() . ' admin users');
                
                if ($admins->count() > 0) {
                    Mail::queue(new AdminCongeMail(
                        $admins->toArray(),
                        "Nouvelle demande de congé de " . $user->name,
                        $conge->motif ?? 'Aucun motif fourni',
                        url('/admin/conges')
                    ));
                    \Log::info('Admin notification email queued successfully');
                } else {
                    \Log::warning('No admin users found to send notification to');
                }
            } catch (Exception $mailException) {
                // Log mail error but don't fail the request
                \Log::error('Failed to send admin notification email: ' . $mailException->getMessage());
            }

            DB::commit();
            \Log::info('Leave request transaction committed successfully');

            return redirect()
                ->route('employes.conge.index')
                ->with('success', 'Votre demande de congé a été envoyée avec succès !');

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Error creating leave request: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request_data' => $request->except(['justificatif']),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'envoi de la demande : ' . $e->getMessage());
        }
    }
}
