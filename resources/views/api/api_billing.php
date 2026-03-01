<script>
    var a = sessionStorage.getItem('token');

    if (!a) {
        window.location.href = "./index";
    } else {
        var base_url = window.location.origin + '/api/';

        var id = <?php if (isset($_GET['id'])) echo $_GET['id'];
                    else echo "0" ?>;

        var permission = '';
        var total_balance = 0;
        var c_id = 0;
        // UI BYPASS: $("#add_billing").hide();
        var state_id = "";

        var Array_ids = [];

        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 10;
        let totalRecords = 0;
        let totalPages = 0;

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
                all();

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
                            }, 500);
                        };

                        // Handle image load error
                        logoImage.onerror = () => {
                            console.error('Image failed to load');
                            newWin.print();
                            newWin.close();
                        };
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function model(id) {
            billing_id = id;
            fetchBillingDetails(billing_id);
            $('#billing_balance').modal('show');
            $('#pay-balance').prop('disabled', false);
            $('#payment-amount').val('');
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
                        const {
                            total_amount,
                            paid_amount,
                            remaining_amount
                        } = data.details;

                        document.getElementById('total-amount').textContent = `₹${total_amount}`;
                        document.getElementById('paid-amount').textContent = `₹${paid_amount}`;
                        document.getElementById('remaining-amount').textContent = `₹${remaining_amount}`;

                        if (remaining_amount > total_amount) {
                            document.getElementById('warning-message').classList.remove('d-none');
                            document.getElementById('pay-balance').classList.add('d-none');
                        } else {
                            document.getElementById('warning-message').classList.add('d-none');
                            document.getElementById('pay-balance').classList.remove('d-none');
                        }

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
                    }
                });
        }

        $('#pay-balance').click(function() {
            const token = sessionStorage.getItem('token');
            const paymentAmount = parseFloat(document.getElementById('payment-amount').value) || 0;
            const totalAmount = parseFloat(document.getElementById('total-amount').textContent.replace('₹', '')) || 0;
            const paidAmount = parseFloat(document.getElementById('paid-amount').textContent.replace('₹', '')) || 0;
            const remainingAmount = parseFloat(document.getElementById('remaining-amount').textContent.replace('₹', '')) || 0;


            if (paymentAmount <= 0) {
                alert("Please enter a valid payment amount.");
                $('#pay-balance').prop('disabled', false);

                return;
            }

            $('#pay-balance').prop('disabled', true);

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
                    if (data.status === 200) {
                        all();
                        $("#status_success").html("<div class='alert alert-success' role='alert'>Payment Successfully Paid!</div>");
                        setTimeout(() => {
                            $("#status_success").html("");
                            $('#billing_balance').modal('hide');
                            all();
                        }, 2000);
                    } else {
                        alert("Payment failed. Please try again.");
                    }
                })
                .catch((error) => {
                    console.error("Error processing payment:", error);
                    alert("An error occurred while processing the payment.");
                });
        });

        // Enter key in search input
        $('#search_input').keypress(function(e) {
            if (e.which == 13) { // Enter key
                var branch_id = $("#branch_name").val();
                currentPage = 1;
                all();
            }
        });

        // Auto-search with delay (optional)
        let searchTimeout;
        $('#search_input').keyup(function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                var branch_id = $("#branch_name").val();
                currentPage = 1;
                all()
            }, 500); // 500ms delay
        });

        function all() {
            const token = sessionStorage.getItem('token');

            var branch_id = $('#branch_name').val();
            var tc_id = $('#treatment_cat_list').val();
            var t_id = $('#select_treatment').val();
            var search_input = $('#search_input').val();


            let params = new URLSearchParams();

            params.append('branch_id', branch_id);
            params.append('tc_id', tc_id);
            params.append('t_id', t_id);
            params.append('page', currentPage);
            params.append('limit', itemsPerPage);
            params.append('search_input', search_input);


            document.getElementById("loadingIndicator").style.display = "block";
            document.getElementById("billing_list").style.display = "none";

            fetch(base_url + "billing", {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "post",
                    body: params
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        totalRecords = data.total || 0;
                        totalPages = Math.ceil(totalRecords / itemsPerPage);

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

                                if (permission) {
                                    var values = permission.split(",");
                                    if (values.length > 0) {
                                        var add = values.includes('add');
                                        var edit = values.includes('edit');
                                        var view = values.includes('view');
                                        var del = values.includes('add');
                                        var print = values.includes('print');

                                        if (parseFloat(value[i].balance_amount) === 0) {
                                            del = false;
                                        }
                                        if (value[i].invoice_no == null) {
                                            print = false;
                                        }

                                        if (add) {
                                            $("#add_billing").show();
                                        } else {
                                            // UI BYPASS: $("#add_billing").hide();
                                        }

                                        if (del) {
                                            action += `<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model(${value[i].billing_id})'><i class="fa fa-rupee" title="Pay Balance" style="font-size:20px;color:red"></i></a>`;
                                        }
                                        if (print) {
                                            action += `<a href='#'onclick='on_print(${value[i].billing_id})'><i class='fa fa-print eyc'></i></a>`;
                                        }
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
                                    <td>₹${entry.total_amount}</td>
                                    <td>₹${entry.paid_amount}</td>
                                    <td>₹${entry.balance_amount}</td>
                                    <td>${paid_status}</td>
                                    <td>${action}</td>
                                </tr>
                            `;
                                totalAmount += parseFloat(entry.total_amount);
                                totalGst += parseFloat(entry.paid_amount);
                                balanceAmount += parseFloat(entry.balance_amount);
                            }

                            var totalRow = `<tfoot><tr>
                            <td colspan='3' class="fs-4"><strong>Total (this page)</strong></td>
                            <td><strong class="text-info fs-4">₹${totalAmount.toFixed(2)}</strong></td>
                            <td><strong class="text-success fs-4">₹${totalGst.toFixed(2)}</strong></td>
                            <td><strong class="text-danger fs-4">₹${balanceAmount.toFixed(2)}</strong></td>
                            <td></td>
                        </tr></tfoot>`;

                            htmlString += totalRow + "</tbody></table>";

                            // Add pagination container
                            htmlString += `<div id='custom-pagination-container' class='mt-3'></div>`;

                            $("#billing_list").html(htmlhead + htmlString);

                            // Initialize DataTable
                            initializeDataTable();

                            // Create custom pagination
                            createCustomPagination();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error fetching billing data:', error);
                })
                .finally(() => {
                    document.getElementById("loadingIndicator").style.display = "none";
                    document.getElementById("billing_list").style.display = "block";
                });
        }

        var billing_id = '';

        function initializeDataTable() {
            // Destroy existing DataTable instance if it exists
            if ($.fn.DataTable.isDataTable('#advance-1')) {
                $('#advance-1').DataTable().destroy();
            }

            // Initialize DataTable with pagination disabled
            $('#advance-1').DataTable({
                "ordering": false,
                "responsive": true,
                "aaSorting": [],
                "paging": false,
                "info": false,
                "searching": true,
                "language": {
                    "lengthMenu": "Show _MENU_",
                },
                "dom": "<'row'" +
                    // "<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
                    // "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +
                    "<'table-responsive'tr>"
            });
        }

        // Update the createCustomPagination function:
        function createCustomPagination() {
            if (totalPages <= 1) {
                $('#custom-pagination-container').html('');
                return;
            }

            let paginationHtml = `<div class="d-flex justify-content-between align-items-center">
        <div class="page-info">
            <small class="text-muted">Showing ${((currentPage - 1) * itemsPerPage + 1)} to ${Math.min(currentPage * itemsPerPage, totalRecords)} of ${totalRecords} entries</small>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination mb-0">`;

            // Previous button
            paginationHtml += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="javascript:void(0)" onclick="goToPage(${currentPage - 1})" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
        </a>
    </li>`;

            // Always show first page
            if (currentPage > 3) {
                paginationHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="goToPage(1)">1</a></li>`;
                if (currentPage > 4) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }

            // Show pages around current page
            const startPage = Math.max(2, currentPage - 2);
            const endPage = Math.min(totalPages - 1, currentPage + 2);

            for (let i = startPage; i <= endPage; i++) {
                paginationHtml += `<li class="page-item ${currentPage === i ? 'active' : ''}">
            <a class="page-link" href="javascript:void(0)" onclick="goToPage(${i})">${i}</a>
        </li>`;
            }

            // Always show last page
            if (currentPage < totalPages - 2) {
                if (currentPage < totalPages - 3) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
                paginationHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="goToPage(${totalPages})">${totalPages}</a></li>`;
            }

            // Next button
            paginationHtml += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link" href="javascript:void(0)" onclick="goToPage(${currentPage + 1})" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
        </a>
    </li>`;

            paginationHtml += `</ul></nav></div>`;

            $("#custom-pagination-container").html(paginationHtml);
        }

        // Also update the DataTable initialization to remove the default info:
        function initializeDataTable() {
            // Destroy existing DataTable instance if it exists
            if ($.fn.DataTable.isDataTable('#advance-1')) {
                $('#advance-1').DataTable().destroy();
            }

            // Initialize DataTable with custom DOM
            $('#advance-1').DataTable({
                "ordering": false,
                "responsive": true,
                "aaSorting": [],
                "paging": false,
                "info": false, // This hides the default "Showing X to Y of Z entries"
                "searching": true,
                "language": {
                    "lengthMenu": "Show _MENU_",
                    "info": "", // Empty string to ensure no info is shown
                    "infoEmpty": "",
                    "infoFiltered": ""
                },
                "dom": "<'row'" +
                    // "<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
                    // "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +
                    "<'table-responsive'tr>"
            });
        }

        // Function to navigate to specific page
        function goToPage(page) {
            if (page < 1 || page > totalPages || page === currentPage) return;

            currentPage = page;
            all();
        }

        // Rest of your existing functions (getbranchall, cattreatmentall, etc.)
        // ... (keep all your other functions as they were)
        function cattreatmentall(id = 0) {
            fetch(base_url + "treatment", {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        if (data.data) {
                            var value = data.data;
                            var htmlString = "";
                            var htmlhead = "<option value='0'>All</option>";
                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0') {
                                    htmlString += "<option value=" + value[i].treatment_id + ">" + value[i].treatment_name + "</option>"
                                }
                            }
                            var htmlstringall = htmlhead + htmlString;
                            $("#select_treatment").html(htmlstringall);
                        }
                    }
                });
        }

        //   gettreatmentcatall();

        function gettreatmentcatall() {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "treatment_cat", {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        if (data.data) {
                            const value = data.data;
                            var htmlString = "";
                            var htmlhead = "<label class='form-label'>Categories</label><select class='form-select' id='tc_name'><option value='0'>All</option>";
                            for (var i = 0; i < value.length; i++) {
                                htmlString += "<option value=" + value[i].tcategory_id + ">" + value[i].tc_name + "</option>"
                            }
                            var htmlfooter = "</select><div class='text-danger' id='error_tc_name'></div>";
                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#treatment_cat_list").html(htmlstringall);
                        }
                    }
                });
        }

        if (id > 0) {
            gettcategoryall(id);
        }

        

        // Initial load
        all();

        // Your other functions remain unchanged below...
        // ... (all the remaining functions from your original code)

        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);

        getbranchall(branch_id);

        function getbranchall(branch_id) {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "branch", {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        if (data.data) {
                            function sel_status(value) {
                                // const = branch_id.length == 0
                                // const branc_ids =branch_id;
                                if (value == branch_id[1]) {
                                    return 'selected';
                                } else {
                                    return '';
                                }
                            }

                            const value = data.data;
                            var htmlString = "";
                            var htmlhead = "<option value=''>All Branch</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (sessionStorage.getItem('role') != 1) {
                                    if (value[i].status == '0' && branch_id.includes(value[i].branch_id)) {
                                        htmlString += "<option value='" + value[i].branch_id + "'" + sel_status(value[i].branch_id) + ">" + value[i].branch_name + "</option>";
                                    }

                                } else {
                                    if (value[i].status == '0') {

                                        htmlString += "<option value='" + value[i].branch_id + "'" + sel_status(value[i].branch_id) + ">" + value[i].branch_name + "</option>";

                                    }
                                }
                            }

                            var htmlstringall = htmlhead + htmlString;
                            $("#branch_name").html(htmlstringall);

                            // Ensure the default selection is set after populating the dropdown

                            all(); // Call any other functions if needed
                        }
                    }
                });
        }
        $('#all_billing_list').on('click', function() {
            currentPage = 1; // Reset to first page on filter
            // var tc_id = document.getElementById("treatment_cat_list").value;
            // var t_id = document.getElementById("select_treatment").value;
            var branch_id = $('#branch_name').val();
            // cattreatmentall(id, branch_id)
            all();
        });

    }

    function sum(arr) {
        return arr.reduce(function(a, b) {
            return a + b;
        }, 0);
    }
