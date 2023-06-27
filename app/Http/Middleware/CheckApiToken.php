<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    // {
    //     if ($request->header('Authorization')) {
    //         $token = str_replace('Bearer ', '', $request->header('Authorization'));
    //         $request->headers->set('Authorization', 'Bearer ' . $token);
    //         try {
    //             $user = Auth::authenticate();
    //             $request->setUserResolver(function () use ($user) {
    //                 return $user;
    //             });
    //                 //  return $next($request);

    //         } catch (AuthenticationException $e) {
    //             return response()->json(['status'=>false,'message' => $e->getMessage()], 401);
    //         }
    //     } else {
    //         return response()->json(['message' => 'Missing Authorization header','status'=>false], 404);
    //     }

    //     return $next($request);
                    $token = $request->bearerToken();

                    
                    if (!$token) {
                        throw new UnauthorizedException('Invalid token');
                    }

                    try {
                        $user = Auth::authenticate($token);
                    } catch (\Exception $e) {
                        return response()->json(['status'=>false,'message' => $e->getMessage()]);
                        // throw new UnauthorizedException(['Invalid token',$e->getMessage()]);
                    }

                    if (!$user) {
                        throw new UnauthorizedException('User not found');
                    }

                    // Token is valid and user is authenticated
                    // Perform any additional logic or proceed to the next middleware
                    return $next($request);


    }
}



