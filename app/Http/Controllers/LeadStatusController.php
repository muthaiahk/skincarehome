<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\LeadStatus;

class LeadStatusController extends Controller
{
    //
    public function Index(){
        
        $lead_status = LeadStatus::where('status', '!=', 2)->get();

        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $lead_status ,
                        ],200);

    }
    public function Add(Request $request){
        
        $validator = Validator::make($request->all(), [ 
                                                        'lead_status_name' => 'required|unique:lead_status|max:255',
                                                        
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

          
        }else{

            $status_name  = $request->lead_status_name;
            $description  = "";
          
        
            $add_lead_status   = new LeadStatus;
            $add_lead_status->lead_status_name        = $status_name;
            $add_lead_status->lead_status_description = $description;
            $add_lead_status->created_by              = $request->user()->id;
            $add_lead_status->modified_by             = $request->user()->id;
        
            $add_lead_status->save();

            if($add_lead_status){
                
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Designation has been created successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([
                        'status'    => 401,
                        'message'   => 'Designation can not be created',
                        'error_msg' => 'Designation information is worng please try again',
                        'data'      => null ,
                    ],401);
            }
            
            
        }

        return $result;
    }
    public function Edit($id){
        $lead_status = LeadStatus::where('lead_status_id', $id)->get();
        return response([
            'data' => $lead_status,
            'status' => 200
        ],200);
    }
    public function Update(Request $request,$id){

        $validator = Validator::make($request->all(), [ 
                                                        'lead_status_name' => 'required|unique:lead_status,lead_status_name,'.$id.',lead_status_id|max:255',
                                                    ]);

        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

        }else{
           
            $status_name = $request->lead_status_name;
            $description = "";
            
            $upd_lead_status = LeadStatus::find($id);

            $upd_lead_status->lead_status_name        = $status_name;
            $upd_lead_status->lead_status_description = $description;
            $upd_lead_status->modified_by             = $request->user()->id;
            $upd_lead_status->update();

            $result =   response([
                                    'status'    => 200,
                                    'message'   => 'successfull updated',
                                    'error_msg' => null,
                                    'data'      => $upd_lead_status,
                                ],200);
        }

        return $result;
    }
    public function Delete($id){
        $status = LeadStatus::where('lead_status_id', $id)->first();

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

        $lead_status = LeadStatus::where('lead_status_id', $id)->first();

        if($lead_status){
            $lead_status->status = $request->status;
            $lead_status->modified_by             = $request->user()->id;
            $lead_status->update();
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