</script>
<style>
    /* Loader Styles */
    #loadingIndicator {
        padding: 40px;
    }

    .spinner-border {
        width: 3rem;
        height: 3rem;
    }

    /* Table Styles */
    .product-table {
        min-height: 400px;
    }

    /* Modal Styles */
    .modal-lg {
        max-width: 600px;
    }

    /* Treatment and Product Item Styles */
    .treatment-item {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 15px;
        background-color: #f9f9f9;
        transition: box-shadow 0.3s;
    }

    .treatment-item:hover {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .treatment-label {
        font-size: 14px;
    }

    .amount-details {
        color: #555;
        font-size: 14px;
    }

    .product-item {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 15px;
        background-color: #f9f9f9;
        transition: box-shadow 0.3s;
        min-height: 80px;
        display: flex;
        align-items: center;
    }

    .product-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .product-name {
        font-size: 14px;
        color: #333;
        margin-bottom: 2px;
    }

    .product-amount {
        color: #3db082;
        font-size: 13px;
    }

    .form-check-label {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Alert Styles */
    .alert {
        margin: 15px 0;
    }

    /* DataTable Customization */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 15px;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0.375rem 0.75rem;
    }
</style>

<style>
    /* Pagination Container */
    #custom-pagination-container {
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
        margin-top: 20px;
        border: 1px solid #dee2e6;
    }

    .page-info {
        font-size: 14px;
        color: #495057;
    }

    /* Pagination Styles */
    .pagination {
        margin: 0;
    }

    .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
        z-index: 3;
    }

    .page-link {
        color: #007bff;
        cursor: pointer;
        padding: 0.375rem 0.75rem;
        border: 1px solid #dee2e6;
        margin-left: -1px;
    }

    .page-link:hover {
        color: #0056b3;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    .page-item:first-child .page-link {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }

    .page-item:last-child .page-link {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        cursor: not-allowed;
        background-color: #fff;
        border-color: #dee2e6;
    }

    /* Ensure proper spacing */
    .dataTables_wrapper {
        padding-bottom: 0 !important;
    }

    /* Remove any duplicate pagination from DataTable */
    .dataTables_paginate {
        display: none !important;
    }

    .dataTables_info {
        display: none !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        #custom-pagination-container {
            flex-direction: column;
            text-align: center;
        }

        .page-info {
            margin-bottom: 10px;
        }

        .pagination {
            justify-content: center;
        }
    }
</style>

