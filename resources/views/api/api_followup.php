<script>
    var a = sessionStorage.getItem('token');
    if (!a) {
        window.location.href = "./index";
    } else {
        var base_url = window.location.origin + '/api/';
        var from_date = document.getElementById('from_date').value;
        var to_date = document.getElementById('to_date').value;
        var permission = '';
        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);

        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 10;
        let totalRecords = 0;
        let totalPages = 0;
        let currentFromDate = from_date;
        let currentToDate = to_date;
        let currentBranchId = branch_id[1];
        let currentPermission = '';

        console.log(branch_ids);
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

        permission_page("followup").then(() => {
            try {
                console.log(permission);
                $('#data_filter').click(function() {
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var branch_id = $('#branch_name').val();

                    if (branch_id === null) {
                        alert("Please select at least one branch.");
                        return;
                    }

                    currentPage = 1; // Reset to first page on filter
                    currentFromDate = from_date;
                    currentToDate = to_date;
                    currentBranchId = branch_id;

                    all(from_date, to_date, branch_id, permission);
                });
            } catch (error) {
                console.error(error);
            }
        });



        all(from_date, to_date, branch_id[1], permission);

        // Enter key in search input
        $('#search_input').keypress(function(e) {
            if (e.which == 13) { // Enter key
                all(from_date, to_date, branch_id[1], permission);
            }
        });

        // Auto-search with delay (optional)
        let searchTimeout;
        $('#search_input').keyup(function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                all(from_date, to_date, branch_id[1], permission);
            }, 500); // 500ms delay
        });

        function all(from_date, to_date, branch_id, permission) {
            // Update current parameters
            currentFromDate = from_date;
            currentToDate = to_date;
            currentBranchId = branch_id;
            if (permission) {
                currentPermission = permission;
            }
            var search_input = $('#search_input').val();


            // Build URL with pagination parameters
            let data = "from=" + from_date + "&to=" + to_date +
                "&branch_id=" + branch_id +
                "&page=" + currentPage +
                "&limit=" + itemsPerPage +
                "&search_input=" + search_input;


            const token = sessionStorage.getItem('token');

            fetch(base_url + "followup?" + data, {
                    headers: {
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
                            var htmlhead = "<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Name</th><th>Mobile</th><th>FlwUp Date</th><th>NextFlwUp Date</th><th>Problem</th><th>Remarks</th><th>Status</th><th>Action</th></tr></thead><tbody>";

                            // Calculate starting index for serial numbers
                            const startIndex = (currentPage - 1) * itemsPerPage;

                            for (var i = 0; i < value.length; i++) {
                                var date = new Date(value[i].followup_date);
                                var status = '';
                                if (value[i].status == '0') {
                                    var status = 'checked';
                                }

                                var flw_status = "";

                                if (value[i].app_status == 2) {
                                    flw_status = "";
                                } else if (value[i].app_status == 1 && new Date(value[i].next_followup_date >= new Date())) {
                                    flw_status = `
                                        <span class="status-badge status-click-complete" 
                                            onclick="followup_status(${value[i].lead_id}, ${value[i].followup_id})" 
                                            title="Click to Complete">
                                            <i class="text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="18" width="14" viewBox="0 0 384 512" fill="#fff">
                                                    <path d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM305 273L177 401c-9.4 9.4-24.6 9.4-33.9 0L79 337c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L271 239c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"></path>
                                                </svg>
                                            </i> Complete
                                        </span>`;
                                }

                                var f_status = "";
                                if (new Date(value[i].next_followup_date) <= new Date() && value[i].app_status != 2) {
                                    f_status = `
                                        <span class="status-badge status-missed">
                                            <i class="fa fa-warning"></i> Missed
                                        </span>`;
                                } else if (value[i].app_status == 2) {
                                    f_status = `
                                        <span class="status-badge status-completed">
                                            <i class="fa fa-check"></i> Completed
                                        </span>`;
                                } else if (value[i].app_status == 1 && new Date(value[i].next_followup_date) >= new Date()) {
                                    f_status = `
                                        <span class="status-badge status-upcoming">
                                            <i class="fa fa-user-md"></i> Upcoming
                                        </span>`;
                                }

                                if (value[i].remark == null) {
                                    var remarks = "-";
                                } else {
                                    var remarks = value[i].remark;
                                }

                                var date = new Date(value[i].next_followup_date);
                                var day = date.getDate().toString().padStart(2, '0');
                                var month = (date.getMonth() + 1).toString().padStart(2, '0');
                                var year = date.getFullYear().toString();
                                var formattedDate = day + '-' + month + '-' + year;

                                var dates = new Date(value[i].next_followup_date);
                                var day = dates.getDate().toString().padStart(2, '0');
                                var month = (dates.getMonth() + 1).toString().padStart(2, '0');
                                var year = dates.getFullYear().toString();
                                var followDate = day + '-' + month + '-' + year;

                                var action = "";

                                action = "<a href='view_lead?l_id=" + value[i].lead_id + "'" + "><i class='fa fa-eye eyc'></i> View</a>";

                                if (permission) {
                                    var cama = stringHasTheWhiteSpaceOrNot(permission);
                                    if (cama) {
                                        var values = permission.split(",");
                                        if (values.length > 0) {
                                            var edit = values.includes('edit');
                                            var view = values.includes('view');
                                            var del = values.includes('delete');

                                            if (view) {
                                                action = "<a href='view_lead?l_id=" + value[i].lead_id + "'" + "><i class='fa fa-eye eyc'></i> View</a>";
                                            } else {
                                                action = "";

                                            }
                                        }
                                    }
                                }



                                // Calculate serial number
                                const serialNo = startIndex + i + 1;

                                htmlString += "<tr><td>" + serialNo + "</td><td>" + value[i].lead_first_name + " " + value[i].lead_last_name + "<br> <span class='badge badge-info'>" + value[i].branch_name + "</span></td><td>" + value[i].lead_phone + "<br>" + value[i].lead_email + "</td><td>" + followDate + "</td><td>" + formattedDate + "</td><td>" + value[i].lead_problem + "</td><td>" + remarks + "</td><td>" + f_status + "</td><td>" + action + flw_status + "</td></tr>";
                            }

                            var htmlfooter = "</tbody></table>";

                            // Add pagination container
                            htmlfooter += `<div id='followup-pagination-container' class='mt-3'></div>`;

                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#followup_list").html(htmlstringall);

                            // Initialize DataTable without default pagination
                            initializeFollowupDataTable();

                            // Create custom pagination
                            createFollowupPagination();
                        }
                    }
                });
        }

        // Helper function
        function stringHasTheWhiteSpaceOrNot(value) {
            return value.indexOf(',') >= 0;
        }

        // Function to initialize DataTable for followups
        function initializeFollowupDataTable() {
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

        // Function to create custom pagination for followups
        function createFollowupPagination() {
            if (totalPages <= 1) {
                $('#followup-pagination-container').html('');
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
                <a class="page-link" href="javascript:void(0)" onclick="goToFollowupPage(${currentPage - 1})" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>`;

            // Always show first page
            if (currentPage > 3) {
                paginationHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="goToFollowupPage(1)">1</a></li>`;
                if (currentPage > 4) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }

            // Show pages around current page
            const startPage = Math.max(2, currentPage - 2);
            const endPage = Math.min(totalPages - 1, currentPage + 2);

            for (let i = startPage; i <= endPage; i++) {
                paginationHtml += `<li class="page-item ${currentPage === i ? 'active' : ''}">
                    <a class="page-link" href="javascript:void(0)" onclick="goToFollowupPage(${i})">${i}</a>
                </li>`;
            }

            // Always show last page
            if (currentPage < totalPages - 2) {
                if (currentPage < totalPages - 3) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
                paginationHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="goToFollowupPage(${totalPages})">${totalPages}</a></li>`;
            }

            // Next button
            paginationHtml += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0)" onclick="goToFollowupPage(${currentPage + 1})" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>`;

            paginationHtml += `</ul></nav></div>`;

            $("#followup-pagination-container").html(paginationHtml);
        }

        // Function to navigate to specific page for followups
        function goToFollowupPage(page) {
            if (page < 1 || page > totalPages || page === currentPage) return;

            currentPage = page;
            all(currentFromDate, currentToDate, currentBranchId, currentPermission);
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
                        function sel_status(value) {
                            if (value == branch_id[1]) {
                                return 'selected';
                            } else {
                                return '';
                            }
                        }
                        if (data.data) {
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
                    }
                });
        }

        var delete_id = '';

        function followup_status(id, flw_id) {
            $('#lead_followup').modal('show');
            $('#follow_up_id').val(id);
        }

        $('#completed').click(function() {
            var id = $('#follow_up_id').val();
            const token = sessionStorage.getItem('token');

            fetch(base_url + "followup_completed/" + id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        $("#status_success").html("<div class='alert alert-success' role='alert'>Followup Successfully Completed!</div>");
                        setTimeout(() => {
                            $("#status_success").html("");
                            all(currentFromDate, currentToDate, currentBranchId, currentPermission);
                        }, 4000);
                    }
                });
        });

    }
</script>

