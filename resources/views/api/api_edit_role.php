<script>

var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{

    //branch drop down select
  var base_url = window.location.origin+'/api/';
    
    var id=<?php if(isset($_GET['r_id'])) echo $_GET['r_id']; else echo ""?>;

    
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_role/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
        if(data.status == '200'){
            

            document.getElementById("role_name").value = data.data[0].role_name;
          
            
      
        }
    });

       
    
    function update_role() {

    
        var role_name = document.getElementById("role_name").value;
    

     
        if(!role_name){

            $("#error_role_name").html("Please fill input feilds ");

        }else{
            $("#error_role_name").html("");
        } 


        if(role_name){
            document.getElementById('upd_role').style.pointerEvents = 'none';


            var data = "role_name="+role_name;

            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_role/"+id+"?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {

                

                
                if(data.status == '200'){

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Role Successfully Updated!</div>");
                    
                    // setTimeout(() => { $("#status_success").html("");}, 2000);
                    
                    setTimeout(() => {$("#status_success").html(""); window.location.href = "./role_permission";document.getElementById('upd_role').style.pointerEvents = 'auto';}, 4000);
                    
                    

                }else{
                    
                  document.getElementById('upd_role').style.pointerEvents = 'auto';
                  
                   $("#status_success").html("<div class='alert alert-danger' role='alert'>"+data.message+"</div>");
                   
                   setTimeout(() => {$("#status_success").html("");}, 4000);
                  
                }
            });
        }
    }
    }

</script>
