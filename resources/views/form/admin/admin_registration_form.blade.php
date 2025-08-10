<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Admin Registration</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('/logo/admin_bg.jpg') no-repeat center center/cover;
        }
        .register-wrapper {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 500px;
        }
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .register-header img {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }
        .register-header h4 {
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="register-wrapper">
    <div class="register-header">
        <img src="/logo/logo.png" alt="College Logo">
        <h4>College Admin Registration</h4>
        <p class="text-muted">Fill out the form below to create an admin account</p>
    </div>

    <form id="adminRegisterForm">
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter full name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" minlength="8" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm password" minlength="8" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">Register</button>
        </div>
    </form>
</div>

<script>
document.getElementById('adminRegisterForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    let formData = {
        name: document.getElementById('name').value.trim(),
        email: document.getElementById('email').value.trim(),
        password: document.getElementById('password').value.trim(),
        password_confirmation: document.getElementById('password_confirmation').value.trim(),
        role: 'admin'
    };

    try {
        let res = await axios.post('/admin/registration/store', formData);

        if (res.data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Registration Successful',
                text: res.data.message,
                confirmButtonColor: '#0d6efd'
            });
            document.getElementById('adminRegisterForm').reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: res.data.message || 'Something went wrong!',
                confirmButtonColor: '#dc3545'
            });
        }

    } catch (err) {
        if (err.response && err.response.status === 422) {
            let errors = err.response.data.errors;
            let errorMessages = Object.values(errors).flat().join('\n');
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: errorMessages,
                confirmButtonColor: '#ffc107'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: err.message,
                confirmButtonColor: '#dc3545'
            });
        }
    }
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
