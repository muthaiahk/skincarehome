<script>
 var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
       var base_url = window.location.origin+'/api/';
    var id=<?php if(isset($_GET['tm_id'])) echo $_GET['tm_id']; else echo ""?>;

        
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_customer_treatment/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
        if(data.status == '200'){


             
            gettcall(data.data[0].tcategory_id);
            gettreatmentall(data.data[0].treatment_id);
            getuserall(data.data[0].customer_id);
            getprogressall(data.data[0].progress);
            document.getElementById("mobile").value = data.data[0].customer_phone;
        
            document.getElementById("remark").value = data.data[0].remarks;
          
          
            document.getElementById("tc_name").value = data.data[0].tc_name;
            document.getElementById("treatment_name").value = data.data[0].treatment_name;
            document.getElementById("customer_name").value = data.data[0].customer_first_name;
           
           
        
           
                 
        }
    });

    function pay_amount(e){

var regex = /^\d+(\.\d{2,2})?$/;




var amount = $('#amount').val();




var discount = e.target.value;

if(discount == '' ||  regex.test(discount) == false){
    $("#error_discount").html("Please enter valid amount");

}else{

//  var total_amount = $('#total_amount').val();
                

    if(parseInt(discount) >= parseInt(amount)){
        
        $("#error_discount").html("your amount is excess treatment amount");
        $("#amount").val(total_amount);

    }else{
        var final_amount = parseInt(amount) - parseInt(discount);
        $("#amount").val(final_amount);

        $("#error_discount").html("");
    }
    
    
}

}


    function update_treatment_management() {

        var customer_id = document.getElementById("edit_customer_name").value;
        var treatment_id = document.getElementById("edit_treatment_name").value;
        var tc_id = document.getElementById("edit_tc_name").value;
  
        

        if(customer_id == '0'){

            $("#error_edit_customer_name").html("Please select customer name");

        }else{
            $("#error_edit_customer_name").html("");
        } 

        if(treatment_id == '0'){

            $("#error_edit_treatment_name").html("Please select treatment name");

        }else{
            $("#error_edit_treatment_name").html("");
        } 

       
        if(tc_id == '0'){

            $("#error_edit_tc_name").html("Please select category name");

        }else{
            $("#error_edit_tc_name").html("");
        } 

        
        if(customer_id  && treatment_id && tc_id){
          //  document.getElementById('upd_customer_treatment').style.pointerEvents = 'none';

            var data = "customer_id="+customer_id+"&treatment_id="+treatment_id+"&tc_id="+tc_id;
               
            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_customer_treatment/"+id+"?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {
            // document.getElementById('upd_customer_treatment').style.pointerEvents = 'auto';
                
                if(data.status == '200'){

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Customer Treatment Successfully Updated!</div>");
                    
                    setTimeout(() => { $("#status_success").html("");window.location.href = "./treatment_management";document.getElementById('upd_customer_treatment').style.pointerEvents = 'none';}, 4000);  
                    

                }else{
                    
                    $("#status_success").html("<div class='alert alert-danger' role='alert'>"+data.message+"!</div>");
                    
                    setTimeout(() => { $("#status_success").html("");window.location.href = "./treatment_management";document.getElementById('upd_customer_treatment').style.pointerEvents = 'none';}, 4000);  
                }
            });
        }

    }

    function getuserall(id){

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

                    var htmlhead ="<option value='0'>Select Customer name</option>";

                    for(var i = 0; i < value.length  ; i++){
                        
                        function sel_status(value){
                            if(value == id){ return 'selected';}else{ return '';}
                        }
                                
                        if(value[i].status == '0'){

                            htmlString += "<option value='"+value[i].customer_id+"'"+sel_status(value[i].customer_id)+">"+ value[i].customer_first_name+" " + value[i].customer_last_name+ "</option>";
                                    
                        }
                    }
                                
                        var htmlstringall = htmlhead+htmlString;
                        $("#edit_customer_name").html(htmlstringall);
                        
                                        
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

                    var htmlhead ="<option value='0'>Select Lead Status</option>";

                    for(var i = 0; i < value.length  ; i++){

                        function sel_status(value){
                            if(value == id){ return 'selected';}else{ return '';}
                        }
                                
                        if(value[i].status == '0'){
                            htmlString += "<option value='"+value[i].treatment_id+"'"+sel_status(value[i].treatment_id)+">"+ value[i].treatment_name + "</option>";
                        }
                    }
                        
                    var htmlstringall = htmlhead+htmlString;
                    $("#edit_treatment_name").html(htmlstringall);
                                        
                }
                
            }
        });
    }

    function gettcall(id){

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

                    var htmlhead ="<option value='0'>Select Category Name</option>";

                    for(var i = 0; i < value.length  ; i++){

                        function sel_status(value){
                            if(value == id){ return 'selected';}else{ return '';}
                        }
                                
                        if(value[i].status == '0'){
                            htmlString += "<option value='"+value[i].tcategory_id+"'"+sel_status(value[i].tcategory_id)+">"+ value[i].tc_name + "</option>";
                        }
                    }
                        
                    var htmlstringall = htmlhead+htmlString;
                    $("#edit_tc_name").html(htmlstringall);
                                        
                }
                
            }
        });
    }


    function getprogressall(value){

      //  alert(value);

        var  progress = ['Ongoing','Not completed','Completed'];

       

        var htmlhead ="<option value='0'>Select Progress name</option>";
        var htmlString ="";

        for(var i = 0; i < progress.length  ; i++){


            function sel_status(values){
                if(values == value){ return 'selected';}else{ return '';}
            }

            htmlString += "<option value='"+progress[i]+"'"+sel_status(progress[i])+">"+ progress[i]+ "</option>";
            
        }

        var htmlstringall = htmlhead+htmlString;
        $("#edit_progress").html(htmlstringall);

    
                
    }

}

</script>
