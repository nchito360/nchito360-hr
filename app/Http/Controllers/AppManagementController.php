<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;



class AppManagementController extends Controller
{
 
public function manageLeave()
{
    $allLeaves = Leave::with('user')->get();

    return view('apps.manage.leave.index', compact('allLeaves'));
}



    
    public function managePayroll()
    {
        return view('apps.manage.payroll.index');
    }

    public function manageAttendance()
    {
        return view('apps.manage.attendance.index');
    }

    public function manageOvertime()
    {
        return view('apps.manage.overtime.index');
    }

    public function manageCashRequest()
    {
        return view('apps.manage.cash_request.index');
    }

    public function manageEmployees()
    {
        return view('apps.manage.employees.index');
    }
}
