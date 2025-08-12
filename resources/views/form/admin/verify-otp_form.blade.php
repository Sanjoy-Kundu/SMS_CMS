<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verify OTP - College Management System</title>

    <!-- CSRF Token (Laravel) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .otp-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px 35px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .otp-card h2 {
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .otp-inputs {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 25px;
        }

        .otp-inputs input {
            width: 50px;
            height: 55px;
            font-size: 1.8rem;
            text-align: center;
            border: 1.5px solid #ced4da;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .otp-inputs input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 5px #0d6efd;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
            font-weight: 600;
            padding: 12px 0;
            font-size: 1.1rem;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .resend-text {
            margin-top: 15px;
            font-size: 0.9rem;
            color: #6c757d;
            cursor: pointer;
            user-select: none;
        }

        .resend-text:hover {
            text-decoration: underline;
            color: #0d6efd;
        }

        .resend-text.disabled {
            pointer-events: none;
            color: #adb5bd;
            text-decoration: none;
            cursor: default;
        }
    </style>
</head>

<body>

    <div class="otp-card" data-email="">
        <h2>Verify OTP</h2>
        <p class="text-muted mb-4">Enter the 6-digit OTP sent to your email.</p>
        <div class="otp-image d-flex align-items-center mb-4 gap-3">
            <img src="/uploads/admin/profile/default.png" alt="OTP Image" id="user_profile_image_otp"
                style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">

            <div class="user-name" style="font-weight: 600; font-size: 1.25rem; color: #333;">
                <div class="user-info-row d-flex justify-content-start mb-2">
                    <div style="min-width: 80px; font-weight: 700;">Name:</div>
                    <div><span id="user_name__otp"></span></div>
                </div>
                <div class="user-info-row d-flex justify-content-start mb-2">
                    <div style="min-width: 80px; font-weight: 700;">Email:</div>
                    <div><span id="user_email__otp"></span></div>
                </div>
                <div class="user-info-row d-flex justify-content-start">
                    <div style="min-width: 80px; font-weight: 700;">Role:</div>
                    <div><span id="user_role__otp"></span></div>
                </div>
            </div>
        </div>

        <form id="otpForm" novalidate autocomplete="off">

            <div class="otp-inputs">
                <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" name="otp[]" required>
                <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" name="otp[]" required>
                <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" name="otp[]" required>
                <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" name="otp[]" required>
                <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" name="otp[]" required>
                <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" name="otp[]" required>
            </div>

            <button id="verifyBtn" type="submit" class="btn btn-primary w-100">
                <span id="verifyBtnText">Verify OTP</span>
                <span id="verifyBtnLoader" class="spinner-border spinner-border-sm ms-2" role="status"
                    aria-hidden="true" style="display:none;"></span>
            </button>
        </form>

        <div class="mt-3">
            Didn't receive OTP? <span id="resendOtpBtn" class="resend-link"
                style="color:#0d6efd; cursor:pointer;">Resend</span>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        getUserInfo();

        async function getUserInfo() {
            let token = localStorage.getItem('token');
            let email = localStorage.getItem('verify_otp_email');
            if (!token || !email) {
                window.location.href = "/forgot-password";
                return;
            }

            try {
                let res = await axios.post('/otp-details-users', {
                    email: email
                }, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                if (res.data.status === 'success') {
                    document.querySelector('#user_name__otp').innerText = res.data.user.name ? res.data.user.name :
                        "N/A";
                    document.querySelector('#user_email__otp').innerText = res.data.user.email ? res.data.user.email :
                        "N/A";
                    document.querySelector('#user_role__otp').innerText = res.data.user.role ? res.data.user.role :
                        "N/A";
                    if (res.data.user.admin && res.data.user.admin.image) {
                        document.querySelector('#user_profile_image_otp').src = res.data.user.admin.image;
                    } else {
                        document.querySelector('#user_profile_image_otp').src = '/uploads/admin/profile/default.png';
                    }
                }
            } catch (error) {
                console.error(error);
            }
        }

        // Verify OTP Function with loader and button disable
        async function verifyOtp(event) {
            event.preventDefault();

            let token = localStorage.getItem('token');
            let email = localStorage.getItem('verify_otp_email');

            if (!token || !email) {
                window.location.href = "/forgot-password";
                return;
            }

            const otpInputs = document.querySelectorAll('input[name="otp[]"]');
            let otp = '';
            otpInputs.forEach(input => {
                otp += input.value.trim();
            });

            if (otp.length !== 6) {
                Swal.fire('Error', 'Please enter the complete 6-digit OTP.', 'error');
                return;
            }

            const verifyBtn = document.getElementById('verifyBtn');
            const verifyBtnText = document.getElementById('verifyBtnText');
            const verifyBtnLoader = document.getElementById('verifyBtnLoader');

            // Show loader and disable button
            verifyBtn.disabled = true;
            verifyBtnText.style.display = 'none';
            verifyBtnLoader.style.display = 'inline-block';

            try {
                let res = await axios.post('/forgot-password/verify-otp', {
                    email,
                    otp
                }, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (res.data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'OTP Verified',
                        text: 'You can now reset your password.',
                        confirmButtonText: 'Continue'
                    }).then(() => {
                        window.location.href = '/reset-password';
                    });
                } else {
                    Swal.fire('Error', res.data.message || 'Invalid OTP.', 'error');
                }
            } catch (error) {
                let message = 'Failed to verify OTP. Try again.';
                if (error.response && error.response.status === 422) {
                    message = error.response.data.message || 'Invalid or expired OTP.';
                }
                Swal.fire('Error', message, 'error');
                console.error(error);
            } finally {
                // Hide loader and enable button again
                verifyBtn.disabled = false;
                verifyBtnText.style.display = 'inline';
                verifyBtnLoader.style.display = 'none';
            }
        }

        document.getElementById('otpForm').addEventListener('submit', verifyOtp);

        $(document).ready(function() {
            const resendOtpBtn = $('#resendOtpBtn');
            let token = localStorage.getItem('token');
            let email = localStorage.getItem('verify_otp_email');
            let countdownInterval;

            function startResendCountdown(seconds = 60) {
                resendOtpBtn.addClass('disabled').css('pointer-events', 'none');
                let timeLeft = seconds;

                resendOtpBtn.text(`Resend available in ${timeLeft} sec`);

                countdownInterval = setInterval(() => {
                    timeLeft--;
                    if (timeLeft > 0) {
                        resendOtpBtn.text(`Resend available in ${timeLeft} sec`);
                    } else {
                        clearInterval(countdownInterval);
                        resendOtpBtn.text('Resend');
                        resendOtpBtn.removeClass('disabled').css('pointer-events', 'auto');
                    }
                }, 1000);
            }

            // Start countdown on page load to prevent immediate resend (optional)
            startResendCountdown(60);

            resendOtpBtn.on('click', async function() {
                if (resendOtpBtn.hasClass('disabled')) {
                    return; // Prevent clicks while disabled
                }

                // Confirm dialog before resending OTP
                const {
                    isConfirmed
                } = await Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to resend the OTP?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, resend it!',
                    cancelButtonText: 'Cancel'
                });

                if (!isConfirmed) {
                    return; // User cancelled
                }

                // Refresh token and email every click in case changed
                token = localStorage.getItem('token');
                email = localStorage.getItem('verify_otp_email');

                if (!token || !email) {
                    Swal.fire('Error', 'Session expired. Please try forgot password again.', 'error');
                    window.location.href = '/forgot-password';
                    return;
                }

                try {
                    // Show loading popup while request is in progress
                    Swal.fire({
                        title: 'Resending OTP...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const response = await axios.post('/forgot-password/resend-otp', {
                        email
                    }, {
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    });

                    Swal.close(); // Close loading popup

                    if (response.data.status === 'success') {
                        Swal.fire('Success', response.data.message || 'OTP resent successfully.',
                            'success');
                        // Start countdown after successful resend
                        startResendCountdown(60);
                    } else {
                        Swal.fire('Error', response.data.message || 'Failed to resend OTP.', 'error');
                    }
                } catch (error) {
                    Swal.close(); // Close loading popup if error
                    Swal.fire('Error', 'Failed to resend OTP. Try again later.', 'error');
                    //console.error(error);
                }
            });
        });
    </script>

</body>

</html>
