<script>
        var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
all();

function all(){

    const token = sessionStorage.getItem('token');

    fetch(base_url+"designation", {
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

                       


                        var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Company name</th> <th>Designation</th><th>Description</th><th>Status</th><th>Action</th></tr></thead><tbody>";

                        for(var i = 0; i < value.length  ; i++){

                           
                            var  status = '';
                            if(value[i].status == '0'){
                                var status = 'checked';
                            }

                            htmlString += "<tr>"+"<td>" + value[i].company_name + "</td><td>" +  value[i].designation + "</td><td>"+ value[i].description + "</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='dsg_status("+value[i].job_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td><td>" + "<a href='view_designation?ds_id="+value[i].job_id+"'"+"><i class='fa fa-eye eyc'></i></a><a href='edit_designation?ds_id="+value[i].job_id+"'"+"><i class='fa fa-edit eyc'></i></a><a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model("+value[i].job_id
                            +")'><i class='fa fa-trash eyc'></i></a>" + "</td>"+"</tr>"
                            
                        }

                        var htmlfooter ="</tbody></table>";
                        
                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#designation_list").html(htmlstringall);

                        datatable();

                        
                                    
                    }
                   

                }
            });
}

function dsg_status(id,status){

    if(status == '1'){
        var designation_status = 0;
    }else{
        var designation_status = 1;
    }
    const token = sessionStorage.getItem('token');
    fetch(base_url+"designation_status/"+id+'?status='+designation_status, {
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

    $('#designation_delete').modal('show');
    delete_id = id;
}

$('#delete').click(function(){

    const token = sessionStorage.getItem('token');

    fetch(base_url+"delete_designation/"+delete_id, {
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

                $("#status_success").html("<div class='alert alert-success' role='alert'>Designation Successfully Deleted!</div>");
                  
                setTimeout(() => { $("#status_success").html("");}, 4000);    

                }
            });
})



document.getElementById("company_name").value = sessionStorage.getItem('company');


function add_designation() {

    var company_name     = document.getElementById("company_name").value;
    var designation      = document.getElementById("designation").value;
    var description     = document.getElementById("description").value;
  

    if(!company_name){

        $("#error_company_name").html("Please fill the input feilds");

    }else{
        $("#error_company_name").html("");
    } 
    
    if(!designation){
        $("#error_designation").html("Please fill the  input feilds");
    }
    else{
        $("#error_designation").html("");
    }
    
    // if(!description){
    //     $("#error_description").html("Please fill the  input feilds");
      
    // }
    // else{

    //     $("#error_description").html("");
    // }
    
    


    if(company_name && designation ){
        document.getElementById('add_desig').style.pointerEvents = 'none';
        var data = "company_name="+company_name+"&designation="+designation+"&description="+description;

        const token = sessionStorage.getItem('token');

        fetch(base_url+"add_designation?"+data, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "post",
            })
        .then((response) => response.json())
        .then((data) => {
            
            
            if(data.status == '200'){

                

                $("#status_success").html("<div class='alert alert-success' role='alert'>Designation Successfully Added!</div>");
                  
                setTimeout(() => { $("#status_success").html("");window.location.href = "./designation";   document.getElementById('add_desig').style.pointerEvents = 'none';}, 4000);  
                
                

            }else{
                document.getElementById('add_desig').style.pointerEvents = 'auto';
                $("#status_success").html("<div class='alert alert-danger' role='alert'>"+data.error_msg.designation[0]+"</div>");
                  
                  setTimeout(() => { $("#status_success").html("");window.location.href = "./designation";   document.getElementById('add_desig').style.pointerEvents = 'none';}, 4000); 
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


