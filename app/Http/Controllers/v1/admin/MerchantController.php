<?php

namespace App\Http\Controllers\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\MerchantRequest;
use App\Models\Merchant;
use Exception;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:sanctum', ['except' => []]);
    }

    public function create(MerchantRequest $req){
        try{
            $new_merchant = Merchant::create(array_merge($req->except('total_images'),['added_by'=>$req->user()->id]));
            if($new_merchant){
                return response()->json([
                    "success"=>false,
                    "message"=>"New Merchant has been added!",
                    "data"=>$new_merchant
                ]);
            }
            else{
                throw new Exception("Merchant creation failed");
            }
        }
        catch (Exception $e){
            return response()->json([
                "success"=>false,
                "message"=>$e->getMessage(),
                "line"=>$e->getLine()
            ]);
        }
    }
}
