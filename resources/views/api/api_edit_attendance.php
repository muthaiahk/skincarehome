<script>
     var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);

    getbranchall(branch_id);

    function getbranchall(id){
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
                            
                            function sel_status(value){
                                if(value == id){ return 'selected';}else{ return '';}
                            }
                            // function sel_status(value) {
                            
                            //     if (value ==branch_id[1] ) {
                            //         return 'selected';
                            //     } else {
                            //         return '';
                            //     }
                            // }
                            const value = data.data;
                            var htmlString = "";

                            var htmlhead ="<option value=''>Select Branch</option>";

                            for(var i = 0; i < value.length  ; i++){
                                // if(value[i].status == '0'){
                                //     htmlString += "<option value='"+value[i].branch_id+"'"+sel_status(value[i].branch_id)+">"+ value[i].branch_name + "</option>";

                                //     // htmlString += "<option value="+value[i].branch_id+">"+ value[i].branch_name + "</option>"
                                // }
                                if(sessionStorage.getItem('role') != 1){
                                    if (value[i].status == '0' && branch_id.includes(value[i].branch_id)) {
                                        htmlString += "<option value='" + value[i].branch_id + "'" + sel_status(value[i].branch_id) + ">" + value[i].branch_name + "</option>";
                                    }
                                
                                }else{
                                    if(value[i].status == '0'){

                                        htmlString += "<option value='"+value[i].branch_id+"'"+sel_status(value[i].branch_id)+">"+ value[i].branch_name + "</option>";
                                    
                                    }
                                }
                            }

                            var htmlfooter ="";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#branch_name").html(htmlstringall);

                        //     if(sessionStorage.getItem('role') != 1){
                        //     $('#branch_name').prop('disabled', true);
                        //     $('.form-select').css('background-image', '');
                            
                        // }
                                        
                        }
                    

                    }
                });
    }
    
    //  getstaffall(branch_id);
    function getstaffall(branch_id){

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

                            var htmlhead ="<label class='form-label'>Staff Name</label><select class='form-select' id='staff_name'><option value=''>Select Staff Name</option>";

                            for(var i = 0; i < value.length  ; i++){

                              
                                if (value[i].status == '0' && value[i].branch_id.includes(branch_id)) {
                                    htmlString += "<option value="+value[i].staff_id+">"+ value[i].name + "</option>"
                          
                                }
                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_staff_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#attendance_staff_list").html(htmlstringall);

                            datatable();

                            
                                        
                        }
                    

                    }
                });
    }

    $('#branch_name').change(function(){
        var branch_id = $('#branch_name').val();
        getstaffall(branch_id); // Pass selected staff id and branch id
    });
    

    
    function update_attendance() {

        var staff_id     = document.getElementById("staff_name").value;
        var from_date    = document.getElementById("from_date").value;
        var to_date      = document.getElementById("to_date").value;
        var attendance   = document.getElementById("attendance_status").value;
    

        if(staff_id == '0'){

            $("#error_staff_name").html("Please select staff name");

        }else{
            $("#error_staff_name").html("");
        } 

        
        if(!from_date){

            $("#error_from_date").html("Please select date");

        }else{
            $("#error_from_date").html("");
        } 
        if(!to_date){

            $("#error_to_date").html("Please select date");

        }else{
            $("#error_to_date").html("");
        } 
        if(!attendance){

            $("#error_attendance").html("Please select attendance");

        }else{
            $("#error_attendance").html("");
        } 

        

        // var present       = document.getElementById("present").checked;  
        //     var permission    = document.getElementById("permission").checked;
        //     var leave         = document.getElementById("leave").checked;
        //     var weekoff       = document.getElementById("weekoff").checked;
        //     var remarks       = document.getElementById("leave_remarks").value;
            
            // // alert("present")
            

            var present_val = 0;
            var permission_val = 0;
            var leave_val = 0;
            var weekoff_val = 0;
           
            if(attendance=='present'){
                present_val = 1;
            }else if(attendance=='permission'){
                permission_val = 1;
            }else if(attendance=='leave'){
                leave_val = 1;
            }else if(attendance=='weekoff'){
                weekoff_val = 1;
            }
            

        if(staff_id,from_date,to_date,attendance){
            document.getElementById('update_att').style.pointerEvents = 'none';
            // var id =staff_id;
            var data = "staff_id="+staff_id+"&from_date="+from_date+"&to_date="+to_date+"&present="+present_val+"&permission="+permission_val+"&leave="+leave_val+"&weekoff="+weekoff_val;

            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_attendance/"+id+"?"+data, {
                
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('update_att').style.pointerEvents = 'auto';
                if(data.status == '200'){

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Attendance Successfully Updated!</div>");
                
                    
                    setTimeout(() => {$("#status_success").html(""); window.location.href = "./attendance";document.getElementById('update_att').style.pointerEvents = 'none';}, 4000);
                    
                    

                }else{
                  
                    $("#status_error").html("<div class='alert alert-danger' role='alert'>"+data.error_msg+"</div>");
                    setTimeout(() => { $("#status_error").html("");}, 4000); 
                        
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
