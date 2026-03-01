<script>
     var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
    var id=<?php if(isset($_GET['ls_id'])) echo $_GET['ls_id']; else echo ""?>;

    
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_lead_status/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
        if(data.status == '200'){

            document.getElementById("lead_status_name").value = data.data[0].lead_status_name;
       

                        
        }
    });

    
    
    function update_lead_status() {

        var lead_status_name    = document.getElementById("lead_status_name").value;
     
        if(!lead_status_name){

            $("#error_lead_status_name").html("Please fill the input feilds");

        }else{
            $("#error_lead_status_name").html("");
        } 

        

        if(lead_status_name){

            
            document.getElementById('upd_lead_status').style.pointerEvents = 'none';

            var data = "lead_status_name="+lead_status_name;



            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_lead_status/"+id+"?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {
                  
            

                if(data.status == '200'){

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Lead Source Successfully Updated!</div>");
                    
                   // setTimeout(() => { $("#status_success").html("");}, 2000);
                    
                    setTimeout(() => { $("#status_success").html("");window.location.href = "./lead_status";}, 4000);
                    
                    

                }else{
                    document.getElementById('upd_lead_status').style.pointerEvents = 'auto';
                }
            });
        }
    }

    }
</script>
