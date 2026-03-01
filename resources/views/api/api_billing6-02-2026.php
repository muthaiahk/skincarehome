
<script>
    var a = sessionStorage.getItem('token');
    
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';

        var id=<?php if(isset($_GET['id'])) echo $_GET['id']; else echo "0"?>;

        var permission = '';
        var total_balance = 0;
        var c_id =0;
        $( "#add_billing" ).hide();
        var state_id = "";
        // var branch_id = $('#branch_name').val();

        var Array_ids = [];
       // var pay_amount = 0;
       
 
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

        permission_page("customer_payment").then(() => {
            try {
                console.log(permission);

              all(permission);
          
            } catch (error) {
                console.error(error);
            }
        });

        function on_print(id) {
    const token = sessionStorage.getItem('token');
    fetch(base_url + "billing_invoice/" + id, {
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            'Authorization': `Bearer ${token}`
        },
        method: "get",
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === 200) {
                const payment = data.data.payment;
                const treatments = data.data.treatments;
                const products = data.data.products;

                let itemRows = '';
                treatments.forEach(treatment => {
                    itemRows += `<tr class="item">
                                    <td>${treatment.treatment_name}</td>
                                    <td>Included</td>
                                 </tr>`;
                });

                products.forEach(product => {
                    itemRows += `<tr class="item">
                                    <td>${product.product_name}</td>
                                    <td>₹${payment.total_amount}</td>
                                 </tr>`;
                });

                const amt = payment.total_amount;
                const state_id = payment.state_id;
                let gstDetails = '';
                if (state_id === 23) {
                    const sgst = (amt / 100) * 9;
                    const cgst = (amt / 100) * 9;
                    gstDetails = `
                        <tr class="total">
                            <td></td>
                            <td>Inc. CGST: ₹${sgst.toFixed(2)}</td>
                        </tr>
                        <tr class="total">
                            <td></td>
                            <td>Inc. SGST: ₹${cgst.toFixed(2)}</td>
                        </tr>`;
                } else {
                    const igst = (amt * 18) / 100;
                    gstDetails = `
                        <tr class="total">
                            <td></td>
                            <td>Inc. IGST: ₹${igst.toFixed(2)}</td>
                        </tr>`;
                }
             const logoUrl = 'https://crm.renewhairandskincare.com/renew_api/public/logo/22626.png';
                const htmlContent = `
                    <!DOCTYPE html>
                    <html>
                        <head>
                            <meta charset="utf-8">
                            <title>PAYMENT INVOICE</title>
                            <style>
                                .invoice-box {
                                    max-width: 800px;
                                    margin: auto;
                                    padding: 20px;
                                    border: 1px solid #eee;
                                    font-size: 16px;
                                    line-height: 24px;
                                    font-family: Arial, sans-serif;
                                    color: #555;
                                }
                                .invoice-box table {
                                    width: 100%;
                                    line-height: inherit;
                                    text-align: left;
                                }
                                .invoice-box table td {
                                    padding: 8px;
                                    vertical-align: top;
                                }
                                .invoice-box table tr.heading td {
                                    background: #eee;
                                    font-weight: bold;
                                }
                                .invoice-box table tr.total td {
                                    font-weight: bold;
                                }
                               
                                .headerlogo {
                                    display: flex;
                                    align-items: center;
                                    justify-content: space-between;
                                    padding: 10px 0;
                                    border-bottom: 2px solid #eee;
                                }
                                .logo {
                                    width: 150px;
                                    height: auto;
                                }
                                @media print {
                                    img {
                                        display: block !important;
                                        max-width: 100%;
                                    }
                                }
                                
                            </style>
                        </head>
                        <body>
                            <div class="invoice-box">
                                <div class="headerlogo">
                                    <img src="${logoUrl}" alt="Logo" class="logo" id="logoImage">
                                    <h2 align="center">PAYMENT INVOICE</h2>
                                </div>
                                <hr>
                                <table>
                                    <tr>
                                        <td>
                                            <h3>Renew+ Hair and Skin Care</h3>
                                            <p>No.155, 2nd floor, 80 feet road,<br> KK Nagar, Madurai, Tamil Nadu, India, 625020</p>
                                            <p>+91 9150309990</p>
                                            <p>Email: renewhairskincare@gmail.com</p>
                                        </td>
                                        <td align="right">
                                            INVOICE #: ${payment.invoice_no}<br>
                                            Payment Date: ${payment.payment_date}<br>
                                        </td>
                                    </tr>
                                </table>
                                <hr>
                                <h3>Customer Details</h3>
                                <p>Name: ${payment.customer_first_name || payment.lead_first_name} ${payment.customer_last_name || payment.lead_last_name}</p>
                                <p>Email: ${payment.customer_email || payment.lead_email}</p>
                                <p>Phone: ${payment.customer_phone || payment.lead_phone}</p>
                                <hr>
                                <h3>Payment Details</h3>
                                <table>
                                    <tr class="heading">
                                        <td>Description</td>
                                        <td>Price</td>
                                    </tr>
                                    ${itemRows}
                                    ${gstDetails}
                                    <tr class="total">
                                        <td></td>
                                        <td>Total: ₹${amt}</td>
                                    </tr>
                                </table>
                            </div>
                        </body>
                    </html>
                `;

                const newWin = window.open('', 'Print-Window');
                newWin.document.open();
                newWin.document.write(htmlContent);
                newWin.document.close();
    
                // Wait for the logo image to load before printing
                const logoImage = newWin.document.getElementById('logoImage');
                logoImage.onload = () => {
                    setTimeout(() => {
                        newWin.print();
                        newWin.close();
                    }, 500); // Optional: Adjust delay if needed
                };
    
                // Handle image load error
                logoImage.onerror = () => {
                    console.error('Image failed to load');
                    newWin.print(); // Print even if image fails to load
                    newWin.close();
                };
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}


        function model(id) {
            billing_id = id;
            // Fetch billing data to display in the modal
            fetchBillingDetails(billing_id);
            $('#billing_balance').modal('show');
        }

        function fetchBillingDetails(id) {
            const token = sessionStorage.getItem('token');

            fetch(base_url + "get_billing_details/" + id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`,
                },
                method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === 200) {
                    const { total_amount, paid_amount, remaining_amount } = data.details;

                    // Update UI with fetched data
                    document.getElementById('total-amount').textContent = `₹${total_amount}`;
                    document.getElementById('paid-amount').textContent = `₹${paid_amount}`;
                    document.getElementById('remaining-amount').textContent = `₹${remaining_amount}`;

                    // Show warning if remaining amount is invalid
                    if (remaining_amount > total_amount) {
                        document.getElementById('warning-message').classList.remove('d-none');
                        document.getElementById('pay-balance').classList.add('d-none');
                    } else {
                        document.getElementById('warning-message').classList.add('d-none');
                        document.getElementById('pay-balance').classList.remove('d-none');
                    }

                    // Set up event listener for payment amount input
                    const paymentAmountInput = document.getElementById('payment-amount');
                    const balanceLabel = document.getElementById('payment-amount-balance');
                    paymentAmountInput.addEventListener('input', () => {
                        const paymentAmount = parseFloat(paymentAmountInput.value) || 0;
                        const newBalance = remaining_amount - paymentAmount;

                        if (paymentAmount <= remaining_amount && paymentAmount > 0) {
                            balanceLabel.textContent = `₹${newBalance.toFixed(2)}`;
                            balanceLabel.classList.remove('d-none');
                            document.getElementById('pay-balance').classList.remove('d-none');
                            document.getElementById('warning-message').classList.add('d-none');
                        } else {
                            balanceLabel.classList.add('d-none');
                            document.getElementById('warning-message').classList.remove('d-none');
                            document.getElementById('pay-balance').classList.add('d-none');
                        }
                    });
                } else {
                    // alert("Failed to fetch billing details.");
                }
            });
        }


       

        $('#pay-balance').click(function() {
            const token = sessionStorage.getItem('token');
            const paymentAmount = parseFloat(document.getElementById('payment-amount').value) || 0;
            const totalAmount = parseFloat(document.getElementById('total-amount').textContent.replace('$', '')) || 0;
            const paidAmount = parseFloat(document.getElementById('paid-amount').textContent.replace('$', '')) || 0;
            const remainingAmount = parseFloat(document.getElementById('remaining-amount').textContent.replace('$', '')) || 0;

            // Check if payment amount is valid before sending
            if (paymentAmount <= 0) {
                alert("Please enter a valid payment amount.");
                return;
            }

            fetch(base_url + "balance_payment/" + billing_id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`
                },
                method: "POST",
                body: `payment_amount=${paymentAmount}&paid_amount=${paidAmount}&remaining_amount=${remainingAmount}&total_amount=${totalAmount}`
            })
            .then((response) => response.json())
            .then((data) => {
                // Check if the response contains status and it's equal to 200 (as number)
                if (data.status === 200) {
                    // Call any function to refresh the page or update the balance if needed
                    all();
            
                    // Display success message
                    $("#status_success").html("<div class='alert alert-success' role='alert'>Payment Successfully Paid!</div>");
            
                    // Clear success message after 4 seconds
                    setTimeout(() => {
                        $("#status_success").html(""); 
                        // Reload the page after the success message is cleared
                        location.reload(); 
                    }, 2000);
                } else {
                    // Handle failure case
                    alert("Payment failed. Please try again.");
                }
            })
            .catch((error) => {
                console.error("Error processing payment:", error);
                alert("An error occurred while processing the payment.");
            });
        });


        let currentPage = 1; // Keep track of the current page
        const itemsPerPage = 10; // Set how many items to display per page

        all(branch_id[1]);

        // function all(){

        //     const token = sessionStorage.getItem('token');

        //     var branch_id = $('#branch_name').val();
        //     var tc_id = $('#treatment_cat_list').val();
        //     var t_id = $('#select_treatment').val();
          
        //     let params = new URLSearchParams();

        //     params.append('branch_id', branch_id);
        //     params.append('tc_id', tc_id);
        //     params.append('t_id', t_id);
        //     params.append('page', currentPage); // Add the current page
        //     params.append('limit', itemsPerPage); // Add the items per page
        //     fetch(base_url+"billing", {
        //             headers: {
        //                 "Content-Type": "application/x-www-form-urlencoded",
        //                 'Authorization': `Bearer ${token}`, // notice the Bearer before your token
        //             },
        //             method: "post",
        //             body:params
        //         })
        //             .then((response) => response.json())
        //             .then((data) => {
                    
                       
        //             if(data.status == '200') {
        //                 if(data.data) {
        //                     const value = data.data;
                           
        //                     var htmlString = "";
        //                     var htmlhead = "<table class='display' id='advance-1'><thead><tr><th>Biling / Invoice No</th><th>Date / Receipt No</th><th>Customer</th><th>Amount</th><th>Total Amount</th><th>Balance</th><th>Pay Status</th><th>Action</th></tr></thead><tbody>";

        //                     let totalAmount = 0;
        //                     let totalGst = 0;

        //                     for (var i = 0; i < value.length; i++) {
        //                         var status = value[i].status == '0' ? 'checked' : '';
                                
                            
        //                         var action = "";

        //                         // Permission logic
        //                         if (permission) {
        //                             var values = permission.split(",");
        //                             if (values.length > 0) {
        //                                 var add = values.includes('add');
        //                                 var edit = values.includes('edit');
        //                                 var view = values.includes('view');
        //                                 var del = values.includes('delete');
        //                                 var print = values.includes('print');

        //                                 if (add) { $("#add_billing").show(); }
        //                                 else { // UI BYPASS: $("#add_billing").hide(); }

        //                                 if (edit) { action += `<a href='edit_payment?pay_id=${value[i].billing_id}'><i class='fa fa-edit eyc'></i></a>`; }
        //                                 if (view) { action += `<a href='view_payment?pay_id=${value[i].billing_id}'><i class='fa fa-eye eyc'></i></a>`; }
        //                                 if (del) { action += `<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model(${value[i].billing_id})'><i class="fa fa-rupee" title="Balance Pay" style="font-size:20px;color:red"></i></a>`; }
        //                                 if (print) { action += `<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='on_print(${value[i].billing_id})'><i class='fa fa-print eyc'></i></a>`; }
        //                             }
        //                         }
        //                         console.log(value[i]);
        //                         const entry = value[i];
                               
        //                         const paid_status = entry.balance_amount > 0 ? "<span class='bg-danger p-1 rounded'>Pending</span>" : "<span class='bg-success p-1 rounded'>Paid</span>";
        //                         const invoice = entry.invoice_no || " ";
        //                         const nameDisplay = entry.lead_first_name ? entry.lead_first_name : entry.customer_first_name;
        //                         const phoneDisplay = entry.lead_phone ? entry.lead_phone : entry.customer_phone;

        //                         htmlString += `
        //                             <tr>
        //                                 <td>${entry.billing_no}<br/>${invoice}</td>
        //                                 <td>${entry.payment_date}<br/>${entry.receipt_no}</td>
        //                                 <td>${nameDisplay}<br/>${phoneDisplay}</td>
        //                                 <td>${entry.paid_amount}</td>
        //                                 <td>${entry.total_amount}</td>
        //                                 <td>${entry.balance_amount}</td>
        //                                 <td>${paid_status}</td>
        //                                 <td>${action}</td>
        //                             </tr>
        //                         `;
        //                         totalAmount += parseFloat(entry.paid_amount);
        //                         totalGst += parseFloat(entry.total_amount);
        //                     }
                            

        //                     var totalRow = `<tfoot><tr>
        //                         <td colspan='3'><strong>Total</strong></td>
        //                         <td><strong>${totalAmount.toFixed(2)}</strong></td>
        //                         <td><strong>${totalGst.toFixed(2)}</strong></td>
        //                         <td></td>
        //                     </tr></tfoot>`;

        //                     htmlString += totalRow + "</tbody></table>";
        //                     const totalPages = Math.ceil(data.total / itemsPerPage);
        //                     htmlString += `<div class='pagination'>`;
        //                     for (let i = 1; i <= totalPages; i++) {
        //                         htmlString += `<button class='page-button' id='page-button' onclick='goToPage(${i})'>${i}</button>`;
        //                     }
        //                     htmlString += `</div>`;
        //                     $("#billing_list").html(htmlhead + htmlString);
        //                     pay_report = htmlString;
                            
        //                     // Initialize DataTable
        //                     datatable(data.total);
        //                 }
        //             }      
                 

        //     });
        // }
      
 
        
        function all() {
            const token = sessionStorage.getItem('token');

            var branch_id = $('#branch_name').val();
            var tc_id = $('#treatment_cat_list').val();
            var t_id = $('#select_treatment').val();
        
            let params = new URLSearchParams();

            params.append('branch_id', branch_id);
            params.append('tc_id', tc_id);
            params.append('t_id', t_id);
            params.append('page', currentPage); // Add the current page
            params.append('limit', itemsPerPage); // Add the items per page
            
            // Show the loading spinner
            document.getElementById("loadingIndicator").style.display = "block";
            document.getElementById("billing_list").style.display = "none"; // Hide the data container during loading

            fetch(base_url + "billing", {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "post",
                body: params
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.status == '200') {
                    if (data.data) {
                        const value = data.data;
                        var htmlString = "";
                        var htmlhead = "<table class='display' id='advance-1'><thead><tr><th>Date / Invoice</th><th>Billing No</th><th>Customer / Lead</th><th>Total Amount</th><th>Paid Amount</th><th>Balance Amount</th><th>Pay Status</th><th>Action</th></tr></thead><tbody>";

                        let totalAmount = 0;
                        let totalGst = 0;
                        let balanceAmount = 0;
                    
                        for (var i = 0; i < value.length; i++) {
                            var status = value[i].status == 0 ? 'checked' : '';
                            var action = "";

                            // Permission logic
                            if (permission) {
                                var values = permission.split(",");
                                if (values.length > 0) {
                                    var add = values.includes('add');
                                    var edit = values.includes('edit');
                                    var view = values.includes('view');
                                    var del = values.includes('add');
                                    var print = values.includes('print');

                                  
                                     // Disable delete action if status is 1 or balance_amount is 0
                                    if (parseFloat(value[i].balance_amount) === 0) {
                                        
                                        del = false;
                                       
                                    }
                                    if(value[i].invoice_no == null){
                                         print = false;
                                    }


                                    if (add) { $("#add_billing").show(); }
                                    else { // UI BYPASS: $("#add_billing").hide(); }

                                    // if (edit) { action += `<a href='edit_billing?pay_id=${value[i].billing_id}'><i class='fa fa-edit eyc'></i></a>`; }
                                    // if (del) { action += `<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model(${value[i].billing_id})'><i class="fa fa-rupee" title="Pay Balance" style="font-size:20px;color:red"></i></a>`; }
                                   if (print) { action += `<a href='#'onclick='on_print(${value[i].billing_id})'><i class='fa fa-print eyc'></i></a>`; }

                                }
                            }


                            const entry = value[i];
                            const paid_status = entry.balance_amount > 0 ? "<span class='bg-danger p-1 rounded'>Pending</span>" : "<span class='bg-success p-1 rounded'>Paid</span>";
                            const invoice = entry.invoice_no || " ";
                            const nameDisplay = `${entry.lead_first_name || entry.customer_first_name} ${entry.lead_last_name || entry.customer_last_name}`
                            const phoneDisplay = entry.lead_phone ? entry.lead_phone : entry.customer_phone;

                            htmlString += `
                                <tr>
                                    <td>${entry.payment_date}<br/>${invoice}</td>
                                    <td>${entry.billing_no}</td>
                                    <td>${nameDisplay}<br/>${phoneDisplay}</td>
                                    <td>${entry.total_amount}</td>
                                    <td>${entry.paid_amount}</td>
                                    <td>${entry.balance_amount}</td>
                                    <td>${paid_status}</td>
                                    <td>${action}</td>
                                </tr>
                            `;
                            totalAmount += parseFloat(entry.total_amount);
                            totalGst += parseFloat(entry.paid_amount);
                            balanceAmount += parseFloat(entry.balance_amount);
                        }

                        var totalRow = `<tfoot><tr>
                            <td colspan='3'><strong>Total</strong></td>
                            <td><strong>${totalAmount.toFixed(2)}</strong></td>
                            <td><strong>${totalGst.toFixed(2)}</strong></td>
                            <td><strong>${balanceAmount.toFixed(2)}</strong></td>
                            <td></td>
                        </tr></tfoot>`;

                        htmlString += totalRow + "</tbody></table>";
                        const totalPages = Math.ceil(data.total / itemsPerPage);
                        htmlString += `<div class='pagination'>`;
                        for (let i = 1; i <= totalPages; i++) {
                            htmlString += `<button class='page-button' id='page-button' onclick='goToPage(${i})'>${i}</button>`;
                        }
                        htmlString += `</div>`;
                        $("#billing_list").html(htmlhead + htmlString);
                        pay_report = htmlString;

                        // Initialize DataTable
                        datatable(data.total);
                    }
                }

            })
            .finally(() => {
                // Hide the loading spinner and show the data after fetching is complete
                document.getElementById("loadingIndicator").style.display = "none";
                document.getElementById("billing_list").style.display = "block"; // Show the data container
            });
        }
           
        var billing_id = '';

      


           // Function to create custom pagination
        function createCustomPagination(totalPages) {
            let paginationHtml = `<div class='pagination'>`;
            for (let i = 1; i <= totalPages; i++) {
                paginationHtml += `<button class='page-button' onclick='goToPage(${i})'>${i}</button>`;
            }
            paginationHtml += `</div>`;

            // Append custom pagination to the desired container
            $("#custom-pagination").html(paginationHtml);
        }

       
        // Call datatable function to initialize
        function datatable(totalRecords) {
            const itemsPerPage = 10;
            const totalPages = Math.ceil(totalRecords / itemsPerPage); // Calculate total pages based on actual total records
            console.log("Total Records:", totalRecords); // Debugging
            console.log("Total Pages:", totalPages); // Debugging

            // Initialize DataTable with custom settings
            const table = $("#advance-1").DataTable({
                "ordering": false,
                "responsive": true,
                "aaSorting": [],
                "language": {
                    "lengthMenu": "Show _MENU_",
                },
                "paging": false, // Disable default pagination
                "dom": 
                    "<'row'" +
                    "<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +
                    "<'table-responsive'tr>" +
                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">"
            });

            // Generate custom pagination after the DataTable is drawn
            createCustomPagination(totalPages); // Create pagination after table initialization

            window.goToPage = function(page) {
                currentPage = page; // Update the current page globally
                setActivePage(page);
                all(); // Re-fetch data for the new page, if necessary
            }
        }

        // Set the active page button
        function setActivePage(currentPage) {
            console.log("Current Page:", currentPage); // Debugging
            // Remove active class from all buttons
            $(".page-button").removeClass("active");
            // Add active class to the current page button
            $(".page-button").eq(currentPage - 1).addClass("active");
        }

        // Use data.total from the server response as totalRecords
        if (data.status == '200') {
            if (data.data) {
                // Generate HTML for the table...
                let htmlString = "<table id='advance-1'><thead>...</thead><tbody>";

                // Loop through data and add rows here
                htmlString += totalRow + "</tbody></table>";
                
                // Append the pagination container where custom pagination will go
                htmlString += `<div id='custom-pagination' class='pagination'></div>`;

                $("#billing_list").html(htmlString);

                // Initialize DataTable with total records
                datatable(data.total);
            }
        }

       
      
           

        if(id > 0){
            gettcategoryall(id);
        }
       
         

       



        var arr_treatment = [];

        function payment_enter(e){

            var amount = e.target.value;
            var index = e.target.name;

            
            var total_amount = $('#amount'+index).val();
            var total_discount = $('#discount'+index).val();
            var treatment_id = $('#treatment_name'+index).val();
            var cus_treat_id = $('#cus_treat_id'+index).val();

            var select_discount = $('#select_discount'+index).val();
           
           console.log(select_discount);
            arr_treatment.push({
                'id':treatment_id,
                'discount' :total_discount,
                'amount' :amount,
                'cus_treat_id' :cus_treat_id,
            })

         

            var t_amt = parseInt(amount)+parseInt(total_discount);
            
            if(parseInt(t_amt) > total_amount){
                alert('your amount is excess paying amount');
                $('#final_amount'+index).val(0);
            } 

            var arr_amt = [];

            var p_amt = [];

            Array_ids.map((val,i)=>{

                
                var dis = $('#'+val.discount).val();
                var amt = parseInt($('#'+val.final_amount).val());

                if (select_discount === 'percent') {
                    val_amt = (total_amount * dis) / 100;  // Use a cleaner calculation
                } else {
                    val_amt = dis;  // Assign the fixed discount value directly
                }
                console.log('percentage',val_amt);
                // $val = parseInt(amt)-parseInt(val_amt);
                $val = parseInt(val_amt)+parseInt(amt);
                arr_amt.push($val);
                p_amt.push(amt);
                

            });

            var t_amt = sum(arr_amt);

            $('#taxtable_value').val(t_amt);
           
                if(state_id == 23){
                    $value = parseInt(t_amt)*(18/100);
                    $value = Math.round($value/2);
                    $('#cgst_value').val($value);
                    $('#sgst_value').val($value);
                    $('#igst_value').val(0);

                    $('#igst').css({'display':'none'});
                    $('#igst_value').css({'display':'none'});

                    $('#cgst').css({'display':'block'});
                    $('#cgst_value').css({'display':'block'});

                    $('#sgst').css({'display':'block'});
                    $('#sgst_value').css({'display':'block'});

                }else{
                    $value = parseInt(t_amt)*(18/100);
                    $value = Math.round($value/1);
                    $('#cgst_value').val(0);
                    $('#sgst_value').val(0);
                    $('#igst_value').val($value);
                    
                    $('#igst').css({'display':'block'});
                    $('#igst_value').css({'display':'block'});

                    $('#cgst').css({'display':'none'});
                    $('#cgst_value').css({'display':'none'});

                    $('#sgst').css({'display':'none'});
                    $('#sgst_value').css({'display':'none'});
                }

            
            $('#total_amount_value').val(amount); 

        }


        function discount_enter(e){

           

            var amount = e.target.value;
            var index = e.target.name;

            var select_discount = $('#select_discount'+index).val();
            var discount_type = select_discount === 'percent' ? 2 : 1;  // Determine discount type (1 for rupees, 2 for percent)

            console.log('discount_type', discount_type);

            // Set the discount type in the corresponding hidden input
            $('#discount_type' + index).val(discount_type);


            var final_amount = $('#final_amount'+index).val();
            var total_amount = $('#amount'+index).val(); 
            

            var t_amt = parseInt(final_amount)+parseInt(amount);
            
            if(parseInt(t_amt) > total_amount){
                alert('your amount is excess paying amount');
                $('#final_amount'+index).val(0);
            } 


            var arr_amt = [];
            var p_amt =[];

            Array_ids.map((val,i)=>{

                
                var dis = $('#'+val.discount).val();
                var amt = parseInt($('#'+val.final_amount).val());
               
                if(select_discount == 'percent'){
                    var val_amt = (total_amount/100)*dis;
                  
                }else{
                    var val_amt = dis;
                   
                }
              
                // $('#discount_type' + i).val(discount_type);

                $val = parseInt(val_amt)+parseInt(amt);

                arr_amt.push($val);
                p_amt.push(amt);

            });

            var t_amt = sum(arr_amt);

            $('#taxtable_value').val(t_amt);

            if(state_id == 23){
                $value = parseInt(t_amt)*(18/100);
                $value = Math.round($value/2);
                $('#cgst_value').val($value);
                $('#sgst_value').val($value);
                $('#igst_value').val(0);
            }else{
                $value = parseInt(t_amt)*(18/100);
                $value = Math.round($value/1);
                $('#cgst_value').val(0);
                $('#sgst_value').val(0);
                $('#igst_value').val($value);
            }
            // $value = parseInt(t_amt)*(18/100);
            // $value = Math.round($value/2);
            // $('#cgst_value').val($value);
            // $('#sgst_value').val($value);
            // $('#igst_value').val(parseInt(t_amt)*(18/100));
            $('#total_amount_value').val(sum(p_amt)); 




        }

      
        var branch_ids = sessionStorage.getItem('branch_id');
            var branch_id = JSON.parse(branch_ids);
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
                            
                            // function sel_status(value){
                            //     if(value == id){ return 'selected';}else{ return '';}
                            // }
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

                            var htmlhead ="<option value=''>Select Branch</option><option value='0'>Select All</option>";       

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
                            $("#branch_name").html(htmlstringall);
                            
                            // if(sessionStorage.getItem('role') >2){
                            //     $('#branch_name').prop('disabled', true);
                            //     $('.form-select').css('background-image', '');
                                
                            // }
                        }
                    

                    }
                });
        }
        

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

        $('#all_payment_list').on('click', function() {
            
            var tc_id = document.getElementById("treatment_cat_list").value;
            var t_id = document.getElementById("select_treatment").value;
            var branch_id = $('#branch_name').val();
            cattreatmentall(id,branch_id)
            // all(tc_id,t_id,branch_id);

        });

       
       

       
        function py_status(id,status){

            if(status == '1'){
                var payment_status = 0;
            }else{
                var payment_status = 1;
            }
            const token = sessionStorage.getItem('token');
            fetch(base_url+"payment_status/"+id+'?status='+payment_status, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
                .then((response) => response.json())
                    .then((data) => {
                    
                        if(data.status == '200'){

                        $("#status_success").html("<div class='alert alert-success' role='alert'>Payment Successfully Updated!</div>");
                        
                        setTimeout(() => { $("#status_success").html("");}, 4000);    

                        }
                    });
                    
        }

      
       
        function select_t_Category(){
            var tcategory_id  = document.getElementById("tc_name").value;
            gettreatmentall(tcategory_id);
            
            //cutomer_invoice();
        }

        function cutomer_invoice(){

            var customer_id   = document.getElementById("select_customer").value;
            var tcategory_id  = document.getElementById("tc_name").value;
            var treatment_id  = document.getElementById("treatment_name").value;

            if(!tcategory_id){

                $("#error_tc_name").html("Please select Treatment_category name");
                var dropDown = document.getElementById("treatment_name");
                dropDown.selectedIndex = 0;
            }else{
                $("#error_tc_name").html("");
            } 

            if(!treatment_id){

                $("#error_treatment_name").html("Please select Treatment name");
                dropDown.selectedIndex = 0;

            }else{
                $("#error_treatment_name").html("");
            } 
            if(!customer_id){

                $("#error_customer_name").html("Please select Customer name");
                dropDown.selectedIndex = 0;

            }else{
                $("#error_customer_name").html("");
            } 


            if(customer_id && tcategory_id && treatment_id){
            
                var data = "customer_id="+customer_id+'&tcategory_id='+tcategory_id+'&treatment_id='+treatment_id;

                const token = sessionStorage.getItem('token');

                    fetch(base_url+"invoice_generator?"+data, {
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded",
                                'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                            },
                            method: "get",
                        })
                    .then((response) => response.json())
                    .then((data) => {
                
                        
                        if(data.status == '200'){

                            if(data.balance == 0){

                                $("#status_success").html("<div class='alert alert-danger' role='alert'>Amount already paid !</div>");
                        
                                setTimeout(() => { $("#status_success").html("");}, 4000); 

                            }else{

                                var numbers = data.numbers;
                                if(numbers){                                 
                                    if(data.used){
                                        
                                        
                                        if(data.used == 'new'){

                                            var in_id = autoIncrementCustomId(numbers.invoice_no);
                                            var re_id = numbers.receipt_no;

                                            document.getElementById("invoice_no").value = in_id;
                                            document.getElementById("receipt_no").value = re_id;

                                        }else{
                                            var in_id = numbers.invoice_no;
                                            var re_id = autoIncrementreceipt(numbers.receipt_no);

                                            document.getElementById("invoice_no").value = in_id;
                                            document.getElementById("receipt_no").value = re_id;

                                            

                                        }


                                        
                                    }else{

                                        var dt = new Date();
                                        var val = dt.getFullYear().toString().substr(dt.getFullYear().toString().length -2);

                                        var in_id = autoIncrementCustomId(numbers.invoice_no);
                                        var re_id = numbers.receipt_no;

                                        document.getElementById("invoice_no").value = in_id;
                                        document.getElementById("receipt_no").value = re_id;
                                        
                                        
                                    }
                                }else{
                                    var dt = new Date();
                                    var val = dt.getFullYear().toString().substr(dt.getFullYear().toString().length -2);

                                    var in_id = autoIncrementCustomId('IN000/'+val);
                                    var re_id = autoIncrementreceipt('RP000/'+val);

                                    document.getElementById("invoice_no").value = in_id;
                                    document.getElementById("receipt_no").value = re_id;
                                    
                                    
                                }

                                document.getElementById("sitting_counts").value = data.sitting_count;
                                document.getElementById("total_amount").value = data.total_amount;
                                document.getElementById("balance_amount").value = data.balance;
                                
                                total_balance =  data.balance;
                            }
                        }
                    });
            }
        }

        function pay_amount(e){

            if($('#select_customer').val()){
            

                var regex = /^\d+(\.\d{2,2})?$/;
                

                if(parseInt(total_balance) == 0){

                    total_balance = $('#total_amount').val();

                }

                
                var amount = e.target.value;
                
                if(amount == '' || amount <= 0 || regex.test(amount) == false){
                    $("#error_pay_amount").html("Please enter valid amount");
                
                }else{
                
                //  var total_amount = $('#total_amount').val();

                    document.getElementById("cash").value = amount;
                    document.getElementById("card").value = 0;
                    document.getElementById("cheque").value = 0;
                    document.getElementById("upi").value = 0;
                                

                    if(parseInt(amount) > parseInt(total_balance)){
                        
                        $("#error_pay_amount").html("your amount is excess paying amount");
                        document.getElementById("cash").value = 0;
                        document.getElementById("card").value = 0;
                        document.getElementById("cheque").value = 0;
                        document.getElementById("upi").value = 0;

                    }else{
                        var balance = parseInt(total_balance) - parseInt(amount);
                        $("#balance_amount").val(balance);

                        $val = parseInt(amount)*(18/100);
                        $val = Math.round($val/2);
                        $('#cgst').html($val);
                        $('#sgst').html($val);
                    

                        $("#error_pay_amount").html("");
                    }
                    
                    
                }
            }else{
                
                $("#error_customer_name").html("Please select User ");
                $("#select_customer").focus();

            }



            
        }

         //global variable

       
        
        // function multi_payment(e)
        // {
          
        //     var cash_amt   = $('#cash').val();
        //     var card_amt   = $('#card').val();
        //     var cheque_amt = $('#cheque').val();
        //     var upi_amt    = $('#upi').val();

            

        //     var total_amt = parseInt(cash_amt)+parseInt(card_amt)+parseInt(cheque_amt)+parseInt(upi_amt);
            
         

        //     if(total_amt > parseInt($('#total_amount_value').val())){
        //         // $("#error_pay_amount").html("your amount is excess paying amount");
        //         alert("your amount is excess paying amount");
        //         $('#cash').val(0);
        //         $('#card').val(0);
        //         $('#cheque').val(0);
        //         $('#upi').val(0);
        //     }else{
        //         // $("#error_pay_amount").html('');

        //     }

            
        // }        


        var final_arr = [];

    
      


   


        function autoIncrementCustomId(lastRecordId){
            var id = lastRecordId.split("/");
            
            let increasedNum = Number(id[0].replace('IN','')) + 1;
            let kmsStr = id[0].substr(0,2);
            for(let i=0; i < 3 - increasedNum.toString().length; i++){
            kmsStr = kmsStr+'0';
            }
            kmsStr = kmsStr + increasedNum.toString()+"/"+id[1];

            return kmsStr;

            
        }
        function autoIncrementreceipt(lastId){
            var id = lastId.split("/");
            
            let increasedNo = Number(id[0].replace('RP','')) + 1;
            let kmsStr = id[0].substr(0,2);
            for(let i=0; i < 3 - increasedNo.toString().length; i++){
            kmsStr = kmsStr+'0';
            }
            kmsStr = kmsStr + increasedNo.toString()+"/"+id[1];

            return kmsStr;

            
        }

     }


        function sum(arr) {
            return arr.reduce(function (a, b) {
                return a + b;
            }, 0);
        }
    
