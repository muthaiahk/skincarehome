<script>

var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
       var base_url = window.location.origin+'/api/';

// all();
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
            const treatmentModule = permission.find(p => p.name === "treatment");
            return treatmentModule && treatmentModule.permission.includes(action);
        }


function all(){

    

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

                        var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Category name</th><th>Status</th><th>Action</th></tr></thead><tbody>";

                        for(var i = 0; i < value.length  ; i++){

                           
                            var  status = '';
                            if(value[i].status == '0'){
                                var status = 'checked';
                            }
                            
                             // Check permissions for actions
                            let actions = "";
                            if (hasTreatmentPermission("view")) {
                                actions += `<a href='view_tc?tc_id=${value[i].tcategory_id}'><i class='fa fa-eye eyc'></i></a>`;
                            }
                            if (hasTreatmentPermission("edit")) {
                                actions += `<a href='edit_tc?tc_id=${value[i].tcategory_id}'><i class='fa fa-edit eyc'></i></a>`;
                            }
                            if (hasTreatmentPermission("delete")) {
                                actions += `<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model(${value[i].tcategory_id})'><i class='fa fa-trash eyc'></i></a>`;
                            }

                            htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].tc_name +"</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='tc_status("+value[i].tcategory_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td><td>" +
                                actions +
                                "</td></tr>";
                            
                        }

                        var htmlfooter ="</tbody></table>";
                        
                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#tc_list").html(htmlstringall);

                        datatable();
                                    
                    }
                   

                }
            });
   }
// Hide "Add Treatment" button if the user does not have the "add" permission
    function toggleAddTreatmentButton() {
        if (!hasTreatmentPermission("add")) {
            // UI BYPASS: $("#add_treatment_cat").hide(); // Hide the button if "add" permission is not available
        }
    }
    
    // Initialize: Fetch permissions and apply logic for Treatment
    permission_page("settings").then(() => {
        toggleAddTreatmentButton(); // Toggle the visibility of the Add Treatment button
        all(); // Fetch and display treatments
    });

function tc_status(id,status){

    if(status == '1'){
        var treatment_cat_status = 0;
    }else{
        var treatment_cat_status = 1;
    }
    const token = sessionStorage.getItem('token');
    fetch(base_url+"treatment_cat_status/"+id+'?status='+treatment_cat_status, {
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
                  
                  setTimeout(() => { $("#status_success").html("");}, 4000);    

                }
            });
            
}

var delete_id = '';

function model(id){

    $('#treatment_category_delete').modal('show');
    delete_id = id;
}

$('#delete').click(function(){

    const token = sessionStorage.getItem('token');

    fetch(base_url+"delete_treatment_cat/"+delete_id, {
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

                $("#status_success").html("<div class='alert alert-success' role='alert'>Category Successfully Deleted!</div>");
                  
                setTimeout(() => { $("#status_success").html("");}, 4000);    

                }
            });
})




function add_treatment_cat() {

    var treatment_cat_name = document.getElementById("treatment_cat_name").value;
   

    
    if(!treatment_cat_name){

        $("#error_treatment_cat_name").html("Please fill the input feilds");

    }else{
        $("#error_treatment_cat_name").html("");
    } 


    if(treatment_cat_name){

        document.getElementById('add_t_cat').style.pointerEvents = 'none';

        var data = "tc_name="+treatment_cat_name;

        const token = sessionStorage.getItem('token');

        fetch(base_url+"add_treatment_cat?"+data, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "post",
            })
        .then((response) => response.json())
        .then((data) => {

        

            
            if(data.status == '200'){

                

                $("#status_success").html("<div class='alert alert-success' role='alert'>Category Successfully Added!</div>");
                  
                setTimeout(() => { $("#status_success").html("");window.location.href = "./t_category";}, 4000);  
                
                

            }else{
               $("#error_treatment_cat_name").html(data.error_msg.tc_name[0]);
               document.getElementById('add_t_cat').style.pointerEvents = 'auto';
               
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



