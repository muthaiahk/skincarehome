<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\LeadSource;

class LeadSourceController extends Controller
{
    //
    public function Index(){
        
        $lead_source = LeadSource::where('status', '!=', 2)->get();

        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $lead_source ,
                        ],200);

    }
    public function Add(Request $request){
        
        $validator = Validator::make($request->all(), [ 
                                                        'lead_source_name' => 'required|unique:lead_source|max:255',
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

          
        }else{

            $source_name  = $request->lead_source_name;
                      
            $add_lead_source   = new LeadSource;
            $add_lead_source->lead_source_name      = $source_name;
            $add_lead_source->created_by              =$request->user()->id;
            $add_lead_source->modified_by             =$request->user()->id;
        
            $add_lead_source->save();

            if($add_lead_source){
                
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Lead Reource name has been created successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([
                        'status'    => 401,
                        'message'   => 'Lead Reource name can not be created',
                        'error_msg' => 'Lead Reource name information is worng please try again',
                        'data'      => null ,
                    ],401);
            }
            
            
        }

        return $result;
    }
    public function Edit($id){
        $lead_source = LeadSource::where('lead_source_id', $id)->get();
        return response([
            'data' => $lead_source,
            'status' => 200
        ],200);
    }
    public function Update(Request $request,$id){

        $validator = Validator::make($request->all(), [ 
                                                        'lead_source_name' => 'required|unique:lead_source,lead_source_name,'.$id.',lead_source_id|max:255',
                                                    ]);

        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg' => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

        }else{
           
            $source_name = $request->lead_source_name;
            
            
            $upd_lead_source = LeadSource::find($id);
            $upd_lead_source->lead_source_name  = $source_name;
            $upd_lead_source->modified_by             =$request->user()->id;
      
            $upd_lead_source->update();

            $result =   response([
                                    'status'    => 200,
                                    'message'   => 'successfull updated',
                                    'error_msg' => null,
                                    'data'      => $upd_lead_source,
                                ],200);
        }

        return $result;
    }
    public function Delete($id){
        $status = LeadSource::where('lead_source_id', $id)->first();

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

        $lead_source = LeadSource::where('lead_source_id', $id)->first();

        if($lead_source){
            $lead_source->status = $request->status;
            $lead_source->modified_by             =$request->user()->id;
            $lead_source->update();
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
