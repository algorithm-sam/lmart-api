<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Firebase\JWT\JWT;
use \DomainException;
use \Firebase\JWT\ExpiredException;
use \Firebase\JWT\SignatureInvalidException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            // check if the token is in the header,post or a get variable then authenticate appropriately else return null;
            if ($request->input('api_token')) {
                // decode token
                $token = $request->input('api_token');
            } else if ($request->header('api_token')) {
                $token = $request->header('api_token');
            } else {
                return null;
            }
            $user = $this->decodeToken($token);
            if ($user) {
                $user = User::where('email', '=', $user->email)->first();
                if (!$user) return null;

                $validToken = $user->tokens()->where('token', $token)->first();
                if (!$validToken) return null;

                return $user;
            } else {
                return null;
            }
        });
    }

    public function decodeToken($token)
    {
        try {
            $decoded_data = JWT::decode($token, env('APP_KEY'), ['HS256']);
        } catch (ExpiredException $e) {
            return null;
        } catch (SignatureInvalidException $e) {
            return null;
        } catch (DomainException $e) {
            return null;
        }
        return $decoded_data->data;
    }
}
