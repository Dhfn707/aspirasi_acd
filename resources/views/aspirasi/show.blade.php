@extends('layouts.app')

@section('title', 'Detail Aspirasi')

@section('content')
<div class="container-fluid">
    <!-- Back Button -->
    <div class="mb-4 d-flex gap-2">
        <a href="{{ route('aspirasi.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('aspirasi.edit', $aspirasi->id) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('aspirasi.destroy', $aspirasi->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"
                    onclick="confirmDelete(event, '{{ $aspirasi->judul }}')">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </form>
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
                    <!-- Nama Pengirim & Email -->
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

                    <!-- Jabatan & Prioritas -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold">
                                <i class="fas fa-briefcase"></i> Jabatan
                            </label>
                            <p class="fs-5 fw-bold mb-0">{{ $aspirasi->user->jabatan->nama ?? 'N/A' }}</p>
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

                    <!-- Tanggal Dibuat & Tanggal Update -->
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

                    <!-- Tanggapan Admin -->
                    <div class="mb-4">
                        <label class="text-muted small fw-bold d-block mb-2">
                            <i class="fas fa-reply"></i> Tanggapan Admin
                        </label>
                        @if($aspirasi->tanggapan_admin)
                            <div class="bg-light p-3 rounded border">
                                <p class="mb-0 text-justify" style="line-height: 1.8;">
                                    {{ $aspirasi->tanggapan_admin }}
                                </p>
                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle"></i> Belum ada tanggapan dari admin
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="card-footer bg-white">
                    <div class="text-muted small">
                        <strong>Status:</strong>
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
                                'desc' => 'Aspirasi belum dibaca oleh admin'
                            ],
                            'Dibaca' => [
                                'icon' => 'fa-book',
                                'desc' => 'Aspirasi sudah dibaca oleh admin'
                            ],
                            'Ditanggapi' => [
                                'icon' => 'fa-spinner',
                                'desc' => 'Aspirasi sedang diproses'
                            ],
                            'Selesai' => [
                                'icon' => 'fa-check-circle',
                                'desc' => 'Aspirasi sudah selesai diproses'
                            ]
                        ];
                        $currentStatus = $statusInfo[$aspirasi->status] ?? $statusInfo['Belum Dibaca'];
                    @endphp

                    <div class="text-center">
                        <i class="fas {{ $currentStatus['icon'] }} text-info" style="font-size: 2rem;"></i>
                        <p class="text-muted small mt-2 mb-0">
                            {{ $currentStatus['desc'] }}
                        </p>
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
