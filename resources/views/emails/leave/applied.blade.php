<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Leave Application Notification</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }
        h2 {
            color: #0056b3;
        }
        p {
            line-height: 1.6;
        }
        .info-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .info-table th,
        .info-table td {
            padding: 10px;
            text-align: left;
        }
        .info-table th {
            background-color: #f0f4f8;
            color: #0056b3;
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #888;
            text-align: center;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #0056b3;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn:hover {
            background-color: #003e80;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>New Leave Application Submitted</h2>
        <p>Hello,</p>

        <p>
            <strong>{{ $leave->user->first_name }} {{ $leave->user->last_name }}</strong> has submitted a leave request. Below are the details:
        </p>

        <table class="info-table">
            <tr>
                <th>Employee Name</th>
                <td>{{ $leave->user->first_name }} {{ $leave->user->last_name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $leave->user->email }}</td>
            </tr>
            <tr>
                <th>Leave Type</th>
                <td>{{ ucfirst($leave->type) }}</td>
            </tr>
            <tr>
                <th>Start Date</th>
                <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('F j, Y') }}</td>
            </tr>
            <tr>
                <th>End Date</th>
                <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('F j, Y') }}</td>
            </tr>
            <tr>
                <th>Reason</th>
                <td>{{ $leave->reason }}</td>
            </tr>
        </table>

        <a href="{{ route('leave.manage') }}" class="btn">Go to Dashboard</a>

        <div class="footer">
            &copy; {{ now()->year }} Human Resource Management System. All rights reserved.<br>
            This email was sent to you because you are an administrator of the HR System.
        </div>
    </div>
</body>
</html>
