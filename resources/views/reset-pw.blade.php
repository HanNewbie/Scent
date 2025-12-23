<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Scent Atelier</title>
</head>

<body style="margin:0; padding:0; background-color:#fffbf5; font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#fffbf5; padding:30px 0;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" 
                       style="max-width:520px; background-color:#ffffff; border-radius:16px; box-shadow:0 10px 25px rgba(0,0,0,0.08); padding:32px;">
                
                    <tr>
                        <td align="center" style="padding-bottom:20px;">
                            <h1 style="margin:0; font-size:22px; letter-spacing:2px; color:#92400e;">
                                SCENT ATELIER
                            </h1>
                            <p style="margin:6px 0 0; font-size:14px; color:#555;">
                                Reset Password
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size:14px; color:#333; line-height:1.6;">
                            <p>Halo,</p>
                            <p>
                                Kami menerima permintaan untuk mereset password akun Anda.
                                Silakan klik tombol di bawah ini untuk melanjutkan proses reset password.
                            </p>
                            <p style="text-align:center; margin:28px 0;">
                                <a href="{{ $link }}"
                                   style="display:inline-block; padding:12px 24px; background-color:#92400e; color:#ffffff;
                                          text-decoration:none; border-radius:8px; font-weight:bold;">
                                    Reset Password
                                </a>
                            </p>
                            <p>
                                Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut
                                ke browser Anda:
                            </p>
                            <p style="word-break:break-all; color:#92400e;">
                                <a href="{{ $link }}" style="color:#92400e; text-decoration:none;">
                                    {{ $link }}
                                </a>
                            </p>
                            <div style="margin-top:20px; padding:12px 16px; background-color:#fff7ed; border-left:4px solid #92400e;">
                                <p style="margin:0; font-size:13px; color:#92400e;">
                                    <strong>Catatan:</strong> Tautan reset password ini hanya berlaku selama
                                    <strong>60 menit</strong>. Setelah itu, Anda perlu mengajukan permintaan reset ulang.
                                </p>
                            </div>

                            <p style="margin-top:20px;">
                                Jika Anda tidak merasa meminta reset password, abaikan email ini.
                            </p>

                            <p style="margin-top:24px;">
                                Salam,<br>
                                <strong>Scent Atelier</strong>
                            </p>
                        </td>
                    </tr>
                </table>
                <p style="font-size:12px; color:#888; margin-top:16px;">
                    © {{ date('Y') }} Scent Atelier. All rights reserved.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
