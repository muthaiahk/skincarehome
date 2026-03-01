<script>

var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{

        var base_url = window.location.origin+'/api/';
    var id=<?php if(isset($_GET['in_id'])) echo $_GET['in_id']; else echo ""?>;

    
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_inventory/"+id, {
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
            getbrandall(data.data[0].brand_id);
            getproductcatall(data.data[0].prod_cat_id);
            getproductall(data.data[0].product_id);
            document.getElementById("inventory_date").value = data.data[0].inventory_date;
            document.getElementById("stock_in_hand").value = data.data[0].stock_in_hand;
            document.getElementById("stock_alert_count").value = data.data[0].stock_alert_count;
            document.getElementById("description").value = data.data[0].description; 
            document.getElementById("company_name").value = data.data[0].company_name;
            document.getElementById("branch_name").value = data.data[0].branch_name;
            document.getElementById("brand_name").value = data.data[0].brand_name;
            document.getElementById("prod_cat_name").value = data.data[0].prod_cat_name;
            document.getElementById("product_name").value = data.data[0].product_name;


    
            

      
        }
    });

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
                            $("#inventory_branch_list").html(htmlstringall);

                            datatable();

                            
                                        
                        }
                    

                    }
                });
    }


    function getbrandall(id){

        const token = sessionStorage.getItem('token');

        fetch(base_url+"brand", {
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

                            var htmlhead ="<label class='form-label'>Brand Name</label><select class='form-select' id='brand_name'><option value='0'>Select Brand Name</option>";

                            for(var i = 0; i < value.length  ; i++){
                                

                                function sel_status(value){
                                    if(value == id){ return 'selected';}else{ return '';}
                                }
                                
                                if(value[i].status == '0'){
                                    htmlString += "<option value='"+value[i].brand_id+"'"+sel_status(value[i].brand_id)+">"+ value[i].brand_name + "</option>";
                                }

                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_brand_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#inventory_brand_list").html(htmlstringall);

                            datatable();

                            
                                        
                        }
                    

                    }
                });
    }
      function getproductcatall(id){

        const token = sessionStorage.getItem('token');

        fetch(base_url+"product_category", {
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

                            var htmlhead ="<label class='form-label'>Product Categories</label><select class='form-select' id='prod_cat_name'><option value='0'>Select Product Categories</option>";

                            for(var i = 0; i < value.length  ; i++){

                                function sel_status(value){
                                    if(value == id){ return 'selected';}else{ return '';}
                                }
                                
                                if(value[i].status == '0'){
                                    htmlString += "<option value='"+value[i].prod_cat_id+"'"+sel_status(value[i].prod_cat_id)+">"+ value[i].prod_cat_name + "</option>";

                                }
                         
                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_prod_cat_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#inventory_prod_cat_list").html(htmlstringall);

                            datatable();

                            
                                        
                        }
                    

                    }
                });
    }
     function getproductall(id){

        const token = sessionStorage.getItem('token');

        fetch(base_url+"product", {
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

                            var htmlhead ="<label class='form-label'>Product Name</label><select class='form-select' id='product_name'><option value='0'>Select Product Name</option>";

                            for(var i = 0; i < value.length  ; i++){

                                function sel_status(value){
                                    if(value == id){ return 'selected';}else{ return '';}
                                }

                                if(value[i].status == '0'){

                                    htmlString += "<option value='"+value[i].product_id+"'"+sel_status(value[i].product_id)+">"+ value[i].product_name + "</option>";
                                }
                                
                         
                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_product_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#inventory_product_list").html(htmlstringall);

                            datatable();

                            
                                        
                        }
                    

                    }
                });
    }

    
    
function update_inventory() {

    var inventory_date = document.getElementById("inventory_date").value;  
    var company_name = document.getElementById("company_name").value;
    var branch_id     = document.getElementById("branch_name").value;
    var brand_id  = document.getElementById("brand_name").value;
    var prod_cat_id = document.getElementById("prod_cat_name").value;
    var product_id = document.getElementById("product_name").value;
    var stock_in_hand = document.getElementById("stock_in_hand").value;
    var stock_alert_count = document.getElementById("stock_alert_count").value;
    var description = document.getElementById("description").value;
    
    

    
    if(!inventory_date){

        $("#error_inventory_date").html("Please select Date");

    }else{
        $("#error_inventory_date").html("");
    }
     
    if(company_name == '0'){

        $("#error_company_name").html("Please fill the  input feilds");

    }else{
        $("#error_company_name").html("");
    } 

    if(branch_id == '0'){

        $("#error_branch_name").html("Please select Branch name");

    }else{
        $("#error_branch_name").html("");
    } 
    if(brand_id == '0'){

        $("#error_brand_name").html("Please select Brand name");

    }else{
        $("#error_brand_name").html("");
    } 
    if(prod_cat_id == '0'){

        $("#error_prod_cat_name").html("Please select Product Category");

    }else{
        $("#error_prod_cat_name").html("");
    } 
    if(product_id == '0'){

        $("#error_product_name").html("Please select Product name");

    }else{
        $("#error_product_name").html("");
    } 
    
    if(!stock_in_hand){

        $("#error_stock_in_hand").html("Please fill the  input feilds");

    }else{
        $("#error_stock_in_hand").html("");
    } 
    if(!stock_alert_count){

        $("#error_stock_alert_count").html("Please fill the  input feilds");

    }else{
        $("#error_stock_alert_count").html("");
    } 
    if(!description){

        $("#error_description").html("Please fill the  input feilds");

    }else{
        $("#error_description").html("");
    } 
    


    if(inventory_date&&company_name&&branch_id&&brand_id&&prod_cat_id&&product_id&&stock_in_hand&&stock_alert_count&&description){
        document.getElementById('update_int').style.pointerEvents = 'none';

        var data = "inventory_date="+inventory_date+"&company_name="+company_name+"&branch_id="+branch_id+"&brand_id="+brand_id+"&prod_cat_id="+prod_cat_id+"&product_id="+product_id+"&stock_in_hand="+stock_in_hand+"&stock_alert_count="+stock_alert_count+"&description="+description;

            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_inventory/"+id+"?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('update_int').style.pointerEvents = 'auto';
                if(data.status == '200'){

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Inventory Successfully Updated!</div>");
                    
                    
                    setTimeout(() => {$("#status_success").html(""); window.location.href = "./inventory"; document.getElementById('update_int').style.pointerEvents = 'none';}, 4000);
                    
                    

                }
            });
        }
    }

   
}


</script>
