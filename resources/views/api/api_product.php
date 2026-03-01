<script>
 var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
    getbrandall();

    function getbrandall(){

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

                                htmlString += "<option value="+value[i].brand_id+">"+ value[i].brand_name + "</option>"
                         
                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_brand_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#product_brand_list").html(htmlstringall);
              
                        }
                    

                    }
                });
    }

    getproductcatall();

    function getproductcatall(){

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

                                htmlString += "<option value="+value[i].prod_cat_id+">"+ value[i].prod_cat_name + "</option>"
                         
                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_prod_cat_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#prod_cat_list").html(htmlstringall);
   
                                        
                        }
                    

                    }
                });
    }
    
     async function permission_page(name) {
            try {
                const response = await fetch(base_url + "role_permission_page/" + name, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        Authorization: `Bearer ${token}`,
                    },
                    method: "get",
                });
        
                const data = await response.json();
                if (data.status === 200) {
                    permission = JSON.parse(data.data.permission); // Parse the permission string into an array
                    console.log("Fetched Permissions:", permission);
                } else {
                    console.error("Error fetching permissions:", data.message);
                }
            } catch (error) {
                console.error("Error:", error);
            }
        }
        
        function hasTreatmentPermission(action) {
            const treatmentModule = permission.find(p => p.name === "treatment");
            return treatmentModule && treatmentModule.permission.includes(action);
        }

// all();

function all(){

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

                        var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Brand</th><th>Product Category</th><th>Product Name</th><th>Amount</th><th>Status</th><th>Action</th></tr></thead><tbody>";

                        for(var i = 0; i < value.length  ; i++){

                           
                            var  status = '';
                            if(value[i].status == '0'){
                                var status = 'checked';
                            }
                            
                              // Check permissions for actions
                            let actions = "";
                            if (hasTreatmentPermission("view")) {
                                actions += `<a href='view_product?p_id=${value[i].product_id}'><i class='fa fa-eye eyc'></i></a>`;
                            }
                            if (hasTreatmentPermission("edit")) {
                                actions += `<a href='edit_product?p_id=${value[i].product_id}'><i class='fa fa-edit eyc'></i></a>`;
                            }
                            if (hasTreatmentPermission("delete")) {
                                actions += `<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model(${value[i].product_id})'><i class='fa fa-trash eyc'></i></a>`;
                            }

                            htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].brand_name +"</td><td>" + value[i].prod_cat_name +"</td><td>" + value[i].product_name +"</td><td>" + value[i].amount +"</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='prod_status("+value[i].product_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td><td>" +
                                actions +
                                "</td></tr>";
                            
                        }

                        var htmlfooter ="</tbody></table>";
                        
                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#product_list").html(htmlstringall);

                        datatable();
                                    
                    }
                   

                }
            });
}
// Hide "Add Treatment" button if the user does not have the "add" permission
    function toggleAddTreatmentButton() {
        if (!hasTreatmentPermission("add")) {
            // UI BYPASS: $("#add_product").hide(); // Hide the button if "add" permission is not available
        }
    }
    
    // Initialize: Fetch permissions and apply logic for Treatment
    permission_page("settings").then(() => {
        toggleAddTreatmentButton(); // Toggle the visibility of the Add Treatment button
        all(); // Fetch and display treatments
    });
function prod_status(id,status){

    if(status == '1'){
        var product_status = 0;
    }else{
        var product_status = 1;
    }
    const token = sessionStorage.getItem('token');
    fetch(base_url+"product_status/"+id+'?status='+product_status, {
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                'Authorization': `Bearer ${token}`, // notice the Bearer before your token
            },
            method: "get",
        })
        .then((response) => response.json())
            .then((data) => {
            
                if(data.status == '200'){

                  $("#status_success").html("<div class='alert alert-success' role='alert'>Product Successfully Updated!</div>");
                  
                  setTimeout(() => { $("#status_success").html("");}, 4000);    

                }
            });
            
}

var delete_id = '';

function model(id){

    $('#product_delete').modal('show');
    delete_id = id;
}

$('#delete').click(function(){

    const token = sessionStorage.getItem('token');

    fetch(base_url+"delete_product/"+delete_id, {
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                'Authorization': `Bearer ${token}`, // notice the Bearer before your token
            },
            method: "delete",
        })
        .then((response) => response.json())
            .then((data) => {
            
                if(data.status == '200'){

                all();

                $("#status_success").html("<div class='alert alert-success' role='alert'>Product Successfully Deleted!</div>");
                  
                setTimeout(() => { $("#status_success").html("");}, 4000);    

                }
            });
})






