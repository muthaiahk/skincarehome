<script>

    var app_report = '';
  
    var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);
        appointment(id='',branch_id[1]);
     

        function appointment(id,branch_id,print_enable=false){

            const token = sessionStorage.getItem('token');

            var from_date =   $('#from_date').val();
            var to_date   =    $('#to_date').val();

            let params = new URLSearchParams();
            params.append('from_date', from_date);
            params.append('to_date', to_date);
            params.append('treatment_id', id);
            params.append('branch_id', branch_id);


            fetch(base_url+"appointment_report", {
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
                   // $('#lead_loader').modal('hide');
                    //document.getElementById("company_name").value = sessionStorage.getItem('company');

                    if(data.data){
                        
                        const value = data.data;
                        var htmlString = "";

                        var htmlhead ="<table class='display' id='advance-2'><thead><tr><th>Sl no</th><th>Name</th><th>Problem</th><th>Treament Name</th><th>Attended By</th></tr></thead><tbody>";

                        for(var i = 0; i < value.length  ; i++){

                            
                            var  status = "<span style='color:#ff0018;font-weight: 750;'      class='text-danger'>"+value[i].app_status+"</span>";
                            if(value[i].app_status == '1'){
                                var status = "<span style='color:#ff0018;font-weight: 750;' class='text-success'>"+value[i].app_status+"</span>";
                            }


                            htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].user_name+"(<span class='text-primary'>"+value[i].user_status+"</span>)"+"</td><td>" + value[i].problem +"</td><td>" + value[i].treatment_name+"</td><td>" + value[i].staff_name+"</td></tr>";
                            
                        }

                        var htmlfooter ="</tbody></table>";
                        
                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#appointment_report").html(htmlstringall);

                        app_report = htmlstringall;
                        datatable();
                        
                        
                        
                        if(print_enable){
                            
                            var values = [];
                                //    if(value[i].gender == 1){
                                //             gen = "Male"
                                //    } else{
                                //     gen = "Female"
                                //    }
                            
                            // value.map((data,i)=>{
                            //     values.push({'Sl No':i+1,'Gender':data.gender,'Name':data.user_name,'Type':data.user_status,'Problem':data.problem,'Treament':data.treatment_name,'Attended By':data.staff_name})
                            // })
                            for (var i = 0; i < value.length; i++) {
                                var gen;
                                if (value[i].gender == 1) {
                                    gen = "Male";
                                } else {
                                    gen = "Female";
                                }

                                values.push({
                                    'Sl No': i + 1,
                                    'Gender': gen,
                                    'Name': value[i].user_name,
                                    'Type': value[i].user_status,
                                    'Problem': value[i].problem,
                                    'Treatment': value[i].treatment_name,
                                    'Attended By': value[i].staff_name
                                });
                            }
             

                            var filename='Appointment_reports.xlsx';
                       
                            var ws = XLSX.utils.json_to_sheet(values);
                            var wb = XLSX.utils.book_new();
                            XLSX.utils.book_append_sheet(wb, ws, "People");
                            XLSX.writeFile(wb,filename);
                        }
                                    
                    }
                        

                }else{
                  //  $('#lead_loader').modal('hide');
                }
            });
        }

        // var branch_id = sessionStorage.getItem('branch_id');
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
                            //         if(value == id){ return 'selected';}else{ return '';}
                            //     }
                            function sel_status(value) {
                                // const = branch_id.length == 0
                                // const branc_ids =branch_id;
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
                            
                            var htmlstringall = htmlhead+htmlString;
                            $("#branch_name").html(htmlstringall);
                            
                            // if(sessionStorage.getItem('role') != 1){
                            //     $('#branch_name').prop('disabled', true);
                            //     $('.form-select').css('background-image', '');
                                
                            // }
                                        
                        }
                    

                    }
                });
        }

        $('#treatment_filter').on('click', function() {
           // $('#lead_loader').modal('show');
            var id = document.getElementById("treatment_list").value;
            var branch_id = $('#branch_name').val();
            appointment(id,branch_id);
        });
        
        function app_report_export(){
            var id = document.getElementById("treatment_list").value;
            var branch_id = $('#branch_name').val();
            appointment(id,branch_id,true);
        }

        gettreatmentall();
       
       
        function gettreatmentall(){
            const token = sessionStorage.getItem('token');

            fetch(base_url+"treatment", {
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

                        var htmlhead ="<option value='0'>Select Treatment</option>";

                        for(var i = 0; i < value.length  ; i++){
                           // if(value[i].status == '0'){
                                htmlString += "<option value="+value[i].treatment_id+">"+ value[i].treatment_name + "</option>"
                            //}
                        }
                            
                        var htmlstringall = htmlhead+htmlString;
                        $("#treatment_list").html(htmlstringall);
                                              
                    }
                    
                }
            });
        }

        function datatable(){
            $("#advance-2").DataTable({
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


        function print_report(value){
           
           // alert(value)
            let values;
            switch (value) {
                case 'lead':
                    // var divElements = document.getElementById('lead_report').innerHTML;
                    // //Get the HTML of whole page
                    // var oldPage = document.body.innerHTML;
                    // //Reset the page's HTML with div's HTML only
                    // document.body.innerHTML = 
                    // "<html><head><title></title></head><body>" + 
                    // divElements + "</body>";
                    // //Print Page
                    document.body.innerHTML = lead_report;
                    
                    window.open();
                    window.print();
                    window.close();
                    //Restore orignal HTML
                   
                    break;
                case 'app':
                    document.body.innerHTML = app_report;
                    window.print();
                    break;
                case 'stock':
                    document.body.innerHTML = stock_report;
                    window.print();
                    break;
                case 'atn':
                    document.body.innerHTML = atn_report;
                    window.print();
                    break;
                case 'pay':
                    document.body.innerHTML = pay_report;
                    window.print();
                    break;
                
            }
        }
    }


</script>
