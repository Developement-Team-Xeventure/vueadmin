<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\StateResource;
use App\Models\BusinessCategory;
use App\Models\BusinessType;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class GeneralController extends Controller
{
    public function states(Request $request){
        $searchTerm = $request->input('search');

        $query = State::query();

        if ($searchTerm) {
            $query->where('name', 'LIKE', "%$searchTerm%");
        }

        $states = $query->get();

        return response()->json([
            'status' => true,
            'msg' => 'Successfully fetched states',
            'states' => StateResource::collection($states),
        ], 200);
    }

    public function countryStates($id){
        $states = State::where('country_id',$id)->get();
        return response()->json([
            'status' => true,
            'msg' => 'Successfully fetched States',
            'states' => StateResource::collection($states),
        ],200);
    }

    public function countries(Request $request){
        $searchTerm = $request->input('search');
         if($searchTerm){
        $query = Country::query();

        if ($searchTerm && strlen($searchTerm)>2) {
            $query->where('name', 'LIKE', "%$searchTerm%");
        }

        $countries = $query->get();

        }else{
            $countries = Country::where('name','India')->get();
        }
        return response()->json([
            'status' => true,
            'msg' => 'Successfully fetched states',
            'countries' => CountryResource::collection($countries),
        ], 200);
    }

    // public function countryStates($id){
    //     $states = State::where('country_id',$id)->get();
    //     return response()->json([
    //         'status' => true,
    //         'msg' => 'Successfully fetched States',
    //         'states' => StateResource::collection($states),
    //     ],200);
    // }


    public function businessTypes(Request $request){
        $data = BusinessType::all();
        return response()->json([
            'status' => true,
            'msg' => 'Success',
            'data' => StateResource::collection($data),
        ],200);
    }

    public function businessCategories(Request $request){
        $data = BusinessCategory::all();
        return response()->json([
            'status' => true,
            'msg' => 'Success',
            'data' => StateResource::collection($data),
        ],200);
    }
    public function companyRoles(Request $request){
        $data = Role::get();
        return response()->json([
            'status' => true,
            'msg' => 'Success',
            'roles' => RoleResource::collection($data),
        ],200);
    }
}
