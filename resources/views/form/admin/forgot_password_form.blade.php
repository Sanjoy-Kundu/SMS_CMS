<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Forgot Password with Loader</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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
    .forgot-card {
        background: rgba(255, 255, 255, 0.95);
        padding: 30px 35px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        max-width: 400px;
        width: 100%;
    }
    .forgot-card h2 {
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
    /* spinner style */
    .spinner-border {
        width: 1rem;
        height: 1rem;
        border-width: 0.15em;
        vertical-align: middle;
        margin-right: 5px;
        display: none; /* শুরুতে লুকানো থাকবে */
    }
</style>
</head>
<body>

<div class="forgot-card">
    <h2>Forgot Password</h2>
    <p class="text-center text-muted mb-4">Enter your registered email to receive password reset instructions.</p>

    <form id="forgotPasswordForm" novalidate autocomplete="off" method="POST" action="/forgot-password/send-otp">
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                placeholder="Enter your email"
                required
                autocomplete="email"
            >
            <div class="invalid-feedback">
                Please enter a valid email address.
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100" onclick="sendOtp(event)">
            <span id="spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span id="btn-text">Send OTP</span>
        </button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
async function sendOtp(event) {
    event.preventDefault();

    const form = document.getElementById('forgotPasswordForm');
    const emailInput = document.getElementById('email');
    const spinner = document.getElementById('spinner');
    const btnText = document.getElementById('btn-text');
    const submitBtn = event.currentTarget;

    form.classList.remove('was-validated');

    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    // লোডার চালু করো, বাটন disable করো
    spinner.style.display = 'inline-block';
    btnText.textContent = 'Sending...';
    submitBtn.disabled = true;

    const data = { email: emailInput.value };

    try {
        let res = await axios.post('/forgot-password/send-otp', data);

        if (res.data.status === 'success') {
            localStorage.setItem('token', res.data.token);
            localStorage.setItem('verify_otp_email', res.data.email);
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: res.data.message,
                timer: 2000,
                showConfirmButton: false
            });
            window.location.href = '/verify-otp';
            
            form.classList.remove('was-validated');
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: res.data.message || 'Failed to send OTP.'
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.response.data.message ? error.response.data.message : 'Something went wrong.'
        });
        //console.error(error);
    } finally {
        // লোডার বন্ধ করো, বাটন enable করো
        spinner.style.display = 'none';
        btnText.textContent = 'Send OTP';
        submitBtn.disabled = false;
    }
}
</script>

</body>
</html>
