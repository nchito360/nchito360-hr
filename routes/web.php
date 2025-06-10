<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AppManagementController;


Route::get('/test-email', function () {
    Mail::raw('Test email content', function ($message) {
        $message->to('katongobupe444@gmail.com')
                ->subject('Test Email');
    });

    return 'Email sent!';
});

Route::get('/', function () {
    return redirect()->route('login.form');
});


Route::middleware(['auth'])->group(function () {

    // Employee routes
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave.index');
    Route::get('/leave', [LeaveController::class, 'apply'])->name('leave.apply');
    Route::post('/leave', [LeaveController::class, 'store'])->name('leave.apply');
    Route::get('/leave/{leave}/edit', [LeaveController::class, 'edit'])->name('leave.edit');
    Route::put('/leave/{leave}', [LeaveController::class, 'update'])->name('leave.update');
    Route::patch('/leave/{id}/cancel', [LeaveController::class, 'cancel'])->name('leave.cancel');
    Route::delete('/leave/{id}', [LeaveController::class, 'destroy'])->name('leave.destroy');

    // Manager routes
    Route::get('/leave/manage', [LeaveController::class, 'manage'])->name('leave.manage');
    Route::post('/leave/{leave}/approve', [LeaveController::class, 'approve'])->name('leave.approve');
    Route::post('/leave/{leave}/reject', [LeaveController::class, 'reject'])->name('leave.reject');
    Route::post('/leave/{leave}/status', [LeaveController::class, 'approveReject'])->name('leave.status');
});



// Authentication
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login.form');
    Route::post('login', 'login')->name('login');
    Route::get('register', 'showRegisterForm')->name('register.form');
    Route::post('register', 'register')->name('register');
    Route::post('logout', 'logout')->name('logout');

    // Route::get('select-company-mode', 'showCompanyModeSelection')->name('select-company-mode');


    Route::get('forgot-password', 'showForgotPasswordForm')->name('password.request');
    Route::post('forgot-password', 'sendResetLinkEmail')->name('password.email');
    Route::get('reset-password/{token}', 'showResetForm')->name('password.reset');
    Route::post('reset-password', 'resetPassword')->name('password.update');

    Route::get('email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::post('email/verification-notification', 'sendEmailVerification')
        ->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    Route::get('email/verify/{id}/{hash}', 'verifyEmail')
        ->middleware(['auth', 'signed'])->name('verification.verify');


});


