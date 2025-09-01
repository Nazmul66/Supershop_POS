<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Two-Factor Authentication</title>
</head>

<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f4f4;">
    <table width="100%" cellspacing="0" cellpadding="0" style="background-color:#f4f4f4; padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellspacing="0" cellpadding="0" style="background:#ffffff; border-radius:10px; padding:30px;">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding-bottom:20px;">
                            <h2 style="color:#333; margin:0;">🔐 Two-Factor Authentication</h2>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="color:#555; font-size:16px; line-height:24px; padding-bottom:20px;">
                            Hello <strong>{{ $admin->name }}</strong>,<br><br>
                            To complete your login, please use the following verification code:
                        </td>
                    </tr>
                    <!-- OTP Code -->
                    <tr>
                        <td align="center" style="padding:20px 0;">
                            <div style="background:#007bff; color:#fff; font-size:24px; letter-spacing:4px; padding:15px 30px; border-radius:8px; display:inline-block;">
                                {{ $admin->two_factor_code }}
                            </div>
                        </td>
                    </tr>
                    <!-- Footer -->

                    @php
                        $expireAt = \Carbon\Carbon::parse($admin->two_factor_expire_at)->timezone('Asia/Dhaka');
                        $now = \Carbon\Carbon::now('Asia/Dhaka');

                        // Get signed difference in seconds
                        $remainingMinutes = $now->diffInMinutes($expireAt, false); // negative if expired

                        // dd($remainingMinutes);
                    @endphp

                    <tr>
                        <td style="color:#777; font-size:14px; line-height:20px; padding-top:20px; text-align:center;">
                            This code will expire in {{ ceil($remainingMinutes) }} minutes. If you did not attempt to log in, please secure your account immediately.<br><br>
                            <em>Thank you,<br>{{ config('app.name') }} Security Team</em>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>