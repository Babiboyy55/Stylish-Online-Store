<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Stylish Online Store</title>
    <link rel="stylesheet" href="{{ asset('user/css/auth/login.css') }}">
</head>

<body>
    <div class="auth-wrapper">
        <!-- Background Pattern -->
        <div class="bg-pattern"></div>

        <!-- Main Container -->
        <div class="auth-container">
            <!-- Left Side - Branding -->
            <div class="auth-branding">
                <div class="brand-content">
                    <div class="brand-logo">
                        <img src="{{ asset('user/images/main-logo.png') }}" alt="Tên thương hiệu" />
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <p class="brand-subtitle">Nền tảng mua sắm hàng đầu</p>
                    <div class="brand-features">
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Đăng ký dễ dàng</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Mua sắm hiệu quả</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Bảo mật tuyệt đối</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="auth-form-container">
                <div class="form-header">
                    <h2>Chào mừng trở lại!</h2>
                    <p>Đăng nhập để tiếp tục hành trình của bạn</p>
                </div>

                <form method="POST" action="/login" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="login" class="form-label">Email/Tên đăng nhập</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" id="login" name="login"
                                class="form-input @error('login') error @enderror" placeholder="Nhập email hoặc username của bạn"
                                required autocomplete="username">
                        </div>
                        @error('login')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password"
                                class="form-input @error('password') error @enderror" placeholder="Nhập mật khẩu"
                                required autocomplete="current-password">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-options">
                        <label class="checkbox-wrapper">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember', true) ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            <span class="checkbox-label">Ghi nhớ đăng nhập</span>
                        </label>
                    </div>

                    <button type="submit" class="submit-btn">
                        <span>Đăng nhập</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <div class="divider">
                        <div class="divider-line"></div>
                        <div class="divider-line"></div>
                    </div>


                    <div class="auth-switch">
                        <p>Chưa có tài khoản? <a href="/register" class="switch-link">Đăng ký ngay</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const toggle = input.nextElementSibling;
            const icon = toggle.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>

</html>
