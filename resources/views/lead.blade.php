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
                <h3>Lead Lists</h3>
              </div>

              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard">
                      <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Lead Lists</li>
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
                  <div class="row card-header ">
                    <div class="col-md-3">
                      <div id="dashboard_branch_list">
                        <!-- <label class="form-label">Branch</label> -->
                        <select class="form-select" id="branch_name" onChange="selectbranch(event)">
                          <option value="0">All Branch</option>
                        </select>
                        <div class="invalid-feedback"></div>
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class=" text-end">
                        <a href="add_lead" type="button" class="btn btn-primary" type="submit" data-bs-original-title="" id="add_lead">Add Lead</a>
                      </div>
                    </div>


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
                  
                  <div id="loadingIndicator" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Loading data, please wait...</p>
                  </div>
                  
                  <div class="card-body table-responsive" id="lead_list">

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
  <div class="modal fade" id="lead_followup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Follow Up</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="form wizard">
          <div class="modal-body">
            <!-- <div class="row mb-3">
                <div class="col-lg-6 position-relative">
                  <label class="form-label">FollowUp Date</label>
                  <input class="form-control digits" type="date" placeholder="FollowUp Date" value="" id="followup_date" >
                  <div class="text-danger" id="error_followup_date" ></div>
                </div>
                <div class="col-lg-6 position-relative">
                  <label class="form-label">Next FollowUp Date</label>
                  <input class="form-control digits" type="date" placeholder="Next FollowUp Date"  value="" id="next_followup_date">
                  <div class="text-danger" id="error_next_followup_date" ></div>
                </div>
              </div> -->
            <div class="row mb-3">
              <div class="col-lg-6 position-relative">
                <label class="form-label">FollowUp Date</label>
                <input class="form-control digits" type="date" placeholder="FollowUp Date" value="" id="followup_date">
                <div class="text-danger" id="error_followup_date"></div>
              </div>
              <div class="col-lg-6 position-relative">
                <label class="form-label">Next FollowUp Date</label>
                <input class="form-control digits" type="date" placeholder="Next FollowUp Date" value="" id="next_followup_date">
                <div class="text-danger" id="error_next_followup_date"></div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-lg-6 position-relative">
                <label class="form-label">FollowUp Count</label>
                <input class="form-control" type="text" data-bs-original-title="" placeholder="FollowUp Count" value="1" readonly id="followup_count">
              </div>
              <div class="col-lg-6 position-relative">
                <label class="form-label">Status</label>
                <select class="form-select" id="pn_status">
                  <option value="0">Select Status</option>
                  <option value="1">Positive</option>
                  <option value="2">Negative</option>
                </select>
                <div class="text-danger" id="error_pn_status"></div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-lg-6 position-relative">
                <label class="form-label">Remarks</label>
                <textarea class="form-control" placeholder="Remarks" value="" id="followup_remark" rows="1"></textarea>
                <div class="text-danger" id="error_followup_remark"></div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="card-footer text-end">

                <p class="btn btn-secondary" data-bs-dismiss="modal" type="reset" data-bs-original-title="" title="">Cancel</p>
                <p class="btn btn-primary" data-bs-original-title="" title="" onclick="add_followup();">Submit</p>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="lead_followup_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">FollowUp History</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="form wizard">
          <div class="modal-body">
            <div class="row mb-3">
              <div class="col-lg-3 position-relative">
                <label class="form-label">From</label>
                <input class="form-control digits" type="date" placeholder="FollowUp Date" value="" id="from_date">
                <div class="text-danger" id="error_from_date"></div>
              </div>
              <div class="col-lg-3 position-relative">
                <label class="form-label">To</label>
                <input class="form-control digits" type="date" placeholder="Next FollowUp Date" value="" id="to_date">
                <div class="text-danger" id="error_to_date"></div>
              </div>
              <div class="col-lg-3 position-relative">
                <label class="form-label">Status</label>
                <select class="form-select" id="flw_pn_status">
                  <option value="0">All</option>
                  <option value="1">Positive</option>
                  <option value="2">Negative</option>
                </select>

              </div>
              <div class="col-lg-2">
                <button class="btn btn-primary report_mt-4" type="button" data-bs-original-title="" title="" onclick="filter_followup()">Go</button>
              </div>


            </div>
            <div id="followup_history_list"></div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="lead_to_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <br>
          <h5 style="text-align: center;">Lead to Customer</h5><br>
          <div class="mb-3">
            <p class="col-form-label" style="text-align: center !important;">Are you sure to convert us customer ?</p>
          </div>
        </div>
        <div class="card-footer text-center mb-3">
          <a href="#" type="button" class="btn btn-light" data-bs-dismiss="modal">No</a>
          <a href="#" type="button" class="btn btn-primary" id="convert">Yes</a>
          <!-- <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Yes</button>
            <button class="btn btn-light" type="button" data-bs-dismiss="modal">No</button> -->
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="lead_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <br>
          <h5 style="text-align: center;">Delete ?</h5><br>
          <div class="mb-3">
            <p class="col-form-label" style="text-align: center !important;">Are you sure you want to delete this Lead.</p>
          </div>
        </div>
        <div class="card-footer text-center mb-3">
          <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal" id="delete">Yes, delete</button>
        </div>
      </div>
    </div>
  </div>
  
  
  <script>
    $("#lead_lists").kendoTooltip({
      filter: "td",
      show: function(e) {
        if (this.content.text() != "") {
          $('[role="tooltip"]').css("visibility", "visible");
        }
      },
      hide: function() {
        $('[role="tooltip"]').css("visibility", "hidden");
      },
      content: function(e) {
        var element = e.target[0];
        if (element.offsetWidth < element.scrollWidth) {
          return e.target.text();
        } else {
          return "";
        }
      }
    })
  </script>
  <script>
    $(document).ready(function() {
      // Handle input change event for FollowUp Date
      $('#followup_date').on('change', function() {
        updateNextFollowUpDateMin();
        validateFollowUpDates();
      });

      // Handle input change event for Next FollowUp Date
      $('#next_followup_date').on('change', function() {
        validateFollowUpDates();
      });

      function updateNextFollowUpDateMin() {
        var followUpDate = $('#followup_date').val();
        var nextFollowUpDateInput = $('#next_followup_date');

        // Set the minimum allowed date for Next FollowUp Date
        nextFollowUpDateInput.attr('min', followUpDate);

        // Reset error message and enable the input field
        $('#error_next_followup_date').text('');
        nextFollowUpDateInput.prop('disabled', false);
      }

      function validateFollowUpDates() {
        var followUpDate = $('#followup_date').val();
        var nextFollowUpDate = $('#next_followup_date').val();
        var nextFollowUpDateInput = $('#next_followup_date');

        // Reset error message and enable the input field
        $('#error_next_followup_date').text('');
        nextFollowUpDateInput.prop('disabled', false);

        // Perform validation
        if (followUpDate && nextFollowUpDate) {
          if (followUpDate >= nextFollowUpDate) {
            $('#error_next_followup_date').text('Next FollowUp Date must be after FollowUp Date.');
            nextFollowUpDateInput.prop('disabled', true); // Disable the input field
          }
        }
      }
    });
  </script>
  <!-- <script>
          (function($) 
          {
              $('#basic-3').DataTable();
          })(jQuery);
    </script> -->
  <!-- login js-->
  <!-- Plugin used-->
  @include('api.api_lead')

</body>

</html>
@endsection



