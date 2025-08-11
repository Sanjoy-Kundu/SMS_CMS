<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>College Management System - Reset Password</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            /* ব্যাকগ্রাউন্ড ইমেজ, কলেজ থিম মতো */
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
    <form id="resetPasswordForm" novalidate autocomplete="off" method="POST" action="/forgot-password/reset-password">
        <!-- CSRF Token -->
        <!-- যদি Laravel Blade হয়: @csrf -->
        <input type="hidden" name="email" value="{{ $email ?? '' }}">

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
            >
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
            >
            <div class="invalid-feedback">
                Password confirmation must match the new password.
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
    </form>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Simple client-side validation for password confirmation
    (function() {
        'use strict';
        const form = document.getElementById('resetPasswordForm');

        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                const password = form.password.value;
                const confirm = form.password_confirmation.value;
                if (password !== confirm) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.password_confirmation.classList.add('is-invalid');
                    form.password_confirmation.nextElementSibling.textContent = 'Password confirmation does not match.';
                } else {
                    form.password_confirmation.classList.remove('is-invalid');
                }
            }
            form.classList.add('was-validated');
        });
    })();
</script>

</body>
</html>
