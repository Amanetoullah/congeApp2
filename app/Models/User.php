<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;

use App\Models\Departement;
use App\Models\Conge;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class,'departement_id');
    }

    public function conges()
    {
        return $this->hasMany(Conge::class);
    }

    /**
     * Get remaining leave days for the user
     */
    public function getRemainingLeaveDaysAttribute()
    {
        // Default leave days per year (you can adjust this)
        $totalLeaveDays = 25;
        
        // Get approved leaves for current year
        $usedLeaveDays = $this->conges()
            ->where('statut', 'Approuve')
            ->whereYear('date_debut', Carbon::now()->year)
            ->get()
            ->sum(function($conge) {
                $start = Carbon::parse($conge->date_debut);
                $end = Carbon::parse($conge->date_fin);
                return $start->diffInDays($end) + 1;
            });
        
        return max(0, $totalLeaveDays - $usedLeaveDays);
    }

    /**
     * Get pending leaves count for the user
     */
    public function getPendingLeavesCountAttribute()
    {
        return $this->conges()
            ->where('statut', 'En attente')
            ->count();
    }

    /**
     * Check if user has admin role
     */
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }
}
