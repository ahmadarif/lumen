<?php

namespace App\Http\Middleware;

use App\Http\Models\User;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Response;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {

            if ($request->hasHeader('Token')) {
                $token = $request->header('Token');
                $user = User::where('token', $token)->first();
                if ($user == null) {
                    $res['success'] = false;
                    $res['message'] = 'Token is invalid!';
                    return response($res, Response::HTTP_UNAUTHORIZED);
                }
            } else {
                $res['success'] = false;
                $res['message'] = 'Login please!';
                return response($res, Response::HTTP_UNAUTHORIZED);
            }
        }

        return $next($request);
    }
}