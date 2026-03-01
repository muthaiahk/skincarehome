<?php include("common.php") ?>
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
      <?php include("header.php") ?>
      <!-- Page Header Ends-->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <?php include("sidebar.php") ?>
        <!-- Page Sidebar Ends-->

        <div class="page-body">
            <div class="container-fluid">        
                <div class="page-title">
                  <div class="row">
                    <div class="col-6">
                      <h3>View Customer</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="customer">Customer Lists</a></li>
                        <li class="breadcrumb-item">View Customer</li>
                      </ol>
                    </div>
                  </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-12">
                  <div class="card">
                    <!-- <div class="card-header">
                      <h5>Lead Lists</h5>
                    </div> -->
                    <div class="card-body">
                    <div class="row mb-3">
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Company Name</label>
                              <input class="form-control" type="text" data-bs-original-title="" placeholder="Company Name" value="" required="" readonly id="company_name">
                             
                            </div>
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Branch Name</label>
                              <input class="form-control" type="text" data-bs-original-title="" placeholder="Branch Name" value="" required="" readonly id="customer_branch_name">
                           
                            </div>
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Staff Name</label>
                              <input class="form-control" type="text" data-bs-original-title="" placeholder="Staff Name" value="Hema" required="" readonly id="customer_staff_name">
                              
                            </div>
                          </div>
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">First Name</label>
                            <input class="form-control" type="text" data-bs-original-title="" placeholder="First Name" required="" value="" readonly id="customer_first_name">
                            
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Last Name</label>
                            <input class="form-control" type="text" data-bs-original-title="" placeholder="Last Name" required="" value="" readonly id="customer_last_name">
                            
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Date Of Birth</label>
                            <input class="form-control digits" type="date" placeholder="Date Of Birth" required="" value="" readonly id="customer_dob">
                            
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Gender</label>
                            <input class="form-control" type="text" data-bs-original-title="" placeholder="Gender" required="" value="" readonly id="customer_gender">
                            
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Age</label>
                            <input class="form-control" type="text" data-bs-original-title="" placeholder="Age" required="" value="" readonly id="customer_age">
                            
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Mobile</label>
                            <input class="form-control" type="text" data-bs-original-title="" placeholder="Mobile" required="" value="" readonly id="customer_phone">
                            
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Email ID</label>
                            <input class="form-control" type="text" data-bs-original-title="" placeholder="Email ID" required="" value="" readonly id="customer_email">
                         
                          </div>
                          <!-- <div class="col-lg-4 position-relative">
                            <label class="form-label">Lead Source</label>
                            <input class="form-control" type="text" data-bs-original-title="" placeholder="Lead Source" required="" value="" readonly id="customer_lead_source_name">
                           
                          </div> -->
                          <!-- <div class="col-lg-4 position-relative">
                            <label class="form-label">Enquiry Date</label>
                            <input class="form-control digits" type="date" placeholder="Enquiry Date" required="" value="" readonly id="customer_enquiry_date">
                          
                          </div>
                        </div>
                        <div class="row mb-3"> -->
                        <input class="form-control digits" type="hidden" placeholder="Enquiry Date" required="" value="" readonly id="customer_enquiry_date">
                          <!-- <div class="col-lg-4 position-relative">
                            <label class="form-label">Lead Status</label>
                            <input class="form-control" type="text" data-bs-original-title="" placeholder="Lead Status" required="" value="" readonly id="customer_lead_status_name">
                        
                          </div> -->
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" placeholder="Address" required="" rows="1" readonly id="customer_address"></textarea>
                            
                          </div>
                          <!-- <div class="col-lg-4 position-relative">
                            <label class="form-label">Treatment Name</label>
                            <input class="form-control" type="text" data-bs-original-title="" placeholder="Treatment Name" value="" required="" readonly id="customer_lead_treatment_name">
                          
                          </div> -->
                        <!-- </div>
                        <div class="row mb-3"> -->
                          <!-- <div class="col-lg-4 position-relative">
                            <label class="form-label">Problem</label>
                            <textarea class="form-control" placeholder="Problem" required="" rows="1" readonly id="customer_problem"></textarea>
                           
                          </div>            
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Remarks</label>
                            <textarea class="form-control" placeholder="Remarks" required="" rows="2" readonly id="customer_remark"></textarea>
                            
                          </div> -->
                        </div><br>
                        <label class="form-label" style="color: black !important;font-weight: 550;"><u>TREATMENT DETAILS</u></label>
                        <div class="table-responsive product-table" id="customer_treatment_details_view"> </div>
                        <br>
                        <label class="form-label" style="color: black !important;font-weight: 550;"><u>APPOINTMENT DETAILS</u></label>
                          <div class="table-responsive product-table" id="customer_appointment_details_view"></div>
                        
                        <br>
                        <label class="form-label" style="color: black !important;font-weight: 550;"><u>PAYMENT DETAILS</u></label>
                        <div class="table-responsive product-table" id="customer_payment_details_view"></div>  
                        
                    </div>
                    <div class="row mb-3">
                          <div class="card-footer text-end">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./customer'>back</a></button>
                            <!-- <button class="btn btn-primary"  data-bs-original-title="" title="" onclick="add_branch()">Submit</button> -->
                          </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <?php include("footer.php") ?>
        <!-- footer start-->
      </div>
    </div>
    <?php include("script.php") ?>
    
    <script>
      $("#customer_appointment_details_view").kendoTooltip({
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

      $("#customer_treatment_details_view").kendoTooltip({
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
    <?php include("session_timeout.php") ?>
    <?php include("api/api_edit_customer.php") ?>
  </body>
</html>