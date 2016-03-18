<?php namespace Ale\Http\Controllers;

use Ale\Http\Requests;
use Ale\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function getIndex()
    {
		$givename = 'GIVENNAME';
		$surname = 'SURNAME';
		$subject = $_SERVER['HTTP_RENIECSUBJECTDN'];
		$name = substr($subject, strpos($subject, $givename) + strlen($givename) + 1);
		$name = substr($name, 0, strpos($name, ','));
		$lastname = substr($subject, strpos($subject, $surname) + strlen($surname) + 1);
		$lastname = substr($lastname, 0, strpos($lastname, ','));
		
        return view('dashboard')->with('names', $name);
    }
}
