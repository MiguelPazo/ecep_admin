<?php namespace Ale\Http\Controllers;

use Ale\Http\Requests;
use Ale\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function getIndex()
    {
        return view('dashboard');
    }
}
