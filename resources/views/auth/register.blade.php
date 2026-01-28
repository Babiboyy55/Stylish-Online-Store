<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Stylish Online Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('user/css/auth/register.css') }}">

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
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h1 class="brand-title">Stylish Online Store</h1>
                    <div class="brand-features">
                        <div class="feature-item">
                        </div>
                        <div class="feature-item">
                        </div>
                        <div class="feature-item">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Register Form -->
            <div class="auth-form-container">
                <div class="form-header">
                    <h2>Tạo tài khoản mới</h2>
                </div>

                <form method="POST" action="/register" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">Họ và tên</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" id="name" name="name" class="form-input @error('name') error @enderror"
                                placeholder="Nhập họ và tên của bạn" value="{{ old('name') }}" required
                                autocomplete="name">
                        </div>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email"
                                class="form-input @error('email') error @enderror" placeholder="Nhập email của bạn"
                                required autocomplete="email">
                        </div>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Tên đăng nhập</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="text" id="username" name="username"
                                class="form-input @error('username') error @enderror" placeholder="Nhập tên đăng nhập của bạn"
                                value="{{ old('username') }}" required autocomplete="username">
                        </div>
                        @error('username')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password"
                                class="form-input @error('password') error @enderror" placeholder="Tạo mật khẩu"
                                required autocomplete="new-password">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-input" placeholder="Nhập lại mật khẩu" required autocomplete="new-password">
                            <button type="button" class="password-toggle"
                                onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        @error('role')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="terms-checkbox">
                        <label class="checkbox-wrapper">
                            <input type="checkbox" name="terms" id="terms" required>
                            <span class="checkmark"></span>
                            <span class="checkbox-label">
                                Tôi đồng ý với <a href="#" class="terms-link">Điều khoản sử dụng</a> và <a href="#"
                                    class="terms-link">Chính sách bảo mật</a>
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="submit-btn">
                        <span>Tạo tài khoản</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    </div>
                    <div class="auth-switch">
                        <p>Đã có tài khoản? <a href="/login" class="switch-link">Đăng nhập</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
</body>

</html>