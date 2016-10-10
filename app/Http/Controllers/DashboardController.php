<?php namespace Ecep\Http\Controllers;

use Ecep\Http\Requests;
use Ecep\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function getIndex()
    {
        return view('dashboard');
    }

    public function getInfo()
    {
        return view('info');
    }

    public function getPermission()
    {
        return view('permission');
    }
}
