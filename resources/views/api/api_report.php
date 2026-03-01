<script>

    var lead_report = '';
    var app_report = '';
    var stock_report = '';
    var atn_report = '';
    var pay_report = '';


    var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
       var base_url = window.location.origin+'/api/';
        lead(id='');
        appointment(id='');
        inventory(brand_id ='',cat_id='',pro_id='');
        attendance(id='');
        payment(id='');

        function lead(id,print_enable=false){

            const token = sessionStorage.getItem('token');

            
            fetch(base_url+"lead_report?lead_source_id="+id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
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

                            htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].lead_first_name+ value[i].lead_last_name+"</td><td>" + value[i].lead_phone +"<br>"+ value[i].lead_email+"</td><td>" + value[i].lead_source_name+"</td><td>" + value[i].lead_problem+"</td><td>" + value[i].lead_status_name+"</td><td>" + value[i].lead_status_id+"</td><td>" + value[i].lead_phone  +"</td></tr>";
                                    
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

        function appointment(id,print_enable=false){

            fetch(base_url+"appointment_report?treatment_id="+id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
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
                        datatable2();
                        
                        
                        
                        if(print_enable){
                            
                            var values = [];
                            
                            value.map((data,i)=>{
                                values.push({'Sl No':i+1,'Name':data.user_name,'Type':data.user_status,'Problem':data.problem,'Treament':data.treatment_name,'Attended By':data.staff_name})
                            })
             

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

        function inventory(brand_id,cat_id,pro_id,print_enable=false){

            fetch(base_url+"stock_report?brand_id="+brand_id+"&prod_category_id="+cat_id+"&product_id="+pro_id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                    
                if(data.status == '200'){
                    //$('#lead_loader').modal('hide');
                    //document.getElementById("company_name").value = sessionStorage.getItem('company');

                    if(data.data){
                                
                        const value = data.data;
                        var htmlString = "";

                        var htmlhead ="<table class='display' id='advance-3'><thead><tr><th>Sl no</th><th>Brand</th><th>Categories</th><th>Product Name</th><th>Stock</th></tr></thead><tbody>";

                        for(var i = 0; i < value.length  ; i++){


                            htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].brand_name+"</td><td>" + value[i].prod_cat_name +"</td><td>"+ value[i].product_name+"</td><td>" + value[i].stock_in_hand+"</td></tr>";
                                    
                        }

                        var htmlfooter ="</tbody></table>";
                                
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#inventory_report").html(htmlstringall);
                            stock_report = htmlstringall;
                            datatable3();
                            
                            
                            
                            if(print_enable){
                            
                                var values = [];
                                
                                value.map((data,i)=>{
                                    values.push({'Sl No':i+1,'Brand':data.brand_name,'Category':data.prod_cat_name,'Categories':data.lead_email,'Product':data.product_name,'Available Stock':data.stock_in_hand})
                                })
                 
    
                                var filename='stock_reports.xlsx';
                           
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
            
        function attendance(date,print_enable=false){

            
            fetch(base_url+"attendance_report?date="+date, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
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
                        datatable4();
                        
                        
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

        

        function payment(tc_id,t_id='',p_id=2,print_enable=false){
            fetch(base_url+"payment_report?treatment_cat_id="+tc_id+"&treatment_id="+t_id+"&pending="+ p_id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                    
                if(data.status == '200'){
                   // $('#lead_loader').modal('hide');
                    //document.getElementById("company_name").value = sessionStorage.getItem('company');

                    if(data.data){
                                
                        const value = data.data;
                        var htmlString = "";

                        var htmlhead ="<table class='display' id='advance-5'><thead><tr><th>Invoice No</th><th>Date</th><th>Treatment category</th><th>Treatment</th><th>Customer</th><th>Count of Sitting</th><th>Status</th><th>Amount</th><th>Discount</th><th>Paid Amount</th><th>Pending Amount</th><th>Payment Status</th></tr></thead><tbody>";

                        for(var i = 0; i < value.length  ; i++){

                            var  status = '';
                            if(value[i].status == '0'){
                                var status = 'checked';
                            }


                            var  paid_status = "<span class='bg-success p-1 rounded'>Paid<span>";
                            if(value[i].pending > 0){
                                paid_status = "<span class='bg-danger p-1 rounded'>Pending<span>";
                            }



                            htmlString += "<tr>"+"<td>" + value[i].invoice_no + "</td><td>" + value[i].date + "</td><td>" +  value[i].category_name + "</td><td>" +  value[i].treatment_name + "</td><td>"+ value[i].customer_name + "</td><td>"+ value[i].sitting_count + "</td><td>"+ value[i].progress + "</td><td>"+ value[i].amount + "</td><td>"+ value[i].discount + "</td><td>"+ value[i].paid_amount + "</td><td>"+ value[i].pending + "</td><td>"+ paid_status+ "</td></tr>";


                            // <td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='status("+value[i].p_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td><td>" + "<a href='view_payment?pay_id="+value[i].p_id+"'"+"><i class='fa fa-eye eyc'></i></a><a href='edit_payment?pay_id="+value[i].p_id+"'"+"><i class='fa fa-edit eyc'></i></a><a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model("+value[i].p_id +")'><i class='fa fa-trash eyc'></i></a>" + "</td>
                            
                        }

                        var htmlfooter ="</tbody></table>";

                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#payment_report").html(htmlstringall);
                        pay_report = htmlstringall;
                        datatable5();
                        
                        
                        if(print_enable){
                        
                            var values = [];
                            
                            value.map((data,i)=>{
                                values.push({'Sl No':i+1,'Invoice No':data.invoice_no,'Date':data.date,'Treatment Category':data.category_name,'Treatment':data.treatment_name,'Customer':data.customer_name,'Count of Sitting':data.sitting_count,'Status':data.progress,'Amount':data.amount,'Discount':data.discount,'Paid Amount':data.paid_amount,'Pending Amount':data.pending,'Payment Status':data.paid_status})
                            })
             

                            var filename='payment_reports.xlsx';
                       
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

        $('#lead_source_filter').on('click', function() {
           
           // $('#lead_loader').modal('show');
            var id = document.getElementById("lead_source_list").value;
            lead(id);
            
        });
        
        function lead_report_export(){
            var id = document.getElementById("lead_source_list").value;
            lead(id,true);
        }
        
        
        
        
        
        

        $('#treatment_filter').on('click', function() {
           // $('#lead_loader').modal('show');
            var id = document.getElementById("treatment_list").value;
            appointment(id);
        });
        
        function app_report_export(){
            var id = document.getElementById("treatment_list").value;
            appointment(id,true);
        }

        

        $('#product_cat_filter').on('click', function() {
           // $('#lead_loader').modal('show');
            var brand_id = document.getElementById("brand_list").value;
            var cat_id = document.getElementById("product_cat_list").value;
            var pro_id = document.getElementById("product_list").value;
            inventory(brand_id,cat_id,pro_id);
        });
        
        function stock_report_export(){
            var brand_id = document.getElementById("brand_list").value;
            var cat_id = document.getElementById("product_cat_list").value;
            var pro_id = document.getElementById("product_list").value;
            inventory(brand_id,cat_id,pro_id,true);
        }
        
       
        $('#attendance_filter').on('click', function() {
           // $('#lead_loader').modal('show');
            var id = document.getElementById("attendance").value;
            attendance(id);
        });
        
        function attn_report_export(){
             var id = document.getElementById("attendance").value;
            attendance(id,true);
        }
        
        
        $('#treatment_cat_filter').on('click', function() {
           // $('#lead_loader').modal('show');
            var tc_id = document.getElementById("treatment_cat_list").value;
            var t_id = document.getElementById("select_treatment").value;
            var p_id = document.getElementById("paid_status").value;
            payment(tc_id,t_id,p_id);
        });
        
         function payment_report_export(){
            var tc_id = document.getElementById("treatment_cat_list").value;
            var t_id = document.getElementById("select_treatment").value;
            var p_id = document.getElementById("paid_status").value;
            payment(tc_id,t_id,p_id,true);
        }
        
        

        $('#treatment_cat_list').on('click', function() {
            
            var id = document.getElementById("treatment_cat_list").value;
            cattreatmentall(id)


        });

        function cattreatmentall(id=0){



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
                                
                            var value = data.data;
                            var htmlString = "";

                            var htmlhead ="<option value='0'>All</option>";
                            
                            for(var i = 0; i < value.length  ; i++){
                                if(value[i].status == '0'){
                                    htmlString += "<option value="+value[i].treatment_id+">"+ value[i].treatment_name + "</option>"
                                }
                            }


                                
                            var htmlstringall = htmlhead+htmlString;
                        
                            $("#select_treatment").html(htmlstringall);
                                                
                        }
                        
                    }
                });
            

        }
        


        getleadsourceall();
        gettreatmentall();
       
        gettreatmentcatall();


        getbrandall();
        getprodcatall();
        getprodall();

        
        function getbrandall(){
            const token = sessionStorage.getItem('token');

            fetch(base_url+"brand", {
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

                                var htmlhead ="<option value='0'>Select</option>";

                                for(var i = 0; i < value.length  ; i++){
                                    if(value[i].status == '0'){
                                        htmlString += "<option value="+value[i].brand_id+">"+ value[i].brand_name + "</option>"
                                    }
                                }

                                var htmlfooter ="<div class='text-danger' id='error_brand_name'></div>";
                                
                                var htmlstringall = htmlhead+htmlString+htmlfooter;
                                $("#brand_list").html(htmlstringall);

                                

                                
                                            
                            }
                        

                        }
                    });
        }
        function getprodall(){
            const token = sessionStorage.getItem('token');

            fetch(base_url+"product", {
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

                                var htmlhead ="<option value='0'>Select </option>";

                                for(var i = 0; i < value.length  ; i++){
                                    if(value[i].status == '0'){
                                        htmlString += "<option value="+value[i].product_id+">"+ value[i].product_name + "</option>"
                                    }
                                }

                                var htmlfooter ="<div class='text-danger' id='error_product_name'></div>";
                                
                                var htmlstringall = htmlhead+htmlString+htmlfooter;
                                $("#product_list").html(htmlstringall);

                                            
                            }
                        

                        }
                    });
        }
        

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

        function getprodcatall(){
            const token = sessionStorage.getItem('token');

            fetch(base_url+"product_category", {
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

                        var htmlhead ="<label class='form-label'>Product Categories</label><select class='form-select' id='prod_cat_name'><option value='0'>Select </option>";

                        for(var i = 0; i < value.length  ; i++){
                           // if(value[i].status == '0'){
                                htmlString += "<option value="+value[i].prod_cat_id+">"+ value[i].prod_cat_name + "</option>"
                           // }
                        }

                        var htmlfooter ="</select><div class='text-danger' id='error_prod_cat_name'></div>";
                        
                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#product_cat_list").html(htmlstringall);
                                    
                    }
                

                }
            });
        }


        function getprodcatall(){
            const token = sessionStorage.getItem('token');

            fetch(base_url+"product_category", {
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

                        var htmlhead ="<label class='form-label'>Product Categories</label><select class='form-select' id='prod_cat_name'><option value='0'>Select </option>";

                        for(var i = 0; i < value.length  ; i++){
                           // if(value[i].status == '0'){
                                htmlString += "<option value="+value[i].prod_cat_id+">"+ value[i].prod_cat_name + "</option>"
                           // }
                        }

                        var htmlfooter ="</select><div class='text-danger' id='error_prod_cat_name'></div>";
                        
                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#product_cat_list").html(htmlstringall);
                                    
                    }
                

                }
            });
        }
        

        function gettreatmentcatall(){
            const token = sessionStorage.getItem('token');

            fetch(base_url+"treatment_cat", {
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

                        var htmlhead ="<label class='form-label'>Categories</label><select class='form-select' id='tc_name'><option value='0'>All</option>";

                        for(var i = 0; i < value.length  ; i++){

                            htmlString += "<option value="+value[i].tcategory_id+">"+ value[i].tc_name + "</option>"
                    
                        }

                        var htmlfooter ="</select><div class='text-danger' id='error_tc_name'></div>";
                        
                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#treatment_cat_list").html(htmlstringall);                           
                                    
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

        function datatable2(){
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

        function datatable3(){
            $("#advance-3").DataTable({
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

        function datatable4(){
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

        function datatable5(){
            $("#advance-5").DataTable({
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
