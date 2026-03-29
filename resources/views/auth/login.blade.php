@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
   <div class="login-container">
        <div class="login-wrapper">
            <div class="login-card">
                <!-- Header Card -->
                <div class="login-header">
                    <h3 class="login-title">Masuk</h3>
                    <p class="login-subtitle">Admin & Karyawan</p>
                </div>

                <!-- Body Card -->
                <div class="login-body-content">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i>
                            <strong>Login Gagal!</strong>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <!-- Email Input -->
                        <div class="mb-4">
                            <label for="email" class="form-label login-label">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input
                                type="email"
                                class="form-control login-input @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@example.com"
                                required
                                autofocus
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="mb-4">
                            <label for="password" class="form-label login-label">
                                <i class="fas fa-lock"></i> Password
                            </label>
                            <div class="password-input-group">
                                <input
                                    type="password"
                                    class="form-control login-input @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    placeholder="Masukkan password"
                                    required
                                >
                                <button type="button" class="btn-toggle-password" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <a href="https://gagalabsen.acdikari.net/" style="border-line:none">Lupa password?</a>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-login-submit w-100">
                            <i class="fas fa-sign-in-alt"></i> Masuk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function(e) {
            e.preventDefault();
            const passwordInput = document.getElementById('password');
            const toggleBtn = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.classList.remove('fa-eye');
                toggleBtn.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleBtn.classList.remove('fa-eye-slash');
                toggleBtn.classList.add('fa-eye');
            }
        });
    </script>
@endsection
