<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Doclistings;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $docController;
    public function __construct(Doclistings $docController)
    {
        $this->middleware('guest')->except('logout');
        $this->docController = $docController;
    }

    public function login(Request $request)
    {

        $input = $request->all();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password']))) {
        

            if (auth()->user()->is_admin == 1) {
                if (Session::get('tempProject')) {
                   
                    $content = new Request(['id' => Session::get('tempProject')]);

                    $transactionController = app()->make(Doclistings::class);
                    return $transactionController->editDocument($content);
                    
                } else {
                  

                    return redirect()->route('dashboard.index');
                }
            } else {
                if (Session::get('tempProject')) {
                 
                    $content = new Request(['id' => Session::get('tempProject')]);
                    $this->docController->editDocument($content);
                } else {
                 
                    return redirect()->route('dashboard.index');
                }
            }
        } else {
            // return redirect()->route('login')
            //     ->with('error','Email-Address And Password Are Wrong.');
            return Redirect::back()->withErrors('SAP-ID or Password Wrong.');
        }
    }
}
