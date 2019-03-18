<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param  App\Http\Requests\LoginRequest  $request
	 * @param  Guard  $auth
	 * @return Response
	 */
	public function postLogin (LoginRequest $request, Guard $auth)
    {
        $throttles = in_array(ThrottlesLogins::class, class_uses_recursive(get_class($this)));

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
			return redirect('/auth/login')
				->with('error', trans('front/login.max'))
				->withInput($request->only('email'));
        }

		$credentials = [
            'email'     => $request->input('email'),
			'password'  => $request->input('password')
		];

		if (!$auth->validate($credentials)) {
			if ($throttles) {
	            $this->incrementLoginAttempts($request);
	        }

			return redirect('/auth/login')
				->with('error', trans('front/login.invalid'))
				->withInput($request->only('email'));
		}

		$user = $auth->getLastAttempted();

		if ($user->confirmed) {
			if ($throttles) {
                $this->clearLoginAttempts($request);
            }

			$auth->login($user, $request->has('memory'));

			if ($request->session()->has('user_id'))	{
				$request->session()->forget('user_id');
			}

			return redirect('/');
		}
		
		$request->session()->put('user_id', $user->id);	

		return redirect('/auth/login')->with('error', trans('front/verify.again'));			
	}
}
