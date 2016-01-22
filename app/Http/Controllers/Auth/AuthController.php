<?php namespace Ale\Http\Controllers\Auth;

use Ale\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * The Guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;
    protected $request;

    public function __construct(Guard $auth, Registrar $registrar, Request $request)
    {
        $this->auth = $auth;
        $this->request = $request;

        $this->middleware('guest', ['except' => ['getLogout', 'postLogin']]);
    }

    public function getLogin()
    {
        return view('app');
    }

    public function postLogin()
    {
        $this->validate($this->request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $jResponse = [
            'success' => false,
            'message' => '',
            'url' => ''
        ];

        return response()->json($jResponse);
    }

    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : url('/admin');
    }

    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/';
    }

    public function getLogout()
    {
        Session::flush();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
}
