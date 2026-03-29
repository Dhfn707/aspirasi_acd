@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<div class="container">
    <div class="row min-vh-100 align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
            <h1 class="display-4 fw-bold mb-4">
                <i class="fas fa-lightbulb text-warning"></i>
                Sistem Aspirasi Karyawan
            </h1>
            <p class="lead mb-4">
                Platform terpadu untuk mengumpulkan, mengelola, dan merespons aspirasi dari seluruh karyawan organisasi Anda dengan efisien.
            </p>

            <div class="d-flex flex-column gap-2">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="{{ route('aspirasi.index') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-arrow-right"></i> Lihat Aspirasi
                </a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card h-100 text-center p-4">
                        <i class="fas fa-comment fa-3x text-primary mb-3"></i>
                        <h5>Kirim Aspirasi</h5>
                        <p class="text-muted small mb-0">Ekspresikan ide dan saran Anda untuk perkembangan organisasi</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 text-center p-4">
                        <i class="fas fa-chart-bar fa-3x text-success mb-3"></i>
                        <h5>Pantau Status</h5>
                        <p class="text-muted small mb-0">Lacak perkembangan aspirasi Anda secara real-time</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 text-center p-4">
                        <i class="fas fa-users fa-3x text-info mb-3"></i>
                        <h5>Kolaborasi</h5>
                        <p class="text-muted small mb-0">Berkontribusi dalam menciptakan lingkungan kerja yang lebih baik</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 text-center p-4">
                        <i class="fas fa-shield-alt fa-3x text-warning mb-3"></i>
                        <h5>Aman & Terpercaya</h5>
                        <p class="text-muted small mb-0">Data Anda dilindungi dengan sistem keamanan terkini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
