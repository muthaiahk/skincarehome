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
                      <h3>Attendance </h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Attendance</li>                
                      </ol>
                    </div>
                  </div>
                </div>
            </div>
        <form class="form wizard">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <div class="row mt-3 mx-2">
                      <div class="col-lg-3">
                        <label class="form-label">Branch</label>
                        <select class='form-select' id='branch_name'>
                        <option value='0'>Select Branch</option></select>
                        <div class="text-danger" id="error_branch_id"></div>
                      </div>
                      <div class="col-lg-3">
                        <label class="form-label">Month</label>
                        <input class="form-control digits" type="month" placeholder="Date" id="attendance" required="" value="<?php echo date("Y-m"); ?>">
                      </div>
                      <div class="col-lg-1">
                        <button class="btn btn-primary report_mt-4" type="button" data-bs-original-title="" title="" id="attendance_filter">Go</button>
                      </div> 
                      <div class="col-lg-5 text-end float-right">
                        <a href="edit_atd"><button class="btn btn-primary " type="button" >Modify Attendance</button></a>
                        <a href="mark_atd"><button class="btn btn-primary " type="button" >Mark Attendance</button></a>                
                      </div>
                    </div>
                  </div>  
                  <div class="card-body">                    
                    
                    <div class="table-responsive product-table" id="attendance_list">
                        
                    </div> 
                  </div>
                </div>
              </div>
            </div>          
            <!-- Container-fluid Ends-->
          </div>
        </form>
        </div>
        <!-- footer start-->
        
        <!-- footer start-->
      </div>
    </div>
    
    
    @include('api.api_attendance')
    <!-- login js-->
    <!-- Plugin used-->
       
   
  </body>
  </html>
@endsection