/*
|--------------------------------------------------------------------------
| Employee Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'employeeDashboard'])->name('dashboard');

    // Company
     Route::get('/company/overview', [DashboardController::class, 'employeeCompanyOverview'])->name('company.overview');
    Route::get('/company/team', [DashboardController::class, 'employeeCompanyTeam'])->name('company.team');
    Route::get('/company/branches', [DashboardController::class, 'employeeCompanyBranches'])->name('company.branches');
    Route::get('/company/departments', [DashboardController::class, 'employeeCompanyDepartments'])->name('company.departments');

    // Route::post('/company/request-join', [CompanyController::class, 'requestToJoinCompany'])->name('company.request.join');
    Route::delete('/company/join-request/{id}/cancel', [CompanyController::class, 'cancelJoinRequest'])->name('company.request.cancel');

    Route::post('/company/switch', [CompanyController::class, 'switchCompany'])->name('company.switch');
    Route::post('/company/leave', [DashboardController::class, 'leaveCompany'])->name('company.leave');
    Route::get('/company/register', [DashboardController::class, 'showRegisterCompanyForm'])->name('company.register.form');
    Route::post('/company/register', [DashboardController::class, 'registerCompany'])->name('company.register');
    Route::put('/company/update', [DashboardController::class, 'updateCompany'])->name('company.update');
    Route::get('/company/manage', [DashboardController::class, 'manageCompany'])->name('company.manage');
    Route::get('/company/invite', [DashboardController::class, 'inviteToCompany'])->name('company.invite');
    Route::post('/company/invite', [DashboardController::class, 'sendCompanyInvitation'])->name('company.invite.send');


    Route::post('/company/join-request', [CompanyController::class, 'requestToJoinCompany'])->name('company.request.join');
    Route::post('/company/join-request/{id}/approve', [CompanyController::class, 'approveJoinRequest'])->name('company.request.approve');
    Route::post('/company/join-request/{id}/reject', [CompanyController::class, 'rejectJoinRequest'])->name('company.request.reject');
    Route::delete('/company/delete', [CompanyController::class, 'destroy'])->name('company.destroy');



    // Team
    Route::put('/team/{id}/update', [TeamController::class, 'update'])->name('team.update');
    Route::get('/team/members', [DashboardController::class, 'employeeTeamMembers'])->name('team.members');
    Route::get('/team/roles', [DashboardController::class, 'employeeTeamRoles'])->name('team.roles');
    Route::get('/team/invitations', [DashboardController::class, 'employeeTeamInvitations'])->name('team.invitations');

    // Branches
    Route::get('/branches/overview', [DashboardController::class, 'employeeBranchesOverview'])->name('branches.overview');
    Route::get('/branches/settings', [DashboardController::class, 'employeeBranchesSettings'])->name('branches.settings');
    Route::get('/branches/new', [DashboardController::class, 'employeeBranchesCreate'])->name('branches.create');

    // Departments
    Route::get('/departments/overview', [DashboardController::class, 'employeeDepartmentsOverview'])->name('departments.overview');
    Route::get('/departments/settings', [DashboardController::class, 'employeeDepartmentsSettings'])->name('departments.settings');
    Route::get('/departments/new', [DashboardController::class, 'employeeDepartmentsCreate'])->name('departments.create');

    // Profile
    Route::get('/profile/settings', [DashboardController::class, 'employeeProfileSettings'])->name('profile.settings');
    Route::get('/profile/notifications', [DashboardController::class, 'employeeProfileNotifications'])->name('profile.notifications');

    Route::get('/profile/overview', [DashboardController::class, 'employeeProfileOverview'])->name('profile.overview');
    Route::put('/profile/overview', [DashboardController::class, 'employeeUpdateProfile'])->name('profile.update');

    // Account
     Route::get('/account/overview', [DashboardController::class, 'employeeAccountOverview'])->name('account.overview');
    Route::get('/account/profile', [DashboardController::class, 'employeeAccountProfile'])->name('account.profile');
    Route::get('/account/billing', [DashboardController::class, 'employeeAccountBilling'])->name('account.billing');
    Route::get('/account/security', [DashboardController::class, 'employeeAccountSecurity'])->name('account.security');

    // Support
    Route::get('/support', [DashboardController::class, 'employeeSupport'])->name('support');
});


Route::prefix('apps')->name('apps.')->group(function () {
    Route::get('/attendance', [AppController::class, 'attendance'])->name('attendance');
    Route::get('/overtime', [AppController::class, 'overtime'])->name('overtime');
    Route::get('/payroll', [AppController::class, 'payroll'])->name('payroll');
    Route::get('/cash-request', [AppController::class, 'cashRequest'])->name('cash-request');
    Route::get('/leave', [AppController::class, 'leave'])->name('leave');
    Route::get('/other', [AppController::class, 'otherApps'])->name('other');
});

Route::prefix('manage')->middleware(['auth'])->group(function () {
    Route::get('/leave', [AppManagementController::class, 'manageLeave'])->name('manage.leave');
    Route::get('/payroll', [AppManagementController::class, 'managePayroll'])->name('manage.payroll');
    Route::get('/attendance', [AppManagementController::class, 'manageAttendance'])->name('manage.attendance');
    Route::get('/overtime', [AppManagementController::class, 'manageOvertime'])->name('manage.overtime');
    Route::get('/cash-request', [AppManagementController::class, 'manageCashRequest'])->name('manage.cash_request');
    Route::get('/employees', [AppManagementController::class, 'manageEmployees'])->name('manage.employees');
});



// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

