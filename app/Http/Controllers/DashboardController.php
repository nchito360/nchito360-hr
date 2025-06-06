<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\JoinCompanyRequest;
use App\Models\User;


use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | EMPLOYEE SECTION
    |--------------------------------------------------------------------------
    */

    public function employeeDashboard() {
        return view('employee.dashboard');
    }

    // Company
    public function employeeCompanyOverview()
{
    $user = auth()->user();
    $company = $user->company;
    // $company = auth()->user()->company; // or however you're getting the company

    $users = $company ? $company->users : collect(); // Get all users in the same company or an empty collection if no company
    

    $joinRequests = JoinCompanyRequest::where('user_id', $user->id)->with('company')->latest()->get();

        return view('employee.company.overview', [
            'company' => $user->company,
            'teamMembers' => $user->company ? $user->company->users : collect(),
            'currentRole' => $user->position,
            'currentDepartment' => $user->department,
            'currentBranch' => $user->branch,
            'joinRequests' => $joinRequests,
            'users' => $users
        ]);
    }


public function manageCompany()
{
    $user = auth()->user();
    $company = $user->company;

    if (!$company) {
        return redirect()->back()->with('error', 'No company associated with your account.');
    }

    // Only fetch join requests if the user is admin (you can define this logic better)
    $joinRequests = JoinCompanyRequest::where('company_id', $company->id)->where('status', 'pending')->with('user')->get();

    return view('employee.company.manage', compact('company', 'joinRequests'));
}

public function showRegisterCompanyForm()
{
    return view('employee.company.register');
}

public function registerCompany(Request $request)
{
    $request->validate([
        'organization_name' => 'required|string|max:255',
        'logo' => 'nullable|url',
        'description' => 'nullable|string',
        'industry' => 'nullable|string|max:255',
        'branches' => 'nullable|array',
        'departments' => 'nullable|array',
        'website' => 'nullable|url',
        'email' => 'required|email|max:255',
    ]);

    $company = \App\Models\Company::create([
        'organization_name' => $request->organization_name,
        'logo' => $request->logo,
        'description' => $request->description,
        'industry' => $request->industry,
        'branches' => $request->branches,
        'departments' => $request->departments,
        'website' => $request->website,
        'email' => $request->email,
        'company_code' => strtoupper(\Illuminate\Support\Str::random(8)), // Generate a random company code
    ]);

    $user = auth()->user();
    $user->company_id = $company->id;
    $user->save();

    return redirect()->route('employee.company.manage')->with('success', 'Company registered successfully.');
}

public function updateCompany(Request $request)
{
    $user = auth()->user();
    $company = $user->company;

    if (!$company) {
        return redirect()->back()->with('error', 'No company associated with your account.');
    }

    $request->validate([
        'organization_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'industry' => 'nullable|string|max:255',
        'website' => 'nullable|url',
        'description' => 'nullable|string',
        'branches' => 'nullable|string',
        'departments' => 'nullable|string',
        'company_code' => 'nullable|string|max:255',
    ]);

    $company->update([
        'organization_name' => $request->organization_name,
        'email' => $request->email,
        'industry' => $request->industry,
        'website' => $request->website,
        'description' => $request->description,
        'branches' => $request->branches ? array_map('trim', explode(',', $request->branches)) : [],
        'departments' => $request->departments ? array_map('trim', explode(',', $request->departments)) : [],
        'company_code' => $request->company_code,
    ]);

    return redirect()->back()->with('success', 'Company updated successfully.');
}



public function requestToJoinCompany(Request $request)
{
    $request->validate([
        'company_code' => 'required|string|max:255',
    ]);

    $company = Company::where('company_code', $request->company_code)->first();

    if (!$company) {
        return back()->with('error', 'Invalid company code.');
    }

    $existing = \App\Models\JoinCompanyRequest::where('user_id', auth()->id())
        ->where('company_id', $company->id)
        ->where('status', 'pending')
        ->first();

    if ($existing) {
        return back()->with('info', 'You have already requested to join this company.');
    }

    JoinCompanyRequest::create([
        'user_id' => auth()->id(),
        'company_id' => $company->id,
        'status' => 'pending',
    ]);

    // Optionally notify company admins...

    

    return back()->with('success', 'Your request to join the company has been submitted.');
}