// function add_product() {


   
//     var brand_id     = document.getElementById("brand_name").value;
//     var prod_cat_id  = document.getElementById("prod_cat_name").value;
//     var product_name = document.getElementById("product_name").value;
//     var amount       = document.getElementById("amount").value;   
//     var gst          = document.getElementById("gst").value;
//     var product_image          = document.getElementById("product_image").value;
   

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

//         $("#error_amount").html("Input feilds error");

//     }else{
//         $("#error_amount").html("");
//     }

//     if(gst == 0){
//         $('#error_gst').html("Input feilds error")
//     }else{
//         $('#error_gst').html("");
//     }


//     if(brand_id && prod_cat_id && product_name && amount && gst && product_image){

//         document.getElementById('add_prod').style.pointerEvents = 'none';


//         var data = "brand_id="+brand_id+"&prod_cat_id="+prod_cat_id+"&product_name="+product_name+"&amount="+amount+"&gst="+gst+"&product_image="+product_image;

//         const token = sessionStorage.getItem('token');

//         fetch(base_url+"add_product?"+data, {
//                 headers: {
//                     "Content-Type": "application/x-www-form-urlencoded",
//                     'Authorization': `Bearer ${token}`, // notice the Bearer before your token
//                 },
//                 method: "post",
//             })
//         .then((response) => response.json())
//         .then((data) => {

//         document.getElementById('add_prod').style.pointerEvents = 'auto';

            
//             if(data.status == '200'){

                

//                 $("#status_success").html("<div class='alert alert-success' role='alert'>Product Successfully Added!</div>");
                  
//                 setTimeout(() => { $("#status_success").html("");window.location.href = "./product";}, 4000);  
                
                

//             }else{
//                $("#error_product_name").html(data.error_msg.product_name[0]);
               
//             }
//         });
//      }
    

// }
function add_product() {
    // Get input values
    var brand_id = document.getElementById("brand_name").value;
    var prod_cat_id = document.getElementById("prod_cat_name").value;
    var product_name = document.getElementById("product_name").value;
    var amount = document.getElementById("amount").value;
    var gst = document.getElementById("gst").value;
    var product_image = document.getElementById("product_image").files[0]; // Get file directly

    // Validate form inputs
    if (brand_id === '0') {
        $("#error_brand_name").html("Please select brand name");
    } else {
        $("#error_brand_name").html("");
    }

    if (prod_cat_id === '0') {
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
        $("#error_amount").html("Amount field error");
    } else {
        $("#error_amount").html("");
    }

    if (gst == 0) {
        $('#error_gst').html("GST field error");
    } else {
        $('#error_gst').html("");
    }

    // Proceed only if all inputs are valid
    if (brand_id && prod_cat_id && product_name && amount && gst && product_image) {
        document.getElementById('add_prod').style.pointerEvents = 'none';

        // Prepare form data
        var formData = new FormData();
        formData.append("brand_id", brand_id);
        formData.append("prod_cat_id", prod_cat_id);
        formData.append("product_name", product_name);
        formData.append("amount", amount);
        formData.append("gst", gst);
        formData.append("product_image", product_image); // Add image file

        const token = sessionStorage.getItem('token');

        fetch(base_url + "add_product", {
            headers: {
                'Authorization': `Bearer ${token}`, // Auth token
            },
            method: "POST",
            body: formData, // Set formData as body
        })
        .then((response) => response.json())
        .then((data) => {
            document.getElementById('add_prod').style.pointerEvents = 'auto';

            if(data.status == '200'){

            $("#status_success").html("<div class='alert alert-success' role='alert'>Product Successfully Added!</div>");
            
            setTimeout(() => { $("#status_success").html("");window.location.href = "./product";}, 4000);  

            }else{
            $("#error_product_name").html(data.error_msg.product_name[0]);

            }
        });
    }
}


function datatable(){
    $("#advance-1").DataTable({
                        // "ordering": false,
                        "responsive": true,
                        "aaSorting":[],
                        "language": {
                            "lengthMenu": "Show _MENU_",
                        },
                        // dom: 'Bfrtip',
                        "dom":
                            "<'row'" +
                            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                            ">" +

                            "<'table-responsive'tr>" +

                            "<'row'" +
                            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                            ">"
                        }); 
}
    }
    
</script>



