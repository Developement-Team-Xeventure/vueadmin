<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Passport\Token;
use Symfony\Component\HttpFoundation\Response;

class BearerTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader &&  Str::startsWith($authorizationHeader, 'Bearer ')) {
            $bearerToken = substr($authorizationHeader, 7);
            $auth_header = explode(' ', $bearerToken);
            $token = $auth_header[0];
            $token_parts = explode('.', $token);
            $token_header = $token_parts[1];
            $token_header_json = base64_decode($token_header);
            $token_header_array = json_decode($token_header_json, true);
            $token_id = $token_header_array['jti'];
            $user = Token::find($token_id)->user;

            $company = Company::where(['user_id'=>$user->id,'open_status'=>1,'active_status'=>1])->first();
            //  at a time one company open case
            $request->merge(
                [
                    'bearerToken' => $bearerToken,
                    'bearerTokenUser' => $user??null,
                    'openCompany' => $company->id,
                    ]
            );
        }

        return $next($request);
    }
}
