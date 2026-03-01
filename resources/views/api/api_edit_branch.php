<script>
        var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
       var base_url = window.location.origin+'/api/';
  
    var id=<?php if(isset($_GET['b_id'])) echo $_GET['b_id']; else echo ""?>;

    
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_branch/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
        if(data.status == '200'){

            if(data.data[0].is_franchise == '1'){
                //document.getElementById("franchise").checked;
                $("#franchise").prop('checked', true); 

            }

            document.getElementById("company_name").value = data.data[0].company_name;
            document.getElementById("branch_name").value = data.data[0].branch_name;
             document.getElementById("branch_code").value = data.data[0].branch_code;
            document.getElementById("opening_date").value = data.data[0].branch_opening_date;
           // document.getElementById("branch_authority").value = data.data[0].name;
            document.getElementById("branch_phone").value = data.data[0].branch_phone;
            document.getElementById("branch_location").value = data.data[0].branch_location;
            document.getElementById("branch_email").value = data.data[0].branch_email;
            document.getElementById("franchise").value = data.data[0].is_franchise;

            getauthority(data.data[0].branch_authority);

            document.getElementById("branch_authority").value = data.data[0].name;
                        
        }
    });

    function getauthority(id){
        
      
            const token = sessionStorage.getItem('token');
            fetch(base_url+"staff", {
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

                        var htmlhead ="<label class='form-label'>Branch Authority</label><select class='form-select' id='branch_authority'><option value='0'>Select</option>";

                        for(var i = 0; i < value.length  ; i++){

                            function sel_status(value){
                                    if(value == id){ return 'selected';}else{ return '';}
                                }
                            if(value[i].status == '0'){

                               
                                htmlString += "<option value='"+value[i].staff_id+"'"+sel_status(value[i].staff_id)+">"+ value[i].name + "</option>";
                            }
                        }
                        var htmlfooter ="</select><div class='text-danger' id='error_branch_authority'></div>";  
                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#staff_list").html(htmlstringall);
                                    
                    }
                }
            });
        
    }


    function checkbox(){

        if(event.target.checked){
            document.getElementById("franchise").value = "1";
        }else{
            document.getElementById("franchise").value = "0";
        }

    }
    
    
    function update_branch() {

        var company_name     = document.getElementById("company_name").value;
        var branch_name      = document.getElementById("branch_name").value;
        var branch_code      = document.getElementById("branch_code").value;
        var opening_date     = document.getElementById("opening_date").value;
        var branch_authority = document.getElementById("branch_authority").value;
        var branch_phone     = document.getElementById("branch_phone").value;
        var branch_location  = document.getElementById("branch_location").value;
        var branch_email     = document.getElementById("branch_email").value;
        var is_franchise     = document.getElementById("franchise").value;

        if(!company_name){

            $("#error_company_name").html("Please fill the input feilds");

        }else{
            $("#error_company_name").html("");
        } 

        if(!branch_name){
            $("#error_branch_name").html("Please fill the  input feilds");
        }
        else{
            $("#error_branch_name").html("");
        }

        if(!branch_code){
            $("#error_branch_code").html("Please fill the  input feilds");
        }
        else{
            $("#error_branch_code").html("");
        }
        if(!opening_date){
            $("#error_opening_date").html("Please fill the  input feilds");

        }
        else{

            $("#error_opening_date").html("");
        }

        if(!branch_authority){
            $("#error_branch_authority").html("Please fill the  input feilds");
            
        }
        else{
            $("#error_branch_authority").html("");
        }


        if(!branch_phone){
            $("#error_branch_phone").html("Please fill the  input feilds");

        }
        else{
            $("#error_branch_phone").html("");
        }

        if(!branch_location){
            $("#error_branch_location").html("Please fill the input feilds");

        }
        else{
            $("#error_branch_location").html("");
        }

        if(!branch_email){
            $("#error_branch_email").html("Please fill the input box");


        }else{
            $("#error_branch_email").html("");
        }


        if(company_name && branch_name && branch_code &&  opening_date && branch_authority && branch_phone && branch_location && branch_email && is_franchise){
           
            document.getElementById('upd_branch').style.pointerEvents = 'none';

            var data = "company_name="+company_name+"&branch_name="+branch_name+"&branch_code="+branch_code+"&branch_opening_date="+opening_date+"&branch_authority="+branch_authority+"&branch_phone="+branch_phone+"&branch_location="+branch_location+"&branch_email="+branch_email+"&is_franchise="+is_franchise;

            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_branch/"+id+"?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {
                
                if(data.status == '200'){


                    $("#status_success").html("<div class='alert alert-success' role='alert'>Branch Successfully Updated!</div>");
                    
                    setTimeout(() => { $("#status_success").html("");window.location.href = "./branch";}, 4000);  
                    
                    

                }else{
                    document.getElementById('upd_branch').style.pointerEvents = 'auto';
                }
            });
        }
    }
    }

</script>
