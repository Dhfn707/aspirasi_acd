<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jabatan::create(['name' => 'Manager']);
        Jabatan::create(['name' => 'Supervisor']);
        Jabatan::create(['name' => 'Staff']);
        Jabatan::create(['name' => 'Intern']);
    }
}
