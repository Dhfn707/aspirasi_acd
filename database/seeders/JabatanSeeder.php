<?php

namespace Database\Seeders;

use App\Models\JabatanAbsen;
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
        JabatanAbsen::create(['nama' => 'Manager']);
        JabatanAbsen::create(['nama' => 'Supervisor']);
        JabatanAbsen::create(['nama' => 'Staff']);
        JabatanAbsen::create(['nama' => 'Intern']);
    }
}
