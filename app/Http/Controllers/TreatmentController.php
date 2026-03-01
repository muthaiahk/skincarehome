<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Treatment;

class TreatmentController extends BaseController
{
    //
    public function Index(Request $request){


        $cat_id = $request->tc_id;

        
        $treatment = Treatment::select('treatment.treatment_id','treatment.treatment_name','treatment_category.tcategory_id','treatment_category.tc_name','treatment.amount','treatment.status')
                                ->join('treatment_category', 'treatment_category.tcategory_id','=','treatment.tc_id')
                                ->where('treatment.status', '!=', 2);

        if(isset($request->tc_id)){
            $treatment = $treatment->where('treatment.tc_id', $cat_id);
        }
       // $treatment->get();

        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $treatment->get() ,
                        ],200);

    }
    public function Add(Request $request){
        
        $validator = Validator::make($request->all(), [ 
                                                        'treatment_name' => 'required|max:255',
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

          
        }else{


            $tc_id                  = $request->tc_id;
            $treatment_name         = $request->treatment_name;
            $treatment_description  = $request->treatment_description;
            $amount                 = $request->amount;
    
            $chk = Treatment::where('treatment_name',$request->treatment_name)->where('status',0)->first();
            if($chk){
                $result =   response([
                    'status'    => 401,
                    'message'   => 'Treatment can not be created Already have!',
                    'error_msg' => 'Treatment can not be created Already have!',
                    'data'      => null ,
                ],401);
            }else{

                $add_treatment   = new Treatment;

                $add_treatment->tc_id                = $tc_id;
                $add_treatment->treatment_name       = $treatment_name;
                $add_treatment->treatment_description  = $treatment_description;
                $add_treatment->amount  = $amount;
            
                $add_treatment->created_by  =  $request->user()->id;
                $add_treatment->modified_by = $request->user()->id;
            
                $add_treatment->save();
                if($add_treatment){
                
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
            
            
        }

        return $result;
    }
    public function Edit($id){
        $treatment = Treatment::select('treatment.treatment_id','treatment.treatment_name','treatment_category.tcategory_id','treatment_category.tc_name','treatment.amount','treatment.status')
        ->join('treatment_category', 'treatment_category.tcategory_id','=','treatment.tc_id')->where('treatment_id', $id)->get();
        return response([
            'data' => $treatment,
            'status' => 200
        ],200);
    }
    public function Update(Request $request,$id){

        $validator = Validator::make($request->all(), [ 
                                                        'treatment_name' => 'required|max:255',
                                                       
                                                    ]);

        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

        }else{

            $chk = Treatment::where('tc_id',$request->tc_id)->where('treatment_name',$request->treatment_name)->first();

            if(!$chk){


                $tc_id                  = $request->tc_id;
                $treatment_name         = $request->treatment_name;
                $treatment_description  = $request->treatment_description;
                $amount                 = $request->amount;
                $upd_treatment = Treatment::find($id);

                $upd_treatment->tc_id                   = $tc_id;
                $upd_treatment->treatment_name          = $treatment_name;
                $upd_treatment->treatment_description   = $treatment_description;
                $upd_treatment->amount                  = $amount;
                $upd_treatment->modified_by = $request->user()->id;
            
                $upd_treatment->update();
            

                $result =   response([
                                    'status'    => 200,
                                    'message'   => 'successfull updated',
                                    'error_msg' => null,
                                    'data'      => $upd_treatment,
                                ],200);
            }else{

                if($chk->treatment_id == $id){
                    
                    $tc_id                  = $request->tc_id;
                    $treatment_name         = $request->treatment_name;
                    $treatment_description  = $request->treatment_description;
                    $amount                 = $request->amount;
                    $upd_treatment = Treatment::find($id);

                    $upd_treatment->tc_id                   = $tc_id;
                    $upd_treatment->treatment_name          = $treatment_name;
                    $upd_treatment->treatment_description   = $treatment_description;
                    $upd_treatment->amount                  = $amount;
                    $upd_treatment->modified_by = $request->user()->id;
                
                    $upd_treatment->update();
                

                    $result =   response([
                                        'status'    => 200,
                                        'message'   => 'successfull updated',
                                        'error_msg' => null,
                                        'data'      => $upd_treatment,
                                    ],200);
                }else{
                
                    return response([
                        'status'    => 400,
                        'message'   => 'treatment already created ',
                        'error_msg' => null,
                        'data'      => null,
                    ],200);
                }
               
            }
        }

        return $result;
    }
    public function Delete($id){
        $status = Treatment::where('treatment_id', $id)->first();

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

        $treatement_status = Treatment::where('treatment_id', $id)->first();

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

    public function TreatmentCategory(){
        
        $manage_tc = Treatment::select('treatment_category.tcategory_id','treatment_category.tc_name','treatment_category.status')->
        join('treatment_category', 'treatment_category.tcategory_id','=','treatment.tc_id')
                        ->distinct('treatment.tc_id')->where('treatment.status', '!=', 2)->get(); 

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $manage_tc ,
        ],200);


    }

    public function Treatment($id){

        $treatment = Treatment::select('treatment.treatment_id','treatment.treatment_name','treatment.status')
                                ->where('treatment.tc_id',$id)
                                ->where('treatment.status', '!=', 2)
                                ->get();

        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $treatment ,
                        ],200);


    }

    public function Amount(Request $request){


        $treatment = Treatment::select('amount')
                                ->where('treatment.tc_id',$request->tc_id)->where('treatment.treatment_id',$request->t_id)
                                ->where('treatment.status', '!=', 2)
                                ->first();

        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $treatment,
                        ],200);


    }




}
