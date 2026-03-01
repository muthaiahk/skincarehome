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
                <h3>Treatment list</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard">
                      <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Treatment list</li>
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
                  <div class="row card-header mt-4 mx-3" id="add_treatment">


                    <div class="col-md-3">
                      <div id="branch_list">
                        <!-- multiple -->
                        <label class="form-label">Branch</label> 
                        <select class="form-select" id="branch_name"  onChange="selectbranch(event)">
                          <option value="0">Select Branch</option>
                        </select>
                        <div class="invalid-feedback"></div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Category</label>
                      <select class="form-select" id="treatment_cat_list">
                        <option value="0">Select Category</option>
                      </select>

                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Treatment</label>
                      <select class="form-select" id="select_treatment">
                        <option value="0">Select Treatment</option>
                      </select>
                    </div>

                    <div class="col-md-3">
                      <div class=" text-end float-right">
                        <a href="add_t_management.php"><button class="btn btn-primary " id='add_t_management' type="button">Add Treament</button></a>
                      </div>
                    </div>
                    <div class="col-md-3 mt-2">
                      <label class="form-label">Status</label>
                      <select class="form-select" id="select_status">
                        <option value="">Select Status</option>
                        <option value="0">Progress</option>
                        <option value="1">Completed</option>
                      </select>

                    </div>
                  </div>


                  <div class="card-body">

                    
                    <div class="d-flex justify-content-end mt-2 mb-2">
                      <div class="col-3">
                        <input class="form-control" type="text" placeholder="Search" id='search_input'>
                      </div>
                    </div>
                    <div id="loadingIndicator" class="text-center">
                      <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                      </div>
                      <p>Loading data, please wait...</p>
                    </div>
                    
                    <div class="table-responsive product-table" id="treatment_management_list">

                    </div>
                  </div>
                </div>
              </div>
        </form>
      </div>
      <div class="modal fade" id="t_management_delete" tabindex="-1" role="dialog" aria-hidden="true">
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
      <div class="modal fade" id="t_management_completed" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <br>
              <h5 style="text-align: center;">Complete ?
              </h5>
              <br>
              <div class="mb-3">
                <p class="col-form-label" style="text-align: center !important;">Are you sure you want to Completed this data ?</p>
              </div>
            </div>
            <div class="card-footer text-center mb-3">
              <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
              <button class="btn btn-primary" type="button" data-bs-dismiss="modal" id="complete">Yes, Completed</button>
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
  
  
  @include('api.api_treatment_management')
  <!-- login js-->
  <!-- Plugin used-->

</body>

</html>
@endsection


