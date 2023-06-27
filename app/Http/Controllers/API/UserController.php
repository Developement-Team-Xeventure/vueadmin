<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public $user;
    public $companyId;

    public function __construct(){}

    public function initialize(Request $request)
    {
        $this->companyId = $request->input('openCompany');
        $this->user = $request->input('bearerTokenUser');
    }

    public function companyUsers(Request $request)
    {

        $this->initialize($request);
        $companyId = $this->companyId;
        $company = Company::find($companyId);

        $users = $company->users()->with('roles')->get();



        if ($users->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'users' => $users,
            ], 200);
        }
        return response()->json([
            'status' => false,
            'sss' => $company,
            'message' => 'No users found for the given company ID.',
        ], 404);

    }


    public function addUser(Request $request)
    {

        $this->initialize($request);
        $companyId = $this->companyId;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|max:8',
            'role' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
           return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ],422);
        } else {
            // Store User and Assign Role to User

                // Create User
                $user = new User();
                $user->name     = $request->input('name');
                $user->email     = $request->input('email');
                $user->password = Hash::make($request->input('password'));
                $user->save();

                // Attach companies to the user
                $companies = Company::where('id', $companyId)->get();
                $user->companies()->attach($companies);

                // Assign Role
                $role = Role::where('id',$request->input('role'))->get();
                $user->assignRole($role);


            return response()->json([
                'status' => true,
                'message' => 'Success',
                'errors' => []
            ],201);
        }
    }

}
