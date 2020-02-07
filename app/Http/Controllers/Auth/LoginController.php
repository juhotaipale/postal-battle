<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Player;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username(): string
    {
        return 'name';
    }

    public function showLoginForm(): View
    {
        return view('index');
    }

    protected function validateLogin(Request $request): void
    {
        $this->validate($request, [
            $this->username() => 'required|string',
        ]);

        $this->createIfNotExist($request->get($this->username()));
    }

    protected function createIfNotExist(string $name): void
    {
        Player::firstOrCreate([
            'name' => $name,
        ]);
    }

    protected function credentials(Request $request): array
    {
        return array_merge($request->only($this->username()));
    }
}
