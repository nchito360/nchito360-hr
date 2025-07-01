<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class AppController extends Controller
{
    public function attendance()
    {
        return view('apps.no-app');
    }

    public function overtime()
    {
        return view('apps.no-app');
    }

    public function payroll()
    {
        return view('apps.no-app');
    }

    public function cashRequest()
    {
        return view('apps.no-app');
    }

public function leave()
{
    $user = auth()->user();

    // Check if the user is not associated with any company
    if (is_null($user->company_id)) {
        return view('apps.no-app'); // A view telling the user they need to join or create a company
    }

    // Otherwise, show the leave dashboard
    return app()->call('App\Http\Controllers\LeaveController@index');
}


    public function otherApps()
    {
        return view('apps.no-app'); // Optional fallback
    }
}



// class AppController extends Controller
// {
//     public function attendance()
//     {
//         return view('apps.attendance.index');
//     }

//     public function overtime()
//     {
//         return view('apps.overtime.index');
//     }

//     public function payroll()
//     {
//         return view('apps.payroll.index');
//     }

//     public function cashRequest()
//     {
//         return view('apps.cash_request.index');
//     }

//     public function leave()
//     {
//         return app()->call('App\Http\Controllers\LeaveController@index');
//         // return view('apps.leave.employee.index'); // Assuming leave view is here
//     }

//     public function otherApps()
//     {
//         return view('apps.other.index'); // Optional fallback
//     }
// }
