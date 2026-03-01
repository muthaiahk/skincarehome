<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use App\Models\AppointmentPayment;
use App\Models\Company;
use App\Models\Staff;
use App\Models\User;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\Treatment;
use App\Models\Notification;
use App\Models\TreatmentCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerTreatment;

class AppointmentController extends Controller
{
    //
    public function All(Request $request)
    {
        $app = Appointment::select('appointment.appointment_id', 'appointment.company_id', 'company.company_name', 'appointment.problem', 'appointment.remark', 'appointment.status', 'appointment.staff_id', 'appointment.lead_id', 'appointment.customer_id', 'appointment.app_status', 'appointment.lead_status_id', 'staff.name as staff_name', 'appointment.tc_id', 'appointment.treatment_id', 'appointment.date', 'appointment.time')
            ->leftjoin('company', 'company.company_id', '=', 'appointment.company_id')
            ->leftjoin('staff', 'staff.staff_id', '=', 'appointment.staff_id')
            ->where('appointment.status', '!=', 2)
            ->orderBy('appointment.appointment_id', 'desc');

        if (isset($request->branch_id)) {
            if ($request->branch_id > 0) {
                $app = $app->where('appointment.branch_id', $request->branch_id);
            }
        }

        if (isset($request->from) && isset($request->to)) {
            $app = $app->whereBetween('date', [$request->from, $request->to]);
        }

        $page = $request->input('page', 1); // Default to page 1
        $limit = $request->input('limit', 10); // Default limit
        // Get the total count for pagination
        $total = $app->count();
        $app = $app->skip(($page - 1) * $limit)->take($limit)->get();

        //   return $app;

        $data = [];

        foreach ($app as $key =>  $value) {

            if ($value->customer_id) {

                $user_id = $value->customer_id;
                $customer = Customer::where('customer_id', $user_id)->first();
                $username = $customer->customer_first_name . " " . $customer->customer_last_name;
                $phone = $customer ? $customer->customer_phone : '';
                $user_status = "Customer";
                $category = TreatmentCategory::where('tcategory_id', $value->tc_id)->first();
                $tc_name =  $category ? $category->tc_name : '';
                $treatment = Treatment::where('treatment_id', $value->treatment_id)->first();
                $treatment_name = $treatment ? $treatment->treatment_name : '';
                $problem = $treatment_name;
                $branch_id = $customer->branch_id;

            } else {

                $user_id = $value->lead_id;
                $lead = Lead::where('lead_id', $user_id)->first();
                $first = $lead ? $lead->lead_first_name : '';
                $last = $lead ? $lead->lead_last_name : '';
                $username = $first . " " . $last;
                $phone = $lead ? $lead->lead_phone : '';
                $user_status = "Lead";
                $tc_name = "";
                $treatment_name = "";
                $problem = $value->problem;
                $branch_id = $lead ? $lead->branch_id : 0;

            }

            $data[$key] = [

                'appointment_id' =>  $value->appointment_id,
                'date'           => $value->date,
                'time'           => $value->time,
                'user_id'        => $user_id,
                'user_name'      => $username,
                'phone'           => $phone,
                'company_id'     => $value->company_id,
                'company_name'   => $value->company_name,
                'staff_id'       => $value->staff_id,
                'staff_name'     => $value->staff_name,
                'tc_id'          => $value->tc_id,
                'tc_name'        => $tc_name ? $tc_name : '',
                'treatment_id' => $value->treatment_id,
                'treatment_name' => $treatment_name,
                // 'lead_status_id'=> $value->lead_status_id,
                // 'lead_status_name'=> $value->lead_status_name,
                'app_status' => $value->app_status,
                'problem' => $problem,
                'remark' => $value->remark == '' ? '' : $value->remark,
                'status' => $value->status,
                'user_status' => $user_status,
                'branch_id' => $branch_id

            ];
        }

        $branch_id = $request->branch_id;
        $data1 = [];

        foreach ($data as $k => $d) {
            if ($branch_id > 0) {
                if ($d['branch_id'] == $branch_id) {
                    $data1[] = [

                        'appointment_id' => $d['appointment_id'],
                        'date'           => $d['date'],
                        'time'           => $d['time'],
                        'user_id'        => $d['user_id'],
                        'user_name'      => $d['user_name'],
                        'phone'          => $d['phone'],
                        'company_id'     => $d['company_id'],
                        'company_name'   => $d['company_name'],
                        'staff_id'       => $d['staff_id'],
                        'staff_name'     => $d['staff_name'],
                        'tc_id'          => $d['tc_id'],
                        'tc_name'        => $d['tc_name'],
                        'treatment_id'   => $d['treatment_id'],
                        'treatment_name' => $d['treatment_name'],
                        // 'lead_status_id'=> $d['lead_status_id'],
                        // 'lead_status_name'=> $d['lead_status_name'],
                        'app_status'     => $d['app_status'],

                        'problem'        => $d['problem'],
                        'remark'   => $d['remark'],
                        'status' => $d['status'],
                        'user_status' => $d['user_status'],
                        'branch_id' => $d['branch_id']

                    ];
                }
            } else {
                $data1[] = [

                    'appointment_id' => $d['appointment_id'],
                    'date'           => $d['date'],
                    'time'           => $d['time'],
                    'user_id'        => $d['user_id'],
                    'user_name'      => $d['user_name'],
                    'phone'          => $d['phone'],
                    'company_id'     => $d['company_id'],
                    'company_name'   => $d['company_name'],
                    'staff_id'       => $d['staff_id'],
                    'staff_name'     => $d['staff_name'],
                    'tc_id'          => $d['tc_id'],
                    'tc_name'        => $d['tc_name'],
                    'treatment_id' => $d['treatment_id'],
                    'treatment_name' => $d['treatment_name'],
                    // 'lead_status_id'=> $d['lead_status_id'],
                    // 'lead_status_name'=> $d['lead_status_name'],
                    'app_status' => $d['app_status'],
                    'problem' => $d['problem'],
                    'remark' => $d['remark'],
                    'status' => $d['status'],
                    'user_status' => $d['user_status'],
                    'branch_id' => $d['branch_id']

                ];
            }
        }

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $data,
            'total' => $total,
            'page' => $page,
            'limit' => $limit
        ], 200);
    }
    public function Add(Request $request)
    {

        $validator = Validator::make($request->all(), []);


        if ($validator->fails()) {
            $result =   response([
                'status'    => 401,
                'message'   => 'Incorrect format input feilds',
                'error_msg'     => $validator->messages()->get('*'),
                'data'      => null,
            ], 401);
        } else {

            $company = Company::where('company_name', $request->company_name)->first();
            $staff = Staff::where('name', $request->app_staff_name)->first();
            $treatment = Treatment::where('treatment_id', $request->app_treatment_id)->first();



            $company_id         = $company->company_id;
            $user_id            = $request->user_id;

            $app_problem        = $request->app_problem;
            // $app_tc_id          = $treatment->tc_id;
            $app_treatment_id   = $request->app_treatment_id;
            $app_staff_id       = $request->user()->staff_id;
            $app_pn_status      = 0;
            $app_lead_status_id = 0;
            $app_remark         = $request->app_remark;
            $date               = $request->app_date;
            $time               = $request->app_time;





            $add_app   = new Appointment;

            if ($request->is_customer == 0) {

                $chk_app = Appointment::where('app_status', '!=', 2)->where('treatment_id', $app_treatment_id)->where('customer_id', $user_id)->where('date', $date)->first();

                if ($chk_app) {
                    return response([
                        'status'    => 401,
                        'message'   => 'Appointment already Fixed',
                        'error_msg' => 'Appointment already Fixed',
                        'data'      => null,
                    ], 401);
                }

                $tc = Treatment::where('treatment_id', $app_treatment_id)->first();
                $customer = Customer::where('customer_id', $user_id)->first();

                $add_app->customer_id           = $user_id;
                $add_app->tc_id                 = $tc->tc_id;
                $add_app->treatment_id          = $app_treatment_id;
                $add_app->branch_id              = $customer->branch_id;
            } else if ($request->is_customer == 1) {

                $chk_app = Appointment::where('lead_id', $user_id)->where('date', $date)->where('time')->first();

                if ($chk_app) {
                    return response([
                        'status'    => 401,
                        'message'   => 'Appointment already Fixed',
                        'error_msg' => 'Appointment already Fixed',
                        'data'      => null,
                    ], 401);
                }
                $lead = Lead::where('lead_id', $user_id)->first();
                $add_app->lead_id               = $user_id;
                $add_app->tc_id                 = null;
                $add_app->treatment_id          = null;
                $add_app->branch_id             = $lead->branch_id;
            }

            $add_app->company_id            = $company_id;
            $add_app->problem               = $app_problem;

            $add_app->staff_id              = $app_staff_id;
            $add_app->app_status            = $app_pn_status;
            $add_app->lead_status_id        = $app_lead_status_id;
            $add_app->remark                = $app_remark;
            $add_app->date                  = $date;
            $add_app->time                  = $time;
            $add_app->created_by            = $request->user()->id;
            $add_app->modified_by           = $request->user()->id;

            $add_app->save();

            if ($add_app) {

                $add_notify = new Notification();

                $add_notify->content      = " Schedule new appointment ";

                $add_notify->title        = "New Appointment";

                $add_notify->sender_id    = $request->user()->staff_id;

                $add_notify->receiver_id  = 1;

                $add_notify->alert_status = 2;

                $add_notify->created_by   = $request->user()->staff_id;

                $add_notify->updated_by   = $request->user()->staff_id;



                $add_notify->save();
            }

            $result =   response([
                'status'    => 200,
                'message'   => 'Appointment has been created successfully',
                'error_msg' => null,
                'data'      => $request->is_coustomer,
            ], 200);

            // if($add_app){

            //     if($request->is_customer == 0){



            //         $add_cus_treatment   = new CustomerTreatment;

            //         $add_cus_treatment->tc_id              = $treatment->tc_id;
            //         $add_cus_treatment->treatment_id       = $app_treatment_id;
            //         $add_cus_treatment->customer_id        = $add_app->customer_id;
            //         $add_cus_treatment->progress           = 0;
            //         $add_cus_treatment->medicine_prefered  = "";
            //         $add_cus_treatment->remarks            = $app_remark;
            //         $add_cus_treatment->amount             = $treatment ->amount;
            //         $add_cus_treatment->discount           = 0;
            //         $add_cus_treatment->created_by         = 1;
            //         $add_cus_treatment->modified_by        = 1;

            //         $add_cus_treatment->save();
            //     }

            //     $result =   response([
            //                             'status'    => 200,
            //                             'message'   => 'Appointment has been created successfully',
            //                             'error_msg' => null,
            //                             'data'      => $request->is_coustomer ,
            //                         ],200);

            // }else{

            //     $result =   response([
            //             'status'    => 401,
            //             'message'   => 'Appointment can not be created',
            //             'error_msg' => 'Appointment information is worng please try again',
            //             'data'      => null ,
            //         ],401);
            // }


        }

        return $result;
    }
    public function Edit($id)
    {

        // $app = Appointment::select('appointment.appointment_id','appointment.lead_id','appointment.company_id','company.company_name','appointment.staff_id','appointment.problem','appointment.remark','appointment.status','treatment.treatment_name','appointment.staff_id','appointment.lead_id','appointment.customer_id','appointment.app_status','appointment.remark','appointment.status','appointment.lead_status_id','lead_status.lead_status_name','staff.staff_id','staff.name as staff_name')
        //                 ->join('company', 'company.company_id','=','appointment.company_id')
        //                 ->join('treatment', 'treatment.treatment_id','=','appointment.treatment_id')
        //                 ->join('staff', 'staff.staff_id','=','appointment.staff_id')
        //                 ->where('appointment.status', '!=', 2)
        //                 ->leftjoin('lead_status', 'lead_status.lead_status_id','=','appointment.lead_status_id')
        //                 ->orderBy('appointment.created_on', 'desc')
        //                 ->where('appointment.appointment_id', $id)
        //                 ->get();
        // $data= [];
        // foreach($app as $key =>  $value){

        //     if($value->customer_id){
        //         $user_id = $value->customer_id;
        //         $customer = Customer::where('customer_id',$user_id)->first();
        //         $username = $customer->customer_first_name.$customer->customer_last_name;
        //         $user_status = "Customer";

        //     }else{
        //         $user_id = $value->lead_id;
        //         $lead = Lead::where('lead_id',$user_id)->first();
        //         $username = $lead->lead_first_name.$lead->lead_last_name;
        //         $user_status = "Lead";
        //     }


        //     $data[$key] = [
        //                 'appointment_id' =>  $value->appointment_id,
        //                 'user_id'   => $user_id,
        //                 'user_name' => $username,
        //                 'company_id'=> $value->company_id,
        //                 'company_name'=> $value->company_name,
        //                 'staff_id'=> $value->staff_id,
        //                 'staff_name'=> $value->staff_name,
        //                 'lead_status_id'=> $value->lead_status_id,
        //                 'lead_status_name'=> $value->lead_status_name,
        //                 'app_status'=> $value->app_status,
        //                 'treatment_name'=> $value->treatment_name,
        //                 'problem'=> $value->problem,
        //                 'remark'=> $value->remark,
        //                 'status'=> $value->status,
        //                 'user_status'=>$user_status 


        //             ];
        // }




        // return response([
        //                     'status'    => 200,
        //                     'message'   => 'Success',
        //                     'error_msg' => null,
        //                     'data'      => $data ,
        //                 ],200);

        $app = Appointment::select('appointment.appointment_id', 'appointment.company_id', 'company.company_name', 'appointment.problem', 'appointment.remark', 'appointment.status', 'appointment.staff_id', 'appointment.lead_id', 'appointment.customer_id', 'appointment.app_status', 'appointment.lead_status_id', 'staff.name as staff_name', 'appointment.tc_id', 'appointment.treatment_id', 'appointment.date', 'appointment.time')
            ->join('company', 'company.company_id', '=', 'appointment.company_id')
            // ->join('treatment', 'treatment.treatment_id','=','appointment.treatment_id')
            ->join('staff', 'staff.staff_id', '=', 'appointment.staff_id')
            ->where('appointment.status', '!=', 2)
            //->leftjoin('lead_status', 'lead_status.lead_status_id','=','appointment.lead_status_id')
            ->orderBy('appointment.created_on', 'desc')
            ->where('appointment.appointment_id', $id)
            ->get();
        $data = [];
        foreach ($app as $key =>  $value) {

            if ($value->customer_id) {
                $user_id = $value->customer_id;
                $customer = Customer::where('customer_id', $user_id)->first();
                $username = $customer->customer_first_name . $customer->customer_last_name;

                $user_status = "Customer";


                $category = TreatmentCategory::where('tcategory_id', $value->tc_id)->first();
                $tc_name =  $category ? $category->tc_name : '';
                $treatment = Treatment::where('treatment_id', $value->treatment_id)->first();
                $treatment_name = $treatment->treatment_name;
                $problem = $treatment->treatment_name;
            } else {
                $user_id = $value->lead_id;
                $lead = Lead::where('lead_id', $user_id)->first();
                $username = $lead->lead_first_name . $lead->lead_last_name;

                $user_status = "Lead";
                $tc_name = "";
                $treatment_name = "";
                $problem = $value->problem;
            }


            $data[$key] = [

                'appointment_id' =>  $value->appointment_id,
                'date'           => $value->date,
                'time'           => $value->time,
                'user_id'   => $user_id,
                'user_name' => $username,

                'company_id' => $value->company_id,
                'company_name' => $value->company_name,
                'staff_id' => $value->staff_id,
                'staff_name' => $value->staff_name,
                'tc_id' => $value->tc_id,
                'tc_name' => $tc_name ? $tc_name : '',
                'treatment_id' => $value->treatment_id,
                'treatment_name' => $treatment_name,
                // 'lead_status_id'=> $value->lead_status_id,
                // 'lead_status_name'=> $value->lead_status_name,
                'app_status' => $value->app_status,

                'problem' => $problem,
                'remark' => $value->remark,
                'status' => $value->status,
                'user_status' => $user_status


            ];
        }




        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $data,
        ], 200);
    }


    public function Update(Request $request, $id)
    {

        // $validator = Validator::make($request->all(), [ 
        //                                                 'lead_phone' => 'required|unique:lead|numeric|digits:10',
        //                                                 'lead_email' => 'required|unique:lead|email|max:255', 
        //                                             ]);

        // if($validator->fails()) {
        //     $result =   response([
        //                             'status'    => 401,
        //                             'message'   => 'Incorrect format input feilds',
        //                             'error_msg'     => $validator->messages()->get('*'),
        //                             'data'      => null ,
        //                         ],401);

        // }else{
        //     $company_id       = $request->company_id;
        //     $branch_id        = $request->branch_id;
        //     $staff_id         = $request->staff_id;
        //     $lead_first_name  = $request->lead_first_name;
        //     $lead_last_name   = $request->lead_last_name;
        //     $lead_dob         = $request->lead_dob;
        //     $lead_gender      = $request->lead_gender;
        //     $lead_age         = $request->lead_age;
        //     $lead_phone       = $request->lead_phone;
        //     $lead_email       = $request->lead_email;
        //     $lead_address     = $request->lead_address;
        //     $treatment_id     = $request->treatment_id;
        //     $enquiry_date     = $request->enquiry_date;
        //     $lead_status_id   = $request->lead_status_id;
        //     $lead_source_id   = $request->lead_source_id;
        //     $lead_problem     = $request->lead_problem;
        //     $lead_remark      = $request->lead_remark;

        //     $upd_lead = Designation::find($id);

        //     $upd_lead->company_id       = $company_id;
        //     $upd_lead->branch_id        = $branch_id;
        //     $upd_lead->staff_id         = $staff_id;
        //     $upd_lead->lead_first_name  = $lead_first_name;
        //     $upd_lead->lead_last_name   = $lead_last_name;
        //     $upd_lead->lead_dob         = $lead_dob;
        //     $upd_lead->lead_gender      = $lead_gender;
        //     $upd_lead->lead_age         = $lead_age;
        //     $upd_lead->lead_phone       = $lead_phone;
        //     $upd_lead->lead_email       = $lead_email;
        //     $upd_lead->lead_address     = $lead_address;
        //     $upd_lead->treatment_id     = $treatment_id;
        //     $upd_lead->enquiry_date     = $enquiry_date;
        //     $upd_lead->lead_status_id   = $lead_status_id;
        //     $upd_lead->lead_source_id   = $lead_source_id;
        //     $upd_lead->lead_problem     = $lead_problem;
        //     $upd_lead->lead_remark      = $lead_remark;

        //     $upd_lead->update();

        //     $result =   response([
        //                             'status'    => 200,
        //                             'message'   => 'successfull updated',
        //                             'error_msg' => null,
        //                             'data'      => $upd_lead,
        //                         ],200);
        // }

        // return $result;

        $company = Company::where('company_name', $request->company_name)->first();
        $staff = Staff::where('name', $request->app_staff_name)->first();

        $company_id         = $company->company_id;
        $user_id            = $request->user_id;
        $app_problem        = $request->app_problem;
        $app_tc_id          = $request->app_tc_id;
        $app_treatment_id   = $request->app_treatment_id;
        $app_staff_id       = $staff->staff_id;
        $app_pn_status      = 0;
        $app_lead_status_id = 0;
        $app_remark         = $request->app_remark;
        $date               = $request->app_date;
        $time               = $request->app_time;


        $upd_app   = Appointment::where('appointment_id', $id)->first();

        if ($request->is_customer == 0) {

            $upd_app->customer_id           = $user_id;
            $upd_app->tc_id                 = $app_tc_id;
            $upd_app->treatment_id          = $app_treatment_id;
        } else if ($request->is_customer == 1) {

            $upd_app->lead_id               = $user_id;
            $upd_app->tc_id                 = null;
            $upd_app->treatment_id          = null;
        }

        $upd_app->company_id            = $company_id;
        $upd_app->problem               = $app_problem;

        $upd_app->staff_id              = $app_staff_id;
        $upd_app->app_status            = $app_pn_status;
        $upd_app->lead_status_id        = $app_lead_status_id;
        $upd_app->remark                = $app_remark;
        $upd_app->date                  = $date;
        $upd_app->time                  = $time;
        $upd_app->created_by            =  $request->user()->id;
        $upd_app->modified_by           =  $request->user()->id;

        $upd_app->update();

        if ($upd_app) {

            $result =   response([
                'status'    => 200,
                'message'   => 'Appointment has been Updated successfully',
                'error_msg' => null,
                'data'      => $request->is_coustomer,
            ], 200);
        } else {

            $result =   response([
                'status'    => 401,
                'message'   => 'Appointment can not be Updated',
                'error_msg' => 'Appointment information is worng please try again',
                'data'      => null,
            ], 401);
        }
        return $result;
    }

    public function Delete($id)
    {
        $status = Appointment::where('appointment_id', $id)->first();

        if ($status) {
            $status->status = 2;
            $status->update();
        }
        return response([
            'data' => null,
            'message' => 'Successfully Delete',
            'status' => 200
        ], 200);
    }

    public function Status(Request $request, $id)
    {



        $status = Appointment::where('appointment_id', $id)->first();

        if ($status) {
            $status->app_status = $request->status;
            $status->modified_by           =  $request->user()->id;
            $status->update();
        } else {
            return response([
                'data' => null,
                'message' => 'No data found',
                'status' => 404
            ], 404);
        }


        return response([
            'data' => null,
            'message' => 'Successfully Check In',
            'status' => 200
        ], 200);
    }

    public function Payment(Request $request)
    {

        $app_id = $request->app_id;
        $paid_mode = $request->paid_mode;
        $amount = $request->amount;

        $payment = new AppointmentPayment;
        $payment->app_id        = $app_id;
        $payment->mode          = $paid_mode;
        $payment->amount        = $amount;
        $payment->created_by    = $request->user()->id;
        $payment->updated_by   = $request->user()->id;
        $payment->save();

        if ($payment) {

            $app_upd = Appointment::where('appointment_id', $app_id)->first();

            $app_upd->app_status = 2;
            $app_upd->update();

            return response([
                'data' => null,
                'message' => 'Successfully Added !',
                'status' => 200
            ], 200);
        } else {
            return response([
                'data' => null,
                'message' => 'Payment not updated in database !',
                'status' => 400
            ], 400);
        }
    }

    public function Remark(Request $request, $id)
    {


        $status = Appointment::where('appointment_id', $id)->first();

        if ($status) {
            $status->remark = $request->remark;
            $status->update();
            return response([
                'data' => null,
                'message' => 'Successfully updated!',
                'status' => 200
            ], 200);
        } else {
            return response([
                'data' => null,
                'message' => 'No data found',
                'status' => 404
            ], 404);
        }
    }
}
