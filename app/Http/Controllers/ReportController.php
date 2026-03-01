<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Lead;
use App\Models\Appointment;
use App\Models\Inventory;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Staff;
use App\Models\Customer;
use App\Models\CustomerTreatment;
use App\Models\Stock;


class ReportController extends Controller
{
    //

    public function LeadReport(Request $request){
     
        $lead_source_id = $request->lead_source_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $lead_report = Lead::select('lead.lead_id','lead.company_id','company.company_name','lead.branch_id','lead.staff_id','lead.lead_first_name','lead.lead_last_name','lead.lead_phone','lead.lead_email','lead_source.lead_source_id','lead_source.lead_source_name','lead_status.lead_status_id','lead_status.lead_status_name','lead.lead_problem','lead.lead_remark','lead.status','followup_history.next_followup_date','lead.branch_id')
                                ->where('lead.status', '!=', 2)
                                ->join('company', 'company.company_id','=','lead.company_id')
                                ->join('treatment', 'treatment.treatment_id','=','lead.treatment_id')
                                ->join('lead_source', 'lead_source.lead_source_id','=','lead.lead_source_id')
                                ->join('lead_status', 'lead_status.lead_status_id','=','lead.lead_status_id')
                                ->where('lead.convert_status',0)
                                ->join('followup_history', 'followup_history.lead_id','=','lead.lead_id')
                                ->where('followup_history.app_status',0);
                               

        if($lead_source_id){
            if($lead_source_id != 0){
                $lead_report->where('lead.lead_source_id',$lead_source_id);
            }
            
        }
        if(isset($request->branch_id)){
            if($request->branch_id > 0){
                $lead_report = $lead_report->where('lead.branch_id',$request->branch_id);
            } 
         } 
        if($from_date){
            $lead_report->whereDate('lead.created_on','>=',$from_date);
        }

        if($to_date){
            $lead_report->whereDate('lead.created_on',"<=",$to_date);
        }

        
        $branch = Staff::select('branch_id','role_id')->where('staff_id',$request->user()->staff_id)->first();
        
        if($branch->role_id != 1){
            $lead_report = $lead_report->where('lead.branch_id',$branch->branch_id);
        }
        


        $result =  $lead_report->get();

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $result,
        ],200);


    }
    public function AppointmentReport(Request $request){
        $treatment_id = $request->treatment_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;


        $appintment_report = Appointment::select('appointment.appointment_id','appointment.lead_id','appointment.company_id','company.company_name','appointment.staff_id','appointment.problem','appointment.remark','appointment.status','treatment.treatment_name','appointment.staff_id','appointment.lead_id','appointment.customer_id','appointment.app_status','appointment.remark','appointment.status','appointment.lead_status_id','lead_status.lead_status_name','staff.staff_id','staff.name as staff_name','appointment.branch_id')
                                        ->where('appointment.status', '!=', 2)
                                        ->join('company', 'company.company_id','=','appointment.company_id')
                                        ->join('treatment', 'treatment.treatment_id','=','appointment.treatment_id')
                                        ->join('staff', 'staff.staff_id','=','appointment.staff_id')
                                        ->leftjoin('lead_status', 'lead_status.lead_status_id','=','appointment.lead_status_id')
                                        ->orderBy('appointment.created_on', 'desc');
    

        if($treatment_id){
            if($treatment_id != 0){

                $appintment_report->where('appointment.treatment_id',$treatment_id);
            }
            
        }
        if(isset($request->branch_id)){
            if($request->branch_id > 0){
                $appintment_report = $appintment_report->where('appointment.branch_id',$request->branch_id);
            } 
         } 

        if($from_date){
            $appintment_report->whereDate('appointment.created_on','>=',$from_date);
        }

        if($to_date){
            $appintment_report->whereDate('appointment.created_on',"<=",$to_date);
        }
        
        $branch = Staff::select('branch_id','role_id')->where('staff_id',$request->user()->staff_id)->first();
        
        // if($branch->role_id != 1){
        //     $appintment_report = $appintment_report->where('lead.branch_id',$branch->branch_id);
        // }
        

        $app =  $appintment_report->get();


        $data= [];
        foreach($app as $key =>  $value){

            if($value->customer_id){
                $user_id = $value->customer_id;
                $customer = Customer::where('customer_id',$user_id)->first();
                $username = $customer->customer_first_name.$customer->customer_last_name;
                $user_status = "Customer";
                $branch_id = $customer->branch_id;
            }else{
                $user_id = $value->lead_id;
                $lead = Lead::where('lead_id',$user_id)->first();
                $username = $lead->lead_first_name.$lead->lead_last_name;
                $user_status = "Lead";
                $branch_id = $lead->branch_id;
            }


            $data[$key] = [
                        'appointment_id' =>  $value->appointment_id,
                        'user_id'   => $user_id,
                        'user_name' => $username,
                        'company_id'=> $value->company_id,
                        'company_name'=> $value->company_name,
                        'staff_id'=> $value->staff_id,
                        'staff_name'=> $value->staff_name,
                        'lead_status_id'=> $value->lead_status_id,
                        'lead_status_name'=> $value->lead_status_name,
                        'app_status'=> $value->app_status,
                        'treatment_name'=> $value->treatment_name,
                        'problem'=> $value->problem,
                        'remark'=> $value->remark,
                        'status'=> $value->status,
                        'user_status'=>$user_status,
                        'branch_id' => $branch_id
                   

                    ];
                    
                    
                    
        }
        
        
        $branch_id = $branch->branch_id;
        $data1= [];
        
        
        if($branch->role_id != 1){
           
            
            foreach($data as $k => $d){
                
                if($d['branch_id'] == $branch_id){
                    
                     $data1[] = [
                        
                        // 'appointment_id' => $d['appointment_id'],
                        // 'date'           => $d['date'],
                        // 'time'           => $d['time'],
                        // 'user_id'        => $d['user_id'],
                        // 'user_name'      => $d['user_name'],
                        // 'company_id'     => $d['company_id'],
                        // 'company_name'   => $d['company_name'],
                        // 'staff_id'       => $d['staff_id'],
                        // 'staff_name'     => $d['staff_name'],
                        // 'tc_id'          => $d['tc_id'],
                        // 'tc_name'        => $d['tc_name'],
                        // 'treatment_id'=> $d['treatment_id'],
                        // 'treatment_name'=> $d['treatment_name'],
                        // // 'lead_status_id'=> $d['lead_status_id'],
                        // // 'lead_status_name'=> $d['lead_status_name'],
                        // 'app_status'=> $d['app_status'],
                        
                        // 'problem'=> $d['problem'],
                        // 'remark'=> $d['remark'],
                        // 'status'=> $d['status'],
                        // 'user_status'=>$d['user_status'],
                        // 'branch_id' => $d['branch_id']
                        
                        'appointment_id' =>  $d['appointment_id'],
                        'user_id'   => $d['user_id'],
                        'user_name' => $d['user_name'],
                        'company_id'=> $d['company_id'],
                        'company_name'=> $d['company_name'],
                        'staff_id'=> $d['staff_id'],
                        'staff_name'=> $d['staff_name'],
                        'lead_status_id'=>$d['lead_status_id'],
                        'lead_status_name'=> $d['lead_status_name'],
                        'app_status'=> $d['app_status'],
                        'treatment_name'=> $d['treatment_name'],
                        'problem'=> $d['problem'],
                        'remark'=> $d['remark'],
                        'status'=> $d['status'],
                        'user_status'=>$d['user_status'],
                        'branch_id' => $d['branch_id']
                   

                    ];
                }
               
            }
            
           
        }else{
            $data1= $data;
        }
        
        

        

        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $data1 ,
                        ],200);

        
    }
    public function StockReport(Request $request){
        
        
        $brand_id = $request->brand_id;
        $prod_category_id = $request->prod_category_id;
        $product_id = $request->product_id;
       

        //$stock_report = Stock::select('stock_id','stock_in_hand','product_category.prod_cat_id')->get();
        
        $stock_report = Stock::select('stock_id','stock_in_hand','product_category.prod_cat_id','product_category.prod_cat_name','product.product_id','product.product_name','brand.brand_id','brand.brand_name','branch.branch_id','branch.branch_name')       
                                ->join('brand', 'brand.brand_id','=','stock_maintanance.brand_id')
                                ->join('product_category', 'product_category.prod_cat_id','=','stock_maintanance.prod_cat_id')
                                ->join('product', 'product.product_id','=','stock_maintanance.product_id')
                                ->join('branch', 'branch.branch_id','=','stock_maintanance.branch_id');
          //return $stock_report; 
          
        // $branch_id = $request->branch_id;
        
        // $branch = Staff::select('branch_id','role_id')->where('staff_id',$request->user()->staff_id)->first();
        
        // if($branch->role_id != 1){
        //     $branch_id =  $branch->branch_id;
        // }
        
        if(isset($request->branch_id)){
            if($request->branch_id > 0){
                $stock_report = $stock_report->where('stock_maintanance.branch_id',$request->branch_id);
            } 
         } 
        

        // if($branch_id){
        //     $stock_report->where('stock_maintanance.branch_id',$branch_id);
        // }
        
        
        

        if($brand_id){
            $stock_report->where('stock_maintanance.brand_id',$brand_id);
        }

        if($prod_category_id){
            $stock_report->where('stock_maintanance.prod_cat_id',$prod_category_id);
        }

        if($product_id){
            $stock_report->where('stock_maintanance.product_id',$product_id);
        }



        $result =  $stock_report->get();

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $result,
        ],200);
    }
    public function AttendanceReport(Request $request){

        $select_date = $request->date;

        

        $staffs = Staff::select('staff_id','name','job_designation.job_id','job_designation.designation')         
                        ->where('staff.status', '!=', 2)             
                        ->join('job_designation', 'job_designation.job_id','=','staff.job_id');
                        //->get();

        // $branch = Staff::select('branch_id','role_id')->where('staff_id',$request->user()->staff_id)->first();
        
        // if($branch->role_id != 1){
        //     $staffs = $staffs->where('staff.branch_id',$branch->branch_id);
        // }
        if(isset($request->branch_id)){
            if($request->branch_id > 0){
                $staffs = $staffs->where('staff.branch_id',$request->branch_id);
            } 
         }
        $staffs= $staffs->get();

        if($select_date){

            
           
            // $month_no = Carbon::now()->$select_date->month;
            // $m_days   = Carbon::now()->$select_date->month($month_no)->daysInMonth; 

            for($i = 1; $i <=  date('t', strtotime($select_date)); $i++)
            {
                $dates[] = date('Y', strtotime($select_date)) . "-" . date('m', strtotime($select_date)) . "-" . str_pad($i, 2, '0', STR_PAD_LEFT); 
            }

        }else{

            for($i = 1; $i <=  date('t'); $i++)
            {
                $dates[] = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT); 
            }
    
        }

        
        

        foreach($staffs as $s=>$staff){
            $date_data =[];
            foreach($dates as $key => $date){
                $attendance = Attendance::where('staff_id',$staff->staff_id)->whereDate("from_date","=",$date)->first();
                $status = '';

                if($attendance){

                    if($attendance->present == 1){
                        $status = 'P';
                    }else if($attendance->permission == 1){
                        $status = 'OW';
                    }elseif($attendance->leave == 1){
                        $status = 'L';
                    }else{
                        $status = '';
                    }
                }

                $date_data[] = ['date'=>$date,'status'=>$status ];
            }

            $values[] = [
                        'staff_id'=>$staff->staff_id,
                        'staff_name'=>$staff->name,
                        'designation'=>$staff->designation,
                        'job_id'   => $staff->job_id,
                        'dates' => $date_data,
                        

            ];


        }




      
        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                          //  'data'      => $staffs ,
                            'data' => $values
                        ],200);
        // $date = $request->date;

        // $attendance_report = Attendance::select('*');

        // if($date){
        //     $attendance_report->where('att_date',$date);
        // }

        // $result =  $attendance_report->get();

        // return response([
        //     'status'    => 200,
        //     'message'   => 'Success',
        //     'error_msg' => null,
        //     'data'      => $result,
        // ],200);
    }
    public function PaymentReport(Request $request){

        $treatment_cat_id = $request->treatment_cat_id;
        $treatment_id     = $request->treatment_id;
        $pending          = $request->pending;

        $from_date = $request->from_date;
        $to_date = $request->to_date;


        


        // $payment_report = Payment::select('payment.p_id','payment.receipt_no','payment.invoice_no','payment.payment_date','payment.sitting_count','payment.amount','payment.total_amount','payment_status','payment.balance','treatment_category.tcategory_id','treatment_category.tc_name','treatment.treatment_id','treatment.treatment_name','customer.customer_id','customer.customer_first_name','payment.status')
        //                             ->where('payment.status', '!=', 2)
        //                             ->join('treatment_category','treatment_category.tcategory_id','=','payment.tcate_id')
        //                             ->join('treatment','treatment.treatment_id','=','payment.treatment_id')
        //                             ->join('customer', 'customer.customer_id','=','payment.customer_id')->get();

        // return $payment_report;

        
        $treatments = CustomerTreatment:: select('treatment_category.created_on','treatment_category.tcategory_id','treatment_category.tc_name','treatment.treatment_id','treatment.treatment_name','customer.customer_id','customer.customer_first_name','customer_treatment.progress','customer_treatment.amount','customer_treatment.discount','customer.branch_id','customer.state_id')
                                    ->where('treatment_category.status', '!=', 2)
                                    ->join('treatment_category','treatment_category.tcategory_id','=','customer_treatment.tc_id')
                                    ->join('treatment','treatment.treatment_id','=','customer_treatment.treatment_id')
                                    ->join('customer', 'customer.customer_id','=','customer_treatment.customer_id');                    

        if($treatment_cat_id){
            $treatments->where('customer_treatment.tc_id',$treatment_cat_id);
        }

        if($treatment_id){
            $treatments->where('customer_treatment.treatment_id',$treatment_id);
        }

       
        if(isset($request->branch_id)){
            if($request->branch_id > 0){
                $treatments = $treatments->where('customer.branch_id',$request->branch_id);
            } 
         } 
        
        // $branch = Staff::select('branch_id','role_id')->where('staff_id',$request->user()->staff_id)->first();
        
        // if($branch->role_id != 1){
        //     $treatments = $treatments->where('customer.branch_id',$branch->branch_id);
        // }


        $results =  $treatments->get();

        $result = [];
        foreach($results as $val){

            $payment = Payment::select('invoice_no','payment_date','sitting_count','amount','amount','total_amount','balance','cgst','sgst')->where('tcate_id',$val->tcategory_id)->where('treatment_id',$val->treatment_id)->where('customer_id',$val->customer_id)->orderBy('sitting_count', 'DESC')->first();

            $paid_amount = Payment::where('tcate_id',$val->tcategory_id)->where('treatment_id',$val->treatment_id)->where('customer_id',$val->customer_id)->sum('amount');
            $branch = Customer::where('branch_id',$val->customer_id)->first();
            if($payment){

                if($payment->payment_date >= $from_date  &&  $payment->payment_date <= $to_date){
                    
                    $result [] = [
                       
                        'invoice_no' => $payment ? $payment->invoice_no : "",
                        'date' => $payment ? $payment->payment_date: "",
                        'category_name' => $val['tc_name'],
                        'treatment_name' => $val['treatment_name'],
                        'progress' => $val['progress'],
                        'customer_name' => $val['customer_first_name'],
                        'sitting_count' =>$payment ? $payment->sitting_count: "",
                        'amount' => $payment ?$payment->total_amount: "",
                        'gst' => ($payment ? $payment->cgst : 0) + ($payment ? $payment->sgst : 0),
                          'state_id' => $val['state_id'],
                        'discount' => $val['discount'],
                        'paid_amount' =>$paid_amount,
                        'pending' =>$payment ? $payment->balance: "",
                        'payment_status' => $payment ?$payment->balance: "",
                        'branch_id' => $branch ?$branch->branch_id:''
                    ];
                }
                
               
            }
        }

        $final = [];



        foreach($result as $res){

            if($pending >= 0){

                
                if($res['pending'] == $pending){

                                        
                    $final [] = [
                                    'invoice_no' => $res['invoice_no'],
                                    'date' =>  $res['date'],
                                    'category_name' => $res['category_name'],
                                    'treatment_name' =>  $res['treatment_name'],
                                    'progress' => $res['progress'],
                                    'customer_name' =>  $res['customer_name'],
                                    'sitting_count' => $res['sitting_count'],
                                    'amount' =>  $res['amount'],
                                    'gst' => $res['gst'],
                                    'state_id' => $res['state_id'],
                                    'discount' =>  $res['discount'],
                                    'paid_amount' => $res['paid_amount'],
                                    'pending' =>  $res['pending'],
                                    'payment_status' =>  $res['payment_status'],
                                    'branch_id' =>  $res['branch_id'],
                                ];

                }
    
                // if($pending == 1){
                //     if($res['pending'] > 0){
                        // $final [] = [
                        //                 'invoice_no' => $res['invoice_no'],
                        //                 'date' =>  $res['date'],
                        //                 'category_name' => $res['category_name'],
                        //                 'treatment_name' =>  $res['treatment_name'],
                        //                 'progress' => $res['progress'],
                        //                 'customer_name' =>  $res['customer_name'],
                        //                 'sitting_count' => $res['sitting_count'],
                        //                 'amount' =>  $res['amount'],
                        //                 'discount' =>  $res['discount'],
                        //                 'paid_amount' => $res['paid_amount'],
                        //                 'pending' =>  $res['pending'],
                        //                 'payment_status' =>  $res['payment_status'],
                //         //             ];
                //     }
                // }


                if($pending == 1){

                    if($res['pending'] > 0){
                        $final [] = [
                                        'invoice_no' => $res['invoice_no'],
                                        'date' =>  $res['date'],
                                        'category_name' => $res['category_name'],
                                        'treatment_name' =>  $res['treatment_name'],
                                        'progress' => $res['progress'],
                                        'customer_name' =>  $res['customer_name'],
                                        'sitting_count' => $res['sitting_count'],
                                        'amount' =>  $res['amount'],
                                        'gst' => $res['gst'],
                                        'state_id' => $res['state_id'],
                                        'discount' =>  $res['discount'],
                                        'paid_amount' => $res['paid_amount'],
                                        'pending' =>  $res['pending'],
                                        'payment_status' =>  $res['payment_status'],
                                        'branch_id' =>  $res['branch_id'],
                                    ];
                    }
    
                }


                if($pending == 2){

                    
                        $final [] = [
                                        'invoice_no' => $res['invoice_no'],
                                        'date' =>  $res['date'],
                                        'category_name' => $res['category_name'],
                                        'treatment_name' =>  $res['treatment_name'],
                                        'progress' => $res['progress'],
                                        'customer_name' =>  $res['customer_name'],
                                        'sitting_count' => $res['sitting_count'],
                                        'amount' =>  $res['amount'],
                                        'gst' => $res['gst'],
                                        'state_id' => $res['state_id'],
                                        'discount' =>  $res['discount'],
                                        'paid_amount' => $res['paid_amount'],
                                        'pending' =>  $res['pending'],
                                        'payment_status' =>  $res['payment_status'],
                                        'branch_id' =>  $res['branch_id'],
                                    ];
                   
    
                }

            }
            
        }


        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $final,
        ],200);

    }
}
