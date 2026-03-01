<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Company;
use App\Models\General;
use App\Models\State;
use App\Models\Staff;
use Laravel\Passport\HasApiTokens;


class LoginController extends Controller
{
    //
    public function login(Request $request){
        
        $username = $request->username;
        $password = $request->password;

        $validator = Validator::make($request->all(), [
            'username' => 'required|max:255',
            'password' => 'required|min:4',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 422, 'message' => 'Validation Error', 'error_msg' => $validator->errors(), 'data' => null],422);
        }else{

            // $user = User::where('username',$username)->first();
            $user = User::select('users.*', 'staff.status')
            ->leftJoin('staff', 'users.staff_id', '=', 'staff.staff_id')
            ->where('staff.status', '!=', 2)
            ->where('users.username', $username)
            ->first();

            if ($user) {

                if (Hash::check($password, $user->password)) {
                 
                 //   $token      = $user->createToken('authToken')->accessToken;
                 $token = $user->createToken('authToken')->accessToken;
                  //  $token = $user->createToken('authToken')->access_token;
                    $role       = $user->role_id;
                    $staff_id   = $user->staff_id;

                    $company = Company::where('company_id',$user->company_id)->first();
                    $company_name = $company->company_name;
                    
                    $general = General::where('company_id',$user->company_id)->first();
                    
                    $staff = Staff::where('staff_id',$staff_id)->first();

                    $userDetails = [
                        'user_id'    => $user->id,
                        'username'   => $user->username,
                        'role'       => $role, 
                        'staff_id'   => $staff_id,
                        'token'      => $token,
                        'company_name' => $company_name,
                        'branch_id'   =>$staff->branch_id,
                        
                    ];

                    return response()->json(['status' => 200, 'message' => 'Successfully Logged In', 'error_msg' => null, 'data' => $userDetails],200);
                } else {
                    $response = ['status' => 422, 'message' => 'Password is wrong! Please enter correct password', "error_msg" => null, 'data' => null];
                    return response($response);
                }
            } else {
                $response = ['status' => 422, 'message' => 'User does not exist', "error_msg" => null, 'data' => null];
                return response($response);

            }
        }
    }

    public function Logout(Request $request)
    {   
        try {
            $user = $request->user()->token()->revoke();

            // return $user;
            //$user->revoke();

            //$authUserId = $request->auth()->user_id;
            if ($user) {

            //     $update = User::where('user_id', $authUserId)->update(['verification_code' => '']);
                $response = ['status' => 200, 'message' => 'You have been successfully logged out!', 'error_msg' => null, 'data' => null];
                 return response($response,200);

            } else {
                return response()->json(['status' => 500, 'message' => 'User Not Found', 'error_msg' => null, 'data' => null],500);
            }

        } catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => 'Exception Error', 'error_msg' => $th->getMessage(), 'data' => null],500);
        }

    }

    public function State(){
        $states = State::all();
        return response()->json([
            'data' => $states,
            'status '=> 200,
        ],200);
    }
}
