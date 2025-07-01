<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\EmailController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;



class LeaveController extends Controller
{

public function index(Request $request)
{
    $user = auth()->user();

    $leaveEntitlement = 0;

    if ($user->employment_status !== 'probation' && $user->contract_start_date) {
        $contractStart = Carbon::parse($user->contract_start_date);
        $yearStart = Carbon::now()->startOfYear();
        $now = Carbon::now()->startOfMonth();

        $entitlementStart = $contractStart->greaterThan($yearStart) ? $contractStart->copy()->startOfMonth() : $yearStart;

        $monthsWorkedThisYear = $entitlementStart->diffInMonths($now);
        $leaveEntitlement = $monthsWorkedThisYear * 2;
    }

    $usedLeaveDays = Leave::where('user_id', $user->id)
        ->where('status', 'approved')
        ->whereYear('start_date', Carbon::now()->year)
        ->where('type', 'annual')
        ->get()
        ->sum(function ($leave) {
            return Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1;
        });

    $remainingLeaveDays = max($leaveEntitlement - $usedLeaveDays, 0);

    // Build query to fetch leaves for this user
    $query = Leave::where('user_id', $user->id)->latest();

    // Apply filter if status present in query string
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $appliedLeaves = $query->get();

    // Filter declined leaves separately (optional if you want)
    $declinedLeaves = $appliedLeaves->where('status', 'declined');

    return view('apps.leave.employee.index', [
        'leaveEntitlement' => $leaveEntitlement,
        'usedLeaveDays' => $usedLeaveDays,
        'remainingLeaveDays' => $remainingLeaveDays,
        'appliedLeaves' => $appliedLeaves,
        'declinedLeaves' => $declinedLeaves,
        'user' => $user,
    ]);
}


    public function apply()
    {
        $leaves = Leave::where('user_id', Auth::id())->latest()->get();
        return view('apps.leave.employee.apply', compact('leaves'));
    }

public function approve($id)
{
    $leave = Leave::with('user')->findOrFail($id);

    if ($leave->status !== 'pending') {
        return redirect()->back()->with('error', 'Only pending leaves can be approved.');
    }

    // Mark as approved
    $leave->status = 'approved';
    $leave->manager_comment = 'Approved';
    $leave->approved_by = Auth::id();
    $leave->save();

    // Calculate number of leave days
    $approvedDays = Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1;

    // Update user's used leave days (excluding sick/emergency/other)
    if (!in_array($leave->type, ['sick', 'emergency', 'other'])) {
        $leave->user->used_leave_days += $approvedDays;
        $leave->user->save();
    }

    // Email content
    $applicantName = $leave->user->first_name . ' ' . $leave->user->last_name;
       $leaveDetailsTable = "
    <table cellpadding='0' cellspacing='0' width='100%' style='max-width:600px; border-collapse:collapse; font-family:Arial, sans-serif; font-size:14px; color:#333; margin:auto;'>
        <tr>
            <td colspan='2' style='background-color:#f1f1f1; padding:12px; font-weight:bold; text-align:left; border:1px solid #ddd;'>
                Leave Application Summary
            </td>
        </tr>
        <tr>
            <td style='width:40%; padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Applicant</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$applicantName}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Leave Type</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->type}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Start Date</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->start_date}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>End Date</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->end_date}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Status</td>
            <td style='padding:10px; border:1px solid #ddd; text-transform:capitalize;'>{$leave->status}</td>
        </tr>
       
    </table>
";

    // Notify user
    $userSubject = 'Your Leave Application Approved';
    $userMessage = "
        Dear {$applicantName},<br><br>
        Your leave application has been <strong>approved</strong> by your manager.<br><br>
        <strong>Leave Details:</strong><br><br>
        {$leaveDetailsTable}
        <br><br>
        If you have any questions, please contact HR.
    ";

    // Notify admins
    $adminSubject = 'Employee Leave Application Approved';
    $adminMessage = "
        Hello Admin,<br><br>
        The following leave application has been <strong>approved</strong>:<br><br>
        {$leaveDetailsTable}
        <br><br>
        Please take note for your records.
    ";

    app(EmailController::class)->notifyUser($leave->user, $userSubject, $userMessage);
    app(EmailController::class)->notifyAdmins(
        $leave->company,
        $adminSubject,
        $adminMessage,
        'View Leave',
        route('manage.leave')
    );

    return redirect()->back()->with('success', 'Leave application approved.');
}



public function reject(Request $request, $id)
{
    $leave = Leave::with('user')->findOrFail($id);

    $leave->status = 'rejected';
    $leave->manager_comment = $request->input('manager_comment');
    $leave->approved_by = Auth::id(); // Set the manager who rejected
    $leave->save();

    $applicantName = $leave->user->name;
    $managerComment = $leave->manager_comment;

    $leaveDetailsTable = "
    <table cellpadding='0' cellspacing='0' width='100%' style='max-width:600px; border-collapse:collapse; font-family:Arial, sans-serif; font-size:14px; color:#333; margin:auto;'>
        <tr>
            <td colspan='2' style='background-color:#f1f1f1; padding:12px; font-weight:bold; text-align:left; border:1px solid #ddd;'>
                Leave Application Summary
            </td>
        </tr>
        <tr>
            <td style='width:40%; padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Applicant</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$applicantName}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Leave Type</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->type}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Start Date</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->start_date}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>End Date</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->end_date}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Status</td>
            <td style='padding:10px; border:1px solid #ddd; text-transform:capitalize;'>{$leave->status}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Manager Comment</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$managerComment}</td>
        </tr>
    </table>
";


