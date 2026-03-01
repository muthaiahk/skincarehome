@extends('layouts.app')

@section('content')

<!-- <body onload="startTime()"> -->

<body>
  <style>
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 14px;
      font-weight: 500;
      padding: 4px 8px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .status-upcoming {
      background-color: #dc3545;
      color: #fff;
    }

    .status-missed {
      background-color: #ffc107;
      color: #212529;
    }

    .status-completed {
      background-color: #28a745;
      color: #fff;
    }

    .status-click-complete {
      background-color: #1b5105;
      color: #fff;
      cursor: pointer;
    }

    .status-click-complete:hover {
      background-color: #2f7a0a;
    }
  </style>
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
                <h3>FollowUp History Lists</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard">
                      <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">FollowUp History Lists</li>
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
                <div id="status_success">

                </div>
                <div class="card-body">
                  <div class="row mb-2">

                    <div class="col-md-3">
                      <div id="dashboard_branch_list">
                        <!-- <label class="form-label">Branch</label> -->
                        <select class="form-select"  id="branch_name">

                        </select>
                        <div class="invalid-feedback"></div>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <input class="form-control" type="date" id="from_date" value="">
                    </div>
                    <div class="col-lg-3">
                      <input class="form-control" type="date" id="to_date" value="">
                    </div>
                    <div class="col-lg-1">
                      <p class="btn btn-primary" id="data_filter">Go</p>
                    </div>
                  </div>
                  <div class="row">
                    <!-- <div class="card-header text-end">
                          <a href="add_followup_history" type="button" class="btn btn-primary" type="submit" data-bs-original-title="">Add FollowUp</a>
                        </div> -->
                    <!-- <div class="col-md-4 position-relative">
                            <label class="form-label" for="validationTooltip01">First name</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="" data-bs-original-title="" title="">
                          <div class="valid-tooltip">Looks good!</div>
                        </div> -->
                  </div>
                  <div class="d-flex justify-content-end mt-2 mb-2">
                    <div class="col-3">
                      <input class="form-control" type="text" placeholder="Search" id='search_input'>
                    </div>
                  </div>
                  <!-- Loading Indicator -->
                    <div id="loadingIndicator" class="text-center" style="display: none;">
                      <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                      </div>
                      <p>Loading data, please wait...</p>
                    </div>
                  <div class="card-body table-responsive" id='followup_list'>
                    <!-- <table class="display" id="followup_history_lists">
                          <thead>
                            <tr>
                              <th class="min-w-100px">Name</th>
                              <th class="min-w-100px">Mobile</th>
                              <th class="min-w-100px">FlwUp Date</th>
                              <th class="min-w-100px">FlwUp Count</th>
                              <th class="min-w-125px">Next FlwUp Date</th>
                              <th class="min-w-100px">Status</th>
                              <th class="min-w-100px">Remarks</th>
                              <th class="min-w-125px">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Srinivasan K</td>
                              <td>9598959695</td>
                              <td>02/10/2022</td>
                              <td>1</td>
                              <td>03/10/2022</td>
                              <td>Possitive</td>
                              <td>Good</td>
                              <td>
                                <a href="view_followup_history"><i class="fa fa-eye eyc"></i></a>
                                <a href="edit_followup_history"><i class="fa fa-edit eyc"></i></a>
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#followup_history_delete"><i class="fa fa-trash eyc"></i></a>
                              </td>
                            </tr>
                          </tbody>
                        </table> -->
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

  <!-- <div class="modal fade" id="lead_followup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Follow Up</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="form wizard">
            <div class="modal-body">
              <div class="row mb-3">
                <div class="col-lg-6 position-relative">
                  <label class="form-label">FollowUp Date</label>
                  <input class="form-control digits" type="date" placeholder="FollowUp Date" value="<?php echo date('Y-m-d'); ?>" id="followup_date" >
                  <div class="text-danger" id="error_followup_date" ></div>
                </div>
                <div class="col-lg-6 position-relative">
                  <label class="form-label">Next FollowUp Date</label>
                  <input class="form-control digits" type="date" placeholder="Next FollowUp Date"  value="" id="next_followup_date">
                  <div class="text-danger" id="error_next_followup_date" ></div>
                </div>
              </div>
              <div class="row mb-3">
                 <div class="col-lg-6 position-relative">
                  <label class="form-label">FollowUp Count</label>
                  <input class="form-control" type="text" data-bs-original-title="" placeholder="FollowUp Count"  value="1" readonly id="followup_count">
                </div>
                <div class="col-lg-6 position-relative">
                  <label class="form-label">Status</label>
                  <select class="form-select"  id="pn_status">
                    <option value="0">Select Status</option>
                    <option value="1">Positive</option>
                    <option value="2">Negative</option>
                  </select>
                  <div class="text-danger" id="error_pn_status" ></div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-lg-6 position-relative">
                  <label class="form-label">Remarks</label>
                  <textarea class="form-control" placeholder="Remarks" value="" id="followup_remark" rows="1"></textarea>
                  <div class="text-danger" id="error_followup_remark" ></div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="card-footer text-end">
                <input class="form-control" type="hidden" data-bs-original-title=""  readonly id="lead_id">
                <input class="form-control" type="hidden" data-bs-original-title=""  readonly id="followup_id">
                  <p class="btn btn-secondary" data-bs-dismiss="modal" type="reset" data-bs-original-title="" title="">Cancel</p>
                  <p class="btn btn-primary"  data-bs-original-title="" title="" onclick="comp_followup();">Submit</p>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div> -->
  <div class="modal fade" id="lead_followup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Follow Up Completion</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="form wizard">
          <div class="modal-content">
            <div class="modal-body">
              <br>
              <h5 style="text-align: center;">Are you sure you want to Completed this Followup.</h5><br>
              <!-- <div class="mb-3">
                <p class="col-form-label" style="text-align: center !important;">Are you sure you want to Completed this Followup.</p>
              </div> -->
            </div>
            <div class="card-footer text-center mb-3">
              <input type='hidden' value="" id="follow_up_id" />
              <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
              <button class="btn btn-primary" type="button" data-bs-dismiss="modal" id="completed">Yes, Completed</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="followup_completed" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <br>
          <h5 style="text-align: center;"> Followup Completed</h5><br>
          <div class="mb-3">
            <p class="col-form-label" style="text-align: center !important;">Are you sure you want to Completed this Followup.</p>
          </div>
        </div>
        <div class="card-footer text-center mb-3">
          <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal" id="completed">Yes, delete</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="followup_history_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <br>
          <h5 style="text-align: center;">Delete ?</h5><br>
          <div class="mb-3">
            <p class="col-form-label" style="text-align: center !important;">Are you sure you want to delete this FollowUp.</p>
          </div>
        </div>
        <div class="card-footer text-center mb-3">
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Yes, delete</button>
          <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
        </div>
      </div>
    </div>
  </div>
  
  
  @include('api.api_followup')
  <script>
    var today = new Date();
    // var from_date = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
    // var to_date = today.toISOString().split('T')[0];
    // document.getElementById('from_date').value = from_date;
    // document.getElementById('to_date').value = to_date;
  </script>
  <script>
    // $("#followup_history_lists").kendoTooltip({
    //   filter: "td",
    //   show: function(e){
    //     if(this.content.text() !=""){
    //       $('[role="tooltip"]').css("visibility", "visible");
    //     }
    //   },
    //   hide: function(){
    //     $('[role="tooltip"]').css("visibility", "hidden");
    //   },
    //   content: function(e){
    //     var element = e.target[0];
    //     if(element.offsetWidth < element.scrollWidth){
    //       return e.target.text();
    //     }else{
    //       return "";
    //     }
    //   }
    // })
  </script>
  <script>
    // $("#followup_history_lists").DataTable({
    //     // "ordering": false,
    //     "responsive": true,
    //     "aaSorting":[],
    //      "language": {
    //       "lengthMenu": "Show _MENU_",
    //      },
    //      "dom":
    //       "<'row'" +
    //       "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
    //       "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
    //       ">" +

    //       "<'table-responsive'tr>" +

    //       "<'row'" +
    //       "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
    //       "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
    //       ">"
    //     });
  </script>

  <!-- login js-->
  <!-- Plugin used-->
</body>

</html>
@endsection


