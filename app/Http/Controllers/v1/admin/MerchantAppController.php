<?php

namespace App\Http\Controllers\v1\admin;

use App\Events\UploadImageEvent;
use App\Http\Controllers\Controller;
use App\Models\MerchantApp;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MerchantAppController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:sanctum', ['except' => []]);
    }

    public function create(Request $req){
        DB::beginTransaction();
        try{
            $req->validate([
                "name"=>"required|string|max:255",
                "merchant_id"=>"required|exists:merchants,id",
                "payment_merchant_id"=>"required|string",
                "payment_merchant_type"=>"required|string"
            ]);
            $new_merchant_app = MerchantApp::create($req->all());
            
            if($new_merchant_app){
                DB::commit();
                return response()->json([
                    "success"=>true,
                    "message"=>"New Merchant App has been added!",
                    "data"=>$new_merchant_app
                ],200);
            }
            else{
                throw new Exception("Merchant creation failed");
            }
        }
        catch (Exception $e){
            DB::rollBack();
            return response()->json([
                "success"=>false,
                "message"=>$e->getMessage(),
                "line"=>$e->getLine()
            ],500);
        }
    }
    public function edit(Request $req,$id){
        DB::beginTransaction();
        try{
            $req->validate([
                "name"=>"required|string|max:255",
                "merchant_id"=>"required|exists:merchants,id",
                "payment_merchant_id"=>"required|string",
                "payment_merchant_type"=>"required|string"
            ]);
            $existing_merchant_app = MerchantApp::findOrFail($id)->update($req->all());
            
            if($existing_merchant_app){
                DB::commit();
                return response()->json([
                    "success"=>true,
                    "message"=>"Merchant App has been updated!",
                    "data"=>$existing_merchant_app
                ],200);
            }
            else{
                throw new Exception("Merchant app update failed");
            }
        }
        catch (Exception $e){
            DB::rollBack();
            return response()->json([
                "success"=>false,
                "message"=>$e->getMessage(),
                "line"=>$e->getLine()
            ],500);
        }
    }
    public function all(Request $req){
        try{
            $merchant_apps=MerchantApp::with(['merchant'])->get();
            // $merchants = $merchants->transform(function ($item, $key) { 
            //     foreach ($item->getMedia('main_image') as $media) { 
            //         $media['link'] = $media->getFullUrl(); 
            //     } 
            //     return $item; 
            // });
            return response()->json([
                "success"=>true,
                "message"=>"New Merchant has been added!",
                "data"=>$merchant_apps
            ],200);
        }
        catch (Exception $e){
            return response()->json([
                "success"=>false,
                "message"=>$e->getMessage(),
                "line"=>$e->getLine()
            ],500);
        }
    }

    public function delete($id){
        try{
            $merchant_app=MerchantApp::findOrFail($id);
            $merchant_app->delete();
            return response()->json([
                "success"=>true,
                "message"=>"Merchant Application has been deleted!",
            ],200);
        }
        catch (Exception $e){
            return response()->json([
                "success"=>false,
                "message"=>$e->getMessage(),
                "line"=>$e->getLine()
            ],500);
        }
    }
}
