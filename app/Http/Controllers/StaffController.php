<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\Staff;
use App\Models\User;
use App\Models\Company;
use App\Models\Branch;
class StaffController extends BaseController
{
    // public function All(Request $request){
        
    //     $department_id = $request->department_id;
    //     $branch_id = $request->branch_id;
    //   // echo $department_id;

    //     $staff = Staff::select('staff.*','company.company_id','company.company_name','staff.name','staff.phone_no','staff.email','staff.status','department.department_id','department.department_name','job_designation.job_id','job_designation.designation','role.role_id','role.role_name','staff.emergency_contact','staff.address','staff.gender')
    //     ->join('company', 'company.company_id','=','staff.company_id')
    //     // ->join('branch', 'branch.branch_id','=','staff.branch_id')
    //     ->join('department', 'department.department_id','=','staff.dept_id')
    //     ->join('job_designation', 'job_designation.job_id','=','staff.job_id')
    //     ->join('role', 'role.role_id','=','staff.role_id')
    //     ->where('staff.status', '!=', 2)
    //     ->where('staff.staff_id', '!=', 1);

    //     if($department_id >= 1){
    //         $staff = $staff->where('staff.dept_id', $department_id);
    //     }

    //     // if(isset($branch_id)){
    //     //     if(is_array($branch_id) && count($branch_id) > 0){
    //     //         // $staff = $staff->whereIn('staff.branch_id', $branch_id);
    //     //         $staff = $staff->where(function($query) use ($branch_id) {
    //     //             foreach ($branch_id as $branch) {
    //     //                 $query->orWhereJsonContains('staff.branch_id', $branch);
    //     //             }
    //     //         });
    //     //     } else if($branch_id > 0){
    //     //         // $staff = $staff->where('staff.branch_id',$branch_id);
    //     //         $staff = $staff->whereJsonContains('staff.branch_id', $branch_id);
    //     //     }
    //     // }
    //     if ($branch_id > 0) {
    //         $idArray = explode(',', $branch_id); 
    //         $staff = $staff->orWhereJsonContains('staff.branch_id', $idArray);
    //     }
        
    //     $staff= $staff->get();

    //     //  return $staff;

    //     $data= [];
    //     foreach($staff as $val){
    //         $data[] = [
    //             'staff_id'                 => $val->staff_id,
    //             'status'                   => $val->status,
    //             'phone_no'                 => $val->phone_no,
    //             'email'                    => $val->email,
    //             'department_id'            => $val->department_id,
    //             'role_id'                  => $val->role_id,
    //             'name'                     => $val->name,
    //             'address'                  => $val->address,
    //             'designation_id'           => $val->designation_id,
    //             'department_name'          => $val->department_name,
    //             'designation_name'         => $val->designation_name,
    //             'branch_id'                => json_decode($val->branch_id)
    //         ];
    //     }


    //     return response([
    //                         'status'    => 200,
    //                         'message'   => 'Success',
    //                         'error_msg' => null,
    //                         'data'      => $data ,
    //                     ],200);

    // }
    
