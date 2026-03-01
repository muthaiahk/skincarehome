<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Lead;
use App\Models\Payment;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Treatment;
use App\Models\CustomerTreatment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    //
    // public function Count(Request $request){

    //     $branch_id = $request->branch_id;

    //     $lead        = Lead::select('lead_id');
    //     $appointment = Appointment::leftjoin('customer', 'customer.customer_id','=','appointment.customer_id');
    //     $payments    = Payment::leftjoin('customer', 'customer.customer_id','=','payment.customer_id');

    //     // if($branch_id){
    //     //     $lead->where('branch_id',$branch_id);
    //     //     $appointment->where('customer.branch_id',$branch_id);
    //     //     $payments->where('customer.branch_id',$branch_id);
    //     // }
    //     if($branch_id){
    //         $idArray = explode(',', $branch_id); // Convert the comma-separated string to an array
            
    //         $lead->whereIn('branch_id',$idArray);
    //         $appointment->whereIn('customer.branch_id',$idArray);
    //         $payments->whereIn('customer.branch_id',$idArray);
    //     }
    //     $lead_count = $lead->get();
    //     $payments = $payments->get()->sum('amount');
    //     $appointment_count = $appointment->get();
      
    //     $result = [
    //                 'lead_count' => count($lead_count),
    //                 'appointment_count' => count($appointment_count),
    //                 'payment' => $payments,
    //             ];
                
    //     return response([
    //                 'status'    => 200,
    //                 'message'   => 'Success',
    //                 'error_msg' => null,
    //                 'data'      => $result,
    //             ],200);

    // }
  public function Count(Request $request){

        $branch_id = $request->branch_id;
        $currentMonth = now()->startOfMonth(); // Get the start of the current month
    
        $lead = Lead::select('lead_id')->whereMonth('lead.created_on', $currentMonth);
        $appointment = Appointment::leftJoin('customer', 'customer.customer_id','=','appointment.customer_id')
                                  ->whereMonth('date', $currentMonth); // Assuming appointment_date is the date of the appointment
        $payments = Payment::leftJoin('customer', 'customer.customer_id','=','payment.customer_id')
                           ->whereMonth('payment.created_on', $currentMonth); // Assuming payment_date is the date of the payment
    
        if (is_string($branch_id)) {
        // Remove square brackets and quotes
        $branch_id = str_replace(['[', ']'], '', $branch_id);
        $branch_id = explode(',', $branch_id);
        $branch_id = array_map('trim', $branch_id); // Trim any whitespace
        }
        
        // Ensure branch_id is an array and clean up any strings
        if (!is_array($branch_id)) {
            $branch_id = [$branch_id]; // Wrap single ID in an array
        }

        // if(isset($request->branch_id)){
        //     if($request->branch_id > 0){
        //         $idArray = explode(',', $request->branch_id);
               
        //         $lead->whereIn('branch_id', $idArray);
            
        //         $appointment->whereIn('customer.branch_id', $idArray);
        //         $payments->whereIn('customer.branch_id', $idArray);
        //     } else{
        //         $lead->whereIn('branch_id', $branch_id);
            
        //         $appointment->whereIn('customer.branch_id', $branch_id);
        //         $payments->whereIn('customer.branch_id', $branch_id);
        //     }
        //  } 

        if (in_array('all', $branch_id)) {
          
            $allBranchIds = Branch::pluck('branch_id')->toArray();
        } else {
           
            $allBranchIds = $branch_id;
        }

        $lead->whereIn('branch_id', $allBranchIds);
            
        $appointment->whereIn('customer.branch_id', $allBranchIds);
        $payments->whereIn('customer.branch_id', $allBranchIds);
    
        $lead_count = $lead->count();
        $payments_total = $payments->sum('amount');
        $appointment_count = $appointment->count();
    
        $result = [
            'lead_count' => $lead_count,
            'appointment_count' => $appointment_count,
            'payment' => $payments_total,
        ];
    
        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $result,
        ],200);
    
    }
    // public function Customer(Request $request){

    //     $branch_id = $request->branch_id;

    //     $data = $request->data;
    //     $year = $request->year;
    //     $month = $request->month;
    //     $from_date = $request->from_date;
    //     $to_date = $request->to_date;
        
    //     $users = Customer::select( 'customer.created_on')->join('staff','staff.staff_id','=','customer.staff_id');
                        
	// 	if($branch_id > 0){
	// 	    $users = $users->where('staff.branch_id',$branch_id);
	// 	}		        
		
	// 	$users =$users->get();
	// 	$users =$users->groupBy(function ($date) {
	// 			            return Carbon::parse($date->created_on)->format('m');
	// 			        });

	// 	$usermcount = [];
	// 	$userArr = [];

	// 	foreach ($users as $key => $value) {
	// 		$usermcount[(int)$key] = count($value);
	// 	}

	// 	$month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

	// 	for ($i = 1; $i <= 12; $i++) {
	// 		if (!empty($usermcount[$i])) {
	// 			$userArr[$i]['count'] = $usermcount[$i];
	// 		} else {
	// 			$userArr[$i]['count'] = 0;
	// 		}
	// 		$userArr[$i]['month'] = $month[$i - 1];
    //     }

    //     return response([
    //         'status'    => 200,
    //         'message'   => 'Success',
    //         'error_msg' => null,
    //         'data'      => $userArr,
    //     ],200);
        
    // }
    public function Customer(Request $request){

        $branch_id = $request->branch_id;

        $data = $request->data;
        $year = $request->year;
        $month = $request->month;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        
        $categories = [];
        $userArr = [];
       
       
        if($data){

            if($data == 1){

                if($year){
                    
                    $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
                    foreach($categories as $key => $ct){
    
                        $num = $key < 10 ? '0' : '';
    
                        $mn =  $num.($key+1).'-'.$year;
    
    
                        $users = Customer::whereYear('created_on',$year)->whereMonth('created_on',$mn)->get();
    
                    
                        $userArr = 0;
                        
        
                        foreach ($users as $value) {
                            // $usermcount[(int)$key] = count($value);
                            $usermcount = count($value);
                            $customer = Customer::where('customer_id',$value->customer_id)->first();
                            if($customer){
                                $userArr =  $userArr+1;
                            }else{
                                $userArr =  0;
                            }
                        }
        
                        $userArr[] = $userArr;
        
                    }
    
                    // return $users;
                }else{
                    $users = Customer::select( 'customer.created_on')->join('staff','staff.staff_id','=','customer.staff_id');
                        
                    if($branch_id > 0){
                        $users = $users->where('staff.branch_id',$branch_id);
                    }		        
                    
                    $users =$users->get();
                    $users =$users->groupBy(function ($date) {
                                        return Carbon::parse($date->created_on)->format('m');
                                    });

                    $usermcount = [];
                    $userArr = [];

                    foreach ($users as $key => $value) {
                        $usermcount[(int)$key] = count($value);
                    }

                    $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                    for ($i = 1; $i <= 12; $i++) {
                        if (!empty($usermcount[$i])) {
                            $userArr[$i]['count'] = $usermcount[$i];
                        } else {
                            $userArr[$i]['count'] = 0;
                        }
                        $userArr[$i]['month'] = $month[$i - 1];
                    }
                }
    
            }else if($data == 2){

                // $days = Carbon::date('Y',$month)->month($month)->daysInMonth;
                // return $days;
                $mn = $month."-01";
                $days = Carbon::parse($mn)->daysInMonth;
                $categories = [];
    
                for($i=1; $i < $days ;$i++){

                    $num = $i < 10 ? '0' : '';

                    $date = $month."-".$num.$i;

                    $categories[] =  Carbon::parse($date)->format('M-d');

                  
                    foreach($categories as $key => $ct){
    
                        $num = $key < 10 ? '0' : '';
    
                        $mn =  $num.($key+1).'-'.$year;
    
    
                        $users = Customer::whereYear('created_on',$year)->whereMonth('created_on',$mn)->get();
    
                    
                        $userArr = 0;
                        
        
                        foreach ($users as $value) {
                            // $usermcount[(int)$key] = count($value);
                            $usermcount = count($value);
                            $customer = Customer::where('customer_id',$value->customer_id)->first();
                            if($customer){
                                $userArr =  $userArr+1;
                            }else{
                                $userArr =  0;
                            }
                        }

                
                        // for ($i = 1; $i <= 12; $i++) {
                        //     if (!empty($usermcount[$i])) {
                        //         $userArr[$i]['count'] = $usermcount[$i];
                        //     } else {
                        //         $userArr[$i]['count'] = 0;
                        //     }
                        
                        // }
        
                        $userArr[] = $userArr;
        
                    }

    
                }
    
            }else if($data == 3){

               

                $period = CarbonPeriod::create($from_date, $to_date);
                
                // Iterate over the period
                foreach ($period as $date) {
                    $date_f = $date->format('Y-m-d');
                    $categories[] = $date->format('Y-m-d');

                    $users = CustomerTreatment::whereDate('created_on',$date_f)->get();
        
                    
                    $userArr = 0;
    
                    foreach ($users as $value) {
                        // $usermcount[(int)$key] = count($value);
                        $usermcount = count($value);
                        $customer = Customer::where('customer_id',$value->customer_id)->first();
                        if($customer){
                            $userArr =  $userArr+1;
                        }else{
                            $userArr =  0;
                        }
                    }
    
                    $userArr[] = $userArr;


                    
                }

                // Convert the period to an array of dates
              //  $dates = $period->toArray();
      
                
            }

        }else{
            $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $users = Customer::select( 'customer.created_on')->join('staff','staff.staff_id','=','customer.staff_id');
                        
            if($branch_id > 0){
                $users = $users->where('staff.branch_id',$branch_id);
            }		        
            
            $users =$users->get();
            $users =$users->groupBy(function ($date) {
                                return Carbon::parse($date->created_on)->format('m');
                            });

            $usermcount = [];
            $userArr = [];

            foreach ($users as $key => $value) {
                $usermcount[(int)$key] = count($value);
            }

            $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            for ($i = 1; $i <= 12; $i++) {
                if (!empty($usermcount[$i])) {
                    $userArr[$i]['count'] = $usermcount[$i];
                } else {
                    $userArr[$i]['count'] = 0;
                }
                $userArr[$i]['month'] = $month[$i - 1];
            }


        }
       
       
       
        // $users = Customer::select( 'customer.created_on')->join('staff','staff.staff_id','=','customer.staff_id');
                        
		// if($branch_id > 0){
		//     $users = $users->where('staff.branch_id',$branch_id);
		// }		        
		
		// $users =$users->get();
		// $users =$users->groupBy(function ($date) {
		// 		            return Carbon::parse($date->created_on)->format('m');
		// 		        });

		// $usermcount = [];
		// $userArr = [];

		// foreach ($users as $key => $value) {
		// 	$usermcount[(int)$key] = count($value);
		// }

		// $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

		// for ($i = 1; $i <= 12; $i++) {
		// 	if (!empty($usermcount[$i])) {
		// 		$userArr[$i]['count'] = $usermcount[$i];
		// 	} else {
		// 		$userArr[$i]['count'] = 0;
		// 	}
		// 	$userArr[$i]['month'] = $month[$i - 1];
        // }

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'categories'=> $categories,
            'data'      => $userArr,
        ],200);
        
    }
    public function Appointment(Request $request){
        
        $branch_id = $request->branch_id;
        
        $app = Appointment::select( 'appointment.created_on')
                        ->join('staff','staff.staff_id','=','appointment.staff_id')
                        ->where('staff.branch_id',$branch_id)
				        ->get()
				        ->groupBy(function ($date) {
				            return Carbon::parse($date->created_on)->format('m');
				        });




		$appmcount = [];
		$appArr = [];

		foreach ($app as $key => $value) {
			$usermcount[(int)$key] = count($value);
		}

		$month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

		for ($i = 1; $i <= 12; $i++) {


            if (!empty($usermcount[$i])) {
				//$appArr[$i]['count'] = $usermcount[0];
                $appArr[$i]['count'] = $usermcount[$i];
			} else {
				$appArr[$i]['count'] = 0;
			}

			$appArr[$i]['month'] = $month[$i - 1];
        }

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $appArr,
        ],200);
    }
    public function Treatment(Request $request){
        
        $branch_id = $request->branch_id;
        
        
        $treatments = Treatment::where('status','!=',2)->get();
        
        $data = [];
        
        foreach($treatments as $key => $treat){
            
            $app_treat = CustomerTreatment::select('customer_treatment.treatment_id','customer.branch_id')->where('customer_treatment.treatment_id',$treat->treatment_id)->
            join('customer','customer_treatment.customer_id','=','customer.customer_id');
            
            
            if($branch_id != 0){
                 $app_treat =  $app_treat->where('customer.branch_id',$branch_id);
            }
            
            $app_treat = $app_treat->get();
            
            $data[$key]['count'] = count($app_treat);
            $data[$key]['name']  = $treat->treatment_name;
            
        }
        
      //  return $data;
       
       usort($data, function($a, $b){ return $b['count'] <=> $a['count'];});
       
     //  return $data;
        
        // $app = Appointment::select( 'appointment.created_on')
        //                 ->join('staff','staff.staff_id','=','appointment.staff_id')
        //                 ->where('staff.branch_id',$branch_id)
				    //     ->get()
				    //     ->groupBy(function ($date) {
				    //         return Carbon::parse($date->created_on)->format('m');
				    //     });




        // 		$appmcount = [];
        // 		$appArr = [];

        // 		foreach ($app as $key => $value) {
        // 			$usermcount[(int)$key] = count($value);
        // 		}

        // 		$month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // 		for ($i = 1; $i <= 12; $i++) {


        //             if (!empty($usermcount[$i])) {
        // 				//$appArr[$i]['count'] = $usermcount[0];
        //                 $appArr[$i]['count'] = $usermcount[$i];
        // 			} else {
        // 				$appArr[$i]['count'] = 0;
        // 			}

        // 			$appArr[$i]['month'] = $month[$i - 1];
        //         }
                
        

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            // 'data'      => $appArr,
             'data2'      =>$data,
        ],200);
    }
    
    // public function Comparison(Request $request){


    //     $data = $request->data;
    //     $year = $request->year;
    //     $month = $request->month;
    //     $from_date = $request->from_date;
    //     $to_date = $request->to_date;

    //     $categories = [];
    //     $old = [];
    //     $new = [];
        
    //     if($data){

    //         if($data == 1){

    //             if($year){
                    
    //                 $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
                          
        
    //                 foreach($categories as $key => $ct){
    
    //                     $num = $key < 10 ? '0' : '';
    
    //                     $mn =  $num.($key+1).'-'.$year;
    
    
    //                     $comparisons = CustomerTreatment::whereYear('created_on',$year)->whereMonth('created_on',$mn)->get();
    
                    
    //                     $old_cus = 0;
    //                     $new_cus = 0;
        
    //                     $chk_customer_id = 0;
        
    //                     foreach($comparisons as $cus){
        
    //                         if($chk_customer_id != $cus->customer_id){
    //                             $chk_customer_id = $cus->customer_id;
        
    //                             $customer = Payment::where('customer_id',$cus->customer_id)->first();
        
    //                             if($customer){
    //                                 $old_cus =  $old_cus+1;
    //                             }else{
    //                                 $new_cus =  $new_cus+1;
    //                             }
        
                                
    //                         }
        
                            
    //                     }
        
    //                     $old[] = $old_cus;
    //                     $new[] = $new_cus;
        
    //                 }
    
    //                 //return $comparisons;
    //             }else{
    //                 $start_year = CustomerTreatment::orderBy('cus_treat_id','asc')->first();

    //                 $st_date = $start_year->created_on;
    //                 $ed_date = date('d-m-Y');
                    
    //                 $startDate = Carbon::parse($st_date); 
    //                 $endDate = Carbon::parse($ed_date); 
    //                 $diff = $startDate->diffInYears($endDate);
        
    //                 if($diff > 5){
        
    //                     $dty = date('Y',$startDate)+1;
                        
    //                     for($i=0; $i < $diff ;$i++){
    //                         $dty = $dty-1;
    //                         $categories[] = $dty;
            
    //                     }
        
    //                 }else{
    //                     $dty = date('Y')+1;
    //                     for($i=0; $i < 5;$i++){
    //                         $dty = $dty-1;
    //                         $categories[] = $dty;
            
    //                     }
    //                 }
        
    //                 foreach($categories as $key => $ct){
            
                      
        
        
    //                     $comparisons = CustomerTreatment::whereYear('created_on',$ct)->get();
        
                    
    //                     $old_cus = 0;
    //                     $new_cus = 0;
        
    //                     $chk_customer_id = 0;
        
    //                     foreach($comparisons as $cus){
        
    //                         if($chk_customer_id != $cus->customer_id){
    //                             $chk_customer_id = $cus->customer_id;
        
    //                             $customer = Payment::where('customer_id',$cus->customer_id)->first();
        
    //                             if($customer){
    //                                 $old_cus =  $old_cus+1;
    //                             }else{
    //                                 $new_cus =  $new_cus+1;
    //                             }
        
                                
    //                         }
        
                            
    //                     }
        
    //                     $old[] = $old_cus;
    //                     $new[] = $new_cus;
        
    //                 }
    //             }
    
    //         }else if($data == 2){

    //             // $days = Carbon::date('Y',$month)->month($month)->daysInMonth;
    //             // return $days;
    //             $mn = $month."-01";
    //             $days = Carbon::parse($mn)->daysInMonth;
    //             $categories = [];
    
    //             for($i=1; $i < $days ;$i++){

    //                 $num = $i < 10 ? '0' : '';

    //                 $date = $month."-".$num.$i;

    //                 $categories[] =  Carbon::parse($date)->format('M-d');

    //                 $comparisons = CustomerTreatment::whereDate('created_on',$date)->get();
        
                    
    //                 $old_cus = 0;
    //                 $new_cus = 0;
    
    //                 $chk_customer_id = 0;
    
    //                 foreach($comparisons as $cus){
    
    //                     if($chk_customer_id != $cus->customer_id){
    //                         $chk_customer_id = $cus->customer_id;
    //                         $customer = Payment::where('customer_id',$cus->customer_id)->first();
    
    //                         if($customer){
    //                             $old_cus =  $old_cus+1;
    //                         }else{
    //                             $new_cus =  $new_cus+1;
    //                         }
    
                            
    //                     }
    
                        
    //                 }
    
    //                 $old[] = $old_cus;
    //                 $new[] = $new_cus;

    
    //             }
    
    //         }else if($data == 3){

               

    //             $period = CarbonPeriod::create($from_date, $to_date);
                
    //             // Iterate over the period
    //             foreach ($period as $date) {
    //                 $date_f = $date->format('Y-m-d');
    //                 $categories[] = $date->format('Y-m-d');

    //                 $comparisons = CustomerTreatment::whereDate('created_on',$date_f)->get();
        
                    
    //                 $old_cus = 0;
    //                 $new_cus = 0;
    
    //                 $chk_customer_id = 0;
    
    //                 foreach($comparisons as $cus){
    
    //                     if($chk_customer_id != $cus->customer_id){
    //                         $chk_customer_id = $cus->customer_id;
    //                         $customer = Payment::where('customer_id',$cus->customer_id)->first();
    
    //                         if($customer){
    //                             $old_cus =  $old_cus+1;
    //                         }else{
    //                             $new_cus =  $new_cus+1;
    //                         }
    
                            
    //                     }
    
                        
    //                 }
    
    //                 $old[] = $old_cus;
    //                 $new[] = $new_cus;


                    
    //             }

    //             // Convert the period to an array of dates
    //           //  $dates = $period->toArray();
      
                
    //         }

    //     }else{

    //         $start_year = CustomerTreatment::orderBy('cus_treat_id','asc')->first();

    //         $st_date = $start_year->created_on;
    //         $ed_date = date('d-m-Y');
            
    //         $startDate = Carbon::parse($st_date); 
    //         $endDate = Carbon::parse($ed_date); 
    //         $diff = $startDate->diffInYears($endDate);

    //         if($diff > 5){

    //             $dty = date('Y',$startDate)+1;
                
    //             for($i=0; $i < $diff ;$i++){
    //                 $dty = $dty-1;
    //                 $categories[] = $dty;
    
    //             }

    //         }else{
    //             $dty = date('Y')+1;
    //             for($i=0; $i < 5;$i++){
    //                 $dty = $dty-1;
    //                 $categories[] = $dty;
    
    //             }
    //         }

    //         foreach($categories as $key => $ct){
    
    //             $comparisons = CustomerTreatment::whereYear('created_on',$ct)->get();

            
    //             $old_cus = 0;
    //             $new_cus = 0;

    //             $chk_customer_id = 0;

    //             foreach($comparisons as $cus){

    //                 if($chk_customer_id != $cus->customer_id){
    //                     $chk_customer_id = $cus->customer_id;

    //                     $customer = Payment::where('customer_id',$cus->customer_id)->first();

    //                     if($customer){
    //                         $old_cus =  $old_cus+1;
    //                     }else{
    //                         $new_cus =  $new_cus+1;
    //                     }

                        
    //                 }

                    
    //             }

    //             $old[] = $old_cus;
    //             $new[] = $new_cus;

    //         }

    //     }
        
        

        
    //     return response([
    //         'status'    => 200,
    //         'message'   => 'Success',
    //         'error_msg' => null,
    //         'categories'=> $categories,
    //         'old'       => $old,
    //         'new'       => $new,
    //     ],200);


    // }
    
      public function Comparison(Request $request){

        $branch_id = $request->branch_id;
        $data = $request->data;
        $year = $request->year;
        $month = $request->month;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $categories = [];
        $old = [];
        $new = [];
        
        if($data){

            if($data == 1){

                if($year){
                    
                    $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
                          
        
                    foreach($categories as $key => $ct){
    
                        $num = $key < 10 ? '0' : '';
    
                        $mn =  $num.($key+1).'-'.$year;
    
    
                        $comparisons = CustomerTreatment::whereYear('created_on',$year)->whereMonth('created_on',$mn)->get();
    
                    
                        $old_cus = 0;
                        $new_cus = 0;
        
                        $chk_customer_id = 0;
        
                        foreach($comparisons as $cus){
        
                            if($chk_customer_id != $cus->customer_id){
                                $chk_customer_id = $cus->customer_id;
        
                                if (is_string($branch_id)) {
                                    // Remove square brackets and quotes
                                       $branch_id = str_replace(['[', ']'], '', $branch_id);
                                       $branch_id = explode(',', $branch_id);
                                       $branch_id = array_map('trim', $branch_id); // Trim any whitespace
                                   }
                                   
                                   // Ensure branch_id is an array and clean up any strings
                                   if (!is_array($branch_id)) {
                                       $branch_id = [$branch_id]; // Wrap single ID in an array
                                   }
                           
                                   if (in_array('all', $branch_id)) {
                                     
                                       $allBranchIds = Branch::pluck('branch_id')->toArray();
                                   } else {
                                      
                                       $allBranchIds = $branch_id;
                                   }
                           
                                $customer = Payment::where('customer_id',$cus->customer_id)->first();
        
                                if($customer){
                                    $old_cus =  $old_cus+1;
                                }else{
                                    $new_cus =  $new_cus+1;
                                }
        
                                
                            }
        
                            
                        }
        
                        $old[] = $old_cus;
                        $new[] = $new_cus;
        
                    }
    
                    //return $comparisons;
                }else{
                    $start_year = CustomerTreatment::orderBy('cus_treat_id','asc')->first();

                    $st_date = $start_year->created_on;
                    $ed_date = date('d-m-Y');
                    
                    $startDate = Carbon::parse($st_date); 
                    $endDate = Carbon::parse($ed_date); 
                    $diff = $startDate->diffInYears($endDate);
        
                    if($diff > 5){
        
                        $dty = date('Y',$startDate)+1;
                        
                        for($i=0; $i < $diff ;$i++){
                            $dty = $dty-1;
                            $categories[] = $dty;
            
                        }
        
                    }else{
                        $dty = date('Y')+1;
                        for($i=0; $i < 5;$i++){
                            $dty = $dty-1;
                            $categories[] = $dty;
            
                        }
                    }
        
                    foreach($categories as $key => $ct){
            
                      
        
        
                        $comparisons = CustomerTreatment::whereYear('created_on',$ct)->get();
        
                    
                        $old_cus = 0;
                        $new_cus = 0;
        
                        $chk_customer_id = 0;
        
                        foreach($comparisons as $cus){
        
                            if($chk_customer_id != $cus->customer_id){
                                $chk_customer_id = $cus->customer_id;
        
                                if (is_string($branch_id)) {
                                    // Remove square brackets and quotes
                                       $branch_id = str_replace(['[', ']'], '', $branch_id);
                                       $branch_id = explode(',', $branch_id);
                                       $branch_id = array_map('trim', $branch_id); // Trim any whitespace
                                   }
                                   
                                   // Ensure branch_id is an array and clean up any strings
                                   if (!is_array($branch_id)) {
                                       $branch_id = [$branch_id]; // Wrap single ID in an array
                                   }
                           
                                   if (in_array('all', $branch_id)) {
                                     
                                       $allBranchIds = Branch::pluck('branch_id')->toArray();
                                   } else {
                                      
                                       $allBranchIds = $branch_id;
                                   }
                           
                                $customer = Payment::where('customer_id', $cus->customer_id)
                                ->whereHas('customer', function($query) use ($allBranchIds) {
                                    $query->whereIn('branch_id', $allBranchIds);
                                })->first();
                            
                                if($customer){
                                    $old_cus =  $old_cus+1;
                                }elseif($customer){
                                    $new_cus =  $new_cus+1;
                                }else{
                                    $old_cus =  $old_cus;
                                    $new_cus =  $new_cus;
                                }
                                // $customer = Payment::where('customer_id',$cus->customer_id)->first();
        
                                // if($customer){
                                //     $old_cus =  $old_cus+1;
                                // }else{
                                //     $new_cus =  $new_cus+1;
                                // }
        
                                
                            }
        
                            
                        }
        
                        $old[] = $old_cus;
                        $new[] = $new_cus;
        
                    }
                }
    
            }else if($data == 2){

                // $days = Carbon::date('Y',$month)->month($month)->daysInMonth;
                // return $days;
                $mn = $month."-01";
                $days = Carbon::parse($mn)->daysInMonth;
                $categories = [];
    
                for($i=1; $i < $days ;$i++){

                    $num = $i < 10 ? '0' : '';

                    $date = $month."-".$num.$i;

                    $categories[] =  Carbon::parse($date)->format('M-d');

                    $comparisons = CustomerTreatment::whereDate('created_on',$date)->get();
        
                    
                    $old_cus = 0;
                    $new_cus = 0;
    
                    $chk_customer_id = 0;
    
                    foreach($comparisons as $cus){
                       
                        if (is_string($branch_id)) {
                            // Remove square brackets and quotes
                               $branch_id = str_replace(['[', ']'], '', $branch_id);
                               $branch_id = explode(',', $branch_id);
                               $branch_id = array_map('trim', $branch_id); // Trim any whitespace
                           }
                           
                           // Ensure branch_id is an array and clean up any strings
                           if (!is_array($branch_id)) {
                               $branch_id = [$branch_id]; // Wrap single ID in an array
                           }
                   
                           if (in_array('all', $branch_id)) {
                             
                               $allBranchIds = Branch::pluck('branch_id')->toArray();
                           } else {
                              
                               $allBranchIds = $branch_id;
                           }
                   
                        if($chk_customer_id != $cus->customer_id){
                            $chk_customer_id = $cus->customer_id;
                           
                            // $customer = Payment::where('customer_id', $cus->customer_id)
                            // ->whereIn('customer.branch_id', $allBranchIds)
                            // ->first();

                            $customer = Payment::where('customer_id', $cus->customer_id)
                            ->whereHas('customer', function($query) use ($allBranchIds) {
                                $query->whereIn('branch_id', $allBranchIds);
                            })->first();
                        
                            if($customer){
                                $old_cus =  $old_cus+1;
                            }elseif($customer){
                                $new_cus =  $new_cus+1;
                            }else{
                                $old_cus =  $old_cus;
                                $new_cus =  $new_cus;
                            }
    
                            
                        }
    
                        
                    }
    
                    $old[] = $old_cus;
                    $new[] = $new_cus;

    
                }
    
            }else if($data == 3){

               

                $period = CarbonPeriod::create($from_date, $to_date);
                
                // Iterate over the period
                foreach ($period as $date) {
                    $date_f = $date->format('Y-m-d');
                    $categories[] = $date->format('Y-m-d');

                    $comparisons = CustomerTreatment::whereDate('created_on',$date_f)->get();
        
                    
                    $old_cus = 0;
                    $new_cus = 0;
    
                    $chk_customer_id = 0;
    
                    foreach($comparisons as $cus){
    
                        if($chk_customer_id != $cus->customer_id){
                            $chk_customer_id = $cus->customer_id;


                            if (is_string($branch_id)) {
                                // Remove square brackets and quotes
                                   $branch_id = str_replace(['[', ']'], '', $branch_id);
                                   $branch_id = explode(',', $branch_id);
                                   $branch_id = array_map('trim', $branch_id); // Trim any whitespace
                               }
                               
                               // Ensure branch_id is an array and clean up any strings
                               if (!is_array($branch_id)) {
                                   $branch_id = [$branch_id]; // Wrap single ID in an array
                               }
                       
                               if (in_array('all', $branch_id)) {
                                 
                                   $allBranchIds = Branch::pluck('branch_id')->toArray();
                               } else {
                                  
                                   $allBranchIds = $branch_id;
                               }
                       

                               $customer = Payment::where('customer_id', $cus->customer_id)
                               ->whereHas('customer', function($query) use ($allBranchIds) {
                                   $query->whereIn('branch_id', $allBranchIds);
                               })->first();
                           
                               if($customer){
                                   $old_cus =  $old_cus+1;
                               }elseif($customer){
                                   $new_cus =  $new_cus+1;
                               }else{
                                   $old_cus =  $old_cus;
                                   $new_cus =  $new_cus;
                               }
                            // $customer = Payment::where('customer_id',$cus->customer_id)->first();
    
                            // if($customer){
                            //     $old_cus =  $old_cus+1;
                            // }else{
                            //     $new_cus =  $new_cus+1;
                            // }
    
                            
                        }
    
                        
                    }
    
                    $old[] = $old_cus;
                    $new[] = $new_cus;


                    
                }

                // Convert the period to an array of dates
              //  $dates = $period->toArray();
      
                
            }

        }else{

            $start_year = CustomerTreatment::orderBy('cus_treat_id','asc')->first();

            $st_date = $start_year->created_on;
            $ed_date = date('d-m-Y');
            
            $startDate = Carbon::parse($st_date); 
            $endDate = Carbon::parse($ed_date); 
            $diff = $startDate->diffInYears($endDate);

            if($diff > 5){

                $dty = date('Y',$startDate)+1;
                
                for($i=0; $i < $diff ;$i++){
                    $dty = $dty-1;
                    $categories[] = $dty;
    
                }

            }else{
                $dty = date('Y')+1;
                for($i=0; $i < 5;$i++){
                    $dty = $dty-1;
                    $categories[] = $dty;
    
                }
            }

            foreach($categories as $key => $ct){
    
                $comparisons = CustomerTreatment::whereYear('created_on',$ct)->get();

            
                $old_cus = 0;
                $new_cus = 0;

                $chk_customer_id = 0;

                foreach($comparisons as $cus){

                    if($chk_customer_id != $cus->customer_id){
                        $chk_customer_id = $cus->customer_id;

                        $customer = Payment::where('customer_id',$cus->customer_id)->first();

                        if($customer){
                            $old_cus =  $old_cus+1;
                        }else{
                            $new_cus =  $new_cus+1;
                        }

                        
                    }

                    
                }

                $old[] = $old_cus;
                $new[] = $new_cus;

            }

        }
        
        

        
        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'categories'=> $categories,
            'old'       => $old,
            'new'       => $new,
        ],200);


    }
    
    // public function Comparisonfm(Request $request){


    //     $data = $request->data;
    //     $year = $request->year;
    //     $month = $request->month;
    //     $from_date = $request->from_date;
    //     $to_date = $request->to_date;

    //     $categories = [];
    //     $male = [];
    //     $female = [];
        
    //     if($data){

    //         if($data == 1){

    //             if($year){
                    
    //                 $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
                          
        
    //                 foreach($categories as $key => $ct){
    
    //                     $num = $key < 10 ? '0' : '';
    
    //                     $mn =  $num.($key+1).'-'.$year;
    
    
    //                     $comparisons = CustomerTreatment::whereYear('created_on',$year)->whereMonth('created_on',$mn)->get();
    
                    
    //                     $male_cus = 0;
    //                     $female_cus = 0;
        
    //                     $chk_customer_id = 0;
        
    //                     foreach($comparisons as $cus){
        
    //                         if($chk_customer_id != $cus->customer_id){
    //                             $chk_customer_id = $cus->customer_id;
        
    //                             $customer = Customer::where('customer_id',$cus->customer_id)->where('customer_gender','1')->first();
        
    //                             if($customer){
    //                                 $male_cus =  $male_cus+1;
    //                             }else{
    //                                 $female_cus =  $female_cus+1;
    //                             }
        
                                
    //                         }
        
                            
    //                     }
        
    //                     $male[] = $male_cus;
    //                     $female[] = $female_cus;
        
    //                 }
    
    //                 //return $comparisons;
    //             }else{
    //                 $start_year = CustomerTreatment::orderBy('cus_treat_id','asc')->first();

    //                 $st_date = $start_year->created_on;
    //                 $ed_date = date('d-m-Y');
                    
    //                 $startDate = Carbon::parse($st_date); 
    //                 $endDate = Carbon::parse($ed_date); 
    //                 $diff = $startDate->diffInYears($endDate);
        
    //                 if($diff > 5){
        
    //                     $dty = date('Y',$startDate)+1;
                        
    //                     for($i=0; $i < $diff ;$i++){
    //                         $dty = $dty-1;
    //                         $categories[] = $dty;
            
    //                     }
        
    //                 }else{
    //                     $dty = date('Y')+1;
    //                     for($i=0; $i < 5;$i++){
    //                         $dty = $dty-1;
    //                         $categories[] = $dty;
            
    //                     }
    //                 }
        
    //                 foreach($categories as $key => $ct){
            
                      
        
        
    //                     $comparisons = CustomerTreatment::whereYear('created_on',$ct)->get();
        
                    
    //                     $male_cus = 0;
    //                     $female_cus = 0;
        
    //                     $chk_customer_id = 0;
        
    //                     foreach($comparisons as $cus){
        
    //                         if($chk_customer_id != $cus->customer_id){
    //                             $chk_customer_id = $cus->customer_id;
        
    //                             $customer = Payment::where('customer_id',$cus->customer_id)->first();
        
    //                             if($customer){
    //                                 $male_cus =  $male_cus+1;
    //                             }else{
    //                                 $female_cus =  $female_cus+1;
    //                             }
        
                                
    //                         }
        
                            
    //                     }
        
    //                     $male[] = $male_cus;
    //                     $female[] = $female_cus;
        
    //                 }
    //             }
    
    //         }else if($data == 2){

    //             // $days = Carbon::date('Y',$month)->month($month)->daysInMonth;
    //             // return $days;
    //             $mn = $month."-01";
    //             $days = Carbon::parse($mn)->daysInMonth;
    //             $categories = [];
    
    //             for($i=1; $i < $days ;$i++){

    //                 $num = $i < 10 ? '0' : '';

    //                 $date = $month."-".$num.$i;

    //                 $categories[] =  Carbon::parse($date)->format('M-d');

    //                 $comparisons = CustomerTreatment::whereDate('created_on',$date)->get();
        
                    
    //                 $male_cus = 0;
    //                 $female_cus = 0;
    
    //                 $chk_customer_id = 0;
    
    //                 foreach($comparisons as $cus){
    
    //                     if($chk_customer_id != $cus->customer_id){
    //                         $chk_customer_id = $cus->customer_id;
    
    //                         $customer = Customer::where('customer_id',$cus->customer_id)->where('customer_gender','1')->first();
    
    //                         if($customer){
    //                             $male_cus =  $male_cus+1;
    //                         }else{
    //                             $female_cus =  $female_cus+1;
    //                         }
    
                            
    //                     }
    
                        
    //                 }
    
    //                 $male[] = $male_cus;
    //                 $female[] = $female_cus;

    
    //             }
    
    //         }else if($data == 3){

               

    //             $period = CarbonPeriod::create($from_date, $to_date);
                
    //             // Iterate over the period
    //             foreach ($period as $date) {
    //                 $date_f = $date->format('Y-m-d');
    //                 $categories[] = $date->format('Y-m-d');

    //                 $comparisons = CustomerTreatment::whereDate('created_on',$date_f)->get();
        
                    
    //                 $male_cus = 0;
    //                 $female_cus = 0;
    
    //                 $chk_customer_id = 0;
    
    //                 foreach($comparisons as $cus){
    
    //                     if($chk_customer_id != $cus->customer_id){
    //                         $chk_customer_id = $cus->customer_id;
    
    //                         $customer = Customer::where('customer_id',$cus->customer_id)->where('customer_gender','1')->first();
    
    //                         if($customer){
    //                             $male_cus =  $male_cus+1;
    //                         }else{
    //                             $female_cus =  $female_cus+1;
    //                         }
    
                            
    //                     }
    
                        
    //                 }
    
    //                 $male[] = $male_cus;
    //                 $female[] = $female_cus;


                    
    //             }

    //             // Convert the period to an array of dates
    //           //  $dates = $period->toArray();
      
                
    //         }

    //     }else{

    //         $start_year = CustomerTreatment::orderBy('cus_treat_id','asc')->first();

    //         $st_date = $start_year->created_on;
    //         $ed_date = date('d-m-Y');
            
    //         $startDate = Carbon::parse($st_date); 
    //         $endDate = Carbon::parse($ed_date); 
    //         $diff = $startDate->diffInYears($endDate);

    //         if($diff > 5){

    //             $dty = date('Y',$startDate)+1;
                
    //             for($i=0; $i < $diff ;$i++){
    //                 $dty = $dty-1;
    //                 $categories[] = $dty;
    
    //             }

    //         }else{
    //             $dty = date('Y')+1;
    //             for($i=0; $i < 5;$i++){
    //                 $dty = $dty-1;
    //                 $categories[] = $dty;
    
    //             }
    //         }

    //         foreach($categories as $key => $ct){
    
    //             $comparisons = CustomerTreatment::whereYear('created_on',$ct)->get();

            
    //             $male_cus = 0;
    //             $female_cus = 0;

    //             $chk_customer_id = 0;

    //             foreach($comparisons as $cus){

    //                 if($chk_customer_id != $cus->customer_id){
    //                     $chk_customer_id = $cus->customer_id;

    //                     $customer = Customer::where('customer_id',$cus->customer_id)->where('customer_gender','1')->first();

    //                     if($customer){
    //                         $male_cus =  $male_cus+1;
    //                     }else{
    //                         $female_cus =  $female_cus+1;
    //                     }

                        
    //                 }

                    
    //             }

    //             $male[] = $male_cus;
    //             $female[] = $female_cus;

    //         }

    //     }
        
        

        
    //     return response([
    //         'status'    => 200,
    //         'message'   => 'Success',
    //         'error_msg' => null,
    //         'categories'=> $categories,
    //         'male'       => $male,
    //         'female'     => $female,
    //     ],200);


    // }
     public function Comparisonfm(Request $request){

        $branch_id = $request->branch_id;
        $data = $request->data;
        $year = $request->year;
        $month = $request->month;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $categories = [];
        $male = [];
        $female = [];
        
        if($data){

            if($data == 1){

                if($year){
                    
                    $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
                          
        
                    foreach($categories as $key => $ct){
    
                        $num = $key < 10 ? '0' : '';
    
                        $mn =  $num.($key+1).'-'.$year;
    
    
                        $comparisons = CustomerTreatment::whereYear('created_on',$year)->whereMonth('created_on',$mn)->get();
    
                    
                        $male_cus = 0;
                        $female_cus = 0;
        
                        $chk_customer_id = 0;
        
                        foreach($comparisons as $cus){
        
                            if($chk_customer_id != $cus->customer_id){
                                $chk_customer_id = $cus->customer_id;
        
                                   if (is_string($branch_id)) {
                                     // Remove square brackets and quotes
                                        $branch_id = str_replace(['[', ']'], '', $branch_id);
                                        $branch_id = explode(',', $branch_id);
                                        $branch_id = array_map('trim', $branch_id); // Trim any whitespace
                                    }
                                    
                                    // Ensure branch_id is an array and clean up any strings
                                    if (!is_array($branch_id)) {
                                        $branch_id = [$branch_id]; // Wrap single ID in an array
                                    }
                            
                                    if (in_array('all', $branch_id)) {
                                      
                                        $allBranchIds = Branch::pluck('branch_id')->toArray();
                                    } else {
                                       
                                        $allBranchIds = $branch_id;
                                    }
                            
                                    // $lead->whereIn('branch_id', $allBranchIds);
                                        
                                    // $appointment->whereIn('customer.branch_id', $allBranchIds);
                                $customer = Customer::where('customer_id',$cus->customer_id)->where('customer_gender','1')->whereIn('customer.branch_id', $allBranchIds)->first();
        
                                if($customer){
                                    $male_cus =  $male_cus+1;
                                }else{
                                    $female_cus =  $female_cus+1;
                                }
        
                                
                            }
        
                            
                        }
        
                        $male[] = $male_cus;
                        $female[] = $female_cus;
        
                    }
    
                    //return $comparisons;
                }else{
                    $start_year = CustomerTreatment::orderBy('cus_treat_id','asc')->first();

                    $st_date = $start_year->created_on;
                    $ed_date = date('d-m-Y');
                    
                    $startDate = Carbon::parse($st_date); 
                    $endDate = Carbon::parse($ed_date); 
                    $diff = $startDate->diffInYears($endDate);
        
                    if($diff > 5){
        
                        $dty = date('Y',$startDate)+1;
                        
                        for($i=0; $i < $diff ;$i++){
                            $dty = $dty-1;
                            $categories[] = $dty;
            
                        }
        
                    }else{
                        $dty = date('Y')+1;
                        for($i=0; $i < 5;$i++){
                            $dty = $dty-1;
                            $categories[] = $dty;
            
                        }
                    }
        
                    foreach($categories as $key => $ct){
            
                      
                        $comparisons = CustomerTreatment::whereYear('created_on',$ct)->get();
        
                    
                        $male_cus = 0;
                        $female_cus = 0;
        
                        $chk_customer_id = 0;
        
                        foreach($comparisons as $cus){
        
                            if($chk_customer_id != $cus->customer_id){
                                $chk_customer_id = $cus->customer_id;
        
                                $customer = Payment::where('customer_id',$cus->customer_id)->first();
        
                                if($customer){
                                    $male_cus =  $male_cus+1;
                                }else{
                                    $female_cus =  $female_cus+1;
                                }
        
                                
                            }
        
                            
                        }
        
                        $male[] = $male_cus;
                        $female[] = $female_cus;
        
                    }
                }
    
            }else if($data == 2){

                // $days = Carbon::date('Y',$month)->month($month)->daysInMonth;
                // return $days;
                $mn = $month."-01";
                $days = Carbon::parse($mn)->daysInMonth;
                $categories = [];
    
                for($i=1; $i < $days ;$i++){

                    $num = $i < 10 ? '0' : '';

                    $date = $month."-".$num.$i;

                    $categories[] =  Carbon::parse($date)->format('M-d');

                    $comparisons = CustomerTreatment::whereDate('created_on',$date)->get();
        
                    
                    $male_cus = 0;
                    $female_cus = 0;
    
                    $chk_customer_id = 0;
    
                    foreach($comparisons as $cus){
    
                        if($chk_customer_id != $cus->customer_id){
                            $chk_customer_id = $cus->customer_id;
    

                            if (is_string($branch_id)) {
                                // Remove square brackets and quotes
                                   $branch_id = str_replace(['[', ']'], '', $branch_id);
                                   $branch_id = explode(',', $branch_id);
                                   $branch_id = array_map('trim', $branch_id); // Trim any whitespace
                               }
                               
                               // Ensure branch_id is an array and clean up any strings
                               if (!is_array($branch_id)) {
                                   $branch_id = [$branch_id]; // Wrap single ID in an array
                               }
                       
                               if (in_array('all', $branch_id)) {
                                 
                                   $allBranchIds = Branch::pluck('branch_id')->toArray();
                               } else {
                                  
                                   $allBranchIds = $branch_id;
                               }
                       
                            // $customer = Customer::where('customer_id',$cus->customer_id)->where('customer_gender','1')->whereIn('customer.branch_id', $allBranchIds)->first();
                            $customer = Customer::where('customer_id',$cus->customer_id)->whereIn('branch_id', $allBranchIds)->first();
                            if ($customer) {
                                if ($customer->customer_gender == '1') {
                                    $male_cus = $male_cus + 1;
                                } else {
                                    $female_cus = $female_cus + 1;
                                }
                            }
    
                            
                        }
    
                        
                    }
    
                    $male[] = $male_cus;
                    $female[] = $female_cus;

    
                }
    
            }else if($data == 3){

               

                $period = CarbonPeriod::create($from_date, $to_date);
                
                // Iterate over the period
                foreach ($period as $date) {
                    $date_f = $date->format('Y-m-d');
                    $categories[] = $date->format('Y-m-d');

                    $comparisons = CustomerTreatment::whereDate('created_on',$date_f)->get();
        
                    
                    $male_cus = 0;
                    $female_cus = 0;
    
                    $chk_customer_id = 0;
    
                    foreach($comparisons as $cus){
    
                        if($chk_customer_id != $cus->customer_id){
                            $chk_customer_id = $cus->customer_id;
    
                            if (is_string($branch_id)) {
                                // Remove square brackets and quotes
                                   $branch_id = str_replace(['[', ']'], '', $branch_id);
                                   $branch_id = explode(',', $branch_id);
                                   $branch_id = array_map('trim', $branch_id); // Trim any whitespace
                               }
                               
                               // Ensure branch_id is an array and clean up any strings
                               if (!is_array($branch_id)) {
                                   $branch_id = [$branch_id]; // Wrap single ID in an array
                               }
                       
                               if (in_array('all', $branch_id)) {
                                 
                                   $allBranchIds = Branch::pluck('branch_id')->toArray();
                               } else {
                                  
                                   $allBranchIds = $branch_id;
                               }
                            // $customer = Customer::where('customer_id',$cus->customer_id)->where('customer_gender','1')->first();
    
                            // if($customer){
                            //     $male_cus =  $male_cus+1;
                            // }else{
                            //     $female_cus =  $female_cus+1;
                            // }

                            $customer = Customer::where('customer_id',$cus->customer_id)->whereIn('branch_id', $allBranchIds)->first();
                            if ($customer) {
                                if ($customer->customer_gender == '1') {
                                    $male_cus = $male_cus + 1;
                                } else {
                                    $female_cus = $female_cus + 1;
                                }
                            }
    
                            
                        }
    
                        
                    }
    
                    $male[] = $male_cus;
                    $female[] = $female_cus;


                    
                }

                // Convert the period to an array of dates
              //  $dates = $period->toArray();
      
                
            }

        }else{

            $start_year = CustomerTreatment::orderBy('cus_treat_id','asc')->first();

            $st_date = $start_year->created_on;
            $ed_date = date('d-m-Y');
            
            $startDate = Carbon::parse($st_date); 
            $endDate = Carbon::parse($ed_date); 
            $diff = $startDate->diffInYears($endDate);

            if($diff > 5){

                $dty = date('Y',$startDate)+1;
                
                for($i=0; $i < $diff ;$i++){
                    $dty = $dty-1;
                    $categories[] = $dty;
    
                }

            }else{
                $dty = date('Y')+1;
                for($i=0; $i < 5;$i++){
                    $dty = $dty-1;
                    $categories[] = $dty;
    
                }
            }

            foreach($categories as $key => $ct){
    
                $comparisons = CustomerTreatment::whereYear('created_on',$ct)->get();

            
                $male_cus = 0;
                $female_cus = 0;

                $chk_customer_id = 0;

                foreach($comparisons as $cus){

                    if($chk_customer_id != $cus->customer_id){
                        $chk_customer_id = $cus->customer_id;

                        $customer = Customer::where('customer_id',$cus->customer_id)->where('customer_gender','1')->first();

                        if($customer){
                            $male_cus =  $male_cus+1;
                        }else{
                            $female_cus =  $female_cus+1;
                        }

                        
                    }

                    
                }

                $male[] = $male_cus;
                $female[] = $female_cus;

            }

        }
        
        

        
        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'categories'=> $categories,
            'male'       => $male,
            'female'     => $female,
        ],200);


    }

}
