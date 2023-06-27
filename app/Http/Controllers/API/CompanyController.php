<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\CompanyResource;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Laravel\Passport\Token;

class CompanyController extends Controller
{
    private $user;
    private $companyId;

    public function __construct(Request $request)
    {
        $this->user = $request->input('bearerTokenUser');
        $this->companyId = $request->input('openCompany');
    }

    public function companies(Request $request): JsonResponse
    {
        $company = Company::all();
        return response()->json([
            'status' => true,
            'msg' => 'Successfully fetched companies information',
            'company' => CompanyResource::collection($company),
        ], 200);
    }

    public function userCompanies(Request $request, $id): JsonResponse
    {
        $company = Company::where('user_id', $id)->get();
        return response()->json([
            'status' => true,
            'msg' => 'Successfully fetched user companies information',
            'company' => CompanyResource::collection($company),
        ], 200);
    }

    public function createCompany(Request $request): JsonResponse
    {

        try {

            $rules = [
                'bcat' => 'required|numeric',
                'btype' => 'required|numeric',
                'country' => 'required|numeric',
                'email' => 'required|email|unique:users,email',
                'name' => 'required',
                'password' => 'required|min:6',
                'phone' => 'required',
                'state' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                // Validation failed
                $errors = $validator->errors();
                return response()->json([
                    'status' => false,
                    'data' =>  $errors,
                    'msg' => 'Validation failed',
                ]);
            }

            try {
                DB::beginTransaction();

                // Create User
                $user = new User();
                $user->name     = "Super Admin";
                $user->email    = $request->input('email');
                $user->password = Hash::make($request->input('password'));
                $user->save();
                // Assign Role
                $role = Role::where('name','primaryadmin')->get(); // Primary Admin
                $user->assignRole($role);

                // Create Company
                $company = new Company();
                $company->name = $request->input('name');
                $company->GSTIN = 0;
                $company->phone = $request->input('phone');
                $company->email = $request->input('email');
                $company->address = null;
                $company->logo = null;
                $company->signature = null;
                $company->business_type = $request->input('btype');
                $company->business_categories = $request->input('bcat');
                $company->state_id = $request->input('state');
                $company->description = "";
                $company->open_status = 1;
                $company->active_status = 1;
                $company->is_parent = 1;
                $company->user_id = $user->id;
                $company->save();
                DB::commit();
                return response()->json([
                    'status' => true,
                    'data' => $request->all(),
                    'msg' => 'Successfully Created Company',
                ], 201);

            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'msg' => 'Company Registration Failed, Try again later',
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong, Try again later',
            ], 201);
        }
    }


    public function updateCompany(Request $request): JsonResponse
    {

        return response()->json([
            'status' => true,
            'msg' => 'Successfully Updated Company Details',
        ], 200);
    }



    public function testPermission(Request $request) {


        $user = $request->input('bearerTokenUser');
        if($user){
            return response()->json([
                'status' => true,
                'is_allowed' => $user->hasPermissionTo("can-view-dashboard"),
            ], 200);
        }

    }


    public function hasAccess(Request $request,$permissionName){
        $user = $request->input('bearerTokenUser');
        if($user){
            return response()->json([
                'status' => true,
                'is_allowed' => $user->hasPermissionTo($permissionName),
            ], 200);
        }

    }



    public function companyUsers(Request $request)
    {
        $companyId = $this->companyId;

        $users = User::with('roles')->whereHas('company', function ($query) use ($companyId) {
            $query->where('id', $companyId);
        })->get();

        if ($users->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'users' => $users,
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'No users found for the given company ID.',
        ], 404);
    }
}

