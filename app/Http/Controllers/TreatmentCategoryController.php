<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\TreatmentCategory;

class TreatmentCategoryController extends Controller
{
    //
    public function Index(){
        
        $treatment_cat = TreatmentCategory::where('status', '!=', 2)->get();

        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $treatment_cat ,
                        ],200);

    }
    public function Add(Request $request){
        
        $validator = Validator::make($request->all(), [ 
                                                        'tc_name' => 'required|unique:treatment_category|max:255',
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

          
        }else{


         
            $tc_name         = $request->tc_name;
            $tc_description  = $request->tc_description;
         
    
            $add_tc   = new TreatmentCategory;

        
            $add_tc->tc_name        = $tc_name;
            $add_tc->tc_description = $tc_description;
          
            $add_tc->created_by  =  $request->user()->id;
            $add_tc->modified_by = $request->user()->id;
        
            $add_tc->save();

            if($add_tc){
                
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Treatment has been created successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([

                        'status'    => 401,
                        'message'   => 'Treatment can not be created',
                        'error_msg' => 'Treatment information is worng please try again',
                        'data'      => null ,
                    ],401);
            }
            
            
        }

        return $result;
    }
    public function Edit($id){
        $treatment = TreatmentCategory::where('tcategory_id', $id)->get();
        return response([
            'data' => $treatment,
            'status' => 200
        ],200);
    }
    public function Update(Request $request,$id){

        $validator = Validator::make($request->all(), [ 
                                                        'tc_name' => 'required|unique:treatment_category,tc_name,'.$id.',tcategory_id|max:255',
                                                       
                                                    ]);

        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

        }else{

            
            $tc_name         = $request->tc_name;
            $tc_description  = $request->tc_description;
         
            $upd_treatment_cat = TreatmentCategory::find($id);

            $upd_treatment_cat->tc_name          = $tc_name;
            $upd_treatment_cat->tc_description   = $tc_description;
            $upd_treatment_cat->modified_by = $request->user()->id;
            $upd_treatment_cat->update();

            $result =   response([
                                    'status'    => 200,
                                    'message'   => 'successfull updated',
                                    'error_msg' => null,
                                    'data'      => $upd_treatment_cat,
                                ],200);
        }

        return $result;
    }
    public function Delete($id){
        $status = TreatmentCategory::where('tcategory_id', $id)->first();

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

        $treatement_status = TreatmentCategory::where('tcategory_id', $id)->first();

        if($treatement_status){
            $treatement_status->status = $request->status;
            $treatement_status->modified_by = $request->user()->id;
            $treatement_status->update();
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
