<script>

    var atn_report = '';
   

    var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
       var base_url = window.location.origin+'/api/';
        var date = document.getElementById("attendance").value;
        var branch_id = sessionStorage.getItem('branch_id');
        attendance(date,branch_id);
   
        function attendance(date,branch_id,print_enable=false){

            const token = sessionStorage.getItem('token');

            let params = new URLSearchParams();
            params.append('date', date);
            params.append('branch_id', branch_id);
            fetch(base_url+"attendance_report", {
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

                    //$('#lead_loader').modal('hide');

                    //document.getElementById("company_name").value = sessionStorage.getItem('company');

                    if(data.data){
                                
                        const value = data.data;

                        var htmlString = "";

                        const monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];


                        const d = new Date(value[0].dates[0].date);

                        //console.log(new Date(value[0].dates[0].date))

                        var m_name = monthNames[d.getMonth()];

                        var htmlhead ="<table class='display' id='advance-4'><thead><tr><th>Sl no</th><th>Staff ID</th><th>Staff Name</th><th>Designation</th>";

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

                            htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].staff_id +"</td><td>" + value[i].staff_name +"</td><td>" + value[i].designation +"</td>";
                            
                            for(var k = 0; k < value[i].dates.length;k++){
                                htmlString +="<td>"+value[i].dates[k].status+"</td>";
                                
                                  
                            }

                            htmlString +="</tr>";
                            
                         
                            
                            
                        }

                        var htmlfooter ="</tbody></table>";
                        
                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#attendance_report").html(htmlstringall);
                        atn_report = htmlstringall;
                        datatable();
                        
                        
                        if(print_enable){
                            
                            var values = [];
                            value.map((data,i)=>{
                                
                                let obj = [];
                                
                                obj['Sl No'] = i+1;
                                obj['Staff Name'] = data.staff_name;
                                obj['Designation'] = data.designation;
                                
                                
                                data.dates.map((dt)=>{
                                  
                                    obj[dt.date] = dt.status;
                                })
                            
                                values.push(obj)
                               
                            })
                            
                           
             

                            var filename='attendance_reports.xlsx';
                       
                            var ws = XLSX.utils.json_to_sheet(values);
                            var wb = XLSX.utils.book_new();
                            XLSX.utils.book_append_sheet(wb, ws, "People");
                            XLSX.writeFile(wb,filename);
                        }       
                           
                                            
                    }
                }else{
                   // $('#lead_loader').modal('hide');
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

                            function sel_status(value){
                                    if(value == id){ return 'selected';}else{ return '';}
                                }
                            
                            const value = data.data;
                            var htmlString = "";

                            var htmlhead ="<option value='0'>Select Branch</option>";

                            for(var i = 0; i < value.length  ; i++){

                                if(value[i].status == '0'){

                                    htmlString += "<option value='"+value[i].branch_id+"'"+sel_status(value[i].branch_id)+">"+ value[i].branch_name + "</option>";
                                    // htmlString += "<option value="+value[i].branch_id+">"+ value[i].branch_name + "</option>"
                                }
                            }
                            
                            var htmlstringall = htmlhead+htmlString;
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
            attendance(id,branch_id);
        });
        
        function attn_report_export(){
            var id = document.getElementById("attendance").value;
            var branch_id = $('#branch_name').val();
            attendance(id,branch_id,true);
        }
        

        function datatable(){
            $("#advance-4").DataTable({
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
