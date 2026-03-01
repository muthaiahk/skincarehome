<script>
    var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./";
    }else{
        
        var base_url = window.location.origin+'/api/';
        var id=<?php if(isset($_GET['r_id'])) echo $_GET['r_id']; else echo ""?>;
        const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_role/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
            if(data.status == '200'){
                

                document.getElementById("pr_role_name").value = data.data[0].role_name;
            
                
        
            }
        });





        //global variable

        var arr="";

        var Array_obj = [
                            {name: 'general_setting', permission: []},
                            {name: 'email_setting', permission: []},
                            {name: 'company', permission: []},
                            {name: 'branch', permission: []},
                            {name: 'department', permission: []},
                            {name: 'designation', permission: []},
                            {name: 'brand', permission: []},
                            {name: 'lead_source', permission: []},
                            {name: 'lead_status', permission: []},
                            {name: 'product', permission: []},
                            {name: 'product_category', permission: []},
                            {name: 'treatment', permission: []},
                            {name: 'treatment_category', permission: []},
                            {name: 'role', permission: []},

                        ];



        fetch(base_url+"role_permission_view/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
            if(data.status == '200'){
                
                var permissions = data.data;
                var length = permissions.length;
                
                for (let i = 0; i < length; i++) {
                    var permission = permissions[i].permission;
                    var page       = permissions[i].page;
                    if (page === 'settings') {
    var setting_pages = JSON.parse(permission);
    Array_obj = setting_pages;

    setting_pages.map((menu) => {
        console.log(menu.name);
        var name = menu.name;
        var values = menu.permission;

        if (values.length > 0) {
            var list = include(values, 'list');
            var add = include(values, 'add');
            var edit = include(values, 'edit');
            var view = include(values, 'view');
            var del = include(values, 'delete');

            if (list) {
                const listElement = document.getElementById(`st_${name}_list`);
                if (listElement) listElement.checked = true;
            }
            if (add) {
                const addElement = document.getElementById(`st_${name}_add`);
                if (addElement) addElement.checked = true;
            }
            if (edit) {
                const editElement = document.getElementById(`st_${name}_edit`);
                if (editElement) editElement.checked = true;
            }
            if (view) {
                const viewElement = document.getElementById(`st_${name}_view`);
                if (viewElement) viewElement.checked = true;
            }
            if (del) {
                const deleteElement = document.getElementById(`st_${name}_delete`);
                if (deleteElement) deleteElement.checked = true;
            }
        }

        function include(arr, obj) {
            for (var i = 0; i < arr.length; i++) {
                if (arr[i] === obj) return true;
            }
            return false; // Ensure a fallback if not found
        }
    });
}

                    else{

                        if(permission){

                            var cama=stringHasTheWhiteSpaceOrNot(permission);
                            if(cama){
                                var values = permission.split(",");

                                if(values.length > 0){

                                    var list   = include(values, 'list'); // true
                                    var add    = include(values, 'add'); // true
                                    var edit   = include(values, 'edit'); // true
                                    var view   = include(values, 'view'); // true
                                    var del    = include(values, 'delete'); // true
                                    var print  = include(values, 'print'); // true
                                    var exp    = include(values, 'export'); // true

                                
                                    if(list){  document.getElementById(page+"_list").checked = true;}
                                    if(add){  document.getElementById(page+"_add").checked = true;}
                                    //else{document.getElementById(page+"_view").checked = false;}
                                    if(edit){  document.getElementById(page+"_edit").checked = true;}
                                    //else{document.getElementById(page+"_view").checked = false;}
                                    if(view){  document.getElementById(page+"_view").checked = true;}
                                    //else{document.getElementById(page+"_view").checked = false;}
                                    if(del){  document.getElementById(page+"_delete").checked = true;}
                                    //else{document.getElementById(page+"_view").checked = false;}
                                    if(print){  document.getElementById(page+"_print").checked = true;}
                                    if(exp){  document.getElementById(page+"_export").checked = true;}
                                }
                            
                            

                                function include(arr, obj) {
                                    for (var i = 0; i < arr.length; i++) {
                                        if (arr[i] == obj) return true;
                                    }
                                }


                            } else {
                            

                                if(permission){
                                    document.getElementById(page+"_view").checked = true;
                                }else{
                                    document.getElementById(page+"_view").checked = false;
                                }
                                
                            
                            }

                        }else{
                            document.getElementById(page+"_view").checked = false;
                        }

                    }

                    
                   // alert(page+permission);
                   
                    //alert(i);
                }


                
               
            }

            function stringHasTheWhiteSpaceOrNot(value){
                return value.indexOf(',') >= 0;
            }

        });

        
      
        function change(checkbox)
        {
            
            const permission = Array_obj.map((menu) =>

                {
                    if(menu.name == checkbox.name ){

                        $value = menu.permission;

                        arr = $value;

                       

                        if(checkbox.checked == true)
                        {
                            arr.push(checkbox.value);
                                                       
                        }
                        else
                        {
                            var j = arr.indexOf(checkbox.value);
                            arr.splice(j, 1);
                        }
                        
                    }
                }
                
                
            );

            const upd_obj = Array_obj.map((menu) =>
                menu.name == checkbox.name // from state
                ? { ...menu, permission: arr}
                : menu
            );

            Array_obj = upd_obj;

            //console.log(Array_obj);

           
        }

   
      $('#add_permission').click(function(event) {
         event.preventDefault(); // Prevent default form submission
    
         // Show loading state
         const button = $(this);
         const spinner = button.find('.spinner-border');
         
         // Change button state to loading
         button.prop('disabled', true);
         spinner.show(); // Show the loading spinner
         button.text('Submitting...'); // Change button text
         //   console.log(JSON.stringify(Array_obj));
            
            const token = sessionStorage.getItem('token');

            var dashborad           = [];
            var lead                = [];
            var followup            = [];
            var customer            = [];
            var customer_treatment  = [];
            var appointment         = [];
            var customer_payment    = [];
            var consultation        = [];
            var sales               = [];
            var invoice             = [];
            var inventory           = [];
            var staff               = [];
            var attendance          = [];
            // var treatment      = [];
            // var payment        = [];
            
            var lead_rpt         = [];
            var appointment_rpt  = [];
            var stock_rpt        = [];
            var attendance_rpt   = [];
            var payment_rpt      = [];

            var dashboard_view      = document.getElementById("dashboard_view").checked ;
            var dashboard_list      = document.getElementById("dashboard_list").checked;
           
            if(dashboard_list){
                dashborad.push('list');
            }
            if(dashboard_view){
                dashborad.push('view');
            }

            var lead_list      = document.getElementById("lead_list").checked;
            var lead_add       = document.getElementById("lead_add").checked;
            var lead_edit      = document.getElementById("lead_edit").checked;
            var lead_view      = document.getElementById("lead_view").checked;
            var lead_delete    = document.getElementById("lead_delete").checked;

            if(lead_list){
               lead.push('list');
            }
            if(lead_add){
               lead.push('add');
            }
            if(lead_edit){
               lead.push('edit');
            }
            if(lead_view){
               lead.push('view');
            }
            if(lead_delete){
               lead.push('delete');
            }

            var followup_list       = document.getElementById("followup_list").checked;
            var followup_add        = document.getElementById("followup_add").checked;
            var followup_edit       = document.getElementById("followup_edit").checked;
            var followup_view       = document.getElementById("followup_view").checked;
            var followup_delete     = document.getElementById("followup_delete").checked;
            
            if(followup_list){
               followup.push('list');
            }
            if(followup_add){
               followup.push('add');
            }
            if(followup_edit){
               followup.push('edit');
            }
            if(followup_view){
               followup.push('view');
            }
            if(followup_delete){
               followup.push('delete');
            }


            var customer_list        = document.getElementById("customer_list").checked;
            var customer_add        = document.getElementById("customer_add").checked;
            var customer_edit       = document.getElementById("customer_edit").checked;
            var customer_view       = document.getElementById("customer_view").checked;
            var customer_delete     = document.getElementById("customer_delete").checked;
            
            if(customer_list){
               customer.push('list');
            }
            if(customer_add){
               customer.push('add');
            }
            if(customer_edit){
               customer.push('edit');
            }
            if(customer_view){
               customer.push('view');
            }
            if(customer_delete){
               customer.push('delete');
            }

            var customer_treatment_list        = document.getElementById("customer_treatment_list").checked;
            var customer_add                   = document.getElementById("customer_treatment_add").checked;
            var customer_treatment_edit        = document.getElementById("customer_treatment_edit").checked;
            var customer_treatment_view        = document.getElementById("customer_treatment_view").checked;
            var customer_treatment_delete      = document.getElementById("customer_treatment_delete").checked;
            var customer_treatment_print     = document.getElementById("customer_treatment_print").checked;

            if(customer_treatment_list){
               customer_treatment.push('list');
            }
            if(customer_treatment_add){
               customer_treatment.push('add');
            }
            if(customer_treatment_edit){
               customer_treatment.push('edit');
            }
            if(customer_treatment_view){
               customer_treatment.push('view');
            }
            if(customer_treatment_delete){
               customer_treatment.push('delete');
            }
            if(customer_treatment_print){
               customer_treatment.push('print');
            }

           

            var appointment_list     = document.getElementById("appointment_list").checked;
            var appointment_add     = document.getElementById("appointment_add").checked;
            var appointment_edit    = document.getElementById("appointment_edit").checked;
            var appointment_view    = document.getElementById("appointment_view").checked;
            var appointment_delete  = document.getElementById("appointment_delete").checked;

            if(appointment_list){
               appointment.push('list');
            }
            if(appointment_add){
               appointment.push('add');
            }
            if(appointment_edit){
               appointment.push('edit');
            }
            if(appointment_view){
               appointment.push('view');
            }
            if(appointment_delete){
               appointment.push('delete');
            }

            var customer_payment_list     = document.getElementById("customer_payment_list").checked;
            var customer_payment_add     = document.getElementById("customer_payment_add").checked;
            var customer_payment_edit    = document.getElementById("customer_payment_edit").checked;
            var customer_payment_view    = document.getElementById("customer_payment_view").checked;
            var customer_payment_delete  = document.getElementById("customer_payment_delete").checked;
            var customer_payment_print  = document.getElementById("customer_payment_print").checked;

            if(customer_payment_list){
               customer_payment.push('list');
            }
            if(customer_payment_add){
               customer_payment.push('add');
            }
            if(customer_payment_edit){
               customer_payment.push('edit');
            }
            if(customer_payment_view){
               customer_payment.push('view');
            }
            if(customer_payment_delete){
               customer_payment.push('delete');
            }
            if(customer_payment_print){
               customer_payment.push('print');
            }

            var consultation_list    = document.getElementById("consultation_list").checked;
            var consultation_add     = document.getElementById("consultation_add").checked;
            var consultation_edit    = document.getElementById("consultation_edit").checked;
            var consultation_view    = document.getElementById("consultation_view").checked;
            var consultation_delete  = document.getElementById("consultation_delete").checked;
            var consultation_print   = document.getElementById("consultation_print").checked;

            if(consultation_list){
               consultation.push('list');
            }
            if(consultation_add){
               consultation.push('add');
            }
            if(consultation_edit){
               consultation.push('edit');
            }
            if(consultation_view){
               consultation.push('view');
            }
            if(consultation_delete){
               consultation.push('delete');
            }
            if(consultation_print){
               consultation.push('print');
            }


            var sales_list        = document.getElementById("sales_list").checked;
            var sales_add         = document.getElementById("sales_add").checked;
            var sales_edit        = document.getElementById("sales_edit").checked;
            var sales_view        = document.getElementById("sales_view").checked;
            var sales_delete      = document.getElementById("sales_delete").checked;
            var sales_print       = document.getElementById("sales_print").checked;

            if(sales_list){
               sales.push('list');
            }
            if(sales_add){
               sales.push('add');
            }
            if(sales_edit){
               sales.push('edit');
            }
            if(sales_view){
               sales.push('view');
            }
            if(sales_delete){
               sales.push('delete');
            }
            if(sales_print){
               sales.push('print');
            }


            


            var invoice_list       = document.getElementById("invoice_list").checked;
            var invoice_add        = document.getElementById("invoice_add").checked;
            var invoice_edit       = document.getElementById("invoice_edit").checked;
            var invoice_view       = document.getElementById("invoice_view").checked;
            var invoice_delete     = document.getElementById("invoice_delete").checked;
            var invoice_print      = document.getElementById("invoice_print").checked;

            if(invoice_list){
               invoice.push('list');
            }
            if(invoice_add){
               invoice.push('add');
            }
            if(invoice_edit){
               invoice.push('edit');
            }
            if(invoice_view){
               invoice.push('view');
            }
            if(invoice_delete){
               invoice.push('delete');
            }
            if(invoice_print){
               invoice.push('print');
            }


            var inventory_list      = document.getElementById("inventory_list").checked;
            var inventory_add       = document.getElementById("inventory_add").checked;
            var inventory_edit      = document.getElementById("inventory_edit").checked;
            var inventory_view      = document.getElementById("inventory_view").checked;
            var inventory_delete    = document.getElementById("inventory_delete").checked;

            if(inventory_list){
               inventory.push('list');
            }
            if(inventory_add){
               inventory.push('add');
            }
            if(inventory_edit){
               inventory.push('edit');
            }
            if(inventory_view){
               inventory.push('view');
            }
            if(inventory_delete){
               inventory.push('delete');
            }



            var staff_list          = document.getElementById("staff_list").checked;
            var staff_add           = document.getElementById("staff_add").checked;
            var staff_edit          = document.getElementById("staff_edit").checked;
            var staff_view          = document.getElementById("staff_view").checked;
            var staff_delete        = document.getElementById("staff_delete").checked;

            if(staff_list){
               staff.push('list');
            }
            if(staff_add){
               staff.push('add');
            }
            if(staff_edit){
               staff.push('edit');
            }
            if(staff_view){
               staff.push('view');
            }
            if(staff_delete){
               staff.push('delete');
            }

            var attendance_list          = document.getElementById("attendance_list").checked;
            var attendance_add           = document.getElementById("attendance_add").checked;
            var attendance_edit          = document.getElementById("attendance_edit").checked;
            var attendance_view          = document.getElementById("attendance_view").checked;
            var attendance_delete        = document.getElementById("attendance_delete").checked;

            if(attendance_list){
               attendance.push('list');
            }
            if(attendance_add){
               attendance.push('add');
            }
            if(attendance_edit){
               attendance.push('edit');
            }
            if(attendance_view){
               attendance.push('view');
            }
            if(attendance_delete){
               attendance.push('delete');
            }

           
          

            
            var lead_rpt_list            = document.getElementById("lead_rpt_list").checked;
            var lead_rpt_view            = document.getElementById("lead_rpt_view").checked;
            var lead_rpt_export          = document.getElementById("lead_rpt_export").checked;
            var appointment_rpt_list     = document.getElementById("appointment_rpt_list").checked;
            var appointment_rpt_view     = document.getElementById("appointment_rpt_view").checked;
            var appointment_rpt_export   = document.getElementById("appointment_rpt_export").checked;
            var stock_rpt_view           = document.getElementById("stock_rpt_view").checked;
            var stock_rpt_list           = document.getElementById("stock_rpt_list").checked;
            var stock_rpt_export         = document.getElementById("stock_rpt_export").checked;
            var attendance_rpt_view      = document.getElementById("attendance_rpt_view").checked;
            var attendance_rpt_list      = document.getElementById("attendance_rpt_list").checked;
            var attendance_rpt_export    = document.getElementById("attendance_rpt_export").checked;
            var payment_rpt_view         = document.getElementById("payment_rpt_view").checked;
            var payment_rpt_list         = document.getElementById("payment_rpt_list").checked;
            var payment_rpt_export       = document.getElementById("payment_rpt_export").checked;

           

            if(lead_rpt_view){
                lead_rpt.push('view');
            }
            if(appointment_rpt_view){
                appointment_rpt.push('view');
            }
            if(stock_rpt_view){
                stock_rpt.push('view');
            }
            if(attendance_rpt_view){
                attendance_rpt.push('view');
            }
            if(payment_rpt_view){
                payment_rpt.push('view');
            }
            if(lead_rpt_list){
                lead_rpt.push('list');
            }
            if(appointment_rpt_list){
                appointment_rpt.push('list');
            }
            if(stock_rpt_list){
                stock_rpt.push('list');
            }
            if(attendance_rpt_list){
                attendance_rpt.push('list');
            }
            if(payment_rpt_list){
                payment_rpt.push('list');
            }
            if(lead_rpt_export){
                lead_rpt.push('export');
            }
            if(appointment_rpt_export){
                appointment_rpt.push('export');
            }
            if(stock_rpt_export){
                stock_rpt.push('export');
            }
            if(attendance_rpt_export){
                attendance_rpt.push('export');
            }
            if(payment_rpt_export){
                payment_rpt.push('export');
            }



            var data = "page[]=dashboard&dashboard_permission="+dashborad+"&page[]=lead&lead_permission="+lead+"&page[]=followup&followup_permission="+followup+"&page[]=customer&customer_permission="+customer+"&page[]=customer_treatment&customer_treatment_permission="+customer_treatment+"&page[]=appointment&appointment_permission="+appointment+"&page[]=customer_payment&customer_payment_permission="+customer_payment+"&page[]=consultation&consultation_permission="+consultation+"&page[]=sales&sales_permission="+sales+ "&page[]=invoice&invoice_permission="+invoice+ "&page[]=inventory&inventory_permission="+inventory+ "&page[]=staff&staff_permission="+staff+ "&page[]=attendance&attendance_permission="+attendance+"&page[]=lead_rpt&lead_rpt_permission="+lead_rpt+ "&page[]=appointment_rpt&appointment_rpt_permission="+appointment_rpt+ "&page[]=stock_rpt&stock_rpt_permission="+stock_rpt+ "&page[]=attendance_rpt&attendance_rpt_permission="+attendance_rpt+"&page[]=payment_rpt&payment_rpt_permission="+payment_rpt+"&page[]=settings&settings_permission="+JSON.stringify(Array_obj);
     



            

            // fetch(base_url+"role_permission/"+id+"/?"+data, {
            //         headers: {
            //             "Content-Type": "application/x-www-form-urlencoded",
            //             'Authorization': `Bearer ${token}`, // notice the Bearer before your token
            //         },
            //         method: "GET",
            //     })
            //     .then((response) => response.json())
            //         .then((data) => {
            //             // Reset button state
            //             button.prop('disabled', false);
            //             spinner.hide(); // Hide the loading spinner
            //             button.text('Submit'); // Reset button text
            //             if(data.status == 200){

            //                 // all();

            //                 $("#status_success").html("<div class='alert alert-success' role='alert'>"+data.message+"!</div>");
                            
            //                //  setTimeout(() => { $("#status_success").html("");}, 4000);    
            //                 setTimeout(() => { $("#status_success").html("");window.location.href = "./role_permission"}, 3000);

            //             }

            //         });
            fetch(base_url + "role_permission/" + id + "/?" + data, {
                     headers: {
                           "Content-Type": "application/x-www-form-urlencoded",
                           'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                     },
                     method: "GET",
                  })
                  .then((response) => response.json())
                  .then((data) => {
                     // Reset button state
                     button.prop('disabled', false);
                     spinner.hide(); // Hide the loading spinner
                     button.text('Submit'); // Reset button text
                     
                     if(data.status == 200) {
                           $("#status_success").html("<div class='alert alert-success' role='alert'>"+data.message+"!</div>");
                           setTimeout(() => { 
                              $("#status_success").html("");
                              window.location.href = "./role_permission";
                           }, 3000);
                     } else {
                           // Handle error response here if needed
                           $("#status_success").html("<div class='alert alert-danger' role='alert'>Error: "+data.message+"</div>");
                           setTimeout(() => { $("#status_success").html(""); }, 4000);
                     }
                  })
                  .catch((error) => {
                     // Handle fetch error
                     console.error('Error:', error);
                     button.prop('disabled', false);
                     spinner.hide(); // Hide the loading spinner
                     button.text('Submit'); // Reset button text
                     $("#status_success").html("<div class='alert alert-danger' role='alert'>Something went wrong!</div>");
                     setTimeout(() => { $("#status_success").html(""); }, 4000);
            });
        })

    }
</script>
