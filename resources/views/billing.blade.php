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
                <h3>Billing Lists</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard">
                      <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Billing Lists</li>
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
                <div class="card-body">
                  <div class="row">
                    <div class="row card-header mt-4 mx-3" id="add_treatment">
                      <div class="col-md-3">
                        <div id="branch_list">
                          <select class="form-select" id="branch_name" onChange="selectbranch(event)">
                            <option value="0">All Branch</option>
                          </select>
                          <div class="invalid-feedback"></div>
                        </div>
                      </div>

                      <!-- <div class="col-md-3">
                        <select class="form-select" id="treatment_cat_list">
                          <option value="0">Select Category</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <select class="form-select" id="select_treatment">
                          <option value="0">Select Treatment</option>
                        </select>
                      </div> -->
                      
                      <div class="col-lg-1">
                        <p class="btn btn-primary" id="all_billing_list">Go</p>
                      </div>
                      <div class="col-md-3"></div>
                      <div class="col-md-3"></div>
                      
                      <div class="col-md-2">
                        <div class=" text-end float-right">
                          <a href="add_billing.php" type="button" class="btn btn-primary" data-bs-original-title="">Add Billing</a>
                        </div>
                      </div>
                    </div>
                    <div id="status_success">

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


                    <div class="table-responsive product-table" id="billing_list">
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid Ends-->
      </div>
      <!-- footer start-->
      
      <!-- footer start-->
    </div>
  </div>
  <div class="modal fade" id="billing_balance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Large modal for better visibility -->
      <div class="modal-content">
        <div class="modal-body">
          <h5 class="text-center">Billing Balance</h5>
          <div id="billing-details" class="text-center mt-3">
            <div class="row justify-content-center mb-2">
              <div class="col-auto">
                <p class="mb-0" style="color: #007bff; font-size: 20px;"><strong>Total Amount:</strong> <span id="total-amount" class="fs-2 fw-bold">$0.00</span></p>
              </div>
              <div class="col-auto">
                <p class="mb-0" style="color: #28a745; font-size: 20px;"><strong>Paid Amount:</strong> <span id="paid-amount" class="fs-2 fw-bold">$0.00</span></p>
              </div>
              <div class="col-auto">
                <p class="mb-0" style="color: #dc3545; font-size: 20px;"><strong>Remaining Balance:</strong> <span id="remaining-amount" class="fs-2 fw-bold">$0.00</span></p>
              </div>
            </div>

            <div id="warning-message" class="alert alert-danger mt-2 d-none" role="alert">
              Warning: Remaining balance exceeds the total amount.
            </div>
            <div class="row mt-4">
              <div class="col-md-6 mx-auto"> <!-- Center the input field -->
                <label for="payment-amount" class="form-label"><strong>Enter Amount:</strong></label>
                <input type="number" class="form-control" id="payment-amount" placeholder="Enter payment amount" min="0" />
              </div>
              <div class="col-md-6 mx-auto"> <!-- right end the label field when enter show the balance amount and if == or exceed amoun hide it  -->
                <label for="payment-amount-balance" class="form-label"><strong>Balance Amount:</strong></label>
                <label class="form-control" id="payment-amount-balance">0</label>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-center mb-3">
          <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
          <button class="btn btn-primary d-none" type="button" id="pay-balance">Yes, Pay Balance</button>
        </div>
      </div>
    </div>
  </div>


  
  
  @include('api.api_billing')

</body>

</html>
@endsection


