<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Join Request Notification</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.07);
        }
        h2 {
            color: #1a73e8;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #e8f0fe;
            color: #1a73e8;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
        .btn {
            margin-top: 20px;
            display: inline-block;
            padding: 12px 20px;
            background-color: #1a73e8;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #155ab6;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>New Join Request</h2>
        <p>Hello Admin,</p>

        <p><strong>{{ $user->first_name }} {{ $user->last_name }}</strong> has requested to join your company <strong>{{ $company->name }}</strong>.</p>

        <table>
            <tr>
                <th>Full Name</th>
                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Requested At</th>
                <td>{{ now()->format('F j, Y - g:i A') }}</td>
            </tr>
        </table>

        <a href="{{ route('employee.company.manage') }}" class="btn">Review Requests</a>

         <div class="footer">
            &copy; {{ now()->year }} Human Resource Management System. All rights reserved.<br>
            This email was sent to you because you are an administrator of the HR System.
        </div>
    </div>
</body>
</html>