    // Message for the user
    $userSubject = 'Your Leave Application Rejected';
    $userMessage = "
        Dear {$applicantName},<br><br>
        Your leave application has been <strong>rejected</strong> by your manager.<br><br>
        <strong>Leave Details:</strong><br>
        {$leaveDetailsTable}
        <br>
        If you have any questions, please contact HR.
    ";

    // Message for the admins
    $adminSubject = 'Employee Leave Application Rejected';
    $adminMessage = "
        Hello Admin,<br><br>
        The following leave application has been <strong>rejected</strong>:<br><br>
        {$leaveDetailsTable}
        <br>
        Please take note for your records.
    ";

    app(EmailController::class)->notifyUser($leave->user, $userSubject, $userMessage);
    app(EmailController::class)->notifyAdmins($leave->company, $adminSubject, $adminMessage, 'View Leave', route('manage.leave'));

    return redirect()->back()->with('success', 'Leave application rejected with comment.');
}



public function store(Request $request)
{
    $request->validate([
        'leave_type' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'nullable|string|max:1000',
        'supporting_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5048',
    ]);

    $user = Auth::user();

    if ($user->employment_status === 'probation') {
        return redirect()->back()->with('error', 'You cannot apply for leave while on probation.');
    }

    // Calculate leave entitlement
    $start = Carbon::parse($user->contract_start_date)->startOfMonth();
    $now = Carbon::now()->startOfMonth();
    $monthsWorked = $start->diffInMonths($now) + 1;
    $leaveEntitlement = $monthsWorked * 2;

    $usedLeaveDays = Leave::where('user_id', $user->id)
        ->where('status', 'approved')
        ->whereNotIn('type', ['sick', 'emergency', 'other'])
        ->get()
        ->sum(fn($leave) => Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1);

    $remainingLeaveDays = max($leaveEntitlement - $usedLeaveDays, 0);
    $requestedDays = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date)) + 1;

    if (!in_array($request->leave_type, ['sick', 'emergency', 'other']) && $requestedDays > $remainingLeaveDays) {
        return redirect()->back()->with('error', 'You cannot apply for more leave days than you have accumulated.');
    }

    $documentPath = null;
    if ($request->hasFile('supporting_document')) {
        $documentPath = $request->file('supporting_document')->store('supporting_documents', 'public');
    }

    $leave = Leave::create([
        'user_id' => $user->id,
        'company_id' => $user->company_id,
        'type' => $request->leave_type,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'reason' => $request->reason,
        'supporting_document' => $documentPath,
        'status' => 'pending',
    ]);

    app(EmailController::class)->sendLeaveApplied($leave);

    return redirect()->back()->with('success', 'Leave request submitted.');
}


