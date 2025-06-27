<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Conge\EmployeCongeController;
use App\Http\Controllers\EmployeeHomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EmployesController;
use App\Http\Controllers\Admin\DepartementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CongeController;
use App\Http\Controllers\NotificationsController;
use App\Livewire\Conges\Create;





//<<<<<<< HEAD

Route::get('/',function(){
    return view('welcome');
})->name('welcome');

Route::get('/conges', [\App\Http\Controllers\CongeController::class, 'index']);


// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware(['auth'])->group(function() {
    // Admin routes with role middleware
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Employes routes
        Route::get('/employes', [EmployesController::class, 'index'])->name('employes.index');
        Route::get('/employes/create', [EmployesController::class, 'create'])->name('employes.create');
        Route::get('/employes/{id}', [EmployesController::class, 'show'])->name('employes.show');
        Route::get('/employes/{id}/edit', [EmployesController::class, 'edit'])->name('employes.edit');
        Route::put('/employes/{id}', [EmployesController::class, 'update'])->name('employes.update');
        Route::delete('/employes/{id}', [EmployesController::class, 'destroy'])->name('employes.destroy');
        Route::post('/employes/store', [EmployesController::class, 'store'])->name('employes.store');

        // Departements routes
        Route::resource('departement', DepartementController::class);

        // Conges routes
        Route::prefix('/conges')->name('conges.')->group(function() {
            Route::get('/', [CongeController::class,'index'])->name('index');
            Route::get('/{id}', [CongeController::class,'show'])->name('show');
            Route::post('/{id}/accept', [CongeController::class,'accepter'])->name('accept');
            Route::post('/{id}/refuse', [CongeController::class,'refuser'])->name('refuse');
            Route::delete('/{id}', [CongeController::class,'destroy'])->name('destroy');
        });
    });
});


    Route::middleware(['auth'])->group(function () {

    Route::prefix('employe')->name('employes.')->group(function () {
        Route::get('/dashboard', [EmployeeHomeController::class, 'index'])->name('dashboard');
        Route::get('/conges', [EmployeCongeController::class, 'index'])->name('conge.index');
        Route::get('/conges/create', [EmployeCongeController::class, 'create'])->name('conge.create');
        Route::post('/conges/store', [EmployeCongeController::class, 'store'])->name('conge.store');
       
    });

    // Notifications routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationsController::class, 'index'])->name('index');
        Route::post('/{id}/mark-as-read', [NotificationsController::class, 'markAsRead'])->name('mark-as-read');
        Route::post('/mark-all-as-read', [NotificationsController::class, 'markAllAsRead'])->name('mark-all-as-read');
        Route::delete('/{id}', [NotificationsController::class, 'destroy'])->name('destroy');
        Route::delete('/clear-all', [NotificationsController::class, 'clearAll'])->name('clear-all');
        Route::get('/count', [NotificationsController::class, 'count'])->name('count');
        Route::get('/stats', [NotificationsController::class, 'stats'])->name('stats');
        Route::get('/{id}/read-and-redirect', [NotificationsController::class, 'markAsReadAndRedirect'])->name('read-and-redirect');
        Route::get('/unread-count', [NotificationsController::class, 'unreadCount'])->name('unread-count');
        Route::get('/recent', [NotificationsController::class, 'recent'])->name('recent');
        Route::get('/filtered', [NotificationsController::class, 'getFiltered'])->name('filtered');
    });

});
