<?php

use App\Http\Controllers\API\CompanyAuthController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\GeneralController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'cors','prefix'=>'v1/'], function () {

    Route::get('states',[GeneralController::class,'states']);
    Route::get('states/{id}',[GeneralController::class,'countryStates']);
    Route::get('countries',[GeneralController::class,'countries']);
    Route::get('b-types',[GeneralController::class,'businessTypes']);
    Route::get('b-categories',[GeneralController::class,'businessCategories']);

    Route::get('company',[CompanyController::class,'companies']);
    Route::post('company',[CompanyController::class,'createCompany']);
    Route::put('company',[CompanyController::class,'updateCompany']);

    Route::post('company-login',[CompanyAuthController::class,'login']);
    Route::post('company-logout',[CompanyAuthController::class,'logout']);
    // Route::get('verify-token',[CompanyAuthController::class,'verifyToken']);


    Route::group(['middleware' => ['auth:api']], function () {

            Route::get('verify-token', [CompanyAuthController::class, 'verifyToken']);
            Route::post('logout', [CompanyAuthController::class, 'logout']);
            Route::post('me', [CompanyAuthController::class, 'me']);

            Route::get('menus', [MenuController::class, 'menus']);

            Route::get('users', [UserController::class, 'companyUsers']);
            Route::post('user', [UserController::class, 'addUser']);
            Route::get('roles', [GeneralController::class, 'companyRoles']);
            Route::get('has/{name}/access', [CompanyController::class, 'hasAccess']);



    });




















    // Api not Found -> redirect
    Route::any('{any}', function () {
        return response()->json(
            [
                'status' => 'success',
                'message' => 'API not found',
            ],404
        );
    })->where('any', '.*');
});