// Employee: Edit a leave (if declined)
public function edit(Leave $leave)
{
    // Optional: Only allow editing if the leave belongs to the logged-in user and is declined
    if ($leave->user_id !== auth()->id()) {
        abort(403, 'Unauthorized access.');
    }

    // if ($leave->status !== 'declined') {
    //     return redirect()->back()->with('error', 'Only declined leave applications can be edited.');
    // }

    return view('apps.leave.employee.edit', compact('leave'));
}

// Employee: Update leave
public function update(Request $request, Leave $leave)
{
    if ($leave->user_id !== auth()->id()) {
        abort(403, 'Unauthorized access.');
    }

    $request->validate([
        'leave_type' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'nullable|string|max:1000',
        'supporting_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5048',
    ]);

    $updateData = [
        'type' => $request->leave_type,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'reason' => $request->reason,
        'status' => 'pending',

    ];

    if ($request->hasFile('supporting_document')) {
        $updateData['supporting_document'] = $request->file('supporting_document')->store('supporting_documents', 'public');
    }

    $leave->update($updateData);

    // Build email content
    $applicantName = $leave->user->first_name . ' ' . $leave->user->last_name;
    $managerComment = $leave->manager_comment;
    $leaveDetailsTable = "
    <table cellpadding='0' cellspacing='0' width='100%' style='max-width:600px; border-collapse:collapse; font-family:Arial, sans-serif; font-size:14px; color:#333; margin:auto;'>
        <tr>
            <td colspan='2' style='background-color:#f1f1f1; padding:12px; font-weight:bold; text-align:left; border:1px solid #ddd;'>
                Leave Application Summary
            </td>
        </tr>
        <tr>
            <td style='width:40%; padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Applicant</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$applicantName}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Leave Type</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->type}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Start Date</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->start_date}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>End Date</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->end_date}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Status</td>
            <td style='padding:10px; border:1px solid #ddd; text-transform:capitalize;'>{$leave->status}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Manager Comment</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$managerComment}</td>
        </tr>
    </table>
";


    // Notify user
    app(EmailController::class)->notifyUser(
        $leave->user,
        'Your Leave Application Has Been Updated',
        "Dear {$applicantName},<br><br>Your leave application has been updated and resubmitted for review.<br><br>{$leaveDetailsTable}<br>HR will review your request shortly."
    );

    // Notify admins
    app(EmailController::class)->notifyAdmins(
        $leave->company,
        'An Employee Has Updated Their Leave Application',
        "Hello Admin,<br><br>{$applicantName} has updated their leave request. Please review:<br><br>{$leaveDetailsTable}",
        'Review Now',
        route('manage.leave')
    );

    return redirect()->route('apps.leave')->with('success', 'Leave application updated and resubmitted.');
}



