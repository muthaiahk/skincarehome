<script>
        var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{

       var base_url = window.location.origin+'/api/';
getbranchall();

    function getbranchall(){

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
                                if(value[i].status == '0'){
                                    htmlString += "<option value="+value[i].branch_id+">"+ value[i].branch_name + "</option>"
                                }
                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_branch_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#department_branch_list").html(htmlstringall);

                            
                                        
                        }
                    

                    }
                });
    }

    // getstaffall();
    //     function getstaffall(){
    //         const token = sessionStorage.getItem('token');
    //         fetch(base_url+"staff", {
    //             headers: {
    //                 "Content-Type": "application/x-www-form-urlencoded",
    //                 'Authorization': `Bearer ${token}`, // notice the Bearer before your token
    //             },
    //             method: "get",
    //         })
    //         .then((response) => response.json())
    //         .then((data) => {
                
    //             if(data.status == '200'){

    //                 if(data.data){
                            
    //                     const value = data.data;
    //                     var htmlString = "";

    //                     var htmlhead ="<label class='form-label'>Branch Authority</label><select class='form-select' id='dept_incharge'><option value='0'>Select</option>";

    //                     for(var i = 0; i < value.length  ; i++){
    //                         if(value[i].status == '0'){
    //                             htmlString += "<option value='"+value[i].staff_id+"'>"+ value[i].name + "</option>"
    //                         }
    //                     }
    //                     var htmlfooter ="</select><div class='text-danger' id='error_dept_incharge'></div>";  
    //                     var htmlstringall = htmlhead+htmlString+htmlfooter;
    //                     $("#staff_list").html(htmlstringall);
                                    
    //                 }
    //             }
    //         });
    //     }


    all();

    function all(){

        const token = sessionStorage.getItem('token');

        fetch(base_url+"department", {
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

                            var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Company name</th><th>Branch name</th><th>Department Name</th><th>Status</th><th>Action</th></tr></thead><tbody>";

                            for(var i = 0; i < value.length  ; i++){

                            
                                var  status = '';
                                if(value[i].status == '0'){
                                    var status = 'checked';
                                }

                                htmlString += "<tr>"+"<td>" + value[i].company_name + "</td><td>" + value[i].branch_name + "</td><td>" +  value[i].department_name + "</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='dpt_status("+value[i].department_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td><td>" + "<a href='view_dpt?dp_id="+value[i].department_id+"'"+"><i class='fa fa-eye eyc'></i></a><a href='edit_dpt?dp_id="+value[i].department_id+"'"+"><i class='fa fa-edit eyc'></i></a><a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model("+value[i].department_id
                                +")'><i class='fa fa-trash eyc'></i></a>" + "</td>"+"</tr>";
                                
                            }

                            var htmlfooter ="</tbody></table>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#department_list").html(htmlstringall);

                            datatable();

                            
                                        
                        }
                    

                    }
                });
    }

    function dpt_status(id,status){

        if(status == '1'){
            var department_status = 0;
        }else{
            var department_status = 1;
        }
        const token = sessionStorage.getItem('token');
        fetch(base_url+"department_status/"+id+'?status='+department_status, {
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

        $('#department_delete').modal('show');
        delete_id = id;
    }

    $('#delete').click(function(){

        const token = sessionStorage.getItem('token');

        fetch(base_url+"delete_department/"+delete_id, {
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

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Department Successfully Deleted!</div>");
                    
                    setTimeout(() => { $("#status_success").html("");}, 4000);    

                    }
                });
    })



document.getElementById("company_name").value = sessionStorage.getItem('company');


    function add_department() {

        var company_name     = document.getElementById("company_name").value;
        var branch_id        = document.getElementById("branch_name").value;
        var department_name  = document.getElementById("department_name").value;
        var dept_incharge    = null;
        // alert("dept_incharge")

        if(!company_name){

            $("#error_company_name").html("Please fill the input feilds");

        }else{
            $("#error_company_name").html("");
        }

        if(branch_id == '0'){

            $("#error_branch_name").html("Please select branch name");

        }else{
            $("#error_branch_name").html("");
        }
        
        if(!department_name){
            $("#error_department_name").html("Please fill the  input feilds");
        }
        else{
            $("#error_department_name").html("");
        }
        
        // if(!dept_incharge){
        //     $("#error_dept_incharge").html("Please fill the  input feilds");
        
        // }
        // else{

        //     $("#error_dept_incharge").html("");
        // }
        
        


        if(company_name&&branch_id&&department_name){

            document.getElementById('add_depart').style.pointerEvents = 'auto';

            var data = "company_name="+company_name+"&branch_id="+branch_id+"&department_name="+department_name+"&dept_incharge="+dept_incharge;

            const token = sessionStorage.getItem('token');

            fetch(base_url+"add_department?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "post",
                })
            .then((response) => response.json())
            .then((data) => {
                
                if(data.status == '200'){

                    

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Department Successfully Added!</div>");
                    
                    setTimeout(() => { $("#status_success").html("");window.location.href = "./department";document.getElementById('add_depart').style.pointerEvents = 'none';}, 4000);                                 

                }else{
                $("#error_department_name").html(data.error_msg.department_name[0]);
                $("#error_dept_incharge").html(data.error_msg.dept_incharge[0]);
                document.getElementById('add_depart').style.pointerEvents = 'auto';

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


