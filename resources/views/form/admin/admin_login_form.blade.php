<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>College Management System - Admin Login</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />

    <style>
        body {
            background: url('/logo/login_backaground.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }
        .login-card {
            width: 100%;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.95);
            padding: 35px 30px;
            border-radius: 12px;
            box-shadow: 0 12px 28px rgba(0,0,0,0.15);
        }
        .login-logo {
            display: block;
            margin: 0 auto 15px auto;
            width: 80px;
        }
        .login-header {
            font-weight: 700;
            font-size: 1.5rem;
            color: #0d6efd;
            margin-bottom: 20px;
            text-align: center;
        }
        .forgot-link {
            font-size: 0.9rem;
            color: #0d6efd;
            text-decoration: none;
        }
        .forgot-link:hover {
            text-decoration: underline;
        }
        #togglePassword {
            cursor: pointer;
            user-select: none;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

<div class="login-card">
    <img src="/logo/logo.png" alt="Logo" class="login-logo">
    <h2 class="login-header">Admin Login</h2>

    <form id="loginForm" autocomplete="off" novalidate>
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required autofocus />
            <div class="invalid-feedback">Please enter a valid email address</div>
        </div>

        <div class="mb-3 position-relative">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control pe-5" id="password" name="password" placeholder="Enter your password" required minlength="8" />
            <span id="togglePassword" class="position-absolute top-50 end-0 translate-middle-y me-3" title="Show/Hide password">👁️</span>
            <div class="invalid-feedback">Password must be at least 8 characters</div>
        </div>

        <div class="mb-3 text-end">
            <a href="#" class="forgot-link">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    // Toggle password visibility
    togglePassword.addEventListener('click', () => {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePassword.textContent = '🙈';
        } else {
            passwordInput.type = 'password';
            togglePassword.textContent = '👁️';
        }
    });

    // Form submit
    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!loginForm.checkValidity()) {
            e.stopPropagation();
            loginForm.classList.add('was-validated');
            return;
        }

        const data = {
            email: loginForm.email.value.trim(),
            password: passwordInput.value,
            role: 'admin'
        };

        try {
            Swal.fire({
                title: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            let response = await axios.post('/admin/login/store', data);

            if (response.data.status === 'success') {
                localStorage.setItem('token', response.data.token);
                Swal.fire({
                    icon: 'success',
                    title: 'Login Successful',
                    text: response.data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '/admin/dashboard';
                });
            }
        } catch (error) {
            localStorage.removeItem('admin_token');
            if(error.response.data.status === 'error'){
                Swal.fire({
                icon: 'error',
                text: error.response.data.message
            });
            }else{
                console.log(error);
            }
          
        }
    });
});
</script>

</body>
</html>
