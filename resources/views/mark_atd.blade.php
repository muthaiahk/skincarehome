@extends('layouts.app')

@section('content')

<!-- <body onload="startTime()"> -->
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
                <h3>Staff Daily Attendance</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard">                                     
                    <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item"><a href="attendance">Attendance</a></li>
                    <!-- <li class="breadcrumb-item">Staff Daily Attendance</li>  -->                   
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
                            <div id="status_success"></div>
                            <div class="card-header">
                              <div class="row mt-2">
                                
                                <div class="col-lg-1 mt-2 ">
                                  <h6>
                                  &nbsp; <label class="form-label " for="formfield">Date : </label>
                                  </h6>
                                </div>
                                <div class="col-lg-4">
                               
                                    <h6>
                                      <input class="form-control" type='date'id="current_date" value="<?php echo date('Y-m-d'); ?>"/>
                                     
                                    </h6>
                                
                                </div> 
                                <div class="col-lg-2">
                               
                                </div>
                                <div class="col-lg-4 float-right text-end">
                                  <!-- <span class="float-right text-end">  -->
                                    <button class="btn btn-primary " type="button" data-bs-original-title="" title="" id='staff_count' onclick="add_attendance();">Mark Attendance</button>
                                    <!-- <button class="btn btn-primary" type="button" data-bs-original-title="" title="" id="mark_attendance_button" onclick="add_attendance()">Mark Attendance</button> -->
                                    <!-- </span>  -->
                                </div>
                                
                              </div>                
                            </div>
                            <div class="card-body" >
                              <div class="table-responsive" style="overflow-x:hidden;" >
                                <div id="attendance_add_list">
                               
                                </div>
                                <!-- <div class="card-footer text-end">
                                    <button class="btn btn-secondary" type="reset">Cancel</button>
                                    <button class="btn btn-primary" type="button" onclick="add_attendance()">Submit</button>
                                </div> -->
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
     <div class="modal fade" id="mark_attendance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Mark Attendance</h5>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form wizard">
              <div class="modal-body">
                <div class="row mb-3 m-t-15 custom-radio-ml">
                  <div class="col-lg-3  form-check radio radio-primary">
                    <input class="form-check-input" id="present" type="radio" name="radio" value='present' onclick='att_status();'>
                    <label class="form-check-label" for="present">Present</label>
                   
                  </div>
                  <div class="col-lg-3  form-check radio radio-primary">
                    <input class="form-check-input" id="permission" type="radio" name="radio" value='permission' onclick='att_status();'>
                    <label class="form-check-label" for="permission">Permission</label>
                  </div>
                  <div class="col-lg-2 m-l-5 form-check radio radio-primary">
                    <input class="form-check-input" id="leave" type="radio" name="radio" value='leave' onclick='att_status();'>
                    <label class="form-check-label" for="leave">Leave</label>
                  </div>
                  <div class="col-lg-2 m-l-5 form-check radio radio-primary">
                    <input class="form-check-input" id="weekoff" type="radio" name="radio" value='Weekoff' onclick='att_status();'>
                    <label class="form-check-label" for="weekoff">Weekoff</label>
                  </div>
                </div>

                <div class="row mb-3 m-t-15 custom-radio-ml" id="att_remarks" style='display:none'>
                  <div class="col-lg-6 position-relative">
                    <label class="form-label">Remarks</label>
                    <textarea class="form-control" placeholder="Remarks" id="leave_remarks"  rows="2"></textarea>
                    <div class="valid-tooltip"></div>
                  </div>
                </div>
                <div class="text-danger" id="error_attendance"></div>
                <!-- <div class="row mb-3">
                  <div class="card-footer text-end">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="reset" data-bs-original-title="" title="">Cancel</button>
                    <button class="btn btn-primary" type="button" data-bs-original-title="" title="" onclick="add_attendance()">Submit</button>
                  </div>
                </div> -->
              </div>
            </form>
          </div>
        </div>
      </div>
    
    @include('api.api_attendance')
    
    <!-- login js-->
    <!-- Plugin used-->
    <script>
    
        
    </script>
    <script>
    // function att_status()
    // {
    //   var att_leave= document.getElementById("att_leave").value;
    //   var att_leave2= document.getElementById("att_leave2").value;
      

    //   var att_remarks = document.getElementById("att_remarks");
    //   var att_remarks2 = document.getElementById("att_remarks2");
      
      

    //   if (att_leave == "leave")
    //   {
    //     att_remarks.style.display = "block";       
    //   } else 
    //   {
    //     att_remarks.style.display = "none";        
    //   }
    //   if (att_leave2 == "leave2")
    //   {
    //     att_remarks2.style.display = "block";       
    //   } else 
    //   {
    //     att_remarks2.style.display = "none";        
    //   }
      
    // };

    function att_status()
    {
      
      var att_leave= document.getElementById("leave").checked;
 
      var att_remarks2 = document.getElementById("att_remarks");
       
       if(att_leave)
       {
        att_remarks2.style.display = "block";       
       } else 
       {
         att_remarks2.style.display = "none";        
       }
      
    }


   
    </script>
    
     
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


