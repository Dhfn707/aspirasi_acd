<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\JabatanAbsen;
use App\Models\Aspirasi;

class TestDatabaseConnections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:database-connections';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test multi-database setup';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('=== Testing Database Connections ===');

        $this->info("\n=== Testing User Model (from absen_karyawan) ===");
        $user = User::first();
        if ($user) {
            $this->info("✓ User retrieved successfully!");
            $this->line("  Connection: " . $user->getConnectionName());
            $this->line("  Table: " . $user->getTable());
            $this->line("  User: " . $user->name . " (ID: " . $user->id . ")");
            $this->line("  Email: " . $user->email);
        } else {
            $this->error("✗ No users found in absen_karyawan.user table");
        }

        $this->info("\n=== Testing Jabatan Model (from absen_karyawan) ===");
        $jabatan = JabatanAbsen::first();
        if ($jabatan) {
            $this->info("✓ Jabatan retrieved successfully!");
            $this->line("  Connection: " . $jabatan->getConnectionName());
            $this->line("  Table: " . $jabatan->getTable());
            $this->line("  Jabatan: " . $jabatan->nama . " (ID: " . $jabatan->id . ")");
        } else {
            $this->error("✗ No jabatan found in absen_karyawan.jabatan table");
        }

        if ($user && $user->jabatan) {
            $this->info("\n=== Testing User-Jabatan Relationship ===");
            $this->info("✓ User Jabatan Relationship works!");
            $this->line("  User " . $user->name . " has jabatan: " . $user->jabatan->nama);
        }

        $this->info("\n=== Testing Aspirasi Model (from aspirasi_acd) ===");
        $aspirasi = Aspirasi::first();
        if ($aspirasi) {
            $this->info("✓ Aspirasi retrieved successfully!");
            $this->line("  Connection: " . $aspirasi->getConnectionName());
            $this->line("  Aspirasi: " . substr($aspirasi->aspirasi, 0, 50) . "...");
            if ($aspirasi->user) {
                $this->line("  User (from absen_karyawan): " . $aspirasi->user->name);
            }
        } else {
            $this->warn("⚠ No aspirasi found in aspirasi_acd.aspirasis table");
        }

        $this->info("\n✓ All tests completed!");
        return 0;
    }
}