    public function All(Request $request){
        
        $department_id = $request->department_id;
        $branch_id = $request->branch_id;
       // echo $department_id;

        $staff = Staff::select('staff.*','company.company_id','company.company_name','staff.name','staff.phone_no','staff.email','staff.status','department.department_id','department.department_name','job_designation.job_id','job_designation.designation','role.role_id','role.role_name','staff.emergency_contact','staff.address','staff.gender')
        ->join('company', 'company.company_id','=','staff.company_id')
        // ->join('branch', 'branch.branch_id','=','staff.branch_id')
        ->join('department', 'department.department_id','=','staff.dept_id')
        ->leftJoin('job_designation', 'job_designation.job_id','=','staff.job_id')
        ->join('role', 'role.role_id','=','staff.role_id')
        ->where('staff.status', '!=', 2)
        ->where('staff.staff_id', '!=', 1);
        //  ->where('staff.branch_id', 'like', '%' . $branch_id . '%');

        if($department_id >= 1){
            $staff = $staff->where('staff.dept_id', $department_id);
        }
         if($branch_id !== 'all'){
            $staff = $staff->where('staff.branch_id', 'like', '%' . $branch_id . '%');
        }
        // if($branch_id !== 'all'){
        //     $staff = $staff->where('staff.branch_id', 'like', '%' . $branch_id . '%');
        // }
        // return $branch_id;
        // if(isset($branch_id)){
        //     if(is_array($branch_id) && count($branch_id) > 0){
        //         // $staff = $staff->whereIn('staff.branch_id', $branch_id);
        //         $staff = $staff->where(function($query) use ($branch_id) {
        //             foreach ($branch_id as $branch) {
        //                 $idArray = explode(',', $branch);
        //                 $query->orWhereJsonContains('staff.branch_id', $idArray);
        //             }
        //         });
        //     } else if($branch_id > 0){
        //         $staff = $staff->whereJsonContains('staff.branch_id', $branch_id);
        //     }else{
        //         if ($branch_id > 0) {
        //             $idArray = explode(',', $branch_id); // Convert the comma-separated string to an array
        //             $staff = $staff->whereIn('staff.branch_id', $idArray);
        //         }
        //     }
        // }
        // if ($branch_id > 0) {
        //     $idArray = explode(',', $branch_id); 
        //     $staff = $staff->orWhereJsonContains('staff.branch_id', $idArray);
        // }
        // if ($branch_id > 0) {
        //     $idArray = array_filter(explode(',', $branch_id)); // Remove empty elements from the array
        //     $staff = $staff->orWhere(function ($query) use ($idArray) {
        //         foreach ($idArray as $id) {
        //             $query->orWhereJsonContains('staff.branch_id', $id);
        //         }
        //     });
        // }
        $staff= $staff->get();

        //  return $staff;

        $data= [];
        foreach($staff as $val){

            $branches = json_decode($val->branch_id);
            // $design_id =$branch_id;
            // $list_desings_ids = $branches;

         
           
            
            if(in_array($branch_id, json_decode($branches)))
            {
             
  
                $data[] = [
                    'staff_id'                 => $val->staff_id,
                    'status'                   => $val->status,
                    'phone_no'                 => $val->phone_no,
                    'email'                    => $val->email,
                    'department_id'            => $val->department_id,
                    'role_id'                  => $val->role_id,
                    'name'                     => $val->name,
                    'address'                  => $val->address,
                    'designation_id'           => $val->designation_id,
                    'department_name'          => $val->department_name,
                    'designation_name'         => $val->designation_name,
                    'branch_id'                => $branch_id
                ];
            }else{
                $data[] = [
                    'staff_id'                 => $val->staff_id,
                    'status'                   => $val->status,
                    'phone_no'                 => $val->phone_no,
                    'email'                    => $val->email,
                    'department_id'            => $val->department_id,
                    'role_id'                  => $val->role_id,
                    'name'                     => $val->name,
                    'address'                  => $val->address,
                    'designation_id'           => $val->designation_id,
                    'department_name'          => $val->department_name,
                    'designation_name'         => $val->designation_name,
                    'branch_id'                => json_decode($val->branch_id)
                ];
            }
        
        }


        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $data ,
                        ],200);

    }
    public function Add(Request $request){

        $validator = Validator::make($request->all(), [ 
                                                        // 'phone_no' => 'required|min:10|unique:staff|regex:/^[0-9]*-?[0-9]*$/',
                                                        // 'email'     => 'required|unique:staff|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                                                        // 'password'  => 'required|min:8', 
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

            $company_id       = $company->company_id;
            $branch_id        = $request->branch_id;
            $name             = $request->name;
            $address          = $request->address;
            $phone_no         = $request->phone_no;
            $emergency_contact = $request->emergency_contact;
            $email            = $request->email;
            $date_of_birth    = $request->date_of_birth;
            $date_of_joining  = $request->date_of_joining;
            $gender           = $request->gender;
            $desg_id          = $request->desg_id;
            $dept_id          = $request->dept_id;
            $role_id          = $request->role_id;
           

           
        
        //$chars              = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        // $varification_code  = substr( str_shuffle( $chars ), 0, 15);

            $staff_user   = new Staff;

            $staff_user->company_id       = $company_id;
            $staff_user->branch_id        = json_encode($branch_id);
            $staff_user->name             = $name;
            $staff_user->address          = $address;
            $staff_user->phone_no         = $phone_no;
            $staff_user->emergency_contact = $emergency_contact;
            $staff_user->email            = $email;
            $staff_user->date_of_birth    = $date_of_birth;
            $staff_user->date_of_joining  = $date_of_joining;
            $staff_user->gender           = $gender;
            $staff_user->dept_id          = $dept_id;
            $staff_user->role_id          = $role_id;
            $staff_user->job_id           = $desg_id;

            $staff_user->username          = $request->username;
            $staff_user->password          = $request->password;

            $staff_user->created_by         =  $request->user()->id;
            $staff_user->modified_by        =  $request->user()->id;
            // return $staff_user;    
            $staff_user->save();

            if($staff_user){

                $username = $request->username;
                $password = Hash::make($request->password);    

                $users = new User;

                $users->username    = $username;
                $users->password    = $password;
                $users->role_id     = $role_id;
                $users->company_id  = $company_id;
                $users->staff_id    = $staff_user->staff_id;
                $users->save();


               
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Staff has been created successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([
                        'status'    => 401,
                        'message'   => 'Staff can not be created',
                        'error_msg' => 'Staff information is worng please try again',
                        'data'      => null ,
                    ],401);
            }
            
            
        }

        return $result;
    }

    // public function Edit($id){

    //     // $staff = Staff::select('staff.staff_id','company.company_id','company.company_name','branch.branch_id','branch.branch_name','staff.name','staff.phone_no','staff.email','staff.status','department.department_id','department.department_name','job_designation.job_id','job_designation.designation','role.role_id','role.role_name','staff.emergency_contact','staff.address','staff.gender','staff.date_of_joining','staff.date_of_birth','staff.username','staff.password')
    //     $staff = Staff::select('staff.*','company.company_id','company.company_name','staff.name','staff.phone_no','staff.email','staff.status','department.department_id','department.department_name','job_designation.job_id','job_designation.designation','role.role_id','role.role_name','staff.emergency_contact','staff.address','staff.gender')
    //     ->join('company', 'company.company_id','=','staff.company_id')
    //     // ->join('branch', 'branch.branch_id','=','staff.branch_id')
    //     ->join('department', 'department.department_id','=','staff.dept_id')
    //     ->leftJoin('job_designation', 'job_designation.job_id','=','staff.job_id')
    //     ->join('role', 'role.role_id','=','staff.role_id')
    //     ->where('staff_id', $id);
        
    //     $staff= $staff->get();

    //     //  return $staff;

    //     $data= [];
    //     foreach($staff as $val){
         
    //         $cleanedBranchId = stripslashes($val->branch_id); // Remove the extra backslashes
    //         $jsonString = trim($cleanedBranchId, '""'); // Remove the double quotes from the beginning and end

    //         $branchIdsArray = explode(',', $jsonString);

    //         $branches = Branch::whereIn('branch_id', $branchIdsArray)->get();

    //         $branchNames = $branches->pluck('branch_name')->toArray();

    //         // foreach ($branchIdsArray as $index => $branchId) {
    //             $data[] = [
    //                 'staff_id'                 => $val->staff_id,
    //                 'status'                   => $val->status,
    //                 'phone_no'                 => $val->phone_no,
    //                 'email'                    => $val->email,
    //                 'gender'                   => $val->gender,
    //                 'date_of_joining'          => $val->date_of_joining,
    //                 'emergency_contact'        => $val->emergency_contact,
    //                 'date_of_birth'            => $val->date_of_birth,
    //                 'department_id'            => $val->department_id,
    //                 'role_id'                  => $val->role_id,
    //                 'role_name'                => $val->role_name,
    //                 'name'                     => $val->name,
    //                 'address'                  => $val->address,
    //                 'designation_id'           => $val->job_id,
    //                 'department_name'          => $val->department_name,
    //                 'designation_name'         => $val->designation,
    //                 'username'                 => $val->username,
    //                 'password'                 => $val->password,
    //                 'branch_id'                => json_decode($val->branch_id),
    //                  'branch_name'              => $branchNames, // Retrieve the corresponding branch_name
    //             ];
    //         // }
    //         // $data[] = [
    //         //     'staff_id'                 => $val->staff_id,
    //         //     'status'                   => $val->status,
    //         //     'phone_no'                 => $val->phone_no,
    //         //     'email'                    => $val->email,
    //         //     'gender'                   => $val->gender,
    //         //     'date_of_joining'          => $val->date_of_joining,
    //         //     'emergency_contact'        => $val->emergency_contact,
    //         //     'date_of_birth'            => $val->date_of_birth,
    //         //     'department_id'            => $val->department_id,
    //         //     'role_id'                  => $val->role_id,
    //         //     'role_name'                => $val->role_name,
    //         //     'name'                     => $val->name,
    //         //     'address'                  => $val->address,
    //         //     'designation_id'           => $val->job_id,
    //         //     'department_name'          => $val->department_name,
    //         //     'designation_name'              => $val->designation,
    //         //     'username'                 => $val->username,
    //         //     'password'                 => $val->password,
    //         //     'branch_id'                => json_decode($val->branch_id),
    //         //     'branch_name'              => $branchNames,
    //         // ];
    //     }

        

    //     return response([
    //         'data' => $data,
    //         'status' => 200
    //     ],200);

    // }
    //  public function Edit($id)
    // {
    //     $staff = Staff::select('staff.*', 'company.company_id', 'company.company_name', 'staff.name', 'staff.phone_no', 'staff.email', 'staff.status', 'department.department_id', 'department.department_name', 'job_designation.job_id', 'job_designation.designation', 'role.role_id', 'role.role_name', 'staff.emergency_contact', 'staff.address', 'staff.gender')
    //         ->join('company', 'company.company_id', '=', 'staff.company_id')
    //         ->join('department', 'department.department_id', '=', 'staff.dept_id')
    //         ->leftJoin('job_designation', 'job_designation.job_id', '=', 'staff.job_id')
    //         ->join('role', 'role.role_id', '=', 'staff.role_id')
    //         ->where('staff_id', $id)
    //         ->get();
    
    //     $data = [];
    //     foreach ($staff as $val) {
    //         // Clean up the branch_id string and decode it
    //         $branchIdsString = $val->branch_id;
    //         $cleanedBranchIdsString = str_replace(['[', ']', '"'], '', $branchIdsString);
    //         $branchIdsArray = explode(',', $cleanedBranchIdsString);
            
    //         // Retrieve the corresponding branch names
    //         $branches = Branch::whereIn('branch_id', $branchIdsArray)->get();
    //         $branchNames = $branches->pluck('branch_name')->toArray();
    
    //         $data[] = [
    //             'staff_id' => $val->staff_id,
    //             'status' => $val->status,
    //             'phone_no' => $val->phone_no,
    //             'email' => $val->email,
    //             'gender' => $val->gender,
    //             'date_of_joining' => $val->date_of_joining,
    //             'emergency_contact' => $val->emergency_contact,
    //             'date_of_birth' => $val->date_of_birth,
    //             'department_id' => $val->department_id,
    //             'role_id' => $val->role_id,
    //             'role_name' => $val->role_name,
    //             'name' => $val->name,
    //             'address' => $val->address,
    //             'designation_id' => $val->job_id,
    //             'department_name' => $val->department_name,
    //             'designation_name' => $val->designation,
    //             'username' => $val->username,
    //             'password' => $val->password,
    //             'branch_id' => $branchIdsArray,
    //             'branch_name' => $branchNames,
    //         ];
    //     }
    
    //     return response([
    //         'data' => $data,
    //         'status' => 200
    //     ], 200);
    // }
public function Edit($id){

        // $staff = Staff::select('staff.staff_id','company.company_id','company.company_name','branch.branch_id','branch.branch_name','staff.name','staff.phone_no','staff.email','staff.status','department.department_id','department.department_name','job_designation.job_id','job_designation.designation','role.role_id','role.role_name','staff.emergency_contact','staff.address','staff.gender','staff.date_of_joining','staff.date_of_birth','staff.username','staff.password')
        $staff = Staff::select('staff.*','company.company_id','company.company_name','staff.name','staff.phone_no','staff.email','staff.status','department.department_id','department.department_name','job_designation.job_id','job_designation.designation','role.role_id','role.role_name','staff.emergency_contact','staff.address','staff.gender')
        ->join('company', 'company.company_id','=','staff.company_id')
        // ->join('branch', 'branch.branch_id','=','staff.branch_id')
        ->join('department', 'department.department_id','=','staff.dept_id')
        ->leftJoin('job_designation', 'job_designation.job_id','=','staff.job_id')
        ->join('role', 'role.role_id','=','staff.role_id')
        ->where('staff_id', $id);
        
        $staff= $staff->get();

        //  return $staff;

        $data= [];
        foreach($staff as $val){
         
            $cleanedBranchId = stripslashes($val->branch_id); // Remove the extra backslashes
            $jsonString = trim($cleanedBranchId, '""'); // Remove the double quotes from the beginning and end

            $branchIdsArray = explode(',', $jsonString);

            $branches = Branch::whereIn('branch_id', $branchIdsArray)->get();

            $branchNames = $branches->pluck('branch_name')->toArray();

            // foreach ($branchIdsArray as $index => $branchId) {
                $data[] = [
                    'staff_id'                 => $val->staff_id,
                    'status'                   => $val->status,
                    'phone_no'                 => $val->phone_no,
                    'email'                    => $val->email,
                    'gender'                   => $val->gender,
                    'date_of_joining'          => $val->date_of_joining,
                    'emergency_contact'        => $val->emergency_contact,
                    'date_of_birth'            => $val->date_of_birth,
                    'department_id'            => $val->department_id,
                    'role_id'                  => $val->role_id,
                    'role_name'                => $val->role_name,
                    'name'                     => $val->name,
                    'address'                  => $val->address,
                    'designation_id'           => $val->job_id,
                    'department_name'          => $val->department_name,
                    'designation_name'         => $val->designation,
                    'username'                 => $val->username,
                    'password'                 => $val->password,
                    'branch_id'                => json_decode($val->branch_id),
                     'branch_name'              => $branchNames, // Retrieve the corresponding branch_name
                ];
            // }
            // $data[] = [
            //     'staff_id'                 => $val->staff_id,
            //     'status'                   => $val->status,
            //     'phone_no'                 => $val->phone_no,
            //     'email'                    => $val->email,
            //     'gender'                   => $val->gender,
            //     'date_of_joining'          => $val->date_of_joining,
            //     'emergency_contact'        => $val->emergency_contact,
            //     'date_of_birth'            => $val->date_of_birth,
            //     'department_id'            => $val->department_id,
            //     'role_id'                  => $val->role_id,
            //     'role_name'                => $val->role_name,
            //     'name'                     => $val->name,
            //     'address'                  => $val->address,
            //     'designation_id'           => $val->job_id,
            //     'department_name'          => $val->department_name,
            //     'designation_name'              => $val->designation,
            //     'username'                 => $val->username,
            //     'password'                 => $val->password,
            //     'branch_id'                => json_decode($val->branch_id),
            //     'branch_name'              => $branchNames,
            // ];
        }

        

        return response([
            'data' => $data,
            'status' => 200
        ],200);

    }
    public function View($id)
    {
        $staff = Staff::select('staff.*', 'company.company_id', 'company.company_name', 'staff.name', 'staff.phone_no', 'staff.email', 'staff.status', 'department.department_id', 'department.department_name', 'job_designation.job_id', 'job_designation.designation', 'role.role_id', 'role.role_name', 'staff.emergency_contact', 'staff.address', 'staff.gender')
            ->join('company', 'company.company_id', '=', 'staff.company_id')
            ->join('department', 'department.department_id', '=', 'staff.dept_id')
            ->leftJoin('job_designation', 'job_designation.job_id', '=', 'staff.job_id')
            ->join('role', 'role.role_id', '=', 'staff.role_id')
            ->where('staff_id', $id)
            ->get();
    
        $data = [];
        foreach ($staff as $val) {
            // Clean up the branch_id string and decode it
            $branchIdsString = $val->branch_id;
            $cleanedBranchIdsString = str_replace(['[', ']', '"'], '', $branchIdsString);
            $branchIdsArray = explode(',', $cleanedBranchIdsString);
            
            // Retrieve the corresponding branch names
            $branches = Branch::whereIn('branch_id', $branchIdsArray)->get();
            $branchNames = $branches->pluck('branch_name')->toArray();
    
            $data[] = [
                'staff_id' => $val->staff_id,
                'status' => $val->status,
                'phone_no' => $val->phone_no,
                'email' => $val->email,
                'gender' => $val->gender,
                'date_of_joining' => $val->date_of_joining,
                'emergency_contact' => $val->emergency_contact,
                'date_of_birth' => $val->date_of_birth,
                'department_id' => $val->department_id,
                'role_id' => $val->role_id,
                'role_name' => $val->role_name,
                'name' => $val->name,
                'address' => $val->address,
                'designation_id' => $val->job_id,
                'department_name' => $val->department_name,
                'designation_name' => $val->designation,
                'username' => $val->username,
                'password' => $val->password,
                'branch_id' => $branchIdsArray,
                'branch_name' => $branchNames,
            ];
        }
    
        return response([
            'data' => $data,
            'status' => 200
        ], 200);
    }
    public function Update(Request $request,$id){

       

        $validator = Validator::make($request->all(), [ 
            // 'phone_no' => 'required|min:10|unique:staff,phone_no,'.$id.',staff_id|regex:/^[0-9]*-?[0-9]*$/',
            // 'email'     => 'required|unique:staff,email,'.$id.',staff_id|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            // 'password'  => 'required|min:8', 
           
        ]);

        if($validator->fails()) {

            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg' => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

        }else{


            $company_id        = 1;
            $branch_id         = $request->branch_id;
            $name              = $request->name;
            $address           = $request->address;
            $phone_no          = $request->phone_no;
            $emergency_contact = $request->emergency_contact;
            $email             = $request->email;
            $date_of_birth     = $request->date_of_birth;
            $date_of_joining   = $request->date_of_joining;
            $salary            = $request->salary;
            $gender            = $request->gender;
            $marital_status    = $request->marital_status;
            $date_of_relieve   = $request->date_of_relieve;
            $dept_id           = $request->dept_id;
            $role_id           = $request->role_id;
            $job_id            = $request->desg_id;

           
        
            $staff_user   = Staff::where('staff_id',$id)->first();
            

            $staff_user->company_id        = $company_id;
            $staff_user->branch_id        = json_encode($branch_id);
            $staff_user->name              = $name;
            $staff_user->address           = $address;
            $staff_user->phone_no          = $phone_no;
            $staff_user->emergency_contact = $emergency_contact;
            $staff_user->email             = $email;
            $staff_user->date_of_birth     = $date_of_birth;
            $staff_user->date_of_joining   = $date_of_joining;
            $staff_user->salary            = $salary;
            $staff_user->gender            = $gender;
            $staff_user->marital_status    = $marital_status;
            $staff_user->date_of_relieve   = $date_of_relieve;
            $staff_user->dept_id           = $dept_id;
            $staff_user->role_id           = $role_id;
            $staff_user->job_id            = $job_id;
            $staff_user->username          = $request->username;
            $staff_user->password          = $request->password;
            $staff_user->modified_by       = $request->user()->id;


            $staff_user->update();

            if($staff_user){

                $password = Hash::make($request->password);    

                $users = User::where('staff_id',$id)->first();

                $users->username    = $request->username;
                $users->password    = $password;

                $users->update();
            
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Staff has been updated successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([
                        'status'    => 401,
                        'message'   => 'Staff can not be created',
                        'error_msg' => 'Staff information is worng please try again',
                        'data'      => null ,
                    ],401);
            }

            return $result;
        }
        
    }
    public function Delete($id){

        $status = Staff::where('staff_id', $id)->first();

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

        $status = Staff::where('staff_id', $id)->first();

        if($status){
            $status->status = $request->status;
            $status->modified_by        =  $request->user()->id;
            $status->update();
            return response([
                'data' => null,
                'message' => 'Successfully Update',
                'status' => 200
            ],200);
        }else{
            return response([
                'data' => null,
                'message' => 'No data found',
                'status' => 404
            ],404); 
        }

       
    }
    public function UserEdit($id){

       
        $staff = Staff::select('staff.*','staff.name','staff.phone_no','staff.email','staff.status','role.role_id','role.role_name','staff.emergency_contact','staff.address','staff.gender')

       
        ->join('role', 'role.role_id','=','staff.role_id')
        ->where('staff_id', $id);
        
        $staff= $staff->get();

        //  return $staff;

        $data= [];
        foreach($staff as $val){
         
            $cleanedBranchId = stripslashes($val->branch_id); 
            $jsonString = trim($cleanedBranchId, '""'); 

            $branchIdsArray = explode(',', $jsonString);

            $branches = Branch::whereIn('branch_id', $branchIdsArray)->get();

            $branchNames = $branches->pluck('branch_name')->toArray();
        
                $data[] = [
                    'staff_id'                 => $val->staff_id,
                    'staff_name'                 => $val->name,
                    'status'                   => $val->status,
                    'phone_no'                 => $val->phone_no,
                    'email'                    => $val->email,
                    'gender'                   => $val->gender,
                    'date_of_joining'          => $val->date_of_joining,
                    'emergency_contact'        => $val->emergency_contact,
                    'date_of_birth'            => $val->date_of_birth,
                    'department_id'            => $val->department_id,
                    'role_id'                  => $val->role_id,
                    'role_name'                => $val->role_name,
                    'name'                     => $val->name,
                    'address'                  => $val->address,
                    'designation_id'           => $val->job_id,
                    'department_name'          => $val->department_name,
                    'designation_name'         => $val->designation,
                    'username'                 => $val->username,
                    'password'                 => $val->password,
                    'profile_pic'              => $val->profile_pic,
                    'branch_id'                => json_decode($val->branch_id),
                     'branch_name'             => $branchNames, 
                ];
                    
        }

        

        return response([
            'data' => $data,
            'status' => 200
        ],200);

    }

    public function UserUpdate(Request $request,$id){

       

        $validator = Validator::make($request->all(), [ 
            // 'phone_no' => 'required|min:10|unique:staff,phone_no,'.$id.',staff_id|regex:/^[0-9]*-?[0-9]*$/',
            // 'email'     => 'required|unique:staff,email,'.$id.',staff_id|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            // 'password'  => 'required|min:8', 
           
        ]);

        if($validator->fails()) {

            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg' => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

        }else{


            $name              = $request->name;
            $address           = $request->address;
            $phone_no          = $request->phone_no;
            $email             = $request->email;
            $date_of_birth     = $request->date_of_birth;

           
           
        
            $staff_user   = Staff::where('staff_id',$id)->first();
            
            if($request->profile_pic) { 
                $imageName = idate("B").rand(1,50).'.'.$request->profile_pic->extension(); 
                // //Storage::disk('public')->putFileAs('/awards', $request->logo,$imageName,'public');  

                $destinationPath = 'profile_pic';
                // // $myimage = $request->image->getClientOriginalName();
                //$logo = $request->logo->move(public_path($destinationPath), $imageName);
                 $request->profile_pic->move(public_path($destinationPath), $imageName);
                $profile_pic = "https://crm.renewhairandskincare.com/new/renew_api/public/".$destinationPath ."/".$imageName;
            
            }else{
                $profile_pic        =  $staff_user->profile_pic;
            }
            $staff_user->name              = $name;
            $staff_user->address           = $address;
            $staff_user->phone_no          = $phone_no;
            $staff_user->email             = $email;
            $staff_user->profile_pic       = $profile_pic;
            $staff_user->modified_by       = $request->user()->id;


            $staff_user->update();

            if($staff_user){

            
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'User Profile has been updated successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([
                        'status'    => 401,
                        'message'   => 'User Profile can not be created',
                        'error_msg' => 'User Profile information is worng please try again',
                        'data'      => null ,
                    ],401);
            }

            return $result;
        }
        
    }
}
