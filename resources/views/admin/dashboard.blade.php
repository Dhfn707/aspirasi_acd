@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Header Section -->
<div class="row mb-5">
    <div class="col-md-8">
        <h1 class="mb-3"><i class="fas fa-lightbulb"></i> Daftar Aspirasi Karyawan</h1>
        <p class="text-muted">Kelola dan pantau semua aspirasi yang masuk dari karyawan</p>
    </div>
</div>

<!-- Status Cards Section -->
<div class="row mb-5">
    <!-- Belum Dibaca -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #1a3a52 0%, #0f2536 100%); color: white;">
            <div class="card-body text-center py-4">
                <i class="fas fa-envelope" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
                <h6 class="card-title fw-normal mb-2">Belum Dibaca</h6>
                <h2 class="card-text" style="color: #ff6b6b;">{{ $belumDibaca }}</h2>
            </div>
        </div>
    </div>

    <!-- Dibaca -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #4a8bb7 0%, #3a7aa3 100%); color: white;">
            <div class="card-body text-center py-4">
                <i class="fas fa-eye" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
                <h6 class="card-title fw-normal mb-2">Dibaca</h6>
                <h2 class="card-text">{{ $dibaca }}</h2>
            </div>
        </div>
    </div>

    <!-- Ditanggapi -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #7ab8d4 0%, #5ba8c8 100%); color: white;">
            <div class="card-body text-center py-4">
                <i class="fas fa-spinner" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
                <h6 class="card-title fw-normal mb-2">Ditanggapi</h6>
                <h2 class="card-text">{{ $ditanggapi }}</h2>
            </div>
        </div>
    </div>

    <!-- Selesai -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #52a89a 0%, #3a9a8a 100%); color: white;">
            <div class="card-body text-center py-4">
                <i class="fas fa-check-circle" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
                <h6 class="card-title fw-normal mb-2">Selesai</h6>
                <h2 class="card-text">{{ $selesai }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-3">
                    <!-- Search -->
                    <div class="col-md-6">
                        <label for="search" class="form-label fw-bold">Cari Aspirasi</label>
                        <input type="text" class="form-control" id="search" name="search"
                               placeholder="Ketik kata kunci..." value="{{ request('search') }}">
                    </div>

                    <!-- Filter Prioritas -->
                    <div class="col-md-6">
                        <label for="prioritas" class="form-label fw-bold">Prioritas</label>
                        <select class="form-select" id="prioritas" name="prioritas">
                            <option value="">-- Semua Prioritas --</option>
                            <option value="Rendah" {{ request('prioritas') == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="Sedang" {{ request('prioritas') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="Tinggi" {{ request('prioritas') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                            <option value="Urgent" {{ request('prioritas') == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                    </div>

                    <!-- Filter Hari -->
                    <div class="col-md-3">
                        <label for="hari" class="form-label fw-bold">Hari</label>
                        <select class="form-select" id="hari" name="hari">
                            <option value="">-- Semua Hari --</option>
                            @for ($i = 1; $i <= 31; $i++)
                                <option value="{{ $i }}" {{ request('hari') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Filter Bulan -->
                    <div class="col-md-3">
                        <label for="bulan" class="form-label fw-bold">Bulan</label>
                        <select class="form-select" id="bulan" name="bulan">
                            <option value="">-- Semua Bulan --</option>
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
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary w-100">
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
                                    <th style="width: 100px;" class="text-center">Aksi</th>
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
                                            <a href="{{ route('admin.aspirasi.show', $aspirasi->id) }}" class="btn btn-sm btn-outline-primary"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
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
                        <p class="mt-3 mb-0">Belum ada aspirasi yang masuk</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
