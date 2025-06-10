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
    public function sendLeaveApplied($leave)
    {
        // $managers = User::where('company_id', $leave->company_id)
        //                 ->whereIn('position', ['manager', 'supervisor', 'admin'])
        //                 ->where('id', '!=', $leave->user_id)
        //                 ->get();

        
            Mail::to('katongobupe444@gmail.com')->send(new LeaveAppliedMail($leave));

        return response()->json(['message' => 'Leave application email sent.']);
    }

    public function sendLeaveStatusChanged($leave)
    {
        Mail::to($leave->user->email)->send(new LeaveStatusChangedMail($leave));
        return response()->json(['message' => 'Leave status change email sent.']);
    }

    public function sendJoinRequest($joinRequest)
    {
        $admins = User::where('company_id', $joinRequest->company_id)
                      ->where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new JoinRequestMail($joinRequest));
        }

        return response()->json(['message' => 'Join request email sent.']);
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
    $admins = User::where('company_id', $company->id)
                  ->where('privileges', 'full') // Adjust as per your role logic
                  ->get();

    foreach ($admins as $admin) {
        Mail::to($admin->email)->send(new NotificationMail($subject, $message, $buttonText, $buttonUrl));
    }

    // Also notify the support email
    Mail::to('katongobupe444@gmail.com')->send(new NotificationMail($subject, $message, $buttonText, $buttonUrl));
}

public function sendJoinCompanyNotification($user, $company)
{
    $subject = 'New Join Request';
    $message = "{$user->first_name} {$user->last_name} has requested to join your company.";
    $buttonText = 'Manage Requests';
    $buttonUrl = route('employee.company.manage');

    $this->notifyAdmins($company, $subject, $message, $buttonText, $buttonUrl);
}

public function sendCancelJoinNotification($user, $company)
{
    $subject = 'Join Request Cancelled';
    $message = "{$user->first_name} {$user->last_name} has cancelled their join request.";
    $buttonText = 'View Requests';
    $buttonUrl = route('employee.company.manage');

    $this->notifyAdmins($company, $subject, $message, $buttonText, $buttonUrl);
}

public function sendJoinRequestResponseNotification($user, $company, $status)
{
    $subject = "Join Request {$status}";
    $message = "The join request from {$user->first_name} {$user->last_name} has been {$status}.";
    $buttonText = 'View Requests';
    $buttonUrl = route('employee.company.manage');

    $this->notifyAdmins($company, $subject, $message, $buttonText, $buttonUrl);
}


public function sendApproveJoinNotification($user, $company)
{
    $subject = 'Join Request Approved';
    $message = "{$user->first_name} {$user->last_name}'s request to join your company has been approved.";
    $this->notifyAdmins($company, $subject, $message);
}


public function sendRejectJoinNotification($user, $company)
{
    $subject = 'Join Request Rejected';
    $message = "{$user->first_name} {$user->last_name}'s request to join your company has been rejected.";
    $this->notifyAdmins($company, $subject, $message);
}




}

