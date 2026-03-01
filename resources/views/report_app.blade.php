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
                        <h3>Appointment Report</h3>
                      </div>
                      <div class="col-6">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="dashboard">
                            <i data-feather="home"></i></a></li>
                          <li class="breadcrumb-item">Appointment Report</li>
                       <!--    <li class="breadcrumb-item"><a href="add_product.php">Add New</a></li> -->
                        </ol>
                      </div>
                    </div>
                  </div>
              </div>
            <!-- Container-fluid starts-->
        <form class="form wizard">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row mb-3 me-1">  
                          <div class="col-lg-3 " id="branch_list">
                            <label class="form-label">Branch</label>
                            <select class='form-select' id='branch_name' multiple>
                            <option value='0'>Select Branch</option></select>
                            <div class="text-danger" id="error_branch_id"></div>
                          </div>                        
                          <div class="col-md-3">
                            <label class="form-label">Treatment</label>
                            <!-- <input class="form-control digits" type="text" placeholder="Location" required=""> -->
                              <select class="form-select" id="treatment_list">
                                        
                              </select>
                          </div> 
                          <div class="col-lg-4">
                              <label class="form-label">Date Range</label>
                              <div class="input-group input-daterange col-md-4">
                                <input type="date"  id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
                                <span class="input-group-addon p-2">To</span>
                                <input type="date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
                              </div>
                          </div>
                          <div class="col-lg-1">
                            <button class="btn btn-primary report_mt-4" type="button" data-bs-original-title="" title="" id="treatment_filter">Go</button>
                          </div>  
                          <div class="col-lg-1  text-end">
                            <button class="btn btn-primary report_mt-4" type="button" data-bs-original-title="" title="" onclick='app_report_export();'>Export</button>
                          </div> 
                        </div> 
                        <div class="table-responsive product-table" id="appointment_report">
                         
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </form>
              
          
          <!-- Container-fluid Ends-->
      </div>
      </div>
        <!-- footer start-->
        
        <!-- footer start-->
      </div>
    </div>
    <div class="modal fade" id="lead_loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

      <div class="modal-dialog" role="document" style="text-align:center;position:relative;top:35%;">
        <!-- <div class="modal-content"> -->
          <img src="assets/images/loader/loader-renew.gif" style="width:50%;" />
        <!-- </div> -->
      </div>
    </div>
    
    
    @include('api.api_report_appointment')
  </body>
  </html>
@endsection


