<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\JoinCompanyRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EmailController;


use App\Models\User;


class CompanyController extends Controller
{


public function requestToJoinCompany(Request $request)
{
    $request->validate([
        'company_code' => 'required|exists:companies,company_code',
    ], [
        'company_code.exists' => 'The company code you entered does not exist.',
    ]);

    $company = Company::where('company_code', $request->company_code)->firstOrFail();
    $user = Auth::user();
    

    $exists = JoinCompanyRequest::where('user_id', auth()->id())
        ->where('company_id', $company->id)
        ->where('status', 'pending')
        ->exists();

    if (!$exists) {
        
        JoinCompanyRequest::create([
            'user_id' => auth()->id(),
            'company_id' => $company->id,
            'status' => 'pending',
        ]);

         app(EmailController::class)->sendJoinCompanyNotification($user, $company);

        return back()->with('success', 'Join request sent.');
    } else {
        return back()->with('error', 'You have already sent a join request to this company.');
    }
}



public function cancelJoinRequest($id)
{
    $request = JoinCompanyRequest::where('id', $id)
        ->where('user_id', auth()->id())
        ->where('status', 'pending')
        ->firstOrFail();

    $request->delete();

    return back()->with('success', 'Join request canceled.');
}


public function approveJoinRequest($id)
{
    $joinRequest = JoinCompanyRequest::findOrFail($id);
    $joinRequest->update(['status' => 'approved']);

    $user = $joinRequest->user;
    $user->company_id = $joinRequest->company_id;
    $user->save();

    return back()->with('success', 'Request approved.');
}

public function rejectJoinRequest($id)
{
    $joinRequest = JoinCompanyRequest::findOrFail($id);
    $joinRequest->update(['status' => 'rejected']);

    return back()->with('success', 'Request rejected.');
}




    // ========== Manage Company - Overview ==========
    public function overview()
    {
        $company = Auth::user()->company;
        return view('applications.company.overview', compact('company'));
    }

    // ========== Manage Company - Settings ==========
    public function settings()
    {
        $company = Auth::user()->company;
        return view('applications.company.settings', compact('company'));
    }

    // ========== Manage Company - Billing ==========
    public function billing()
    {
        // Assuming you have a billing system or logic in place
        $company = Auth::user()->company;
        return view('applications.company.billing', compact('company'));
    }

    // ========== Manage Company - Help & Support ==========
    public function helpSupport()
    {
        return view('applications.company.help-support');
    }

    // ========== Companies - Create Company ==========
    public function createCompany(Request $request)
    {
        $data = $request->validate([
            'organization_name' => 'required|string',
        ]);

        // Create the company
        $company = Company::create([
            'organization_name' => $data['organization_name'],
            'branches' => [],
            'departments' => [],
        ]);

        // Assign the company to the logged-in user
        $user = Auth::user();
        $user->company_id = $company->id;
        $user->organization = $company->organization_name;
        $user->save();

        return back()->with('success', 'Company created.');
    }

    // ========== Companies - Get All Companies ==========
    public function getAllCompanies()
    {
        $companies = Company::all();
        return response()->json($companies);
    }

    // ========== Companies - Edit Company ==========
    public function editCompany($id)
    {
        $company = Company::findOrFail($id);
        return view('applications.company.edit', compact('company'));
    }

    // ========== Companies - Update Company ==========
    public function updateCompany(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $data = $request->validate([
            'organization_name' => 'required|string',
        ]);

        $company->update([
            'organization_name' => $data['organization_name'],
        ]);

        return redirect()->route('applications.company.overview')->with('success', 'Company information updated.');
    }

    // ========== Companies - Delete Company ==========
    public function deleteCompany($id)
    {
        $company = Company::findOrFail($id);
        
        // Optional: Remove all associated data such as users, branches, departments before deleting
        $company->delete();

        return back()->with('success', 'Company deleted.');
    }

}
