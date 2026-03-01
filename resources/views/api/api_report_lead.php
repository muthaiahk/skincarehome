<script>

    var lead_report = '';

    var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{

       var base_url = window.location.origin+'/api/';
        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);
        lead(id='',branch_id[1]);
   

        function lead(id,branch_id,print_enable=false){

            const token = sessionStorage.getItem('token');
            
            var from_date =   $('#from_date').val();
            var to_date   =    $('#to_date').val();
           

            let params = new URLSearchParams();

            params.append('from_date', from_date);
            params.append('to_date', to_date);
            params.append('lead_source_id', id);
            params.append('branch_id', branch_id);

            
            fetch(base_url+"lead_report", {
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
                    
                  //  $('#lead_loader').modal('hide');
                    //document.getElementById("company_name").value = sessionStorage.getItem('company');

                    if(data.data){
                                
                        const value = data.data;
                        var htmlString = "";

                        var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Name</th><th>Contact Details</th><th>Lead Source</th><th>Problem</th><th>Lead Status</th><th>Flw Up Count</th><th>Next Flw Up Date</tr></thead><tbody>";

                        for(var i = 0; i < value.length  ; i++){

                                
                            var  status = '';
                            if(value[i].status == '0'){
                                    var status = 'checked';
                            }
                            var date = new Date(value[i].next_followup_date);
                            var day = date.getDate().toString().padStart(2, '0'); 
                            var month = (date.getMonth() + 1).toString().padStart(2, '0'); 
                            var year = date.getFullYear().toString(); 

                            var nextDate = day+'-' + month+'-' + year;
                            htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].lead_first_name+ value[i].lead_last_name+"</td><td>" + value[i].lead_phone +"<br>"+ value[i].lead_email+"</td><td>" + value[i].lead_source_name+"</td><td>" + value[i].lead_problem+"</td><td>" + value[i].lead_status_name+"</td><td>" + value[i].lead_status_id+"</td><td>" + nextDate  +"</td></tr>";
                                    
                        }

                        var htmlfooter ="</tbody></table>";
                                
                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#lead_report").html(htmlstringall);
                        lead_report = htmlstringall;

                        datatable();
                        
                        
                        if(print_enable){
                            
                            var values = [];
                            
                            value.map((data,i)=>{
                                values.push({'Sl No':i+1,'Name':data.lead_first_name+data.lead_last_name,'Phone':data.lead_phone,'Email':data.lead_email,'Source':data.lead_source_name,'Problem':data.lead_problem})
                            })
             

                            var filename='lead_reports.xlsx';
                       
                            var ws = XLSX.utils.json_to_sheet(values);
                            var wb = XLSX.utils.book_new();
                            XLSX.utils.book_append_sheet(wb, ws, "People");
                            XLSX.writeFile(wb,filename);
                        }
                                            
                    }
                        

                }else{
                    //$('#lead_loader').modal('hide');
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

        $('#lead_source_filter').on('click', function() {
           
           // $('#lead_loader').modal('show');
            var id = document.getElementById("lead_source_list").value;
            var branch_id = $('#branch_name').val();
            lead(id,branch_id);
            
        });
        
        function lead_report_export(){
            var id = document.getElementById("lead_source_list").value;
            var branch_id = $('#branch_name').val();
            lead(id,branch_id,true);
        }
        
        
        
        var from_date = "<?php echo date('Y-m-d'); ?>";
        var to_date   =  "<?php echo date('Y-m-d'); ?>";

        
        getleadsourceall();
      
        function getleadsourceall(){

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

                            var htmlhead ="<option value='0'>Select Lead Source name</option>";

                            for(var i = 0; i < value.length  ; i++){
                               // if(value[i].status == '0'){
                                    htmlString += "<option value="+value[i].lead_source_id+">"+ value[i].lead_source_name + "</option>"
                                //
                            }
                                
                            var htmlstringall = htmlhead+htmlString;
                            $("#lead_source_list").html(htmlstringall);
                                
                                            
                        }
                        

                    }
                });
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
