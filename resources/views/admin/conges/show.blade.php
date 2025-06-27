<div class="conge-details">
    <div class="row">
        <div class="col-md-6">
            <div class="detail-section mb-4">
                <h6 class="text-primary font-weight-bold mb-3">
                    <i class="fas fa-user mr-2"></i>Informations de l'employé
                </h6>
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-lg mr-3">
                        @if ($conge->user->image && $conge->user->image !== 'images/default-avatar.png')
                            <img src="{{ asset('storage/' . $conge->user->image) }}" alt="Avatar" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user text-white" style="font-size: 1.5rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h5 class="mb-1 font-weight-bold">{{ $conge->user->name }}</h5>
                        <p class="text-muted mb-1">{{ $conge->user->email }}</p>
                        <span class="badge badge-info badge-pill">{{ $conge->user->departement->nom ?? 'Aucun département' }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="detail-section mb-4">
                <h6 class="text-primary font-weight-bold mb-3">
                    <i class="fas fa-calendar-alt mr-2"></i>Détails du congé
                </h6>
                <div class="row">
                    <div class="col-6">
                        <div class="detail-item mb-2">
                            <small class="text-muted">Type de congé</small>
                            <div class="font-weight-bold">
                                <span class="badge badge-info badge-pill">{{ $conge->type }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="detail-item mb-2">
                            <small class="text-muted">Statut</small>
                            <div>
                                @if($conge->statut == 'Approuve')
                                    <span class="badge badge-success badge-pill">
                                        <i class="fas fa-check mr-1"></i>Approuvé
                                    </span>
                                @elseif($conge->statut == 'Refuser')
                                    <span class="badge badge-danger badge-pill">
                                        <i class="fas fa-times mr-1"></i>Refusé
                                    </span>
                                @else
                                    <span class="badge badge-warning badge-pill">
                                        <i class="fas fa-clock mr-1"></i>En attente
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="detail-section mb-4">
                <h6 class="text-primary font-weight-bold mb-3">
                    <i class="fas fa-calendar-day mr-2"></i>Période de congé
                </h6>
                <div class="row">
                    <div class="col-6">
                        <div class="detail-item mb-3">
                            <small class="text-muted">Date de début</small>
                            <div class="font-weight-bold text-success">
                                <i class="fas fa-play mr-1"></i>
                                {{ \Carbon\Carbon::parse($conge->date_debut)->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="detail-item mb-3">
                            <small class="text-muted">Date de fin</small>
                            <div class="font-weight-bold text-danger">
                                <i class="fas fa-stop mr-1"></i>
                                {{ \Carbon\Carbon::parse($conge->date_fin)->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail-item">
                    <small class="text-muted">Durée totale</small>
                    <div class="font-weight-bold">
                        @php
                            $start = \Carbon\Carbon::parse($conge->date_debut);
                            $end = \Carbon\Carbon::parse($conge->date_fin);
                            $duration = $start->diffInDays($end) + 1;
                        @endphp
                        <span class="badge badge-light badge-pill">
                            <i class="fas fa-calendar-day mr-1"></i>
                            {{ $duration }} jour(s)
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="detail-section mb-4">
                <h6 class="text-primary font-weight-bold mb-3">
                    <i class="fas fa-info-circle mr-2"></i>Informations supplémentaires
                </h6>
                <div class="detail-item mb-3">
                    <small class="text-muted">Motif du congé</small>
                    <div class="font-weight-bold">
                        {{ $conge->motif ?? 'Aucun motif spécifié' }}
                    </div>
                </div>
                @if($conge->remarque)
                    <div class="detail-item mb-3">
                        <small class="text-muted">Remarque administrative</small>
                        <div class="font-weight-bold text-info">
                            {{ $conge->remarque }}
                        </div>
                    </div>
                @endif
                <div class="detail-item">
                    <small class="text-muted">Date de soumission</small>
                    <div class="font-weight-bold">
                        {{ $conge->created_at->format('d/m/Y à H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($conge->justificatif)
        <div class="detail-section">
            <h6 class="text-primary font-weight-bold mb-3">
                <i class="fas fa-file-alt mr-2"></i>Justificatif
            </h6>
            <div class="justificatif-preview">
                <a href="/storage{{ $conge->justificatif }}" target="_blank" class="btn btn-outline-primary">
                    <i class="fas fa-file-alt mr-2"></i>
                    Voir le justificatif
                </a>
                <small class="text-muted d-block mt-2">
                    Cliquez pour ouvrir le document dans un nouvel onglet
                </small>
            </div>
        </div>
    @endif

    @if($conge->statut !== 'En attente')
        <div class="detail-section mt-4">
            <h6 class="text-primary font-weight-bold mb-3">
                <i class="fas fa-history mr-2"></i>Historique de traitement
            </h6>
            <div class="timeline-item">
                <div class="d-flex align-items-center">
                    <div class="timeline-icon mr-3">
                        @if($conge->statut == 'Approuve')
                            <i class="fas fa-check-circle text-success"></i>
                        @else
                            <i class="fas fa-times-circle text-danger"></i>
                        @endif
                    </div>
                    <div>
                        <div class="font-weight-bold">
                            Demande {{ $conge->statut == 'Approuve' ? 'approuvée' : 'refusée' }}
                        </div>
                        <small class="text-muted">
                            {{ $conge->updated_at->format('d/m/Y à H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.conge-details {
    padding: 1rem;
}

.detail-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.detail-item {
    margin-bottom: 1rem;
}

.detail-item:last-child {
    margin-bottom: 0;
}

.avatar-lg {
    flex-shrink: 0;
}

.timeline-item {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.timeline-icon {
    font-size: 1.5rem;
}

.justificatif-preview {
    text-align: center;
    padding: 1rem;
    background: white;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.badge {
    font-size: 0.8rem;
}

.font-weight-bold {
    font-weight: 600 !important;
}
</style> 