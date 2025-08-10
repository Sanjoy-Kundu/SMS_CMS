<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>College Management System - Admin Login</title>
    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet" />

    <style>
        body {
            background: #e9f0f8; /* হালকা নীলা-সাদা ব্যাকগ্রাউন্ড */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }
        .login-card {
            max-width: 40%;
            width: 100%;
            background: #ffffff;
            padding: 35px 40px;
            border-radius: 12px;
            box-shadow: 0 12px 28px rgba(0,0,0,0.12);
            border-left: 5px solid #ebf0f8; /* Bootstrap primary blue */
        }
        .login-header {
            font-weight: 700;
            font-size: 1.8rem;
            color: #0d6efd;
            margin-bottom: 30px;
            text-align: center;
            letter-spacing: 1px;
            user-select: none;
        }
        .form-check-inline {
            user-select: none;
        }
        .show-password-checkbox {
            cursor: pointer;
            user-select: none;
            font-size: 0.9rem;
            color: #555;
        }
        .forgot-link {
            font-size: 0.9rem;
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }
        .forgot-link:hover {
            text-decoration: underline;
        }
        .btn-primary {
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="login-card shadow-sm">
    <h2 class="login-header">College Management System</h2>
    <form id="loginForm" autocomplete="off" novalidate>
        <div class="mb-4">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required autofocus />
            <div class="invalid-feedback">Please enter a valid email address</div>
        </div>

        <div class="mb-4 position-relative">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control pe-5" id="password" name="password" placeholder="Enter your password" required minlength="8" />
            <span id="togglePassword" class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor:pointer; user-select:none; font-size:1.2rem;" title="Show/Hide password">👁️</span>
            <div class="invalid-feedback">Password must be at least 8 characters</div>
        </div>

        <div class="mb-3">
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input" id="showPasswordCheckbox" />
                <label class="form-check-label show-password-checkbox" for="showPasswordCheckbox">Show Password</label>
            </div>
        </div>

        <div class="mb-4 text-end">
            <a href="#" class="forgot-link">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loginForm = document.getElementById('loginForm');
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');


        // Toggle password visibility via eye icon
        togglePassword.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePassword.textContent = '🙈';
                showPasswordCheckbox.checked = true;
            } else {
                passwordInput.type = 'password';
                togglePassword.textContent = '👁️';
                showPasswordCheckbox.checked = false;
            }
        });

        // Toggle password visibility via checkbox
        showPasswordCheckbox.addEventListener('change', () => {
            if (showPasswordCheckbox.checked) {
                passwordInput.type = 'text';
                togglePassword.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                togglePassword.textContent = '👁️';
            }
        });

        // Form validation and submission
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!loginForm.checkValidity()) {
                e.stopPropagation();
                loginForm.classList.add('was-validated');
                return;
            }

            const data = {
                email: loginForm.email.value.trim(),
                password: passwordInput.value,
                
            };
            console.log(data);

            // Swal.fire({
            //     title: 'Please wait...',
            //     allowOutsideClick: false,
            //     didOpen: () => Swal.showLoading()
            // });

            // let response = await axios.post('/admin/login/store', data);
            // if(response.data.status ==== 'success'){
            //     Swal.fire({
            //         icon: 'success',
            //         title: 'Success',
            //         text: response.data.message,
            //         timer: 2000,
            //         timerProgressBar: true,
            //         didOpen: () => {
            //             Swal.showLoading()
            //         }
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             window.location.href = '/admin/dashboard';
            //         }
            //     });
            // }
        
        });
    });
</script>

</body>
</html>