</script>
<style>
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }

    .page-button {
        padding: 5px 10px;
        margin: 0 5px;
        border: 1px solid #007bff;
        background-color: #ffffff;
        color: #007bff;
        cursor: pointer;
    }

    .page-button:hover {
        background-color: #007bff;
        color: #ffffff;
    }

    .page-button:focus {
        outline: none;
    }
    .page-button.active {
        background-color: #007bff; /* Change to the desired active color */
        color: #ffffff; /* Change text color for active button */
        font-weight: bold; /* Optional: make the active button bold */
    }

    .treatment-item {
        border: 1px solid #ccc; /* Light gray border */
        border-radius: 5px; /* Rounded corners */
        padding: 15px; /* Spacing inside the box */
        background-color: #f9f9f9; /* Light background color */
        transition: box-shadow 0.3s; /* Smooth transition for hover effect */
    }

    .treatment-item:hover {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow on hover */
    }

    .treatment-label {
        font-size: 14px; /* Font size for treatment name */
    }

    .amount-details {
        color: #555; /* Darker color for amount details */
        font-size: 14px; /* Font size for amount text */
    }

    .product-item {
        border: 1px solid #ccc; /* Light gray border */
        border-radius: 5px; /* Rounded corners */
        padding: 15px; /* Inner padding */
        background-color: #f9f9f9; /* Light background color */
        transition: box-shadow 0.3s; /* Smooth transition for hover */
        min-height: 80px; /* Consistent height */
        display: flex; /* Flexbox for alignment */
        align-items: center; /* Center items vertically */
    }

    .product-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow on hover */
    }

    .product-name {
        font-size: 14px; /* Font size for product name */
        color: #333; /* Darker text color */
        margin-bottom: 2px; /* Space below the name */
    }

    .product-amount {
        color: #3db082; /* Green color for amount */
        font-size: 13px; /* Slightly smaller font */
    }

    .form-check-label {
        width: 100%; /* Make the label full width */
        display: flex;
        align-items: center;
        justify-content: space-between;
    }



</style>



