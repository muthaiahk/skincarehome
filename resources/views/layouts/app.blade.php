<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/logo/renew_3.png') }}" type="image/x-icon" id="fav_icon1">
    <link rel="shortcut icon" href="{{ asset('assets/logo/renew_3.png') }}" type="image/x-icon" id="fav_icon2">
    <title>Renew+::CRM</title>
    
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fonts_googleapis.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fonts_googleapis_1.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/chartist.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2022.2.621/styles/kendo.default-v2.min.css"/>
    
    <script>
      var base_url = window.location.origin + '/api/';
      var url = window.location.origin + '/renew_api/';
    </script>
    @yield('head_scripts')
  </head>
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

    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      <div class="page-header">
        <div class="header-wrapper row m-0">
          <form class="form-inline search-full col" action="#" method="get">
            <div class="form-group w-100">
              <div class="Typeahead Typeahead--twitterUsers">
                <div class="u-posRelative">
                  <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Cuba .." name="q" title="" autofocus>
                  <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
                </div>
                <div class="Typeahead-menu"></div>
              </div>
            </div>
          </form>
          <div class="header-logo-wrapper col-4 p-0">
            <div class="logo-wrapper"><a href="{{ url('dashboard') }}"><img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt=""></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i></div>
          </div>
          <div class="nav-right col-8 pull-right right-header p-0">
            <ul>
              <li class="onhover-dropdown">
                  <div class="notification-box" ><i data-feather="bell"> </i>
                    <span class="badge rounded-pill badge-primary" id='notify_count'>0</span>
                  </div>
                  <div class="onhover-show-div notification-dropdown " style="overflow: auto; max-height: 400px;" id='notify_list'>
                  </div>
              </li>
              <li class="onhover-dropdown p-0 me-0">
                <div class="media profile-media"><img class="b-r-10" style="width:50px;height:50px;" src="{{ asset('assets/images/dashboard/22626.png') }}" id="profile_pic" alt="">
                  <div class="media-body" id="h_username"><span></span>
                    <p class="mb-0 font-roboto" id="h_rolename"><i class="middle fa fa-angle-down"></i></p>
                  </div>
                </div>
                <ul class="profile-dropdown onhover-show-div">
                  <li><a href="{{ url('user_profile') }}"><i data-feather="user"></i><span>Account </span></a></li>
                  <li><a onclick="logout();"><i data-feather="log-in" > </i><span>Logout</span></a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Page Header Ends-->

      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="sidebar-wrapper" >
            <div>
            <div class="logo-wrapper" >
              <a href="{{ url('dashboard') }}">
                <img class="img-fluid for-light" src="{{ asset('assets/logo/renew_1.png') }}" width="75" id="c_logo">
              </a>
              <div class="back-btn"><i class="fa fa-angle-left"></i></div>
              <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
            </div>
            <div class="logo-icon-wrapper">
              <a href="{{ url('dashboard') }}">
                <img class="img-fluid" src="{{ asset('assets/logo/renew_3.png') }}" width="60" id="c_logo_icon">
              </a>
            </div>
            <nav class="sidebar-main">
              <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
              <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                  <li class="back-btn"><a href="{{ url('dashboard') }}"><img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a>
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                  </li>
                  <li id='dashboard_page' class="sidebar-list"><a class="sidebar-link " href="{{ url('dashboard') }}">
                  <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512">
                     <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
                  </svg>
                  <span >Dashboard</span></a>
                  </li>

                  <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:;">
                  <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512">
                     <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/>
                  </svg>
                  <span>Lead management</span></a>
                    <ul class="sidebar-submenu">
                      <li id='lead_page'><a href="{{ url('lead') }}">Lead</a></li>
                      <li id='followup_page'><a href="{{ url('followup') }}">Followup</a></li>
                    </ul>
                  </li>

                  <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:;">
                  <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512">
                    <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM609.3 512H471.4c5.4-9.4 8.6-20.3 8.6-32v-8c0-60.7-27.1-115.2-69.8-151.8c2.4-.1 4.7-.2 7.1-.2h61.4C567.8 320 640 392.2 640 481.3c0 17-13.8 30.7-30.7 30.7zM432 256c-31 0-59-12.6-79.3-32.9C372.4 196.5 384 163.6 384 128c0-26.8-6.6-52.1-18.3-74.3C384.3 40.1 407.2 32 432 32c61.9 0 112 50.1 112 112s-50.1 112-112 112z"/>
                  </svg>
                  <span>Customer management</span></a>
                    <ul class="sidebar-submenu">
                      <li id='customer_page'><a href="{{ url('customer') }}">Customers</a></li>
                      <li id='customer_treatment_page'><a href="{{ url('treatment_management') }}">Customer Treatments</a></li>
                    </ul>
                  </li>
                  
                  <li class="sidebar-list" id='appointment_page'>
                    <a class="sidebar-link" href="{{ url('appointment') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512">
                      <path d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM305 273L177 401c-9.4 9.4-24.6 9.4-33.9 0L79 337c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L271 239c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                    </svg>
                    <span>Appointment</span></a>
                  </li>

                  <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:;">
                  <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                     <path d="M326.7 403.7c-22.1 8-45.9 12.3-70.7 12.3s-48.7-4.4-70.7-12.3c-.3-.1-.5-.2-.8-.3c-30-11-56.8-28.7-78.6-51.4C70 314.6 48 263.9 48 208C48 93.1 141.1 0 256 0S464 93.1 464 208c0 55.9-22 106.6-57.9 144c-1 1-2 2.1-3 3.1c-21.4 21.4-47.4 38.1-76.3 48.6zM256 84c-11 0-20 9-20 20v14c-7.6 1.7-15.2 4.4-22.2 8.5c-13.9 8.3-25.9 22.8-25.8 43.9c.1 20.3 12 33.1 24.7 40.7c11 6.6 24.7 10.8 35.6 14l1.7 .5c12.6 3.8 21.8 6.8 28 10.7c5.1 3.2 5.8 5.4 5.9 8.2c.1 5-1.8 8-5.9 10.5c-5 3.1-12.9 5-21.4 4.7c-11.1-.4-21.5-3.9-35.1-8.5c-2.3-.8-4.7-1.6-7.2-2.4c-10.5-3.5-21.8 2.2-25.3 12.6s2.2 21.8 12.6 25.3c1.9 .6 4 1.3 6.1 2.1l0 0 0 0c8.3 2.9 17.9 6.2 28.2 8.4V312c0 11 9 20 20 20s20-9 20-20V298.2c8-1.7 16-4.5 23.2-9c14.3-8.9 25.1-24.1 24.8-45c-.3-20.3-11.7-33.4-24.6-41.6c-11.5-7.2-25.9-11.6-37.1-15l-.7-.2c-12.8-3.9-21.9-6.7-28.3-10.5c-5.2-3.1-5.3-4.9-5.3-6.7c0-3.7 1.4-6.5 6.2-9.3c5.4-3.2 13.6-5.1 21.5-5c9.6 .1 20.2 2.2 31.2 5.2c10.7 2.8 21.6-3.5 24.5-14.2s-3.5-21.6-14.2-24.5c-6.5-1.7-13.7-3.4-21.1-4.7V104c0-11-9-20-20-20zM48 352H64c19.5 25.9 44 47.7 72.2 64H64v32H256 448V416H375.8c28.2-16.3 52.8-38.1 72.2-64h16c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V400c0-26.5 21.5-48 48-48z"/>
                  </svg>
                  <span>Sales </span></a>
                    <ul class="sidebar-submenu">
                      <li id='billing_page'><a href="{{ url('billing') }}">Billing</a></li>
                      <li id='customer_payment_page'><a href="{{ url('payment') }}">Receipt</a></li>
                    </ul>
                  </li>

                  <li class="sidebar-list" id='inventory_page'><a class="sidebar-link" href="{{ url('inventory') }}">
                  <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512">
                    <path d="M64 144c0-26.5 21.5-48 48-48s48 21.5 48 48V256H64V144zM0 144V368c0 61.9 50.1 112 112 112s112-50.1 112-112V189.6c1.8 19.1 8.2 38 19.8 54.8L372.3 431.7c35.5 51.7 105.3 64.3 156 28.1s63-107.5 27.5-159.2L427.3 113.3C391.8 61.5 321.9 49 271.3 85.2c-28 20-44.3 50.8-47.3 83V144c0-61.9-50.1-112-112-112S0 82.1 0 144zm296.6 64.2c-16-23.3-10-55.3 11.9-71c21.2-15.1 50.5-10.3 66 12.2l67 97.6L361.6 303l-65-94.8zM491 407.7c-.8 .6-1.6 1.1-2.4 1.6l4-2.8c-.5 .4-1 .8-1.6 1.2z"/>
                  </svg>
                  <span>Inventory</span></a>
                  </li>

                  <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:;">
                  <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512">
                    <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM625 177L497 305c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L591 143c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                  </svg>
                  <span>HR management</span></a>
                    <ul class="sidebar-submenu">
                      <li id='staff_page'><a href="{{ url('staff') }}">Staff</a></li>
                      <li id='attendance_page'><a href="{{ url('attendance') }}">Attendance</a></li>
                    </ul>
                  </li>

                  <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:;">
                  <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512">
                     <path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                  </svg>
                  <span>Report</span></a>
                    <ul class="sidebar-submenu">
                      <li id="lead_rpt_page"><a href="{{ url('report_lead') }}">Lead Report</a></li>
                      <li id="appointment_rpt_page"><a href="{{ url('report_app') }}">Appointment Report</a></li>
                      <li id="stock_rpt_page"><a href="{{ url('report_stock') }}">Stock Report</a></li>
                      <li id="attendance_rpt_page"><a href="{{ url('report_atd') }}">Attendance Report</a></li>
                      <li id="payment_rpt_page"><a href="{{ url('report_pay') }}">Payment Report</a></li>
                    </ul>
                  </li>
                  
                  <li class="sidebar-list" id='settings_page'><a class="sidebar-link sidebar-title" href="javascript:;">
                  <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                     <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
                  </svg>
                  <span>Settings</span></a>
                    <ul class="sidebar-submenu">
                      <li id='general_setting_page'><a href="{{ url('general') }}">General Settings</a></li>
                      <li id='email_setting_page'><a href="{{ url('email') }}">Email Configuration</a></li>
                      <li id='company_page'><a href="{{ url('company') }}">Company</a></li>
                      <li id='branch_page'><a href="{{ url('branch') }}">Branch</a></li>
                      <li id='department_page'><a href="{{ url('department') }}">Department</a></li>
                      <li id='designation_page'><a href="{{ url('designation') }}">Designation</a></li>
                      <li id='brand_page'><a href="{{ url('brand') }}">Brand</a></li>
                      <li id='lead_source_page'><a href="{{ url('lead_source') }}">Lead Source</a></li>
                      <li id='lead_status_page'><a href="{{ url('lead_status') }}">Lead Status</a></li>
                      <li id='product_category_page'><a href="{{ url('product_category') }}">Product Category</a></li>
                      <li id='product_page'><a href="{{ url('product') }}">Product</a></li>
                      <li id='treatment_category_page'><a href="{{ url('t_category') }}">Treatment Category</a></li>
                      <li id='treatment_page'><a href="{{ url('treatment') }}">Treatment</a></li>
                      <li id='role_page'><a href="{{ url('role_permission') }}">Role</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </nav>
            </div>
        </div>
        <!-- Page Sidebar Ends-->

        <div class="page-body">
          @yield('content')
        </div>

        <footer class="footer">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-12 footer-copyright text-center">
                    <p class="mb-0">{{ date("Y") }} &copy; Renew+</p>
                  </div>
               </div>
            </div>
        </footer>
      </div>
    </div> <!-- page-wrapper Ends -->

    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    
    <script src="{{ asset('assets/js/typeahead/handlebars.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/typeahead.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/typeahead.custom.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead-search/handlebars.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead-search/typeahead-custom.js') }}"></script>

    <!-- Theme js-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/own_js/kendo.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    
    <script>
        function logout() {
            sessionStorage.clear();
            window.location.href = "{{ url('/') }}";
        }

        // Header Script Logic
        generall();
        function generall(){
          var a = sessionStorage.getItem('token');
          if(!a){
              window.location.href = "{{ url('/') }}";
          }else{
              const token = sessionStorage.getItem('token');
              fetch(base_url+"general", {
                      headers: {
                          "Content-Type": "application/x-www-form-urlencoded",
                          'Authorization': `Bearer ${token}`,
                      },
                      method: "get",
              })
              .then((response) => response.json())
              .then((data) => {
                  if(data.status == '200'){
                      var value = data.data[0];
                      if(document.getElementById("default_pic")) document.getElementById("default_pic").src = value.default_pic;
                      if(document.getElementById("c_logo")) document.getElementById("c_logo").src = value.logo;
                      if(document.getElementById("c_logo_icon")) document.getElementById("c_logo_icon").src = value.logo;
                      if(document.getElementById("fav_icon1")) document.getElementById("fav_icon1").href = value.favicon;
                      if(document.getElementById("fav_icon2")) document.getElementById("fav_icon2").href = value.favicon;
                  }
              });
          }
        }

        notification();
        function notification() {
            var a = sessionStorage.getItem('token');
            if (!a) {
                return;
            }
            const token = sessionStorage.getItem('token');
            fetch(base_url + "notification", {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        if (data.data) {
                            const value = data.data;
                            var htmlString = "";
                            var htmlhead = "<h6 class='f-18 mb-0 dropdown-title'>Notifications</h6><ul>";
                            for (var i = 0; i < value.length; i++) {
                                const duration = (start_time) => {
                                    var st = moment(start_time).toISOString();
                                    var ed = moment().toISOString();
                                    var a = moment(ed);
                                    var b = moment(st);
                                    var time_elapsed = a.diff(b, 'seconds');
                                    var seconds = time_elapsed;
                                    var minutes = Math.round(time_elapsed / 60);
                                    var hours = Math.round(time_elapsed / 3600);
                                    var days = Math.round(time_elapsed / 86400);
                                    if (seconds <= 60) return "just now";
                                    else if (minutes <= 60) return minutes == 1 ? "1 min ago" : minutes + " mins ago";
                                    else if (hours <= 24) return hours == 1 ? "1 hr ago" : hours + " hrs ago";
                                    else return days == 1 ? "yesterday" : days + " days ago";
                                }
                                var created_at_duration = duration(value[i].created_at);
                                htmlString += "<li class='b-l-primary border-4'><p>" + value[i].content + ".</p><span class='font-danger'>" + created_at_duration + "</span></p><input type='hidden' id='notify_id' value='"+value[i].notify_id+"'></li>";
                            }
                            var htmlfooter = "<h6 class='f-18  mb-0 dropdown-footer' style='position: sticky; bottom: 0; background-color: #fff;'><div class='row'><div class='col-6' id='clear' style='cursor:pointer;'><i class='fa fa-trash' aria-hidden='true' style='color: red;'></i>Clear</div><div class='col-6 mt-2' id='check_all'><a href='{{ url('notification_view') }}'>Check all</a></div></div></h6></ul>";
                            $("#notify_list").html(htmlhead + htmlString + htmlfooter);
                        }
                        $('#notify_count').html(data.count);
                        if (data.count > 99) $('#notify_count').html(data.count + '<sup>+</sup>');
                        if (data.count == 0) $('#notify_count').hide();
                      
                        $('#clear').on('click', function() {
                            fetch(base_url + "notification_clear", {
                                headers: { "Content-Type": "application/x-www-form-urlencoded", 'Authorization': `Bearer ${token}` },
                                method: "get",
                            })
                            .then((response) => response.json())
                            .then((data) => {
                                if (data.status == '200') notification(); 
                            });
                        });
                    }
                });
        }

        // Sidebar Script Logic
        var id = sessionStorage.getItem('role');
        var token = sessionStorage.getItem('token');
        if(id && token) {
          fetch(base_url + "role_permission_view/" + id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`
                },
                method: "get",
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 200) {
                    let permissions = data.data;
                    if (permissions && permissions.length > 0) {
                      permissions.forEach(item => {
                          let permission = item.permission;
                          let page = item.page;
                          if (!permission) {
                              if(document.getElementById(`${page}_page`)) document.getElementById(`${page}_page`).style.display = "none";
                              return;
                          }
                          if (page === "settings" && permission) {
                              try {
                                  let settingsPermissions = JSON.parse(permission);
                                  for (let i = 0; i < settingsPermissions.length; i++) {
                                      let settingName = settingsPermissions[i].name;
                                      let settingPerms = settingsPermissions[i].permission || [];
                                      let settingPageElement = document.getElementById(`${settingName}_page`);
                                      if (settingPageElement) {
                                          settingPageElement.style.display = settingPerms.includes("list") ? "block" : "none";
                                      }
                                  }
                              } catch (e) {
                                  console.error("Failed to parse settings permissions:", e);
                              }
                          } else {
                              let hasComma = permission && permission.includes(',');
                              if (hasComma) {
                                  if (permission.split(",").includes("list")) {
                                      if(document.getElementById(`${page}_page`)) document.getElementById(`${page}_page`).style.display = "block";
                                  } else {
                                      if(document.getElementById(`${page}_page`)) document.getElementById(`${page}_page`).style.display = "none";
                                  }
                              }
                          }
                      });
                  }
                }
            });

            // Report Perms
            const report_pages = ['lead_rpt', 'appointment_rpt', 'stock_rpt', 'attendance_rpt', 'payment_rpt'];
            report_pages.forEach(name => {
              fetch(base_url+"role_permission_page/"+name, {
                  headers: { "Content-Type": "application/x-www-form-urlencoded", 'Authorization': `Bearer ${token}` },
                  method: "get",
              })
              .then(res => res.json())
              .then(data => {
                  if(data.status == '200' && data.data.permission) {
                      let el = document.getElementById(name + "_page");
                      if(el) el.style.display = 'block';
                  }
              });
            });
        }
    </script>
    @yield('scripts')
  </body>
</html>