public function cancel($id)
{
    $leave = Leave::where('user_id', Auth::id())->findOrFail($id);

    if ($leave->status === 'pending') {
        $leave->update(['status' => 'cancelled']);

       $applicantName = $leave->user->first_name . ' ' . $leave->user->last_name;
       $managerComment = $leave->manager_comment;
        $leaveDetailsTable = "
    <table cellpadding='0' cellspacing='0' width='100%' style='max-width:600px; border-collapse:collapse; font-family:Arial, sans-serif; font-size:14px; color:#333; margin:auto;'>
        <tr>
            <td colspan='2' style='background-color:#f1f1f1; padding:12px; font-weight:bold; text-align:left; border:1px solid #ddd;'>
                Leave Application Summary
            </td>
        </tr>
        <tr>
            <td style='width:40%; padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Applicant</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$applicantName}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Leave Type</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->type}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Start Date</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->start_date}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>End Date</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->end_date}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Status</td>
            <td style='padding:10px; border:1px solid #ddd; text-transform:capitalize;'>{$leave->status}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Manager Comment</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$managerComment}</td>
        </tr>
    </table>
";


        // Message for the user
        $userSubject = 'Your Leave Application Cancelled';
        $userMessage = "
            Dear {$applicantName},<br><br>
            You have successfully <strong>cancelled</strong> your leave application.<br><br>
            <strong>Leave Details:</strong><br>
            {$leaveDetailsTable}
            <br>
            If you have any questions, please contact HR.
        ";

        // Message for the admins
        $adminSubject = 'Employee Leave Application Cancelled';
        $adminMessage = "
            Hello Admin,<br><br>
            The following leave application has been <strong>cancelled</strong> by <strong>{$applicantName}</strong>:<br><br>
            {$leaveDetailsTable}
            <br>
            Please update your records accordingly.
        ";

        app(EmailController::class)->notifyUser($leave->user, $userSubject, $userMessage);
        app(EmailController::class)->notifyAdmins($leave->company, $adminSubject, $adminMessage, 'View Leave', route('manage.leave'));
    }

    return redirect()->back()->with('success', 'Leave application cancelled.');
}


    public function destroy($id)
    {
        $leave = Leave::where('user_id', Auth::id())->findOrFail($id);

        if ($leave->status === 'pending') {
            $leave->delete();
        }

        if ($leave->status === 'approved') {
            return redirect()->back()->with('error', 'You cannot delete an approved leave application.');
        }

        if ($leave->status === 'rejected') {
            return redirect()->back()->with('error', 'You cannot delete a rejected leave application.');
        }

        if ($leave->status === 'cancelled') {
            return redirect()->back()->with('error', 'You cannot delete a cancelled leave application.');
        }

        // If we reach here, the leave is pending and can be deleted
        $leave->delete();

        return redirect()->back()->with('success', 'Leave application deleted.');
    }

    // Manager: View all leave requests for their branch/company
    public function manage()
    {
        $user = Auth::user();
        $leaves = Leave::where('company_id', $user->company_id)->latest()->get();
        return view('apps.leave.index', compact('leaves'));
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

    $applicantName = $leave->user->first_name . ' ' . $leave->user->last_name;
    $managerComment = $leave->manager_comment;

    $leaveDetailsTable = "
    <table cellpadding='0' cellspacing='0' width='100%' style='max-width:600px; border-collapse:collapse; font-family:Arial, sans-serif; font-size:14px; color:#333; margin:auto;'>
        <tr>
            <td colspan='2' style='background-color:#f1f1f1; padding:12px; font-weight:bold; text-align:left; border:1px solid #ddd;'>
                Leave Application Summary
            </td>
        </tr>
        <tr>
            <td style='width:40%; padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Applicant</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$applicantName}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Leave Type</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->type}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Start Date</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->start_date}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>End Date</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$leave->end_date}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Status</td>
            <td style='padding:10px; border:1px solid #ddd; text-transform:capitalize;'>{$leave->status}</td>
        </tr>
        <tr>
            <td style='padding:10px; border:1px solid #ddd; background-color:#f9f9f9;'>Manager Comment</td>
            <td style='padding:10px; border:1px solid #ddd;'>{$managerComment}</td>
        </tr>
    </table>
";


    // User message
    $userSubject = 'Your Leave Application ' . ucfirst($request->status);
    $userMessage = "
        Dear {$applicantName},<br><br>
        Your leave application has been <strong>{$request->status}</strong> by your manager.<br><br>
        <strong>Leave Details:</strong><br>
        {$leaveDetailsTable}
        <br>
        If you have any questions, please contact HR.
    ";

    // Admin message
    $adminSubject = 'Employee Leave Application ' . ucfirst($request->status);
    $adminMessage = "
        Hello Admin,<br><br>
        The following leave application has been <strong>{$request->status}</strong>:<br><br>
        {$leaveDetailsTable}
        <br>
        Please take note for your records.
    ";

    app(EmailController::class)->notifyUser($leave->user, $userSubject, $userMessage);
    app(EmailController::class)->notifyAdmins($leave->company, $adminSubject, $adminMessage, 'View Leave', route('manage.leave'));

    return back()->with('success', 'Leave application ' . $request->status . '.');
}

}