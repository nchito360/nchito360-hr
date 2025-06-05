<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Reset Your Password - Nchito360°</title>
</head>
 <body style="background: linear-gradient(-45deg, #696CFF, #5E60CE, #3A0CA3, #4361EE, #00B4D8, #48CAE4, #F72585, #FFB703); background-size: 600% 600%; animation: gradientBG 16s ease-in-out infinite;">
  <style>
    @keyframes gradientBG {
      0% {background-position: 0% 50%;}
      15% {background-position: 50% 100%;}
      30% {background-position: 100% 50%;}
      45% {background-position: 50% 0%;}
      60% {background-position: 0% 50%;}
      75% {background-position: 50% 100%;}
      90% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }
  </style>
  <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" style="padding: 30px;">
        <!-- Card -->
        <table style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
          <tr>
            <td align="center">
              <!-- Logo -->
              <img src="https://nchito360.site/assets/img/logos/nchito360-logo.png" alt="Nchito360° Logo" width="100" style="margin-bottom: 20px;" />
              
              <!-- Title -->
              <h2 style="color: #1a1a1a;">Reset Your Password</h2>

              <!-- Message -->
              <p style="color: #555; line-height: 1.6;">
                Hi {{ $user->name ?? 'there' }}, <br><br>
                You recently requested to reset your password for your Nchito360° account. Click the button below to choose a new password:
              </p>

              <!-- Call to Action Button -->
              <p style="margin: 30px 0;">
                <a href="{{ $url }}" target="_blank" style="background-color: #0d6efd; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 5px; font-weight: bold;">
                  Reset Password
                </a>
              </p>

              <p style="color: #6c757d; font-size: 14px;">
                This link will expire in 60 minutes. If you did not request a password reset, please ignore this email.
              </p>

              <!-- Divider -->
              <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;" />

              <!-- Signature -->
              <p style="color: #6c757d; font-size: 14px;">
                Regards,<br>
                The Nchito360° Team
              </p>
            </td>
          </tr>
        </table>

      </td>
    </tr>
  </table>
</body>
</html>
