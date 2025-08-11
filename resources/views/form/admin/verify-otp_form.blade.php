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

    <div class="otp-card" data-email="{{ $email ?? 'user@example.com' }}">
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

            <button type="submit" class="btn btn-primary w-100" onclick="verifyOtp(event)">Verify OTP</button>
        </form>

        <div class="resend-text" id="resendOtp">Didn't receive OTP? Resend</div>
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
                    console.log(res.data.user.name);
                    document.querySelector('#user_name__otp').innerText = res.data.user.name?res.data.user.name:"N/A";
                    document.querySelector('#user_email__otp').innerText = res.data.user.email?res.data.user.email:"N/A";
                    document.querySelector('#user_role__otp').innerText = res.data.user.role?res.data.user.role:"N/A";
                    if (res.data.user.admin.image) {
                        document.querySelector('#user_profile_image_otp').src = res.data.user.admin.image;
                        
                    } else {
                        document.querySelector('#user_profile_image_otp').src = '/uploads/admin/profile/default.png';
                    }
                }
            } catch (error) {
                console.error(error);
            }
        }



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

    try {
        let res = await axios.post('/forgot-password/verify-otp', { email, otp }, {
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
                // Reset localStorage items if needed
                //localStorage.removeItem('verify_otp_email');
                // Redirect to reset password page
                window.location.href = '/forgot-password/reset-password';
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
    }
}
















        // $(function() {
        //     // CSRF token from meta
        //     axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

        //     const inputs = $('.otp-inputs input');
        //     const resendOtpBtn = $('#resendOtp');
        //     const otpCard = $('.otp-card');
        //     const email = otpCard.data('email');
        //     let resendTimer;

        //     // Auto focus next input on input
        //     inputs.on('input', function() {
        //         const index = inputs.index(this);
        //         if (this.value.length === 1 && index < inputs.length - 1) {
        //             inputs.eq(index + 1).focus();
        //         }
        //     });

        //     // Backspace to previous input
        //     inputs.on('keydown', function(e) {
        //         const index = inputs.index(this);
        //         if (e.key === 'Backspace' && this.value === '' && index > 0) {
        //             inputs.eq(index - 1).focus();
        //         }
        //     });

        //     // Resend OTP click handler
        //     resendOtpBtn.on('click', function() {
        //         if (resendOtpBtn.hasClass('disabled')) return;

        //         axios.post('/forgot-password/send-otp', { email: email })
        //         .then(response => {
        //             if(response.data.status === 'success') {
        //                 Swal.fire('Success', 'OTP resent successfully! Please check your email.', 'success');
        //                 startResendTimer(30);
        //             } else {
        //                 Swal.fire('Error', response.data.message || 'Failed to resend OTP.', 'error');
        //             }
        //         })
        //         .catch(error => {
        //             Swal.fire('Error', 'Failed to resend OTP. Try again later.', 'error');
        //             console.error(error);
        //         });
        //     });

        //     // Timer for resend button
        //     function startResendTimer(seconds) {
        //         let timeLeft = seconds;
        //         resendOtpBtn.addClass('disabled').text(`Resend available in ${timeLeft} seconds`);

        //         resendTimer = setInterval(() => {
        //             timeLeft--;
        //             if(timeLeft > 0) {
        //                 resendOtpBtn.text(`Resend available in ${timeLeft} second${timeLeft > 1 ? 's' : ''}`);
        //             } else {
        //                 clearInterval(resendTimer);
        //                 resendOtpBtn.removeClass('disabled').text("Didn't receive OTP? Resend");
        //             }
        //         }, 1000);
        //     }

        //     // Form submit handler
        //     $('#otpForm').on('submit', function(e) {
        //         e.preventDefault();

        //         // Collect OTP digits
        //         const otpValues = inputs.map(function() {
        //             return $(this).val().trim();
        //         }).get();

        //         // Validate OTP inputs
        //         if(otpValues.some(val => val === '' || !/^\d$/.test(val))) {
        //             Swal.fire('Error', 'Please enter a valid 6-digit OTP.', 'error');
        //             return;
        //         }

        //         const otp = otpValues.join('');

        //         axios.post('/forgot-password/verify-otp', { otp: otp, email: email })
        //         .then(response => {
        //             if(response.data.status === 'success') {
        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: 'OTP Verified',
        //                     text: 'You can now reset your password.',
        //                     confirmButtonText: 'Continue'
        //                 }).then(() => {
        //                     window.location.href = '/forgot-password/reset-password'; // Adjust URL if needed
        //                 });
        //             } else {
        //                 Swal.fire('Error', response.data.message || 'Invalid OTP.', 'error');
        //             }
        //         })
        //         .catch(error => {
        //             if(error.response && error.response.status === 422) {
        //                 let errors = error.response.data.errors;
        //                 let messages = Object.values(errors).flat().join('<br>');
        //                 Swal.fire({ icon: 'error', title: 'Validation Error', html: messages });
        //             } else {
        //                 Swal.fire('Error', 'Failed to verify OTP. Try again.', 'error');
        //             }
        //             console.error(error);
        //         });
        //     });
        // });


    </script>

</body>

</html>
        