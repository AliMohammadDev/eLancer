<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    protected $guard = 'web';

    public function __construct(Request $request)
    {
        if ($request->is('admin/*')) {
            $this->guard = 'admin';
        }
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login', [
            'routePrefix' => $this->guard == 'admin' ? 'admin' : '',
        ]);

    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        // Auth::attempt([
        //     'email'=>$request->email,
        //     'password'=>$request->password
        // ]);

        // $user = User::where('email',$request->post('email'))->first();
        // if(!$user || !Hash::check($request->post('password',$user->password))){
        //     throw ValidationException::withMessage([
        //         'email'=>'Invalid Credentials'
        //     ]);
        // }
        // Auth::login($user);

        $request->authenticate($this->guard);

        $request->session()->regenerate();

        return redirect()->intended(
            $this->guard == 'admin' ? 'dashboard/categories' :
              RouteServiceProvider::HOME
        );
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard($this->guard)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
