<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /* Customer Dashboard */

    public function index()
    {

        return view('pages.dashboard.index');
    }

}
