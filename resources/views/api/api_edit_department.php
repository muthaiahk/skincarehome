<script>

var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
    
       var base_url = window.location.origin+'/api/';
    var id=<?php if(isset($_GET['dp_id'])) echo $_GET['dp_id']; else echo ""?>;

    
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_department/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
        if(data.status == '200'){
             
             getbranchall(data.data[0].branch_id); 
             getstaff(data.data[0].dept_incharge);
             
             document.getElementById("department_name").value = data.data[0].department_name;
            // document.getElementById("dept_incharge").value = data.data[0].dept_incharge;
             document.getElementById("company_name").value = data.data[0].company_name;
                  
             
         // alert(data.data[0].branch_name)
            

            //document.getElementById("dept_incharge").value = data.data[0].name;
            document.getElementById("branch_name").value = data.data[0].branch_name;   
                        
        }
    });
    

    function getstaff(id){
       
      
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

                    var htmlhead ="<label class='form-label'>Department Incharge</label><select class='form-select' id='dept_incharge'><option value='0'>Select</option>";

                    for(var i = 0; i < value.length  ; i++){

                        function sel_status(value){
                                if(value == id){ return 'selected';}else{ return '';}
                            }
                        if(value[i].status == '0'){

                           
                            htmlString += "<option value='"+value[i].staff_id+"'"+sel_status(value[i].staff_id)+">"+ value[i].name + "</option>";
                        }
                    }
                    var htmlfooter ="</select><div class='text-danger' id='error_dept_incharge'></div>";  
                    var htmlstringall = htmlhead+htmlString+htmlfooter;
                    $("#staff_list").html(htmlstringall);
                                
                }
            }
        });
    
}
function getbranchall(id){

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

                            var htmlhead ="<label class='form-label'>Branch Name</label><select class='form-select' id='branch_name'><option value='0'>Select Branch</option>";

                            for(var i = 0; i < value.length  ; i++){
                                // var sel_status ="";

                                function sel_status(value){
                                    if(value == id){ return 'selected';}else{ return '';}
                                }
                                

                                if(value[i].status == '0'){
                                    htmlString += "<option value='"+value[i].branch_id+"'"+sel_status(value[i].branch_id)+">"+ value[i].branch_name + "</option>";
                                }      
                               


                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_branch_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#department_branch_list").html(htmlstringall);

                            datatable();

                            
                                        
                        }
                    

                    }
                });
    }
    
    
    function update_department() {
       

        var company_name    = document.getElementById("company_name").value;
        var branch_id       = document.getElementById("branch_name").value;
        var department_name      = document.getElementById("department_name").value;
        var dept_incharge        = "";
     

        if(!company_name){

            $("#error_company_name").html("Please fill the input feilds");

        }else{
            $("#error_company_name").html("");
        } 
        if(branch_id == '0'){
            $("#error_branch_name").html("Please select branch name");
        }
        else{
            $("#error_branch_name").html("");
        }

        if(!department_name){
            $("#error_department_name").html("Please fill the  input feilds");
        }
        else{
            $("#error_department_name").html("");
        }




           if (company_name,branch_id,department_name){ 
           
            document.getElementById('upd_depart').style.pointerEvents = 'none';

            var data = "company_name="+company_name+"&branch_id="+branch_id+"&department_name="+department_name+"&dept_incharge="+dept_incharge;



            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_department/"+id+"?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {
   

                if(data.status == '200'){

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Department Successfully Added!</div>");
                    
                    setTimeout(() => { $("#status_success").html(""); document.getElementById('update_dept').style.pointerEvents = 'none';}, 4000);  
                    
                    window.location.href = "./department";

                }else{
                    document.getElementById('upd_depart').style.pointerEvents = 'auto';
                }
            });
        }
    }

    }
</script>
