<script>
 var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var prod_amount = 0;
      var base_url = window.location.origin+'/api/';
        $( "#add_sales" ).hide();

        var branch_ids = sessionStorage.getItem('branch_id');
            var branch_id = JSON.parse(branch_ids);
          
        
        let permission = ""; 

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

        permission_page("sales").then(() => {
            try {
                console.log(permission);

                $('#data_filter').click(function(){
                from_date = document.getElementById('from_date').value;
                to_date   = document.getElementById('to_date').value;
            
                var branch_id = $('#branch_name').val();

                all(from_date,to_date,branch_id[1],permission);
                });

                all(from_date,to_date,branch_id[1],permission);
            } catch (error) {
                console.error(error);
            }
        });
        
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

                            var htmlhead ="<option value='0'>Select Branch</option>";

                            for(var i = 0; i < value.length  ; i++){

                                // if(value[i].status == '0'){
                                //     htmlString += "<option value='"+value[i].branch_id+"'"+sel_status(value[i].branch_id)+">"+ value[i].branch_name + "</option>";
                                //     // htmlString += "<option value="+value[i].branch_id+">"+ value[i].branch_name + "</option>"
                                // }
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
                            $("#branch_id").html(htmlstringall);

                            // if(sessionStorage.getItem('role') >2){
                            //     $('#branch_id').prop('disabled', true);
                            //     $('.form-select').css('background-image', '');
                                
                            // }
                            
                                        
                        }
                    

                    }
                });
        }
       
       
          
        
        getuserall();
        
        function getuserall(branch_id=1){
            
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

                        // var filter_data = data.data.filter((c)=>{ return c.branch_id == branch_id});
                            
                        const value = data.data;

                        // const value = filter_data;
                        var htmlString = "";

                        var htmlhead ="<label class='form-label'>Customer</label><select class='form-select' id='customer_name'><option value='0'>Select Customer</option>";

                        for(var i = 0; i < value.length  ; i++){
                            if(value[i].status == '0' && branch_id == value[i].branch_id){
                                htmlString += "<option value="+value[i].customer_id+">"+ value[i].customer_first_name+ " "+ value[i].customer_last_name+' - '+  value[i].customer_phone+ "</option>"
                            }
                        }
                        var htmlfooter ="</select><div class='text-danger' id='error_customer_name'></div>";  
                        var htmlstringall = htmlhead+htmlString+htmlfooter;
                        $("#customer_list").html(htmlstringall);
                                    
                    }
                }
            });
        }
        $('#branch_id').change(function(){
                var branch_id = $(this).val(); 
                // var branch_id = $('#branch_id').val();
                getuserall(branch_id);
        });
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
     
        function getcat(e){
            getproductcatall(e.target.value);
        }
      
        function getproductcatall(id){

            const token = sessionStorage.getItem('token');

            fetch(base_url+"get_category/"+id, {
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

                                var htmlhead ="<label class='form-label'>Categories</label><select class='form-select' id='prod_cat_name' onchange='getprod(event)'><option value='0'>Select Categories</option>";

                                for(var i = 0; i < value.length  ; i++){

                                    htmlString += "<option value="+value[i].prod_cat_id+">"+ value[i].prod_cat_name + "</option>"
                            
                                }

                                var htmlfooter ="</select><div class='text-danger' id='error_prod_cat_name'></div>";
                                
                                var htmlstringall = htmlhead+htmlString+htmlfooter;
                                $("#prod_cat_list").html(htmlstringall);
    
                                            
                            }
                        

                        }
                    });
        }

        function getprod(e){
            getproductall(e.target.value);
        }

        function getproductall(id){

            const token = sessionStorage.getItem('token');

            fetch(base_url+"get_product/"+id, {
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

                                var htmlhead ="<label class='form-label'>Product</label><select class='form-select' id='product_name' onchange='select_product(event)'><option value='0'>Select Product</option>";

                                for(var i = 0; i < value.length  ; i++){

                                    htmlString += "<option value="+value[i].product_id+">"+ value[i].product_name + "</option>"
                            
                                }

                                var htmlfooter ="</select><div class='text-danger' id='error_product_name'></div>";
                                
                                var htmlstringall = htmlhead+htmlString+htmlfooter;
                                $("#product_list").html(htmlstringall);
    
                                            
                            }
                        

                        }
                    });
        }

        function select_product(e){
            $val = e.target.value;
            const token = sessionStorage.getItem('token');
            fetch(base_url+"edit_product/"+$val, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                    
                if(data.status == '200'){
                
                    document.getElementById("amount").value = data.data[0].amount;
                    prod_amount = data.data[0].amount;
                
                }
            });

        };

        function add_aquantity(e){

            var qnt = e.target.value;
            document.getElementById("amount").value = prod_amount * qnt;
            
        }


        var today = new Date();
        var from_date = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
        var to_date = today.toISOString().split('T')[0];

        $('#data_filter').click(function(){
           from_date = document.getElementById('from_date').value;
           to_date   = document.getElementById('to_date').value;
     
           var branch_id = $('#branch_id').val();

           all(from_date,to_date,branch_id);
        });

        all(from_date,to_date,branch_id[1],permission);

        function all(from,to,branch_id,permission){

            const token = sessionStorage.getItem('token');

            data="from="+from+"&to="+to+"&branch_id="+branch_id;
            fetch(base_url+"sales?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
                    .then((response) => response.json())
                    .then((data) => {
                    

                        if(permission){
                            var cama=stringHasTheWhiteSpaceOrNot(permission);
                            if(cama){
                                var values = permission.split(",");
                                // console.log(values)

                                if(values.length > 0){
                                    // alert("values")
                                    var add   = values.includes('add');// true
                                
                                    

                                    if(add){                                                     
                                    $( "#add_sales" ).show();
                                    }else{
                                        $( "#add_sales" ).hide();
                                    }
                                    
                                                                            
                                }
                            
                                function include(arr, obj) {
                                    for (var i = 0; i < arr.length; i++) {
                                        if (arr[i] == obj) return true;
                                    }
                                }
                            } else {

                            //   if(permission){
                            //       $data += "";
                            //   }else{
                            //       $data += "";
                            //   }
                            }

                            function stringHasTheWhiteSpaceOrNot(value){
                                return value.indexOf(',') >= 0;
                            }

                        }else{
                            
                        }
                        if(data.status == '200'){

                            if(data.data){
                                
                                
                                const value = data.data;
                                var htmlString = "";

                                var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Date</th><th>Branch</th><th>Customer Name</th><th>Product / Category</th><th>Amount</th><th>Print</th></tr></thead><tbody>";

                                for(var i = 0; i < value.length  ; i++){

                                
                                    var  status = '';
                                    if(value[i].status == '0'){
                                        var status = 'checked';
                                    }
                                    var  action = '';
                                    //<td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='sales_status("+value[i].sales_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td>+"</td><td>" + "<a href='view_sales?p_id="+value[i].sales_id+"'"+"><i class='fa fa-eye eyc'></i></a><a href='edit_sales?sales_id="+value[i].sales_id+"'"+"><i class='fa fa-edit eyc'></i></a><a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model("+value[i].sales_id +")'><i class='fa fa-trash eyc'></i></a>"
                                    if(permission){
                                      
                                    
                                      var cama=stringHasTheWhiteSpaceOrNot(permission);
                                      if(cama){
                                          var values = permission.split(",");
                                          // console.log(values)

                                          if(values.length > 0){
                                              // alert("values")
                                              var print = values.includes('print');// true
                                             

                                             
                                             
                                              if(print){  
                                                action += "<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='print("+value[i].sales_id +")'><i class='fa fa-print eyc'></i></a>";
                                                }else{
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
                                     htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].date +"</td><td>" + value[i].branch_name +"</td><td>" + value[i].customer_first_name + " <span>" + value[i].customer_last_name + "</span><br/>" + value[i].customer_phone + "</td><td>" + value[i].product_name +'<br/ >'+value[i].prod_cat_name  +"</td><td>" + value[i].amount  + "</td><td>"+action+"</td></tr>";
                                    
                                }

                                var htmlfooter ="</tbody></table>";
                                
                                var htmlstringall = htmlhead+htmlString+htmlfooter;
                                $("#sales_list").html(htmlstringall);

                                datatable();
                                            
                            }
                        

                        }
                    });
        }

        function sales_status(id,status){

            if(status == '1'){
                var sales_status = 0;
            }else{
                var sales_status = 1;
            }
            const token = sessionStorage.getItem('token');
            fetch(base_url+"sales_status/"+id+'?status='+sales_status, {
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

        function print(id){
            const token = sessionStorage.getItem('token');

            fetch(base_url+"edit_sales/"+id, {
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

                            console.log(data.data[0]);

                            // $html_tr = "";

                            // $pay_modes = JSON.parse(data.data[0]);

                            // $pay_modes.map((menu) =>

                            // {

                            //     $html_tr += " <tr class='details'><td>"+menu.name+"</td><td>"+menu.amount+"</td></tr>"
                            

                            // });
                            var date = "<?php echo date('d-m-Y'); ?>";

                            $htmltr = "";

                            var newWin = window.open('','Print-Window');

                            newWin.document.open();

                            var date = "<?php echo date('d-m-Y'); ?>";

                            var amt = data.data[0].amount;
                            var value = parseInt(amt)*(data.data[0].gst/100);
                            value = Math.round(value/2);

                            var cgst = value;
                            var sgst = value;
                            
                            var html_content =  "<!DOCTYPE html><html><head><meta charset='utf-8' /><title>PAYMENT RECEIPT</title><style>.invoice-box {	max-width: 800px;margin: auto;padding: 0px;			border: 1px solid #eee;box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);font-size: 16px;		line-height: 24px;font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;	color: #555;}.invoice-box table {width: 100%;line-height: inherit;			text-align: left;}.invoice-box table td {padding: 5px;vertical-align: top;}	.invoice-box table tr td:nth-child(2) {	text-align: right;	}	.invoice-box table tr.top table td {padding-bottom: 20px;	}	.invoice-box table tr.top table td.title {font-size: 15px;	line-height: 15px;	color: #333;}.invoice-box table tr.information table td {			padding-bottom: 40px;	}.invoice-box table tr.heading td {	background: #eee;			border-bottom: 1px solid #ddd;	font-weight: bold;}	.invoice-box table tr.details td {	padding-bottom: 20px;}.invoice-box table tr.item td {border-bottom: 1px solid #eee;	}.invoice-box table tr.item.last td {border-bottom: none;}.invoice-box table tr.total :nth-child(2) {border-top: 2px solid #eee;font-weight: bold;	}	@media only screen and (max-width: 600px) {	.invoice-box table tr.top table td {width: 100%;				display: block;	text-align: center;	}.invoice-box table tr.information table td {		width: 100%;	display: block;	text-align: center;	}}	/** RTL **/	.invoice-box.rtl {	direction: rtl;	font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;}.invoice-box.rtl table {text-align: right;}.invoice-box.rtl table tr d:nth-child(2) {	text-align: left;}</style></head>	<body><div class='invoice-box' style='border: 1px solid #c6c6c6;'> <h2 align='center'>PAYMENT RECEIPT</h2><hr><table cellpadding='0' cellspacing='0'>	<tr class='top ' >	<td colspan='2' style='border-bottom: 1px solid #c6c6c6';>		<table>	<tr ><td class='title' ><img src='https://elysiumhosting.com/renew_UI/assets/logo/renew_1.png' style='float:left; width: 100%; max-width: 120px;    padding-top: 30px; margin-right:20px;' />			<div style='vertical-align:bottom ;'><h3>Renew+ Hair and Skin Care</h3><p>No.155, 2nd floor, 80 feet road,<br /> kk nagar, Madurai, Tami Nadu, India, 625020</p><p>+91 9150309990(M)</p><p>Email: renewhairskincare@gmail.com</p></div>	</td><td>Receipt  #: "+data.data[0].sales_id+"<br />		Created: "+date+"<br />	Due: "+data.data[0].date+"</td></tr></table></td></tr><tr class='information'><td colspan='2'><table><tr><td><h5>To:</h5><h3>Name : "+data.data[0].customer_first_name+" "+data.data[0].customer_last_name+"</h3>    <p style='margin:0px;'>"+data.data[0].customer_address+"</p><p style='margin:0px;'>+91 "+data.data[0].customer_phone+"(M)</p><p style='margin:0px;'>Email: "+data.data[0].customer_email+"</p></td><td></td>	</tr></table></td></tr>	<tr class='heading'><td>Payment Method</td> <td>Cash #</td>	</tr><tr class='details'>	<td>Cash</td>  <td>"+data.data[0].amount+"</td>	</tr>	<tr class='heading'>    <td>Description</td>		<td>Price</td>	</tr>	<tr class='item'>  <td>"+data.data[0].product_name+"</td>			<td>"+data.data[0].amount+".00</td>	</tr><tr class='total' style='font-size: 12px;'>	<td></td><td>Inc. CGST : "+cgst+".00</td>	</tr><tr class='total' style='font-size: 12px;'><td></td><td>Inc. SGST : "+sgst+".00</td>	</tr><tr class='total'>	<td></td><td>Total:"+data.data[0].amount+".00</td>	</tr><tr style='height:100px'>	<td></td><td></td>	</tr><tr >	<td>Customer's Signatory</td>	<td>Authorised Signatory</td>	</tr>	<tr style='height:20px'><td></td><td></td></tr>	</table></div></body></html>";    
                            newWin.document.write(html_content);
                            newWin.document.close();
                        }
                    }
                });
                            
        }

        var delete_id = '';

        function model(id){

            $('#sales_delete').modal('show');
            delete_id = id;
        }

        $('#delete').click(function(){

            const token = sessionStorage.getItem('token');

            fetch(base_url+"delete_sales/"+delete_id, {
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

                        $("#status_success").html("<div class='alert alert-success' role='alert'>Successfully Deleted!</div>");
                        
                        setTimeout(() => { $("#status_success").html("");}, 4000);    

                        }
                    });
        })

        function add_sale() {


            var branch_id    = document.getElementById("branch_id").value;
            var customer_id  = document.getElementById("customer_name").value;
            var brand_id     = document.getElementById("brand_name").value;
            var prod_cat_id  = document.getElementById("prod_cat_name").value;
            var product_id   = document.getElementById("product_name").value;
            var amount       = document.getElementById("amount").value;
            var quantity     = document.getElementById("quantity").value;
            

            if(branch_id == '0'){

                $("#error_branch_id").html("Please select Branch");

            }else{
                $("#error_branch_id").html("");
            } 
        
            if(customer_id == '0'){

                $("#error_customer_name").html("Please select Customer");

            }else{
                $("#error_customer_name").html("");
            } 

            if(brand_id == '0'){

                $("#error_brand_name").html("Please select brand");

            }else{
                $("#error_brand_name").html("");
            } 


            if(prod_cat_id == '0'){

                $("#error_prod_cat_name").html("Please select category");

            }else{
                $("#error_prod_cat_name").html("");
            } 

            if(product_id == '0'){

                $("#error_product_name").html("Please select product");

            }else{
                $("#error_product_name").html("");
            } 

            if(quantity <= 0){

                $("#error_quantity").html("Invalid quantity");

            }else{
                $("#error_quantity").html("");
            } 

            if(amount <= 0){

                $("#error_amount").html("Invalid payment");

            }else{
                $("#error_amount").html("");
            } 

            
        

            if(customer_id &&brand_id && prod_cat_id && product_id && amount && quantity){

                //document.getElementById('add_prod').style.pointerEvents = 'none';


                var data = "customer_id="+customer_id+"&brand_id="+brand_id+"&prod_cat_id="+prod_cat_id+"&product_id="+product_id+"&amount="+amount+"&quantity="+quantity;

                const token = sessionStorage.getItem('token');

                fetch(base_url+"add_sales?"+data, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                        },
                        method: "post",
                    })
                .then((response) => response.json())
                .then((data) => {

                //document.getElementById('add_prod').style.pointerEvents = 'auto';

                    
                    if(data.status == '200'){

                        $("#status_success").html("<div class='alert alert-success' role='alert'>Thank You!</div>");  
                        setTimeout(() => { $("#status_success").html("");window.location.href = "./sales";}, 4000);                        

                    }else if(data.status == '401'){
                        $("#status_success").html("<div class='alert alert-danger' role='alert'> Stock not avaliable this Branch!</div>");  
                        setTimeout(() => { $("#status_success").html("");}, 4000);  
                    }else{
                        $("#status_success").html("<div class='alert alert-danger' role='alert'>Invalid Input feilds!</div>");  
                        setTimeout(() => { $("#status_success").html("");}, 4000);  
                     //    $("#error_product_name").html(data.error_msg.product_name[0]);
                    
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


