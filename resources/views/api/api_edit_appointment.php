<script>
     var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
    var id=<?php if(isset($_GET['ap_id'])) echo $_GET['ap_id']; else echo ""?>;

        
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_appointment/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
        if(data.status == '200'){
           
           
           
            if(data.data[0].user_status == 'Lead' ){

                
            
                getuserall(1,data.data[0].user_id);
               
            }else{
             
                getuserall(0,data.data[0].user_id);
                
            }
            
            

           
            document.getElementById("app_date").value = data.data[0].date;

         
            document.getElementById("timepicker").value=data.data[0].time;
            document.getElementById("app_problem").value=data.data[0].problem;
      
            document.getElementById("app_remark").value=data.data[0].remark;
            document.getElementById("app_staff_name").value=data.data[0].staff_name;
            
           
        
            var cus_tc_box = document.getElementById("cus_tc_box");
            var cus_treatment_box = document.getElementById("cus_treatment_box");
            var lead_problem_box = document.getElementById("lead_problem_box");

            if(data.data[0].tc_name) {
                
                document.getElementById("is_customer").value = 0;
                cus_tc_box.style.display = "block";
                cus_treatment_box.style.display = "block";
                lead_problem_box.style.display = "none";
                gettcall(data.data[0].tc_id);
                gettreatmentall(data.data[0].tc_id,data.data[0].treatment_id);
            }else{
                document.getElementById("is_customer").value = 1;
                cus_tc_box.style.display = "none";
                cus_treatment_box.style.display = "none";
                lead_problem_box.style.display = "block";
            } 
            
            
           

            

                      
        }
    });

    function update_appointment() {

        var  user_id   = document.getElementById("app_user_name").value;
        var date   = document.getElementById("app_date").value;
        var time   = document.getElementById("timepicker").value;
        var problem   = document.getElementById("app_problem").value;
        var app_remark = document.getElementById("app_remark").value;  
        var tc_id   = document.getElementById("app_cus_tc").value;
        var treatment_id   = document.getElementById("app_cus_treatment").value;
        var is_customer = document.getElementById("is_customer").value;
        var app_staff_name = document.getElementById("app_staff_name").value;
        if(user_id){

            document.getElementById('upd_app').style.pointerEvents = 'none';

            var data = "company_name="+sessionStorage.getItem('company')+"&is_customer="+is_customer+"&user_id="+user_id+"&app_problem="+problem+"&app_tc_id="+tc_id+"&app_treatment_id="+treatment_id+"&app_staff_name="+app_staff_name+"&app_remark="+app_remark+"&app_date="+date+"&app_time="+time;
               
            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_appointment/"+id+"?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('upd_app').style.pointerEvents = 'auto';
                if(data.status == '200'){

                    

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Appointment Successfully Updated!</div>");
                    
                    setTimeout(() => { $("#status_success").html("");window.location.href = "./appointment";document.getElementById('upd_app').style.pointerEvents = 'none';}, 4000);  
                    
                    

                }else{
                $("#error_treatment_name").html(data.error_msg.lead_name[0]);
                
                }
            });
        }

    }


    
    function getuserall(value,id){

      
      
        const token = sessionStorage.getItem('token');
       
        if(value == '1'){
            fetch(base_url+"lead/0", {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                
                if(data.status == '200'){

                    if(data.data)   {
                            
                        const value = data.data;
                        var htmlString = "";

                        function sel_status(values){
                            if(values == id){ return 'selected';}else{ return '';}
                        }
                    

                        var htmlhead ="<option value='0'>Select Lead name</option>";

                        for(var i = 0; i < value.length  ; i++){

                            if(value[i].status == '0'){

                                htmlString += "<option value='"+value[i].lead_id+"'"+sel_status(value[i].lead_id)+">"+ value[i].lead_first_name + "</option>";
                            }
                        }
                            
                        var htmlstringall = htmlhead+htmlString;
                        $("#app_user_name").html(htmlstringall);
                                    
                    }
                }
            });
        }else{

            fetch(base_url+"customer/0", {
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

                        function sel_status(values){
                            if(values == id){ return 'selected';}else{ return '';}
                        }
                                

                        var htmlhead ="<option value='0'>Select customer name</option>";

                        for(var i = 0; i < value.length  ; i++){
                            if(value[i].status == '0'){
                               
                               htmlString += "<option value='"+value[i].customer_id+"'"+sel_status(value[i].customer_id)+">"+ value[i].customer_first_name + "</option>";
                            }
                        }
                            
                        var htmlstringall = htmlhead+htmlString;
                        $("#app_user_name").html(htmlstringall);
                                    
                    }
                }
            });
        } 
    }

    function gettcall(id){

        const token = sessionStorage.getItem('token');

        fetch(base_url+"treatment_cat", {
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

                    var htmlhead ="<label class='form-label'>Categories</label><select class='form-select' id='tc_name'><option value=''>Select Categories</option>";

                    for(var i = 0; i < value.length  ; i++){

                        function sel_status(value){
                            if(value == id){ return 'selected';}else{ return '';}
                        }

                        htmlString += "<option value="+"'"+value[i].tcategory_id+"'"+sel_status(value[i].tcategory_id)+">"+ value[i].tc_name + "</option>"
                
                    }

                    var htmlfooter ="</select><div class='text-danger' id='error_tc_name'></div>";
                    
                    var htmlstringall = htmlhead+htmlString+htmlfooter;
                    $("#app_cus_tc").html(htmlstringall);

                

                    
                                
                }
            

            }
        });
    }


    function gettreatmentall(tc_id,id){

        const token = sessionStorage.getItem('token');

        fetch(base_url+"treatment?tc_id="+tc_id, {
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

                        var htmlhead ="<option value='0'>Select Treatment</option>";

                        for(var i = 0; i < value.length  ; i++){

                            function sel_status(value){
                                if(value == id){ return 'selected';}else{ return '';}
                            }
                                    
                            if(value[i].status == '0'){
                                htmlString += "<option value='"+value[i].treatment_id+"'"+sel_status(value[i].treatment_id)+">"+ value[i].treatment_name + "</option>";
                            }
                        }
                            
                        var htmlstringall = htmlhead+htmlString;
                        $("#app_cus_treatment").html(htmlstringall);
                                            
                    }
                    
                }
            });
    }

}
</script>
