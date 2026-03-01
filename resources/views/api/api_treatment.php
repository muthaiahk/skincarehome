<script>

var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
    gettcall();

    function gettcall(){

        const token = sessionStorage.getItem('token');

        fetch(base_url+"treatment_cat", {
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

                            var htmlhead ="<label class='form-label'>Categories</label><select class='form-select' id='tc_name'><option value='0'>Select Categories</option>";

                            for(var i = 0; i < value.length  ; i++){

                                htmlString += "<option value="+value[i].tcategory_id+">"+ value[i].tc_name + "</option>"
                         
                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_tc_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#tc_list").html(htmlstringall);

                                        
                        }
                    

                    }
                });
    }
      let permission = []; // Initialize as an array
        
        // Fetch permissions for a module
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

    // all();

    // function all(){

        

    //     const token = sessionStorage.getItem('token');

    //     fetch(base_url+"treatment", {
    //             headers: {
    //                 "Content-Type": "application/x-www-form-urlencoded",
    //                 'Authorization': `Bearer ${token}`, // notice the Bearer before your token
    //             },
    //             method: "get",
    //         })
    //             .then((response) => response.json())
    //             .then((data) => {
                
    //                 if(data.status == '200'){

    //                     if(data.data){
                            
    //                         const value = data.data;
    //                         var htmlString = "";

    //                         var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Treatment Categories</th><th>Treatment name</th><th>Amount</th><th>Status</th><th>Action</th></tr></thead><tbody>";

    //                         for(var i = 0; i < value.length  ; i++){

                            
    //                             var  status = '';
    //                             if(value[i].status == '0'){
    //                                 var status = 'checked';
    //                             }

    //                             htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].tc_name +"</td><td>" + value[i].treatment_name+"</td><td>" + value[i].amount+"</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='trmt_status("+value[i].treatment_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td><td>" + "<a href='view_treatment?t_id="+value[i].treatment_id+"'"+"><i class='fa fa-eye eyc'></i></a><a href='edit_treatment?t_id="+value[i].treatment_id+"'"+"><i class='fa fa-edit eyc'></i></a><a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model("+value[i].treatment_id +")'><i class='fa fa-trash eyc'></i></a>" + "</td></tr>";
                                
    //                         }

    //                         var htmlfooter ="</tbody></table>";
                            
    //                         var htmlstringall = htmlhead+htmlString+htmlfooter;
    //                         $("#treatment_list").html(htmlstringall);

    //                         datatable();
                                        
    //                     }
                    

    //                 }
    //             });
    // }
    // Check if a user has a specific action for the treatment module
    function hasTreatmentPermission(action) {
        const treatmentModule = permission.find(p => p.name === "treatment");
        return treatmentModule && treatmentModule.permission.includes(action);
    }
    
    // Fetch and display treatments based on permissions
    function all() {
        const token = sessionStorage.getItem("token");
    
        fetch(base_url + "treatment", {
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                Authorization: `Bearer ${token}`, // notice the Bearer before your token
            },
            method: "get",
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status == "200" && data.data) {
                    const value = data.data;
                    var htmlString = "";
    
                    var htmlhead =
                        "<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Treatment Categories</th><th>Treatment Name</th><th>Amount</th><th>Status</th><th>Action</th></tr></thead><tbody>";
    
                    for (var i = 0; i < value.length; i++) {
                        var status = value[i].status == "0" ? "checked" : "";
    
                        // Check permissions for actions
                        let actions = "";
                        if (hasTreatmentPermission("view")) {
                            actions += `<a href='view_treatment?t_id=${value[i].treatment_id}'><i class='fa fa-eye eyc'></i></a>`;
                        }
                        if (hasTreatmentPermission("edit")) {
                            actions += `<a href='edit_treatment?t_id=${value[i].treatment_id}'><i class='fa fa-edit eyc'></i></a>`;
                        }
                        // if (hasTreatmentPermission("delete")) {
                        //     actions += `<a href='#' data-bs-toggle='modal' onclick='model(${value[i].treatment_id})'><i class='fa fa-trash eyc'></i></a>`;
                        // }
    
                        htmlString +=
                            "<tr><td>" +
                            (i + 1) +
                            "</td><td>" +
                            value[i].tc_name +
                            "</td><td>" +
                            value[i].treatment_name +
                            "</td><td>" +
                            value[i].amount +
                            "</td><td class='media-body switch-sm'>" +
                            "<label class='switch'><input type='checkbox' " +
                            status +
                            " onclick='trmt_status(" +
                            value[i].treatment_id +
                            "," +
                            value[i].status +
                            ")'><span class='switch-state'></span></label>" +
                            "</td><td>" +
                            actions +
                            "</td></tr>";
                    }
    
                    var htmlfooter = "</tbody></table>";
                    var htmlstringall = htmlhead + htmlString + htmlfooter;
                    $("#treatment_list").html(htmlstringall);
    
                    datatable();
                }
            });
    }
    
    // Hide "Add Treatment" button if the user does not have the "add" permission
    function toggleAddTreatmentButton() {
        if (!hasTreatmentPermission("add")) {
            // UI BYPASS: $("#add_treatment").hide(); // Hide the button if "add" permission is not available
        }
    }
    
    // Initialize: Fetch permissions and apply logic for Treatment
    permission_page("settings").then(() => {
        toggleAddTreatmentButton(); // Toggle the visibility of the Add Treatment button
        all(); // Fetch and display treatments
    });

    function trmt_status(id,status){

        if(status == '1'){
            var treatment_status = 0;
        }else{
            var treatment_status = 1;
        }
        const token = sessionStorage.getItem('token');
        fetch(base_url+"treatment_status/"+id+'?status='+treatment_status, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
            })
            .then((response) => response.json())
                .then((data) => {
                
                    if(data.status == '200'){

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Treatement Successfully Updated!</div>");
                    
                    setTimeout(() => { $("#status_success").html("");}, 4000);    

                    }
                });
                
    }

    var delete_id = '';

    function model(id){

        $('#treatment_delete').modal('show');
        delete_id = id;
    }

    $('#delete').click(function(){

        const token = sessionStorage.getItem('token');

        fetch(base_url+"delete_treatment/"+delete_id, {
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

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Treatment Successfully Deleted!</div>");
                    
                    setTimeout(() => { $("#status_success").html("");}, 4000);    

                    }
                });
    })




    // function add_treatment() {


    //     var tc_id  = document.getElementById("tc_name").value;
    //     var treatment_name = document.getElementById("treatment_name").value;
    //     var amount = document.getElementById("amount").value;



    //     if(tc_id == '0'){

    //         $("#error_tc_name").html("Please select category name");

    //     }else{
    //         $("#error_tc_name").html("");
    //     } 
        
    //     if(!treatment_name){

    //         $("#error_treatment_name").html("Please fill the input feilds");

    //     }else{
    //         $("#error_treatment_name").html("");
    //     } 

    //     if(!amount || amount == 0){

    //         $("#error_amount").html("amount is invalid");

    //     }else{
    //         $("#error_amount").html("");
    //     } 


    //     if(tc_id  && treatment_name && amount){

    //         document.getElementById('add_treatmnt').style.pointerEvents = 'none';


    //         var data = "tc_id="+tc_id+"&treatment_name="+treatment_name+"&amount="+amount;

    //         const token = sessionStorage.getItem('token');

    //         fetch(base_url+"add_treatment?"+data, {
    //                 headers: {
    //                     "Content-Type": "application/x-www-form-urlencoded",
    //                     'Authorization': `Bearer ${token}`, // notice the Bearer before your token
    //                 },
    //                 method: "post",
    //             })
    //         .then((response) => response.json())
    //         .then((data) => {
            
                
    //             if(data.status == '200'){
                

    //                 $("#status_success").html("<div class='alert alert-success' role='alert'>Treatement Successfully Added!</div>");
                    
    //                 setTimeout(() => { $("#status_success").html("");window.location.href = "./treatment";}, 4000);  
                    
                    

    //             }else if(data.status == '401'){
                    
    //                 $("#error_treatment_name").html(data.error_msg);
    //                 document.getElementById('add_treatmnt').style.pointerEvents = 'auto';
                  
    //             }
    //             else{
    //                 // $("#status_success").html("<div class='alert alert-success' role='alert'>Treatement Successfully Added!</div>");
                    
    //                 // setTimeout(() => { $("#status_success").html("");window.location.href = "./treatment";}, 4000);  
    //                $("#error_treatment_name").html(data.error_msg.treatment_name[0]);
    //                document.getElementById('add_treatmnt').style.pointerEvents = 'auto';
    //             }
    //         });
    //     }
        

    // }
    function add_treatment() { 
        var tc_id = document.getElementById("tc_name").value;
        var treatment_name = document.getElementById("treatment_name").value;
        var amount = document.getElementById("amount").value;

        // Validate inputs
        if (tc_id == '0') {
            $("#error_tc_name").html("Please select category name");
            return;
        } else {
            $("#error_tc_name").html("");
        } 

        if (!treatment_name) {
            $("#error_treatment_name").html("Please fill the input fields");
            return;
        } else {
            $("#error_treatment_name").html("");
        } 

        if (!amount || amount == 0) {
            $("#error_amount").html("Amount is invalid");
            return;
        } else {
            $("#error_amount").html("");
        } 

        // Proceed if all validations pass
        if (tc_id && treatment_name && amount) {
            const button = document.getElementById('add_treatmnt');
            const spinner = button.querySelector('.spinner-border');

            // Disable button and show loading spinner
            button.style.pointerEvents = 'none';
            button.textContent = 'Submitting...'; // Change button text
            spinner.style.display = 'inline-block'; // Show spinner

            var data = "tc_id=" + tc_id + "&treatment_name=" + treatment_name + "&amount=" + amount;
            const token = sessionStorage.getItem('token');

            fetch(base_url + "add_treatment?" + data, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`,
                },
                method: "post",
            })
            .then((response) => response.json())
            .then((data) => {
                // Hide spinner and enable button
                spinner.style.display = 'none'; // Hide spinner
                button.disabled = false; // Enable button
                button.textContent = 'Submit'; // Reset button text

                if (data.status == '200') {
                    $("#status_success").html("<div class='alert alert-success' role='alert'>Treatment Successfully Added!</div>");
                    setTimeout(() => { 
                        $("#status_success").html(""); 
                        window.location.href = "./treatment"; 
                    }, 4000);  
                } else if (data.status == '401') {
                    $("#error_treatment_name").html(data.error_msg);
                } else {
                    $("#error_treatment_name").html(data.error_msg.treatment_name[0]);
                }
            })
            .catch((error) => {
                // Hide spinner and enable button on error
                spinner.style.display = 'none'; // Hide spinner
                button.disabled = false; // Enable button
                button.textContent = 'Submit'; // Reset button text
                console.error('Error:', error);
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



