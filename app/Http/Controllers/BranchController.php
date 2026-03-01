<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Branch;
use App\Models\Company;
class BranchController extends BaseController
{
    public function Index(){
        
        $branch = Branch::select('branch.branch_id as branch_id','company.company_name as company_name','branch.branch_name as branch_name','branch.branch_authority as branch_authority','branch.branch_opening_date as branch_opening_date','branch.branch_phone as branch_phone','branch.branch_location as branch_location','branch.branch_email as branch_email','branch.is_franchise as is_franchise','branch.branch_id as branch_id','branch.status as status','staff.name')
                        ->where('branch.status', '!=', 2)
                        ->where('staff.status', '!=', 2)
                        ->join('company', 'company.company_id','=','branch.company_id')
                        ->join('staff', 'staff.staff_id','=','branch.branch_authority')
                        ->get();
        
        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $branch,
                        ],200);

    }
    public function Add(Request $request){
        $validator = Validator::make($request->all(), [ 
                                                        'branch_name' => 'required|unique:branch|max:255',
                                                        'branch_phone' => 'required|unique:branch|max:10',
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

          
        }else{

            $company = Company::where('company_name', $request->company_name)->first();

            $company_id          = $company->company_id;
            $branch_name         = $request->branch_name;
            $branch_email        = $request->branch_email;
            $branch_location     = $request->branch_location;
            $branch_phone        = $request->branch_phone;  
            $branch_code         = $request->branch_code; 
            $branch_authority    = $request->branch_authority;
            $branch_opening_date = $request->branch_opening_date;
            $is_franchise        = $request->is_franchise;         
        
            $branch   = new Branch;

            $branch->company_id          = $company_id;
            $branch->branch_name         = $branch_name;
            $branch->branch_email         = $branch_email;
            $branch->branch_location     = $branch_location;
            $branch->branch_phone        = $branch_phone;
             $branch->branch_code         = $branch_code;
            $branch->branch_authority    = $branch_authority;
            $branch->branch_opening_date = $branch_opening_date;
            $branch->is_franchise        = $is_franchise ;
            $branch->created_by          = $request->user()->id;
            $branch->modified_by         = $request->user()->id;
            
        
            $branch->save();

            if($branch){
                
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Branch has been created successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([
                        'status'    => 401,
                        'message'   => 'Branch can not be created',
                        'error_msg' => 'Branch information is worng please try again',
                        'data'      => null ,
                    ],401);
            }
            
            
        }

        return $result;
    }
    public function Edit($id){

        $branch = Branch::select('branch.branch_id as branch_id','company.company_name as company_name','branch.branch_name as branch_name','branch.branch_code as branch_code','branch.branch_authority as branch_authority','branch.branch_opening_date as branch_opening_date','branch.branch_phone as branch_phone','branch.branch_location as branch_location','branch.branch_email as branch_email','branch.is_franchise as is_franchise','branch.branch_id as branch_id','branch.status as status','staff.name')->where('branch.status', '!=', 2)
                        ->join('company', 'company.company_id','=','branch.company_id')
                        ->join('staff', 'staff.staff_id','=','branch.branch_authority')
                        ->where('branch.branch_id', $id)
                        ->get();
        return response([
            'data' => $branch,
            'status' => 200
        ],200);

    }
    public function Update(Request $request, $id){

        $validator = Validator::make($request->all(), [ 
                                                        'branch_name' => 'required|unique:branch,branch_name,'.$id.',branch_id|max:255',
                                                     
                                                    ]);

        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

        }else{

            $company = Company::where('company_name', $request->company_name)->first();

            $company_id          = $company->company_id;
            $branch_name         = $request->branch_name;
            $branch_email        = $request->branch_email;
            $branch_location     = $request->branch_location;
            $branch_phone        = $request->branch_phone;   
            $branch_code        = $request->branch_code;  
            $branch_authority    = $request->branch_authority;
            $branch_opening_date = $request->branch_opening_date;
            $is_franchise        = $request->is_franchise;             
            
            $branch = Branch::find($id);

            $branch->company_id          = $company_id;
            $branch->branch_name         = $branch_name;
            $branch->branch_email         = $branch_email;
            $branch->branch_location     = $branch_location;
            $branch->branch_phone        = $branch_phone;
            $branch->branch_code         = $branch_code;
            $branch->branch_authority    = $branch_authority;
            $branch->branch_opening_date = $branch_opening_date;
            $branch->is_franchise        = $is_franchise;
            $branch->modified_by         = $request->user()->id;
            $branch->update();

            $result =   response([
                                    'status'    => 200,
                                    'message'   => 'success',
                                    'error_msg' => null,
                                    'data'      => $branch,
                                ],200);
        }

        return $result;
    }

    public function Delete($id){

        $status = Branch::where('branch_id', $id)->first();

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

        $branch_status = Branch::where('branch_id', $id)->first();

        if($branch_status){
            $branch_status->status = $request->status;
            $branch_status->modified_by         = $request->user()->id;
            $branch_status->update();
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
