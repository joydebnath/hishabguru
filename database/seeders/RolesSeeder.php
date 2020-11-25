<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate([
            'name' => 'Admin',
            'slug' => 'admin',
        ], [
            'permissions' => json_encode(["*"])
        ]);

        Role::firstOrCreate([
            'name' => 'Lead Sales',
            'slug' => 'lead-sales',
        ], [
            'permissions' => json_encode([])
        ]);

        Role::firstOrCreate([
            'name' => 'Sales',
            'slug' => 'sales',
        ], [
            'permissions' => json_encode([])
        ]);

        Role::firstOrCreate([
            'name' => 'Payroll Only',
            'slug' => 'payroll-only',
        ], [
            'permissions' => json_encode([])
        ]);
    }
}
