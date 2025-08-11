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
    .card-custom {
        width: 100%;
        max-width: 420px;
        background: rgba(255, 255, 255, 0.95);
        padding: 35px 30px;
        border-radius: 12px;
        box-shadow: 0 12px 28px rgba(0,0,0,0.15);
        margin-bottom: 30px;
    }
    .logo {
        display: block;
        margin: 0 auto 15px auto;
        width: 80px;
    }
    .header-primary {
        font-weight: 700;
        font-size: 1.7rem;
        color: #0d6efd;
        margin-bottom: 20px;
        text-align: center;
    }
    #togglePassword {
        cursor: pointer;
        user-select: none;
        font-size: 1.2rem;
    }
    .form-footer-link {
        font-size: 0.9rem;
        color: #0d6efd;
        cursor: pointer;
        text-decoration: underline;
    }
    .form-footer-link:hover {
        color: #084298;
    }
</style>

</head>
<body>

<!-- LOGIN FORM -->
<div class="card-custom" id="loginCard">
    <img src="/logo/logo.png" alt="Logo" class="logo" />
    <h2 class="header-primary">Admin Login</h2>

    <form id="loginForm" autocomplete="off" novalidate>
        <div class="mb-3">
            <label for="loginEmail" class="form-label fw-semibold">Email Address</label>
            <input type="email" class="form-control" id="loginEmail" name="email" placeholder="Enter your email" required autofocus />
            <div class="invalid-feedback">Please enter a valid email address</div>
        </div>

        <div class="mb-3 position-relative">
            <label for="loginPassword" class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control pe-5" id="loginPassword" name="password" placeholder="Enter your password" required minlength="8" />
            <span id="togglePassword" class="position-absolute top-50 end-0 translate-middle-y me-3" title="Show/Hide password">👁️</span>
            <div class="invalid-feedback">Password must be at least 8 characters</div>
        </div>

        <div class="mb-3 text-end">
            <a class="form-footer-link" href="{{url('/forgot-password')}}">Forgot Password</a>
         
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
    // Password toggle in Login form
    const togglePassword = document.getElementById('togglePassword');
    const loginPasswordInput = document.getElementById('loginPassword');
    togglePassword.addEventListener('click', () => {
        if (loginPasswordInput.type === 'password') {
            loginPasswordInput.type = 'text';
            togglePassword.textContent = '🙈';
        } else {
            loginPasswordInput.type = 'password';
            togglePassword.textContent = '👁️';
        }
    });


    // LOGIN FORM submit
    const loginForm = document.getElementById('loginForm');
    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!loginForm.checkValidity()) {
            e.stopPropagation();
            loginForm.classList.add('was-validated');
            return;
        }

        const data = {
            email: loginForm.email.value.trim(),
            password: loginPasswordInput.value,
            role: 'admin'
        };

        try {
            Swal.fire({
                title: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            const response = await axios.post('/admin/login/store', data);

            Swal.close();

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
            } else {
                Swal.fire('Error', response.data.message || 'Login failed!', 'error');
            }
        } catch (error) {
            Swal.close();
            localStorage.removeItem('token');
            if(error.response && error.response.data.status === 'error'){
                Swal.fire({
                    icon: 'error',
                    text: error.response.data.message
                });
            } else {
                Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                console.error(error);
            }
        }
    });

    // FORGOT PASSWORD FORM submit
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    forgotPasswordForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!forgotPasswordForm.checkValidity()) {
            e.stopPropagation();
            forgotPasswordForm.classList.add('was-validated');
            return;
        }

        const email = forgotPasswordForm.email.value.trim();

        try {
            Swal.fire({
                title: 'Sending OTP...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            const response = await axios.post('/password/otp/send', { email });

            Swal.close();

            if (response.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'OTP Sent',
                    text: 'Please check your email for the OTP to reset your password.',
                    confirmButtonText: 'OK'
                });
                forgotPasswordForm.reset();
                forgotPasswordForm.classList.remove('was-validated');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: response.data.message || 'Failed to send OTP. Try again later.',
                });
            }
        } catch (error) {
            Swal.close();
            if (error.response && error.response.status === 422) {
                let errors = error.response.data.errors;
                let messages = Object.values(errors).flat().join('<br>');
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: messages
                });
            } else if(error.response && error.response.data.message) {
                Swal.fire('Error', error.response.data.message, 'error');
            } else {
                Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
            }
            console.error(error);
        }
    });
});
</script>

</body>
</html>
