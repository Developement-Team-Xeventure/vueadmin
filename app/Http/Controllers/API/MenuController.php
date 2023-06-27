<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class MenuController extends Controller
{
    private $user;
    private $companyId;

    public function __construct(Request $request)
    {
        $this->user = $request->input('bearerTokenUser');
        $this->companyId = $request->input('openCompany');

    }

        public function menus(Request $request){
            $companyId =$request->input('openCompany');
            $menus = Menu::where('company_id',$companyId)->orderBy('order','ASC')->get();
            if($menus){
                return response()->json([
                    'status' => true,
                    'msg' => 'Successfully fetched states',
                    'menus' => $menus,
                ], 200);
            }
        }

}
