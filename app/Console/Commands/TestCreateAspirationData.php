<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Aspirasi;

class TestCreateAspirationData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:create-aspiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test aspiration data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('=== Creating Test Aspiration Data ===');

        // Get first user from absen_karyawan
        $user = User::first();
        if (!$user) {
            $this->error('No users found in absen_karyawan.user table');
            return 1;
        }

        $this->line("Using User: " . $user->name . " (ID: " . $user->id . ")");

        // Create aspiration
        try {
            $aspirasi = Aspirasi::create([
                'user_id' => $user->id,
                'jabatan_id' => $user->jabatan_id ?? 1,
                'prioritas' => 'Tinggi',
                'aspirasi' => 'Ini adalah aspirasi test dari user ' . $user->name . ' di database terpisah',
                'status' => 'Belum Dibaca',
            ]);

            $this->info("\n✓ Aspiration created successfully!");
            $this->line("  ID: " . $aspirasi->id);
            $this->line("  User ID: " . $aspirasi->user_id);
            $this->line("  Status: " . $aspirasi->status);
            $this->line("  Created at: " . $aspirasi->created_at);

            // Test relationship
            $this->info("\n=== Testing Cross-Database Relationship ===");
            $aspirasi = Aspirasi::find($aspirasi->id);
            if ($aspirasi->user) {
                $this->info("✓ Cross-database relationship works!");
                $this->line("  Aspiration from aspirasi_acd.aspirasis");
                $this->line("  -> User from absen_karyawan.user: " . $aspirasi->user->name);
                $this->line("  -> User email: " . $aspirasi->user->email);
                if ($aspirasi->user->jabatan) {
                    $this->line("  -> User jabatan: " . $aspirasi->user->jabatan->nama);
                }
            }

            return 0;
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }
    }
}
