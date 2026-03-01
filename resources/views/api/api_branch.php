<script>
    var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{

        var base_url = window.location.origin+'/api/';
        
        getuserall();
        function getuserall(){
            const token = sessionStorage.getItem('token');
            fetch(base_url+"staff", {
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

                        var htmlhead ="<label class='form-label'>Branch Authority</label><select class='form-select' id='branch_authority'><option value='0'>Select</option>";

                        for(var i = 0; i < value.length  ; i++){
                            if(value[i].status == '0'){
                                htmlString += "<option value='"+value[i].staff_id+"'>"+ value[i].name + "</option>"
                            }
                        }
                        var htmlfooter ="</select><div class='text-danger' id='error_branch_authority'></div>";  
                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#staff_list").html(htmlstringall);
                                    
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
        
        // Check if a user has a specific action for the branch module
        function hasBranchPermission(action) {
            const branchModule = permission.find(p => p.name === "branch");
            return branchModule && branchModule.permission.includes(action);
        }
        function toggleAddBranchButton() {
            if (!hasBranchPermission("add")) {
                // UI BYPASS: $("#add_branch").hide(); // Hide the button if "add" permission is not available
            }
        }
        // Fetch and display branches
        function all() {
            const token = sessionStorage.getItem("token");
        
            fetch(base_url + "branch", {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    Authorization: `Bearer ${token}`,
                },
                method: "get",
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200 && data.data) {
                        const branches = data.data;
                        let htmlString = "";
        
                        const htmlHead = `
                            <table class='display' id='advance-1'>
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Company Name</th>
                                        <th>Branch Name</th>
                                        <th>Branch Authority</th>
                                        <th>Opening Date</th>
                                        <th>Branch Contact No</th>
                                        <th>Branch Location</th>
                                        <th>Branch Email ID</th>
                                        <th>Is Franchise</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>`;
        
                        branches.forEach((branch, index) => {
                            const franchise = branch.is_franchise === "1" ? "Yes" : "No";
                            const status = branch.status === "0" ? "checked" : "";
        
                            // Dynamically generate actions based on permissions
                            let actions = "";
                            if (hasBranchPermission("view")) {
                                actions += `<a href='view_branch?b_id=${branch.branch_id}'><i class='fa fa-eye eyc'></i></a>`;
                            }
                            if (hasBranchPermission("edit")) {
                                actions += `<a href='edit_branch?b_id=${branch.branch_id}'><i class='fa fa-edit eyc'></i></a>`;
                            }
                            if (hasBranchPermission("delete")) {
                                actions += `<a href='#' data-bs-toggle='modal' onclick='model(${branch.branch_id})'><i class='fa fa-trash eyc'></i></a>`;
                            }
        
                            htmlString += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${branch.company_name}</td>
                                    <td>${branch.branch_name}</td>
                                    <td>${branch.name}</td>
                                    <td>${branch.branch_opening_date}</td>
                                    <td>${branch.branch_phone}</td>
                                    <td>${branch.branch_location}</td>
                                    <td>${branch.branch_email}</td>
                                    <td>${franchise}</td>
                                    <td class='media-body switch-sm'>
                                        <label class='switch'>
                                            <input type='checkbox' ${status} onclick='br_status(${branch.branch_id}, ${branch.status})'>
                                            <span class='switch-state'></span>
                                        </label>
                                    </td>
                                    <td>${actions}</td>
                                </tr>`;
                        });
        
                        const htmlFooter = "</tbody></table>";
                        $("#branch_list").html(htmlHead + htmlString + htmlFooter);
                        datatable();
                    } else {
                        console.error("Failed to fetch branches:", data.message);
                    }
                })
                .catch(error => console.error("Error fetching branches:", error));
        }
        
        // Initialize: Fetch permissions and display branches
        permission_page("settings").then(() => {
            toggleAddBranchButton(); // Toggle the visibility of the Add Branch button
            all();
        });
// all();

// function all(){

//     const token = sessionStorage.getItem('token');

//     fetch(base_url+"branch", {
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

//                         var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Sl No</th><th>Company Name</th><th>Branch Name</th><th>Branch Authority</th><th>Opening Date</th><th>Branch Contact No</th><th>Branch Location</th><th>Branch<br>Email ID</th><th>Is Franchise</th><th>Status</th><th>Action</th></tr></thead><tbody>";

//                         for(var i = 0; i < value.length  ; i++){


//                             if(value[i].is_franchise == '1'){
//                                 var franchise = 'yes';
//                             }else{
//                                 var franchise = 'no';
//                             }

//                             var  status = '';
//                             if(value[i].status == '0'){
//                                 var status = 'checked';
//                             }

                            

//                             htmlString += "<tr>"+"<td>"+(i+1)+"</td><td>" + value[i].company_name + "</td><td>" +  value[i].branch_name + "</td><td>"+ value[i].name + "</td><td>"+ value[i].branch_opening_date + "</td><td>" + value[i].branch_phone + "</td><td>"+  value[i].branch_location + "</td><td>" +  value[i].branch_email + "</td><td>"+  franchise + "</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='br_status("+value[i].branch_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td><td>" + "<a href='view_branch?b_id="+value[i].branch_id+"'"+"><i class='fa fa-eye eyc'></i></a><a href='edit_branch?b_id="+value[i].branch_id+"'"+"><i class='fa fa-edit eyc'></i></a><a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model("+value[i].branch_id
//                             +")'><i class='fa fa-trash eyc'></i></a>" + "</td>"+"</tr>"


//                             // htmlString += "<tr>"+"<td>" + value[i].company_name + "</td><td>" +  value[i].branch_name + "</td><td>"+ value[i].branch_authority + "</td><td>"+ value[i].branch_opening_date + "</td><td>" + value[i].branch_phone + "</td><td>"+  value[i].branch_location + "</td><td>" +  value[i].company_name + "</td><td>"+  franchise + "</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='status("+value[i].branch_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td><td>" + "<a href='view_branch'><i class='fa fa-eye eyc'></i></a><a href='edit_branch'><i class='fa fa-edit eyc'></i></a><a href='#' data-bs-toggle='modal' data-bs-target='#branch_delete' ><i class='fa fa-trash eyc'></i></a>" + "</td>"+"</tr>"
                            
//                         }

//                         var htmlfooter ="</tbody></table>";
                        
//                         var htmlstringall = htmlhead+htmlString+htmlfooter;
//                         $("#branch_list").html(htmlstringall);

//                         datatable();

                        
                                    
//                     }
                   

//                 }
//             });
// }



function br_status(id,status){

    if(status == '1'){
        var branch_status = 0;
    }else{
        var branch_status = 1;
    }
    const token = sessionStorage.getItem('token');
    fetch(base_url+"branch_status/"+id+'?status='+branch_status, {
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

    $('#branch_delete').modal('show');
    delete_id = id;
}

$('#delete').click(function(){

    const token = sessionStorage.getItem('token');

    fetch(base_url+"delete_branch/"+delete_id, {
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

                $("#status_success").html("<div class='alert alert-success' role='alert'>Brand Successfully Deleted!</div>");
                  
                setTimeout(() => { $("#status_success").html("");}, 4000);    

                }
            });
})



document.getElementById("company_name").value = sessionStorage.getItem('company');

function checkbox(){

    if(event.target.checked){
        document.getElementById("franchise").value = "1";
    }else{
        document.getElementById("franchise").value = "0";
    }
    
}

function add_branch() {

    var company_name     = document.getElementById("company_name").value;
    var branch_name      = document.getElementById("branch_name").value;
    var branch_code      = document.getElementById("branch_code").value;
    var opening_date     = document.getElementById("opening_date").value;
    var branch_authority = document.getElementById("branch_authority").value;
    var branch_phone     = document.getElementById("branch_phone").value;
    var branch_location  = document.getElementById("branch_location").value;
    var branch_email     = document.getElementById("branch_email").value;
    var is_franchise     = document.getElementById("franchise").value;

    if(!company_name){

        $("#error_company_name").html("Please fill the input feilds");

    }else{
        $("#error_company_name").html("");
    } 
    
    if(!branch_name){
        $("#error_branch_name").html("Please fill the  input feilds");
    }
    else{
        $("#error_branch_name").html("");
    }
    
    if(!branch_code){
        $("#error_branch_code").html("Please fill the  input feilds");
    }
    else{
        $("#error_branch_code").html("");
    }
    if(!opening_date){
        $("#error_opening_date").html("Please fill the  input feilds");
      
    }
    else{

        $("#error_opening_date").html("");
    }
    
    if(branch_authority == 0){
        $("#error_branch_authority").html("Please fill the  input feilds");
        
    }
    else{
        $("#error_branch_authority").html("");
    }


    if(!branch_phone){
        $("#error_branch_phone").html("Please fill the  input feilds");
       
    }
    else{
        $("#error_branch_phone").html("");
    }
    
    if(!branch_location){
        $("#error_branch_location").html("Please fill the input feilds");
       
    }
    else{
        $("#error_branch_location").html("");
    }
    
    if(!branch_email){
        $("#error_branch_email").html("Please fill the input box");
      

    }else{
        $("#error_branch_email").html("");
    }


     if(company_name && branch_name && branch_code &&  opening_date && branch_authority && branch_phone && branch_location && branch_email && is_franchise){
        
        document.getElementById('add_brnch').style.pointerEvents = 'none';
        var data = "company_name="+company_name+"&branch_name="+branch_name+"&branch_code="+branch_code+"&branch_opening_date="+opening_date+"&branch_authority="+branch_authority+"&branch_phone="+branch_phone+"&branch_location="+branch_location+"&branch_email="+branch_email+"&is_franchise="+is_franchise;

        const token = sessionStorage.getItem('token');

        fetch(base_url+"add_branch?"+data, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "post",
            })
        .then((response) => response.json())
        .then((data) => {
           
            if(data.status == '200'){

                $("#status_success").html("<div class='alert alert-success' role='alert'>Brand Successfully Added!</div>");
                  
                setTimeout(() => { $("#status_success").html("");window.location.href = "./branch"; }, 3000);  
                
                
            }else{
                document.getElementById('add_brnch').style.pointerEvents = 'auto';

                if(data.error_msg){

                    if(data.error_msg.branch_name){
                        $("#error_branch_name").html(data.error_msg.branch_name[0]);
                    }

                    if(data.error_msg.branch_phone){
                        $("#error_branch_phone").html(data.error_msg.branch_phone[0]);
                    }

                    if(data.error_msg.branch_email){
                        $("#error_branch_email").html(data.error_msg.branch_email);
                    }


                    
                }

                

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



