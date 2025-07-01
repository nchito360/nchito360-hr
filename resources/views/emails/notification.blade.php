<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>{{ $subjectLine }}</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f8f9fa; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden;">
                    <tr>
                        <td style="padding: 30px; text-align: center;">
                            <img src="https://nchito360.site/assets/img/logos/nchito360-logo.png" alt="Nchito360° Logo"
                                width="130" style="margin-bottom: 20px;" />

                            <h2 style="color: #212529; margin-bottom: 10px;">{{ $subjectLine }}</h2>

                            <p style="font-size: 16px; line-height: 1.6; color: #495057;">
                                {!! $messageBody !!}
                            </p>

                            @if ($buttonText && $buttonUrl)
                            <p style="margin: 30px 0;">
                                <a href="{{ $buttonUrl }}" target="_blank"
                                    style="background-color: #0d6efd; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-size: 16px;">
                                    {{ $buttonText }}
                                </a>
                            </p>
                            @endif

                            <hr style="border: none; border-top: 1px solid #dee2e6; margin: 30px 0;" />
                            <p style="font-size: 14px; color: #6c757d;">
                                <strong>Nchito360° Team</strong><br />
                                🌐 <a href="https://nchito360.site"
                                    style="color: #0d6efd; text-decoration: none;">nchito360.site</a><br />
                                📧 <a href="mailto:support@nchito360.site"
                                    style="color: #0d6efd; text-decoration: none;">support@nchito360.site</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>