<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    //

    //
    public function Index(){
        
        $product_cat = ProductCategory::where('status', '!=', 2)->get();

        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $product_cat ,
                        ],200);

    }
    public function Add(Request $request){
        
        $validator = Validator::make($request->all(), [ 
                                                        'prod_cat_name' => 'required|unique:product_category|max:255',
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

          
        }else{

            $prod_cat_name   = $request->prod_cat_name;
            $brand_id        = $request->brand_id;
         

    
            $add_product_cat   = new ProductCategory;

            $add_product_cat->brand_id       = $brand_id ;
            $add_product_cat->prod_cat_name  = $prod_cat_name;
            
          
            $add_product_cat->created_by  = $request->user()->id;
            $add_product_cat->modified_by = $request->user()->id;
          
        
            $add_product_cat->save();

            if($add_product_cat){
                
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Product category has been created successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([

                        'status'    => 401,
                        'message'   => 'Product can not be created',
                        'error_msg' => 'Product information is worng please try again',
                        'data'      => null ,
                    ],401);
            }
            
            
        }

        return $result;
    }
    public function Edit($id){
        $product_cat = ProductCategory::where('prod_cat_id', $id)->get();
        return response([
            'data' => $product_cat,
            'status' => 200
        ],200);
    }
    public function Update(Request $request,$id){

        $validator = Validator::make($request->all(), [ 
                                                        'prod_cat_name' => 'required|unique:product_category,prod_cat_name,'.$id.',prod_cat_id|max:255',
                                                       
                                                    ]);

        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

        }else{

            $prod_cat_name = $request->prod_cat_name;
           // $brand_id      = $request->brand_id;
            
            $upd_product_cat = ProductCategory::find($id);

            $upd_product_cat->brand_id  = $upd_product_cat->brand_id;
            $upd_product_cat->prod_cat_name  = $prod_cat_name;
            $upd_product_cat->updated_by   = $request->user()->id;
            $upd_product_cat->update();

            $result =   response([
                                    'status'    => 200,
                                    'message'   => 'successfull updated',
                                    'error_msg' => null,
                                    'data'      => $upd_product_cat,
                                ],200);
        }

        return $result;
    }
    public function Delete($id){
        $status = ProductCategory::where('prod_cat_id', $id)->first();

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

        $product_cat_status = ProductCategory::where('prod_cat_id', $id)->first();

        if($product_cat_status){
            $product_cat_status->status = $request->status;
            $product_cat_status->update();
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
