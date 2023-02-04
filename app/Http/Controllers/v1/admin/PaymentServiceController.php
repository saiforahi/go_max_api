<?php

namespace App\Http\Controllers\v1\admin;

use App\Http\Controllers\Controller;
use App\Models\BkashMerchant;
use App\Models\PaymentService;
use App\Models\ShurjoPayMerchant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentServiceController extends Controller
{
    //
    public function getPaymentServices(){
        try{
            return response()->json([
                "success"=>true,
                "message"=>"Payment Service List",
                "data"=>PaymentService::all()
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                "success"=>false,
                "message"=>$e->getMessage(),
                "line"=>$e->getLine()
            ],500);
        }
    }
    public function deleteMerchant($type,$id){
        try{
            if(PaymentService::find($type)->id==1){
                $merchant=ShurjoPayMerchant::findOrFail($id);
                $merchant->delete();
                return response()->json([
                    "success"=>true,
                    "message"=>"Shurjopay Merchant has been deleted!",
                ],200);
            }
            else if(PaymentService::find($type)->id==2){
                $merchant=BkashMerchant::findOrFail($id);
                $merchant->delete();
                return response()->json([
                    "success"=>true,
                    "message"=>"bKash Merchant has been deleted!",
                ],200);
            }
            else{
                throw new Exception("Invalid Merchant type");
            }
        }
        catch (Exception $e){
            return response()->json([
                "success"=>false,
                "message"=>$e->getMessage(),
                "line"=>$e->getLine()
            ],500);
        }
    }
    public function createShurjoPayMerchant(Request $req){
        DB::beginTransaction();
        try{
            $req->validate([
                'live_api_username'=>'required|string|max:255|min:3',
                'live_api_password'=>'required|string|max:255|min:3',
                'live_prefix'=>'required|string|max:20|min:2',
                'alias_name'=>'required|string|max:255'
            ]);
            $new_shurjo_merchant=ShurjoPayMerchant::create($req->all());
            if($new_shurjo_merchant){
                DB::commit();
                return response()->json([
                    "success"=>true,
                    "message"=>"New ShurjoPay Merchant created!",
                    "data"=>$new_shurjo_merchant
                ],200);
            }
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json([
                "success"=>false,
                "message"=>$e->getMessage(),
                "line"=>$e->getLine()
            ],500);
        }
    }
    public function createBkashMerchant(Request $req){
        DB::beginTransaction();
        try{
            $req->validate([
                'reference_merchant_id'=>'required|string|max:255|min:3',
                'merchant_mcc'=>'required|string|max:255|min:3',
                'merchant_name'=>'required|string|max:20|min:2',
                'merchant_city'=>'required|string|max:255',
                'merchant_region'=>'required|string|max:255|min:3',
                'merchant_store_reference_id'=>'required|string|max:255|min:3',
                'merchant_store_mcc'=>'required|string|max:20|min:2',
                'merchant_store_name'=>'required|string|max:255',
                'alias_name'=>'required|string|max:255'
            ]);
            $new_bkash_merchant=BkashMerchant::create($req->all());
            if($new_bkash_merchant){
                DB::commit();
                return response()->json([
                    "success"=>true,
                    "message"=>"New bKash Merchant created!",
                    "data"=>$new_bkash_merchant
                ],200);
            }
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json([
                "success"=>false,
                "message"=>$e->getMessage(),
                "line"=>$e->getLine()
            ],500);
        }
    }
    public function getAllMerchant(Request $req){
        try{
            $result=[];
            foreach(ShurjoPayMerchant::all() as $item){
                array_push($result,array(
                        'id'=>$item->id,
                        'type'=>PaymentService::find(1),
                        'alias_name'=>$item->alias_name,
                        'config'=>array("live_api_username"=>$item->live_api_username,"live_api_password"=>$item->live_api_password,"live_prefix"=>$item->live_prefix)
                    )
                );
            }
            foreach(BkashMerchant::all() as $item){
                array_push($result,array(
                        'id'=>$item->id,
                        'type'=>PaymentService::find(2),
                        'alias_name'=>$item->alias_name,
                        'config'=>array("merchant_mcc"=>$item->merchant_mcc,"merchant_city"=>$item->merchant_city,"merchant_store_name"=>$item->merchant_store_name)
                    )
                );
            }
            return response()->json([
                "success"=>true,
                "message"=>"All merchant list!",
                "data"=>$result
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                "success"=>false,
                "message"=>$e->getMessage(),
                "line"=>$e->getLine()
            ],500);
        }
    }
}
