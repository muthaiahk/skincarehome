<script>
    var a = sessionStorage.getItem('token');
    if (!a) {
        window.location.href = "./index";
    } else {
        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);
        var base_url = window.location.origin + '/api/';
        var permission = '';

        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 10;
        let totalRecords = 0;
        let totalPages = 0;
        let currentBranchId = branch_id[1]; // Store current branch ID for pagination
        let currentPermission = ''; // Store current permission for pagination

        // UI BYPASS: $("#add_lead").hide();

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
                currentPermission = permission; // Store for pagination
                console.log(permission);

            } catch (error) {
                console.error(error);
                throw error;
            }
        }

        permission_page("lead").then(() => {
            try {
                all(currentBranchId, permission);
            } catch (error) {
                console.error(error);
            }
        });

        getstaffall(branch_id[1]);
        getloansourceall();
        getloanstatusall();
        gettreatmentall();
        getstatesall();
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

        function getstaffall(branch_id) {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "staff", {
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
                            var htmlhead = "<option value=''>Select staff name</option>";
                            console.log("branch_id:", branch_id);
                            console.log("Staff data:", value);
                            let branchIdArray;
                            if (typeof branch_id === 'string') {
                                branchIdArray = branch_id.split(',').map(id => parseInt(id.trim(), 10));
                            } else {
                                branchIdArray = Array.isArray(branch_id) ? branch_id.map(Number) : [parseInt(branch_id, 10)];
                            }
                            console.log("Parsed branchIdArray:", branchIdArray);

                            for (var i = 0; i < value.length; i++) {
                                try {
                                    const staffBranchIds = JSON.parse(value[i].branch_id).map(Number);
                                    console.log(`Staff ID: ${value[i].staff_id}, Staff Branch IDs:`, staffBranchIds);

                                    const hasBranch = staffBranchIds.some(id => branchIdArray.includes(id));

                                    if (value[i].status == '0' && hasBranch) {
                                        htmlString += `<option value="${value[i].staff_id}">${value[i].name}</option>`;
                                    }
                                } catch (error) {
                                    console.error(`Error parsing branch_id for staff ID ${value[i].staff_id}:`, error);
                                }
                            }
                            console.log(htmlString);
                            var htmlstringall = htmlhead + htmlString;
                            $("#staff_name").html(htmlstringall);
                        }
                    }
                });
        }

        $('#branch_name').change(function() {
            var branch_id = $(this).val();
            getstaffall(branch_id);
        });

        function getloansourceall() {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "lead_source", {
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
                            var htmlhead = "<option value='0'>Select Lead Source name</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0') {
                                    htmlString += "<option value=" + value[i].lead_source_id + ">" + value[i].lead_source_name + "</option>"
                                }
                            }

                            var htmlstringall = htmlhead + htmlString;
                            $("#source_name").html(htmlstringall);
                        }
                    }
                });
        }

        function getloanstatusall() {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "lead_status", {
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
                            var htmlhead = "<option value='0'>Select Lead Status</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0') {
                                    htmlString += "<option value=" + value[i].lead_status_id + ">" + value[i].lead_status_name + "</option>"
                                }
                            }

                            var htmlstringall = htmlhead + htmlString;
                            $("#lead_status_name").html(htmlstringall);
                        }
                    }
                });
        }

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

        function getstatesall() {
            fetch(base_url + "states", {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.data) {
                        const value = data.data;
                        var htmlString = "";
                        var htmlhead = "<option value='0'>Select State name</option>";

                        for (var i = 0; i < value.length; i++) {
                            htmlString += "<option value=" + value[i].state_id + ">" + value[i].name + "</option>"
                        }

                        var htmlstringall = htmlhead + htmlString;
                        $("#state_name").html(htmlstringall);
                    }
                });
        }

        function selectbranch() {
            var branch_id = $('#branch_name').val();
            currentPage = 1; // Reset to first page when changing branch
            currentBranchId = branch_id; // Update current branch ID
            all(branch_id, currentPermission);
        }

        // Enter key in search input
        $('#search_input').keypress(function(e) {
            if (e.which == 13) { // Enter key
                var branch_id = $("#branch_name").val();
                currentPage = 1;
                currentBranchId = branch_id; // Update current branch ID
                all(branch_id, currentPermission);
            }
        });

        // Auto-search with delay (optional)
        let searchTimeout;
        $('#search_input').keyup(function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                var branch_id = $("#branch_name").val();
                currentPage = 1;
                currentBranchId = branch_id; // Update current branch ID
                all(branch_id, currentPermission)
            }, 500); // 500ms delay
        });

        // SINGLE all() function with pagination - REMOVED DUPLICATE
        function all(branch_id, permission = '') {
            const token = sessionStorage.getItem('token');

            // Update current branch and permission
            currentBranchId = branch_id;
            if (permission) {
                currentPermission = permission;
            }

            // Show the loading spinner
            document.getElementById("loadingIndicator").style.display = "block";
            document.getElementById("lead_list").style.display = "none";
            var search_input = $('#search_input').val();

            // Construct URL with pagination parameters
            let url = base_url + "lead/" + branch_id +
                "?page=" + currentPage +
                "&limit=" + itemsPerPage +
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
                    if (permission) {
                        var cama = stringHasTheWhiteSpaceOrNot(permission);
                        if (cama) {
                            var values = permission.split(",");
                            if (values.length > 0) {
                                var add = values.includes('add');

                                if (add) {
                                    $("#add_lead").show();
                                } else {
                                    // UI BYPASS: $("#add_lead").hide();
                                }
                            }
                        }
                    }

                    if (data.status == '200') {
                        // Update pagination variables
                        totalRecords = data.total || data.data?.length || 0;
                        totalPages = Math.ceil(totalRecords / itemsPerPage);

                        if (data.data) {
                            const value = data.data;
                            var htmlString = "";
                            var htmlhead = "<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Name</th><th>Contact Details</th><th>Lead Source</th><th>Problem</th><th>Lead Status</th><th>Flw Up Count</th><th>Next Flw Up Date</th><th>Flw Up &  Convt Cust</th><th>Status</th><th class='max-w-150px'>Action</th></tr></thead><tbody>";

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
                                            var edit = values.includes('edit');
                                            var view = values.includes('view');
                                            var del = values.includes('delete');

                                            if (edit) {
                                                action += "<a href='edit_lead?l_id=" + value[i].lead_id + "'" + "><i class='fa fa-edit eyc'></i></a>";
                                            }
                                            if (view) {
                                                action += "<a href='view_lead?l_id=" + value[i].lead_id + "'" + "><i class='fa fa-eye eyc'></i></a>";
                                            }
                                            if (del) {
                                                action += "<a href='javascript:;' data-bs-toggle='modal' data-bs-target='' onclick='model(" + value[i].lead_id + ")'><i class='fa fa-trash eyc'></i></a>";
                                            }
                                        }
                                    }
                                }

                                if (value[i].next_flw_date == '01-01-1970') {
                                    var nxt_date = "";
                                } else {
                                    var nxt_date = value[i].next_flw_date;
                                }

                                // Calculate serial number
                                const serialNo = startIndex + i + 1;

                                htmlString += "<tr><td>" + serialNo + "</td><td>" + value[i].lead_first_name + "  " + value[i].lead_last_name + "<br> <span class='badge badge-info'>" + value[i].branch_name + "</span></td><td>" + value[i].lead_phone + "<br>" + value[i].lead_email + "</td><td>" + value[i].lead_source_name + "</td><td>" + value[i].lead_problem + "</td><td>" + value[i].lead_status_name + "</td><td>" + value[i].sitting_count + "</td><td>" + nxt_date + "</td><td>" + "<a href=''  data-bs-toggle='modal' data-bs-target='#lead_followup' class='badge badge-primary' onclick='lead_followup_model(" + value[i].lead_id + ',' + value[i].sitting_count + ")'>Followup</a>" + "<br><br>" + "<a href='' data-bs-toggle='modal' data-bs-target='#lead_to_customer' class='badge badge-secondary text-dark' onclick='convert_model(" + value[i].lead_id + ")'>Convert</a>" + "</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' " + status + " onclick='lead_status(" + value[i].lead_id + ',' + value[i].status + ")' ><span class='switch-state'></span></label>" + "</td><td>" + action + "<a href='javascript:;' data-bs-toggle='modal'  onclick='followup_history_model(" + value[i].lead_id + ")'><i class='fa fa-history eyc'></i></a>" + "</td></tr>";
                            }

                            var htmlfooter = "</tbody></table>";

                            // Add pagination container
                            htmlfooter += `<div id='lead-pagination-container' class='mt-3'></div>`;

                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#lead_list").html(htmlstringall);

                            // Initialize DataTable without default pagination
                            initializeLeadDataTable();

                            // Create custom pagination
                            createLeadPagination();
                        }
                    }
                })
                .finally(() => {
                    document.getElementById("loadingIndicator").style.display = "none";
                    document.getElementById("lead_list").style.display = "block";
                });
        }

        // Helper function
        function stringHasTheWhiteSpaceOrNot(value) {
            return value.indexOf(',') >= 0;
        }

        // Function to initialize DataTable for leads
        function initializeLeadDataTable() {
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

        // Function to create custom pagination for leads
        function createLeadPagination() {
            if (totalPages <= 1) {
                $('#lead-pagination-container').html('');
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
                <a class="page-link" href="javascript:void(0)" onclick="goToLeadPage(${currentPage - 1})" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>`;

            // Always show first page
            if (currentPage > 3) {
                paginationHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="goToLeadPage(1)">1</a></li>`;
                if (currentPage > 4) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }

            // Show pages around current page
            const startPage = Math.max(2, currentPage - 2);
            const endPage = Math.min(totalPages - 1, currentPage + 2);

            for (let i = startPage; i <= endPage; i++) {
                paginationHtml += `<li class="page-item ${currentPage === i ? 'active' : ''}">
                    <a class="page-link" href="javascript:void(0)" onclick="goToLeadPage(${i})">${i}</a>
                </li>`;
            }

            // Always show last page
            if (currentPage < totalPages - 2) {
                if (currentPage < totalPages - 3) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
                paginationHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="goToLeadPage(${totalPages})">${totalPages}</a></li>`;
            }

            // Next button
            paginationHtml += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0)" onclick="goToLeadPage(${currentPage + 1})" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>`;

            paginationHtml += `</ul></nav></div>`;

            $("#lead-pagination-container").html(paginationHtml);
        }

        // Function to navigate to specific page for leads
        function goToLeadPage(page) {
            if (page < 1 || page > totalPages || page === currentPage) return;

            currentPage = page;
            all(currentBranchId, currentPermission);
        }

        function lead_status(id, status) {
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

        var convert_id = '';

        function convert_model(id) {
            $('#lead_to_customer').modal('show');
            convert_id = id;
        }

        $('#convert').click(function() {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "convert/" + convert_id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        $('#lead_to_customer').modal('hide');
                        $("#status_success").html("<div class='alert alert-success' role='alert'>Lead Successfully Convert to Customer!</div>");
                        setTimeout(() => {
                            $("#status_success").html("");
                            window.location.href = "./lead"
                        }, 3000);
                    }
                });
        });

        var delete_id = '';

        function model(id) {
            $('#lead_delete').modal('show');
            delete_id = id;
        }

        $('#delete').click(function() {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "delete_lead/" + delete_id, {
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
                        $("#status_success").html("<div class='alert alert-success' role='alert'>Lead Successfully Deleted!</div>");
                        setTimeout(() => {
                            $("#status_success").html("");
                        }, 4000);
                    }
                });
        });

        var lead_id = '';

        function lead_followup_model(id, count) {
            document.getElementById("followup_date").value = "";
            document.getElementById("next_followup_date").value = "";
            document.getElementById("pn_status").value = "";
            document.getElementById("followup_count").value = (count + 1);
            document.getElementById("followup_remark").value = "";
            lead_id = id;
        }

        function add_followup() {
            var followup_date = document.getElementById("followup_date").value;
            var next_followup_date = document.getElementById("next_followup_date").value;
            var pn_status = document.getElementById("pn_status").value;
            var followup_count = document.getElementById("followup_count").value;
            var remark = document.getElementById("followup_remark").value;

            if (!followup_date) {
                $("#error_followup_date").html("Please fill the input fields");
            } else {
                $("#error_followup_date").html("");
            }

            if (!next_followup_date) {
                $("#error_next_followup_date").html("Please fill the input fields");
            } else {
                $("#error_next_followup_date").html("");
            }

            if (followup_date && next_followup_date) {
                var data = "lead_id=" + lead_id + "&followup_date=" + followup_date + "&next_followup_date=" + next_followup_date + "&app_status=" + pn_status + "&remark=" + remark + "&followup_count=" + followup_count;
                const token = sessionStorage.getItem('token');

                fetch(base_url + "add_followup?" + data, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`,
                        },
                        method: "post",
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status == '200') {
                            $('#lead_followup').modal('hide');
                            $("#status_success").html("<div class='alert alert-success' role='alert'> Successfully Added Followup!</div>");
                            setTimeout(() => {
                                $("#status_success").html("");
                                all(currentBranchId, currentPermission);
                            }, 4000);
                        } else {
                            $("#error_treatment_name").html(data.error_msg.lead_name[0]);
                        }
                    });
            }
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
                            var htmlhead = "<table class='display' id='followup_history_lists'><thead><tr><th>Sl no</th><th>FlwUp Date</th><th>Nxt FlwUp Date</th><th>FlwUp Count</th><th>Remark</th></tr></thead><tbody>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].app_status == '1') {
                                    var status = "<span class='text-success'>" + value[i].app_status + "</span>";
                                } else {
                                    var status = "<span class='text-danger'>" + value[i].app_status + "</span>";
                                }

                                if (value[i].remark == null) {
                                    var remarks = "";
                                } else {
                                    var remarks = value[i].remark;
                                }

                                // Fix: Use the actual followup date
                                var follo_date = value[i].followup_date || "";

                                htmlString += "<tr><td>" + [i + 1] + "</td><td>" + follo_date + "</td><td>" + value[i].next_followup_date + "</td><td>" + value[i].followup_count + "</td><td>" + remarks + "</td></tr>";
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
            var pn_status = document.getElementById("pn_status").value;

            if (!to_date) {
                $("#error_to_date").html("Please select the To date");
            } else {
                if (!from_date) {
                    $("#error_from_date").html("Please select the From date");
                } else {
                    $("#error_from_date").html("");
                }
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

        function add_lead() {
            var company_name = document.getElementById("company_name").value;
            var branch_id = document.getElementById("branch_name").value;
            var staff_id = document.getElementById("staff_name").value;
            var first_name = document.getElementById("first_name").value;
            var last_name = document.getElementById("last_name").value;
            var lead_dob = document.getElementById("lead_dob").value;
            var lead_gender = document.getElementById("lead_gender").value;
            var lead_age = document.getElementById("lead_age").value;
            var lead_phone = document.getElementById("lead_phone").value;
            var lead_email = document.getElementById("lead_email").value;
            var lead_source_id = document.getElementById("source_name").value;
            var enquiry_date = document.getElementById("enquiry_date").value;
            var lead_status_id = document.getElementById("lead_status_name").value;
            var lead_address = document.getElementById("lead_address").value;
            var treatment_id = 4;
            var lead_problem = document.getElementById("lead_problem").value;
            var lead_remark = document.getElementById("lead_remark").value;
            var state_id = document.getElementById("state_name").value;

            if (branch_id == '0') {
                $("#error_branch_name").html("Please select branch name");
            } else {
                $("#error_branch_name").html("");
            }

            if (staff_id == '0') {
                $("#error_staff_name").html("Please select staff name");
            } else {
                $("#error_staff_name").html("");
            }

            if (!first_name) {
                $("#error_first_name").html("Please select first name");
            } else {
                $("#error_first_name").html("");
            }

            if (!last_name) {
                $("#error_last_name").html("Please select last name");
            } else {
                $("#error_last_name").html("");
            }

            if (!lead_dob) {
                $("#error_lead_dob").html("Please fill the input fields");
            } else {
                $("#error_lead_dob").html("");
            }

            if (lead_gender == '0') {
                $("#error_lead_gender").html("Please select gender name");
            } else {
                $("#error_lead_gender").html("");
            }

            if (!lead_age) {
                $("#error_lead_age").html("Please select age");
            } else {
                $("#error_lead_age").html("");
            }

            if (lead_phone.length <= 9) {
                $("#error_lead_phone").html("Please fill the input fields");
            } else {
                $("#error_lead_phone").html("");
            }

            if (!lead_email) {
                $("#error_lead_email").html("Please fill the input fields");
            } else {
                $("#error_lead_email").html("");
            }

            if (lead_source_id == '0') {
                $("#error_source_name").html("Please select Lead Source name");
            } else {
                $("#error_source_name").html("");
            }

            if (!enquiry_date) {
                $("#error_enquiry_date").html("Please fill the input fields");
            } else {
                $("#error_enquiry_date").html("");
            }

            if (lead_status_id == '0') {
                $("#error_lead_status_name").html("Please select lead Status name");
            } else {
                $("#error_lead_status_name").html("");
            }

            if (!lead_address) {
                $("#error_lead_address").html("Please fill the input fields");
            } else {
                $("#error_lead_address").html("");
            }

            if (treatment_id == '0') {
                $("#error_treatment_name").html("Please select treatment name");
            } else {
                $("#error_treatment_name").html("");
            }

            if (state_id == '0') {
                $("#error_state_name").html("Please select state name");
            } else {
                $("#error_state_name").html("");
            }

            if (company_name && branch_id && staff_id && first_name && last_name && lead_dob && lead_gender && lead_age && lead_phone && lead_email && lead_source_id && enquiry_date && lead_status_id && lead_address && treatment_id && state_id) {
                document.getElementById('add_led').style.pointerEvents = 'none';

                var data = "company_name=" + company_name + "&branch_id=" + branch_id + "&staff_id=" + staff_id + "&lead_first_name=" + first_name + "&lead_last_name=" + last_name + "&lead_dob=" + lead_dob + "&lead_gender=" + lead_gender + "&lead_age=" + lead_age + "&lead_phone=" + lead_phone + "&lead_email=" + lead_email + "&lead_source_id=" + lead_source_id + "&enquiry_date=" + enquiry_date + "&lead_status_id=" + lead_status_id + "&lead_address=" + lead_address + "&lead_problem=" + lead_problem + "&lead_remark=" + lead_remark + "&treatment_id=" + treatment_id + "&state_id=" + state_id;

                const token = sessionStorage.getItem('token');

                fetch(base_url + "add_lead?" + data, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`,
                        },
                        method: "post",
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status == '200') {
                            $("#status_success").html("<div class='alert alert-success' role='alert'>Lead Successfully Added!</div>");
                            setTimeout(() => {
                                $("#status_success").html("");
                                window.location.href = "./lead";
                                document.getElementById('add_ld').style.pointerEvents = 'none';
                            }, 4000);
                        } else {
                            document.getElementById('add_led').style.pointerEvents = 'auto';

                            if (data.error_msg) {
                                if (data.error_msg.lead_email) {
                                    $("#error_lead_email").html(data.error_msg.lead_email[0]);
                                } else if (data.error_msg.lead_phone) {
                                    $("#error_lead_phone").html(data.error_msg.lead_phone[0]);
                                } else if (data.error_msg.lead_name) {
                                    $("#error_lead_name").html(data.error_msg.lead_name[0]);
                                } else {
                                    $("#error_lead_email").html("");
                                    $("#error_lead_phone").html("");
                                    $("#error_lead_name").html("");
                                }
                            } else {
                                $("#error_lead_email").html("");
                                $("#error_lead_phone").html("");
                                $("#error_lead_name").html("");
                            }
                        }
                    });
            }
        }
    }
</script>

