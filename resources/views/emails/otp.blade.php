<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .email-container {
            max-width: 600px;
            margin: auto;
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 5px 15px rgb(0 0 0 / 0.1);
        }
        .otp-code {
            font-size: 2.5rem;
            font-weight: 700;
            color: #0d6efd;
            letter-spacing: 8px;
            text-align: center;
            margin: 20px 0;
            user-select: all;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 12px 25px;
            font-size: 1.1rem;
            border-radius: 6px;
            display: inline-block;
            text-decoration: none;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            text-decoration: none;
            color: white;
        }
        .footer-text {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 30px;
            text-align: center;
        }
        @media (max-width: 600px) {
            .email-container {
                padding: 20px;
            }
            .otp-code {
                font-size: 2rem;
                letter-spacing: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2 class="text-center mb-4">OTP Verification Code</h2>
        <p>Hello,</p>
        <p>You have requested to reset your password. Please use the following <strong>One-Time Password (OTP)</strong> to verify your identity:</p>

        <div class="otp-code">{{ $otp }}</div>

        <p class="text-center">
            <a href="{{url('/forgot-password/verify-otp')}}" class="btn btn-primary" target="_blank" rel="noopener">Verify OTP</a>
        </p>

        <p>This OTP is valid for the next 10 minutes. If you did not request this, please ignore this email.</p>

        <p>Thanks,<br /> ABC SCHOOL</p>

        <div class="footer-text">
            &copy; {{ date('Y') }} ABC SCHOOL. All rights reserved.
        </div>
    </div>
</body>
</html>
