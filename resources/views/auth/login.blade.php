<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/logo/renew_3.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/logo/renew_3.png') }}" type="image/x-icon">
    <title>Renew+::CRM Login</title>
    
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fonts_googleapis.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fonts_googleapis_1.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    
    <script>
      var base_url = window.location.origin + '/api/';
    </script>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-7">
          <img class="bg-img-cover bg-center" src="{{ asset('assets/logo/Login_Page_2.jpg') }}">
        </div>
        <div class="col-xl-5 p-0">
          <div class="login-card">
            <div>
              <div class="login-main"> 
                <form class="theme-form" onsubmit="event.preventDefault(); login();">
                  <h4>Login</h4>
                  <p>Enter your username & password to login</p>
                  <div class="form-group">
                    <label class="col-form-label">Username</label>
                    <input class="form-control" type="text" placeholder="Username" id="username">
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Password</label>
                    <div class="form-input position-relative">
                      <input class="form-control" type="password" name="p_word" placeholder="Password" id="password">
                      <div class="show-hide" onclick="show_password();" id="pass"><span class="show"></span></div>
                    </div>
                  </div>
                  <p class="text-danger" id="login_error"></p>
                  <div class="form-group mb-0">
                    <button id="loginButton" class="btn btn-primary btn-block w-100" type="submit">
                      <span class="button-text">Sign in</span>
                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                    </button>
                    <!-- BYPASS LOGIN FOR UI TESTING -->
                    <button type="button" class="btn btn-warning btn-block w-100 mt-2" onclick="bypass_login()">Bypass Login (Testing UI Flow)</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    
    <!-- Old API Script Integration -->
    <script>
      if(sessionStorage.getItem('token')){
          window.location.href = "{{ url('dashboard') }}";
      }

      function show_password(){
          var x = document.getElementById("password");
          if (x.type === "password") {
            x.type = "text";
          } else {
            x.type = "password";
          }
      }

      function login() {
          let user = document.getElementById("username").value;
          let ps = document.getElementById("password").value;

          if (user == "" || ps == "") {
              $("#login_error").html("Please fill Username and Password");
              return false;
          }

          var loginButton = document.getElementById('loginButton');
          var buttonText = loginButton.querySelector('.button-text');
          var spinner = loginButton.querySelector('.spinner-border');

          loginButton.disabled = true;
          buttonText.style.display = 'none';
          spinner.style.display = 'inline-block';

          let params = new URLSearchParams();
          params.append('phone', user);
          params.append('password', ps);

          fetch(base_url + "login", {
                  headers: {
                      "Content-Type": "application/x-www-form-urlencoded",
                  },
                  method: "post",
                  body: params
              })
              .then((response) => response.json())
              .then((data) => {
                  loginButton.disabled = false;
                  buttonText.style.display = 'inline-block';
                  spinner.style.display = 'none';

                  if (data.status == '200') {
                      sessionStorage.setItem("token", data.token);
                      sessionStorage.setItem("role", data.role_id);
                      window.location.href = "{{ url('dashboard') }}";
                  } else {
                      $("#login_error").html(data.error_msg);
                  }
              });
      }

      function bypass_login() {
          sessionStorage.setItem("token", "dummy-bypass-token-ui-test");
          sessionStorage.setItem("role", "1");
          sessionStorage.setItem("username", "Admin User");
          sessionStorage.setItem("branch_id", "[1]");
          sessionStorage.setItem("company", "Test Company");
          window.location.href = "{{ url('dashboard') }}";
      }
    </script>
  </body>
</html>
