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
    public function showLoginIndex()
    {
        return view('auth.login');
    }


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
    // protected $redirectTo = '/login';

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

    // public function login(Request $request)
    // {
    //     $input = $request->all();

    //     $this->validate($request, [
    //         'username' => 'required',
    //         'password' => 'required',
    //     ]);

    //     $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    //     if (auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password']))) {


    //         if (auth()->user()->is_admin == 1) {
    //             if (Session::get('tempProject')) {

    //                 $content = new Request(['id' => Session::get('tempProject')]);

    //                 $transactionController = app()->make(Doclistings::class);
    //                 return $transactionController->editDocument($content);
    //             } else {
    //                 return redirect()->route('dashboard.index');
    //             }
    //         } else {
    //             if (Session::get('tempProject')) {

    //                 $content = new Request(['id' => Session::get('tempProject')]);
    //                 $this->docController->editDocument($content);
    //             } else {
    //                 return redirect()->route('dashboard.index');
    //             }
    //         }
    //     } else {

    //         // return redirect()->route('dashboard.index');
    //         //     ->with('error','Email-Address And Password Are Wrong.');
    //         return redirect()->back()->withErrors('SAP-ID or Password Wrong.');
    //     }
    // }

    public function login(Request $request)
    {
        $encryptedUsername = $request->input('username');
        $encryptedUserPassword = $request->input('password');
        $decodedUserName = base64_decode($encryptedUsername);
        $decodedUserPassword = base64_decode($encryptedUserPassword);
    
        $input = $request->all();
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (auth()->attempt([$fieldType => $decodedUserName, 'password' =>  $decodedUserPassword])) {
            if (auth()->user()->is_admin == 1) {
                return $this->handleAdminLogin();
            } else {
                return $this->handleNonAdminLogin();
            }
        } else {

            return view('auth.login', ['message' => 'SAP-ID or Password Wrong.']);
            // return redirect()back()->withErrors('SAP-ID or Password Wrong.');
        }
    }
    protected function handleAdminLogin()
    {
        if (Session::get('tempProject')) {
            $content = new Request(['id' => Session::get('tempProject')]);
            $transactionController = app()->make(Doclistings::class);
            return $transactionController->editDocument($content);
        } else {
            return redirect()->route('dashboard.index');
        }
    }
    protected function handleNonAdminLogin()
    {
        if (Session::get('tempProject')) {
            $content = new Request(['id' => Session::get('tempProject')]);
            $this->docController->editDocument($content);
        } else {
            return redirect()->route('dashboard.index');
        }
    }
}
