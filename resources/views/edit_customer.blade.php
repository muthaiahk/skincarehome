@extends('layouts.app')

@section('content')

  <!-- <body onload="startTime()"> -->
    <body>
    <!-- loader starts-->
    <div class="loader-wrapper">
      <div class="loader-index"><span></span></div>
      <svg>
        <defs></defs>
        <filter id="goo">
          <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
          <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
        </filter>
      </svg>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <!-- <div class="tap-top"><i data-feather="chevrons-up"></i></div> -->
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      
      <!-- Page Header Ends-->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        
        <!-- Page Sidebar Ends-->

        <div class="page-body">
            <div class="container-fluid">        
                <div class="page-title">
                  <div class="row">
                    <div class="col-6">
                      <h3>Modify Customer</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="customer">Customer Lists</a></li>
                        <li class="breadcrumb-item">Modify Customer</li>
                      </ol>
                    </div>
                  </div>
                </div>
            </div>
            <form class="form wizard">
              <!-- Container-fluid starts-->
              <div class="container-fluid">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="card">
                      <!-- <div class="card-header">
                        <h5>Lead Lists</h5>
                      </div> -->
                      <div  id="status_success">
                     
                      </div>
                      <div class="card-body">
                      <div class="row mb-3">
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Company Name</label>
                              <input class="form-control" type="text" data-bs-original-title="" placeholder="Company Name" value= "" required="" readonly id="company_name">
                              <div class="text-danger" id="error_company_name"></div>
                            </div>
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Branch Name</label>
                              <select class="form-select" id="branch_name">
                                
                              </select>
                              <div class="text-danger" id="error_branch_name"></div>
                            </div>
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Staff Name</label>
                              <select class="form-select" id="staff_name">
                               
                              </select>
                              <div class="text-danger" id="error_staff_name"></div>
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">First Name</label>
                              <input class="form-control" type="text" data-bs-original-title="" placeholder="First Name" required="" id="first_name">
                              <div class="text-danger" id="error_first_name"></div>
                            </div>                         
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Last Name</label>
                              <input class="form-control" type="text" data-bs-original-title="" placeholder="Last Name" required="" id="last_name">
                              <div class="text-danger" id="error_last_name"></div>
                            </div>
                            <div class="col-lg-4 position-relative">
                              <label class="form-label futuredate_disable">Date Of Birth</label>
                              <input class="form-control digits" type="date" placeholder="Date Of Birth" required="" value="<?php echo date("d M Y"); ?>" id="customer_dob">
                              <div class="text-danger" id="error_customer_dob"></div>
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Gender</label>
                              <select class="form-select" required="" id="customer_gender">
                                
                              </select>
                              <div class="text-danger" id="error_customer_gender"></div>
                            </div>                         
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Age</label>
                              <input class="form-control" type="text" data-bs-original-title="" placeholder="Age" required="" id="customer_age">
                              <div class="text-danger" id="error_customer_age"></div>
                            </div>
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Mobile</label>
                              <input class="form-control" type="text" data-bs-original-title="" placeholder="Mobile" required="" id="customer_phone">
                              <div class="text-danger" id="error_customer_phone"></div>
                            </div>
                          </div>
                          <div class="row mb-3">                         
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Email ID</label>
                              <input class="form-control" type="text" data-bs-original-title="" placeholder="Email ID" required="" id="customer_email">
                              <div class="text-danger" id="error_customer_email"></div>
                            </div>  
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Address</label>
                              <textarea class="form-control" placeholder="Address" required="" rows="1" id="customer_address"></textarea >
                              <div class="text-danger" id="error_customer_address"></div>
                            </div>
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">State Name</label>
                              <select class="form-select" id="state_name">
                               
                              </select>
                              <div class="text-danger" id="error_state_name"></div>
                            </div>
                            <!-- <div class="col-lg-4 position-relative">
                              <label class="form-label">customer Source</label>
                              <select class="form-select" required="" id="lead_source_name">
                                
                              </select>
                              <div class="text-danger" id="error_source_name"></div>
                            </div> -->
                            <!-- <div class="col-lg-4 position-relative">
                              <label class="form-label futuredate_disable">Enquiry Date</label>
                              <input class="form-control digits" type="date" placeholder="Enquiry Date" required="" id="enquiry_date">
                              <div class="text-danger" id="error_enquiry_date"></div>
                            </div> -->
                          </div>
                          <div class="row mb-3">                         
                            <!-- <div class="col-lg-4 position-relative">
                              <label class="form-label">lead Status</label>
                              <select class="form-select" required="" id="lead_status_name">
                               
                              </select>
                              <div class="text-danger" id="error_lead_status_name"></div>
                            </div>      -->
                           
                            <!-- <div class="col-lg-4 position-relative">
                              <label class="form-label">Treatment Name</label>
                                <select class="form-select" required="" id="customer_treatment_name">
                                                                                                    
                                </select>
                              <div class="text-danger" id="error_treatment_name"></div>
                            </div> -->
                          </div>
                          <!-- <div class="row mb-3"> -->
                            <!-- <div class="col-lg-4 position-relative">
                              <label class="form-label">Problem</label>
                              <textarea class="form-control" placeholder="Problem" required="" rows="1" id="customer_problem"></textarea >
                              <div class="text-danger" id="error_customer_problem"></div>
                            </div>                          -->
                            
                          <!-- </div> -->
                          <div class="row mb-3">
                            <div class="card-footer text-end">
                                <input class="form-control digits" type="hidden" placeholder="Enquiry Date" required="" id="lead_source_name">
                                <input class="form-control digits" type="hidden" placeholder="Enquiry Date" required="" id="enquiry_date">
                                <input class="form-control " type="hidden" placeholder="Remarks" required="" rows="2" id="lead_status_name">
                                <input class="form-control" type="hidden" placeholder="Problem" rows="1" id="customer_treatment_name">
                                <input class="form-control digits" type="hidden" placeholder="Enquiry Date" required="" id="customer_problem">
                                <input class="form-control digits" type="hidden" placeholder="Enquiry Date" required="" id="customer_remark">
                                <button class="btn btn-secondary" type="reset" data-bs-original-title="" title=""><a href='./customer'>Cancel</a></button>
                                <button class="btn btn-primary" type="button" data-bs-original-title="" title="" id="upd_customer" onclick="update_customer()">Submit</button>
                                <!-- <button class="btn btn-primary"  data-bs-original-title="" title="" onclick="add_branch()">Submit</button> -->
                            </div>
                          </div>
                          </div><br>
                          <!-- <label class="form-label" style="color: black !important;font-weight: 550;"><u>TREATMENT DETAILS</u></label>
                          <table class="display" id="customer_treatment_details_edit">
                            <thead>
                              <tr>
                                <th class="min-w-25px">Sno</th>
                                <th class="min-w-100px">Treatment Categories</th>
                                <th class="min-w-100px">Treatment Name</th>                               
                                <th class="min-w-100px">Treatment in Sitting</th>
                                <th class="min-w-100px">Treatment in Due</th>
                                <th class="min-w-100px">Medicine Preferred</th>
                                <th class="min-w-100px">Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>Skin Care Treatment</td>
                                <td>Dermal Fillers</td>                               
                                <td>3</td>
                                <td>0</td>
                                <td>Restylane-L filler</td>
                                <td class="ple1">Restylane-L filler generally last for a time period of four and a half months to nine months</td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>Skin Care Treatment</td>
                                <td>Dermal Fillers</td>                  
                                <td>3</td>
                                <td>0</td>
                                <td>Restylane-L filler</td>
                                <td class="ple1">Restylane-L filler generally last for a time period of four and a half months to nine months</td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>Skin Care Treatment</td>
                                <td>Dermal Fillers</td>                               
                                <td>3</td>
                                <td>0</td>
                                <td>Restylane-L filler</td>
                                <td class="ple1">Restylane-L filler generally last for a time period of four and a half months to nine months</td>
                              </tr>
                              <tr>
                                <td>4</td>
                                <td>Skin Care Treatment</td>
                                <td>Dermal Fillers</td>                                
                                <td>3</td>
                                <td>0</td>
                                <td>Restylane-L filler</td>
                                <td class="ple1">Restylane-L filler generally last for a time period of four and a half months to nine months</td>
                              </tr>
                            </tbody>
                          </table><br>
                          <label class="form-label" style="color: black !important;font-weight: 550;"><u>APPOINTMENT DETAILS</u></label>
                          <table class="display" id="customer_appointment_details_edit">
                            <thead>
                              <tr>
                                <th class="min-w-25px">Sno</th>
                                <th class="min-w-100px">Prev Appointment</th>
                                <th class="min-w-100px">Next Appointment</th>
                                <th class="min-w-100px">Lead</th>
                                <th class="min-w-100px">Problem</th>
                                <th class="min-w-100px">Treatment Pitched</th>
                                <th class="min-w-100px">Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>07/10/2022</td>
                                <td>09/10/2022</td>
                                <td>Harish</td>
                                <td>Hair Loss</td>
                                <td>DHI</td>
                                <td class="ple1">Restylane-L filler generally last for a time period of four and a half months to nine months</td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>09/10/2022</td>
                                <td>10/10/2022</td>
                                <td>Harish</td>
                                <td>Hair Loss</td>
                                <td>DHI</td>
                                <td class="ple1">Restylane-L filler generally last for a time period of four and a half months to nine months</td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>10/10/2022</td>
                                <td>11/10/2022</td>
                                <td>Harish</td>
                                <td>Hair Loss</td>
                                <td>DHI</td>
                                <td class="ple1">Restylane-L filler generally last for a time period of four and a half months to nine months</td>
                              </tr>
                              <tr>
                                <td>4</td>
                                <td>11/10/2022</td>
                                <td>13/10/2022</td>
                                <td>Harish</td>
                                <td>Hair Loss</td>
                                <td>DHI</td>
                                <td class="ple1">Restylane-L filler generally last for a time period of four and a half months to nine months</td>
                              </tr>
                            </tbody>
                          </table><br>
                          <label class="form-label" style="color: black !important;font-weight: 550;"><u>PAYMENT DETAILS</u></label>
                          <table class="display" id="customer_payment_details_edit">
                            <thead>
                              <tr>
                                <th class="min-w-100px">Sno</th>
                                <th class="min-w-100px">Status</th>
                                <th class="min-w-100px">Amount</th>
                                <th class="min-w-100px">Total Amount</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>Paid</td>
                                <td>2000.00</td>
                                <td>2000.00</td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>Paid</td>
                                <td>1000.00</td>
                                <td>1000.00</td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>Paid</td>
                                <td>1000.00</td>
                                <td>1000.00</td>
                              </tr>
                              <tr>
                                <td>4</td>
                                <td>Paid</td>
                                <td>500.00</td>
                                <td>500.00</td>
                              </tr>
                            </tbody>
                          </table> -->
                         
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Container-fluid Ends-->
            </form>
        </div>
        <!-- footer start-->
        
        <!-- footer start-->
      </div>
    </div>
    
    <script>
      $("#customer_payment_details_edit").DataTable({
          // "ordering": false,
          "responsive": true,
          "aaSorting":[],
           "language": {
            "lengthMenu": "Show _MENU_",
           },
           "dom":
            "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +

            "<'table-responsive'tr>" +

            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
          });
      $("#customer_appointment_details_edit").DataTable({
          // "ordering": false,
          "responsive": true,
          "aaSorting":[],
           "language": {
            "lengthMenu": "Show _MENU_",
           },
           "dom":
            "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +

            "<'table-responsive'tr>" +

            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
          });
      $("#customer_treatment_details_edit").DataTable({
          // "ordering": false,
          "responsive": true,
          "aaSorting":[],
           "language": {
            "lengthMenu": "Show _MENU_",
           },
           "dom":
            "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +

            "<'table-responsive'tr>" +

            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
          });
    </script>
    <script>
      $("#customer_appointment_details_edit").kendoTooltip({
        filter: "td",
        show: function(e){
          if(this.content.text() !=""){
            $('[role="tooltip"]').css("visibility", "visible");
          }
        },
        hide: function(){
          $('[role="tooltip"]').css("visibility", "hidden");
        },
        content: function(e){
          var element = e.target[0];
          if(element.offsetWidth < element.scrollWidth){
            return e.target.text();
          }else{
            return "";
          }
        }
      });

      $("#customer_treatment_details_edit").kendoTooltip({
        filter: "td",
        show: function(e){
          if(this.content.text() !=""){
            $('[role="tooltip"]').css("visibility", "visible");
          }
        },
        hide: function(){
          $('[role="tooltip"]').css("visibility", "hidden");
        },
        content: function(e){
          var element = e.target[0];
          if(element.offsetWidth < element.scrollWidth){
            return e.target.text();
          }else{
            return "";
          }
        }
      });
    </script>
    <!-- login js-->
    <!-- Plugin used-->
    
    @include('api.api_edit_customer')
  </body>
</html>
@endsection


