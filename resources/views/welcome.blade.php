@extends('layouts.app')

@section('title')
    Bienvenue | Application de Gestion des Congés
@endsection

@section('content')
 <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg rounded-lg p-4">
                    <div class="card-header bg-primary text-white text-center py-3 rounded-top-lg">
                        <h2 class="mb-0">Bienvenue sur congeApp</h2>
                    </div>

                <div class="card-body p-4">
                    @guest
                        <div class="card-body text-center p-5">
                        Simplifiez la gestion des demandes de congés de vos employés.
                            Que vous soyez un employé soumettant une demande ou un administrateur gérant les approbations, notre application est là pour vous aider.
                        </p>

                            @guest
                            <p class="mb-4">Veuillez vous connecter pour accéder à toutes les fonctionnalités.</p>
                        @endguest
                            <div class="d-grid gap-2">
                                <a href="{{ route('login')}}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
                                </a>
                                <a href="{{ route('register')}}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-user-plus mr-2"></i> S'inscrire
                                </a>
                            </div>
                        </div>
                    @endguest

                    @auth
                        <div class="text-center">
                            <div class="user-welcome mb-3">
                                <div class="user-avatar mb-2">
                                    @if(Auth::user()->image && Auth::user()->image!== 'images/default-avatar.png')
                                        <img src="{{ asset('storage/'. Auth::user()->image)}}" alt="Avatar" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="avatar-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                                <h5 class="mb-1">Bienvenue, {{ Auth::user()->name}}!</h5>
                                <p class="text-muted mb-3" style="font-size: 0.85rem;">
                                    @if(Auth::user()->hasRole('admin'))
                                        Vous êtes connecté en tant qu'administrateur.
                                    @else
                                        Vous êtes connecté en tant qu'employé.
                                    @endif
                                </p>
                            </div>

                            <div class="d-grid gap-2">
                                @if(Auth::user()->hasRole('admin'))
                                    <a href="{{ route('admin.dashboard')}}" class="btn btn-success btn-sm">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Tableau de Bord Admin
                                    </a>
                                @else<a href="{{ route('employes.dashboard')}}" class="btn btn-success btn-sm">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Mon Tableau de Bord
                                    </a>
                                @endif

                                <form action="{{ route('logout')}}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Se déconnecter
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>

                <div class="card-footer bg-light border-0 text-center py-2">
                    <small class="text-muted" style="font-size: 0.8rem;">
                        <i class="fas fa-copyright mr-1"></i>
                        {{ date('Y')}} CongeApp. Tous droits réservés.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
/* Bar de couleur */
.welcome-bar {
    height: 5px;
    width: 100%;
    background: linear-gradient(90deg, #007bff, #764ba2);
    border-radius: 3px;
}

/* Avatar */
.user-avatar img {
    width: 60px;
    height: 60px;
    object-fit: cover;
}

.avatar-placeholder {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

/* Buttons */
.btn {
    border-radius: 20px;
    font-weight: 500;
    transition: all 0.3s ease;
    padding: 0.5rem 1.5rem;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.15);
}

.btn-sm {
    padding: 0.4rem 1rem;
    font-size: 0.9rem;
}

/* Text adjustments */
.lead {
    font-size: 0.9rem;
    font-weight: 400;
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-footer small {
    font-size: 0.8rem;
}
</style>
@endsection
