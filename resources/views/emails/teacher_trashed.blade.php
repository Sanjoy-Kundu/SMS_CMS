<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Trashed Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f9f9f9; margin:0; padding:0;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding: 30px 0; background-color: #004080; color:#fff;">
                <h1 style="margin:0; font-size:22px;">AB School & College</h1>
                <p style="margin:0; font-size:14px;">Excellence in Education</p>
            </td>
        </tr>

        <tr>
            <td style="padding: 20px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:0 auto; background:#fff; border:1px solid #ddd; border-radius:6px;">
                    <tr>
                        <td style="padding: 20px;">
                            <h2 style="color:#333; font-size:18px;">Dear {{ $teacherName }},</h2>
                            <p style="color:#555; font-size:14px; line-height:1.6;">
                                We would like to inform you that your profile has been <strong>moved to Trash</strong> in our system. 
                                If this action was done by mistake, please contact the administration immediately.
                            </p>

                            <p style="color:#333; font-size:14px;">
                                <strong>Name:</strong> {{ $teacherName }}<br>
                                <strong>Email:</strong> {{ $teacherEmail }}<br>
                                <strong>Role:</strong> Teacher
                            </p>

                            <p style="color:#555; font-size:14px; line-height:1.6;">
                                This ensures that accidental or incorrect registrations are properly managed while maintaining data integrity.
                            </p>

                            <p style="margin-top:20px; font-size:14px; color:#333;">
                                Regards,<br>
                                <strong>Administration Office</strong><br>
                                AB School & College
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td align="center" style="padding: 15px; background-color:#f1f1f1; font-size:12px; color:#555;">
                © {{ date('Y') }} AB School & College. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