public function switchCompany(Request $request)
{
    $request->validate([
        'switch_company_code' => 'required|string|max:255',
    ]);

    $company = Company::where('company_code', $request->switch_company_code)->first();

    if (!$company) {
        return back()->with('error', 'Company code not found.');
    }

    $user = auth()->user();
    $user->company_id = $company->id;
    $user->save();

    return back()->with('success', 'You have successfully switched companies.');
}


public function leaveCompany()
{
    $user = auth()->user();

    // Example logic: disassociate the user from the company
    $user->company_id = null;
    $user->save();

    return back()->with('success', 'You have left the company.');
}

     public function employeeCompanyTeam() {
        return view('employee.company.team');
    }

    public function employeeCompanyBranches() {
        return view('employee.company.branches');
    }

    public function employeeCompanyDepartments() {
        return view('employee.company.departments');
    }

    // Team
    public function employeeTeamMembers() {
        return view('employee.team.members');
    }

    public function employeeTeamRoles() {
        return view('employee.team.roles');
    }

    public function employeeTeamInvitations() {
        return view('employee.team.invitations');
    }

    // Branches
    public function employeeBranchesOverview() {
        return view('employee.branches.overview');
    }

    public function employeeBranchesSettings() {
        return view('employee.branches.settings');
    }

    public function employeeBranchesCreate() {
        return view('employee.branches.create');
    }

    // Departments
    public function employeeDepartmentsOverview() {
        return view('employee.departments.overview');
    }

    public function employeeDepartmentsSettings() {
        return view('employee.departments.settings');
    }

    public function employeeDepartmentsCreate() {
        return view('employee.departments.create');
    }

    // Profile
   public function employeeProfileOverview()
{
    $user = auth()->user();
    return view('employee.profile.overview', compact('user'));
}

public function employeeUpdateProfile(Request $request)
{
    $user = auth()->user();

    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'position' => 'nullable|string|max:255',
        'department' => 'nullable|string|max:255',
        'branch' => 'nullable|string|max:255',
        'profile_picture' => 'nullable|image|max:10048',
    ]);

    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/profiles'), $filename);
        $validated['profile_picture'] = $filename;
    }

    $user->update($validated);

    return back()->with('success', 'Profile updated successfully.');
}


    public function employeeProfileSettings() {
        return view('employee.profile.settings');
    }

    public function employeeProfileNotifications() {
        return view('employee.profile.notifications');
    }

    // Account
    public function employeeAccountOverview() {
        return view('employee.account.overview');
    }

     public function employeeAccountProfile() {
        return view('employee.account.profile');
    }

    public function employeeAccountBilling() {
        return view('employee.account.billing');
    }

    public function employeeAccountSecurity() {
        return view('employee.account.security');
    }

    public function employeeSupport() {
        return view('employee.support');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN SECTION
    |--------------------------------------------------------------------------
    */

    public function adminDashboard() {
        return view('admin.dashboard');
    }

    // Company
    public function adminCompanyTeam() {
        return view('admin.company.team');
    }

    public function adminCompanyBranches() {
        return view('admin.company.branches');
    }

    public function adminCompanyDepartments() {
        return view('admin.company.departments');
    }

    // Team
    public function adminTeamMembers() {
        return view('admin.team.members');
    }

    public function adminTeamRoles() {
        return view('admin.team.roles');
    }

    public function adminTeamInvitations() {
        return view('admin.team.invitations');
    }

    // Branches
    public function adminBranchesOverview() {
        return view('admin.branches.overview');
    }

    public function adminBranchesSettings() {
        return view('admin.branches.settings');
    }

    public function adminBranchesCreate() {
        return view('admin.branches.create');
    }

    // Departments
    public function adminDepartmentsOverview() {
        return view('admin.departments.overview');
    }

    public function adminDepartmentsSettings() {
        return view('admin.departments.settings');
    }

    public function adminDepartmentsCreate() {
        return view('admin.departments.create');
    }

    // Profile
    public function adminProfileOverview() {
        return view('admin.profile.overview');
    }

    public function adminProfileSettings() {
        return view('admin.profile.settings');
    }

    public function adminProfileNotifications() {
        return view('admin.profile.notifications');
    }

    // Account
    public function adminAccountProfile() {
        return view('admin.account.profile');
    }

    public function adminAccountBilling() {
        return view('admin.account.billing');
    }

    public function adminAccountSecurity() {
        return view('admin.account.security');
    }

    public function adminSupport() {
        return view('admin.support');
    }
}
