<script>
     var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
    var id=<?php if(isset($_GET['lsr_id'])) echo $_GET['lsr_id']; else echo ""?>;

    
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_lead_source/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
        if(data.status == '200'){

            document.getElementById("lead_source_name").value = data.data[0].lead_source_name;
       

                        
        }
    });

    
    
    function update_lead_source() {

        var lead_source_name    = document.getElementById("lead_source_name").value;
     
        if(!lead_source_name){

            $("#error_lead_source_name").html("Please fill the input feilds");

        }else{
            $("#error_lead_source_name").html("");
        } 

        

        if(lead_source_name){

            document.getElementById('upd_lead_source').style.pointerEvents = 'none';

            var data = "lead_source_name="+lead_source_name;



            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_lead_source/"+id+"?"+data, {
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
                    
                    setTimeout(() => {$("#status_success").html(""); window.location.href = "./lead_source"; document.getElementById('update_l_source').style.pointerEvents = 'none';}, 4000);
                    
                    

                }else{
                    document.getElementById('upd_lead_source').style.pointerEvents = 'auto';
                }
            });
        }
    }

    }
</script>
