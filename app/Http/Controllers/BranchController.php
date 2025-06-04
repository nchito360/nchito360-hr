<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        return view('dashboard.index'); // Update with your dashboard view
    }
}
