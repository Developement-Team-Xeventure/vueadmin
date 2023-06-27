<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Token;
class CompanyAuthController extends Controller
{

    // public function login(Request $request): JsonResponse
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email|max:255',
    //         'password' => 'required',
    //     ], [
    //         'email.required' => 'Please enter your email address',
    //         'email.email' => 'Please enter a valid email address',
    //         'password.required' => 'Please enter your password.',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid credentials',
    //             'errors' => $validator->errors(),
    //         ], 422);
    //     }

    //     $credentials = $request->only('email', 'password');
    //     if (auth()->attempt($credentials)) {
    //         $companyCode = $request->input('company');
    //         $company = Company::where('code', $companyCode)->where('user_id',auth()->user()->id)->first();

    //         if ($company) {
    //             $company->open_status = 1;
    //             $company->save();

    //             $accessToken = auth()->user()->createToken('billonex_token')->accessToken;
    //             return response()->json([
    //                 'status' => 'success',
    //                 'message' => 'Logged in successfully',
    //                 'authorization' => [
    //                     'token' => $accessToken,
    //                     'type' => 'bearer',
    //                     'company' => $company->code,
    //                 ]
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Unable to login, please try again',
    //             ], 404);
    //         }
    //     }

    //     return response()->json([
    //         'status' => false,
    //         'message' => 'Invalid email and password combination.',
    //     ], 401);
    // }


    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'email' => 'email|required',
            'password' => 'required'
        ]

        );

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials',
            'errors' => $validator->errors(),
        ], 422);
    }
        $email = $request->input('email');
        $password = $request->input('password');
        $companyCode = $request->input('company');

        if(! auth()->guard('web')->attempt(['email' => $email, 'password' => $password])){
            return response()->json(['error' => 'Unauthorised Access'], 401);
        }

        $company = Company::where('code', $companyCode)->where('user_id',auth()->guard('web')->user()->id)->first();
        if ($company) {
            $company->open_status = 1;
            $company->save();
            $accessToken = auth()->guard('web')->user()->createToken('authToken')->accessToken;
            return response()->json([
                'status' => 'success',
                'message' => 'Logged in successfully',
                // 'user' => auth()->user(),
                'authorization' => [
                    'token' => $accessToken,
                    'type' => 'bearer',
                    'c' => $company->code,
                ]
            ],200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Unable to login, please try again',
            ], 404);
        }
    }


    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json(['user' => $user], 200);
    }

    public function logout (Request $request)
    {
        $companyCode = str_replace('"', '', $request->input('company'));
        $token = $request->input('token');
        $company = Company::where('code', $companyCode)->where('user_id', $request->user()->id)->first();
        $token = $request->user()->token();
        $valid = Token::find($token->id)->exists();

        if ($company&&$valid) {
            $company->open_status = 0;
            $company->save();
            $request->user()->token()->revoke();
            $response = ['message' => 'You have been successfully logged out!','status' => true];
        } else {
            $response = ['message' => 'Something went wrong!','status' => false];
        }
        return response()->json($response, 200);
    }

    public function verifyToken(Request $request)
    {
        $token = $request->user()->token();
        if (!$token) {
           return response()->json(['status' => false]);
        }
        $valid = Token::find($token->id)->exists();
        return response()->json(['status' =>$valid], 200);
    }





}
