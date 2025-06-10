<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;

class TeamController extends Controller
{
    public function index()
    {
        return view('dashboard.index'); // Update with your dashboard view
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'position' => 'nullable|string|max:255',
        'privileges' => 'required|in:departmental,notifications,full,none,suspended,delete',
        'department' => 'nullable|string|max:255',
        'branch' => 'nullable|string|max:255',
    ]);

    $user = User::findOrFail($id);
    $company = $user->company;

    // Protect the owner from being deleted or suspended
    if ($company && $company->owner_id === $user->id) {
        return back()->with('error', 'You cannot modify or remove the company owner.');
    }

    if ($request->privileges === 'delete') {
        $user->delete();
        return back()->with('success', 'User removed from company.');
    }

    $user->position = $request->position;
    $user->department = $request->department;
    $user->branch = $request->branch;
    $user->privileges = $request->privileges;

    if ($request->privileges === 'suspended') {
        $user->status = 'suspended';
    }

    $user->save();

    return back()->with('success', 'User updated successfully.');
}





}
