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
                <h3>Company Lists</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard">                                       
                    <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Company Lists</li>
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
                <!-- <div class="card-header text-end">
                    <a href="add_dpt.php" type="button" class="btn btn-primary" type="submit" data-bs-original-title="">Add Department</a>
                </div>  -->                 
                  <div class="card-body">
                    <div class="table-responsive product-table"  id="company_list">
                      <!-- <table class="display" id="company_list">
                        <thead>
                          <tr>                           
                            <th class="min-w-125px cy">Company Name</th>
                            <th class="min-w-125px cy" style="width: 10%;">Status</th>
                            <th class="min-w-125px cy" style="width: 10%;">Action</th>
                          </tr>
                        </thead>

                        <tbody id="company_list_body"> -->
                          <!-- <tr>                           
                            <td>Renew+ Hair and Skin Care</td>
                            <td  class="media-body switch-sm">
                              <label class="switch">
                              <input type="checkbox" checked=""><span class="switch-state"></span>
                              </label>
                            </td>
                            <td>
                              <a href="edit_company.php"><i class="fa fa-edit eyc"></i></a>
                            </td>
                          </tr> -->
                        <!-- </tbody>
                      </table> -->
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
    <!-- <div class="modal fade" id="department_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Yes, delete</button>
          </div>
        </div>
      </div>
    </div> -->
    
    <!-- login js-->
    <!-- Plugin used-->
    <script>
        // function deleteRow(r) {
        // var i = r.parentNode.parentNode.rowIndex;
        // document.getElementById("myTable").deleteRow(i);
        // }
        // $("#company_list").DataTable({
        //   // "ordering": false,
        //   "responsive": true,
        //   "aaSorting":[],
        //    "language": {
        //     "lengthMenu": "Show _MENU_",
        //    },
        //    // dom: 'Bfrtip',
        //    "dom":
        //     "<'row'" +
        //     "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
        //     "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
        //     ">" +

        //     "<'table-responsive'tr>" +

        //     "<'row'" +
        //     "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        //     "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        //     ">"
        //   });
    </script>
    
    @include('api.api_company')
     
    <!-- // (function($) {
    // "use strict";
    // $("#advance-1").jsGrid({
    //     width: "100%",
    //     filtering: true,
    //     editing: true,
    //     inserting: true,
    //     sorting: true,
    //     paging: true,
    //     autoload: true,
    //     pageSize: 15,
    //     pageButtonCount: 5,
    //     deleteConfirm: "Do you really want to delete the client?",
    //     controller: db,
    //     fields: [
    //     { name: "Name", type: "text", width: 150 },
    //     { name: "Age", type: "number", width: 50 },
    //     { name: "Address", type: "text", width: 200 },
    //     { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
    //     { name: "Married", type: "checkbox", title: "Is Married", sorting: false },
    //     { type: "control" }
    //     ]
    // }); -->
   
  </body>
  </html>
@endsection


