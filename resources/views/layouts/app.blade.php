<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Aspirasi') - Sistem Aspirasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <!-- Navbar Header -->
    <nav class="navbar navbar-expand-lg navbar-dark app-navbar">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="#">
                <div class="navbar-brand-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <span>Sistem Aspirasi</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(session('user_type'))
                        <li class="nav-item">
                            <span class="nav-link">{{ session('user_name') ?? 'User' }}</span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline" id="logoutForm">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link" style="color: white; text-decoration: none;" onclick="confirmLogout(event)">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="app-main-content">
        <div class="container-fluid px-4 py-4">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <strong>Sukses!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Error!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Modal Konfirmasi Reusable -->
    <div class="modal fade" id="confirmationModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationTitle">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="confirmationMessage">Apakah Anda yakin?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="confirmationCancelBtn" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmationConfirmBtn">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="app-footer">
        <div class="container-fluid px-4">
            <p class="mb-0">&copy; 2026 Sistem Aspirasi Karyawan. Design By Dhafin & Rizqi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/confirmation.js') }}"></script>
    @yield('scripts')
</body>
</html>
