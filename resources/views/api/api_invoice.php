<script>
    var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
        var tc_id = 0;
        var total_amount = 0;
        var permission = '';
        var arr_chebox = [];
       
        permission_page("invoice");
        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);
        

       // treatment_list();
        //all();
        // function all(){

        //     const token = sessionStorage.getItem('token');

        //     fetch(base_url+"customer_treatment_invoice", {
        //             headers: {
        //                 "Content-Type": "application/x-www-form-urlencoded",
        //                 'Authorization': `Bearer ${token}`, // notice the Bearer before your token
        //             },
        //             method: "get",
        //         })
        //             .then((response) => response.json())
        //             .then((data) => {
                    
        //                 if(data.status == '200'){

        //                     //document.getElementById("company_name").value = sessionStorage.getItem('company');

        //                     if(data.data){
                                
        //                         const value = data.data;
        //                         var htmlString = "";

        //                         var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Customer Name</th><th>Treatment Categories</th><th>Treatment Name</th><th>Status</th><th>Amount</th><th>Action</th></tr></thead><tbody>";

        //                         for(var i = 0; i < value.length  ; i++){


        //                             var treatments = value[i].treament;

        //                             var tmt_val = "";
                                    
        //                             //treatments.map(getFullName);

        //                             // function getFullName(item) {
        //                             //     return [item.firstname,item.lastname].join(" ");
        //                             // }
                                    
        //                             treatments.map((item)=>{
        //                                 tmt_val += '<p>'+item.treatment_name+'-'+item.amount+'</p>';


        //                             });
                                    
                                    
                                    
        //                             var status = "<span class='text-success'>completed</span>";
                                    

                                                                    
        //                             var  invoioce = "<a href='#' data-bs-toggle='modal' data-toggle='tooltip' data-placement='bottom' title='invoice' data-bs-target='' onclick='invoice_print("+value[i].p_id +")'><i class='fa fa-file-text-o'></i></a>";
                                   

        //                             var action = "";

        //                             if(permission){
                                        

        //                                 var cama=stringHasTheWhiteSpaceOrNot(permission);
        //                                 if(cama){
        //                                     var values = permission.split(",");
        //                                     if(values.length > 0){
        //                                         var add    = include(values, 'add'); // true
        //                                         var edit   = include(values, 'edit'); // true
        //                                         var view   = include(values, 'view'); // true
        //                                         var del    = include(values, 'delete'); // true

        //                                         if(add){ 
        //                                             action += "";}
        //                                         else{
        //                                             action += "";$( "#add_treatment" ).hide();}
        //                                         if(edit){  
        //                                             action += "<a href='edit_t_management?tm_id="+value[i].cus_treat_id+"'"+"><i class='fa fa-edit eyc'></i></a>";}
        //                                         else{
        //                                             action += "";}
        //                                         if(view){  
        //                                             action += "<a href='view_t_management?tm_id="+value[i].cus_treat_id+"'"+"><i class='fa fa-eye eyc'></i></a>";}
        //                                         else{
        //                                             action += "";}
        //                                         if(del){  
        //                                             action += "<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model("+value[i].cus_treat_id +")'><i class='fa fa-trash eyc'></i></a>";}
        //                                         else{
        //                                             action += "";}
        //                                     }
                                        
        //                                     function include(arr, obj) {
        //                                         for (var i = 0; i < arr.length; i++) {
        //                                             if (arr[i] == obj) return true;
        //                                         }
        //                                     }

        //                                 } else {

        //                                     if(permission){
        //                                         $data += "";
        //                                     }else{
        //                                         $data += "";
        //                                     }
        //                                 }

        //                                 function stringHasTheWhiteSpaceOrNot(value){
        //                                     return value.indexOf(',') >= 0;
        //                                 }

        //                             }else{
        //                                 action = '';
        //                             }

        //                             var total = value[i].amount+value[i].discount;

        //                             htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].customer_name+"</td><td>" + value[i].tc_name +"</td><td>" + tmt_val+"</td><td>" + status +"</td><td>"+value[i].total_amount+"</td><td>"+invoioce+ "</td></tr>";
                                    
        //                         }

        //                         var htmlfooter ="</tbody></table>";
                                
        //                         var htmlstringall = htmlhead+htmlString+htmlfooter;
        //                         $("#treatment_management_list").html(htmlstringall);

        //                         datatable();
                                            
        //                     }
                        

        //                 }
        //             });
        // }
       
          customer_list(branch_id);
        function customer_list(branch_id){

            let params = new URLSearchParams();

            params.append('branch_id', branch_id);
            fetch(base_url+"customer_list", {
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

                        var htmlhead ="<option value='0'>Select customer name</option>";
                        console.log(value);
                        for(var i = 0; i < value.length  ; i++){

                            if(branch_id == value[i].branch_id){

                                htmlString += "<option value="+value[i].customer_id+">"+ value[i].customer_first_name + "</option>"
                            }
                             
                        }
                                
                        var htmlstringall = htmlhead+htmlString;
                        $("#customer_name").html(htmlstringall);
                                        
                    }
                }
            });
        }
        getbrandall();

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

                                var htmlhead ="<label class='form-label'>Brand</label><select class='form-select' id='brand_name' onchange='getcat(event);'><option value='0'>Select Brand</option>";

                                for(var i = 0; i < value.length  ; i++){

                                    htmlString += "<option value="+value[i].brand_id+">"+ value[i].brand_name + "</option>"
                            
                                }

                                var htmlfooter ="</select><div class='text-danger' id='error_brand_name'></div>";
                                
                                var htmlstringall = htmlhead+htmlString+htmlfooter;
                                $("#product_brand_list").html(htmlstringall);
                
                            }
                        

                        }
                    });
        }
        // var branch_id = sessionStorage.getItem('branch_id');
        getbranchall(branch_id);

        function getbranchall(branch_id){

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


        $( "#customer_name" ).change(function() {
            var id = $(this).val();
            
            treatment_list(id);
            arr_chebox = [];
            invoice_list(id);
        });



        $( "#branch_name" ).change(function() {
            var branch_id = $('#branch_name').val();

            customer_list(branch_id);
            // var branch_id = $('#branch_name').val();
            // treatment_list(branch_id);
            // arr_chebox = [];
            // invoice_list(branch_id);
        });

        function treatment_list(id){

            const token = sessionStorage.getItem('token');

            fetch(base_url+"customer_treatment_invoice/"+id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
                    .then((response) => response.json())
                    .then((data) => {
                    
                        if(data.status == '200'){

                            //document.getElementById("company_name").value = sessionStorage.getItem('company');

                            if(data.data){
                                
                                const value = data.data;
                                var htmlString = "";

                                var htmlhead ="";


                                for(var i = 0; i < value.length  ; i++){

                                    if( value[i].balance == 0  ){


                                        // var treatments = value[i].treament;

                                        // var tmt_val = "";
                                        
                                    
                                        
                                        // treatments.map((item)=>{
                                        //     tmt_val += '<p>'+item.treatment_name+'-'+item.amount+'</p>';


                                        // });
                                        
                                        
                                        
                                        // var status = "<span class='text-success'>completed</span>";
                                        

                                                                        
                                        // var  invoioce = "<a href='#' data-bs-toggle='modal' data-toggle='tooltip' data-placement='bottom' title='invoice' data-bs-target='' onclick='invoice_print("+value[i].p_id +")'><i class='fa fa-file-text-o'></i></a>";
                                    

                                        var action = "";

                                        if(permission){
                                            

                                            var cama=stringHasTheWhiteSpaceOrNot(permission);
                                            if(cama){
                                                var values = permission.split(",");
                                                if(values.length > 0){
                                                    var add    = include(values, 'add'); // true
                                                    var edit   = include(values, 'edit'); // true
                                                    var view   = include(values, 'view'); // true
                                                    var del    = include(values, 'delete'); // true

                                                    if(add){ 
                                                        action += "";}
                                                    else{
                                                        action += "";$( "#add_treatment" ).hide();}
                                                    if(edit){  
                                                        action += "<a href='edit_t_management?tm_id="+value[i].cus_treat_id+"'"+"><i class='fa fa-edit eyc'></i></a>";}
                                                    else{
                                                        action += "";}
                                                    if(view){  
                                                        action += "<a href='view_t_management?tm_id="+value[i].cus_treat_id+"'"+"><i class='fa fa-eye eyc'></i></a>";}
                                                    else{
                                                        action += "";}
                                                    if(del){  
                                                        action += "<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model("+value[i].cus_treat_id +")'><i class='fa fa-trash eyc'></i></a>";}
                                                    else{
                                                        action += "";}
                                                }
                                            
                                                function include(arr, obj) {
                                                    for (var i = 0; i < arr.length; i++) {
                                                        if (arr[i] == obj) return true;
                                                    }
                                                }

                                            } else {

                                                if(permission){
                                                    $data += "";
                                                }else{
                                                    $data += "";
                                                }
                                            }

                                            function stringHasTheWhiteSpaceOrNot(value){
                                                return value.indexOf(',') >= 0;
                                            }

                                        }else{
                                            action = '';
                                        }

                                        var checked = "<div class='custom-control custom-checkbox'><input type='checkbox' class='custom-control-input chk_status'  onclick='select_invoice("+value[i].cus_treat_id +")' ></div>";

                                        htmlString += "<tr><td>" +checked+"</td><td>" + value[i].treatment_name +"</td><td>" + value[i].amount+"</td></tr>";
                                    
                                    }

                                        var htmlfooter ="<tr><td></td><td></td><td><p class='btn btn-primary' id='invoice_generate' onclick='invoice_generate();' type='text'>Generate</p></td></tr>";
                                        
                                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                                        $("#treatment_management_list").html(htmlstringall);

                                        datatable();
                                            
                                }
                            }

                        }
                });
        }

       

        function select_invoice(id){

            var chk = arr_chebox.includes(id);
          

            if(chk){
                for( var i = 0; i < arr_chebox.length; i++){ 
    
                    if ( arr_chebox[i] === id) { 

                        arr_chebox.splice(i, 1); 
                    }

                }

            }else{
                arr_chebox.push(id);
            }
          
           
        }

        function invoice_generate(){
            var scl = arr_chebox.length;
            if(scl == 0){

               $("#status_success").html("<div class='alert alert-danger' role='alert'>Please Select Treatment!</div>");
                    
                setTimeout(() => { $("#status_success").html("");all();}, 2000);

            }else{
                var id = $( "#customer_name" ).val();

                invoice_print(id);

                // setTimeout(() => {$("#status_success").html(""); invoice_list(id);}, 2000); 



               
              
            }

            
        }


        function invoice_print(id){

            if(arr_chebox.length < 5){

        
                const token = sessionStorage.getItem('token');
                fetch(base_url+"invoice?c_id="+id+"&treatment_id="+arr_chebox, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                        },
                        method: "post",
                })
                .then((response) => response.json())
                .then((data) => {
                   
                if(data.status == '200'){
                   
                    var treatments = data.data;

                    var name       = data.customer.customer_first_name+" "+data.customer.customer_last_name;
                    var address    = data.customer.customer_address;
                    var phone      = data.customer.customer_phone;
                    var email      = data.customer.customer_email;
                    var date       =  "<?php echo date('d-m-Y'); ?>";
                    var p_mode     = "";
                    var invoice_no = data.invoice_no;
                    
                    var branch_address = data.branch.branch_location;
                    var branch_phone  = data.branch.branch_phone;
                    var branch_email   = data.branch.branch_email;
                   

                    var html_treatment ="";
                    var total_amount = 0;

                    var div1 = "";
                    var div2 = "";
                    var div3 = "";
                    var div4 = "";
                    var div5 = "";
                    var div6 = "";
                    var div7 = "";
                    var div8 = "";
                    var div9 = "";
                    var div10 = "";
                    var div11 = "";
                    console.log(data)
                   
                    var state_id =data.customer.state_id;

                    treatments.map((item,i)=>{

                      

                      
                        // if(state_id==23){
                        //     var cgst = ((item.amount-item.discount)*9/100);
                        //     var sgst = ((item.amount-item.discount)*9/100);
                        // }else{
                        //     var igst = ((item.amount-item.discount)*18/100);
                        
                        // }
                        // total_amount = total_amount+(item.amount-item.discount);
                        if(state_id==23){
                            var cgst = ((item.amount-item.discount_amount)*9/100);
                            var sgst = ((item.amount-item.discount_amount)*9/100);
                        }else{
                            var igst = ((item.amount-item.discount_amount)*18/100);
                        
                        }
                total_amount = total_amount+(item.amount-item.discount_amount);
                        div1 +="<p style='padding:0px;margin:0px;text-align: center;padding-top:10px;height: 30px;'>"+(i+1)+"</p>";
                        div2 +="<p style='padding:0px;margin:0px;padding-left: 5px;padding-top:10px;height: 30px;'>"+item.treatment_name+"</p>";
                        div3 +="<p style='padding:0px;margin:0px;padding-top:10px;height: 30px;'></p>";
                        div4 +="<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;padding-top:10px;height: 30px;'>1 No</p>";
                        div5 +="<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;padding-top:10px;height: 30px;'>"+item.amount+".00</p>";
                        div6 +="<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;padding-top:10px;height: 30px;'>"+item.discount_amount+"</p>";
                        div7 +="<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;padding-top:10px;height: 30px;'>"+item.amount+".00</p>";
                        div8 +="<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;padding-top:10px;height: 30px;'>"+cgst+"</p>";
                        div9 +="<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;padding-top:10px;height: 30px;'>"+sgst+"</p>";
                        div10 +="<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;padding-top:10px;height: 30px;'>"+igst+"</p>";
                        div11 +="<p style='padding:0px;margin:0px;text-align:right;padding-top:10px;height: 30px;'>"+(item.amount-item.discount)+".00</p>";

                    });


                    var gst_div_html ='';

                    if(state_id==23){
                        gst_div_html="<div style='width: 5%;float: left;border-right:1px solid;height:316px;'>"+div8+"</div><div style='width: 5%;float: left;border-right:1px solid;height:316px;'>"+div9+"</div>";
                    }else{
                        gst_div_html="<div style='width: 5%;float: left;border-right:1px solid;height:316px;'>"+div10+"</div>";
                    
                    }

                       



                    html_treatment += "<div style='width: 3%;float: left;border-right:1px solid;height:316px;'>"+div1+"</div><div style='width: 30%;float: left;border-right:1px solid;height:316px;'>"+div2+"</div><div style='width: 5%;float: left;border-right:1px solid;height:316px;'>"+div3+"</div><div style='width: 5%;float: left;border-right:1px solid;height:316px;'>"+div4+"</div><div style='width: 10%;float: left;border-right:1px solid;height:316px;'>"+div5+"</div><div style='width: 10%;float: left;border-right:1px solid;height:316px;'>"+div6+"</div><div style='width: 10%;float: left;border-right:1px solid;height:316px;'>"+div7+"</div>"+gst_div_html+"<div style='width: 10%;float: left;height:316px;'>"+div11+"</div>";
                        
                    var amount_words = "";

                    update(total_amount);

                    var newWin=window.open('','Print-Window');

                    newWin.document.open();

                    var gst_div ='';

                    if(state_id==23){
                        gst_div="<div style='width: 5%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>CGST %</b></div><div style='width: 5%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>SGST %</b></div>";
                    }else{
                        gst_div="<div style='width: 5%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>IGST %</b></div>";
                    
                    }

     
                    var html_content ="<!DOCTYPE html><html><head><title>Invoice</title></head><body style='width:95%;margin:auto;font-family: sans-serif;font-size: 12px;'><h1 style='padding:0px;margin:0px;text-align:center;font-size:20px;'>Tax Invoice</h1><div style='border:1px solid;height:739pt;'><div style='width:100%;height:220pt;'><div style='width:65%;float:left;padding:0px;margin:0px;border-right:1px solid;height:220pt;box-sizing: border-box;'><div style='width:100%;padding:0px;margin:0px;border-bottom: 1px solid;height:80pt;padding-top: 10px;;'><div style='width:25%;float:left;padding-left:5px;box-sizing: border-box;'><img src='https://crm.renewhairandskincare.com/renew_api/public/logo/22626.png' height='100px' width='100px;'/></div><div style='width:75%;float:left;text-align: left;'><h1 style='padding:0px;margin:0px;'>Renew+ Hair and Skin Care</h1><p style='padding:0px;margin:0px;padding-top:10px;'>"+branch_address+"<br>Mobile No: +91"+branch_phone+"<br> Email : "+branch_email+"<br>CIN : </p></div></div><div style='width:100%;padding:0px;margin:0px;padding-left:10px;box-sizing: border-box;'><p> <b>Bill to:</b><p><p style='padding:0px;margin:0px;padding-top:5px;'>"+name+"</p><p style='padding:0px;margin:0px;padding-top:5px;'><span>"+address+"</span></p><p style='padding:0px;margin:0px;padding-top:5px;padding-bottom: 5px;'>Mobile : "+phone+"</p><p style='padding-top: 40px;'><span style='padding-top: 15px;'>GSTIN:</span><span style='float: right;padding-right:10px;'>St.Code: <b>33</b></span></p></div></div><div style='width:35%;float:left;padding:0px;margin:0px;box-sizing: border-box;'><div style='width:100%;padding:0px;margin:0px;height:162pt;'><div style='width:50%;float:left;padding:0px;margin:0px;font-size: 10px;'><p style=' border-bottom: 1px solid;border-right: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Invoice No.<br><b>"+invoice_no+"</b></p><p style=' border-bottom: 1px solid;border-right: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Delivery Note</p><p style=' border-bottom: 1px solid;border-right: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Supplier's Ref.</p><p style=' border-bottom: 1px solid;border-right: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Buyer Order No</p><p style=' border-bottom: 1px solid;border-right: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Document No</p><p style=' border-bottom: 1px solid;border-right: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Dispatched Through</p></div><div style='width:50%;float:left;padding:0px;margin:0px;font-size: 10px;'><p style='border-bottom: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Dated<br><b>"+date+"</b></p><p style='border-bottom: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Mode/Terms of Payment</p><p style=' border-bottom: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Other Reference(s)</p><p style=' border-bottom: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Dated</p><p style=' border-bottom: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Delivery Note Date</p><p style=' border-bottom: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Destination</p></div></div><div style='width:100%;pad:0px;margin:0px;'><p style='padding-left:5px;padding-top:0px;'>Terms Of Delivery</p></div></div></div><div style='width:100%;border-top:1px solid;border-bottom:1px solid;height:275pt;'><div style='height:50px;border-bottom:1px solid;text-align: center;font-size: 11px;;'><div style='width: 3%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>Sl No.</b></div><div style='width: 30%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>Product Name & Description</b></div><div style='width: 5%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>HSN / SAC</b></div><div style='width: 5%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>Qty,</b></div><div style='width: 10%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>Rate</b></div><div style='width: 10%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>Disc. Amt.</b></div><div style='width: 10%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>Taxable Amt.</b></div>"+gst_div+"<div style='width: 10%;float: left;height:40px;padding-top: 10px;'><b>Amount</b></div></div><div style='height:316px;'>"+html_treatment+"</div><div style='height:26px;border-bottom: 1px solid;'><div style='width: 3%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align: center;'></p></div><div style='width: 30%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;padding-left: 5px;'></p></div><div style='width: 5%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;'></p></div><div style='width: 5%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div><div style='width: 10%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div>      <div style='width: 10%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div><div style='width: 10%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div><div style='width: 5%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div>        <div style='width: 5%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div><div style='width: 5%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'>Total</p></div><div style='width: 10%;float: left;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;'>"+total_amount+".00</p></div></div></div><div style='width:100%;height:15pt;border-bottom: 1px solid;padding-top:5px;margin-top: 19pt;'><p style='margin:0px;padding:0px;padding-left:5px;'><b>Amount In Word : </b><span>Rupees "+amount_words+" Only</span></p> </div><div style='height:50px;border-bottom: 1px solid;box-sizing: border-box;text-align:center;'><div style='width: 50%;float: left;height:40px;padding-top: 10px;border-right:1px solid;'><p style='padding:0px;margin:0px;text-align: center;'></p></div> <div style='width: 10%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><p style='padding:0px;margin:0px;padding-left: 5px;'>Taxable <br>Value</p></div><div style='width: 15%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><p style='padding:0px;margin:0px;border-bottom:1px solid;'>Central Tax</p>    <div style='width:100%;padding:0px;margin:0px;height:18pt;'><div style='width:50%;margin:0px;padding:0px;float:left;border-right:1px solid;box-sizing: border-box;height:18pt;padding-top:5px;'>Rate</div><div style='width:50%;margin:0px;padding:0px;float:left;box-sizing: border-box;height:18pt;padding-top:5px;'>Amount</div></div></div><div style='width: 15%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:center;padding-right: 5px;border-bottom:1px solid;'>State Tax</p><div style='width:100%;padding:0px;margin:0px;height:18pt;'><div style='width:50%;margin:0px;padding:0px;float:left;border-right:1px solid;box-sizing: border-box;height:18pt;padding-top:5px;'>Rate</div>  <div style='width:50%;margin:0px;padding:0px;float:left;box-sizing: border-box;height:18pt;padding-top:5px;'>Amount</div></div></div><div style='width: 9%;float: left;height:40px;padding-top: 6px;'>Total<br>Tax Amount<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div></div><div style='height:30px;border-bottom: 1px solid;box-sizing: border-box;text-align:center;'><div style='width: 50%;float: left;height:20px;padding-top: 10px;border-right:1px solid;'><p style='padding:0px;margin:0px;text-align: right;padding-right:10px;'>Total</p></div><div style='width: 10%;float: left;border-right:1px solid;height:20px;padding-top: 10px;'><p style='padding:0px;margin:0px;padding-left: 5px;'>"+(total_amount-(total_amount*18/100))+".00</p></div><div style='width: 15%;float: left;border-right:1px solid;height:30px;padding-top: 0px;'><div style='width:100%;padding:0px;margin:0px;height:18pt;'><div style='width:50%;margin:0px;padding:0px;float:left;border-right:1px solid;box-sizing: border-box;height:22pt;padding-top:8px;'>9%</div><div style='width:50%;margin:0px;padding:0px;float:left;box-sizing: border-box;height:22pt;padding-top:8px;'>"+(total_amount*9/100)+".00</div></div></div><div style='width: 15%;float: left;border-right:1px solid;height:30px;padding-top: 0px;'><div style='width:100%;padding:0px;margin:0px;height:18pt;'><div style='width:50%;margin:0px;padding:0px;float:left;border-right:1px solid;box-sizing: border-box;height:22pt;padding-top:8px;'>9%</div><div style='width:50%;margin:0px;padding:0px;float:left;box-sizing: border-box;height:22pt;padding-top:8px;'>"+(total_amount*9/100)+".00</div></div></div><div style='width: 9%;float: left;height:20px;padding-top: 8px;'>"+total_amount+".00<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div></div><div style='width:100%;padding:0px;margin:0px;'><div style='width:50%;padding:0px;margin:0px;float:left;box-sizing: border-box;padding-left:10px;padding-top:85px;'><p style='padding:0px;margin:0px;text-decoration-line: underline;padding-bottom: 8px;padding-top:5px;font-size: 13px;'>Terms & Condition :-</p><p style='padding:0px;margin:0px;font-size: 13px;'>1. Subject to Your City Jurisdiction.</p><p style='padding:0px;margin:0px;font-size: 13px;'>2. No liability accepted for any breakage.</p><p style='padding:0px;margin:0px;font-size: 13px;'>3. Goods once sold will not be taken back or exchange</p><p style='padding:0px;margin:0px;font-size: 13px;'>4. Any warranty claim will not be accepted without warranty card. E & O.E.</p></div><div style='width:50%;padding:0px;margin:0px;float:left;box-sizing: border-box;padding-top:19px;'><p style='font-size: 15px;padding:0px 0px 0px 100px;margin:0px'><b>Company's Bank Details:</b></p><p style='padding: 5px 0px 0px 100px;margin:0px;'><span style='padding-right:15px;'>Bank Name :</span> <span>CUB</span></p><p style='padding: 5px 0px 0px 100px;margin:0px;'><span style='padding-right:15px;'>Account No :</span> <span>51090901064714</span></p><p style='padding: 5px 0px 0px 100px;margin:0px;'><span style='padding-right:5px;'>Branch Name : </span> <span>Mannivakkam</span></p>       <p style='padding: 5px 0px 8px 100px;margin:0px;'><span style='padding-right:8px;'>Branch Code :</span>  <span>CIUB0000483</span></p><div style='margin:0px;padding:0px;border-left:1px solid;border-top:1px solid;height:53pt'><p style='padding:0px;margin:0px;text-align:right;padding-right:15px;padding-top:5px;font-size: 10px;'><b>For Renew+ Skin and Care</b></p><p style='text-align:right;padding-right:17px;padding-top:30px;'><b>Authorised Signatory</b></p></div></div></div></div></body></html>";

                    newWin.document.write(html_content);

                    newWin.document.close();
                    
                    $("#status_success").html("<div class='alert alert-success' role='alert'>Invoice Generate Successfully !</div>");
                        
                    setTimeout(() => { $("#status_success").html("");window.location.href = "./invoice";;}, 2000); 
                   
                    
                    

                        function update(amount){
                            var bigNumArry = new Array('', ' thousand', ' million', ' billion', ' trillion', ' quadrillion', ' quintillion');

                            var output = '';
                            var numString =   amount.toString();
                            var finlOutPut = new Array();

                            if (numString == '0') {
                            alert('Zero');
                                return;
                            }

                            if (numString == 0) {
                                alert('messeg tell to enter numbers');
                                return;
                            }

                            var i = numString.length;
                            i = i - 1;

                            //cut the number to grups of three digits and add them to the Arry
                            while (numString.length > 3) {
                                var triDig = new Array(3);
                                triDig[2] = numString.charAt(numString.length - 1);
                                triDig[1] = numString.charAt(numString.length - 2);
                                triDig[0] = numString.charAt(numString.length - 3);

                                var varToAdd = triDig[0] + triDig[1] + triDig[2];
                                finlOutPut.push(varToAdd);
                                i--;
                                numString = numString.substring(0, numString.length - 3);
                            }
                            finlOutPut.push(numString);
                            finlOutPut.reverse();

                            //conver each grup of three digits to english word
                            //if all digits are zero the triConvert
                            //function return the string "dontAddBigSufix"
                            for (j = 0; j < finlOutPut.length; j++) {
                                finlOutPut[j] = triConvert(parseInt(finlOutPut[j]));
                            }

                            var bigScalCntr = 0; //this int mark the million billion trillion... Arry

                            for (b = finlOutPut.length - 1; b >= 0; b--) {
                                if (finlOutPut[b] != "dontAddBigSufix") {
                                    finlOutPut[b] = finlOutPut[b] + bigNumArry[bigScalCntr] + ' , ';
                                    bigScalCntr++;
                                }
                                else {
                                    //replace the string at finlOP[b] from "dontAddBigSufix" to empty String.
                                    finlOutPut[b] = ' ';
                                    bigScalCntr++; //advance the counter  
                                }
                            }

                                //convert The output Arry to , more printable string 
                                for(n = 0; n<finlOutPut.length; n++){
                                    output +=finlOutPut[n];
                                }

                            //document.getElementById('container').innerHTML = output;//print the output
                            amount_words = output;
                        }

                        //simple function to convert from numbers to words from 1 to 999
                        function triConvert(num){
                            var ones = new Array('', ' one', ' two', ' three', ' four', ' five', ' six', ' seven', ' eight', ' nine', ' ten', ' eleven', ' twelve', ' thirteen', ' fourteen', ' fifteen', ' sixteen', ' seventeen', ' eighteen', ' nineteen');
                            var tens = new Array('', '', ' twenty', ' thirty', ' forty', ' fifty', ' sixty', ' seventy', ' eighty', ' ninety');
                            var hundred = ' hundred';
                            var output = '';
                            var numString = num.toString();

                            if (num == 0) {
                                return 'dontAddBigSufix';
                            }
                            //the case of 10, 11, 12 ,13, .... 19 
                            if (num < 20) {
                                output = ones[num];
                                return output;
                            }

                            //100 and more
                            if (numString.length == 3) {
                                output = ones[parseInt(numString.charAt(0))] + hundred;
                                output += tens[parseInt(numString.charAt(1))];
                                output += ones[parseInt(numString.charAt(2))];
                                return output;
                            }

                            output += tens[parseInt(numString.charAt(0))];
                            output += ones[parseInt(numString.charAt(1))];

                            return output;
                        }   
                                        
                    }

                });



            }else{
                $("#status_success").html("<div class='alert alert-danger' role='alert'>Max Five Treament can select !</div>");
                        
                setTimeout(() => {$("#status_success").html(""); }, 2000); 
               
               
                

           }
        }

        let inv_list = [];

        function invoice_list(id){

            const token = sessionStorage.getItem('token');
                fetch(base_url+"invoice_list?c_id="+id, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                        },
                        method: "post",
                })
                .then((response) => response.json())
                .then((data) => {
                   
                    if(data.status == '200'){
                        inv_list = data.data;
                        const value = data.data;
                        var htmlString = "";

                        
                        for(var i = 0; i < value.length  ; i++){

                            if(value[i].invoice_no){


                                htmlString += "<tr><td>"+value[i].invoice_no+"</td><td>"+

                                value[i].treatments.map((t)=>{
                                    return "<span class='p-0 m-0'>"+t.treatment_name+"</span>"
                                })

                                +"</td><td>"+"<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='on_print_invoice("+[i]+")'><i class='fa fa-print eyc'></i></a>"+"</td></tr>";

                            }
                           

                           
                            // htmlString += "<tr><td>" +value[i].invoice_no +"</td><td>" +value[i].customer.customer_first_name+ " " +data.customer.customer_last_name+"<br />"+data.customer.customer_phone+"</td><td>" +"<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='on_print_invoice("+value[i].invoice_no +")'><i class='fa fa-print eyc'></i></a>"+"</td> </tr>";


                        }
                          
                          //  htmlString += data.customer.customer_last_name;
                    
                         
                        $("#invoice_treatment_list").html(htmlString);
    

                    }
                });
        }
        
        function on_print_invoice(index){

           
            let value = inv_list[index];
         
            //var value = inv_list.filter((data)=>{ return data.invoice_no == invoice_no});
           
            var treatments = value.treatments;

            var name       = value.customer.customer_first_name+" "+value.customer.customer_last_name;
            var address    = value.customer.customer_address;
            var phone      = value.customer.customer_phone;
            var email      = value.customer.customer_email;
            var date       =  "<?php echo date('d-m-Y'); ?>";
            var p_mode     = "";
            var invoice_no = value.invoice_no;
            
            var branch_address = value.branch.branch_location;
            var branch_phone  = value.branch.branch_phone;
            var branch_email   = value.branch.branch_email;
            

            var html_treatment ="";
            var total_amount = 0;

            var div1 = "";
            var div2 = "";
            var div3 = "";
            var div4 = "";
            var div5 = "";
            var div6 = "";
            var div7 = "";
            var div8 = "";
            var div9 = "";
            var div10 = "";
            var div11 = "";
            var state_id =value.customer.state_id;
            treatments.map((item,i)=>{

                // var cgst = ((item.amount-item.discount)*9/100);
                // var sgst = ((item.amount-item.discount)*9/100);


                // if(state_id==23){
                //             var cgst = ((item.amount-item.discount)*9/100);
                //             var sgst = ((item.amount-item.discount)*9/100);
                //         }else{
                //             var igst = ((item.amount-item.discount)*18/100);
                        
                //         }
                // total_amount = total_amount+(item.amount-item.discount);
                       if(state_id==23){
                            var cgst = ((item.amount-item.discount_amount)*9/100);
                            var sgst = ((item.amount-item.discount_amount)*9/100);
                        }else{
                            var igst = ((item.amount-item.discount_amount)*18/100);
                        
                        }
                total_amount = total_amount+(item.amount-item.discount_amount);
                div1 +="<p style='padding:0px;margin:0px;text-align: center;padding-top:10px;height: 30px;'>"+(i+1)+"</p>";
                div2 +="<p style='padding:0px;margin:0px;padding-left: 5px;padding-top:10px;height: 30px;'>"+item.treatment_name+"</p>";
                div3 +="<p style='padding:0px;margin:0px;padding-top:10px;height: 30px;'></p>";
                div4 +="<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;padding-top:10px;height: 30px;'>1 No</p>";
                div5 +="<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;padding-top:10px;height: 30px;'>"+item.amount+".00</p>";
                div6 +="<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;padding-top:10px;height: 30px;'>"+item.discount_amount+"</p>";
                div7 +="<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;padding-top:10px;height: 30px;'>"+item.amount+".00</p>";
                div8 +="<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;padding-top:10px;height: 30px;'>"+cgst+"</p>";
                div9 +="<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;padding-top:10px;height: 30px;'>"+sgst+"</p>";
                div10 +="<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;padding-top:10px;height: 30px;'>0</p>";
                div11 +="<p style='padding:0px;margin:0px;text-align:right;padding-top:10px;height: 30px;'>"+(item.amount-item.discount)+".00</p>";

            });

             var gst_div_html ='';

                    if(state_id==23){
                        gst_div_html="<div style='width: 5%;float: left;border-right:1px solid;height:316px;'>"+div8+"</div><div style='width: 5%;float: left;border-right:1px solid;height:316px;'>"+div9+"</div>";
                    }else{
                        gst_div_html="<div style='width: 5%;float: left;border-right:1px solid;height:316px;'>"+div10+"</div>";
                    
                    }



            html_treatment += "<div style='width: 3%;float: left;border-right:1px solid;height:316px;'>"+div1+"</div><div style='width: 30%;float: left;border-right:1px solid;height:316px;'>"+div2+"</div><div style='width: 5%;float: left;border-right:1px solid;height:316px;'>"+div3+"</div><div style='width: 5%;float: left;border-right:1px solid;height:316px;'>"+div4+"</div><div style='width: 10%;float: left;border-right:1px solid;height:316px;'>"+div5+"</div><div style='width: 10%;float: left;border-right:1px solid;height:316px;'>"+div6+"</div><div style='width: 10%;float: left;border-right:1px solid;height:316px;'>"+div7+"</div>"+gst_div_html+"<div style='width: 10%;float: left;height:316px;'>"+div11+"</div>";
                        
            var amount_words = "";

            update(total_amount);

            var newWin=window.open('','Print-Window');

            newWin.document.open();


            
                    var gst_div ='';

                    if(state_id==23){
                        gst_div="<div style='width: 5%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>CGST %</b></div><div style='width: 5%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>SGST %</b></div>";
                    }else{
                        gst_div="<div style='width: 5%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>IGST %</b></div>";
                    
                    }

     
            var html_content ="<!DOCTYPE html><html><head><title>Invoice</title></head><body style='width:95%;margin:auto;font-family: sans-serif;font-size: 12px;'><h1 style='padding:0px;margin:0px;text-align:center;font-size:20px;'>Tax Invoice</h1><div style='border:1px solid;height:739pt;'><div style='width:100%;height:220pt;'><div style='width:65%;float:left;padding:0px;margin:0px;border-right:1px solid;height:220pt;box-sizing: border-box;'><div style='width:100%;padding:0px;margin:0px;border-bottom: 1px solid;height:80pt;padding-top: 10px;;'><div style='width:25%;float:left;padding-left:5px;box-sizing: border-box;'><img src='https://crm.renewhairandskincare.com/renew_api/public/logo/22626.png' height='100px' width='100px;'/></div><div style='width:75%;float:left;text-align: left;'><h1 style='padding:0px;margin:0px;'>Renew+ Hair and Skin Care</h1><p style='padding:0px;margin:0px;padding-top:10px;'>"+branch_address+"<br>Mobile No: +91"+branch_phone+"<br> Email : "+branch_email+"<br>CIN : </p></div></div><div style='width:100%;padding:0px;margin:0px;padding-left:10px;box-sizing: border-box;'><p> <b>Bill to:</b><p><p style='padding:0px;margin:0px;padding-top:5px;'>"+name+"</p><p style='padding:0px;margin:0px;padding-top:5px;'><span>"+address+"</span></p><p style='padding:0px;margin:0px;padding-top:5px;padding-bottom: 5px;'>Mobile : "+phone+"</p><p style='padding-top: 40px;'><span style='padding-top: 15px;'>GSTIN:</span><span style='float: right;padding-right:10px;'>St.Code: <b>33</b></span></p></div></div><div style='width:35%;float:left;padding:0px;margin:0px;box-sizing: border-box;'><div style='width:100%;padding:0px;margin:0px;height:162pt;'><div style='width:50%;float:left;padding:0px;margin:0px;font-size: 10px;'><p style=' border-bottom: 1px solid;border-right: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Invoice No.<br><b>"+invoice_no+"</b></p><p style=' border-bottom: 1px solid;border-right: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Delivery Note</p><p style=' border-bottom: 1px solid;border-right: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Supplier's Ref.</p><p style=' border-bottom: 1px solid;border-right: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Buyer Order No</p><p style=' border-bottom: 1px solid;border-right: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Document No</p><p style=' border-bottom: 1px solid;border-right: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Dispatched Through</p></div><div style='width:50%;float:left;padding:0px;margin:0px;font-size: 10px;'><p style='border-bottom: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Dated<br><b>"+date+"</b></p><p style='border-bottom: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Mode/Terms of Payment</p><p style=' border-bottom: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Other Reference(s)</p><p style=' border-bottom: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Dated</p><p style=' border-bottom: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Delivery Note Date</p><p style=' border-bottom: 1px solid; height: 30px;padding: 5px 0px 0px 5px;margin: 0px;'>Destination</p></div></div><div style='width:100%;pad:0px;margin:0px;'><p style='padding-left:5px;padding-top:0px;'>Terms Of Delivery</p></div></div></div><div style='width:100%;border-top:1px solid;border-bottom:1px solid;height:275pt;'><div style='height:50px;border-bottom:1px solid;text-align: center;font-size: 11px;;'><div style='width: 3%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>Sl No.</b></div><div style='width: 30%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>Product Name & Description</b></div><div style='width: 5%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>HSN / SAC</b></div><div style='width: 5%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>Qty,</b></div><div style='width: 10%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>Rate</b></div><div style='width: 10%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>Disc. Amt.</b></div><div style='width: 10%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><b>Taxable Amt.</b></div>"+gst_div+"<div style='width: 10%;float: left;height:40px;padding-top: 10px;'><b>Amount</b></div></div><div style='height:316px;'>"+html_treatment+"</div><div style='height:26px;border-bottom: 1px solid;'><div style='width: 3%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align: center;'></p></div><div style='width: 30%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;padding-left: 5px;'></p></div><div style='width: 5%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;'></p></div><div style='width: 5%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div><div style='width: 10%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div>      <div style='width: 10%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div><div style='width: 10%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div><div style='width: 5%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div>        <div style='width: 5%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div><div style='width: 5%;float: left;border-right:1px solid;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'>Total</p></div><div style='width: 10%;float: left;height:16px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:right;'>"+total_amount+".00</p></div></div></div><div style='width:100%;height:15pt;border-bottom: 1px solid;padding-top:5px;margin-top: 19pt;'><p style='margin:0px;padding:0px;padding-left:5px;'><b>Amount In Word : </b><span>Rupees "+amount_words+" Only</span></p> </div><div style='height:50px;border-bottom: 1px solid;box-sizing: border-box;text-align:center;'><div style='width: 50%;float: left;height:40px;padding-top: 10px;border-right:1px solid;'><p style='padding:0px;margin:0px;text-align: center;'></p></div> <div style='width: 10%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><p style='padding:0px;margin:0px;padding-left: 5px;'>Taxable <br>Value</p></div><div style='width: 15%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><p style='padding:0px;margin:0px;border-bottom:1px solid;'>Central Tax</p>    <div style='width:100%;padding:0px;margin:0px;height:18pt;'><div style='width:50%;margin:0px;padding:0px;float:left;border-right:1px solid;box-sizing: border-box;height:18pt;padding-top:5px;'>Rate</div><div style='width:50%;margin:0px;padding:0px;float:left;box-sizing: border-box;height:18pt;padding-top:5px;'>Amount</div></div></div><div style='width: 15%;float: left;border-right:1px solid;height:40px;padding-top: 10px;'><p style='padding:0px;margin:0px;text-align:center;padding-right: 5px;border-bottom:1px solid;'>State Tax</p><div style='width:100%;padding:0px;margin:0px;height:18pt;'><div style='width:50%;margin:0px;padding:0px;float:left;border-right:1px solid;box-sizing: border-box;height:18pt;padding-top:5px;'>Rate</div>  <div style='width:50%;margin:0px;padding:0px;float:left;box-sizing: border-box;height:18pt;padding-top:5px;'>Amount</div></div></div><div style='width: 9%;float: left;height:40px;padding-top: 6px;'>Total<br>Tax Amount<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div></div><div style='height:30px;border-bottom: 1px solid;box-sizing: border-box;text-align:center;'><div style='width: 50%;float: left;height:20px;padding-top: 10px;border-right:1px solid;'><p style='padding:0px;margin:0px;text-align: right;padding-right:10px;'>Total</p></div><div style='width: 10%;float: left;border-right:1px solid;height:20px;padding-top: 10px;'><p style='padding:0px;margin:0px;padding-left: 5px;'>"+(total_amount-(total_amount*18/100))+".00</p></div><div style='width: 15%;float: left;border-right:1px solid;height:30px;padding-top: 0px;'><div style='width:100%;padding:0px;margin:0px;height:18pt;'><div style='width:50%;margin:0px;padding:0px;float:left;border-right:1px solid;box-sizing: border-box;height:22pt;padding-top:8px;'>9%</div><div style='width:50%;margin:0px;padding:0px;float:left;box-sizing: border-box;height:22pt;padding-top:8px;'>"+(total_amount*9/100)+".00</div></div></div><div style='width: 15%;float: left;border-right:1px solid;height:30px;padding-top: 0px;'><div style='width:100%;padding:0px;margin:0px;height:18pt;'><div style='width:50%;margin:0px;padding:0px;float:left;border-right:1px solid;box-sizing: border-box;height:22pt;padding-top:8px;'>9%</div><div style='width:50%;margin:0px;padding:0px;float:left;box-sizing: border-box;height:22pt;padding-top:8px;'>"+(total_amount*9/100)+".00</div></div></div><div style='width: 9%;float: left;height:20px;padding-top: 8px;'>"+total_amount+".00<p style='padding:0px;margin:0px;text-align:right;padding-right: 5px;'></p></div></div><div style='width:100%;padding:0px;margin:0px;'><div style='width:50%;padding:0px;margin:0px;float:left;box-sizing: border-box;padding-left:10px;padding-top:85px;'><p style='padding:0px;margin:0px;text-decoration-line: underline;padding-bottom: 8px;padding-top:5px;font-size: 13px;'>Terms & Condition :-</p><p style='padding:0px;margin:0px;font-size: 13px;'>1. Subject to Your City Jurisdiction.</p><p style='padding:0px;margin:0px;font-size: 13px;'>2. No liability accepted for any breakage.</p><p style='padding:0px;margin:0px;font-size: 13px;'>3. Goods once sold will not be taken back or exchange</p><p style='padding:0px;margin:0px;font-size: 13px;'>4. Any warranty claim will not be accepted without warranty card. E & O.E.</p></div><div style='width:50%;padding:0px;margin:0px;float:left;box-sizing: border-box;padding-top:19px;'><p style='font-size: 15px;padding:0px 0px 0px 100px;margin:0px'><b>Company's Bank Details:</b></p><p style='padding: 5px 0px 0px 100px;margin:0px;'><span style='padding-right:15px;'>Bank Name :</span> <span>CUB</span></p><p style='padding: 5px 0px 0px 100px;margin:0px;'><span style='padding-right:15px;'>Account No :</span> <span>51090901064714</span></p><p style='padding: 5px 0px 0px 100px;margin:0px;'><span style='padding-right:5px;'>Branch Name : </span> <span>Mannivakkam</span></p>       <p style='padding: 5px 0px 8px 100px;margin:0px;'><span style='padding-right:8px;'>Branch Code :</span>  <span>CIUB0000483</span></p><div style='margin:0px;padding:0px;border-left:1px solid;border-top:1px solid;height:53pt'><p style='padding:0px;margin:0px;text-align:right;padding-right:15px;padding-top:5px;font-size: 10px;'><b>For Renew+ Skin and Care</b></p><p style='text-align:right;padding-right:17px;padding-top:30px;'><b>Authorised Signatory</b></p></div></div></div></div></body></html>";

            newWin.document.write(html_content);

            newWin.document.close();
                    
        

            function update(amount){
                var bigNumArry = new Array('', ' thousand', ' million', ' billion', ' trillion', ' quadrillion', ' quintillion');

                var output = '';
                var numString =   amount.toString();
                var finlOutPut = new Array();

                if (numString == '0') {
                alert('Zero');
                    return;
                }

                if (numString == 0) {
                    alert('messeg tell to enter numbers');
                    return;
                }

                var i = numString.length;
                i = i - 1;

                            //cut the number to grups of three digits and add them to the Arry
                while (numString.length > 3) {
                    var triDig = new Array(3);
                    triDig[2] = numString.charAt(numString.length - 1);
                    triDig[1] = numString.charAt(numString.length - 2);
                    triDig[0] = numString.charAt(numString.length - 3);

                    var varToAdd = triDig[0] + triDig[1] + triDig[2];
                    finlOutPut.push(varToAdd);
                    i--;
                    numString = numString.substring(0, numString.length - 3);
                }
                finlOutPut.push(numString);
                finlOutPut.reverse();

                //conver each grup of three digits to english word
                //if all digits are zero the triConvert
                //function return the string "dontAddBigSufix"
                for (j = 0; j < finlOutPut.length; j++) {
                    finlOutPut[j] = triConvert(parseInt(finlOutPut[j]));
                }

                var bigScalCntr = 0; //this int mark the million billion trillion... Arry

                for (b = finlOutPut.length - 1; b >= 0; b--) {
                    if (finlOutPut[b] != "dontAddBigSufix") {
                        finlOutPut[b] = finlOutPut[b] + bigNumArry[bigScalCntr] + ' , ';
                        bigScalCntr++;
                    }
                    else {
                        //replace the string at finlOP[b] from "dontAddBigSufix" to empty String.
                        finlOutPut[b] = ' ';
                        bigScalCntr++; //advance the counter  
                    }
                }

                //convert The output Arry to , more printable string 
                for(n = 0; n<finlOutPut.length; n++){
                    output +=finlOutPut[n];
                }

                //document.getElementById('container').innerHTML = output;//print the output
                amount_words = output;
            }

            //simple function to convert from numbers to words from 1 to 999
            function triConvert(num){
                var ones = new Array('', ' one', ' two', ' three', ' four', ' five', ' six', ' seven', ' eight', ' nine', ' ten', ' eleven', ' twelve', ' thirteen', ' fourteen', ' fifteen', ' sixteen', ' seventeen', ' eighteen', ' nineteen');
                var tens = new Array('', '', ' twenty', ' thirty', ' forty', ' fifty', ' sixty', ' seventy', ' eighty', ' ninety');
                var hundred = ' hundred';
                var output = '';
                var numString = num.toString();

                if (num == 0) {
                    return 'dontAddBigSufix';
                }
                //the case of 10, 11, 12 ,13, .... 19 
                if (num < 20) {
                    output = ones[num];
                    return output;
                }

                //100 and more
                if (numString.length == 3) {
                    output = ones[parseInt(numString.charAt(0))] + hundred;
                    output += tens[parseInt(numString.charAt(1))];
                    output += ones[parseInt(numString.charAt(2))];
                    return output;
                }

                output += tens[parseInt(numString.charAt(0))];
                output += ones[parseInt(numString.charAt(1))];

                return output;
            }   
                                        
        }

        $('#tc_name').on('change', function() {
            // alert( this.value );
            gettreatmentall(this.value);

            tc_id = this.value;

        });

        $('#treatment_name').on('change', function() {
            // alert( this.value );
            // gettreatmentall(this.value);

            $data = "tc_id="+tc_id+"&t_id="+this.value;

            fetch(base_url+"customer_treatment_amount?"+$data , {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "post",
            })
            .then((response) => response.json())
            .then((data) => {
                    
                if(data.status == '200'){
                    $('#amount').val(data.data.amount);
                    $('#final_amount').val(data.data.amount);
                    total_amount = data.data.amount;
                }
            });

        });


        $('#select_discount').on('change', function() {

            if(this.value == 'percent'){
                $dis = $('#discount').val();

                if($dis > 100){
                    $('#error_discount').html('Max discount 100 only');
                }else{

                    $('#error_discount').html('');
                    $val = total_amount/100 * $dis;

                    $f_val = total_amount-$val;

                    $('#amount').val($f_val);

                }

            }else{
                $('#error_discount').html('');
                $f_val = total_amount-$('#discount').val();

                $('#amount').val($f_val);
            }
            
           
        });

        function status(id,status){

        if(status == '1'){
            var lead_status = 0;
        }else{
            var lead_status = 1;
        }
        const token = sessionStorage.getItem('token');
        fetch(base_url+"customer_treatment_status/"+id+'?status='+lead_status, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
            })
            .then((response) => response.json())
                .then((data) => {
                
                    if(data.status == '200'){

                    $("#status_success").html("<div class='alert alert-success' role='alert'> Successfully Updated!</div>");
                    
                    setTimeout(() => { $("#status_success").html("");all();}, 4000);    

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

        function permission_page(name){

            fetch(base_url+"role_permission_page/"+name, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
            })
            .then((response) => response.json())
            .then((data) => {

                if(data.status == '200'){

                    
                    permission = data.data.permission;
                

                }
            });

        }

    }
</script>
