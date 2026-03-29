@extends('layouts.app')

@section('title', 'Show Aspirasi - Admin')

@section('content')
<div class="container-fluid">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Detail Card -->
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-lightbulb text-warning"></i> Detail Aspirasi
                    </h4>
                    <span class="badge bg-primary">ID: {{ $aspirasi->id }}</span>
                </div>

                <div class="card-body">
                    <!-- Nama Pengirim & Email (Read Only) -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold">
                                <i class="fas fa-user"></i> Nama Pengirim
                            </label>
                            <p class="fs-5 fw-bold mb-0">{{ $aspirasi->user->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <p class="fs-5 fw-bold mb-0">{{ $aspirasi->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Jabatan & Prioritas (Read Only) -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold">
                                <i class="fas fa-briefcase"></i> Jabatan
                            </label>
                            <p class="fs-5 fw-bold mb-0">{{ $aspirasi->jabatan->nama ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold">
                                <i class="fas fa-flag"></i> Prioritas
                            </label>
                            <div>
                                @php
                                    $badgeClass = [
                                        'Rendah' => 'success',
                                        'Sedang' => 'warning',
                                        'Tinggi' => 'danger',
                                        'Urgent' => 'danger'
                                    ][$aspirasi->prioritas] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $badgeClass }} fs-6">
                                    {{ $aspirasi->prioritas }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Dibuat & Tanggal Update (Read Only) -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold">
                                <i class="fas fa-calendar"></i> Tanggal Dibuat
                            </label>
                            <p class="fs-5 fw-bold mb-0">{{ $aspirasi->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold">
                                <i class="fas fa-sync"></i> Terakhir Diupdate
                            </label>
                            <p class="fs-5 fw-bold mb-0">{{ $aspirasi->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Isi Aspirasi -->
                    <div class="mb-4">
                        <label class="text-muted small fw-bold d-block mb-2">
                            <i class="fas fa-comment"></i> Isi Aspirasi
                        </label>
                        <div class="bg-light p-3 rounded border">
                            <p class="mb-0 text-justify" style="line-height: 1.8;">
                                {{ $aspirasi->aspirasi }}
                            </p>
                        </div>
                    </div>

                    <hr>

                    <!-- Tanggapan Admin Form -->
                    <div class="mb-4">
                        <form action="{{ route('admin.aspirasi.update', $aspirasi->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <label for="tanggapan_admin" class="text-muted small fw-bold d-block mb-2">
                                <i class="fas fa-reply"></i> Tanggapan Admin
                            </label>
                            <textarea class="form-control @error('tanggapan_admin') is-invalid @enderror"
                                      id="tanggapan_admin"
                                      name="tanggapan_admin"
                                      rows="5"
                                      placeholder="Berikan tanggapan untuk aspirasi ini..."
                                      maxlength="2000">{{ old('tanggapan_admin', $aspirasi->tanggapan_admin) }}</textarea>
                            <small class="text-muted d-block mt-2">Maksimal 2000 karakter</small>
                            @error('tanggapan_admin')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            <div class="mt-3">
                                <label for="status" class="text-muted small fw-bold d-block mb-2">
                                    <i class="fas fa-cog"></i> Status Aspirasi
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="Ditanggapi" {{ $aspirasi->status === 'Ditanggapi' ? 'selected' : '' }}>Ditanggapi</option>
                                    <option value="Selesai" {{ $aspirasi->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle"></i> Status akan otomatis menjadi "Ditanggapi" jika ada tanggapan. Pilih "Selesai" jika aspirasi sudah final.
                                </small>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan Tanggapan
                                </button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="card-footer bg-white">
                    <div class="text-muted small">
                        <strong>Status Saat Ini:</strong>
                        @php
                            $statusClass = [
                                'Belum Dibaca' => 'primary',
                                'Dibaca' => 'info',
                                'Ditanggapi' => 'warning',
                                'Selesai' => 'success'
                            ][$aspirasi->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $statusClass }}">{{ $aspirasi->status ?? 'Belum Dibaca' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar - Status Info -->
        <div class="col-md-4">
            <div class="card shadow-sm border-info mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> Informasi Status
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $statusInfo = [
                            'Belum Dibaca' => [
                                'icon' => 'fa-envelope',
                                'desc' => 'Aspirasi belum dibaca'
                            ],
                            'Dibaca' => [
                                'icon' => 'fa-book',
                                'desc' => 'Aspirasi sudah dibaca'
                            ],
                            'Ditanggapi' => [
                                'icon' => 'fa-spinner',
                                'desc' => 'Aspirasi sedang ditanggapi'
                            ],
                            'Selesai' => [
                                'icon' => 'fa-check-circle',
                                'desc' => 'Aspirasi sudah selesai ditanggapi'
                            ]
                        ];
                        $currentStatus = $statusInfo[$aspirasi->status] ?? $statusInfo['Belum Dibaca'];
                    @endphp

                    <div class="text-center">
                        <i class="fas {{ $currentStatus['icon'] }} text-info" style="font-size: 2rem;"></i>
                        <p class="text-muted small mt-2 mb-3">
                            {{ $currentStatus['desc'] }}
                        </p>
                    </div>

                    <div class="alert alert-warning mb-3">
                        <small class="text-muted">
                            <strong>⚠️ Flow Status:</strong>
                            <ul class="mb-0 mt-2" style="margin-left: 1rem;">
                                <li>Beri tanggapan → Status otomatis "Ditanggapi"</li>
                                <li>Bisa revisi → Ubah status kembali ke "Ditanggapi"</li>
                                <li>Selesai → Ubah status ke "Selesai" (tidak bisa diakses karyawan)</li>
                            </ul>
                        </small>
                    </div>

                    <div class="alert alert-light border-bottom">
                        <small class="text-muted">
                            <strong>Catatan:</strong> Aspirasi dengan status "Selesai" tidak akan bisa dilihat karyawan.
                        </small>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-timeline"></i> Timeline
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item mb-3">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <small class="text-muted">Diajukan</small>
                                <p class="mb-0 small">{{ $aspirasi->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        @if($aspirasi->tanggapan_admin)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <small class="text-muted">Ditanggapi</small>
                                    <p class="mb-0 small">{{ $aspirasi->updated_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 1.5rem;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 1rem;
    }

    .timeline-marker {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        position: absolute;
        left: 0;
        top: 0.25rem;
    }

    .timeline-content {
        margin-left: 1.5rem;
    }
</style>

@endsection
