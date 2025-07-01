<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Leave Application Notification – Nchito360°</title>
  </head>
  <body style="margin: 0; padding: 0; background-color: #f8f9fa; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
      <tr>
        <td align="center">
          <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden;">
            <tr>
              <td style="padding: 30px; text-align: center;">
                <!-- Logo -->
                <img src="https://nchito360.site/assets/img/logos/nchito360-logo.png" alt="Nchito360° Logo" width="130" style="margin-bottom: 20px;" />

                <!-- Heading -->
                <h2 style="color: #212529; margin-bottom: 10px;">New Leave Application Submitted</h2>

            

                <!-- Leave Info Table -->
                <table width="100%" cellpadding="0" cellspacing="0" style="margin: 20px 0; border-collapse: collapse;">
                  <tr>
                    <td style="text-align: left; font-size: 15px; color: #343a40;">
                      <table width="100%" cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
                        <tr>
                          <td style="font-weight: bold; width: 160px;">Employee Name:</td>
                          <td>{{ $leave->user->first_name }} {{ $leave->user->last_name }}</td>
                        </tr>
                        <tr>
                          <td style="font-weight: bold;">Email:</td>
                          <td>{{ $leave->user->email }}</td>
                        </tr>
                        <tr>
                          <td style="font-weight: bold;">Leave Type:</td>
                          <td>{{ ucfirst($leave->type) }}</td>
                        </tr>
                        <tr>
                          <td style="font-weight: bold;">Start Date:</td>
                          <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('F j, Y') }}</td>
                        </tr>
                        <tr>
                          <td style="font-weight: bold;">End Date:</td>
                          <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('F j, Y') }}</td>
                        </tr>
                        <tr>
                          <td style="font-weight: bold;">Reason:</td>
                          <td>{{ $leave->reason ?? 'N/A' }}</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>

                <!-- CTA -->
                <!-- <p style="margin: 30px 0;">
                  <a href="{{ route('leave.manage') }}" target="_blank" style="background-color: #0d6efd; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-size: 16px;">
                    👉 Manage Leave Requests
                  </a>
                </p> -->

                <!-- Signature -->
                <hr style="border: none; border-top: 1px solid #dee2e6; margin: 30px 0;" />
                <p style="font-size: 14px; color: #6c757d;">
                  <strong>Nchito360° Team</strong><br />
                  HR Management Made Easy<br />
                  🌐 <a href="https://nchito360.site" style="color: #0d6efd; text-decoration: none;">nchito360.site</a><br />
                  📧 <a href="mailto:support@nchito360.site" style="color: #0d6efd; text-decoration: none;">support@nchito360.site</a>
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
