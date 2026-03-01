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
                      <h3>User Profile</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <!-- <li class="breadcrumb-item"><a href="attendance">Attendance</a></li> -->
                        <!-- <li class="breadcrumb-item"><a href="edit_atd.php">Modify Attendance</a></li> -->
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
                  <div id="status_error"></div>
                    <!-- <div class="card-header">
                      <h5>Lead Lists</h5>
                    </div> -->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="row mb-3">
                                    <div class="col-lg-12 position-relative">
                                        <label class="form-label">Default profile</label>&nbsp;&nbsp;&nbsp;
                                        <div class="image-input image-input-outline" id="default_profile">
                                        <div class="image-input-wrapper"></div>
                                        <label class="btn btn-xs btn-icon btn-circle btn-hover-text-primary btn-shadow">
                                        <input type="file" onchange="img_default(this);" id="profile_avatar_default" name="profile_avatar_default" accept=".png, .jpg, .jpeg" style="display: none;"/>
                                            <input type="hidden" name="profile_avatar_default_remove" /><br>
                                            <img class="img-100 b-r-8" id="profile_pic" src="assets/logo/blank.png" />
                                            </label>
                                        </div>
                                        <div class="valid-tooltip"></div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-lg-8">
                                <div class="row mb-3">
                                    <div class="col-lg-6 position-relative">
                                        <label class="form-label">Name</label>
                                        <input class="form-control" type="text"  placeholder="Staff Name" Value="" id="staff_name" required="" >
                                    <div class="text-danger" id="error_user_name"></div>
                                    </div>
                                    <div class="col-lg-6 position-relative">
                                        <label class="form-label">Date Of Birth</label>
                                        <input class="form-control" type="date" id="staff_dob" placeholder="Phone No" readonly value="" >
                                    </div>
                                    <div class="col-lg-6 position-relative mt-2">
                                        <label class="form-label">Phone No</label>
                                        <input class="form-control" type="text" id="staff_phone" placeholder="Phone No" value="" >
                                     
                                    </div>
                                    <div class="col-lg-6 position-relative mt-2">
                                        <label class="form-label">Email</label>
                                        <input class="form-control" type="text" id="staff_email" placeholder="Email" value="" >
                                        
                                    </div>
                                    <div class="col-lg-12 position-relative mt-3">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control" placeholder="Address" required="" rows="2" id="staff_address"></textarea >
                                       
                                    </div>
                                   
                                </div> 
                            </div>
                            
                          
                        </div> 
                                   
                        <div class="row mb-3">
                          <div class="card-footer text-end">
                            <!-- <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./attendance'>Cancel</a></button> -->
                            <button class="btn btn-primary" type="button" data-bs-original-title="" title="" id="update_user" onclick="Update_user()">Submit</button>
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
    
    
    @include('api.api_user_profile')
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <!-- login js-->
    <!-- Plugin used-->
    <script>
      // var logo_img = "";
      // var fav_img = "";
      var profile_p = "";
      
      // function img_logo(input) {
      //    var img = document.getElementById("profile_avatar_logo").value;
      //   if (img == "") 
      //   {
      //     document.getElementById("logo_gs").style.display = "none";
      //   }
      //   else
      //   {
      //     document.getElementById("logo_gs").style.display = "block";
          
      //     if (input.files && input.files[0]) {
            
      //           var reader = new FileReader();

      //           reader.onload = function (e) {
      //               $('#logo_gs')
      //                   .attr('src', e.target.result)
      //                   .width(200)
      //                   .height(100);
      //           };

      //           reader.readAsDataURL(input.files[0]);
      //           logo_img = input.files[0];

      //       }
            
      //   }
            
      // };
      function img_default(input) {
         var profile = document.getElementById("profile_avatar_default").value;
        if (profile == "") 
        {
          document.getElementById("profile_pic").style.display = "none";
        }
        else
        {
          document.getElementById("profile_pic").style.display = "block";
          if (input.files && input.files[0]) {
            
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#profile_pic')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(100);
                };

                reader.readAsDataURL(input.files[0]);
                profile_p = input.files[0];
            }
            
        }
            
      };
    </script>
  
  </body>
</html>
@endsection


