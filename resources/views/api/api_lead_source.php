<script>
     var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
       var base_url = window.location.origin+'/api/';


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
        
         function hasTreatmentPermission(action) {
            const treatmentModule = permission.find(p => p.name === "lead_source");
            return treatmentModule && treatmentModule.permission.includes(action);
        }
all();

function all(){

    const token = sessionStorage.getItem('token');

    fetch(base_url+"lead_source", {
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

                        var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Lead Source</th><th>Status</th><th>Action</th></tr></thead><tbody>";

                        for(var i = 0; i < value.length  ; i++){

                           
                            var  status = '';
                            if(value[i].status == '0'){
                                var status = 'checked';
                            }
                            
                             // Check permissions for actions
                            let actions = "";
                            if (hasTreatmentPermission("view")) {
                                actions += `<a href='view_lead_source?lsr_id=${value[i].lead_source_id}'><i class='fa fa-eye eyc'></i></a>`;
                            }
                            if (hasTreatmentPermission("edit")) {
                                actions += `<a href='edit_lead_source?lsr_id=${value[i].lead_source_id}'><i class='fa fa-edit eyc'></i></a>`;
                            }
                            if (hasTreatmentPermission("delete")) {
                                actions += `<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model(${value[i].lead_source_id})'><i class='fa fa-trash eyc'></i></a>`;
                            }

                            htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].lead_source_name +"</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='ls_status("+value[i].lead_source_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td><td>" +
                                actions +
                                "</td></tr>";
                            
                        }

                        var htmlfooter ="</tbody></table>";
                        
                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#lead_source_list").html(htmlstringall);

                        datatable();
                                    
                    }
                   

                }
            });
}

    // Hide "Add Treatment" button if the user does not have the "add" permission
    function toggleAddTreatmentButton() {
        if (!hasTreatmentPermission("add")) {
            // UI BYPASS: $("#add_lead_source").hide(); // Hide the button if "add" permission is not available
        }
    }
    
    // Initialize: Fetch permissions and apply logic for Treatment
    permission_page("settings").then(() => {
        toggleAddTreatmentButton(); // Toggle the visibility of the Add Treatment button
        all(); // Fetch and display treatments
    });
function ls_status(id,status){

    if(status == '1'){
        var lead_source_status = 0;
    }else{
        var lead_source_status = 1;
    }
    const token = sessionStorage.getItem('token');
    fetch(base_url+"lead_source_status/"+id+'?status='+lead_source_status, {
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                'Authorization': `Bearer ${token}`, // notice the Bearer before your token
            },
            method: "get",
        })
        .then((response) => response.json())
            .then((data) => {
            
                if(data.status == '200'){

                  $("#status_success").html("<div class='alert alert-success' role='alert'>Status Successfully Updated!</div>");
                  
                  setTimeout(() => { $("#status_success").html("");}, 4000);    

                }
            });
            
}

var delete_id = '';

function model(id){

    $('#lead_source_delete').modal('show');
    delete_id = id;
}

$('#delete').click(function(){

    const token = sessionStorage.getItem('token');

    fetch(base_url+"delete_lead_source/"+delete_id, {
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

                $("#status_success").html("<div class='alert alert-success' role='alert'>Lead source Successfully Deleted!</div>");
                  
                setTimeout(() => { $("#status_success").html("");}, 4000);    

                }
            });
})




function add_lead_source() {

    var lead_source_name     = document.getElementById("lead_source_name").value;
   
  

    if(!lead_source_name){

        $("#error_lead_source_name").html("Please fill the input feilds");

    }else{
        $("#error_lead_source_name").html("");
    } 
    

    if(lead_source_name){
        document.getElementById('add_l_source').style.pointerEvents = 'none';

        var data = "lead_source_name="+lead_source_name;

        const token = sessionStorage.getItem('token');

        fetch(base_url+"add_lead_source?"+data, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "post",
            })
        .then((response) => response.json())
        .then((data) => {
       
            
            if(data.status == '200'){
                

                $("#status_success").html("<div class='alert alert-success' role='alert'>Lead Source Successfully Added!</div>");
                  
                setTimeout(() => { $("#status_success").html(""); window.location.href = "./lead_source"; }, 4000);  
                
               

            }else{
                document.getElementById('add_l_source').style.pointerEvents = 'auto';
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



