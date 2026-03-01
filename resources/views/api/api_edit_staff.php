<script>

var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
    var id=<?php if(isset($_GET['st_id'])) echo $_GET['st_id']; else echo ""?>;

        
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_staff/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                

        if(data.status == '200'){
            
            getroleall(data.data[0].role_id);
            getbranchall(data.data[0].branch_id);
            getdeprtmentall(data.data[0].department_id);
            getdesgall(data.data[0].designation_id);
            getgenderall(data.data[0].gender);
            document.getElementById("staff_name").value = data.data[0].name;
            document.getElementById("staff_dob").value = data.data[0].date_of_birth;
            document.getElementById("staff_gender").value = data.data[0].gender;
            document.getElementById("staff_email").value = data.data[0].email;
            document.getElementById("staff_phone").value = data.data[0].phone_no;
            document.getElementById("staff_emg_phone").value = data.data[0].emergency_contact;
            document.getElementById("staff_address").value = data.data[0].address;
            document.getElementById("role_name").value = data.data[0].role_name;
            document.getElementById("staff_doj").value = data.data[0].date_of_joining;
            document.getElementById("company_name").value = 'Renewhairandskincare';
            
            document.getElementById("branch_name").value = data.data[0].branch_name;
            document.getElementById("department_name").value = data.data[0].department_name;
            document.getElementById("designation_name").value = data.data[0].designation_name;  
            document.getElementById("username").value = data.data[0].username;
            document.getElementById("password").value = data.data[0].password;      

                      
        }
    });


 fetch(base_url+"view_staff/"+id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                    

            if(data.status == '200'){
                
                getroleall(data.data[0].role_id);
                getbranchall(data.data[0].branch_id);
                getdeprtmentall(data.data[0].department_id);
                getdesgall(data.data[0].designation_id);
                getgenderall(data.data[0].gender);
                document.getElementById("staff_name_v").value = data.data[0].name;
                document.getElementById("staff_dob_v").value = data.data[0].date_of_birth;
                document.getElementById("staff_gender_v").value = data.data[0].gender;
                document.getElementById("staff_email_v").value = data.data[0].email;
                document.getElementById("staff_phone_v").value = data.data[0].phone_no;
                document.getElementById("staff_emg_phone_v").value = data.data[0].emergency_contact;
                document.getElementById("staff_address_v").value = data.data[0].address;
                document.getElementById("role_name_v").value = data.data[0].role_name;
                document.getElementById("staff_doj_v").value = data.data[0].date_of_joining;
                document.getElementById("company_name_v").value = 'Renewhairandskincare';
                
                document.getElementById("branch_name_v").value = data.data[0].branch_name;
                document.getElementById("department_name_v").value = data.data[0].department_name;
                document.getElementById("designation_name_v").value = data.data[0].designation_name;  
                document.getElementById("username_v").value = data.data[0].username;
                document.getElementById("password_v").value = data.data[0].password;      

                        
            }
        });
    function update_staff() {

       
        var staff_name = document.getElementById("staff_name").value;
        var staff_dob = document.getElementById("staff_dob").value;
        var staff_gender = document.getElementById("staff_gender").value;
        var staff_email = document.getElementById("staff_email").value;
        var staff_phone = document.getElementById("staff_phone").value;
        var staff_emg_phone = document.getElementById("staff_emg_phone").value;
        var staff_address = document.getElementById("staff_address").value;
        var role_id = document.getElementById("role_name").value;
        var staff_doj = document.getElementById("staff_doj").value;
        var company_name   = document.getElementById("company_name").value;
        var branch_id = Array.from(document.getElementById("branch_name").selectedOptions).map(option => parseInt(option.value));
        var department_id = document.getElementById("department_name").value;
        var designation_id = document.getElementById("designation_name").value;
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
     
        var branchIdString = JSON.stringify(branch_id);

        if(!staff_name){

            $("#error_staff_name").html("Please fill the input fields");

        }else{
            $("#error_staff_name").html("");
        } 


        if(!staff_dob){

            $("#error_staff_dob").html("Please fill the input fields");

        }else{
            $("#error_staff_dob").html("");
        } 
        
        if(staff_gender == '0'){

            $("#error_staff_gender").html("Please select gender name");

        }else{
            $("#error_staff_gender").html("");
        } 

        
        if(!staff_email){

            $("#error_staff_email").html("Please fill the input fields");

        }else{
            $("#error_staff_email").html("");
        } 


        if(staff_phone.length <= 9){

            $("#error_staff_phone").html("Please fill the input fields");

        }else{
            $("#error_staff_phone").html("");
        }

        if(staff_emg_phone.length <= 9){

            $("#error_staff_emg_phone").html("Please fill the input fields");

        }else{
            $("#error_staff_emg_phone").html("");
        } 

        if(!staff_address){

            $("#error_staff_address").html("Please fill the input fields");

        }else{
            $("#error_staff_address").html("");
        } 

        if(role_id == '0'){

            $("#error_role_name").html("Please select staff role name");

        }else{
            $("#error_role_name").html("");
        } 

        if(!staff_dob){

            $("#error_staff_dob").html("Please fill the input fields");

        }else{
            $("#error_staff_dob").html("");
        } 

        if(branchIdString == '0'){

            $("#error_branch_name").html("Please select branch name");

        }else{
            $("#error_branch_name").html("");
        } 

        if(department_id == '0'){

            $("#error_department_name").html("Please select department name");

        }else{
            $("#error_department_name").html("");
        }
        
        // if(designation_id == '0'){

        //     $("#error_designation_name").html("Please select designation name");

        // }else{
        //     $("#error_designation_name").html("");
        // } 

        if(!username){

            $("#error_username").html("Please fill the input fields");

        }else{
            $("#error_username").html("");
        } 


        if(!password){

            $("#error_password").html("Please fill the input fields");

        }else{
            $("#error_password").html("");
        } 


       
        
        if(company_name && branchIdString && staff_name && staff_address && staff_phone && staff_emg_phone && staff_email && staff_dob && staff_doj && staff_gender && department_id && designation_id && role_id && username && password){
            document.getElementById('upd_staff').style.pointerEvents = 'none';
            var data = "company_name="+company_name+"&branch_id="+branchIdString+"&name="+staff_name+"&address="+staff_address+"&phone_no="+staff_phone+"&emergency_contact="+staff_emg_phone+"&email="+staff_email+"&date_of_birth="+staff_dob+"&date_of_joining="+staff_doj+"&gender="+staff_gender+"&dept_id="+department_id+"&desg_id="+designation_id+"&role_id="+role_id +"&username="+username +"&password="+password;
               
            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_staff/"+id+"?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {

               // document.getElementById('upd_staff').style.pointerEvents = 'auto';
                
                if(data.status == '200'){

                    

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Staff Successfully Updated!</div>");
                    
                    setTimeout(() => { $("#status_success").html("");window.location.href = "./staff"; }, 4000);  
                    
                    

                }else{
               
                
                }
            });
        }else{
            $("#status_success").html("<div class='alert alert-danger' role='alert'>Please check input feils !</div>");
                    
                    setTimeout(() => { $("#status_success").html(""); document.getElementById('upd_staff').style.pointerEvents = 'none';}, 4000);  
                    
        }

    }

    function getgenderall(value){

        var  gender = ['male','female'];

        var htmlhead ="<option value='0'>Select Gender name</option>";
        var htmlString ="";

        for(var i = 0; i < gender.length  ; i++){


            function sel_status(values){
                if(values == value){ return 'selected';}else{ return '';}
            }
                    

            htmlString += "<option value='"+gender[i]+"'"+sel_status(gender[i])+">"+ gender[i]+ "</option>";

        }

        var htmlstringall = htmlhead+htmlString;
        $("#gender_name").html(htmlstringall);

   
            
    }

            // getroleall(data.data[0].role_id);
            // getbranchall(data.data[0].role_id);
            // getdeprtmentall(data.data[0].department_id);
            // getdesgall(data.data[0].designation_id);

    function getroleall(id){

        const token = sessionStorage.getItem('token');

        fetch(base_url+"role", {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
            
                if(data.status == '200'){

                    if(data.data){
                        
                        const value = data.data;
                        var htmlString = "";

                        var htmlhead ="<option value='0'>Select role name</option>";

                        for(var i = 0; i < value.length  ; i++){

                         
                            function sel_status(value){
                                if(value == id){ return 'selected';}else{ return '';}
                            }
                                    
                            if(value[i].status == '0'){
                                htmlString += "<option value='"+value[i].role_id+"'"+sel_status(value[i].role_id)+">"+ value[i].role_name + "</option>";
                            }
                    
                        }
                        
                        var htmlstringall = htmlhead+htmlString;
                        $("#role_name").html(htmlstringall);
                        
                                    
                    }
                

                }
            });
    }

    function getbranchall(branch_ids){

        const token = sessionStorage.getItem('token');

        fetch(base_url+"branch", {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
            
                if(data.status == '200'){

                    if(data.data){
                        
                        const value = data.data;
                        var htmlString = "";

                        var htmlhead ="<option value='0'>Select Branch</option>";

                        for(var i = 0; i < value.length  ; i++){

                            console.log(branch_ids)
                           

                            function sel_status(id){

                                console.log(jQuery.inArray(id,JSON.parse(branch_ids)))
                                // 
                                if(jQuery.inArray(id,JSON.parse(branch_ids))>=0){
                                    return 'selected';
                                }else{ return '';}
                                // if(in_value == id){ return 'selected';}else{ return '';}
                            }
                                    
                            if(value[i].status == '0'){
                                htmlString += "<option value='"+value[i].branch_id+"'"+sel_status(value[i].branch_id)+">"+ value[i].branch_name + "</option>";
                            }
                    
                        }
                        
                        var htmlstringall = htmlhead+htmlString;
                        $("#branch_name").html(htmlstringall);
                        
                        if(sessionStorage.getItem('role') != 1){
                                $('#branch_name').prop('disabled', true);
                                $('.form-select').css('background-image', '');
                                
                            }
                    }
                

                }
            });
    }
    function getdeprtmentall(id){

        const token = sessionStorage.getItem('token');

        fetch(base_url+"department", {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
            
                if(data.status == '200'){

                    if(data.data){
                        
                        const value = data.data;
                        var htmlString = "";

                        var htmlhead ="<option value='0'>Select department name</option>";

                        for(var i = 0; i < value.length  ; i++){

                         
                            function sel_status(value){
                                if(value == id){ return 'selected';}else{ return '';}
                            }
                            if(value[i].status == '0'){     

                                htmlString += "<option value='"+value[i].department_id+"'"+sel_status(value[i].department_id)+">"+ value[i].department_name + "</option>";
                            }
                    
                        }
                        
                        var htmlstringall = htmlhead+htmlString;
                        $("#department_name").html(htmlstringall);
                        
                                    
                    }
                

                }
            });
    }

    function getdesgall(id){

        const token = sessionStorage.getItem('token');

        fetch(base_url+"designation", {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
            
                if(data.status == '200'){

                    if(data.data){
                        
                        const value = data.data;
                        var htmlString = "";

                        var htmlhead ="<option value='0'>Select designation name</option>";

                        for(var i = 0; i < value.length  ; i++){

                        
                            function sel_status(value){
                                if(value == id){ return 'selected';}else{ return '';}
                            }
                            if(value[i].status == '0'){      

                                htmlString += "<option value='"+value[i].job_id+"'"+sel_status(value[i].job_id)+">"+ value[i].designation + "</option>";
                            }
                    
                        }
                        
                        var htmlstringall = htmlhead+htmlString;
                        $("#designation_name").html(htmlstringall);
                        
                                    
                    }
                

                }
            });
    }


    }
    
</script>
