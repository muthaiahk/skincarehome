<script>
 var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
       var base_url = window.location.origin+'/api/';
        var tc_id = 0;
        var total_amount = 0;
        var permission = '';
      
        $( "#add_t_management" ).hide();
        var branch_ids = sessionStorage.getItem('branch_id');
            var branch_id = JSON.parse(branch_ids);
        async function permission_page(name) {
            try {
                const response = await fetch(base_url + "role_permission_page/" + name, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        Authorization: `Bearer ${token}`,
                    },
                    method: "get",
                });

                const data = await response.json();
                permission = data.data.permission;
                console.log(permission);

            } catch (error) {
                console.error(error);
                throw error;
            }
        }

        permission_page("customer_treatment").then(() => {
            try {
                console.log(permission);

                all(permission);
              
            } catch (error) {
                console.error(error);
            }
        });

           
        gettcall();
        gettreatmentall();
      
      
        
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

                          
                            function sel_status(value) {
                              
                                if (value ==branch_id[1] ) {
                                    getuserall(branch_id[1]);
                                    return 'selected';
                                } else {
                                    return '';
                                }
                            }
                            const value = data.data;
                            var htmlString = "";

                            var htmlhead ="<option value=''>Select Branch</option>";   

                            for(var i = 0; i < value.length  ; i++){

                              
                                if(sessionStorage.getItem('role') >2){
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
                            
                           
                        }
                    

                    }
                });
        }
        $('#treatment_cat_list').on('click', function() {
            
            var id = document.getElementById("treatment_cat_list").value;
            cattreatmentall(id)
            all();

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
        
        gettreatmentall();
        gettreatmentcatall();
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


        function mobile_search(e){
            keyvalue = e.keyCode;
            if(keyvalue == 13){

                var mobile = e.target.value;

                if(!mobile){

                    $('#error_mobile').html("");
                    getuserall();
                    
                }else{

                    if(mobile.length != 10){
                        $('#error_mobile').html("mobile number is invalid ");
                    }else{

                        $('#error_mobile').html("");
                    
                        fetch(base_url+"customer_search/"+mobile, {
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

                                    var htmlhead ="<option value='0'>Select customer name</option>";

                                    for(var i = 0; i < value.length  ; i++){
                                        if(value[i].status == '0'){
                                            htmlString += "<option selected value="+value[i].customer_id+">"+ value[i].customer_first_name + value[i].customer_last_name+' - '+value[i].customer_phone + "</option>"
                                        }
                                    }
                                        
                                    var htmlstringall = htmlhead+htmlString;
                                    $("#customer_name").html(htmlstringall);

                                    if(data.data.length == 0){
                                        $("#error_mobile").html("Customer name not found please try again");
                                    }
                                                
                                }
                            }
                        });
                    
                        
                    }
                }
                
            }
        }

        $('#customer_name').change(function(){
          //  alert($(this).val());

            $("#error_mobile").html("");
            $("#mobile").val("");

            getusermobile($(this).val());
        })

        function getusermobile(id){

            const token = sessionStorage.getItem('token');

            fetch(base_url+"cus_treament_list/"+id, {
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
                        
                        document.getElementById('mobile').value = data.mobile;
                        
                                            
                    }
                    
                }
            });
        }

        function gettcall(){

            const token = sessionStorage.getItem('token');

            fetch(base_url+"manage_treatment_cat",{
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

                                var htmlhead ="<label class='form-label'>Categories</label><select class='form-select' id='tc_name' onchange='select_t_Category();'><option value='0'>Select Categories</option>";

                                for(var i = 0; i < value.length  ; i++){

                                    htmlString += "<option value="+value[i].tcategory_id+">"+ value[i].tc_name + "</option>"
                            
                                }

                                var htmlfooter ="</select><div class='text-danger' id='error_tc_name'></div>";
                                
                                var htmlstringall = htmlhead+htmlString+htmlfooter;
                                $("#tc_name").html(htmlstringall);                           
                                            
                            }
                        

                        }
                    });
        }


        function gettreatmentall(id=0){

            const token = sessionStorage.getItem('token');

            fetch(base_url+"manage_treatment/"+id, {
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

                            var htmlhead ="<option value='0'>Select Lead Status</option>";
                            
                            for(var i = 0; i < value.length  ; i++){
                                if(value[i].status == '0'){
                                    htmlString += "<option value="+value[i].treatment_id+">"+ value[i].treatment_name + "</option>"
                                }
                            }


                                
                            var htmlstringall = htmlhead+htmlString;
                           
                            $("#treatment_name").html(htmlstringall);
                                                
                        }
                        
                    }
                });
        }

        

       
      

        function getuserall(branch_id=0){
        
            const token = sessionStorage.getItem('token');
        
            fetch(base_url+"customer/"+branch_id, {
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

                        var htmlhead ="<option value='0'>Select customer name</option>";

                        for(var i = 0; i < value.length  ; i++){
                            if(value[i].status == '0'&& branch_id == value[i].branch_id){
                                htmlString += "<option value="+value[i].customer_id+">"+ value[i].customer_first_name+ " "+ value[i].customer_last_name+' - '+  value[i].customer_phone+ "</option>"
                            }
                        }
                                
                        var htmlstringall = htmlhead+htmlString;
                        $("#customer_name").html(htmlstringall);
                                        
                    }
                }
            });
            
        }


        $('#branch_name').change(function(){
            var branch_id = $(this).val(); 
            getuserall(branch_id);
        });
    

        $('#select_treatment').change(function(){
            all();
        })
      
        
        $('#select_status').change(function(){
            var status = $(this).val(); 
            all();
        });
        function selectbranch(e){
            
            all();
        }
        

        all(branch_id[1]);

        function all(){

            const token = sessionStorage.getItem('token');

            var branch_id = $('#branch_name').val();
            var tc_id = $('#treatment_cat_list').val();
            var t_id = $('#select_treatment').val();
            var status = $('#select_status').val();
            let params = new URLSearchParams();

            params.append('branch_id', branch_id);
            params.append('tc_id', tc_id);
            params.append('t_id', t_id);
            params.append('status', status);

            fetch(base_url+"customer_treatment", {
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

                                var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Treatment Categories</th><th>Treatment Name</th><th>Customer Name</th><th>Treatment Status</th><th>Invoice</th><th>Amount</th><th>Balance</th><th>Action</th></tr></thead><tbody>";

                                for(var i = 0; i < value.length  ; i++){

                                
                                  
                                    if(value[i].complete_status == '0'){
                                        var  status = "<span class='text-primary'>Progress</span>";
                                        
                                    }else{
                                       
                                        var status = "<span class='text-success'>Completed</span>";
                                    }
                                    var tickIconId = "tick-icon-" + i;
                                    var tickIconDisplay = value[i].complete_status == 1 ? 'none' : 'block';
                                   

                                    var invoioce = "";
                                    
                                    var action = "";

                                    if(permission){
                                        

                                        var cama=stringHasTheWhiteSpaceOrNot(permission);
                                        if(cama){
                                            var values = permission.split(",");
                                            if(values.length > 0){
                                                var add = values.includes('add');// true
                                                var edit = values.includes('edit');// true
                                                var view = values.includes('view'); // true
                                                var del = values.includes('delete'); // true
                                                var print = values.includes('print'); // true
                                                if(add){ 
                                                    
                                                    $( "#add_t_management" ).show();
                                                    
                                                }
                                                else{
                                                    $( "#add_t_management" ).hide();
                                                }
                                                action += "<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='modelcomplete(" + value[i].cus_treat_id + ")'><i id='" + tickIconId + "' class='fa fa-check' style='display:" + tickIconDisplay + ";'></i></a>";
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
                                                    action += "";
                                                }
                                                if(print && value[i].balance == 0){  
                                                    action +=  "<a href='#' data-bs-toggle='modal' data-toggle='tooltip' data-placement='bottom' title='invoice' data-bs-target='' onclick='invoice_print("+value[i].p_id +")'><i class='fa fa-file-text-o'></i></a>";}
                                                else{
                                                    action += "";
                                                }
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
                                    var invoice = value[i].invoice_no;
                                    if (value[i].invoice_no == null) {
                                        invoice = " ";
                                    }
                                    var total = value[i].amount+value[i].discount;
                                    
                               
                                   
                                    htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].tc_name + "<br/>" + (value[i].treatment_auto_id ? value[i].treatment_auto_id : '') + "</td><td>" + value[i].treatment_name +"</td><td>" + value[i].customer_first_name+"</td><td>" + status +"</td><td>" + invoice +"</td><td>"+value[i].amount+"</td><td>"+value[i].balance+"</td><td>"+ action +invoioce+ "</td></tr>";
                                  
                                    
                                }
                              


                                var htmlfooter ="</tbody></table>";
                                
                                var htmlstringall = htmlhead+htmlString+htmlfooter;
                                $("#treatment_management_list").html(htmlstringall);

                                datatable();
                                            
                            }
                        

                        }
                    });
        }
        
      

        function invoice_print(id){
           
           const token = sessionStorage.getItem('token');
           fetch(base_url+"invoice?p_id="+id, {
                   headers: {
                       "Content-Type": "application/x-www-form-urlencoded",
                       'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                   },
                   method: "post",
           })
           .then((response) => response.json())
           .then((data) => {
                   
               if(data.status == '200'){
                   
                   var invoices = data.data;
                   
                   
                   var name        = invoices.customer_first_name;
                   var phone       = invoices.customer_phone;
                   var email       = invoices.customer_email;
                   var address     = invoices.customer_address;
                   var invoice_no  = invoices.invoice_no;
                   var date        = "<?php echo date('d-m-Y'); ?>";
                   var invoicehtml = "";
                   var sub_total   = data.data.total_amount + data.discount;
                   
                   
                   
                   var newWin=window.open('','Print-Window');

                   newWin.document.open();


                    var html_content = "<!DOCTYPE html><html><head>	<title>Invoice Template Design</title>	<style>  @import url('https://fonts.googleapis.com/css2?family=Lato:wght@100;400;900&display=swap');:root {  --primary: #0000ff;  --secondary: #3d3d3d;   --white: #fff;  --black: #000;}*{	margin: 0;	padding: 0;	box-sizing: border-box;	font-family: 'Lato',sans-serif;}body{background: var(--secondary);padding: 50px;color: var(--secondary);	display: flex;	align-items: center;	justify-content: center;	font-size: 14px;}.bold{	font-weight: 900;}.light{font-weight: 100;}.wrapper{	background: var(--white);	padding: 30px;}.invoice_wrapper{	border: 3px solid var(--black);	width: 700px;	max-width: 100%;}.invoice_wrapper .header .logo_invoice_wrap,.invoice_wrapper .header .bill_total_wrap{	display: flex;	justify-content: space-between;	padding: 20px;}p.invoice.bold {    text-align: center;    font-size: 26px;}.invoice_wrapper .header .logo_sec{	display: flex;	align-items: center;}.invoice_wrapper .header .logo_sec .title_wrap{	margin-left: 5px;}.invoice_wrapper .header .logo_sec .title_wrap .title{	text-transform: uppercase;	font-size: 18px;	color: var(--primary);}.invoice_wrapper .header .logo_sec .title_wrap .sub_title{	font-size: 12px;}.invoice_wrapper .header .invoice_sec,.invoice_wrapper .header .bill_total_wrap .total_wrap{	text-align: right;}.invoice_wrapper .header .invoice_sec .invoice{	font-size: 28px;	color: var(--primary);}.invoice_wrapper .header .invoice_sec .invoice_no,.invoice_wrapper .header .nvoice_sec .date{	display: flex;	width: 100%;}.invoice_wrapper .header .invoice_sec .invoice_no span:first-child,.invoice_wrapper .header .invoice_sec .date span:first-child{	width: 70px;	text-align: left;}.invoice_wrapper .header .invoice_sec .invoice_no span:last-child,.invoice_wrapper .header .invoice_sec .date span:last-child{	width: calc(100% - 70px);}.invoice_wrapper .header .bill_total_wrap .total_wrap .price,.invoice_wrapper .header .bill_total_wrap .bill_sec .name{	color: var(--black);	font-size: 20px;}.invoice_wrapper .body .main_table .table_header{	/* background: var(--primary); */}.invoice_wrapper .body .main_table .table_header .row{color: var(--black);	font-size: 18px;	border-bottom: 0px;	}.invoice_wrapper .body .main_table .row{	display: flex;	border-bottom: 1px solid var(--secondary);}.invoice_wrapper .body .main_table .row .col{	padding: 10px;}.invoice_wrapper .body .main_table .row .col_no{width: 5%;}.invoice_wrapper .body .main_table .row .col_des{width: 45%;}.invoice_wrapper .body .main_table .row .col_price{width: 20%; text-align: center;}.invoice_wrapper .body .main_table .row .col_qty{width: 10%; text-align: center;}.invoice_wrapper .body .main_table .row .col_total{width: 20%; text-align: right;}.invoice_wrapper .body .paymethod_grandtotal_wrap{	display: flex;	justify-content: space-between;	padding: 5px 0 30px;	align-items: flex-end;}.invoice_wrapper .body .paymethod_grandtotal_wrap .paymethod_sec{	padding-left: 30px;}.invoice_wrapper .body .paymethod_grandtotal_wrap .grandtotal_sec{	width: 30%;}.invoice_wrapper .body .paymethod_grandtotal_wrap .grandtotal_sec p{display: flex;	width: 100%;	padding-bottom: 5px;}.invoice_wrapper .body .paymethod_grandtotal_wrap .grandtotal_sec p span{	padding: 0 10px;}.invoice_wrapper .body .paymethod_grandtotal_wrap .grandtotal_sec p span:first-child{	width: 60%;}.invoice_wrapper .body .paymethod_grandtotal_wrap .grandtotal_sec p span:last-child{	width: 40%;	text-align: right;}.invoice_wrapper .body .paymethod_grandtotal_wrap .grandtotal_sec p:last-child span{	/* background: var(--primary); */	padding: 10px;	color: #000;}.invoice_wrapper .footer{	padding: 30px;}.invoice_wrapper .footer > p{	color: var(--primary);	text-decoration: underline;	font-size: 18px;	padding-bottom: 5px;}.invoice_wrapper .footer .terms .tc{	font-size: 16px;}    </style></head><body><div class='wrapper'>	<div class='invoice_wrapper'>		<div class='header'><p class='invoice bold'>INVOICE</p>	<div class='logo_invoice_wrap'>				<div class='logo_sec'>					<img src='https://crm.renewhairandskincare.com/renew_api/apiassets/logo/renew_1.png' style='float:left; width: 100%; max-width: 120px;    padding-top: 0px; margin-right:20px;' />					<div class='title_wrap'>						<!-- <p class='title bold'>Coding Boss</p>	<p class='sub_title'>Privite Limited</p> -->                        <h3>Renew+ Hair and Skin Care</h3>		<p>No.155, 2nd floor, 80 feet road,<br /> kk nagar, Madurai, Tami Nadu, India, 625020</p>	<p>+91 9150309990(M)</p>					<p>Email: renewhairskincare@gmail.com</p>	</div>	</div>	<div class='invoice_sec'>				<p class='invoice_no'>					<span class='bold'>Invoice</span>						<span>#"+invoice_no+"</span>					</p>					<p class='date'>						<span class='bold'>Date</span>						<span>"+date+"</span>					</p>				</div>			</div>			<div class='bill_total_wrap'>				<div class='bill_sec'>					<p>Bill To</p> 	          		<p class='bold name'>"+name+"</p>			        <p>			         "+address+"  </p><p>Email : "+email+"</p><p>Mobile : "+phone+"</p>				</div>				<div class='total_wrap'>					<!-- <p>Total Due</p>	          		<p class='bold price'>USD: $1200</p> -->				</div>			</div>		</div>		<div class='body'>			<div class='main_table'>				<div class='table_header'>					<div class='row'>						<div class='col col_no'>#</div>						<div class='col col_des'>DESCRIPTION</div>						<div class='col col_qty'>QTY</div>                        <div class='col col_price'>Rate</div>                        <div class='col col_price'>Disc. Amt</div>                        <div class='col col_price'>CGST</div>                        <div class='col col_price'>SGST</div>						<div class='col col_total'>TOTAL</div>					</div>				</div>				<div class='table_body'>					<div class='row'>						<div class='col col_no'>							<p>01</p>						</div>						<div class='col col_des'>							<p class='bold'>"+data.data.tc_name+"</p>							<p>"+data.data.treatment_name+"</p>						</div>                        <div class='col col_qty'>							<p>1</p>						</div>						<div class='col col_price'>							<p>"+data.data.total_amount+"</p>						</div>                        <div class='col col_price'>							<p>"+data.discount+"</p>						</div>                        <div class='col col_price'>							<p>"+data.cgst+"</p>						</div>                        <div class='col col_price'>							<p>"+data.sgst+"</p>						</div>						<div class='col col_total'>							<p>"+sub_total+"</p>					</div>					</div>				</div>		</div>			<div class='paymethod_grandtotal_wrap'>			<div class='paymethod_sec'>					<!-- <p class='bold'>Payment Method</p>					<p>Visa, master Card and We accept Cheque</p> -->		</div>				<div class='grandtotal_sec'>			        <p class='bold'>			            <span>SUB TOTAL</span>			            <span>"+sub_total+"</span>			        </p>                    <p>			            <span>Total Inc. SGST  </span>			            <span>"+data.sgst+"</span>                    </p>			        			        <p>                        <span>Total Inc. CGST </span>			            <span>"+data.cgst+"</span>                    </p>               <p>                        <span>Discount </span>            <span>"+"- "+data.discount+"</span>			        </p>			       	<p class='bold'>			            <span>Grand Total</span>			            <span>"+data.data.total_amount+"</span>			        </p>				</div>			</div>		</div>		<div class='footer'>			<p>Thank you and Best Wishes</p>			<div class='terms'>		        <p class='tc bold'>Terms & Coditions</p>		        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit non praesentium doloribus. Quaerat vero iure itaque odio numquam, debitis illo quasi consequuntur velit, explicabo esse nesciunt error aliquid quis eius!</p>		    </div>		</div>	</div></div></body></html>";
   
                   newWin.document.write(html_content);

                   newWin.document.close();
                   
               }
           });
        }

        $('#tc_name').on('change', function() {
            // alert( this.value );
            gettreatmentall(this.value);

            tc_id = this.value;

        });

        $('#treatment_name').on('change', function() {
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

function pay_amount(e){

            var regex = /^\d+(\.\d{2,2})?$/;

            var amount = $('#amount').val();

            var discount = e.target.value;

            if(discount == '' ||  regex.test(discount) == false){
                $("#error_discount").html("Please enter valid amount");
            
            }else{

                $("#error_discount").html("");

                $sl_vl = $('#select_discount').val();

                if($sl_vl == 'percent'){

                    if(parseInt(discount) > 100){

                        $('#error_discount').html('Max discount 100 only');

                    }else{
                        $('#error_discount').html('');

                        $val = total_amount/100 * discount;

                        $f_val = total_amount-$val;

                        $('#amount').val($f_val);

                    }
                    

                }else{
                    
                    if(parseInt(discount) >= parseInt(total_amount)){
                    
                        $("#error_discount").html("your amount is excess treatment amount");
                        $("#amount").val(total_amount);

                    }else{
                        var final_amount = parseInt(total_amount) - parseInt(discount);
                        $("#amount").val(final_amount);

                        $("#error_discount").html("");
                    }

                }
                   
            
            }

        }
      

     
            function add_customer_treatment() {
           
        
                    var customer_id = document.getElementById("customer_name").value;
                    var treatment_id = document.getElementById("treatment_name").value;
                    var tc_id = document.getElementById("tc_name").value;
                    var progress = 0;
                    var remark = document.getElementById("remark").value;
                    var medicine = "";
                    var amount = document.getElementById("final_amount").value;
                   // var discount = document.getElementById("discount").value;
                    var regex = /^\d+(\.\d{2,2})?$/;
        
                    if(customer_id == '0'){
        
                        $("#error_customer_name").html("Please select customer name");
                        customer_id = '';
        
                    }else{
                        $("#error_customer_name").html("");
                    } 
        
                    if(treatment_id == '0'){
        
                        $("#error_treatment_name").html("Please select treatment name");
                        treatment_id = '';
        
                    }else{
                        $("#error_treatment_name").html("");
                    } 
        
                
                    if(tc_id == '0'){
        
                        $("#error_tc_name").html("Please select category name");
        
                    }else{
                        $("#error_tc_name").html("");
                    } 
        
        
                 
        
        
                                
                    if(customer_id  && treatment_id ){
        
                        document.getElementById('add_customer_t').style.pointerEvents = 'none';
        
        
                        var data = "customer_id="+customer_id+"&treatment_id="+treatment_id+"&tc_id="+tc_id+"&progress="+progress+"&remarks="+remark+"&amount="+amount+"&medicine="+medicine;
                        
                        const token = sessionStorage.getItem('token');
        
                        fetch(base_url+"add_customer_treatment?"+data, {
                                headers: {
                                    "Content-Type": "application/x-www-form-urlencoded",
                                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                                },
                                method: "post",
                            })
                        .then((response) => response.json())
                        .then((data) => {
        
                           
                            
                            if(data.status == '200'){
        
                                $("#status_success").html("<div class='alert alert-success' role='alert'>Customer Treatment Successfully Added!</div>");
                                
                                setTimeout(() => { $("#status_success").html("");window.location.href = "./treatment_management";}, 4000);  
                                
        
                            }else{
                                $("#status_success").html("<div class='alert alert-danger' role='alert'>Customer already Assigned Treatment is Ongoing !</div>");
                                setTimeout(() => { $("#status_success").html("");}, 4000);  
                                
                            }
                            document.getElementById('add_customer_t').style.pointerEvents = 'auto';
                        });
                    }
        
                }
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

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Lead Successfully Updated!</div>");
                    
                    setTimeout(() => { $("#status_success").html("");all();}, 4000);    

                    }
                });
                
        }
        var delete_id = '';

        function model(id){

            $('#t_management_delete').modal('show');
            delete_id = id;
        }

        $('#delete').click(function(){

            const token = sessionStorage.getItem('token');

            fetch(base_url+"delete_customer_treatment/"+delete_id, {
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

                        $("#status_success").html("<div class='alert alert-success' role='alert'>Treamtment Successfully Deleted!</div>");
                        
                        setTimeout(() => { $("#status_success").html("");}, 4000);    

                        }
                    });
        })
         
        var complete_id = '';

        function modelcomplete(id){

            $('#t_management_completed').modal('show');
            complete_id = id;
        }

        $('#complete').click(function(){

            const token = sessionStorage.getItem('token');

            fetch(base_url+"completed_customer_treatment/"+complete_id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "post",
                })
                .then((response) => response.json())
                    .then((data) => {
                    
                        if(data.status == '200'){

                        all();

                        $("#status_success").html("<div class='alert alert-success' role='alert'>Treamtment Successfully Completed!</div>");
                        
                        setTimeout(() => { $("#status_success").html("");}, 4000);    

                        }
                    });
        })


      
     
       
    

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
