@extends('adminlte::page')

@section('title')
    Ajouter un employé | Laravel Employés App
@endsection

@section('content_header')
    <h1>Ajouter un Employé</h1>
@endsection

@section('content')
<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-6"> {{-- Réduction de la largeur --}}
            <div class="card shadow-sm border-0"> {{-- Moins de shadow --}}
                <div class="card-header bg-primary text-white text-center py-2"> {{-- Réduction padding vertical --}}
                    <h5 class="mb-0">📝 Ajouter un Employé</h5> {{-- Plus petit titre --}}
                </div>
                <div class="card-body p-2"> {{-- Réduction padding intérieur --}}
                    @include('layouts.alert')
                    <livewire:employees.create />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
