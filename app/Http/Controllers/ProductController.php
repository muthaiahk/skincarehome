<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    //
     public function Index(){
        

        $product = Product::select('product_id','product_name','brand.brand_id', 'brand.brand_name','product_category.prod_cat_id','product_category.prod_cat_name','product.status','product.amount','product.gst')
                        ->join('brand', 'brand.brand_id','=','product.brand_id')
                        ->join('product_category', 'product_category.prod_cat_id','=','product.prod_cat_id')
                        ->where('product.status', '!=', 2)
                        ->get();

        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $product ,
                        ],200);

     }
     public function ProductList(Request $request)
    {
        // Retrieve the category_id parameter from the request
        $categoryId = $request->query('category_id');

        // Build the query
        $query = Product::select(
                        'product_id',
                        'product_name',
                        'brand.brand_id',
                        'brand.brand_name',
                        'product_category.prod_cat_id',
                        'product_category.prod_cat_name',
                        'product.status',
                        'product.amount',
                        'product.gst',
                        'product.product_image'
                    )
                    ->join('brand', 'brand.brand_id', '=', 'product.brand_id')
                    ->join('product_category', 'product_category.prod_cat_id', '=', 'product.prod_cat_id')
                    ->where('product.status', '!=', 2);

        // Apply category filter if category_id is provided
        if ($categoryId) {
            $query->where('product.prod_cat_id', $categoryId);
        }

        // Execute the query and get the products
        $products = $query->get();

        // Return the response
        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $products,
        ], 200);
    }

    public function Add(Request $request){
        
        $validator = Validator::make($request->all(), [ 
                                                        'product_name' => 'required|unique:product|max:255',
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

          
        }else{

            $product_name   = $request->product_name;
            $cat_id         = $request->prod_cat_id;
            $brand_id       = $request->brand_id;
            $amount         = $request->amount;
            $gst            = $request->gst;

            if ($request->hasFile('product_image')) {
                $imageName = idate('B') . rand(1, 50) . '.' . $request->file('product_image')->extension();
                $destinationPath = public_path('product_image');
                // Path to the logos directory
                $request->file('product_image')->move($destinationPath, $imageName);
                $product_image = $imageName;
            } else {
                $product_image = '';
            }
            // return $logo;
            $add_product   = new Product;

            $add_product->product_name  = $product_name;
            $add_product->prod_cat_id   = $cat_id;
            $add_product->brand_id      = $brand_id;
            $add_product-> amount       = $amount;
            $add_product-> gst          = $gst;
            $add_product-> product_image          = $product_image;
            
            $add_product->created_by    = $request->user()->id;
            $add_product->modified_by   = $request->user()->id;
        
            $add_product->save();

            if($add_product){
                
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Product has been created successfully',
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

        $product = Product::select('product_id','product_name','brand.brand_id', 'brand.brand_name','product_category.prod_cat_id','product_category.prod_cat_name','product.status','product.amount','product.gst','product.product_image')
                            ->join('brand', 'brand.brand_id','=','product.brand_id')
                            ->join('product_category', 'product_category.prod_cat_id','=','product.prod_cat_id')
                            ->where('product.product_id', $id)
                            ->get();
        // $brand = Product::where('brand_id', $id)->get();
        return response([
            'data' => $product,
            'status' => 200
        ],200);
    }
    public function Update(Request $request,$id){

        $validator = Validator::make($request->all(), [ 
                                                        'product_name' => 'required|unique:product,product_name,'.$id.',product_id|max:255',
                                                       
                                                    ]);

        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

        }else{
            $product_name = $request->product_name;
            $prod_cat_id  = $request->prod_cat_id;
            $brand_id     = $request->brand_id;
            $amount       = $request->amount;
            $gst          = $request->gst;

            
            $upd_product = Product::find($id);
            if ($request->hasFile('product_image')) {
                $imageName = idate('B') . rand(1, 50) . '.' . $request->file('product_image')->extension();
                $destinationPath = public_path('product_image');
                // Path to the logos directory
                $request->file('product_image')->move($destinationPath, $imageName);
                $product_image = $imageName;
            } else {
                $product_image = $upd_product->product_image;
            }
            $upd_product->product_name  = $product_name;
            $upd_product->prod_cat_id   = $prod_cat_id;
            $upd_product->brand_id      = $brand_id;
            $upd_product->amount        = $amount;
            $upd_product->gst           = $gst;
            $upd_product->product_image           = $product_image;
         
            $upd_product->modified_by   = $request->user()->id;
            $upd_product->update();

            $result =   response([
                                    'status'    => 200,
                                    'message'   => 'successfull updated',
                                    'error_msg' => null,
                                    'data'      => $upd_product,
                                ],200);
        }

        return $result;
    }
    public function Delete($id){
        $status = Product::where('product_id', $id)->first();

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

        $product_status = Product::where('product_id', $id)->first();

        if($product_status){
            $product_status->status = $request->status;
            $product_status->update();
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
