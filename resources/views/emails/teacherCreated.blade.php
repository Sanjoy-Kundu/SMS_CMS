<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Account Created</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
            color: #51545E;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h2 {
            color: #3869D4;
        }
        p {
            line-height: 1.6;
        }
        .credentials {
            background-color: #f0f0f5;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .credentials p {
            margin: 5px 0;
            font-family: monospace;
        }
        .footer {
            font-size: 12px;
            color: #A8AAAF;
            margin-top: 20px;
            text-align: center;
        }
        a.button {
            display: inline-block;
            background-color: #3869D4;
            color: #ffffff !important;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello {{ $user->name }},</h2>
        <p>We are excited to inform you that your <strong>Teacher</strong> account has been successfully created.</p>

        <div class="credentials">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
        </div>

        <p>Please login using the above credentials and change your password immediately for security purposes.</p>

        <a href="{{ url('/teacher/login') }}" class="button">Login Now</a>

        <p>If you did not request this account, please ignore this email or contact support immediately.</p>

        <div class="footer">
            &copy; {{ date('Y') }} Your Institution Name. All rights reserved.
        </div>
    </div>
</body>
</html>
