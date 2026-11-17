<x-guest-layout>
    <div class="mb-4">
        <h3 class="fw-bold" style="color: #142D4E;">Hospital ERP Sign In</h3>
        <p class="text-muted small">Enter your authorized medical or administrative credentials to access your portal.</p>
    </div>

    <!-- Session Status -->
    @if(session('status'))
        <div class="alert alert-success mb-4 rounded-3 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold text-sm">Email Address</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@example.com">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label for="password" class="form-label fw-semibold text-sm mb-0">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-decoration-none text-sm fw-medium" href="{{ route('password.request') }}" style="color: #0D9488;">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" class="form-control mt-2 @error('password') is-invalid @enderror" required autocomplete="current-password" placeholder="••••••••">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label text-sm text-muted">
                    Remember me
                </label>
            </div>
        </div>

        <div>
            <button type="submit" id="submitLoginBtn" class="btn btn-auth w-100 fw-bold py-2.5">
                <i class="fa-solid fa-right-to-bracket me-2"></i> Log In to Portal
            </button>
        </div>
    </form>

    <!-- 1-Click Quick Demo Login Section -->
    <div class="mt-4 pt-3 border-top">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-uppercase small fw-bold text-muted" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                <i class="fa-solid fa-bolt text-warning me-1"></i> 1-Click Demo Login
            </span>
            <span class="badge bg-light text-secondary border small" style="font-size: 0.68rem;">Auto Login</span>
        </div>

        <div class="d-grid gap-2">
            <!-- Super Admin Demo Button -->
            <button type="button" onclick="quickDemoLogin('admin@example.com', 'password', this)" class="btn btn-outline-light text-start d-flex justify-content-between align-items-center p-2.5 rounded-3 border demo-login-btn" style="background: #f8fafc; border-color: #e2e8f0 !important; transition: all 0.2s;">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 34px; height: 34px; background: rgba(20, 45, 78, 0.1); color: #142D4E;">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 0.88rem; line-height: 1.2;">Super Admin</div>
                        <small class="text-muted" style="font-size: 0.72rem;">admin@example.com &bull; Executive Portal</small>
                    </div>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary small px-2 py-1">Instant Login &rarr;</span>
            </button>

            <!-- Doctor Demo Button -->
            <button type="button" onclick="quickDemoLogin('admin@dc.com', 'password', this)" class="btn btn-outline-light text-start d-flex justify-content-between align-items-center p-2.5 rounded-3 border demo-login-btn" style="background: #f8fafc; border-color: #e2e8f0 !important; transition: all 0.2s;">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 34px; height: 34px; background: rgba(13, 148, 136, 0.12); color: #0D9488;">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 0.88rem; line-height: 1.2;">Specialist Doctor</div>
                        <small class="text-muted" style="font-size: 0.72rem;">admin@dc.com &bull; Clinical Chamber</small>
                    </div>
                </div>
                <span class="badge bg-success bg-opacity-10 small px-2 py-1" style="color: #0D9488 !important;">Instant Login &rarr;</span>
            </button>

            <!-- Receptionist Demo Button -->
            <button type="button" onclick="quickDemoLogin('admin@10.com', 'password', this)" class="btn btn-outline-light text-start d-flex justify-content-between align-items-center p-2.5 rounded-3 border demo-login-btn" style="background: #f8fafc; border-color: #e2e8f0 !important; transition: all 0.2s;">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 34px; height: 34px; background: rgba(245, 158, 11, 0.12); color: #d97706;">
                        <i class="fa-solid fa-hospital-user"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 0.88rem; line-height: 1.2;">Receptionist / Desk</div>
                        <small class="text-muted" style="font-size: 0.72rem;">admin@10.com &bull; Patient Registration & OPD</small>
                    </div>
                </div>
                <span class="badge bg-warning bg-opacity-15 small px-2 py-1 text-dark">Instant Login &rarr;</span>
            </button>
        </div>
    </div>

    <!-- Quick Demo Auto-login Script -->
    <script>
        function quickDemoLogin(email, password, btnElement) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitLoginBtn');

            if (emailInput && passwordInput && loginForm) {
                // Populate inputs
                emailInput.value = email;
                passwordInput.value = password;

                // Visual button loading state
                if (btnElement) {
                    btnElement.style.opacity = '0.7';
                    btnElement.innerHTML = '<div class="d-flex align-items-center gap-2 text-dark"><span class="spinner-border spinner-border-sm text-primary"></span> <span>Logging in as ' + email + '...</span></div>';
                }

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Authenticating...';
                }

                // Submit automatically
                setTimeout(function() {
                    loginForm.submit();
                }, 150);
            }
        }
    </script>
</x-guest-layout>
