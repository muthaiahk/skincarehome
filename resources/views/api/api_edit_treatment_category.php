<script>

var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{

    //branch drop down select

    var base_url = window.location.origin+'/api/';
    var id=<?php if(isset($_GET['tc_id'])) echo $_GET['tc_id']; else echo ""?>;

    
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_treatment_cat/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
        if(data.status == '200'){
            

            document.getElementById("treatment_cat_name").value = data.data[0].tc_name;
          
            
      
        }
    });

       
    
    function update_treatment_cat() {

    
        var treatment_cat_name = document.getElementById("treatment_cat_name").value;
    

     
        if(!treatment_cat_name){

            $("#error_treatment_cat_name").html("Please fill input feilds ");

        }else{
            $("#error_treatment_cat_name").html("");
        } 


        if(treatment_cat_name){

            document.getElementById('upd_treatmnt_category').style.pointerEvents = 'none';

            var data = "tc_name="+treatment_cat_name;

            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_treatment_cat/"+id+"?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {
                
                if(data.status == '200'){

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Category Successfully Updated!</div>");
                    
                    // setTimeout(() => { $("#status_success").html("");}, 2000);
                    
                    setTimeout(() => {$("#status_success").html(""); window.location.href = "./t_category";document.getElementById('upd_treatment_cat').style.pointerEvents = 'none';}, 4000);
                    
                    

                }else{
                    document.getElementById('upd_treatmnt_category').style.pointerEvents = 'auto';
                }
            });
        }
    }
}


</script>
