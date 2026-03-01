<script>
    addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            login();
        }
    });

  //  var base_url = window.location.origin+'/api/';
   var base_url = 'http://192.168.30.6/muthaiah/Client-Project/Renew-hair-skin-care/api/';

   // alert(base_url);
    function login() {
        const loginButton = document.getElementById("loginButton");
        const buttonText = loginButton.querySelector(".button-text");
        const spinner = loginButton.querySelector(".spinner-border");
        const loginError = document.getElementById("login_error");

        // Show loading spinner and disable the button
        buttonText.textContent = "Loading...";
        spinner.style.display = "inline-block";
        loginButton.disabled = true;

        // Collect username and password
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var data = "username=" + username + "&password=" + password;

	var base_url2 ='http://192.168.30.6/muthaiah/Client-Project/Renew-hair-skin-care/api/';

	//	alert(base_url2);

        fetch(base_url2 + "login?" + data, {
            headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            },
            method: "post",
        })
            .then((response) => response.json())
            .then((data) => {
            if (data.status == "200") {
                // Save session and local storage data
                sessionStorage.setItem("username", data.data.username);
                sessionStorage.setItem("role", data.data.role);
                sessionStorage.setItem("staff_id", data.data.staff_id);
                sessionStorage.setItem("token", data.data.token);
                sessionStorage.setItem("company", data.data.company_name);
                sessionStorage.setItem("branch_id", data.data.branch_id);
                sessionStorage.setItem("date_format", "hi");

                localStorage.setItem("username", data.data.username);
                localStorage.setItem("role", data.data.role);
                localStorage.setItem("staff_id", data.data.staff_id);
                localStorage.setItem("token", data.data.token);
                localStorage.setItem("company", data.data.company_name);
                localStorage.setItem("date_format", "hi");
                localStorage.setItem("branch_id", data.data.branch_id);

                loginError.innerHTML = ""; // Clear any previous error
                window.location.href = "./dashboard"; // Redirect to dashboard
            } else {
                loginError.innerHTML = "Invalid credential";
            }
            })
            .catch((error) => {
            loginError.innerHTML = "An error occurred. Please try again.";
            console.error("Error:", error);
            })
            .finally(() => {
            // Reset button to original state
            buttonText.textContent = "Sign in";
            spinner.style.display = "none";
            loginButton.disabled = false;
            });
    }

    const token = sessionStorage.getItem('token');
    
    function logout(){
        fetch(base_url+"logout", {
            headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "post",
        })
            .then((response) => response.json())
            .then((data) => {
               
                // if(data.status == '200'){
                    
                    sessionStorage.setItem("username","");
                    sessionStorage.setItem("role", "");
                    sessionStorage.setItem("staff_id", "");
                    sessionStorage.setItem("token", "");
                    sessionStorage.setItem("company", "");
                    sessionStorage.setItem("branch_id", "");

                    localStorage.setItem("username","");
                    localStorage.setItem("role", "");
                    localStorage.setItem("staff_id", "");
                    localStorage.setItem("token", "");
                    localStorage.setItem("company", "");
                    localStorage.setItem("branch_id", "");
                    window.location.href = "./index";

                // }
                
            });
    }


 

    function generall(){

        var a = sessionStorage.getItem('token');
        if(!a){
            window.location.href = "./index";
        }else{
            const token = sessionStorage.getItem('token');
        
            fetch(base_url+"general", {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                    
                if(data.status == '200'){
                            
                    //   console.log(data.data);
                    var value = data.data[0];

                  
                    document.getElementById("default_pic").src = value.default_pic;
                    document.getElementById("c_logo").src = value.logo;
                    document.getElementById("fav_icon1").href = value.favicon;
                    document.getElementById("fav_icon2").href = value.favicon;

                   

                }
            });
        }
    }

    function Userprofile(){

        var a = sessionStorage.getItem('token');
        if(!a){
            window.location.href = "./index";
        }else{
            const token = sessionStorage.getItem('token');

            fetch(base_url+"user_profile/"+id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                    
                if(data.status == '200'){
                            
                    //   console.log(data.data);
                    var value = data.data[0];

                
                    document.getElementById("profile_pic").src = value.profile_pic;
                

                }
            });
        }
    }
    var monthNames = [
    "January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December"
    ];
    var dayOfWeekNames = [
    "Sunday", "Monday", "Tuesday",
    "Wednesday", "Thursday", "Friday", "Saturday"
    ];
    function formatDate(date, patternStr){
        if (!patternStr) {
            patternStr = 'M/d/yyyy';
        }
        var day = date.getDate(),
            month = date.getMonth(),
            year = date.getFullYear(),
            hour = date.getHours(),
            minute = date.getMinutes(),
            second = date.getSeconds(),
            miliseconds = date.getMilliseconds(),
            h = hour % 12,
            hh = twoDigitPad(h),
            HH = twoDigitPad(hour),
            mm = twoDigitPad(minute),
            ss = twoDigitPad(second),
            aaa = hour < 12 ? 'AM' : 'PM',
            EEEE = dayOfWeekNames[date.getDay()],
            EEE = EEEE.substr(0, 3),
            dd = twoDigitPad(day),
            M = month + 1,
            MM = twoDigitPad(M),
            MMMM = monthNames[month],
            MMM = MMMM.substr(0, 3),
            yyyy = year + "",
            yy = yyyy.substr(2, 2)
        ;
        // checks to see if month name will be used
        patternStr = patternStr
        .replace('hh', hh).replace('h', h)
        .replace('HH', HH).replace('H', hour)
        .replace('mm', mm).replace('m', minute)
        .replace('ss', ss).replace('s', second)
        .replace('S', miliseconds)
        .replace('dd', dd).replace('d', day)
        
        .replace('EEEE', EEEE).replace('EEE', EEE)
        .replace('yyyy', yyyy)
        .replace('yy', yy)
        .replace('aaa', aaa);
        if (patternStr.indexOf('MMM') > -1) {
            patternStr = patternStr
            .replace('MMMM', MMMM)
            .replace('MMM', MMM);
        }
        else {
            patternStr = patternStr
            .replace('MM', MM)
            .replace('M', M);
        }
        return patternStr;
    }
    function twoDigitPad(num) {
        return num < 10 ? "0" + num : num;
    }




    var base_url = window.location.origin+'/api/';
        
    var id = sessionStorage.getItem('role');
   

    fetch(base_url+"role_permission_view/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
            if(data.status == '200'){

                var permissions = data.data;


                //  alert(permissions);
                var length = permissions.length;
                // alert(length)
                permissions.map((data)=>{
                   
                    var permission = data.permission;
                    var page       = data.page;
                    //  alert(data.permission)
                    // console.log(data.page)
                    // alert(page)
                    if(page == "settings"){
                        // alert("uhuyhb")
                    }else{
                            
                            // alert(permission)
                        if(permission){
                            // alert(permission)
                            // alert("uhuyhb")
                            // console.log(permission)
                            var cama=stringHasTheWhiteSpaceOrNot(permission);
                            // alert(cama)
                           // var values = permission.split(",");
                       
                            if(cama){
                                
                                // alert(permission)
                                var values = permission.split(",");
                                
                                var list = values.includes('list');
                             
                                if(list == false ){
                                $("#" + page + "_page").hide();
                        
                                }
                                    
                            }else{
                                
                               //  console.log(permission)
                                if(permission !== 'list'){
                                    $("#" + page + "_page").hide();
                                // document.getElementById(page+"_page").style.display = "none";
                                }
                                

                            }
                        }else{
                         document.getElementById(page+"_page").style.display = "none";
                        
                        }
                    }

                   
                })
               
            }

            function stringHasTheWhiteSpaceOrNot(value){
               
                if(value){
                    return value.indexOf(',') >= 0;
                }
            }


    });

        // if(sessionStorage.getItem('role') >2){
        //     $('#branch_name').prop('disabled', true);
        //     $('.form-select').css('background-image', '');
            
        // }
      
        

        
</script>

