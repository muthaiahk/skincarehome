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
                      <h3>Add Department</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="department">Department Lists</a></li>
                        <li class="breadcrumb-item">Add Department</li>
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
                   <div  id="status_success">
                     
                     </div> 
                    <div class="card-body">
                      <div class="row mb-3">
                        <div class="col-lg-4 position-relative">
                            <label class="form-label">Company Name</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="company_name" placeholder="Company Name"   readonly>
                            <div class="text-danger" id="error_company_name"></div>
                          </div>
                        <div class="col-lg-4 position-relative" id="department_branch_list">
                          
                        </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Department Name</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="department_name" placeholder="Department">
                            <div class="text-danger" id="error_department_name"></div>
                          </div>
                        </div>
                        <!--<div class="row mb-3">-->
                        <!--  <div class="col-lg-4 position-relative" id="staff_list"></div>-->
                          <!-- <div class="col-lg-4 position-relative">
                            <label class="form-label">Person Incharge</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="dept_incharge"placeholder="Person Incharge">
                            <div class="text-danger" id="error_dept_incharge"></div>
                          </div> -->

                        <!--</div>-->
                        <div class="row mb-3">
                          <div class="card-footer text-end">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./department'>Cancel</a></button>
                            <button class="btn btn-primary" type="button" data-bs-original-title="" id= "add_depart" title=""onclick="add_department()">Submit</button>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        
        <!-- footer start-->
      </div>
    </div>
    
    
    @include('api.api_department')
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>
@endsection


