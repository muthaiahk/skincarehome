<script>
     var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
       var base_url = window.location.origin+'/api/';
    var id=<?php if(isset($_GET['pc_id'])) echo $_GET['pc_id']; else echo ""?>;

    
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_product_category/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
        if(data.status == '200'){

            document.getElementById("product_cat_name").value = data.data[0].prod_cat_name;
       

                        
        }
    });

    
    
    function update_product_category() {

        var product_cat_name    = document.getElementById("product_cat_name").value;
     
        if(!product_cat_name){

            $("#error_product_cat_name").html("Please fill the input feilds");

        }else{
            $("#error_product_cat_name").html("");
        } 

        

        if(product_cat_name){

            document.getElementById('upd_product_category').style.pointerEvents = 'none';

            var data = "prod_cat_name="+product_cat_name;



            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_product_category/"+id+"?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {
              
                if(data.status == '200'){

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Product Category Successfully Updated!</div>");
                    
                   // setTimeout(() => { $("#status_success").html("");}, 2000);
                    
                    setTimeout(() => {$("#status_success").html(""); window.location.href = "./product_category";}, 4000);
                    
                    

                }else{
                    $("#error_product_cat_name").html(data.error_msg.prod_cat_name[0]);
                    document.getElementById('upd_product_category').style.pointerEvents = 'auto';
                }
            });
        }
    }

    }
</script>
