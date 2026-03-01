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
                <h3>Staff Lists</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard">
                      <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Staff Lists</li>
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
                  <div id="status_success">

                  </div>
                  <div class="card-header" id="add_staff">
                    <div class="row mt-3 mx-2">
                      <div class="col-lg-3 position-relative">
                        <select class='form-select' id='branch_name' multiple>
                          <option value='0'>Select Branch</option>
                        </select>
                        <div class="text-danger" id="error_branch_id"></div>
                      </div>
                      <div class="col-lg-4" id="sl_department_list">
                        <select class="form-select" id="department_name">

                        </select>
                      </div>
                      <div class="col-lg-2">
                        <button class="btn btn-primary" type="button" data-bs-original-title="" title="" onclick="filter_deprt()">Go</button>
                      </div>
                      <div class="col-lg-3">
                        <div class=" text-end float-right">
                          <a href="add_staff.php"><button class="btn btn-primary " type="button">Add Staff</button></a>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="card-body">

                    <div class="table-responsive product-table" id="staff_list">

                    </div>
                  </div>
                </div>
              </div>
        </form>
      </div>
      <div class="modal fade" id="staff_delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <br>
              <h5 style="text-align: center;">Delete ?
              </h5>
              <br>
              <div class="mb-3">
                <p class="col-form-label" style="text-align: center !important;">Are you sure you want to delete this data ?</p>
              </div>
            </div>
            <div class="card-footer text-center mb-3">
              <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
              <button class="btn btn-primary" type="button" data-bs-dismiss="modal" id="delete">Yes, delete</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Container-fluid Ends-->
    </div>
  </div>
  <!-- footer start-->
  
  <!-- footer start-->
  </div>
  </div>
  
  <!-- login js-->
  <!-- Plugin used-->
  
  @include('api.api_staff')

</body>

</html>
@endsection


