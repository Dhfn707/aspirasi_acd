<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\JabatanAbsen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get or create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $karyawanRole = Role::firstOrCreate(['name' => 'karyawan']);

        // Get or create positions
        $managerPos = JabatanAbsen::firstOrCreate(['nama' => 'Manager']);
        $supervisorPos = JabatanAbsen::firstOrCreate(['nama' => 'Supervisor']);
        $staffPos = JabatanAbsen::firstOrCreate(['nama' => 'Staff']);
        $internPos = JabatanAbsen::firstOrCreate(['nama' => 'Intern']);

        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@company.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
            'jabatan_id' => $managerPos->id,
        ]);

        // Create Karyawan Users
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@company.com',
            'password' => Hash::make('password123'),
            'role_id' => $karyawanRole->id,
            'jabatan_id' => $supervisorPos->id,
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@company.com',
            'password' => Hash::make('password123'),
            'role_id' => $karyawanRole->id,
            'jabatan_id' => $staffPos->id,
        ]);

        User::create([
            'name' => 'Ahmad Wijaya',
            'email' => 'ahmad@company.com',
            'password' => Hash::make('password123'),
            'role_id' => $karyawanRole->id,
            'jabatan_id' => $internPos->id,
        ]);
    }
}
