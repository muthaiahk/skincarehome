<script>
    var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{

        var base_url = window.location.origin+'/api/';
        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);
        all("",branch_id[1]);

        function all(date,branch_id){

            const token = sessionStorage.getItem('token');
            // var date = document.getElementById("attendance").value;
            let params = new URLSearchParams();
            params.append('date', date);
            params.append('branch_id', branch_id);

            fetch(base_url+"attendance", {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "post",
                    body:params
                })
                    .then((response) => response.json())
                    .then((data) => {
                    
                        if(data.status == '200'){

                            
                                if(data.data){
                                    
                                    const value = data.data;

                                    var htmlString = "";

                                    const monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
                                    // const d = new Date();
                                    const d = new Date(value[0].dates[0].date);
                                    var m_name = monthNames[d.getMonth()];

                                    var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Staff Name</th>";

                                    for(var j = 0; j < value[0].dates.length  ; j++){
                                        htmlhead +="<th style='p-5'>"+m_name.slice(0, 3)+"<br/>"+(1+j)+"</th>";
                                    }
                                    
                                    htmlhead +="</tr></thead><tbody>";


                                    // } 
                                    for(var i = 0; i < value.length  ; i++){

                                    
                                        var  status = '';
                                        if(value[i].status == '0'){
                                            var status = 'checked';
                                        }
                                        // if(value[i].status == "P"){
                                        //     var status = "<span class='bg-danger p-1 rounded'>P<span>";
                                        // }

                                        htmlString += "<tr><td>" +[i+1] +"</td><td><div>"+ value[i].staff_name +"</div><div>"+ value[i].designation +"</div></td><td></td>";
                                        
                                        for(var k = 0; k < value[i].dates.length;k++){
                                            var  status = '';
                                            if(value[i].dates[k].status == "P"){
                                                var status = "<span class='bg-success p-1 circle'>P<span>";
                                            }else if(value[i].dates[k].status == "PR"){
                                                var status = "<span class='bg-info p-1 circle'>PR<span>";
                                            }else if(value[i].dates[k].status == "L"){
                                                var status = "<span class='bg-danger p-1 circle'>L<span>";
                                            }else if(value[i].dates[k].status == "W"){
                                                var status = "<span class='bg-primary p-1 circle'>W<span>";
                                            }
                                            
                                            // htmlString +="<td>"+value[i].dates[k].status+"</td>";
                                            htmlString +="<td>"+status+"</td>";
                                        }

                                        htmlString +="</tr>";
                                        
                                    }

                                    var htmlfooter ="</tbody></table>";
                                    
                                    var htmlstringall = htmlhead+htmlString+htmlfooter;
                                    $("#attendance_list").html(htmlstringall);

                                    datatable();

                                }
                        
                        }
                    });



                // fetch(base_url+"mark_attendance", {
                //     headers: {
                //         "Content-Type": "application/x-www-form-urlencoded",
                //         'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                //     },
                //     method: "get",
                //      })
                //     .then((response) => response.json())
                //     .then((data) => {
                    
                //         if(data.status == '200'){

                //             if(data.data){
                                
                //                 const value = data.data;
                //                 var htmlString = "";
                            
                //                 var htmlhead ="<div><table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Staff Name</th><th>Attendance</th></tr></thead><tbody>";
                               
                //                 for(var i = 0; i < value.length  ; i++){

                //                     // if(value[i].status == 0){
                //                     //     htmlString += "<tr><td>" +[i+1] +"</td><td><div>"+ value[i].name +"</div><div>"+ value[i].designation +"</div></td><td>"+"<p class='btn btn-primary' onclick=attendance_model("+value[i].staff_id +")>Mark Attendance</p>"+"</td></tr>";
                //                     // }
                //                     if (value[i].status == 0) {
                //                         htmlString += "<tr><td>" + (i + 1) + "</td><td><div>" + value[i].name + "</div><div>" + value[i].designation + "</div></td><td><div class='row mb-3 m-t-15 custom-radio-ml'>" +
                //                             "<div class='col-lg-3 form-check radio radio-primary'>" +
                //                             "<input class='form-check-input' id='present_"+(i + 1)+"' type='radio' name='radio"+(i + 1)+"' value='present' onclick='att_status();' checked>" +
                //                             "<label class='form-check-label' for='present_"+(i + 1)+"'>Present</label>" +
                //                             "</div>" +
                //                             "<div class='col-lg-3 form-check radio radio-primary'>" +
                //                             "<input class='form-check-input' id='permission_"+(i + 1)+"' type='radio' name='radio"+(i + 1)+"' value='permission' onclick='att_status();'>" +
                //                             "<label class='form-check-label' for='permission_"+(i + 1)+"'>Permission</label>" +
                //                             "</div>" +
                //                             "<div class='col-lg-2 m-l-5 form-check radio radio-primary'>" +
                //                             "<input class='form-check-input' id='leave_"+(i + 1)+"' type='radio' name='radio"+(i + 1)+"' value='leave' onclick='att_status();'>" +
                //                             "<label class='form-check-label' for='leave_"+(i + 1)+"'>Leave</label>" +
                //                             "</div>" +
                //                             "<div class='col-lg-2 m-l-5 form-check radio radio-primary'>" +
                //                             "<input class='form-check-input' id='weekoff_"+(i + 1)+"' type='radio' name='radio"+(i + 1)+"' value='Weekoff' onclick='att_status();'>" +
                //                             "<label class='form-check-label' for='weekoff_"+(i + 1)+"'>Weekoff</label>" +
                //                             "</div>" +
                //                             "</div><div class='row mb-3 m-t-15 custom-radio-ml' id='att_remarks' style='display:none'>" +
                //                             "<div class='col-lg-6 position-relative'>" +
                //                             "<label class='form-label'>Remarks</label>" +
                //                             "<textarea class='form-control' placeholder='Remarks' id='leave_remarks' rows='2'></textarea>" +
                //                             "<div class='valid-tooltip'></div>" +
                //                             "</div>" +
                //                             "</div><input type='hidden' id='staff_count' value='staff_id'/></td></tr>";
                //                     }


                                    
                //                 }
                               

                //                 var htmlfooter ="";
                                
                //                 var htmlstringall = htmlhead+htmlString+htmlfooter;
                //                 $("#attendance_add_list").html(htmlstringall);


                                            
                //             }
                        

                //         }
                //     });

                fetch(base_url + "mark_attendance", {
                                headers: {
                                    "Content-Type": "application/x-www-form-urlencoded",
                                    'Authorization': `Bearer ${token}`,
                                },
                                method: "get",
                            })
                            .then((response) => response.json())
                            .then((data) => {
                                if (data.status == '200') {
                                    if (data.data) {
                                        const value = data.data;
                                        var htmlString = "<div><table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Staff Name</th><th>Attendance</th></tr></thead><tbody>";

                                        for (var i = 0; i < value.length; i++) {
                                            if (value[i].status == 0) {
                                                htmlString += "<tr><td>" + (i + 1) + "</td><td><div>" + value[i].name + "</div><div>" + value[i].designation + "</div></td><td><div class='row mb-3 m-t-15 custom-radio-ml'>" +
                                                    "<div class='col-lg-3 form-check radio radio-primary'>" +
                                                    "<input class='form-check-input' id='present_" + value[i].staff_id + "' type='radio' name='radio" + value[i].staff_id + "' value='present' onclick='att_status();' checked>" +
                                                    "<label class='form-check-label' for='present_" + value[i].staff_id + "'>Present</label>" +
                                                    "</div>" +
                                                    "<div class='col-lg-3 form-check radio radio-primary'>" +
                                                    "<input class='form-check-input' id='permission_" + value[i].staff_id + "' type='radio' name='radio" + value[i].staff_id + "' value='permission' onclick='att_status();'>" +
                                                    "<label class='form-check-label' for='permission_" + value[i].staff_id + "'>Permission</label>" +
                                                    "</div>" +
                                                    "<div class='col-lg-2 m-l-5 form-check radio radio-primary'>" +
                                                    "<input class='form-check-input' id='leave_" + value[i].staff_id + "' type='radio' name='radio" + value[i].staff_id + "' value='leave' onclick='att_status();'>" +
                                                    "<label class='form-check-label' for='leave_" + value[i].staff_id + "'>Leave</label>" +
                                                    "</div>" +
                                                    "<div class='col-lg-2 m-l-5 form-check radio radio-primary'>" +
                                                    "<input class='form-check-input' id='weekoff_" + value[i].staff_id + "' type='radio' name='radio" + value[i].staff_id + "' value='Weekoff' onclick='att_status();'>" +
                                                    "<label class='form-check-label' for='weekoff_" + value[i].staff_id + "'>Weekoff</label>" +
                                                    "</div>" +
                                                    "</div><div class='row mb-3 m-t-15 custom-radio-ml' id='att_remarks' style='display:none'>" +
                                                    "<div class='col-lg-6 position-relative'>" +
                                                    "<label class='form-label'>Remarks</label>" +
                                                    "<textarea class='form-control' placeholder='Remarks' id='leave_remarks_" + value[i].staff_id + "' rows='2'></textarea>" +
                                                    "<div class='valid-tooltip'></div>" +
                                                    "</div>" +
                                                    "</div><input type='hidden' class='staff_id' value='" + value[i].staff_id + "'></td></tr>";
                                            }
                                        }
                                        htmlString += "</tbody></table></div>";
                                        $("#attendance_add_list").html(htmlString);
                                    }
                                }
                            });
            
        }
        
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
                                
                                // function sel_status(value){
                                //     if(value == id){ return 'selected';}else{ return '';}
                                // }
                                function sel_status(value) {
                                
                                    if (value ==branch_id[1] ) {
                                        return 'selected';
                                    } else {
                                        return '';
                                    }
                                }
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

                                if(sessionStorage.getItem('role') != 1){
                                $('#branch_name').prop('disabled', true);
                                $('.form-select').css('background-image', '');
                                
                            }
                                            
                            }
                        

                        }
                    });
        }
        
        $('#attendance_filter').on('click', function() {
           // $('#lead_loader').modal('show');
            var id = document.getElementById("attendance").value;
            var branch_id = $('#branch_name').val();
            all(id,branch_id);
        });
        var staff_id= '';
      
        // function attendance_model(id){
        //     staff_id = id;
           
        //     $('#mark_attendance').modal('show');
        // }

        // function add_attendance() {

           
        //     var present = document.querySelectorAll('input[type=radio][name^=radio][value=present]:checked');
        //     var permission = document.querySelectorAll('input[type=radio][name^=radio][value=permission]:checked');
        //     var leave = document.querySelectorAll('input[type=radio][name^=radio][value=leave]:checked');
        //     var weekoff = document.querySelectorAll('input[type=radio][name^=radio][value=Weekoff]:checked');
        //     // var present       = document.getElementById("present").checked;  
        //     // var permission    = document.getElementById("permission").checked;
        //     // var leave         = document.getElementById("leave").checked;
        //     // var weekoff       = document.getElementById("weekoff").checked;
        //     // var staffId = element.name.replace('radio', '');
        //     // var remarks = document.getElementById('leave_remarks_' + staffId).value;
        //     var remarks       = document.getElementById("leave_remarks").value;
        //     var current_date  = document.getElementById("current_date").value;
            
        //     // // alert("present")
            

        //     var present_val = 0;
        //     var permission_val = 0;
        //     var leave_val = 0;
        //     var weekoff_val = 0;
           
        //     if(present){
        //         present_val = 1;
        //     }else if(permission){
        //         permission_val = 1;
        //     }else if(leave){
        //         leave_val = 1;
        //     }else if(weekoff){
        //         weekoff_val = 1;
        //     }else{
        //         if(present_val == 0 && permission_val == 0 && leave_val == 0  && weekoff_val == 0){
         
                    
        //             $("#error_attendance").html("please select any one")
                    
        //         }
        //     }
            

            

        //     if(present_val == 1 || permission_val == 1 ||  leave_val == 1 ||  weekoff_val == 1){
        //         var data = "present="+present_val+"&permission="+permission_val+"&leave="+leave_val+"&remarks="+remarks+"&weekoff="+weekoff_val+"&staff_id="+staff_id+"&current_date="+current_date;
        //             const token = sessionStorage.getItem('token');

        //             fetch(base_url+"add_attendance?"+data, {
        //                         headers: {
        //                             "Content-Type": "application/x-www-form-urlencoded",
        //                             'Authorization': `Bearer ${token}`, // notice the Bearer before your token
        //                         },
        //                         method: "post",
        //             })
        //             .then((response) => response.json())
        //             .then((data) => {
                        
        //                 if(data.status == '200'){

        //                     $('#mark_attendance').modal('hide');

        //                     $("#status_success").html("<div class='alert alert-success' role='alert'>Attendance Successfully Added!</div>");
                                    
        //                     setTimeout(() => { $("#status_success").html("");all()}, 4000); 
                                    

        //                 }else{
        //                     $("#error_attendance_present").html(data.error_msg.present[0]);
                                
        //                 }
        //             });
        //     }

           
        // }
       // Function to add attendance
        function add_attendance() {
            var presentValues = document.querySelectorAll('input[type=radio][name^=radio][value=present]:checked');
            var permissionValues = document.querySelectorAll('input[type=radio][name^=radio][value=permission]:checked');
            var leaveValues = document.querySelectorAll('input[type=radio][name^=radio][value=leave]:checked');
            var weekoffValues = document.querySelectorAll('input[type=radio][name^=radio][value=Weekoff]:checked');
            var current_date  = document.getElementById("current_date").value;
            var staffAttendanceData = [];

            presentValues.forEach(function(element) {
                var staffId = element.name.replace('radio', '');
                var remarks = document.getElementById('leave_remarks_' + staffId).value;
                staffAttendanceData.push({
                    staff_id: staffId,
                    present: 1,
                    leave: 0,
                    weekoff: 0,
                    permission: 0,
                    remarks: remarks,
                    current_date:current_date
                });
            });

            permissionValues.forEach(function(element) {
                var staffId = element.name.replace('radio', '');
                var remarks = document.getElementById('leave_remarks_' + staffId).value;
                staffAttendanceData.push({
                    staff_id: staffId,
                    present: 0,
                    leave: 0,
                    weekoff: 0,
                    permission: 1,
                    remarks: remarks,
                    current_date:current_date
                });
            });

            leaveValues.forEach(function(element) {
                var staffId = element.name.replace('radio', '');
                var remarks = document.getElementById('leave_remarks_' + staffId).value;
                staffAttendanceData.push({
                    staff_id: staffId,
                    present: 0,
                    leave: 1,
                    weekoff: 0,
                    permission: 0,
                    remarks: remarks,
                    current_date:current_date
                });
            });

            weekoffValues.forEach(function(element) {
                var staffId = element.name.replace('radio', '');
                var remarks = document.getElementById('leave_remarks_' + staffId).value;
                staffAttendanceData.push({
                    staff_id: staffId,
                    present: 0,
                    leave: 0,
                    weekoff: 1,
                    permission: 0,
                    remarks: remarks,
                    current_date:current_date
                });
            });

            const token = sessionStorage.getItem('token');

            fetch(base_url + "add_attendance", {
                    body: JSON.stringify({ att_list: staffAttendanceData }),
                    headers: {
                        "Content-Type": "application/json",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "post",
                    
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        $('#mark_attendance').modal('hide');
                        $("#status_success").html("<div class='alert alert-success' role='alert'>Attendance Successfully Added!</div>");
                        setTimeout(() => {
                            setTimeout(() => {$("#status_success").html(""); window.location.href = "./attendance" ; all("",branch_id[1]);}, 4000); // Refresh the attendance list after adding attendance
                        }, 4000);
                    } else {
                        $("#error_attendance_present").html(data.error_msg.present[0]);
                    }
                });
        }
            

        // function update_month(){

        //     if(staff_id,name,job_id,attendance_status){

        //             var data = "staff_id="+staff_id+"&name="+name+"&job_id="+job_id+"&attendance_status="+attendance_status;

        //             const token = sessionStorage.getItem('token');

        //     fetch(base_url+"update_month/"+id+"?"+data, {
        //                     headers: {
        //                         "Content-Type": "application/x-www-form-urlencoded",
        //                         'Authorization': `Bearer ${token}`, // notice the Bearer before your token
        //                     },
        //                     method: "get",
        //                 })
        //             .then((response) => response.json())
        //             .then((data) => {
                        
        //                 if(data.status == '200'){

        //                     $("#status_success").html("<div class='alert alert-success' role='alert'>Attendance Successfully Updated!</div>");
                        
                            
        //                     setTimeout(() => {$("#status_success").html(""); window.location.href = "./attendance"}, 4000);
                            
                            

        //                 }
        //             });
        // }



        // function table(){
        // 		        $("#att-1").Table({
        // 		          "ordering": false,
        // 		          "responsive": true,
        // 		          "scrollX":false,
                        
        // 		          // "aaSorting":[],
        // 		           "language": {
        // 		            // "lengthMenu": "Show _MENU_",
        // 		           },
        // 		           dom: 'rt',
                        
        // 		          });

        // }


        // function date(){

        // 		        var currentDate = new Date()
        // 				var day = currentDate.getDate()
        // 				var month = currentDate.getMonth() + 1
        // 				var year = currentDate.getFullYear()
        // 				document.write("<b>" + day + "-" + month + "-" + year + "</b>")

        // }
        // function att_status()
        //     {
        //         for(var i = 0; i < value.length  ; i++){


        //             var att_leave= document.getElementById("leave_"+(i + 1)).checked;
        
        //             var att_remarks2 = document.getElementById("att_remarks");
                    
        //             if(att_leave)
        //             {
        //                 att_remarks2.style.display = "block";       
        //             } else 
        //             {
        //                 att_remarks2.style.display = "none";        
        //             }
        //         }
            
        //     }
        function att_status() {
            for (var i = 0; i < value.length; i++) {
                var att_leave = document.getElementById("leave_" + (i + 1)).checked;
                var att_remarks2 = document.getElementById("att_remarks_" + (i + 1));

                if (att_leave) {
                    att_remarks2.style.display = "block";
                } else {
                    att_remarks2.style.display = "none";
                }
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
