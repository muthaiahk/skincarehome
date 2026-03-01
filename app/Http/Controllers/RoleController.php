<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Role;

class RoleController extends BaseController
{
    public function Index(){

        $role = Role::where('status', '!=', 2)->get();
        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $role ,
                        ],200);

    }
    public function Add(Request $request){
        $validator = Validator::make($request->all(), [ 
                                                        'role_name' => 'required|unique:role|max:255',
                                                        //'role_description'     => 'required|unique:role',
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

          
        }else{

            $role_name        = $request->role_name;
            $role_description = "";
        
            $role   = new Role;

            $role->role_name        = $role_name;
            $role->role_description = $role_description;
            $role->created_by       =  $request->user()->id;
            $role->created_on       = date('Y-m-d H:i:s');
            $role->modified_by      =  $request->user()->id;
            $role->modified_on      = date('Y-m-d H:i:s');
            $role->status           = 0;
        
            $role->save();

            if($role){
                
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Role has been created successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([
                        'status'    => 401,
                        'message'   => 'Role can not be created',
                        'error_msg' => 'Role information is worng please try again',
                        'data'      => null ,
                    ],401);
            }
            
            
        }

        return $result;
        
    }
    public function Edit($id){
        $role = Role::where('role_id', $id)->get();

        return response([
            'data' => $role,
            'status' => 200
        ],200);
    }

    public function Update(Request $request,$id){
       

        $validator = Validator::make($request->all(), [ 
                                                        'role_name' => 'required|unique:role,role_name,'.$id.',role_id',
                                                        
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

        }else{

            $che_status = Role::first();

            $status = Role::where('role_id', $id)->first();

            if($che_status->role_id != $status->role_id){
                if($status){
                    $role_name        = $request->role_name;
                    $role_description = $request->role_description;
                    
                    $role = Role::find($id);

                    $role->role_name        = $role_name;
                    $role->role_description = $role_description;
                    $role->modified_by      =  $request->user()->id;

                    $role->update();

                    $result =   response([
                                            'status'    => 200,
                                            'message'   => 'success',
                                            'error_msg' => null,
                                            'data'      => $role,
                                        ],200);
                        }
                    
            }else{
                return response([
                                'data' => null,
                                'message' => 'Not to Permission to update this record',
                                'status' => 401
                            ],200);
            }

            
        }

        return $result;
    }
    public function Delete($id){

        $che_status = Role::first();

        $status = Role::where('role_id', $id)->first();

        if($che_status->role_id != $status->role_id){
            if($status){
                $status->status = 2;
                $status->update();
            }
            return response([
                                'data' => null,
                                'message' => 'Successfully Delete',
                                'status' => 200
                            ],200);
        }else{
            return response([
                            'data' => null,
                            'message' => 'Not to Permission to delete this record',
                            'status' => 401
                        ],200);
        }


        
    }
    public function Status(Request $request, $id){

        $che_status = Role::first();

        $status = Role::where('role_id', $id)->first();

        if($che_status->role_id != $status->role_id){

            if($status){
                $status->status = $request->status;
                $status->modified_by      =  $request->user()->id;
                $status->update();
            }
            return response([
                                'data' => null,
                                'message' => 'Successfully Updated',
                                'status' => 200
                            ],200);
        }else{
            return response([
                            'data' => null,
                            'message' => 'Not to Permission to Update this record',
                            'status' => 401
                        ],200);
        }


       
    }
   
}
