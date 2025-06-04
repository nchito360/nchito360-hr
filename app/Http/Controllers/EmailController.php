<?php

namespace App\Http\Controllers;

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


   public static function sendJoinCompanyNotification(User $user, Company $company)
{
    // $admins = $company->users()->where('role', 'admin')->get();

    // foreach ($admins as $admin) {
        Mail::to('katongobupe444@gmail.com')->send(new CompanyJoinRequestMail($user, $company));
    // }
}

}

