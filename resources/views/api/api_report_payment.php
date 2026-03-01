<script>

  
    var pay_report = '';


    var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
       var base_url = window.location.origin+'/api/';
        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);
        payment(branch_id[1]);

        function payment(tc_id,t_id='',p_id=2,branch_id,print_enable=false){

            const token = sessionStorage.getItem('token');

            var from_date =   $('#from_date').val();
            var to_date   =   $('#to_date').val();

            let params = new URLSearchParams();

            params.append('from_date', from_date);
            params.append('to_date', to_date);
            params.append('treatment_cat_id', tc_id);
            params.append('treatment_id', t_id);
            params.append('pending', p_id);
            params.append('branch_id', branch_id);

            fetch(base_url+"payment_report", {
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
                   // $('#lead_loader').modal('hide');
                    //document.getElementById("company_name").value = sessionStorage.getItem('company');

                    // if(data.data){
                                
                    //     const value = data.data;
                    //     var htmlString = "";

                    //     var htmlhead ="<table class='display' id='advance-5'><thead><tr><th>Invoice No</th><th>Date</th><th>Treatment category</th><th>Treatment</th><th>Customer</th><th>Count of Sitting</th><th>Amount</th><th>Discount</th><th>Paid Amount</th><th>Pending Amount</th><th>Payment Status</th></tr></thead><tbody>";

                    //     for(var i = 0; i < value.length  ; i++){

                    //         var  status = '';
                    //         if(value[i].status == '0'){
                    //             var status = 'checked';
                    //         }


                    //         var  paid_status = "<span class='bg-success p-1 rounded'>Paid<span>";
                    //         if(value[i].pending > 0){
                    //             paid_status = "<span class='bg-danger p-1 rounded'>Pending<span>";
                    //         }



                    //         htmlString += "<tr>"+"<td>" + value[i].invoice_no + "</td><td>" + value[i].date + "</td><td>" +  value[i].category_name + "</td><td>" +  value[i].treatment_name + "</td><td>"+ value[i].customer_name + "</td><td>"+ value[i].sitting_count + "</td><td>"+ value[i].amount + "</td><td>"+ value[i].discount + "</td><td>"+ value[i].paid_amount + "</td><td>"+ value[i].pending + "</td><td>"+ paid_status+ "</td></tr>";


                    //         // <td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='status("+value[i].p_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td><td>" + "<a href='view_payment?pay_id="+value[i].p_id+"'"+"><i class='fa fa-eye eyc'></i></a><a href='edit_payment?pay_id="+value[i].p_id+"'"+"><i class='fa fa-edit eyc'></i></a><a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model("+value[i].p_id +")'><i class='fa fa-trash eyc'></i></a>" + "</td>
                            
                    //     }

                    //     var htmlfooter ="</tbody></table>";

                    //     var htmlstringall = htmlhead+htmlString+htmlfooter;
                    //     $("#payment_report").html(htmlstringall);
                    //     pay_report = htmlstringall;
                    //     datatable();
                        
                        
                    //     if(print_enable){
                        
                    //         var values = [];
                            
                    //         value.map((data,i)=>{
                    //             values.push({'Sl No':i+1,'Invoice No':data.invoice_no,'Date':data.date,'Treatment Category':data.category_name,'Treatment':data.treatment_name,'Customer':data.customer_name,'Count of Sitting':data.sitting_count,'Status':data.progress,'Amount':data.amount,'Discount':data.discount,'Paid Amount':data.paid_amount,'Pending Amount':data.pending,'Payment Status':data.paid_status})
                    //         })
             

                    //         var filename='payment_reports.xlsx';
                       
                    //         var ws = XLSX.utils.json_to_sheet(values);
                    //         var wb = XLSX.utils.book_new();
                    //         XLSX.utils.book_append_sheet(wb, ws, "People");
                    //         XLSX.writeFile(wb,filename);
                    //     } 
                                            
                    // }
                    //  if (data.data) {
                    //     const value = data.data;
                    //     var htmlString = "";

                    //     var htmlhead = "<table class='display' id='advance-5'><thead><tr><th>Invoice No</th><th>Date</th><th>Treatment category</th><th>Treatment</th><th>Customer</th><th>Count of Sitting</th><th>Amount</th><th>Discount</th><th>GST</th><th>Paid Amount</th><th>Pending Amount</th><th>Payment Status</th></tr></thead><tbody>";

                    //     let totalAmount = 0;
                    //     let totalGst = 0;
                    //     let totalPaidAmount = 0;
                    //     let totalPending = 0;

                    //     for (var i = 0; i < value.length; i++) {
                    //         var status = '';
                    //         if (value[i].status == '0') {
                    //             var status = 'checked';
                    //         }

                    //         var paid_status = "<span class='bg-success p-1 rounded'>Paid<span>";
                    //         if (value[i].pending > 0) {
                    //             paid_status = "<span class='bg-danger p-1 rounded'>Pending<span>";
                    //         }
                    //          var invoice = value[i].invoice_no;
                    //         if (value[i].invoice_no == null) {
                    //             invoice = " ";
                    //         }

                    //         htmlString += "<tr>" +
                    //             "<td>" + invoice + "</td>" +
                    //             "<td>" + value[i].date + "</td>" +
                    //             "<td>" + value[i].category_name + "</td>" +
                    //             "<td>" + value[i].treatment_name + "</td>" +
                    //             "<td>" + value[i].customer_name + "</td>" +
                    //             "<td>" + value[i].sitting_count + "</td>" +
                    //             "<td>" + value[i].amount + "</td>" +
                    //             "<td>" + value[i].discount + "</td>" +
                    //             "<td>" + value[i].gst + "</td>" +
                    //             "<td>" + value[i].paid_amount + "</td>" +
                    //             "<td>" + value[i].pending + "</td>" +
                    //             "<td>" + paid_status + "</td>" +
                    //             "</tr>";

                    //         totalAmount += parseFloat(value[i].amount);
                    //         totalGst += parseFloat(value[i].gst);
                    //         totalPaidAmount += parseFloat(value[i].paid_amount);
                    //         totalPending += parseFloat(value[i].pending);
                    //     }

                    //     var totalRow = "<tr>" +
                    //         "<td colspan='6'><strong>Total</strong></td>" +
                    //         "<td><strong>" + totalAmount.toFixed(2) + "</strong></td>" +
                    //         "<td></td>" +
                    //         "<td><strong>" + totalGst.toFixed(2) + "</strong></td>" +
                    //         "<td><strong>" + totalPaidAmount.toFixed(2) + "</strong></td>" +
                    //         "<td><strong>" + totalPending.toFixed(2) + "</strong></td>" +
                    //         "<td></td>" +
                    //         "</tr>";

                    //     var htmlfooter = "</tbody></table>";
                    //     var htmlstringall = htmlhead + htmlString + totalRow + htmlfooter;

                    //     $("#payment_report").html(htmlstringall);
                    //     pay_report = htmlstringall;
                    //     datatable();

                    //     if (print_enable) {
                    //         var values = [];

                    //         value.map((data, i) => {
                    //             values.push({
                    //                 'Sl No': i + 1,
                    //                 'Invoice No': data.invoice_no,
                    //                 'Date': data.date,
                    //                 'Treatment Category': data.category_name,
                    //                 'Treatment': data.treatment_name,
                    //                 'Customer': data.customer_name,
                    //                 'Count of Sitting': data.sitting_count,
                    //                 'Status': data.progress,
                    //                 'Amount': data.amount,
                    //                 'Discount': data.discount,
                    //                 'GST': data.gst,
                    //                 'Paid Amount': data.paid_amount,
                    //                 'Pending Amount': data.pending,
                    //                 'Payment Status': data.paid_status
                    //             });
                    //         });

                    //         // Adding totals row to the Excel export
                    //         values.push({
                    //             'Sl No': '',
                    //             'Invoice No': '',
                    //             'Date': '',
                    //             'Treatment Category': '',
                    //             'Treatment': '',
                    //             'Customer': '',
                    //             'Count of Sitting': '',
                    //             'Status': 'Total',
                    //             'Amount': totalAmount.toFixed(2),
                    //             'Discount': '',
                    //             'GST': gst.toFixed(2),
                    //             'Paid Amount': totalPaidAmount.toFixed(2),
                    //             'Pending Amount': totalPending.toFixed(2),
                    //             'Payment Status': ''
                    //         });

                    //         var filename = 'payment_reports.xlsx';
                    //         var ws = XLSX.utils.json_to_sheet(values);
                    //         var wb = XLSX.utils.book_new();
                    //         XLSX.utils.book_append_sheet(wb, ws, "Payment Reports");
                    //         XLSX.writeFile(wb, filename);
                    //     }
                    // }
                     if (data.data) {
                        const value = data.data;
                        // state_id = data.data[0].state_id;
                        var htmlString = "";

                        var htmlhead = "<table class='display' id='advance-5'><thead><tr><th>Invoice No</th><th>Date</th><th>Treatment category</th><th>Treatment</th><th>Customer</th><th>Count of Sitting</th><th>Amount</th><th>Discount</th><th>CGST</th><th>SGST</th><th>IGST</th><th>Paid Amount</th><th>Pending Amount</th><th>Payment Status</th></tr></thead><tbody>";

                        let totalAmount = 0;
                        let totalCGst = 0;
                        let totalSGst = 0;
                        let totalIGst = 0;
                        let totalPaidAmount = 0;
                        let totalPending = 0;

                        for (var i = 0; i < value.length; i++) {
                            var status = '';
                            if (value[i].status == '0') {
                                var status = 'checked';
                            }

                            var paid_status = "<span class='bg-success p-1 rounded'>Paid<span>";
                            if (value[i].pending > 0) {
                                paid_status = "<span class='bg-danger p-1 rounded'>Pending<span>";
                            }
                            var invoice = value[i].invoice_no;
                            if (value[i].invoice_no == null) {
                                invoice = " ";
                            }

                            var cgst = 0;
                            var sgst = 0;
                            var igst = 0;
                            if (value[i].state_id == 23) {
                                cgst = value[i].gst / 2;
                                sgst = value[i].gst / 2;
                            } else {
                                igst = value[i].gst;
                            }

                            htmlString += "<tr>" +
                                "<td>" + invoice + "</td>" +
                                "<td>" + value[i].date + "</td>" +
                                "<td>" + value[i].category_name + "</td>" +
                                "<td>" + value[i].treatment_name + "</td>" +
                                "<td>" + value[i].customer_name + "</td>" +
                                "<td>" + value[i].sitting_count + "</td>" +
                                "<td>" + value[i].amount + "</td>" +
                                "<td>" + value[i].discount + "</td>" +
                                "<td>" + cgst.toFixed(2) + "</td>" +
                                "<td>" + sgst.toFixed(2) + "</td>" +
                                "<td>" + igst.toFixed(2) + "</td>" +
                                "<td>" + value[i].paid_amount + "</td>" +
                                "<td>" + value[i].pending + "</td>" +
                                "<td>" + paid_status + "</td>" +
                                "</tr>";

                            totalAmount += parseFloat(value[i].amount);
                            totalCGst += parseFloat(cgst);
                            totalSGst += parseFloat(sgst);
                            totalIGst += parseFloat(igst);
                            totalPaidAmount += parseFloat(value[i].paid_amount);
                            totalPending += parseFloat(value[i].pending);
                        }

                        var totalRow = "<tr>" +
                            "<td colspan='6'><strong>Total</strong></td>" +
                            "<td><strong>" + totalAmount.toFixed(2) + "</strong></td>" +
                            "<td></td>" +
                            "<td><strong>" + totalCGst.toFixed(2) + "</strong></td>" +
                            "<td><strong>" + totalSGst.toFixed(2) + "</strong></td>" +
                            "<td><strong>" + totalIGst.toFixed(2) + "</strong></td>" +
                            "<td><strong>" + totalPaidAmount.toFixed(2) + "</strong></td>" +
                            "<td><strong>" + totalPending.toFixed(2) + "</strong></td>" +
                            "<td></td>" +
                            "</tr>";

                        var htmlfooter = "</tbody></table>";
                        var htmlstringall = htmlhead + htmlString + totalRow + htmlfooter;

                        $("#payment_report").html(htmlstringall);
                        pay_report = htmlstringall;
                        datatable();

                        if (print_enable) {
                            var values = [];

                            value.map((data, i) => {
                                let cgst = 0;
                                let sgst = 0;
                                let igst = 0;
                                if (state_id == 23) {
                                    cgst = data.gst / 2;
                                    sgst = data.gst / 2;
                                } else {
                                    igst = data.gst;
                                }

                                values.push({
                                    'Sl No': i + 1,
                                    'Invoice No': data.invoice_no,
                                    'Date': data.date,
                                    'Treatment Category': data.category_name,
                                    'Treatment': data.treatment_name,
                                    'Customer': data.customer_name,
                                    'Count of Sitting': data.sitting_count,
                                    'Status': data.progress,
                                    'Amount': data.amount,
                                    'Discount': data.discount,
                                    'CGST': cgst.toFixed(2),
                                    'SGST': sgst.toFixed(2),
                                    'IGST': igst.toFixed(2),
                                    'Paid Amount': data.paid_amount,
                                    'Pending Amount': data.pending,
                                    'Payment Status': data.paid_status
                                });
                            });

                            // Adding totals row to the Excel export
                            values.push({
                                'Sl No': '',
                                'Invoice No': '',
                                'Date': '',
                                'Treatment Category': '',
                                'Treatment': '',
                                'Customer': '',
                                'Count of Sitting': '',
                                'Status': 'Total',
                                'Amount': totalAmount.toFixed(2),
                                'Discount': '',
                                'CGST': totalCGst.toFixed(2),
                                'SGST': totalSGst.toFixed(2),
                                'IGST': totalIGst.toFixed(2),
                                'Paid Amount': totalPaidAmount.toFixed(2),
                                'Pending Amount': totalPending.toFixed(2),
                                'Payment Status': ''
                            });

                            var filename = 'payment_reports.xlsx';
                            var ws = XLSX.utils.json_to_sheet(values);
                            var wb = XLSX.utils.book_new();
                            XLSX.utils.book_append_sheet(wb, ws, "Payment Reports");
                            XLSX.writeFile(wb, filename);
                        }
                    }
                }else{
                   // $('#lead_loader').modal('hide');
                }
            });
        }
        // var branch_id = sessionStorage.getItem('branch_id');
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

                            var htmlhead ="<option value=''>Select Branch</option>";

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
       
        $('#treatment_cat_filter').on('click', function() {
           // $('#lead_loader').modal('show');
            var tc_id = document.getElementById("treatment_cat_list").value;
            var t_id = document.getElementById("select_treatment").value;
            var p_id = document.getElementById("paid_status").value;
            var branch_id = $('#branch_name').val();
            payment(tc_id,t_id,p_id,branch_id);
        });
        
         function payment_report_export(){
            var tc_id = document.getElementById("treatment_cat_list").value;
            var t_id = document.getElementById("select_treatment").value;
            var p_id = document.getElementById("paid_status").value;
            var branch_id = $('#branch_name').val();
            payment(tc_id,t_id,p_id,branch_id,true,);
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


        function datatable(){
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
