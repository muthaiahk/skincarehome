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
                      <h3>Payment Report</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Payment Report</li>
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
                    <!-- <form class="mega-form"> -->
                    <div class="row mb-3">                        
                          <div class="col-md-3">
                            <label class="form-label">Treatment Category</label>
                            <!-- <input class="form-control digits" type="text" placeholder="Location" required=""> -->
                            <select class="form-select" id="treatment_cat_list">
                                
                            </select>

                          </div>    
                          <div class="col-md-3">
                            <label class="form-label">Treatment</label>
                            <!-- <input class="form-control digits" type="text" placeholder="Location" required=""> -->
                            <select class="form-select" id="select_treatment">
                                
                            </select>
                            
                          </div>  
                          <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <!-- <input class="form-control digits" type="text" placeholder="Location" required=""> -->
                            <select class="form-select" id="paid_status">
                              <option value='2'>All</option>
                              <option value='0'>Paid</option>
                              <option value='1'>Pending</option>
                            </select>
                            
                          </div>  
                          <div class="col-lg-3 " id="branch_list">
                            <label class="form-label">Branch</label>
                            <select class='form-select' id='branch_name' multiple>
                            <option value='0'>Select Branch</option></select>
                            <div class="text-danger" id="error_branch_id"></div>
                          </div>
                          
                          <div class="col-lg-6  mt-3">
                                <label class="form-label">Date Range</label>
                                
                                <div class="input-group input-daterange col-md-6">
                                  <input type="date"  id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
                                  <span class="input-group-addon p-2">To</span>
                                  <input type="date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
                                </div>
                                
                              </div>
                          <div class="col-lg-1 mt-3">
                            <button class="btn btn-primary report_mt-4" type="button" data-bs-original-title="" title="" id="treatment_cat_filter">Go</button>
                          </div>  
                          <div class="col-lg-1 mt-3 text-end">
                            <button class="btn btn-primary report_mt-4" type="button" data-bs-original-title="" title=""  onclick='payment_report_export();'>Export</button>
                          </div>
                        </div>                                         
                      <div class="table-responsive product-table" id="payment_report">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>         
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
    
    <!-- login js-->
    <!-- Plugin used-->
    
    @include('api.api_report_payment')
   
  </body>
  </html>
@endsection


