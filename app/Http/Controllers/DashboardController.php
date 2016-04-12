<?php namespace Ecep\Http\Controllers;

use Ecep\Http\Requests;
use Ecep\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function getIndex(Request $request)
    {

//        dd($request->session()->all());
//        $wData = array_key_exists('HTTP_RENIECSUBJECTDN', $_SERVER);
//
//        if ($wData) {
//            $givename = 'GIVENNAME';
//            $surname = 'SURNAME';
//            $subject = $_SERVER['HTTP_RENIECSUBJECTDN'];
//            $name = substr($subject, strpos($subject, $givename) + strlen($givename) + 1);
//            $name = substr($name, 0, strpos($name, ','));
//            $lastname = substr($subject, strpos($subject, $surname) + strlen($surname) + 1);
//            $lastname = substr($lastname, 0, strpos($lastname, ','));
//
//        } else {
//            $name = '------------';
//        }


        return view('dashboard')->with('names', '');
    }

    public function getPermission()
    {
        return view('permission');
    }
}
