<script>
   
    var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{

        var base_url = window.location.origin+'/renew_api/api/';

        //var branch_id  = "";
        var cus_value=[];
        var app_values = [
                            ['Appointment Performance', 'Customers' ]
                            
                        ];
         var treat_values = [
                             ['Treatment Performance', 'Customers' ]
                        ]


         var branch_ids = sessionStorage.getItem('branch_id');
            var branch_id = JSON.parse(branch_ids);
          
            console.log(branch_id);
        getbranchall(branch_id);
        
        
       
        var app_year = "";
        var cus_year = "";
        var treat_year = "";

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
                                
                             
                                
                                console.log(data.data);
                                // function sel_status(value){
                                //     if(value == id){ return 'selected';}else{ return '';}
                                // }
                                //  function sel_status(value) {
                                //     // const = branch_id.length == 0
                                //     // const branc_ids =branch_id;
                                //     if (value ==branch_id[1] ) {
                                //         return 'selected';
                                //     } else {
                                //         return '';
                                //     }
                                // }
                                
                                 function sel_status(value) {
                                   
                                    if(sessionStorage.getItem('role') == 1){
                                        if (value =='all' ) {
                                            return 'selected';
                                        } else {
                                            return '';
                                        }
                                    }else{
                                        if (value ==branch_id[1] ) {
                                            return 'selected';
                                        } else {
                                            return '';
                                        }

                                    }
                                        
                                }
                                const value = data.data;
                                var htmlString = "";

                                // var htmlhead ="<option value='all'>All Branch</option>";
                                 var htmlhead = "<option value='all' " + sel_status('all') + ">All Branch</option>";

                                for(var i = 0; i < value.length  ; i++){
                                    // if(value[i].status == '0'){

                                    //   // htmlString += "<option value="+value[i].branch_id+" >"+ value[i].branch_name + "</option>"
                                        
                                    //     htmlString += "<option value='"+value[i].branch_id+"'"+sel_status(value[i].branch_id)+">"+ value[i].branch_name + "</option>";
                                    // }
                                     if(sessionStorage.getItem('role') != 1){
                                         console.log(branch_id);
                                         console.log(branch_id.includes(value[i].branch_id));
                                            if (value[i].status == '0' && branch_id.includes(value[i].branch_id)) {
                                                htmlString += "<option value='" + value[i].branch_id + "'" + sel_status(value[i].branch_id) + ">" + value[i].branch_name + "</option>";
                                            }
                                        
                                        }else{
                                            if(value[i].status == '0'){
        
                                                htmlString += "<option value='"+value[i].branch_id+"'"+sel_status(value[i].branch_id)+">"+ value[i].branch_name + "</option>";
                                            
                                            }
                                        }
                                }
                                
                                
                                

                                var htmlfooter ="";
                                
                                var htmlstringall = htmlhead+htmlString+htmlfooter;
                                $("#branch_name").html(htmlstringall);
                                
                                
                                // if(sessionStorage.getItem('role') != 1){
                                //     $('#branch_name').prop('disabled', true);
                                //     $('.form-select').css('background-image', '');
                                    
                                // }
                                

                                            
                            }
                        

                        }
                    });
        }

        let customer_from_date = "<?php echo date('Y-m-d'); ?>";
        let customer_to_date = "<?php echo date('Y-m-d');?>";

        $('#customer_from_date').change(function(){
           
            customer_from_date = $(this).val();
            all();
        });

        $('#customer_to_date').change(function(){
           
           customer_to_date = $(this).val();
           all();
        });

        
        // $('#customer_year').change(function(){
            
        //     cus_year = $(this).val();
            
        //     all();
            
        // })

        let appointment_from_date = "<?php echo date('Y-m-d'); ?>";
        let appointment_to_date ="<?php echo date('Y-m-d'); ?>";

        $('#appointment_from_date').change(function(){
           
            appointment_from_date = $(this).val();
            all();
        });

        $('#appointment_to_date').change(function(){
           
           appointment_to_date = $(this).val();
           all();
        });

        var sales_from_date = "<?php echo date('Y-m-d'); ?>";
        var sales_to_date   =  "<?php echo date('Y-m-d'); ?>";
    //     $('#sales_from_date').change(function(){
           
    //         sales_from_date = document.getElementById('from_date').value;
    //        allsalesget(sales_from_date);
    //    });

    //    $('#sales_to_date').change(function(){
          
    //     sales_to_date = document.getElementById('to_date').value;
    //       allsalesget(sales_to_date);
    //    });
       $('#data_filter').click(function(){
        sales_from_date = document.getElementById('sales_from_date').value;
        sales_to_date   = document.getElementById('sales_to_date').value;
     

        allsalesget(sales_from_date,sales_to_date);
        });
        // $('#appointment_year').change(function(){
            
        //     app_year = $(this).val();
            
        //     all();
            
        // })

        let treatment_from_date = "<?php echo date('Y-m-d'); ?>";
        let treatment_to_date = "<?php echo date('Y-m-d'); ?>";

        // $('#treatment_from_date').change(function(){
           
        //     treatment_from_date = $(this).val();
        //     all();
        // });

        // $('#treatment_to_date').change(function(){
           
        //    treatment_to_date = $(this).val();
        //    all();
        // });
        
        
        // $('#treatment_year').change(function(){
            
        //     treat_year = $(this).val();
            
        //     all();
            
        // })
         if(sessionStorage.getItem('role') == 1){
            branch_id == 'all'
            all(branch_id);
        }else{
            all(branch_id[1]);
        }
        function all(branch_id){
           
            // var branch_id      = document.getElementById("branch_name").value;
            // var customer_year      = document.getElementById("customer_year").value;
            // var appointment_year   = document.getElementById("appointment_year").value;
            
            // alert(appointment_year);

            const token = sessionStorage.getItem('token');

            if(branch_id == 'all'){
        
           
                var branch_ids = sessionStorage.getItem('branch_id');
                // var branch_idss = $('#branch_name').val();
                var branch_id_all = JSON.parse(branch_ids);
                // var branch_id_str = branch_id_all.join(',');
                console.log(branch_id_all);
                

                fetch(base_url+"dashborad_count?"+"branch_id="+branch_id_all, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {

                    if(data.status == '200'){

                        $("#d_lead").html(data.data.lead_count)
                        $("#d_app").html(data.data.appointment_count)
                        $("#d_payment").html("&#8377;"+data.data.payment)

                            drawBasic();
                    }
                });

        
                // fetch(base_url+"dashborad_customer?"+"branch_id="+branch_id+"&from_date="+customer_from_date+"&to_date="+customer_to_date, {
                //     headers: {
                //         "Content-Type": "application/x-www-form-urlencoded",
                //         'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                //     },
                //     method: "get",
                // })
                // .then((response) => response.json())
                // .then((data) => {
                    
                //     if(data.status == '200'){
                //     //  cus_value=[];
                    
                //     arr_value = [];

                //         if(data.data){
                            
                //             var value = data.data;

                //             for(let i=1; i <= 12 ; i++){


                //                 arr_value.push(value[i].count);
                //             }
                //             //cus_value=arr_value;
                //             areachart(arr_value);
                        
                //         }
                //     }
        
                // });
            }else{
              fetch(base_url+"dashborad_count?"+"branch_id="+branch_id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {

                    if(data.status == '200'){

                        $("#d_lead").html(data.data.lead_count)
                        $("#d_app").html(data.data.appointment_count)
                        $("#d_payment").html("&#8377;"+data.data.payment)

                            drawBasic();
                    }
                });

          
                // fetch(base_url+"dashborad_customer?"+"branch_id="+branch_id+"&from_date="+customer_from_date+"&to_date="+customer_to_date, {
                //     headers: {
                //         "Content-Type": "application/x-www-form-urlencoded",
                //         'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                //     },
                //     method: "get",
                // })
                // .then((response) => response.json())
                // .then((data) => {
                    
                //     if(data.status == '200'){
                //     //  cus_value=[];
                    
                //     arr_value = [];

                //         if(data.data){
                            
                //             var value = data.data;

                //             for(let i=1; i <= 12 ; i++){


                //                 arr_value.push(value[i].count);
                //             }
                //             //cus_value=arr_value;
                //             areachart(arr_value);
                           
                //         }
                //     }
        
                // });
            }

          
               

            fetch(base_url+"dashborad_appointment?"+"branch_id="+branch_id+"&from_date="+appointment_from_date+"&to_date="+appointment_to_date, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {

                    if(data.status == '200'){
                        
                        app_arr = [ ['Appointment Performance', 'Customers']];
                        if(data.data){
                            
                            var value = data.data;

                            for(let i=1; i <= 12 ; i++){
                                app_arr.push([value[i].month,value[i].count]);
                            }

                        }
                        
                        
                        app_values = app_arr;
                        
                        drawBasic();

                    }
                });
                
                
            fetch(base_url+"dashborad_treatment?"+"branch_id="+branch_id+"&from_date="+treatment_from_date+"&to_date="+treatment_to_date, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {

                    if(data.status == '200'){
                        
                        treat_arr = [['treatment Performance', 'Customers']];
                        if(data.data2){
                            
                            var value = data.data2;
                            
                            // value.sort((a,b) => a.count - b.count)

                            for(let i=0; i < 10 ; i++){
                                
                                treat_arr.push([value[i].name.substring(0,15),value[i].count]);
                            }

                        }
                        
                        
                        treat_values = treat_arr;
                        
                        
                        
                        // treat_values.sort(function(a, b) {
                        //   return  b[1]- a[1];
                        // })
                        
                      //  console.log(treat_values);
                        drawBasic();
                        
                        
                        

                    }
                });
                
        }
        allsalesget(sales_from_date,sales_to_date,id);

        function allsalesget(sales_from_date,sales_to_date,id){

            const token = sessionStorage.getItem('token');

            data="from="+sales_from_date+"&to="+sales_to_date+"&id"+id;
            fetch(base_url+"sales?"+data, {
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

                                var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Date</th><th>Branch</th><th>Customer Name</th><th>Product</th><th>Amount</th><th>Receipt</th></tr></thead><tbody>";

                                for(var i = 0; i < value.length  ; i++){

                                
                                    var  status = '';
                                    if(value[i].status == '0'){
                                        var status = 'checked';
                                    }
                                    //<td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='sales_status("+value[i].sales_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td>+"</td><td>" + "<a href='view_sales?p_id="+value[i].sales_id+"'"+"><i class='fa fa-eye eyc'></i></a><a href='edit_sales?sales_id="+value[i].sales_id+"'"+"><i class='fa fa-edit eyc'></i></a><a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model("+value[i].sales_id +")'><i class='fa fa-trash eyc'></i></a>"

                                    htmlString += "<tr><td>" +[i+1] +"</td><td>" + value[i].date +"</td><td>" + value[i].branch_name +"</td><td>" + value[i].customer_first_name +'<br/ >'+value[i].customer_phone  +"</td><td>" + value[i].product_name +"</td><td>" + value[i].amount  + "</td><td><a href='#' data-bs-toggle='modal' data-bs-target='' onclick='print("+value[i].sales_id +")'><i class='fa fa-print eyc'></i></a></td></tr>";
                                    
                                }

                                var htmlfooter ="</tbody></table>";
                                
                                var htmlstringall = htmlhead+htmlString+htmlfooter;
                                $("#sales_list").html(htmlstringall);

                                datatable();
                                            
                            }
                        

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
        function selectbranch(){
            // branch_id      = document.getElementById("branch_name").value;
  var branch_id = $('#branch_name').val();
            cus_value = [];
            
            app_values = [
                            ["Month", "Appointment ."]
                        ]
            all(branch_id);
            // console.log(cus_value);
            // console.log(app_values)
        }
        
        function areachart(customer){
                       
            var options = {
                series: [
                            {
                                name: 'Customer',
                                data: customer
                            }, 
                        // {
                        //     name: 'Store',
                        //     data: [2, 22, 35, 32, 40, 25, 50, 38, 42, 28, 20, 45, 0]
                        // }
                        ],
                chart: {
                    height: 254,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'category',
                    low: 0,
                    offsetX: 0,
                    offsetY: 0,
                    show: false,
                    categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    labels: {
                        low: 0,
                        offsetX: 0,
                        show: false,
                    },
                    axisBorder: {
                        low: 0,
                        offsetX: 0,
                        show: false,
                    },
                },
                markers: {
                    strokeWidth: 3,
                    colors: "#ffffff",
                    // strokeColors: [ CubaAdminConfig.primary , CubaAdminConfig.secondary ],
                    strokeColors: [ "#0071bc"],
                    hover: {
                        size: 6,
                    }
                },
                yaxis: {
                    low: 0,
                    offsetX: 0,
                    offsetY: 0,
                    show: false,
                    labels: {
                        low: 0,
                        offsetX: 0,
                        show: false,
                    },
                    axisBorder: {
                        low: 0,
                        offsetX: 0,
                        show: false,
                    },
                },
                grid: {
                    show: false,
                    padding: {
                        left: 0,
                        right: 0,
                        bottom: -15,
                        top: -40
                    }
                },
                colors: [ "#0071bc" , CubaAdminConfig.secondary ],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.5,
                        stops: [0, 80, 100]
                    }
                },
                legend: {
                    show: false,
                },
                tooltip: {
                    x: {
                        format: 'MM'
                    },
                },
            };

            var chart = new ApexCharts(document.querySelector("#chart-customer"), options);
            chart.render(); 
        }
        // console.log(values2[0][0],'fgfdhg')
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.load('current', {'packages':['line']});
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawBasic);
        
        function drawBasic() {
            
            if ($("#dashboard-chart1").length > 0) {
                
               
                    
                var a = google.visualization.arrayToDataTable(app_values)
                b = {
                        chart: {
                            title: "Appointment Performance"
                            // subtitle: "Appointment"
                        },
                        bars: "vertical",
                        vAxis: {
                            format: "decimal"
                        },
                        height: 400,
                        width:'100%',
                        bar: {groupWidth: "25%"},
                            colors: [CubaAdminConfig.theme-primary, "#0071bc"]


                    }
                c = new google.charts.Bar(document.getElementById("dashboard-chart1"));
                    c.draw(a, google.charts.Bar.convertOptions(b))
            }
            
            
            if ($("#dashboard-chart2").length > 0) {
                
             
             
                var d = google.visualization.arrayToDataTable(treat_values)
                e = {
                        chart: {
                            title: "Treatment Performance"
                            // subtitle: "Appointment"
                        },
                        bars: "vertical",
                        vAxis: {
                            format: "decimal"
                        },
                        height: 400,
                        width:'100%',
                        bar: {groupWidth: "25%"},
                            colors: [CubaAdminConfig.theme-primary, "#0071bc"]


                    }
                f = new google.charts.Bar(document.getElementById("dashboard-chart2"));
                    f.draw(d, google.charts.Bar.convertOptions(e))
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