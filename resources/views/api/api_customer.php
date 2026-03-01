<script>
    var a = sessionStorage.getItem('token');
    if (!a) {
        window.location.href = "./index";
    } else {
        var base_url = window.location.origin + '/api/';
        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);
        var permission = '';
        
        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 10;
        let totalRecords = 0;
        let totalPages = 0;
        let currentBranchId = branch_id[1];
        let currentPermission = '';
        
        // permission_page('customer');
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

            } catch (error) {
                console.error(error);
                throw error;
            }
        }

        permission_page("customer").then(() => {
            try {
                console.log(permission);
                all(currentBranchId, permission);
            } catch (error) {
                console.error(error);
            }
        });

        gettcall();

        function gettcall() {
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
                            var htmlhead = "<label class='form-label'>Categories</label><select class='form-select' id='tc_name'><option value='0'>Select Categories</option>";

                            for (var i = 0; i < value.length; i++) {
                                htmlString += "<option value=" + value[i].tcategory_id + ">" + value[i].tc_name + "</option>"
                            }

                            var htmlfooter = "</select><div class='text-danger' id='error_tc_name'></div>";
                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#tc_list").html(htmlstringall);
                        }
                    }
                });
        }

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
                                    return 'selected';
                                } else {
                                    return '';
                                }
                            }
                            const value = data.data;
                            var htmlString = "";
                            var htmlhead = "<option value='0'>All Branch</option>";

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
                    }
                });
        }

        function selectbranch() {
            var branch_id = $(this).val();
            all(branch_id);
        }
        
        $('#branch_name').change(function() {
            var branch_id = $(this).val();
            currentPage = 1; // Reset to first page when changing branch
            currentBranchId = branch_id; // Update current branch ID
            all(branch_id, currentPermission);
        });

        // Enter key in search input
        $('#search_input').keypress(function(e) {
            if (e.which == 13) { // Enter key
                var branch_id = $("#branch_name").val();
                currentPage = 1;
                all(branch_id, permission);
            }
        });

        // Auto-search with delay (optional)
        let searchTimeout;
        $('#search_input').keyup(function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                var branch_id = $("#branch_name").val();
                currentPage = 1;
                all(branch_id, permission)
            }, 500); // 500ms delay
        });

        // Modified all() function with pagination
        function all(branch_id, permission) {
            const token = sessionStorage.getItem('token');
            
            // Update current branch and permission
            currentBranchId = branch_id;
            if (permission) {
                currentPermission = permission;
            }

            document.getElementById("loadingIndicator").style.display = "block";
            document.getElementById("customer_list").style.display = "none";
            var search_input = $('#search_input').val();
            
            // Construct URL with pagination parameters
            let url = base_url + "customer_list/" + branch_id + 
                      "?page=" + currentPage + 
                      "&limit=" + itemsPerPage+
                      "&search_input=" + search_input;

            fetch(url, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        // Update pagination variables
                        totalRecords = data.total || data.data?.length || 0;
                        totalPages = Math.ceil(totalRecords / itemsPerPage);
                        
                        if (data.data) {
                            const value = data.data;
                            var htmlString = "";
                            var htmlhead = "<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Name</th><th>Address</th><th>Mobile</th><th>Email</th><th>On going<br>Treament</th><th>Action</th></tr></thead><tbody>";

                            // Calculate starting index for serial numbers
                            const startIndex = (currentPage - 1) * itemsPerPage;
                            
                            for (var i = 0; i < value.length; i++) {
                                var status = '';
                                if (value[i].status == '0') {
                                    var status = 'checked';
                                }

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

                                            if (add) {
                                                $("#add_customer").show();
                                            } else {
                                                // UI BYPASS: $("#add_customer").hide();
                                            }

                                            if (edit) {
                                                action += "<a href='edit_customer?c_id=" + value[i].customer_id + "'" + "><i class='fa fa-edit eyc'></i></a>";
                                            }
                                            if (view) {
                                                action += "<a href='view_customer?c_id=" + value[i].customer_id + "'" + "><i class='fa fa-eye eyc'></i></a>";
                                            }
                                        }
                                    }
                                }

                                // Calculate serial number
                                const serialNo = startIndex + i + 1;
                                
                                htmlString += "<tr><td>" + serialNo + "</td><td>" + value[i].customer_first_name + " " + value[i].customer_last_name +"<br> <span class='badge badge-info'>" + value[i].branch_name + "</span> </td><td>" + value[i].customer_address + "</td><td>" + value[i].customer_phone + "</td><td>" + value[i].customer_email + "</td><td> <span class='badge badge-primary fs-5'>" + value[i].count + "</span></td><td>" + action + "</td></tr>";
                            }

                            var htmlfooter = "</tbody></table>";
                            
                            // Add pagination container
                            htmlfooter += `<div id='customer-pagination-container' class='mt-3'></div>`;
                            
                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#customer_list").html(htmlstringall);
                            
                            // Initialize DataTable without default pagination
                            initializeCustomerDataTable();
                            
                            // Create custom pagination
                            createCustomerPagination();
                        }
                    }
                }).finally(() => {
                    document.getElementById("loadingIndicator").style.display = "none";
                    document.getElementById("customer_list").style.display = "block";
                });
        }

        // Helper function
        function stringHasTheWhiteSpaceOrNot(value) {
            return value.indexOf(',') >= 0;
        }

        // Function to initialize DataTable for customers
        function initializeCustomerDataTable() {
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

        // Function to create custom pagination for customers
        function createCustomerPagination() {
            if (totalPages <= 1) {
                $('#customer-pagination-container').html('');
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
                <a class="page-link" href="javascript:void(0)" onclick="goToCustomerPage(${currentPage - 1})" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>`;

            // Always show first page
            if (currentPage > 3) {
                paginationHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="goToCustomerPage(1)">1</a></li>`;
                if (currentPage > 4) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }

            // Show pages around current page
            const startPage = Math.max(2, currentPage - 2);
            const endPage = Math.min(totalPages - 1, currentPage + 2);

            for (let i = startPage; i <= endPage; i++) {
                paginationHtml += `<li class="page-item ${currentPage === i ? 'active' : ''}">
                    <a class="page-link" href="javascript:void(0)" onclick="goToCustomerPage(${i})">${i}</a>
                </li>`;
            }

            // Always show last page
            if (currentPage < totalPages - 2) {
                if (currentPage < totalPages - 3) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
                paginationHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="goToCustomerPage(${totalPages})">${totalPages}</a></li>`;
            }

            // Next button
            paginationHtml += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0)" onclick="goToCustomerPage(${currentPage + 1})" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>`;

            paginationHtml += `</ul></nav></div>`;

            $("#customer-pagination-container").html(paginationHtml);
        }

        // Function to navigate to specific page for customers
        function goToCustomerPage(page) {
            if (page < 1 || page > totalPages || page === currentPage) return;

            currentPage = page;
            all(currentBranchId, currentPermission);
        }

        function status(id, status) {
            if (status == '1') {
                var lead_status = 0;
            } else {
                var lead_status = 1;
            }
            const token = sessionStorage.getItem('token');
            fetch(base_url + "lead_status/" + id + '?status=' + lead_status, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        $("#status_success").html("<div class='alert alert-success' role='alert'>Lead Successfully Updated!</div>");
                        setTimeout(() => {
                            $("#status_success").html("");
                            all(currentBranchId, currentPermission);
                        }, 4000);
                    }
                });
        }

        var delete_id = '';

        function model(id) {
            $('#customer_delete').modal('show');
            delete_id = id;
        }

        $('#delete').click(function() {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "delete_customer/" + delete_id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "delete",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        all(currentBranchId, currentPermission);
                        $("#status_success").html("<div class='alert alert-success' role='alert'>Customer Successfully Deleted!</div>");
                        setTimeout(() => {
                            $("#status_success").html("");
                        }, 4000);
                    }
                });
        });

        // Keep your other functions as they were...
        // Note: The following functions need to be updated to use currentBranchId and currentPermission
        // if they call the all() function
        
        function add_lead() {
            // ... (your existing add_lead function)
            // Note: After successful add, you might want to call:
            // all(currentBranchId, currentPermission) instead of all()
        }

        var lead_id = '';

        function lead_followup_model(id) {
            lead_id = id;
        }

        function add_followup() {
            // ... (your existing add_followup function)
            // Note: After successful add, you might want to call:
            // all(currentBranchId, currentPermission) instead of all()
        }

        var lead_flw_id = '';

        function followup_history_model(id) {
            lead_flw_id = id;
            $('#lead_followup_history').modal('show');
            const token = sessionStorage.getItem('token');

            fetch(base_url + "edit_followup/" + id, {
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
                            var htmlhead = "<table class='display' id='followup_history_lists'><thead><tr><th>Sl no</th><th>FlwUp Date</th><th>Nxt FlwUp Date</th><th>FlwUp Count</th><th>Status</th><th>Remark</th></tr></thead><tbody>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].app_status == '1') {
                                    var status = "<span class='text-success'>" + value[i].app_status + "</span>";
                                } else {
                                    var status = "<span class='text-danger'>" + value[i].app_status + "</span>";
                                }

                                htmlString += "<tr><td>" + [i + 1] + "</td><td>" + value[i].followup_date + "</td><td>" + value[i].next_followup_date + "</td><td>" + value[i].followup_count + "</td><td>" + status + "</td><td>" + value[i].remark + "</td></tr>";
                            }

                            var htmlfooter = "</tbody></table>";
                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#followup_history_list").html(htmlstringall);
                            datatable_flw();
                        }
                    }
                });
        }

        function filter_followup() {
            var from_date = document.getElementById("from_date").value;
            var to_date = document.getElementById("to_date").value;
            var pn_status = document.getElementById("flw_pn_status").value;

            if (!from_date) {
                $("#error_from_date").html("Please select the From date");
            } else {
                $("#error_from_date").html("");
            }

            if (!to_date) {
                $("#error_to_date").html("Please select the To date");
            } else {
                $("#error_to_date").html("");
            }

            if (from_date && to_date) {
                var data = "from_date=" + from_date + "&to_date=" + to_date + "&pn_status=" + pn_status;
                const token = sessionStorage.getItem('token');

                fetch(base_url + "edit_followup/" + lead_flw_id + "?" + data, {
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
                                var htmlhead = "<table class='display' id='followup_history_lists'><thead><tr><th>Sl no</th><th>FlwUp Date</th><th>Nxt FlwUp Date</th><th>FlwUp Count</th><th>Status</th><th>Remark</th></tr></thead><tbody>";

                                for (var i = 0; i < value.length; i++) {
                                    if (value[i].app_status == 'positive') {
                                        var status = "<span class='text-success'>" + value[i].app_status + "</span>";
                                    } else {
                                        var status = "<span class='text-danger'>" + value[i].app_status + "</span>";
                                    }

                                    htmlString += "<tr><td>" + [i + 1] + "</td><td>" + value[i].followup_date + "</td><td>" + value[i].next_followup_date + "</td><td>" + value[i].followup_count + "</td><td>" + status + "</td><td>" + value[i].remark + "</td></tr>";
                                }

                                var htmlfooter = "</tbody></table>";
                                var htmlstringall = htmlhead + htmlString + htmlfooter;
                                $("#followup_history_list").html(htmlstringall);
                                datatable_flw();
                            }
                        }
                    });
            }
        }

        // Keep datatable_flw() function as it is for modal tables
        function datatable_flw() {
            // Destroy existing instance first
            if ($.fn.DataTable.isDataTable('#followup_history_lists')) {
                $('#followup_history_lists').DataTable().destroy();
            }
            
            $("#followup_history_lists").DataTable({
                "responsive": true,
                "aaSorting": [],
                "language": {
                    "lengthMenu": "Show _MENU_",
                },
                "dom": "<'row'" +
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

