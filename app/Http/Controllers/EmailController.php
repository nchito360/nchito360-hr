<?php

namespace App\Http\Controllers;
use App\Mail\NotificationMail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveAppliedMail;
use App\Mail\LeaveStatusChangedMail;
use App\Mail\JoinRequestMail;
use App\Mail\CompanyJoinRequestMail;
use App\Models\Company;
use App\Models\JoinCompanyRequest;
use App\Models\LeaveApplication;
use App\Models\Leave;
use App\Models\User;

class EmailController extends Controller
{
// public function sendLeaveApplied($leave)
// {
//     // Get users in the same company with full privileges, excluding the one who applied
//     $recipients = User::where('company_id', $leave->company_id)
//                       ->where('privileges', 'full')
//                       ->where('id', '!=', $leave->user_id)
//                       ->get();

//     foreach ($recipients as $recipient) {
//         Mail::to($recipient->email)->send(new LeaveAppliedMail($leave));
//     }

//     return response()->json(['message' => 'Leave application email sent to full-privilege users.']);
// }

public function sendLeaveApplied($leave)
{
    $admins = User::where('company_id', $leave->company_id)
                  ->where('privileges', 'full')
                  ->where('id', '!=', $leave->user_id)
                  ->get();

    foreach ($admins as $admin) {
        Mail::to($admin->email)->send(new LeaveAppliedMail($leave));
    }
}

public function store(Request $request)
{
    $request->validate([
        'leave_type' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'nullable|string|max:1000',
    ]);

    $leave = Leave::create([
        'user_id' => Auth::id(),
        'company_id' => Auth::user()->company_id,
        'type' => $request->leave_type,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'reason' => $request->reason,
        'status' => 'pending',
    ]);

    // Send email to admins with full privileges
    app(EmailController::class)->sendLeaveApplied($leave);

    return redirect()->back()->with('success', 'Leave request submitted.');
}

public function approveReject(Request $request, Leave $leave)
{
    $request->validate([
        'status' => 'required|in:approved,rejected',
        'manager_comment' => 'nullable|string|max:1000',
    ]);

    $leave->update([
        'status' => $request->status,
        'manager_comment' => $request->manager_comment,
    ]);

    // Notify user of the change
    $subject = 'Leave Request ' . ucfirst($request->status);
    $message = "Your leave request from {$leave->start_date} to {$leave->end_date} has been {$request->status}.";
    app(EmailController::class)->notifyUser($leave->user, $subject, $message);

    return back()->with('success', 'Leave application ' . $request->status . '.');
}



public function sendLeaveStatusChanged($leave)
{
    // Notify the applicant about their leave status
    Mail::to($leave->user->email)->send(new LeaveStatusChangedMail($leave));

    return response()->json(['message' => 'Leave status change email sent.']);
}


public function sendJoinRequest($joinRequest)
{
    // Get users with full privileges in the target company
    $admins = User::where('company_id', $joinRequest->company_id)
                  ->where('privileges', 'full')
                  ->get();

    // Send the join request email to each admin
    foreach ($admins as $admin) {
        Mail::to($admin->email)->send(new JoinRequestMail($joinRequest));
    }

    return response()->json(['message' => 'Join request email sent to all full-privilege admins.']);
}



   // public static function sendJoinCompanyNotification(User $user, Company $company)
//{
    // $admins = $company->users()->where('role', 'admin')->get();

    // foreach ($admins as $admin) {
        //Mail::to('katongobupe444@gmail.com')->send(new CompanyJoinRequestMail($user, $company));
    // }
//}


public function notifyAdmins($company, $subject, $message, $buttonText = null, $buttonUrl = null)
{
    // Get all users in the company with full privileges
    $admins = User::where('company_id', $company->id)
                  ->where('privileges', 'full')
                  ->get();

    // Loop through each admin and send the email
    foreach ($admins as $admin) {
        Mail::to($admin->email)->send(
            new NotificationMail($subject, $message, $buttonText, $buttonUrl)
        );
    }
}

public function notifyUser($user, $subject, $message, $buttonText = null, $buttonUrl = null)
{
    Mail::to($user->email)->send(
        new NotificationMail($subject, $message, $buttonText, $buttonUrl)
    );
}


public function sendJoinCompanyNotification($user, $company)
{
    $subject = 'New Join Request';
    $message = "{$user->first_name} {$user->last_name} has requested to join your company.";
    $buttonText = 'Manage Requests';
    $buttonUrl = route('employee.company.manage');

    $this->notifyAdmins($company, $subject, $message, $buttonText, $buttonUrl);
    $this->notifyUser($user, 'Join Request Sent', 'Your request to join the company has been sent successfully.', 'View Company', route('employee.company.overview', $company->id));
}

public function sendCancelJoinNotification($user, $company)
{
    $subject = 'Join Request Cancelled';
    $message = "{$user->first_name} {$user->last_name} has cancelled their join request.";
    $buttonText = 'View Requests';
    $buttonUrl = route('employee.company.manage');

    $this->notifyAdmins($company, $subject, $message, $buttonText, $buttonUrl);
    $this->notifyUser($user, 'Join Request Cancelled', 'Your request to join the company has been cancelled.', 'View Company', route('employee.company.overview', $company->id));
}

public function sendJoinRequestResponseNotification($user, $company, $status)
{
    $subject = "Join Request {$status}";
    $message = "The join request from {$user->first_name} {$user->last_name} has been {$status}.";
    $buttonText = 'View Requests';
    $buttonUrl = route('employee.company.manage');

    $this->notifyAdmins($company, $subject, $message, $buttonText, $buttonUrl);
    $this->notifyUser($user, $subject, $message, 'View Company', route('employee.company.overview', $company->id));
}


public function sendApproveJoinNotification($user, $company)
{
    $subject = 'Join Request Approved';
    $message = "{$user->first_name} {$user->last_name}'s request to join your company has been approved.";
    $this->notifyAdmins($company, $subject, $message);
    $this->notifyUser($user, 'Join Request Approved', 'Your request to join the company has been approved.', 'View Company', route('employee.company.overview', $company->id));
}


public function sendRejectJoinNotification($user, $company)
{
    $subject = 'Join Request Rejected';
    $message = "{$user->first_name} {$user->last_name}'s request to join your company has been rejected.";
    $this->notifyAdmins($company, $subject, $message);
    $this->notifyUser($user, 'Join Request Rejected', 'Your request to join the company has been rejected.', 'View Company', route('employee.company.overview', $company->id));
}




}

