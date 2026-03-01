<script>

   
    var stock_report = '';
    

    var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
       var base_url = window.location.origin+'/api/';
        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);
        inventory(brand_id='',branch_id[1],cat_id='',pro_id='',);
       


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

        function inventory(brand_id,branch_id,cat_id,pro_id,print_enable=false){

            const token = sessionStorage.getItem('token');
            let params = new URLSearchParams();
         
            params.append('brand_id', brand_id);
            params.append('prod_category_id', cat_id);
            params.append('product_id', pro_id);
            params.append('branch_id', branch_id);

            fetch(base_url+"stock_report", {
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

                        var htmlhead ="<table class='display' id='advance-3'><thead><tr><th>Sl no</th><th>Brand</th><th>Categories</th><th>Product Name</th><th>Stock</th></tr></thead><tbody>";

                        for(var i = 0; i < value.length  ; i++){


                            htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].brand_name+"</td><td>" + value[i].prod_cat_name +"</td><td>"+ value[i].product_name+"</td><td>" + value[i].stock_in_hand+"</td></tr>";
                                    
                        }

                        var htmlfooter ="</tbody></table>";
                                
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#inventory_report").html(htmlstringall);
                            stock_report = htmlstringall;
                            datatable();
                            
                            
                            
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
            
       
        $('#product_cat_filter').on('click', function() {
           // $('#lead_loader').modal('show');
            var brand_id = document.getElementById("brand_list").value;
            var cat_id = document.getElementById("product_cat_list").value;
            var pro_id = document.getElementById("product_list").value;
            var branch_id = $('#branch_name').val();
            inventory(brand_id,branch_id,cat_id,pro_id);
        });
        
        function stock_report_export(){
            var brand_id = document.getElementById("brand_list").value;
            var cat_id = document.getElementById("product_cat_list").value;
            var pro_id = document.getElementById("product_list").value;
            var branch_id = $('#branch_name').val();
            inventory(brand_id,branch_id,cat_id,pro_id,true);
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

        function datatable(){
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
