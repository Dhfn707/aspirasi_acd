<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard(Request $request)
    {
        // Get status counts
        $belumDibaca = Aspirasi::where('status', 'Belum Dibaca')->count();
        $dibaca = Aspirasi::where('status', 'Dibaca')->count();
        $ditanggapi = Aspirasi::where('status', 'Ditanggapi')->count();
        $selesai = Aspirasi::where('status', 'Selesai')->count();

        // Build query for aspirasi list
        $query = Aspirasi::query();

        // Filter by prioritas
        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->input('prioritas'));
        }

        // Filter by hari
        if ($request->filled('hari')) {
            $day = intval($request->input('hari'));
            if ($day >= 1 && $day <= 31) {
                $query->whereDay('created_at', $day);
            }
        }

        // Filter by bulan
        if ($request->filled('bulan')) {
            $month = intval($request->input('bulan'));
            if ($month >= 1 && $month <= 12) {
                $query->whereMonth('created_at', $month);
            }
        }

        // Search by keyword (aspirasi content)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('aspirasi', 'like', '%' . $search . '%');
        }

        // Get paginated results
        $aspirasis = $query->with(['user', 'jabatan'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(10)
                          ->withQueryString();

        return view('admin.dashboard', compact('aspirasis', 'belumDibaca', 'dibaca', 'ditanggapi', 'selesai'));
    }

    /**
     * Show specific aspirasi for admin (auto-mark as dibaca)
     */
    public function show($id)
    {
        $aspirasi = Aspirasi::with(['user', 'jabatan'])->findOrFail($id);

        // Auto-update status to Dibaca if still Belum Dibaca
        if ($aspirasi->status === 'Belum Dibaca') {
            $aspirasi->update(['status' => 'Dibaca']);
        }

        return view('admin.show', compact('aspirasi'));
    }

    /**
     * Update aspirasi (tanggapan_admin and status)
     */
    public function update(Request $request, $id)
    {
        $aspirasi = Aspirasi::findOrFail($id);

        $validated = $request->validate([
            'tanggapan_admin' => 'required|string|max:2000',
            'status' => 'required|in:Ditanggapi,Selesai',
        ], [
            'tanggapan_admin.required' => 'Tanggapan harus diisi',
            'tanggapan_admin.max' => 'Tanggapan maksimal 2000 karakter',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid',
        ]);

        try {
            // If tanggapan is provided and status is not explicitly Selesai, auto set to Ditanggapi
            $status = $validated['status'];
            if (!empty($validated['tanggapan_admin']) && $status !== 'Selesai') {
                $status = 'Ditanggapi';
            }

            $aspirasi->update([
                'tanggapan_admin' => $validated['tanggapan_admin'],
                'status' => $status,
            ]);

            return redirect()->route('admin.aspirasi.show', $aspirasi->id)->with('success', 'Tanggapan berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
