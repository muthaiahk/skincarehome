<script>
     var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
       var base_url = window.location.origin+'/api/';

all();

function all(){

    const token = sessionStorage.getItem('token');

    fetch(base_url+"lead_status", {
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

                        var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Lead Status</th><th>Status</th><th>Action</th></tr></thead><tbody>";

                        for(var i = 0; i < value.length  ; i++){

                           
                            var  status = '';
                            if(value[i].status == '0'){
                                var status = 'checked';
                            }

                            htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].lead_status_name +"</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='ld_status("+value[i].lead_status_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td><td>" + "<a href='view_lead_status?ls_id="+value[i].lead_status_id+"'"+"><i class='fa fa-eye eyc'></i></a><a href='edit_lead_status?ls_id="+value[i].lead_status_id+"'"+"><i class='fa fa-edit eyc'></i></a><a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model("+value[i].lead_status_id +")'><i class='fa fa-trash eyc'></i></a>" + "</td></tr>";
                            
                        }

                        var htmlfooter ="</tbody></table>";
                        
                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#lead_status_list").html(htmlstringall);

                        datatable();
                                    
                    }
                   

                }
            });
}

function ld_status(id,status){

    if(status == '1'){
        var lead_status_status = 0;
    }else{
        var lead_status_status = 1;
    }
    const token = sessionStorage.getItem('token');
    fetch(base_url+"lead_status_status/"+id+'?status='+lead_status_status, {
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

    $('#lead_status_delete').modal('show');
    delete_id = id;
}

$('#delete').click(function(){

    const token = sessionStorage.getItem('token');

    fetch(base_url+"delete_lead_status/"+delete_id, {
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




function add_lead_status() {

    

    var lead_status_name     = document.getElementById("lead_status_name").value;
   
  

    if(!lead_status_name){

        $("#error_lead_status_name").html("Please fill the input feilds");

    }else{
        $("#error_lead_status_name").html("");
    } 
    

    if(lead_status_name){

        document.getElementById('add_l_status').style.pointerEvents = 'none';

        var data = "lead_status_name="+lead_status_name;

        const token = sessionStorage.getItem('token');

        fetch(base_url+"add_lead_status?"+data, {
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
                  
                setTimeout(() => { $("#status_success").html("");window.location.href = "./lead_status";}, 4000);  
                
                

            }else{
                document.getElementById('add_l_status').style.pointerEvents = 'auto';
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


