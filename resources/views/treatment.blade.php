@extends('layouts.app')

@section('content')

<body onload="startTime()">
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
  <div class="tap-top"><i data-feather="chevrons-up"></i></div>
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
                <h3>Treatment Lists</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard">                                       
                    <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Treatment Lists</li>
                    <!-- <li class="breadcrumb-item active">Default</li> -->
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
                  <div  id="status_success">
                     
                  </div> 
                  <div class="card-header text-end">
                    <a href="add_treatment" id="add_treatment" type="button" class="btn btn-primary" type="submit" data-bs-original-title="">Add Treatment</a>
                  </div>
                  
                  <div class="card-body">
                    <div class="table-responsive product-table" id="treatment_list">
                      
                    </div>
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
    <div class="modal fade" id="treatment_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <br>
            <h5 style="text-align: center;">Delete ?</h5><br>
            <div class="mb-3">
              <p class="col-form-label" style="text-align: center !important;">Are you sure you want to delete this Data.</p>
            </div>
          </div>
          <div class="card-footer text-center mb-3">
            <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
            <button class="btn btn-primary" type="button" data-bs-dismiss="modal" id="delete">Yes, delete</button>
          </div>
        </div>
      </div>
    </div>
    
    
    @include('api.api_treatment')
  </body>
  </html>
@endsection


