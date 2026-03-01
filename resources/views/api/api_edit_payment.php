<script>
 var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
    var id=<?php if(isset($_GET['pay_id'])) echo $_GET['pay_id']; else echo ""?>;

    
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_payment/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
        if(data.status == '200'){
            
            
            document.getElementById("invoice_no").value = data.data[0].invoice_no;
            document.getElementById("receipt_no").value = data.data[0].receipt_no;
            document.getElementById("payment_date").value = data.data[0].payment_date;
            document.getElementById("amount").value = data.data[0].amount;
           
            document.getElementById("total_amount").value = data.data[0].total_amount;
            document.getElementById("balance").value = data.data[0].balance;
            document.getElementById("payment_status").value = data.data[0].payment_status;
           
            // document.getElementById("sitting_counts").value = data.data[0].sitting_count;
           
            // document.getElementById("tc_name").value = data.data[0].tc_name;
            // document.getElementById("treatment_name").value = data.data[0].treatment_name;
            // document.getElementById("customer_first_name").value = data.data[0].customer_first_name;

            // document.getElementById("cgst").html((data.data[0].amount/100)*18)/2;
            // document.getElementById("sgst").html((data.data[0].amount/100)*18)/2;
            $val =((data.data[0].amount/100)*18)/2;
            $("#cgst").html($val);
            $("#sgst").html($val);

            gettcatgoryall(data.data[0].tcategory_id);
            gettreatmentall(data.data[0].treatment_id);
            getcustomerall(data.data[0].customer_id);

            view(data.data[0]);
           
            

       

            
            

            function view(data){
                document.getElementById("tcat_name").value = data.tc_name;
                document.getElementById("treatment_name_v").value = data.treatment_name;
                document.getElementById("first_name").value = data.customer_first_name;
            }

          


            
            

      
        }
    });

    function pay_amount(e){

        var regex = /^\d+(\.\d{2,2})?$/;
        var amount = e.target.value;
        if(amount == '' || amount <= 0 || regex.test(amount) == false){
            $("#error_amount").html("Please enter valid amount");
        
        }else{

        
            var total_amount = $('#total_amount').val();

        
            
            if(parseInt(amount) > parseInt(total_amount)){
                
                $("#error_amount").html("your amount is excess paying amount");
                $("#balance").val(0);

            }else{
                var balance = parseInt(total_amount) - parseInt(amount);
                $("#balance").val(balance);

                $("#error_amount").html("");
            }
            
            
        }

    }

    function gettcatgoryall(id){

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

                            var htmlhead ="<label class='form-label'>Treatment category</label><select class='form-select' id='tc_name'><option value='0'>Select Treatment category</option>";

                            for(var i = 0; i < value.length  ; i++){
                                

                                function sel_status(value){
                                    if(value == id){ return 'selected';}else{ return '';}
                                }
                                

                                htmlString += "<option value='"+value[i].tcategory_id+"'"+sel_status(value[i].tcategory_id)+">"+ value[i].tc_name + "</option>";
                               
                               


                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_tc_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#payment_tcatgory_list").html(htmlstringall);

                            datatable();

                            
                                        
                        }
                    

                    }
                });
    }

    function gettreatmentall(id){

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

                            var htmlhead ="<label class='form-label'>Treatment</label><select class='form-select' id='treatment_name'><option value='0'>Select Treatment</option>";

                            for(var i = 0; i < value.length  ; i++){

                                function sel_status(value){
                                    if(value == id){ return 'selected';}else{ return '';}
                                }
                                

                                htmlString += "<option value='"+value[i].treatment_id+"'"+sel_status(value[i].treatment_id)+">"+ value[i].treatment_name + "</option>";

                                // htmlString += "<option value="+value[i].prod_cat_id+">"+ value[i].prod_cat_name + "</option>"
                         
                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_treatment_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#payment_treatment_list").html(htmlstringall);

                            datatable();

                            
                                        
                        }
                    

                    }
                });
    }

    function getcustomerall(id){

        const token = sessionStorage.getItem('token');

        fetch(base_url+"customer/0", {
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

                            var htmlhead ="<label class='form-label'>Customer</label><select class='form-select' id='customer_first_name'><option value='0'>Select Customer Name</option>";

                            for(var i = 0; i < value.length  ; i++){

                                function sel_status(value){
                                    if(value == id){ return 'selected';}else{ return '';}
                                }
                                

                                htmlString += "<option value='"+value[i].customer_id+"'"+sel_status(value[i].customer_id)+">"+ value[i].customer_first_name + "</option>";

                                
                         
                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_customer_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#payment_customer_list").html(htmlstringall);

                            datatable();

                            
                                        
                        }
                    

                    }
                });
    }

    function update_payment() {

        var invoice_no     = document.getElementById("invoice_no").value;
        var receipt_no     = document.getElementById("receipt_no").value;
        var tcategory_id   = document.getElementById("tc_name").value;
        var treatment_id   = document.getElementById("treatment_name").value;
        var customer_id    = document.getElementById("customer_first_name").value;
        var payment_date   = document.getElementById("payment_date").value;
        var amount         = document.getElementById("amount").value;
        var total_amount   = document.getElementById("total_amount").value;
        var balance        = document.getElementById("balance").value;
        var payment_status = document.getElementById("payment_status").value;
        var sitting_counts  = document.getElementById("sitting_counts").value;
        
        
        if(!invoice_no){

            $("#error_invoice_no").html("Please select product name");

        }else{
            $("#error_invoice_no").html("");
        } 
         if(!receipt_no){

            $("#error_receipt_no").html("Please select product name");

        }else{
            $("#error_receipt_no").html("");
        } 

        if(tcategory_id == '0'){

            $("#error_tc_name").html("Please select category name");

        }else{
            $("#error_tc_name").html("");
        } 


        if(treatment_id == '0'){

            $("#error_treatment_name").html("Please select treatment name");

        }else{
            $("#error_treatment_name").html("");
        } 
        if(customer_id == '0'){

            $("#error_customer_name").html("Please select customer name");

        }else{
            $("#error_customer_name").html("");
        } 
        
        if(!payment_date){

            $("#error_payment_date").html("Please select product name");

        }else{
            $("#error_payment_date").html("");
        } 
        if(!amount){

            $("#error_amount").html("Please select product name");

        }else{
            $("#error_amount").html("");
        } 
        if(!total_amount){

            $("#error_total_amount").html("Please select product name");

        }else{
            $("#error_total_amount").html("");
        } 
        if(!payment_status){

            $("#error_payment_status").html("Please select product name");

        }else{
            $("#error_payment_status").html("");
        } 
        if(!sitting_counts){

            $("#error_sitting_counts").html("Please select product name");

        }else{
            $("#error_sitting_counts").html("");
        } 

        

        if(invoice_no,receipt_no,tcategory_id,treatment_id,customer_id,payment_date,amount,total_amount,payment_status,sitting_counts, balance){
            document.getElementById('upd_payment').style.pointerEvents = 'none';
          var data = "invoice_no="+invoice_no+"&receipt_no="+receipt_no+"&tcategory_id="+tcategory_id+"&treatment_id="+treatment_id+"&customer_id="+customer_id+"&payment_date="+payment_date+"&amount="+amount+"&total_amount="+total_amount+"&payment_status="+payment_status+"&sitting_counts="+sitting_counts+"&balance_amount="+balance;

            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_payment/"+id+"?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {
                document.getElementById('upd_payment').style.pointerEvents = 'auto';
                if(data.status == '200'){

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Payment Successfully Updated!</div>");
                    
                    
                    setTimeout(() => {$("#status_success").html(""); window.location.href = "./payment";      document.getElementById('upd_payment').style.pointerEvents = 'none';}, 4000);
                    
                    

                }
            });
        }
    }

   
}


</script>
