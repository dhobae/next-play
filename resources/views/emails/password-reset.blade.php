<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur ulang kata sandi</title>
</head>

<body
    style="margin: 0; padding: 32px 16px; background-color: #eef5f5; color: #17212b; font-family: Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto;">
        {{-- <tr>
            <td style="padding: 12px 0 24px; text-align: center;">
                <img src="{{ asset('/assets/nextpremiere/logo.png') }}" alt="Next Premiere" width="64" style="display: inline-block; max-width: 64px; height: auto;">
            </td>
        </tr> --}}
        <tr>
            <td style="background-color: #ffffff; border: 1px solid #dbe4e8; border-radius: 14px; padding: 40px 36px;">
                <h1 style="margin: 0 0 16px; color: #17212b; font-size: 24px; line-height: 1.3;">Atur ulang kata sandi
                </h1>
                <p style="margin: 0 0 16px; color: #687582; font-size: 16px; line-height: 1.6;">
                    Halo{{ $name ? ' ' . $name : '' }},</p>
                <p style="margin: 0 0 24px; color: #687582; font-size: 16px; line-height: 1.6;">Kami menerima permintaan
                    untuk mengatur ulang kata sandi akun Next Premiere Anda. Klik tombol di bawah untuk melanjutkan.</p>
                <table role="presentation" cellspacing="0" cellpadding="0" style="margin: 0 0 24px;">
                    <tr>
                        <td style="border-radius: 8px; background-color: #176b87;">
                            <a href="{{ $url }}"
                                style="display: inline-block; padding: 13px 22px; color: #ffffff; font-size: 15px; font-weight: bold; text-decoration: none;">Atur
                                ulang kata sandi</a>
                        </td>
                    </tr>
                </table>
                <p style="margin: 0 0 12px; color: #687582; font-size: 14px; line-height: 1.6;">Tautan ini berlaku
                    selama 60 menit. Jika Anda tidak meminta perubahan ini, abaikan email ini.</p>
                <p style="margin: 0; color: #687582; font-size: 14px; line-height: 1.6;">Jika tombol tidak berfungsi,
                    salin tautan berikut ke browser Anda:</p>
                <p style="margin: 8px 0 0; word-break: break-all; color: #176b87; font-size: 13px; line-height: 1.5;">
                    {{ $url }}</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 24px 12px 0; text-align: center; color: #687582; font-size: 12px; line-height: 1.5;">
                Email ini dikirim otomatis oleh Next Premiere.
            </td>
        </tr>
    </table>
</body>

</html>
