<script>


var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
    //branch drop down select
   var base_url = window.location.origin+'/api/';
    var base_urlimage = window.location.origin+'/new/renew_api/';
    var id=<?php if(isset($_GET['p_id'])) echo $_GET['p_id']; else echo ""?>;

    
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_product/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
        if(data.status == '200'){
            
            const imagePath = base_urlimage + "public/product_image/" + data.data[0].product_image; // Construct image path
            document.getElementById("product_image_view").src = imagePath; // Set image src
            // console.log("Image Path:", data.data[0].product_image);
            getbrandall(data.data[0].brand_id);
            getgstall(data.data[0].gst);
            getproductcatall(data.data[0].prod_cat_id);
            document.getElementById("product_name").value = data.data[0].product_name;
            document.getElementById("amount").value = data.data[0].amount;
            document.getElementById("brand_name").value = data.data[0].brand_name;
            document.getElementById("category_name").value = data.data[0].prod_cat_name;
            document.getElementById("gst").value = data.data[0].gst;
           // Display the product image
       

        }
    });

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

                            var htmlhead ="<label class='form-label'>Brand</label><select class='form-select' id='brand_name'><option value='0'>Select Brand</option>";

                            for(var i = 0; i < value.length  ; i++){
                                // var sel_status ="";

                                function sel_status(value){
                                    if(value == id){ return 'selected';}else{ return '';}
                                }
                                

                                htmlString += "<option value='"+value[i].brand_id+"'"+sel_status(value[i].brand_id)+">"+ value[i].brand_name + "</option>";
                               
                               


                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_brand_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#product_brand_list").html(htmlstringall);

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

                            var htmlhead ="<label class='form-label'>Categories</label><select class='form-select' id='prod_cat_name'><option value='0'>Select Categories</option>";

                            for(var i = 0; i < value.length  ; i++){

                                function sel_status(value){
                                    if(value == id){ return 'selected';}else{ return '';}
                                }
                                

                                htmlString += "<option value='"+value[i].prod_cat_id+"'"+sel_status(value[i].prod_cat_id)+">"+ value[i].prod_cat_name + "</option>";

                                // htmlString += "<option value="+value[i].prod_cat_id+">"+ value[i].prod_cat_name + "</option>"
                         
                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_prod_cat_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#prod_cat_list").html(htmlstringall);

                            datatable();

                            
                                        
                        }
                    

                    }
                });
    }

    function getgstall(val){

        $arr = [5,12,18,28];

        $option = "<option value='0' >Select</option>";
        function sel_status(value){
            if(value == val){ return 'selected';}else{ return '';}
        }
        $arr.map((it)=>{
            $option += "<option value='"+it+"'"+sel_status(it)+">"+ it + "</option>";
        })

       

        $('#gst').html($option);
    }

    
    
    // function update_product() {

    //     var brand_id     = document.getElementById("brand_name").value;
    //     var prod_cat_id  = document.getElementById("prod_cat_name").value;
    //     var product_name = document.getElementById("product_name").value;
    //     var amount       = document.getElementById("amount").value;
    //     var gst          = document.getElementById("gst").value;

    //     if(brand_id == '0'){

    //         $("#error_brand_name").html("Please select brand name");

    //     }else{
    //         $("#error_brand_name").html("");
    //     } 


    //     if(prod_cat_id == '0'){

    //         $("#error_prod_cat_name").html("Please select category name");

    //     }else{
    //         $("#error_prod_cat_name").html("");
    //     } 
        
    //     if(!product_name){

    //         $("#error_product_name").html("Please select product name");

    //     }else{
    //         $("#error_product_name").html("");
    //     } 

    //     if(amount == 0){

    //         $("#error_amount").html("invalid amunt entry");

    //     }else{
    //         $("#error_amount").html("");
    //     }
        
    //     if(gst == 0){
    //         $('#error_gst').html("Input feilds error")
    //     }else{
    //         $('#error_gst').html("");
    //     }


        

    //     if(brand_id && prod_cat_id && product_name && amount && gst > 0){
    //       //  document.getElementById('upd_product').style.pointerEvents = 'none';
    //         var data = "brand_id="+brand_id+"&prod_cat_id="+prod_cat_id+"&product_name="+product_name+"&amount="+amount+"&gst="+gst;

    //         const token = sessionStorage.getItem('token');

    //         fetch(base_url+"update_product/"+id+"?"+data, {
    //                 headers: {
    //                     "Content-Type": "application/x-www-form-urlencoded",
    //                     'Authorization': `Bearer ${token}`, // notice the Bearer before your token
    //                 },
    //                 method: "get",
    //             })
    //         .then((response) => response.json())
    //         .then((data) => {
    //             //document.getElementById('upd_product').style.pointerEvents = 'auto';
                
    //             if(data.status == '200'){

    //                 $("#status_success").html("<div class='alert alert-success' role='alert'>Product Successfully Updated!</div>");
                    
    //                 // setTimeout(() => { $("#status_success").html("");}, 2000);
                    
    //                 setTimeout(() => {$("#status_success").html(""); window.location.href = "./product"; document.getElementById('upd_product').style.pointerEvents = 'none';}, 4000);
                    
                    

    //             }
    //         });
    //     }
    // }
    function update_product() {
    var brand_id     = document.getElementById("brand_name").value;
    var prod_cat_id  = document.getElementById("prod_cat_name").value;
    var product_name = document.getElementById("product_name").value;
    var amount       = document.getElementById("amount").value;
    var gst          = document.getElementById("gst").value;
    var product_image = document.getElementById("product_image").files[0]; // Get the selected image file

    // Validation (as in your code)
    if (brand_id == '0') {
        $("#error_brand_name").html("Please select brand name");
    } else {
        $("#error_brand_name").html("");
    } 

    if (prod_cat_id == '0') {
        $("#error_prod_cat_name").html("Please select category name");
    } else {
        $("#error_prod_cat_name").html("");
    } 

    if (!product_name) {
        $("#error_product_name").html("Please enter product name");
    } else {
        $("#error_product_name").html("");
    } 

    if (amount == 0) {
        $("#error_amount").html("Invalid amount entry");
    } else {
        $("#error_amount").html("");
    }
    
    if (gst == 0) {
        $('#error_gst').html("Invalid GST value");
    } else {
        $('#error_gst').html("");
    }

    // Proceed if validation is successful
    if (brand_id && prod_cat_id && product_name && amount && gst > 0) {
        const formData = new FormData();
        formData.append("brand_id", brand_id);
        formData.append("prod_cat_id", prod_cat_id);
        formData.append("product_name", product_name);
        formData.append("amount", amount);
        formData.append("gst", gst);

        // Add image file to FormData if present
        if (product_image) {
            formData.append("product_image", product_image);
        }

        const token = sessionStorage.getItem('token');

        fetch(base_url + "update_product/" + id, {
            headers: {
                'Authorization': `Bearer ${token}`
            },
            method: "POST", // Change to POST for file uploads
            body: formData
        })
        .then((response) => response.json())
        .then((data) => {
            if(data.status == '200'){

                $("#status_success").html("<div class='alert alert-success' role='alert'>Product Successfully Updated!</div>");

                // setTimeout(() => { $("#status_success").html("");}, 2000);

                setTimeout(() => {$("#status_success").html(""); window.location.href = "./product"; document.getElementById('upd_product').style.pointerEvents = 'none';}, 4000);

            }
        })
        .catch((error) => {
            console.error("Error updating product:", error);
        });
    }
}


    }
</script>
