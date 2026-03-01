<script>

var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
       var base_url = window.location.origin+'/api/';
       
       
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
        
        function hasTreatmentPermission(action) {
            const treatmentModule = permission.find(p => p.name === "role");
            return treatmentModule && treatmentModule.permission.includes(action);
        }
        all();

        function all(){

            const token = sessionStorage.getItem('token');

            fetch(base_url+"role", {
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

                                var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Role name</th><th>Status</th><th>Action</th></tr></thead><tbody>";

                                for(var i = 0; i < value.length  ; i++){

                                
                                    var  status = '';
                                    if(value[i].status == '0'){
                                        var status = 'checked';
                                    }
                                    
                                     let actions = "";
                                        if (hasTreatmentPermission("view")) {
                                            actions += `<a href='view_role?r_id=${value[i].role_id}'><i class='fa fa-eye eyc'></i></a>`;
                                        }
                                        if (hasTreatmentPermission("edit")) {
                                            actions += `<a href='edit_role?r_id=${value[i].role_id}'+"><i class='fa fa-edit eyc'></i></a>`;
                                        }
                                        if (hasTreatmentPermission("delete")) {
                                            actions += `</a><a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model(${value[i].role_id})'><i class='fa fa-trash eyc'></i></a>`;
                                        }
                                       if (hasTreatmentPermission("delete")) {
                                            actions += `<a href='add_permission?r_id=${value[i].role_id}'><i class='fa fa-sliders'></i></a>`;
                                        }



                                    htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].role_name +"</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='role_status("+value[i].role_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td><td>" +
                                        actions +
                                        "</td></tr>";
                                    
                                }

                                var htmlfooter ="</tbody></table>";
                                
                                var htmlstringall = htmlhead+htmlString+htmlfooter;
                                $("#role_list").html(htmlstringall);

                                datatable();
                                            
                            }
                        

                        }
                    });
        }


   // Hide "Add Treatment" button if the user does not have the "add" permission
    function toggleAddTreatmentButton() {
        if (!hasTreatmentPermission("add")) {
            // UI BYPASS: $("#add_role").hide(); // Hide the button if "add" permission is not available
        }
    }
    
    // Initialize: Fetch permissions and apply logic for Treatment
    permission_page("settings").then(() => {
        toggleAddTreatmentButton(); // Toggle the visibility of the Add Treatment button
        all(); // Fetch and display treatments
    });
    
        function role_status(id,status){

            if(status == '1'){
                var role_status = 0;
            }else{
                var role_status = 1;
            }


            const token = sessionStorage.getItem('token');
            fetch(base_url+"role_status/"+id+'?status='+role_status, {
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
                        
                        setTimeout(() => { $("#status_success").html("");}, 4000);    

                        }else{
                            $("#status_success").html("<div class='alert alert-danger' role='alert'>"+data.message+"</div>");
                        
                        setTimeout(() => { $("#status_success").html("");all();}, 4000);    
                        }
                    });
                    
        }

        var delete_id = '';

        function model(id){

            $('#role_delete').modal('show');
            delete_id = id;
        }

        $('#delete').click(function(){

            const token = sessionStorage.getItem('token');

            fetch(base_url+"delete_role/"+delete_id, {
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

                        $("#status_success").html("<div class='alert alert-success' role='alert'>Role Successfully Deleted!</div>");
                        
                            setTimeout(() => { $("#status_success").html("");window.location.href = "./role_permission";}, 4000);    

                        }else{
                            $("#status_success").html("<div class='alert alert-danger' role='alert'>"+data.message+"</div>");
                            setTimeout(() => { $("#status_success").html("");all();}, 4000);   
                        }
                    });
        })




        function add_role() {

            var role_name = document.getElementById("role_name").value;
        

            
            if(!role_name){

                $("#error_role_name").html("Please fill the input feilds");

            }else{
                $("#error_role_name").html("");
            } 


            if(role_name){

                document.getElementById('add_rle').style.pointerEvents = 'none';


                var data = "role_name="+role_name;

                const token = sessionStorage.getItem('token');

                fetch(base_url+"add_role?"+data, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                        },
                        method: "post",
                    })
                .then((response) => response.json())
                .then((data) => {
                    
                    if(data.status == '200'){

                        

                        $("#status_success").html("<div class='alert alert-success' role='alert'>Role Successfully Added!</div>");
                        
                        setTimeout(() => { $("#status_success").html("");window.location.href = "./role_permission";}, 4000);  
                        
                        

                    }else{
                    $("#error_role_name").html(data.error_msg.role_name[0]);
                    document.getElementById('add_rle').style.pointerEvents = 'auto';
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



