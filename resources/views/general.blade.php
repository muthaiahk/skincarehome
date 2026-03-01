@extends('layouts.app')

@section('content')
<?php include "common.php"; ?>
<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
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
      <?php include "header.php"; ?>
      <!-- Page Header Ends-->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <?php include "sidebar.php"; ?>
        <!-- Page Sidebar Ends-->

        <div class="page-body">
            <div class="container-fluid">        
                <div class="page-title">
                  <div class="row">
                    <div class="col-6">
                      <h3>General Settings</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">General Settings</li>
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
                    <duv id="status_success"></div>                   
                    <div class="card-body">
                      <div class="row mb-3">
                          <div class="col-lg-4 position-relative avatar">
                            <label class="form-label">Logo</label>
                            <div class="image-input image-input-outline" id="logo">
                              <div class="image-input-wrapper"></div>
                                <label class="btn btn-xs btn-icon btn-circle btn-hover-text-primary btn-shadow">
                                  <input type="file" onchange="img_logo(this);" id="profile_avatar_logo" name="profile_avatar_logo" accept=".png, .jpg, .jpeg" style="display: none;"/>
                                  <input type="hidden" name="profile_avatar_logo_remove" /><br>
                                  <img class="img-100 b-r-8" id="logo_gs" src="assets/logo/blank.png" />
                                </label>
                            </div>
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Favicon</label>&nbsp;&nbsp;&nbsp;
                            <div class="image-input image-input-outline" id="fav">
                               <div class="image-input-wrapper"></div>
                               <label class="btn btn-xs btn-icon btn-circle btn-hover-text-primary btn-shadow">
                                  <input type="file" onchange="img_fav(this);" id="profile_avatar_fav" name="profile_avatar_fav" accept=".png, .jpg, .jpeg" style="display: none;"/>
                                  <input type="hidden" name="profile_avatar_fav_remove" /><br>
                                  <img class="img-100 b-r-8" id="fav_gs" src="assets/logo/blank.png" />
                                </label>
                            </div>
                            <div class="valid-tooltip"></div>
                          </div>                                                
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Default profile</label>&nbsp;&nbsp;&nbsp;
                            <div class="image-input image-input-outline" id="default_profile">
                               <div class="image-input-wrapper"></div>
                               <label class="btn btn-xs btn-icon btn-circle btn-hover-text-primary btn-shadow">
                                  <input type="file" onchange="img_default(this);" id="profile_avatar_default" name="profile_avatar_default" accept=".png, .jpg, .jpeg" style="display: none;"/>
                                  <input type="hidden" name="profile_avatar_default_remove" /><br>
                                  <img class="img-100 b-r-8" id="default_gs" src="assets/logo/blank.png" />
                                </label>
                            </div>
                            <div class="valid-tooltip"></div>
                          </div>
                        </div> 
                        <div class="row mb-3">
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Company Name</label>
                              <input class="form-control" type="Text" value="" placeholder="Company Name" required="" id="company_name">
                              <div class="valid-tooltip"></div>
                              </div>
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Date Format</label>                   
                              <select class="form-select" id="Select_date">
                                <option>YYYY/MM/DD</option>
                                <option>DD/MM/YYYY</option>
                                <option>MM/DD/YYYY</option>
                              </select>
                            </div>
                            <div class="col-lg-4 position-relative">
                              <label class="form-label">Time</label>                   
                              <select class="form-select" id="Select_time">
                               <option>Asia/Kolkata (UTC+05:30)</option>
                               <option>Atlantic/Azores (UTC-01:00)</option>
                               <option>Asia/Beirut (UTC+02:00)</option>
                              </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Mobile</label>
                            <input class="form-control" type="text" value="1234567890" placeholder="Mobile" required="" id="mobile">
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Company Website</label>
                            <input class="form-control" type="link"value="http://renewhairandskincare.com/" placeholder="Company Website" required="" id="website">
                            <div class="valid-tooltip"></div>
                          </div>
                          <!-- <div class="col-lg-4 position-relative">
                              <label class="form-label">Region</label>                   
                              <select class="form-select" id="Select_region">
                                <option>Northern</option>
                                <option>Eastern</option>
                                <option>Southern</option>
                                <option>Western</option>
                              </select>
                          </div> -->
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Openining Date</label>
                            <input class="form-control" type="date" placeholder="Password" required="" value="2022-10-12" id='opening_date'>
                            <div class="valid-tooltip"></div>
                          </div>
                        </div>
                        <div class="row mb-3">
                            <!-- <div class="col-lg-4 position-relative">
                            <label class="form-label">Language</label>
                            <select class="form-select" id="Select_language">
                                <option>English</option>
                            </select>
                            <div class="valid-tooltip"></div>
                          </div> -->
                          <!-- <div class="col-lg-4 position-relative">
                            <label class="form-label">Currency</label>
                             <select class="form-select" id="Select_currency">
                                <option>INR</option>
                            </select>
                            <div class="valid-tooltip"></div>
                          </div> -->
                          <!-- <div class="col-lg-4 position-relative">
                            <label class="form-label">Openining Date</label>
                            <input class="form-control" type="date" placeholder="Password" required="" value="2022-10-12" id='opening_date'>
                            <div class="valid-tooltip"></div>
                          </div> -->
                        </div>
                        <div class="row mb-3">
                          <div class="card-footer text-end">
                            <!-- <button class="btn btn-secondary" type="reset">Cancel</button> -->
                            <button class="btn btn-primary" type="button" onclick="upd_general();">Update</button>
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
        <?php include "footer.php"; ?>
        <!-- footer start-->
      </div>
    </div>
    <?php include "script.php"; ?>
    
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <script>
      var logo_img = "";
      var fav_img = "";
      var default_img = "";
      
      function img_logo(input) {
         var img = document.getElementById("profile_avatar_logo").value;
        if (img == "") 
        {
          document.getElementById("logo_gs").style.display = "none";
        }
        else
        {
          document.getElementById("logo_gs").style.display = "block";
          
          if (input.files && input.files[0]) {
            
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#logo_gs')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(100);
                };

                reader.readAsDataURL(input.files[0]);
                logo_img = input.files[0];

            }
            
        }
            
      };

        function img_fav(input) {
         var img_favicon = document.getElementById("profile_avatar_fav").value;
        if (img_favicon == "") 
        {
          document.getElementById("fav_gs").style.display = "none";
        }
        else
        {
          document.getElementById("fav_gs").style.display = "block";
          if (input.files && input.files[0]) {
            
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#fav_gs')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(100);
                };

                reader.readAsDataURL(input.files[0]);
                fav_img = input.files[0];
            }

            // var files = input.files[0].files;

           

            // alert(input.files[0])
            
        }
            
        };

        function img_default(input) {
         var img_def = document.getElementById("profile_avatar_default").value;
        if (img_def == "") 
        {
          document.getElementById("default_gs").style.display = "none";
        }
        else
        {
          document.getElementById("default_gs").style.display = "block";
          if (input.files && input.files[0]) {
            
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#default_gs')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(100);
                };

                reader.readAsDataURL(input.files[0]);
                default_img = input.files[0];
            }
            
        }
            
        };
    </script>
    @include('api.api_general')
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>
@endsection


