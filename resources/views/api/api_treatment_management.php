<script>
    var a = sessionStorage.getItem('token');
    if (!a) {
        window.location.href = "./index";
    } else {
        var base_url = window.location.origin + '/api/';
        var tc_id = 0;
        var total_amount = 0;
        var permission = '';

        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 10;
        let totalRecords = 0;
        let totalPages = 0;

        // UI BYPASS: $("#add_t_management").hide();
        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);

        async function permission_page(name) {
            try {
                const token = sessionStorage.getItem('token');
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

        permission_page("customer_treatment").then(() => {
            try {
                console.log(permission);
                all(permission);
            } catch (error) {
                console.error(error);
            }
        });

        gettcall();
        gettreatmentall();
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
                                if (value == branch_id[1]) {
                                    getuserall(branch_id[1]);
                                    return 'selected';
                                } else {
                                    return '';
                                }
                            }
                            const value = data.data;
                            var htmlString = "";
                            var htmlhead = "<option value=''>All Branch</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (sessionStorage.getItem('role') > 2) {
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
                        }
                    }
                });
        }

        $('#treatment_cat_list').on('click', function() {
            var id = document.getElementById("treatment_cat_list").value;
            cattreatmentall(id);
            currentPage = 1; // Reset to first page on filter
            all();
        });

        function cattreatmentall(id = 0) {
            const token = sessionStorage.getItem('token');
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

        gettreatmentcatall();

        function gettreatmentall() {
            const token = sessionStorage.getItem('token');
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
                            const value = data.data;
                            var htmlString = "";
                            var htmlhead = "<option value='0'>Select Treatment</option>";

                            for (var i = 0; i < value.length; i++) {
                                htmlString += "<option value=" + value[i].treatment_id + ">" + value[i].treatment_name + "</option>"
                            }

                            var htmlstringall = htmlhead + htmlString;
                            $("#treatment_list").html(htmlstringall);
                        }
                    }
                });
        }

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

        function mobile_search(e) {
            keyvalue = e.keyCode;
            if (keyvalue == 13) {
                var mobile = e.target.value;
                if (!mobile) {
                    $('#error_mobile').html("");
                    getuserall();
                } else {
                    if (mobile.length != 10) {
                        $('#error_mobile').html("mobile number is invalid ");
                    } else {
                        $('#error_mobile').html("");
                        const token = sessionStorage.getItem('token');
                        fetch(base_url + "customer_search/" + mobile, {
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
                                        var htmlhead = "<option value='0'>Select customer name</option>";

                                        for (var i = 0; i < value.length; i++) {
                                            if (value[i].status == '0') {
                                                htmlString += "<option selected value=" + value[i].customer_id + ">" + value[i].customer_first_name + value[i].customer_last_name + ' - ' + value[i].customer_phone + "</option>"
                                            }
                                        }

                                        var htmlstringall = htmlhead + htmlString;
                                        $("#customer_name").html(htmlstringall);

                                        if (data.data.length == 0) {
                                            $("#error_mobile").html("Customer name not found please try again");
                                        }
                                    }
                                }
                            });
                    }
                }
            }
        }

        $('#customer_name').change(function() {
            $("#error_mobile").html("");
            $("#mobile").val("");
            getusermobile($(this).val());
        })

        function getusermobile(id) {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "cus_treament_list/" + id, {
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
                            document.getElementById('mobile').value = data.mobile;
                        }
                    }
                });
        }

        function gettcall() {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "manage_treatment_cat", {
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
                            var htmlhead = "<label class='form-label'>Categories</label><select class='form-select' id='tc_name' onchange='select_t_Category();'><option value='0'>Select Categories</option>";

                            for (var i = 0; i < value.length; i++) {
                                htmlString += "<option value=" + value[i].tcategory_id + ">" + value[i].tc_name + "</option>"
                            }

                            var htmlfooter = "</select><div class='text-danger' id='error_tc_name'></div>";
                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#tc_name").html(htmlstringall);
                        }
                    }
                });
        }

        function gettreatmentall(id = 0) {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "manage_treatment/" + id, {
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
                            var htmlhead = "<option value='0'>Select Lead Status</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0') {
                                    htmlString += "<option value=" + value[i].treatment_id + ">" + value[i].treatment_name + "</option>"
                                }
                            }

                            var htmlstringall = htmlhead + htmlString;
                            $("#treatment_name").html(htmlstringall);
                        }
                    }
                });
        }

        function getuserall(branch_id = 0) {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "customer/" + branch_id, {
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
                            var htmlhead = "<option value='0'>Select customer name</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0' && branch_id == value[i].branch_id) {
                                    htmlString += "<option value=" + value[i].customer_id + ">" + value[i].customer_first_name + " " + value[i].customer_last_name + ' - ' + value[i].customer_phone + "</option>"
                                }
                            }

                            var htmlstringall = htmlhead + htmlString;
                            $("#customer_name").html(htmlstringall);
                        }
                    }
                });
        }

        $('#branch_name').change(function() {
            var branch_id = $(this).val();
            getuserall(branch_id);
        });

        $('#select_treatment').change(function() {
            currentPage = 1; // Reset to first page on filter
            all();
        });

        $('#select_status').change(function() {
            currentPage = 1; // Reset to first page on filter
            all();
        });

        function selectbranch(e) {
            currentPage = 1; // Reset to first page on filter
            all();
        }

        // Enter key in search input
        $('#search_input').keypress(function(e) {
            if (e.which == 13) { // Enter key
                currentPage = 1;
                all();
            }
        });

        // Auto-search with delay (optional)
        let searchTimeout;
        $('#search_input').keyup(function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                currentPage = 1;
                all();
            }, 500); // 500ms delay
        });

        // Modified all() function with SERVER-SIDE pagination
        function all() {
            const token = sessionStorage.getItem('token');

            var branch_id = $('#branch_name').val();
            var tc_id = $('#treatment_cat_list').val();
            var t_id = $('#select_treatment').val();
            var status = $('#select_status').val();
            var search_input = $('#search_input').val();

            let params = new URLSearchParams();
            params.append('branch_id', branch_id);
            params.append('tc_id', tc_id);
            params.append('t_id', t_id);
            params.append('status', status);
            params.append('search_input', search_input);
            // ADD PAGINATION PARAMETERS
            params.append('page', currentPage);
            params.append('limit', itemsPerPage);

            document.getElementById("loadingIndicator").style.display = "block";
            document.getElementById("treatment_management_list").style.display = "none";

            fetch(base_url + "customer_treatment", {
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
                        // Update pagination variables from API response
                        totalRecords = data.total || 0;
                        totalPages = Math.ceil(totalRecords / itemsPerPage);

                        if (data.data) {
                            const value = data.data;
                            var htmlString = "";
                            var htmlhead = "<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Treatment Categories</th><th>Treatment Name</th><th>Customer Name</th><th>Treatment Status</th><th>Amount</th><th>Balance</th><th>Action</th></tr></thead><tbody>";

                            // Calculate starting index for serial numbers
                            const startIndex = (currentPage - 1) * itemsPerPage;

                            for (var i = 0; i < value.length; i++) {
                                const serialNo = startIndex + i + 1;

                                if (value[i].complete_status == '0') {
                                    var status = "<span class='text-primary'>Progress</span>";
                                } else {
                                    var status = "<span class='text-success'>Completed</span>";
                                }

                                var tickIconId = "tick-icon-" + i;
                                var tickIconDisplay = value[i].complete_status == 1 ? 0 : 1;
                                var invoioce = "";
                                var action = "";

                                if (permission) {
                                    var cama = stringHasTheWhiteSpaceOrNot(permission);
                                    if (cama) {
                                        var values = permission.split(",");
                                        if (values.length > 0) {
                                            var add = values.includes('add');
                                            var edit = values.includes('edit');
                                            var view = values.includes('view');
                                            var del = values.includes('delete');
                                            var print = values.includes('print');

                                            if (add) {
                                                $("#add_t_management").show();
                                            } else {
                                                // UI BYPASS: $("#add_t_management").hide();
                                            }

                                            if (tickIconDisplay) {
                                                action += "<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='modelcomplete(" + value[i].cus_treat_id + ")'><i id='" + tickIconId + "' class='fa fa-check'></i></a>";
                                            }
                                            if (edit) {
                                                action += "<a href='edit_t_management?tm_id=" + value[i].cus_treat_id + "'" + "><i class='fa fa-edit eyc'></i></a>";
                                            }

                                            if (view) {
                                                action += "<a href='view_t_management?tm_id=" + value[i].cus_treat_id + "'" + "><i class='fa fa-eye eyc'></i></a>";
                                            }

                                            if (print && value[i].balance == 0) {
                                                action += "<a href='#' data-bs-toggle='modal' data-toggle='tooltip' data-placement='bottom' title='invoice' data-bs-target='' onclick='invoice_print(" + value[i].p_id + ")'><i class='fa fa-file-text-o'></i></a>";
                                            }
                                        }
                                    }
                                }

                                var invoice = value[i].invoice_no;
                                if (value[i].invoice_no == null) {
                                    invoice = " ";
                                }
                                // <td>" + invoice + "</td>
                                htmlString += "<tr><td>" + serialNo + "</td><td>" + value[i].tc_name + "<br/>" + (value[i].treatment_auto_id ? value[i].treatment_auto_id : '') + "</td><td>" + value[i].treatment_name + "</td><td>" + value[i].customer_first_name + "</td><td>" + status + "</td><td>" + value[i].amount + "</td><td>" + value[i].balance + "</td><td>" + action + invoioce + "</td></tr>";
                            }

                            var htmlfooter = "</tbody></table>";

                            // Add pagination container
                            htmlfooter += `<div id='treatment-pagination-container' class='mt-3'></div>`;

                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#treatment_management_list").html(htmlstringall);

                            // Initialize DataTable without default pagination
                            initializeTreatmentDataTable();

                            // Create custom pagination
                            createTreatmentPagination();
                        }
                    }
                })
                .finally(() => {
                    document.getElementById("loadingIndicator").style.display = "none";
                    document.getElementById("treatment_management_list").style.display = "block";
                });
        }

        // Helper function
        function stringHasTheWhiteSpaceOrNot(value) {
            return value.indexOf(',') >= 0;
        }

        // Function to initialize DataTable for treatments
        function initializeTreatmentDataTable() {
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
                    "info": "",
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

        // Function to create custom pagination for treatments
        function createTreatmentPagination() {
            if (totalPages <= 1) {
                $('#treatment-pagination-container').html('');
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
                <a class="page-link" href="javascript:void(0)" onclick="goToTreatmentPage(${currentPage - 1})" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>`;

            // Always show first page
            if (currentPage > 3) {
                paginationHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="goToTreatmentPage(1)">1</a></li>`;
                if (currentPage > 4) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }

            // Show pages around current page
            const startPage = Math.max(2, currentPage - 2);
            const endPage = Math.min(totalPages - 1, currentPage + 2);

            for (let i = startPage; i <= endPage; i++) {
                paginationHtml += `<li class="page-item ${currentPage === i ? 'active' : ''}">
                    <a class="page-link" href="javascript:void(0)" onclick="goToTreatmentPage(${i})">${i}</a>
                </li>`;
            }

            // Always show last page
            if (currentPage < totalPages - 2) {
                if (currentPage < totalPages - 3) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
                paginationHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="goToTreatmentPage(${totalPages})">${totalPages}</a></li>`;
            }

            // Next button
            paginationHtml += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0)" onclick="goToTreatmentPage(${currentPage + 1})" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>`;

            paginationHtml += `</ul></nav></div>`;

            $("#treatment-pagination-container").html(paginationHtml);
        }

        // Function to navigate to specific page for treatments
        function goToTreatmentPage(page) {
            if (page < 1 || page > totalPages || page === currentPage) return;

            currentPage = page;
            all(); // Call API again with new page
        }

        // Rest of your existing functions (invoice_print, add_customer_treatment, etc.)
        // Update these functions to reset currentPage = 1

        $('#complete').click(function() {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "completed_customer_treatment/" + complete_id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "post",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        currentPage = 1; // Reset to first page
                        all(); // This will refetch data
                        $("#status_success").html("<div class='alert alert-success' role='alert'>Treamtment Successfully Completed!</div>");
                        setTimeout(() => {
                            $("#status_success").html("");
                        }, 4000);
                    }
                });
        });

        $('#delete').click(function() {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "delete_customer_treatment/" + delete_id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "delete",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        currentPage = 1; // Reset to first page
                        all(); // This will refetch data
                        $("#status_success").html("<div class='alert alert-success' role='alert'>Treamtment Successfully Deleted!</div>");
                        setTimeout(() => {
                            $("#status_success").html("");
                        }, 4000);
                    }
                });
        });

        // Keep all your other functions as they were
        // Remove the old datatable() function since we're using initializeTreatmentDataTable()

        function invoice_print(id) {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "invoice?p_id=" + id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "post",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        // ... your existing invoice print code
                    }
                });
        }

        function add_customer_treatment() {


            var customer_id = document.getElementById("customer_name").value;
            var treatment_id = document.getElementById("treatment_name").value;
            var tc_id = document.getElementById("tc_name").value;
            var progress = 0;
            var remark = document.getElementById("remark").value;
            var medicine = "";
            var amount = document.getElementById("final_amount").value;
            // var discount = document.getElementById("discount").value;
            var regex = /^\d+(\.\d{2,2})?$/;

            if (customer_id == '0') {

                $("#error_customer_name").html("Please select customer name");
                customer_id = '';

            } else {
                $("#error_customer_name").html("");
            }

            if (treatment_id == '0') {

                $("#error_treatment_name").html("Please select treatment name");
                treatment_id = '';

            } else {
                $("#error_treatment_name").html("");
            }


            if (tc_id == '0') {

                $("#error_tc_name").html("Please select category name");

            } else {
                $("#error_tc_name").html("");
            }






            if (customer_id && treatment_id) {

                document.getElementById('add_customer_t').style.pointerEvents = 'none';


                var data = "customer_id=" + customer_id + "&treatment_id=" + treatment_id + "&tc_id=" + tc_id + "&progress=" + progress + "&remarks=" + remark + "&amount=" + amount + "&medicine=" + medicine;

                const token = sessionStorage.getItem('token');

                fetch(base_url + "add_customer_treatment?" + data, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                        },
                        method: "post",
                    })
                    .then((response) => response.json())
                    .then((data) => {



                        if (data.status == '200') {

                            $("#status_success").html("<div class='alert alert-success' role='alert'>Customer Treatment Successfully Added!</div>");

                            setTimeout(() => {
                                $("#status_success").html("");
                                window.location.href = "./treatment_management";
                            }, 4000);


                        } else {
                            $("#status_success").html("<div class='alert alert-danger' role='alert'>Customer already Assigned Treatment is Ongoing !</div>");
                            setTimeout(() => {
                                $("#status_success").html("");
                            }, 4000);

                        }
                        document.getElementById('add_customer_t').style.pointerEvents = 'auto';
                    });
            }

        }
        $('#select_discount').on('change', function() {

            if (this.value == 'percent') {
                $dis = $('#discount').val();

                if ($dis > 100) {
                    $('#error_discount').html('Max discount 100 only');
                } else {

                    $('#error_discount').html('');
                    $val = total_amount / 100 * $dis;

                    $f_val = total_amount - $val;

                    $('#amount').val($f_val);

                }

            } else {
                $('#error_discount').html('');
                $f_val = total_amount - $('#discount').val();

                $('#amount').val($f_val);
            }


        });

        function status(id, status) {

            if (status == '1') {
                var lead_status = 0;
            } else {
                var lead_status = 1;
            }
            const token = sessionStorage.getItem('token');
            fetch(base_url + "customer_treatment_status/" + id + '?status=' + lead_status, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {

                    if (data.status == '200') {

                        $("#status_success").html("<div class='alert alert-success' role='alert'>Lead Successfully Updated!</div>");

                        setTimeout(() => {
                            $("#status_success").html("");
                            all();
                        }, 4000);

                    }
                });

        }
        var delete_id = '';

        function model(id) {

            $('#t_management_delete').modal('show');
            delete_id = id;
        }

        $('#delete').click(function() {

            const token = sessionStorage.getItem('token');

            fetch(base_url + "delete_customer_treatment/" + delete_id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "delete",
                })
                .then((response) => response.json())
                .then((data) => {

                    if (data.status == '200') {

                        all();

                        $("#status_success").html("<div class='alert alert-success' role='alert'>Treamtment Successfully Deleted!</div>");

                        setTimeout(() => {
                            $("#status_success").html("");
                        }, 4000);

                    }
                });
        })

        var complete_id = '';

        function modelcomplete(id) {

            $('#t_management_completed').modal('show');
            complete_id = id;
        }

        $('#complete').click(function() {

            const token = sessionStorage.getItem('token');

            fetch(base_url + "completed_customer_treatment/" + complete_id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "post",
                })
                .then((response) => response.json())
                .then((data) => {

                    if (data.status == '200') {

                        all();

                        $("#status_success").html("<div class='alert alert-success' role='alert'>Treamtment Successfully Completed!</div>");

                        setTimeout(() => {
                            $("#status_success").html("");
                        }, 4000);

                    }
                });
        });

    }
</script>

