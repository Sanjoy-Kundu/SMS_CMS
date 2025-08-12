<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>College Management System - Reset Password</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .reset-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px 35px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 400px;
            width: 100%;
        }

        .reset-card h2 {
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
        }

        .form-label {
            font-weight: 600;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>

<div class="reset-card">
    <h2>Reset Password</h2>
    <form id="resetPasswordForm" novalidate>
        <input type="hidden" id="email" name="email" />

        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input 
                type="password" 
                class="form-control" 
                id="password" 
                name="password" 
                placeholder="Enter new password" 
                required 
                minlength="8" 
                autocomplete="new-password" 
            />
            <div class="invalid-feedback">
                Please enter a password of at least 8 characters.
            </div>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <input 
                type="password" 
                class="form-control" 
                id="password_confirmation" 
                name="password_confirmation" 
                placeholder="Confirm new password" 
                required 
                minlength="8" 
                autocomplete="new-password" 
            />
            <div class="invalid-feedback">
                Password confirmation must match the new password.
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
    </form>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    const email = localStorage.getItem('verify_otp_email');
    const token = localStorage.getItem('token');

    if (!email || !token) {
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: 'Session expired or invalid. Please try forgot password again.',
        }).then(() => {
            window.location.href = '/forgot-password';
        });
        return;
    }

    $('#email').val(email);

    $('#resetPasswordForm').on('submit', function(e) {
        e.preventDefault();

        const password = $('#password').val().trim();
        const password_confirmation = $('#password_confirmation').val().trim();

        // Validation checks
        if (!password) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Password is required.',
            });
            return;
        }

        if (password.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Password must be at least 8 characters long.',
            });
            return;
        }

        if (!password_confirmation) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Password confirmation is required.',
            });
            return;
        }

        if (password !== password_confirmation) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Passwords do not match.',
            });
            return;
        }

        // If all validations pass, send request
        const data = {
            email: email,
            password: password,
            password_confirmation: password_confirmation
        };

        axios.post('/forgot-password/reset-password', data, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            }
        })
        .then(response => {
            if(response.data.status === 'success'){
                // Clear localStorage and redirect
                localStorage.removeItem('token');
                localStorage.removeItem('verify_otp_email');

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.data.message || 'Password reset successfully.',
                    confirmButtonText: 'Go to Login'
                }).then(() => {
                    window.location.href = '/admin/login';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: response.data.message || 'Something went wrong.',
                });
            }
        })
        .catch(error => {
            let msg = 'Something went wrong.';
            if(error.response && error.response.data){
                msg = error.response.data.message || JSON.stringify(error.response.data.errors) || msg;
            }
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: msg,
            });
        });
    });
});
</script>


</body>
</html>
