<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AppleSSOMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $authCode = $request->input('code');

        if ($authCode) {
            // Get the contents of the authkey P8 file
            $authKey = file_get_contents(asset('/AuthKey_M238SUURDQ.p8'));

            // Set the required header fields for the JWT token
            $header = [
                'kid' => 'M238SUURDQ', // Replace with your own key ID
                'alg' => 'ES256'
            ];

            // Set the required payload fields for the JWT token
            $payload = [
                'iss' => 'Y3EW23KC44', // Replace with your own team ID
                'iat' => time(),
                'exp' => time() + 86400, // Token is valid for 24 hours
                'aud' => 'https://fan2stage.colanapps.in',
                'sub' => 'Y3EW23KC44', // Replace with your own client ID
                'at_hash' => $authCode
            ];

            // Create the JWT token
            $jwtToken = JWT::encode($payload, $authKey, 'ES256', null, $header);

            // Return the client secret to the client app
            return response()->json(['client_secret' => $jwtToken]);
        }

        return $next($request);
    }
}
