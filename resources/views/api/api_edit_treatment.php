<script>
 var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{

       var base_url = window.location.origin+'/api/';
    //branch drop down select

    
    var id=<?php if(isset($_GET['t_id'])) echo $_GET['t_id']; else echo ""?>;

    
    const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_treatment/"+id, {
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

            document.getElementById("treatment_name").value = data.data[0].treatment_name;

           // 
          
            document.getElementById("amount").value = data.data[0].amount;
            document.getElementById("category_name").value = data.data[0].tc_name;
      
        }
    });

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

                            var htmlhead ="<label class='form-label'>Categories</label><select class='form-select' id='tc_name'><option value='0'>Select category</option>";

                            for(var i = 0; i < value.length  ; i++){
                                // var sel_status ="";

                                function sel_status(value){
                                    if(value == id){ return 'selected';}else{ return '';}
                                }
                                

                                htmlString += "<option value='"+value[i].tcategory_id+"'"+sel_status(value[i].tcategory_id)+">"+ value[i].tc_name + "</option>";
                               
                               


                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_tc_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#tc_list").html(htmlstringall);

                           

                            //datatable();

                            
                                        
                        }
                    

                    }
                });
    }


  
    
    
    function update_treatment() {

    
        var tc_id  = document.getElementById("tc_name").value;
        var treatment_name = document.getElementById("treatment_name").value;
        var amount = document.getElementById("amount").value;
    

        if(tc_id == '0'){

            $("#error_tc_name").html("Please select Category name");

        }else{
            $("#error_tc_name").html("");
        } 


        
        if(!treatment_name){

            $("#error_treatment_name").html("Please select Treatment name");

        }else{
            $("#error_treatment_name").html("");
        } 


        if(!amount || amount == 0){

            $("#error_amount").html("amount is invalid");

        }else{
            $("#error_amount").html("");
        } 


        

        

        if(tc_id,treatment_name,amount){

            document.getElementById('upd_treatmnt').style.pointerEvents = 'none';


            var data = "tc_id="+tc_id+"&treatment_name="+treatment_name+"&amount="+amount;

            const token = sessionStorage.getItem('token');

            fetch(base_url+"update_treatment/"+id+"?"+data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
            .then((response) => response.json())
            .then((data) => {
            
                
                if(data.status == '200'){

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Treatment Successfully Updated!</div>");
                    
                    // setTimeout(() => { $("#status_success").html("");}, 2000);
                    
                    setTimeout(() => {$("#status_success").html(""); window.location.href = "./treatment"}, 4000);
                    
                    

                }else{
                    document.getElementById('upd_treatmnt').style.pointerEvents = 'auto';
                }
            });
        }
    }

    }
</script>
