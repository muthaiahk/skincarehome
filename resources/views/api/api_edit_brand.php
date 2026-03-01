<script>
    
    var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{ 
       var base_url = window.location.origin+'/api/';
    var id=<?php if(isset($_GET['bd_id'])) echo $_GET['bd_id']; else echo ""?>;

    
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_brand/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
        if(data.status == '200'){

            document.getElementById("brand_name").value = data.data[0].brand_name;
       

                        
        }
    });

    
    
    function update_brand() {

        var brand_name    = document.getElementById("brand_name").value;
     
        if(!brand_name){

            $("#error_brand_name").html("Please fill the input feilds");

        }else{
            $("#error_brand_name").html("");
        } 

        

        if(brand_name){

            document.getElementById('upd_brand').style.pointerEvents = 'none';

            var data = "brand_name="+brand_name;


            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_brand/"+id+"?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {
                
                if(data.status == '200'){

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Brand Successfully Added!</div>");
                    
                    setTimeout(() => { $("#status_success").html(""); window.location.href = "./brand";}, 4000);  
                    
                   

                }else{
                    document.getElementById('upd_brand').style.pointerEvents = 'auto';
                }
            });
        }
    }

    }
</script>
