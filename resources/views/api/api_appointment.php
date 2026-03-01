<script>
    var a = sessionStorage.getItem('token');
    if (!a) {
        window.location.href = "./";
    } else {
        // // UI BYPASS: $("#add_appointment").hide();
        var base_url = window.location.origin + '/api/';

        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 10;
        let totalRecords = 0;
        let totalPages = 0;
        let currentFromDate = "";
        let currentToDate = "";
        let currentBranchId = "";
        let currentPermission = "";

        let permission = "";

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
                currentPermission = permission;
                console.log(permission);
                $('#permission_details').val(permission);

            } catch (error) {
                console.error(error);
                throw error;
            }
        }

        permission_page("appointment").then(() => {
            try {
                console.log(permission);

                $('#data_filter').click(function() {
                    var branch_id = $('#branch_name').val();
                    from_date = document.getElementById('from_date').value;
                    to_date = document.getElementById('to_date').value;
                    currentPage = 1; // Reset to first page on filter
                    all(from_date, to_date, branch_id, permission);
                });

                // Set default dates if not set
                if (!from_date) {
                    from_date = new Date().toISOString().split('T')[0];
                }
                if (!to_date) {
                    to_date = new Date().toISOString().split('T')[0];
                }

                var branch_ids = sessionStorage.getItem('branch_id');
                var branch_id = JSON.parse(branch_ids);
                all(from_date, to_date, branch_id[1], permission);
            } catch (error) {
                console.error(error);
            }
        });

        console.log(permission);

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
                                if (value == branch_id[1]) {
                                    getuserall(value)
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
                        }
                    } else {
                        location.reload();
                    }
                });
        }

        function mobile_search(e) {
            keyvalue = e.keyCode;
            if (keyvalue == 13) {
                var mobile = e.target.value;
                if (!mobile) {
                    $('#error_mobile').html("");
                    var b_id = $('#branch_name').val();
                    if (is_customer == '1') {
                        getuserall(b_id)
                    } else {
                        getuserall(b_id)
                    }
                } else {
                    if (mobile.length != 10) {
                        $('#error_mobile').html("mobile number is invalid ");
                    } else {
                        $('#error_mobile').html("");
                        const token = sessionStorage.getItem('token');
                        if (is_customer == '1') {
                            fetch(base_url + "lead_search/" + mobile, {
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
                                            var htmlhead = "<option selected value='0'>Select Lead name</option>";
                                            for (var i = 0; i < value.length; i++) {
                                                if (value[i].status == '0') {
                                                    htmlString += "<option selected value=" + value[i].lead_id + ">" + value[i].lead_first_name + "</option>"
                                                }
                                            }
                                            var htmlstringall = htmlhead + htmlString;
                                            $("#app_user_name").html(htmlstringall);
                                            if (data.data.length == 0) {
                                                $("#error_mobile").html("Lead name not found please try again");
                                            }
                                        }
                                    }
                                });
                        } else {
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
                                                    htmlString += "<option selected value=" + value[i].customer_id + ">" + value[i].customer_first_name + " " + value[i].customer_last_name + ' - ' + value[i].customer_phone + "</option>"
                                                }
                                            }
                                            var htmlstringall = htmlhead + htmlString;
                                            $("#app_user_name").html(htmlstringall);
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
        }

        function getuserall(branch_id, chk = 0) {
            const token = sessionStorage.getItem('token');
            var lead_appointment_id = document.getElementById("lead_appointment_id");
            if (chk == 1) {
                var lead_appointment_id = document.getElementById("lead_appointment_id").checked;
                if (lead_appointment_id) {
                    var id = 1;
                } else {
                    var id = 0;
                }
            } else {
                var id = 0;
            }

            if (id == 1) {
                fetch(base_url + "lead/" + branch_id, {
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
                                var htmlhead = "<option value='0'>Select Lead name</option>";
                                for (var i = 0; i < value.length; i++) {
                                    if (value[i].status == '0' && branch_id == value[i].branch_id) {
                                        htmlString += "<option value=" + value[i].lead_id + ">" + value[i].lead_first_name + " " + value[i].lead_last_name + ' - ' + value[i].lead_phone + "</option>"
                                    }
                                }
                                var htmlstringall = htmlhead + htmlString;
                                $("#app_user_name").html(htmlstringall);
                            }
                        }
                    });
            } else {
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
                                var htmlhead = "<option value='0'>Select Customer name</option>";
                                for (var i = 0; i < value.length; i++) {
                                    if (value[i].status == '0' && branch_id == value[i].branch_id) {
                                        htmlString += "<option value=" + value[i].customer_id + ">" + value[i].customer_first_name + " " + value[i].customer_last_name + ' - ' + value[i].customer_phone + "</option>"
                                    }
                                }
                                var htmlstringall = htmlhead + htmlString;
                                $("#app_user_name").html(htmlstringall);
                            }
                        }
                    });
            }
        }

        $('#branch_name').change(function() {
            var branch_id = $(this).val();
            getuserall(branch_id);
        })

        $('#app_user_name').change(function() {
            $("#error_mobile").html("");
            $("#mobile").val("");
            gettreatmentall($(this).val());
        })

        function gettreatmentall(id) {
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
                            const value = data.data;
                            var htmlString = "";
                            var htmlhead = "<option value='0'>Select Treatment</option>";
                            if (value == "") {
                                $("#error_app_cus_treatment").html("This Customer don't have Treatment");
                            } else {
                                for (var i = 0; i < value.length; i++) {
                                    htmlString += "<option value=" + value[i].treatment_id + ">" + value[i].treatment_name + "</option>";
                                }
                                $("#error_app_cus_treatment").html("");
                            }
                            var htmlstringall = htmlhead + htmlString;
                            if (htmlString === "") {
                                htmlstringall = htmlhead;
                            }
                            $("#app_cus_treatment").html(htmlstringall);
                        }
                    }
                });
        }

        var from_date = "<?php echo date('Y-m-d'); ?>";
        var to_date = "<?php echo date('Y-m-d'); ?>";

        // Modified all() function with pagination
        function all(from, to, branch_id, permission = '') {
            const token = sessionStorage.getItem('token');

            // Store current parameters
            currentFromDate = from;
            currentToDate = to;
            currentBranchId = branch_id;
            if (permission) {
                currentPermission = permission;
            }

            // Build URL with pagination parameters
            let data = "from=" + from + "&to=" + to +
                "&branch_id=" + branch_id +
                "&page=" + currentPage +
                "&limit=" + itemsPerPage;

            fetch(base_url + "appointment?" + data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (permission) {
                        var cama = stringHasTheWhiteSpaceOrNot(permission);
                        if (cama) {
                            var values = permission.split(",");
                            if (values.length > 0) {
                                var add = values.includes('add');
                                add_permission = add;
                                if (add_permission) {
                                    $("#add_appointment").show();
                                } else {
                                    // UI BYPASS: $("#add_appointment").hide();
                                }
                            }
                        }
                    }

                    if (data.status == '200') {
                        // Update pagination variables from API response
                        totalRecords = data.total || data.data?.length || 0;
                        totalPages = Math.ceil(totalRecords / itemsPerPage);

                        if (data.data) {
                            const value = data.data;
                            var htmlString = "";
                            var htmlhead = "<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Name</th><th>Date</th><th>Time</th><th>Problem</th><th>Remarks</th><th>App.Status</th><th>Action</th></tr></thead><tbody>";

                            // Calculate starting index for serial numbers
                            const startIndex = (currentPage - 1) * itemsPerPage;

                            for (var i = 0; i < value.length; i++) {
                                const serialNo = startIndex + i + 1;

                                var status = "";
                                if (value[i].user_status == 'Customer') {
                                    $sts = 1;
                                } else {
                                    $sts = 2;
                                }

                                if (value[i].app_status == 1) {
                                    status = "<span style='cursor:pointer;background:#f1ecec;' class='text-danger shadow p-1 mb-1'><i class='fa fa-user-md p-0 ' style='font-size:15px' aria-hidden='true' onclick='app_status(" + value[i].appointment_id + ',' + '2' + ',' + $sts + ',' + value[i].user_id + ',' + value[i].treatment_id + ")' title='Check Out'> Click Check Out</i></span>";
                                } else if (value[i].app_status == 2) {
                                    status = "<span style='background:#f1ecec;' class='text-success shadow p-1 mb-1 rounded'><i class='fa fa-check p-0 ' style='font-size:15px' aria-hidden='true'> Completed</i></span>";
                                } else {
                                    status = "<span style='cursor:pointer;background:#f1ecec;' class='text-primary shadow p-1 mb-1'><i class='fa fa-user-md p-0 ' style='font-size:15px' aria-hidden='true' title='Check In' onclick='app_status(" + value[i].appointment_id + ',' + '1' + ")'> Click Check In</i></span>";
                                }

                                var action = "";
                                if (permission) {
                                    var cama = stringHasTheWhiteSpaceOrNot(permission);
                                    if (cama) {
                                        var values = permission.split(",");
                                        if (values.length > 0) {
                                            var edit = values.includes('edit');
                                            var view = values.includes('view');
                                            var del = values.includes('delete');
                                            if (edit) {
                                                action += "<a href='edit_app?ap_id=" + value[i].appointment_id + "'" + "><i class='fa fa-edit eyc'></i></a>";
                                            }
                                            if (view) {
                                                action += "<a href='view_app?ap_id=" + value[i].appointment_id + "'" + "><i class='fa fa-eye eyc'></i></a>";
                                            }
                                            // if(del){  
                                            //     action += "<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model("+value[i].appointment_id +")'><i class='fa fa-trash eyc'></i></a>";}
                                            // }
                                        }
                                    }
                                }

                                htmlString += "<tr><td>" + serialNo + "</td><td>" + value[i].user_name + " " + "(<span class='text-primary'>" + value[i].user_status + "</span>)<div>" + value[i].phone + "</div>" + "</td> <td>" + value[i].date + "</td><td>" + value[i].time + "</td><td>" + value[i].problem + "</td><td>" + value[i].remark + "</td><td>" + status + "</td><td>" + action + "</td></tr>";
                            }

                            var htmlfooter = "</tbody></table>";

                            // Add pagination container
                            htmlfooter += `<div id='appointment-pagination-container' class='mt-3'></div>`;

                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#appointment_list").html(htmlstringall);

                            // Initialize DataTable without default pagination
                            initializeAppointmentDataTable();

                            // Create custom pagination
                            createAppointmentPagination();
                        }
                    }
                });
        }

        // Helper function
        function stringHasTheWhiteSpaceOrNot(value) {
            return value.indexOf(',') >= 0;
        }

        // Function to initialize DataTable for appointments
        function initializeAppointmentDataTable() {
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
                    "<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +
                    "<'table-responsive'tr>"
            });
        }

        // Function to create custom pagination for appointments
        function createAppointmentPagination() {
            if (totalPages <= 1) {
                $('#appointment-pagination-container').html('');
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
                <a class="page-link" href="javascript:void(0)" onclick="goToAppointmentPage(${currentPage - 1})" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>`;

            // Always show first page
            if (currentPage > 3) {
                paginationHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="goToAppointmentPage(1)">1</a></li>`;
                if (currentPage > 4) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }

            // Show pages around current page
            const startPage = Math.max(2, currentPage - 2);
            const endPage = Math.min(totalPages - 1, currentPage + 2);

            for (let i = startPage; i <= endPage; i++) {
                paginationHtml += `<li class="page-item ${currentPage === i ? 'active' : ''}">
                    <a class="page-link" href="javascript:void(0)" onclick="goToAppointmentPage(${i})">${i}</a>
                </li>`;
            }

            // Always show last page
            if (currentPage < totalPages - 2) {
                if (currentPage < totalPages - 3) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
                paginationHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="goToAppointmentPage(${totalPages})">${totalPages}</a></li>`;
            }

            // Next button
            paginationHtml += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0)" onclick="goToAppointmentPage(${currentPage + 1})" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>`;

            paginationHtml += `</ul></nav></div>`;

            $("#appointment-pagination-container").html(paginationHtml);
        }

        // Function to navigate to specific page for appointments
        function goToAppointmentPage(page) {
            if (page < 1 || page > totalPages || page === currentPage) return;

            currentPage = page;
            all(currentFromDate, currentToDate, currentBranchId, currentPermission);
        }

        let is_type;

        function app_status(id, status, is_customer, cus_id = 0, t_id = 0) {
            if (status == 2) {
                is_type = is_customer;
                console.log('checking', is_type);
                $('#appointment_treament').modal('show');
                document.getElementById("cus_id").value = cus_id;
                document.getElementById("app_id").value = id;
                sessionStorage.setItem('treatment_id', t_id);
            } else {
                const token = sessionStorage.getItem('token');
                fetch(base_url + "appointment_status/" + id + "?status=" + status, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`,
                        },
                        method: "get",
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status == '200') {
                            $("#status_success").html("<div class='alert alert-success' role='alert'>" + data.message + "</div>");
                            setTimeout(() => {
                                $("#status_success").html("");
                                all(currentFromDate, currentToDate, currentBranchId, currentPermission);
                            }, 4000);
                        }
                    });
            }
        }

        $('#add_cus_payment').click(function() {
            console.log('customer', is_type);
            $app_id = document.getElementById("app_id").value;
            $remarks = document.getElementById("app_treament").value;
            const id = document.getElementById("cus_id").value;
            const token = sessionStorage.getItem('token');

            fetch(base_url + "appointment_details/" + $app_id + "?remark=" + $remarks, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        // var base_url = window.location.origin + '/' + window.location.pathname.split('/')[1] + '/';
                        // window.location.href = `${window.location.origin}/add_billing.php?id=${id}&type=${is_type === 1 ? "customer" : "lead"}`;
                        // var branch_id = $('#branch_name').val();
                        // from_date = document.getElementById('from_date').value;
                        // to_date = document.getElementById('to_date').value;
                        // permission = document.getElementById('permission_details').value;
                        // currentPage = 1; // Reset to first page on filter
                        // all(from_date, to_date, branch_id, permission = '');
                        location.reload();
                    }
                });
        })

        $('#paid_cash').click(function() {
            var paid_cash = document.getElementById("paid_cash");
            var payment = document.getElementById("payment");
            if (paid_cash.checked) {
                payment.style.display = "";
            } else {
                payment.style.display = "none";
            }
        })

        $('#add_app_payment').click(function() {
            var app_id = $('#app_app_id').val();
            var paid_cash = document.getElementById("paid_cash");
            if (paid_cash.checked) {
                var paid = "paid";
                var amount = $('#app_amount').val();
            } else {
                var paid = "unpaid";
                var amount = 0;
            }

            var data = "app_id=" + app_id + "&paid_mode=" + paid + "&amount=" + amount;
            const token = sessionStorage.getItem('token');

            fetch(base_url + "appointment_payment?" + data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "post",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        $("#status_success").html("<div class='alert alert-success' role='alert'>Payment Has been Successfully Paid!</div>");
                        setTimeout(() => {
                            $("#status_success").html("");
                        }, 4000);
                        all(currentFromDate, currentToDate, currentBranchId, currentPermission);
                    }
                });
        });

        var delete_id = '';

        function model(id) {
            $('#appointment_delete').modal('show');
            delete_id = id;
        }

        $('#delete').click(function() {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "delete_appointment/" + delete_id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "delete",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        $("#status_success").html("<div class='alert alert-success' role='alert'>Appointment Successfully Deleted!</div>");
                        setTimeout(() => {
                            $("#status_success").html("");
                            all(currentFromDate, currentToDate, currentBranchId, currentPermission);
                        }, 4000);
                    }
                });
        })

        function invoice_generate() {
            alert("id");
        }

        function add_appointment() {
            var lead_appointment_id = document.getElementById("lead_appointment_id");
            var app_staff_name = sessionStorage.getItem('username');
            var user_id = "";
            var date = "";
            var time = "";
            var tc_id = "";
            var treatment_id = "";
            var problem = "";
            var app_remark = "";

            if (lead_appointment_id.checked) {
                user_id = document.getElementById("app_user_name").value;
                date = document.getElementById("app_date").value;
                time = document.getElementById("timepicker").value;
                problem = document.getElementById("app_problem").value;
                app_remark = document.getElementById("app_remark").value;
                is_customer = 1;
            } else {
                user_id = document.getElementById("app_user_name").value;
                date = document.getElementById("app_date").value;
                time = document.getElementById("timepicker").value;
                treatment_id = document.getElementById("app_cus_treatment").value;
                app_remark = document.getElementById("app_remark").value;
                is_customer = 0;
            }

            if (is_customer == 0) {
                if (treatment_id == '') {
                    $("#error_app_cus_treatment").html("Please select Treatment name");
                } else {
                    $("#error_app_cus_treatment").html("");
                }
            }

            if (user_id && date && time) {
                var data = "company_name=" + sessionStorage.getItem('company') + "&is_customer=" + is_customer + "&user_id=" + user_id + "&app_problem=" + problem + "&app_treatment_id=" + treatment_id + "&app_staff_name=" + app_staff_name + "&app_remark=" + app_remark + "&app_date=" + date + "&app_time=" + time;
                const token = sessionStorage.getItem('token');

                fetch(base_url + "add_appointment?" + data, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`,
                        },
                        method: "post",
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status == '200') {
                            $("#status_success").html("<div class='alert alert-success' role='alert'>Appointment Successfully Added!</div>");
                            setTimeout(() => {
                                $("#status_success").html("");
                                window.location.href = "./appointment";
                                document.getElementById('add_app').style.pointerEvents = 'none';
                            }, 2000);
                        } else {
                            document.getElementById('add_app').style.pointerEvents = 'auto';
                            $("#status_success").html("<div class='alert alert-danger' role='alert'>Appointment already fixed !</div>");
                            setTimeout(() => {
                                $("#status_success").html("");
                            }, 2000);
                        }
                    });
            }
        }
    }
</script>

