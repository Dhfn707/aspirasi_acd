@extends('layouts.app')

@section('title', 'Daftar Aspirasi Karyawan')

@section('content')
<!-- Header Section -->
<div class="row mb-5">
    <div class="col-md-8">
        <h1 class="mb-3"><i class="fas fa-lightbulb"></i> Daftar Aspirasi Karyawan</h1>
        <p class="text-muted">Kelola dan pantau semua aspirasi yang masuk dari karyawan</p>
    </div>
</div>

<!-- Form Input Aspirasi & Petunjuk Section -->
<div class="row mb-5">
    <!-- Form Input Aspirasi -->
    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0"><i class="fas fa-edit text-primary"></i> Buat Aspirasi Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('aspirasi.store') }}" method="POST">
                    @csrf

                    <!-- Prioritas -->
                    <div class="mb-3">
                        <label for="prioritas" class="form-label fw-bold">
                            <i class="fas fa-flag text-danger"></i> Prioritas
                        </label>
                        <select class="form-select @error('prioritas') is-invalid @enderror" id="prioritas" name="prioritas" required>
                            <option value="">-- Pilih Prioritas --</option>
                            <option value="Rendah">Rendah</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Tinggi">Tinggi</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                        @error('prioritas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Aspirasi -->
                    <div class="mb-4">
                        <label for="aspirasi" class="form-label fw-bold">
                            <i class="fas fa-comment text-info"></i> Aspirasi
                        </label>
                        <textarea class="form-control @error('aspirasi') is-invalid @enderror"
                                  id="aspirasi"
                                  name="aspirasi"
                                  rows="6"
                                  placeholder="Tulis aspirasi Anda di sini..."
                                  maxlength="1000"
                                  required></textarea>
                        <small class="text-muted d-block mt-2">Maksimal 1000 karakter</small>
                        @error('aspirasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-paper-plane"></i> Kirim Aspirasi
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Petunjuk Penggunaan -->
    <div class="col-md-6">
        <div class="card shadow-sm border-info mb-4">
            <div class="card-header bg-light border-bottom border-info">
                <h5 class="mb-0"><i class="fas fa-info-circle text-info"></i> Petunjuk Penggunaan</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h6 class="fw-bold mb-2">
                        <i class="fas fa-check text-success"></i> Prioritas
                    </h6>
                    <p class="text-muted small">Pilih tingkat prioritas aspirasi Anda berdasarkan urgensi</p>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold mb-2">
                        <i class="fas fa-lightbulb text-warning"></i> Aspirasi
                    </h6>
                    <p class="text-muted small">Jelaskan aspirasi Anda dengan detail dan jelas agar mudah dipahami</p>
                </div>

                <div class="mb-0">
                    <h6 class="fw-bold mb-2">
                        <i class="fas fa-check-circle text-success"></i> Pengiriman
                    </h6>
                    <p class="text-muted small">Aspirasi Anda akan langsung ditampilkan di daftar aspirasi setelah dikirim</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('aspirasi.index') }}" class="row g-3">
                    <!-- Search Input -->
                    <div class="col-md-3">
                        <label for="search" class="form-label fw-bold">Cari Aspirasi</label>
                        <input type="text" class="form-control" id="search" name="search"
                               placeholder="Ketik kata kunci..." value="{{ request('search') }}">
                    </div>

                    <!-- Filter Prioritas -->
                    <div class="col-md-3">
                        <label for="prioritas" class="form-label fw-bold">Prioritas</label>
                        <select class="form-select" id="prioritas" name="prioritas">
                            <option value="">-- Semua Prioritas --</option>
                            <option value="Rendah" {{ request('prioritas') === 'Rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="Sedang" {{ request('prioritas') === 'Sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="Tinggi" {{ request('prioritas') === 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                            <option value="Urgent" {{ request('prioritas') === 'Urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                    </div>

                    <!-- Filter Hari -->
                    <div class="col-md-2">
                        <label for="hari" class="form-label fw-bold">Hari</label>
                        <select class="form-select" id="hari" name="hari">
                            <option value="">-- Semua --</option>
                            @for ($i = 1; $i <= 31; $i++)
                                <option value="{{ $i }}" {{ request('hari') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Filter Bulan -->
                    <div class="col-md-2">
                        <label for="bulan" class="form-label fw-bold">Bulan</label>
                        <select class="form-select" id="bulan" name="bulan">
                            <option value="">-- Semua --</option>
                            <option value="1" {{ request('bulan') == 1 ? 'selected' : '' }}>Jan</option>
                            <option value="2" {{ request('bulan') == 2 ? 'selected' : '' }}>Feb</option>
                            <option value="3" {{ request('bulan') == 3 ? 'selected' : '' }}>Mar</option>
                            <option value="4" {{ request('bulan') == 4 ? 'selected' : '' }}>Apr</option>
                            <option value="5" {{ request('bulan') == 5 ? 'selected' : '' }}>Mei</option>
                            <option value="6" {{ request('bulan') == 6 ? 'selected' : '' }}>Jun</option>
                            <option value="7" {{ request('bulan') == 7 ? 'selected' : '' }}>Jul</option>
                            <option value="8" {{ request('bulan') == 8 ? 'selected' : '' }}>Agu</option>
                            <option value="9" {{ request('bulan') == 9 ? 'selected' : '' }}>Sep</option>
                            <option value="10" {{ request('bulan') == 10 ? 'selected' : '' }}>Okt</option>
                            <option value="11" {{ request('bulan') == 11 ? 'selected' : '' }}>Nov</option>
                            <option value="12" {{ request('bulan') == 12 ? 'selected' : '' }}>Des</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-md-2 d-flex gap-2 align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('aspirasi.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Data Table Section -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-list"></i> Daftar Aspirasi ({{ isset($aspirasis) ? $aspirasis->total() : 0 }} total)
                </h5>
            </div>
            <div class="card-body">
                @if(isset($aspirasis) && $aspirasis->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Pengiriman</th>
                                    <th style="width: 200px;">Aspirasi</th>
                                    <th style="width: 100px;">Prioritas</th>
                                    <th style="width: 100px;">Status</th>
                                    <th style="width: 150px;">Tanggal</th>
                                    <th style="width: 120px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aspirasis as $key => $aspirasi)
                                    <tr>
                                        <td><strong>{{ $key + 1 }}</strong></td>
                                        <td>
                                            <strong>{{ $aspirasi->user->name ?? 'N/A' }}</strong><br>
                                            <small class="text-muted">{{ $aspirasi->user->email ?? 'N/A' }}</small><br>
                                            <small class="text-muted">
                                                <i class="fas fa-briefcase"></i> {{ $aspirasi->jabatan->nama ?? 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            <small>
                                                {{ Str::limit($aspirasi->aspirasi, 60, '...') }}
                                            </small>
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = [
                                                    'Rendah' => 'success',
                                                    'Sedang' => 'warning',
                                                    'Tinggi' => 'danger',
                                                    'Urgent' => 'danger'
                                                ][$aspirasi->prioritas] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $badgeClass }}">
                                                {{ $aspirasi->prioritas }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'Belum Dibaca' => 'primary',
                                                    'Dibaca' => 'info',
                                                    'Ditanggapi' => 'warning',
                                                    'Selesai' => 'success'
                                                ][$aspirasi->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">
                                                {{ $aspirasi->status ?? 'Belum Dibaca' }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $aspirasi->created_at->format('d M Y H:i') }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group-sm" role="group">
                                                <a href="{{ route('aspirasi.show', $aspirasi->id) }}" class="btn btn-sm btn-outline-primary"
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('aspirasi.edit', $aspirasi->id) }}" class="btn btn-sm btn-outline-warning"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('aspirasi.destroy', $aspirasi->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Hapus"
                                                            onclick="return confirm('Yakin ingin menghapus aspirasi ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if(isset($aspirasis) && $aspirasis->hasPages())
                        <nav class="mt-4">
                            {{ $aspirasis->links('pagination::bootstrap-5') }}
                        </nav>
                    @endif
                @else
                    <div class="alert alert-info text-center py-5">
                        <i class="fas fa-inbox text-muted" style="font-size: 2rem;"></i>
                        <p class="mt-3 mb-0">Belum ada aspirasi yang diinput</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
