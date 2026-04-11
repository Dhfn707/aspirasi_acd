<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AspirasiController extends Controller
{
    /**
     * Show list of aspirasi with filters and search
     */
    public function index(Request $request)
    {
        $query = Aspirasi::query();

        // Only show aspirations belonging to current user
        $query->where('user_id', session('user_id'));
        // Don't show Selesai status to karyawan
        $query->where('status', '!=', 'Selesai');

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
        $aspirasis = $query->with('user.jabatan')
                          ->orderBy('created_at', 'desc')
                          ->paginate(10)
                          ->withQueryString();

        return view('aspirasi.index', compact('aspirasis'));
    }


    //Show form to create new aspirasi
    public function create()
    {
        return view('aspirasi.create');
    }
     //Store aspirasi in database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prioritas' => 'required|in:Rendah,Sedang,Tinggi,Urgent',
            'aspirasi' => 'required|string|max:1000',
        ], [
            'prioritas.required' => 'Prioritas harus dipilih',
            'prioritas.in' => 'Prioritas tidak valid',
            'aspirasi.required' => 'Aspirasi harus diisi',
            'aspirasi.max' => 'Aspirasi maksimal 1000 karakter',
        ]);

        try {
            // Get user data from session
            $userId = session('user_id');

            // Create aspirasi
            $aspirasi = Aspirasi::create([
                'user_id' => $userId,
                'prioritas' => $validated['prioritas'],
                'aspirasi' => $validated['aspirasi'],
                'status' => 'Belum Dibaca',
            ]);



            return back()->with('success', 'Aspirasi berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show specific aspirasi
     */
    public function show($id)
    {
        $aspirasi = Aspirasi::with('user.jabatan')
                            ->where('user_id', session('user_id'))
                            ->findOrFail($id);

        // Prevent karyawan from viewing Selesai aspirasi
        if ($aspirasi->status === 'Selesai') {
            abort(403, 'Aspirasi ini sudah selesai diproses dan tidak bisa diakses lagi.');
        }

        return view('aspirasi.show', compact('aspirasi'));
    }

    //Show edit form for aspirasi
    public function edit($id)
    {
        $aspirasi = Aspirasi::with('user.jabatan')
                            ->where('user_id', session('user_id'))
                            ->findOrFail($id);
        // Prevent karyawan from editing Selesai aspirasi
        if ($aspirasi->status === 'Selesai') {
            abort(403, 'Aspirasi ini sudah selesai diproses dan tidak bisa diedit lagi.');
        }
        return view('aspirasi.edit', compact('aspirasi'));
    }
    //Update aspirasi in database
    public function update(Request $request, $id)
    {
        $aspirasi = Aspirasi::where('user_id', session('user_id'))->findOrFail($id);

        $validated = $request->validate([
            'prioritas' => 'required|in:Rendah,Sedang,Tinggi,Urgent',
            'aspirasi' => 'required|string|max:1000',
        ], [
            'prioritas.required' => 'Prioritas harus dipilih',
            'prioritas.in' => 'Prioritas tidak valid',
            'aspirasi.required' => 'Aspirasi harus diisi',
            'aspirasi.max' => 'Aspirasi maksimal 1000 karakter',
        ]);
        try {
            $aspirasi->update([
                'prioritas' => $validated['prioritas'],
                'aspirasi' => $validated['aspirasi'],
            ]);

            return redirect()
            ->route('aspirasi.show', $aspirasi->id)
            ->with('success', 'Aspirasi berhasil diupdate!');
        } catch (\Exception $e) {
            return back()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
            ->withInput();
        }
    }

    //Delete aspirasi
    public function destroy($id)
    {
        try {
            $aspirasi = Aspirasi::where('user_id', session('user_id'))->findOrFail($id);

            $aspirasi->delete();
            return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
