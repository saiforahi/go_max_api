<?php

namespace App\Http\Controllers\v1\admin;

use App\Events\UploadImageEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\MerchantRequest;
use App\Models\Merchant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MerchantController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:sanctum', ['except' => []]);
    }

    public function create(MerchantRequest $req){
        DB::beginTransaction();
        try{
            $new_merchant = Merchant::create(array_merge($req->except('main_image'),['added_by'=>$req->user()->id]));
            $images=array();
            if($req->has('main_image')){
                array_push($images,$req->file('main_image'));
            }
            event(new UploadImageEvent($new_merchant,$images));
            if($new_merchant){
                DB::commit();
                return response()->json([
                    "success"=>true,
                    "message"=>"New Merchant has been added!",
                    "data"=>$new_merchant
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

    public function edit(MerchantRequest $req,$merchant_id){
        DB::beginTransaction();
        try{
            $merchant=Merchant::where("id",$merchant_id)->first();
            $merchant->update(array_merge($req->except('main_image'),['added_by'=>$req->user()->id]));
            $images=array();
            if($req->has('main_image')){
                array_push($images,$req->file('main_image'));
                $mediaItems = $merchant->getMedia("main_image");
                foreach($mediaItems as $item){
                    $item->delete();
                }
            }
            event(new UploadImageEvent($merchant,$images));
            if($merchant){
                DB::commit();
                return response()->json([
                    "success"=>true,
                    "message"=>"Merchant info has been updated!",
                    "data"=>$merchant
                ],200);
            }
            else{
                throw new Exception("Merchant update failed");
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
            $merchants=Merchant::all();
            // $merchants = $merchants->transform(function ($item, $key) { 
            //     foreach ($item->getMedia('main_image') as $media) { 
            //         $media['link'] = $media->getFullUrl(); 
            //     } 
            //     return $item; 
            // });
            return response()->json([
                "success"=>true,
                "message"=>"New Merchant has been added!",
                "data"=>$merchants
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
            $merchant=Merchant::findOrFail($id);
            $mediaItems = $merchant->getMedia("main_image");
            foreach($mediaItems as $item){
                $item->delete();
            }
            $merchant->delete();
            return response()->json([
                "success"=>true,
                "message"=>"Merchant has been deleted!",
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
