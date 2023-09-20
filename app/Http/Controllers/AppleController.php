<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Firebase\JWT\JWT;

class AppleController extends Controller
{
    //
    public function getAppletoken(Request $request)
    {
        //dd('coming');
        $authCode = $request->input('code');
        dd($authCode);

        if ($authCode) {
        $authKey = file_get_contents(public_path().'/AuthKey_M238SUURDQ.p8');

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
                'aud' => 'https://appleid.apple.com',
                'sub' => 'Y3EW23KC44', // Replace with your own client ID
                'at_hash' => $authCode
            ];

            // Create the JWT token
            $jwtToken = JWT::encode($payload, $authKey, 'ES256', null, $header);
dd($jwtToken);
            // Return the client secret to the client app
            return response()->json(['client_secret' => $jwtToken]);
        }
    }
}
