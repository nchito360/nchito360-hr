<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function attendance()
    {
        return view('apps.attendance.index');
    }

    public function overtime()
    {
        return view('apps.overtime.index');
    }

    public function payroll()
    {
        return view('apps.payroll.index');
    }

    public function cashRequest()
    {
        return view('apps.cash_request.index');
    }

    public function leave()
    {
        return app()->call('App\Http\Controllers\LeaveController@index');
        // return view('apps.leave.employee.index'); // Assuming leave view is here
    }

    public function otherApps()
    {
        return view('apps.other.index'); // Optional fallback
    }
}
