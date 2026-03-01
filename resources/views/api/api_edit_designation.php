<script>

var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
    
        var base_url = window.location.origin+'/api/';
    var id=<?php if(isset($_GET['ds_id'])) echo $_GET['ds_id']; else echo ""?>;

    
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_designation/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
        if(data.status == '200'){

            document.getElementById("company_name").value = data.data[0].company_name;
            document.getElementById("designation").value = data.data[0].designation;
            document.getElementById("description").value = data.data[0].description;
         

                        
        }
    });

    
    
    function update_designation() {

        var company_name    = document.getElementById("company_name").value;
        var designation     = document.getElementById("designation").value;
        var description     = document.getElementById("description").value;
     

        if(!company_name){

            $("#error_company_name").html("Please fill the input feilds");

        }else{
            $("#error_company_name").html("");
        } 

        if(!designation){
            $("#error_designation").html("Please fill the  input feilds");
        }
        else{
            $("#error_designation").html("");
        }

        // if(!description){
        //     $("#error_description").html("Please fill the  input feilds");

        // }
        // else{

        //     $("#error_description").html("");
        // }




        if(company_name && designation ){

            document.getElementById('upd_desig').style.pointerEvents = 'none';

            var data = "company_name="+company_name+"&designation="+designation+"&description="+description;



            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_designation/"+id+"?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {

                
                
                if(data.status == '200'){

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Designation Successfully Added!</div>");
                    
                    setTimeout(() => { $("#status_success").html("");window.location.href = "./designation"; document.getElementById('update_desig').style.pointerEvents = 'none';}, 4000); 

                    document.getElementById('upd_desig').style.pointerEvents = 'auto';
                    

                }
            });
        }
    }

    }
</script>
