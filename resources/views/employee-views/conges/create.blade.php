@extends('layouts.user')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        @livewire('alert-message')
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4>📅 Demande de congé</h4>
                </div>
                <div class="card-body p-4">
                    @if(session()->has('message'))
                        <div class="alert alert-success text-center">{{ session('message')}}</div>
                    @endif

                    <form action="{{ route('employe.conge.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-primary">Type:</label>
                                <select name="type" class="form-select">

                                    <option value="vacances"> Vacances</option>
                                    <option value="maladie">Maladie</option>
                                    <option value="Exceptionnel">Exceptionnel</option>

                                    
                                </select>
                                @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-primary">Date début:</label>
                                <input type="date" name="date_debut" @old('date_debut')   class="form-control" required>
                                @error('date_debut') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-primary">Date fin:</label>
                                <input type="date" name="date_fin" class="form-control" required>
                                @error('date_fin') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-primary">Justificatif:</label>
                                <input type="file" name="justificatif" class="form-control">
                                <small class="text-muted">Formats acceptés: PDF, JPG, PNG</small>
                                @error('justificatif') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-primary">Motif (optionnel):</label>
                                <textarea name="motif" class="form-control" rows="2" placeholder="Expliquez brièvement..." style="resize: none;"></textarea>
                               @error('motif')
                                   <span class="text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                        </div>
                         <div class="text-center">
                            <span wire:loading wire:target="store" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3 rounded-pill">
                            <i class="fas fa-paper-plane"></i> Envoyer
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

