<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\ProductBrand;

class BrandController extends Controller
{
    // 
    public function Index(){
        
        $brand = ProductBrand::where('status', '!=', 2)->get();

        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $brand ,
                        ],200);

    }
    public function Add(Request $request){
        
        $validator = Validator::make($request->all(), [ 
                                                        'brand_name' => 'required|unique:brand|max:255',
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

          
        }else{

            $name  = $request->brand_name;
    
            $add_brand   = new ProductBrand;

            $add_brand->brand_name  = $name;
            $add_brand->created_by  = $request->user()->id;
            $add_brand->modified_by = $request->user()->id;
        
            $add_brand->save();

            if($add_brand){
                
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Brand has been created successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([
                        'status'    => 401,
                        'message'   => 'Brand can not be created',
                        'error_msg' => 'Brand information is worng please try again',
                        'data'      => null ,
                    ],401);
            }
            
            
        }

        return $result;
    }
    public function Edit($id){
        $brand = ProductBrand::where('brand_id', $id)->get();
        return response([
            'data' => $brand,
            'status' => 200
        ],200);
    }
    public function Update(Request $request,$id){

        $validator = Validator::make($request->all(), [ 
                                                        'brand_name' => 'required|unique:brand,brand_name,'.$id.',brand_id|max:255',
                                                       
                                                    ]);

        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

        }else{
            $name  = $request->brand_name;
            
            $upd_brand = ProductBrand::find($id);

            $upd_brand->brand_name  = $name;
            $upd_brand->modified_by = $request->user()->id;

            $upd_brand->update();

            $result =   response([
                                    'status'    => 200,
                                    'message'   => 'successfull updated',
                                    'error_msg' => null,
                                    'data'      => $upd_brand,
                                ],200);
        }

        return $result;
    }
    public function Delete($id){
        $status = ProductBrand::where('brand_id', $id)->first();

        if($status){
            $status->status = 2;
            $status->update();
        }
        return response([
                            'data' => null,
                            'message' => 'Successfully Delete',
                            'status' => 200
                        ],200);
    }

    public function Status(Request $request, $id){

        $brand_status = ProductBrand::where('brand_id', $id)->first();

        if($brand_status){
            $brand_status->status = $request->status;
            $brand_status->modified_by = $request->user()->id;
            $brand_status->update();
        }else{
            return response([
                'data' => null,
                'message' => 'No data found',
                'status' => 404
            ],404); 
        }

        return response([
                            'data' => null,
                            'message' => 'Successfully Updated',
                            'status' => 200
                        ],200);
    }

}
