<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\RolePermission;
use App\Models\Role;
use App\Models\User;

class RolePermissionController extends BaseController
{
    
  
    public function Permission(Request $request,$id){

      
    
        $role_permission_check = RolePermission::where('role_id',$id)->get();
        
        if($role_permission_check){
            
            $pages = $request->page;

        
            foreach($pages as $page){

                

                $permission = $page.'_permission';

                $role_permission   = RolePermission::where('role_id',$id)->where('page',$page)->first();

                if($role_permission){
                    
                    $role_permission->permission      = $request->$permission; 
                    $role_permission->updated_at      = date('Y-m-d H:i:s');
               
                    $role_permission->update();
                    $result =   response([
                        'status'    => 200,
                        'message'   => 'Role Permission has been Updated successfully',
                        'error_msg' => null,
                        'data'      => null ,
                    ],200);


                }else{
               
                    $role_permission_add   = new RolePermission;
                    $role_permission_add->role_id          = $id;
                    $role_permission_add->page             = $page;
                    $role_permission_add->permission       = $request->$permission;
                    $role_permission_add->created_by       = Auth::user()->id;
                    $role_permission_add->created_at       = date('Y-m-d H:i:s');
                    $role_permission_add->updated_by       = Auth::user()->id;
                    $role_permission_add->updated_at       = date('Y-m-d H:i:s');
                    $role_permission_add->status           = 0;
                    
                    $role_permission_add->save();
                    $result =   response([
                        'status'    => 200,
                        'message'   => 'Role Permission has been Updated successfully',
                        'error_msg' => null,
                        'data'      => null ,
                    ],200);

                }
                
                //echo $permission;
                //return $role_permission;

            }

            

            // if($role_permission){
                
                
            // }else{

            //     $result =   response([
            //             'status'    => 401,
            //             'message'   => 'Role Permission can not be updated',
            //             'error_msg' => 'Role Permission information is worng please try again',
            //             'data'      => null ,
            //         ],401);
            // }
            
        }else{
        
            
            
            $pages = $request->page;

            
            
            foreach($pages as $page){

                $permission = $page.'_permission';

                $role_permission   = new RolePermission;
                
                $role_permission->role_id          = $id;
                $role_permission->page             = $page;
                $role_permission->permission       = $request->$permission;
                $role_permission->created_by       = Auth::user()->id;
                $role_permission->created_at       = date('Y-m-d H:i:s');
                $role_permission->updated_by       = Auth::user()->id;
                $role_permission->updated_at       = date('Y-m-d H:i:s');
                $role_permission->status           = 0;
                
                $role_permission->save();
            }

            
        
            

            if($role_permission){
                
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Role Permission has been created successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([
                        'status'    => 401,
                        'message'   => 'Role Permission can not be created',
                        'error_msg' => 'Role Permission information is worng please try again',
                        'data'      => null ,
                    ],401);
            }
            
            
        }

        return $result;
        
    }

    public function Index(Request $request,$id){
        
        
        $result = RolePermission::where('role_id',$id)->get();
        
        return response([
                                        'status'    => 200,
                                        'message'   => 'Role Permission ',
                                        'error_msg' => null,
                                        'data'      => $result ,
                                    ],200);

        
        
    }

    public function PagePermission($name){
        $page = $name;
        $role = User::where('id',Auth::user()->id)->first();
        $result = RolePermission::where('role_id',$role->role_id)->where('page',$page)->first();
        
        return response([
                                        'status'    => 200,
                                        'message'   => 'Role Permission ',
                                        'error_msg' => null,
                                        'data'      => $result,
                                    ],200);
    }
   

   
}
