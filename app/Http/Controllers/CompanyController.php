<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Company;
use App\Models\General;

class CompanyController extends BaseController
{
    public function Index(){
        
        $company = Company::all();
        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $company,
                        ],200);

    }

    public function Edit($id){
        
        $company = Company::where('company_id', $id)->first();
        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $company,
                        ],200);

    }
    
    public function Update(Request $request){

        $validator = Validator::make($request->all(), [ 
                                                        'company_name' => 'required|unique:general_settings|max:255',
                                                        'phone_no'     => 'required|unique:general_settings',
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg' => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

          
        }else{

            $company_id       = $request->company_id;
            $company_name     = $request->company_name;
            $established_date = $request->established_date;
            $company_address  = $request->company_address;
            $contact_person   = $request->contact_person;
            $phone_no         = $request->phone_no;
            $email            = $request->email;
            $website          = $request->website;
            $timezone         = $request->timezone;
            $currency         = $request->currency;
            $language         = $request->language;
            $gst_no           = $request->gst_no;
            $pan_no           = $request->pan_no;
            
        
            $generalcheck   =  General::first();


            if($generalcheck){

             

                $general  =   General::where('g_set_id',2)->first();

                if($request->logo) { 
                    $imageName = idate("B").rand(1,50).'.'.$request->logo->extension(); 
                    // //Storage::disk('public')->putFileAs('/awards', $request->logo,$imageName,'public');  
    
                    $destinationPath = 'logo';
                    // // $myimage = $request->image->getClientOriginalName();
                    $logo = $request->logo->move(public_path($destinationPath), $imageName);
                
                }else{
                    $logo        =  $general->logo;
                }
                
                
                if($request->favicon) { 
                    $imageName = idate("B").rand(1,50).'.'.$request->favicon->extension(); 
                                     
                    $destinationPath = 'favicon';
                    // //  $myimage = $request->favicon->getClientOriginalName();
                    $favicon = $request->favicon->move(public_path($destinationPath), $imageName);
                    
                }else{
                    $favicon     = $general->favicon;
                }


                if ($request->default_pic) { 
                    $imageName = idate("B").rand(1,50).'.'.$request->default_pic->extension(); 
                                     
                    $destinationPath = 'default';
                    // //  $myimage = $request->favicon->getClientOriginalName();
                    $default_pic = $request->default_pic->move(public_path($destinationPath), $imageName);
                    
                }else{    
                   
                    $default_pic =  $general->default_pic;
                }
    
    
                $general->company_id       = $company_id;
                $general->company_name     = $company_name;
                $general->logo             = $logo;
                $general->favicon          = $favicon;
                $general->default_pic      = $default_pic;
                $general->established_date = $established_date;
                $general->company_address  = $company_address;
                $general->contact_person   = $contact_person;
                $general->phone_no         = $phone_no;
                $general->email            = $email;
                $general->website          = $website;
                $general->timezone         = $timezone;
                $general->currency         = $currency;
                $general->language         = $language;
                $general->gst_no           = $gst_no;
                $general->pan_no           = $pan_no;
                //$general->modified_dt      = date('Y-mm-dd H:s:m');
               
                $general->update();

                if($general){
                    
                    $result =   response([
                                            'status'    => 200,
                                            'message'   => 'General Setting has been Updated successfully',
                                            'error_msg' => null,
                                            'data'      => $general ,
                                        ],200);

                }else{

                    $result =   response([
                                            'status'    => 401,
                                            'message'   => 'General Setting can not be updated',
                                            'error_msg' => 'General Setting information is worng please try again',
                                            'data'      => null ,
                                        ],401);
                }

            }else{
                

                if($request->logo) { 
                    $imageName = idate("B").rand(1,50).'.'.$request->logo->extension(); 
                    // //Storage::disk('public')->putFileAs('/awards', $request->logo,$imageName,'public');  
    
                    $destinationPath = 'logo';
                    // // $myimage = $request->image->getClientOriginalName();
                    $logo = $request->logo->move(public_path($destinationPath), $imageName);
                
                }else{
                    $logo        = null;
                }
                
                
                if($request->favicon) { 
                    $imageName = idate("B").rand(1,50).'.'.$request->favicon->extension(); 
                                     
                    $destinationPath = 'favicon';
                    // //  $myimage = $request->favicon->getClientOriginalName();
                    $favicon = $request->favicon->move(public_path($destinationPath), $imageName);
                    
                }else{
                    $favicon     = null;
                }


                if ($request->default_pic) { 
                    $imageName = idate("B").rand(1,50).'.'.$request->default_pic->extension(); 
                                     
                    $destinationPath = 'default';
                    // //  $myimage = $request->favicon->getClientOriginalName();
                    $default_pic = $request->default_pic->move(public_path($destinationPath), $imageName);
                    
                }else{    
                   
                    $default_pic = null;
                }
    
                $add_general = new General; 
                $add_general->company_id       = $company_id;
                $add_general->company_name     = $company_name;
                $add_general->logo             = $logo;
                $add_general->favicon          = $favicon;
                $add_general->default_pic      = $default_pic;
                $add_general->established_date = $established_date;
                $add_general->company_address  = $company_address;
                $add_general->contact_person   = $contact_person;
                $add_general->phone_no         = $phone_no;
                $add_general->email            = $email;
                $add_general->website          = $website;
                $add_general->timezone         = $timezone;
                $add_general->currency         = $currency;
                $add_general->language         = $language;
                $add_general->gst_no           = $gst_no;
                $add_general->pan_no           = $pan_no;
                // $add_general->created_dt       = date('Y-mm-dd H:s:m');
                // $add_general->modified_dt      = date('Y-mm-dd H:s:m');

            
                $add_general->save();

                return response([
                                    'status'    => 200,
                                    'message'   => 'General Setting has been created successfully',
                                    'error_msg' => null,
                                    'data'      => null ,
                                ],200);

            }
            
        }

     
    }
   
}
