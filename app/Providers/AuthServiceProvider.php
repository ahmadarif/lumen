<?php

namespace App\Providers;

use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot() {
        $this->app['auth']->viaRequest('api', function (Request $request) {
            if ($request->header('Token')) {
                return User::where('token', $request->header('token'))->first();
            }
        });
    }
}