<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    // Employee: View all their leaves
     public function index()
{
    $user = auth()->user();
    $leaves = Leave::where('user_id', $user->id)->get();
    $declinedLeaves = Leave::where('user_id', auth()->id())
        ->where('status', 'declined')
        ->get();
    $appliedLeaves = Leave::where('user_id', Auth::id())->latest()->get();
    

    

    return view('apps.leave.employee.index', [
        'leaves' => $leaves,
        'declinedLeaves' => $declinedLeaves,
        'user' => $user,
        'appliedLeaves' => $appliedLeaves,
    ]);

}


    public function apply()
    {
        $leaves = Leave::where('user_id', Auth::id())->latest()->get();
        return view('apps.leave.employee.apply', compact('leaves'));
    }

    public function approve($id)
{
    $leave = LeaveApplication::findOrFail($id);
    $leave->status = 'approved';
    $leave->manager_comment = 'Approved';
    $leave->save();

    return redirect()->back()->with('success', 'Leave application approved.');
}

public function reject(Request $request, $id)
{
    $leave = LeaveApplication::findOrFail($id);
    $leave->status = 'rejected';
    $leave->manager_comment = $request->input('manager_comment');
    $leave->save();

    return redirect()->back()->with('success', 'Leave application rejected with comment.');
}


    // Employee: Store leave request
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

         app(EmailController::class)->sendLeaveApplied($leave);

        return redirect()->back()->with('success', 'Leave request submitted.');
    }

    // Employee: Edit a leave (if declined)
    public function edit(Leave $leave)
    {
        $this->authorize('update', $leave); // Optional: use policies
        return view('apps.leave.employee.edit', compact('leave'));
    }

    // Employee: Update leave
    public function update(Request $request, Leave $leave)
    {
        $this->authorize('update', $leave);

        $request->validate([
            'leave_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:1000',
        ]);

        $leave->update($request->only(['leave_type', 'start_date', 'end_date', 'reason']));
        return redirect()->route('leave.index')->with('success', 'Leave updated.');
    }

    public function cancel($id)
    {
        $leave = Leave::where('user_id', Auth::id())->findOrFail($id);

        if ($leave->status === 'pending') {
            $leave->update(['status' => 'cancelled']);
        }

        return redirect()->back()->with('success', 'Leave application cancelled.');
    }

    public function destroy($id)
    {
        $leave = Leave::where('user_id', Auth::id())->findOrFail($id);

        if ($leave->status === 'pending') {
            $leave->delete();
        }

        return redirect()->back()->with('success', 'Leave application deleted.');
    }

    // Manager: View all leave requests for their branch/company
    public function manage()
    {
        $user = Auth::user();
        $leaves = Leave::where('company_id', $user->company_id)->latest()->get();
        return view('apps.leave.employee.manage', compact('leaves'));
    }

    // Manager: Approve or reject leave
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

        return back()->with('success', 'Leave application ' . $request->status . '.');
    }
}
