<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employe;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Departement;
class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $departement = Departement::create([
            'name' => 'IT',
        ]);
        $departement = Departement::create([
            'name' => 'Marketing et Ventes',
        ]);
        $departement = Departement::create([
            'name' => 'Finance et comptabilite',
        ]);
      $user=  User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('0000'),
            'registration_number' => '1234567890',
            'hire_date' => '2021-01-01',

            'phone' => '1234567890',
            'address' => 'Admin',
            'city' => 'Nktt',
        ]);
        $roles = [
            ['name' => 'admin'],
            ['name' => 'employee'],
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }
        $user->assignRole('admin');
    }
}
