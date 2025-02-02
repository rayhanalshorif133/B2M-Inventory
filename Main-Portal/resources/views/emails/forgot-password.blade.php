<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; background-color: #ffffff;">
        <tr>
            <td align="center" bgcolor="#4CAF50" style="padding: 40px 0; color: #ffffff; font-size: 24px; font-weight: bold;">
                B2M Technologies Ltd.
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 30px 40px 30px;">
                <p style="margin: 0; font-size: 18px; color: #333333;">Hello {{ $details['user_name'] }},</p>
                <p style="margin: 20px 0 0 0; font-size: 16px; color: #666666;">
                    We received a request to reset your password. Click the button below to reset your password:
                </p>
                <p style="text-align: center; margin: 20px 0 20px 0;">
                    <a href="{{ $details['url'] }}" style="background-color: #4CAF50; color: #ffffff; padding: 15px 25px; text-decoration: none; font-size: 16px; border-radius: 5px;">Reset Password</a>
                </p>
                <p style="margin: 0; font-size: 16px; color: #666666;">
                    If you did not request a password reset, please ignore this email. Your password will remain unchanged.
                </p>
                <p style="margin: 20px 0 0 0; font-size: 16px; color: #333333;">Best regards,</p>
                <p style="margin: 0; font-size: 16px; color: #333333;">B2m Technologies Ltd</p>
            </td>
        </tr>
        <tr>
            <td align="center" bgcolor="#4CAF50" style="padding: 20px 0; color: #ffffff; font-size: 14px;">
                &copy; 2024 B2m Technologies Ltd. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
