<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AdminService
{
    public function getAdmins(): Collection
    {
        return User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();
    }
}
?>
