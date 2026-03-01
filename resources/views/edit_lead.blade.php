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
                      <h3>Modify Lead</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="lead">Lead Lists</a></li>
                        <li class="breadcrumb-item">Modify Lead</li>
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
                              <label class="form-label">Date Of Birth</label>
                              <input class="form-control digits futuredate_disable" type="date" name="dob" placeholder="Date Of Birth" required="" value="" id="lead_dob" onfocusout="check_date(event)">
                              <div class="text-danger" id="error_lead_dob"></div>
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Gender</label>
                              <select class="form-select" required="" id="lead_gender">
                                
                              </select>
                              <div class="text-danger" id="error_lead_gender"></div>
                            </div>                         
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Age</label>
                              <input class="form-control" type="text" data-bs-original-title="" placeholder="Age" required="" id="lead_age">
                              <div class="text-danger" id="error_lead_age"></div>
                            </div>
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Mobile</label>
                              <input class="form-control" type="text" data-bs-original-title="" placeholder="Mobile" required="" id="lead_phone">
                              <div class="text-danger" id="error_lead_phone"></div>
                            </div>
                          </div>
                          <div class="row mb-3">                         
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Email ID</label>
                              <input class="form-control" type="text" data-bs-original-title="" placeholder="Email ID" required="" id="lead_email">
                              <div class="text-danger" id="error_lead_email"></div>
                            </div>                          
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Lead Source</label>
                              <select class="form-select" required="" id="lead_source_name">
                                
                              </select>
                              <div class="text-danger" id="error_source_name"></div>
                            </div>
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Enquiry Date</label>
                              <input class="form-control digits futuredate_disable" type="date" placeholder="Enquiry Date" required="" id="enquiry_date">
                              <div class="text-danger" id="error_enquiry_date" onfocusout="check_date(event)"></div>
                            </div>
                          </div>
                          <div class="row mb-3">                         
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Lead Status</label>
                              <select class="form-select" required="" id="lead_status_name">
                               
                              </select>
                              <div class="text-danger" id="error_lead_status_name"></div>
                            </div>  
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">State</label>
                                <select class="form-select" required="" id="state_name">
                                  <option value="0">Select State</option>
                                  
                                </select>
                                <div class="text-danger" id="error_state_name"></div>
                            </div>   
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Address</label>
                              <textarea class="form-control" placeholder="Address" required="" rows="1" id="lead_address"></textarea >
                              <div class="text-danger" id="error_lead_address"></div>
                            </div>
                            <!-- <div class="col-lg-4 position-relative">
                              <label class="form-label">Treatment Name</label>
                                <select class="form-select" required="" id="lead_treatment_name">
                                                                                                    
                                </select>
                              <div class="text-danger" id="error_treatment_name"></div>
                            </div> -->
                              <select class="form-select " style="display:none;" required="" id="lead_treatment_name" disabled>
                                                                                                    
                              </select>
                          
                         
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Problem</label>
                              <textarea class="form-control" placeholder="Problem" required="" rows="1" id="lead_problem"></textarea >
                              <div class="text-danger" id="error_lead_problem"></div>
                            </div>                         
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Remarks</label>
                              <textarea class="form-control" placeholder="Remarks" required="" rows="2" id="lead_remark"></textarea >
                              <div class="text-danger" id="error_lead_remark"></div>
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="card-footer text-end">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./lead'>Cancel</a></button>
                                <button class="btn btn-primary" type="button" data-bs-original-title="" title="" id="upd_lead" onclick="update_lead()">Submit</button>
                                <!-- <button class="btn btn-primary"  data-bs-original-title="" title="" onclick="add_branch()">Submit</button> -->
                            </div>
                          </div>
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
    
    
    @include('api.api_edit_lead')
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>
@endsection


