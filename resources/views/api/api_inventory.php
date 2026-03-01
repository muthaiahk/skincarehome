<script>
    var a = sessionStorage.getItem('token');
    if (!a) {
        window.location.href = "./index";
    } else {
        var base_url = window.location.origin + '/api/';
        var permission = '';
        // UI BYPASS: $("#add_inventory").hide();
        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);
        console.log(branch_id);

        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 10;
        let totalRecords = 0;
        let totalPages = 0;
        let currentBranchId = "";
        let currentBrandId = "";
        let currentCatId = "";
        let currentProductId = "";
        let currentPermission = "";

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
                console.log("Permission loaded:", permission);

            } catch (error) {
                console.error(error);
                throw error;
            }
        }

        // Load permission first, then initialize everything
        permission_page("inventory").then(() => {
            try {
                console.log("Permission in then:", permission);
                
                // Set up event handlers
                $('#branch_name').change(function() {
                    var branch_id = $(this).val();
                    var brand_id = $('#brand_name').val();
                    var pc_id = $('#prod_cat_name').val();
                    var p_id = $('#product_name').val();
                    currentPage = 1;
                    all(branch_id, brand_id, pc_id, p_id, permission);
                });
                
                // Initial load
                all(branch_id[1], 0, 0, 0, permission);
                
            } catch (error) {
                console.error(error);
            }
        });

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
                            var htmlhead = "<label class='form-label'>Branch</label><select class='form-select' id='branch_name' onchange='select_branch(event);'><option value='0'>All Branch</option>";

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

                            var htmlfooter = "</select><div class='text-danger' id='error_branch_name'></div>";
                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#inventory_branch_list").html(htmlstringall);
                        }
                    }
                });
        }

        getbrandall();

        function getbrandall() {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "brand", {
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
                            var htmlhead = "<label class='form-label'>Brand </label><select class='form-select' id='brand_name' onchange='select_brand(event);'><option value='0'>Select Brand</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0') {
                                    htmlString += "<option value=" + value[i].brand_id + ">" + value[i].brand_name + "</option>"
                                }
                            }

                            var htmlfooter = "</select><div class='text-danger' id='error_brand_name'></div>";
                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#inventory_brand_list").html(htmlstringall);
                        }
                    }
                });
        }

        function select_branch(e) {
            var branch_id = e.target.value;
            var brand_id = $('#brand_name').val();
            var pc_id = $('#prod_cat_name').val();
            var p_id = $('#product_name').val();
            currentPage = 1;
            all(branch_id, brand_id, pc_id, p_id, permission);
        }

        function select_brand(e) {
            productcatall(e.target.value);
            var branch_id = $('#branch_name').val();
            var brand_id = e.target.value;
            var pc_id = $('#prod_cat_name').val();
            var p_id = $('#product_name').val();
            currentPage = 1;
            all(branch_id, brand_id, pc_id, p_id, permission);
        }

        function productcatall(id) {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "inventory_category/" + id, {
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
                            var htmlhead = "<label class='form-label'>Product Categories</label><select class='form-select' id='prod_cat_name' onchange='select_cat(event);'><option value='0'>Select Product Categories</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0') {
                                    htmlString += "<option value=" + value[i].prod_cat_id + ">" + value[i].prod_cat_name + "</option>"
                                }
                            }

                            var htmlfooter = "</select><div class='text-danger' id='error_prod_cat_name'></div>";
                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#inventory_prod_cat_list").html(htmlstringall);
                        }
                    }
                });
        }

        function getproductcatall() {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "product_category", {
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
                            var htmlhead = "<label class='form-label'>Product</label><select class='form-select' id='prod_cat_name'><option value='0'>Select Product</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0') {
                                    htmlString += "<option value=" + value[i].prod_cat_id + ">" + value[i].prod_cat_name + "</option>"
                                }
                            }

                            var htmlfooter = "</select><div class='text-danger' id='error_prod_cat_name'></div>";
                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#inventory_product_list").html(htmlstringall);
                        }
                    }
                });
        }

        function select_cat(e) {
            productall(e.target.value);
            var branch_id = $('#branch_name').val();
            var brand_id = $('#brand_name').val();
            var pc_id = e.target.value;
            var p_id = $('#product_name').val();
            currentPage = 1;
            all(branch_id, brand_id, pc_id, p_id, permission);
        }

        function productall(id) {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "inventory_product/" + id, {
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
                            var htmlhead = "<label class='form-label'>Product</label><select class='form-select' id='product_name' onchange='select_product(event);' ><option value='0'>Select Product</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0') {
                                    htmlString += "<option value=" + value[i].product_id + ">" + value[i].product_name + "</option>"
                                }
                            }

                            var htmlfooter = "</select><div class='text-danger' id='error_product_name'></div>";
                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#inventory_product_list").html(htmlstringall);
                        }
                    }
                });
        }

        function getproductnameall() {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "product", {
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
                            var htmlhead = "<label class='form-label'>Product</label><select class='form-select' id='product_name'><option value='0'>Select Product</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0') {
                                    htmlString += "<option value=" + value[i].product_id + ">" + value[i].product_name + "</option>"
                                }
                            }

                            var htmlfooter = "</select><div class='text-danger' id='error_product_name'></div>";
                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#inventory_product_list").html(htmlstringall);
                        }
                    }
                });
        }

        function select_product(e) {
            var branch_id = document.getElementById('branch_name').value;
            var brand_id = document.getElementById('brand_name').value;
            var cat_id = document.getElementById('prod_cat_name').value;
            var product_id = e.target.value;

            var data = "branch_id=" + branch_id + "&brand_id=" + brand_id + "&cat_id=" + cat_id + "&product_id=" + product_id;
            currentPage = 1;
            all(branch_id, brand_id, cat_id, product_id, permission);

            const token = sessionStorage.getItem('token');
            fetch(base_url + "inventory_product_count?" + data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "post",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        $("#stock").val(data.count);
                    }
                });
        }

        // Modified all() function with pagination
        function all(branch_id, brand_id = 0, pc_id = 0, prd_id = 0, permission = '') {
            const token = sessionStorage.getItem('token');

            // Store current parameters
            currentBranchId = branch_id;
            currentBrandId = brand_id;
            currentCatId = pc_id;
            currentProductId = prd_id;
            
            // Use the permission parameter if provided, otherwise use global permission
            const permToUse = permission || currentPermission;
            if (permToUse) {
                currentPermission = permToUse;
            }

            // Build URL with pagination parameters
            let params = new URLSearchParams();
            params.append('branch_id', branch_id);
            params.append('brand_id', brand_id);
            params.append('pc_id', pc_id);
            params.append('p_id', prd_id);
            params.append('page', currentPage);
            params.append('limit', itemsPerPage);

            console.log("Fetching with params:", {
                branch_id, brand_id, pc_id, prd_id, 
                page: currentPage, limit: itemsPerPage,
                permission: permToUse
            });

            fetch(base_url + "inventory", {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "post",
                    body: params
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log("API Response:", data);
                    
                    // Check permission for add button
                    if (permToUse) {
                        var cama = stringHasTheWhiteSpaceOrNot(permToUse);
                        if (cama) {
                            var values = permToUse.split(",");
                            if (values.length > 0) {
                                var add = values.includes('add');
                                if (add) {
                                    $("#add_inventory").show();
                                } else {
                                    // UI BYPASS: $("#add_inventory").hide();
                                }
                            }
                        }

                        function stringHasTheWhiteSpaceOrNot(value) {
                            return value.indexOf(',') >= 0;
                        }
                    }

                    if (data.status == '200') {
                        // Update pagination variables from API response
                        totalRecords = data.total || data.data?.length || 0;
                        totalPages = Math.ceil(totalRecords / itemsPerPage);

                        console.log("Pagination info:", {
                            totalRecords, totalPages, currentPage, itemsPerPage
                        });

                        if (data.data) {
                            const value = data.data;
                            var htmlString = "";
                            var htmlhead = "<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Date</th><th>Company Name</th><th>Branch</th><th>Brand</th><th>Product Categories</th><th>Product Name</th><th>Stock in Hand</th><th>Action</th></tr></thead><tbody>";

                            // Calculate starting index for serial numbers
                            const startIndex = (currentPage - 1) * itemsPerPage;

                            for (var i = 0; i < value.length; i++) {
                                const serialNo = startIndex + i + 1;

                                var action = "";
                                if (permToUse) {
                                    var cama = stringHasTheWhiteSpaceOrNot(permToUse);
                                    if (cama) {
                                        var values = permToUse.split(",");
                                        if (values.length > 0) {
                                            var edit = values.includes('edit');
                                            var view = values.includes('view');

                                            if (edit) {
                                                action += "<a href='edit_inventory?in_id=" + value[i].inventory_id + "'" + "><i class='fa fa-edit eyc'></i></a>";
                                            }
                                            if (view) {
                                                action += "<a href='view_inventory?in_id=" + value[i].inventory_id + "'" + "><i class='fa fa-eye eyc'></i></a>";
                                            }
                                        }
                                    }
                                }

                                htmlString += "<tr><td>" + serialNo + "</td><td>" + value[i].inventory_date + "</td><td>" + value[i].company_name + "</td><td>" + value[i].branch_name + "</td><td>" + value[i].brand_name + "</td><td>" + value[i].prod_cat_name + "</td><td>" + value[i].product_name + "</td><td>" + value[i].stock_in_hand + "</td><td>" + action + "</td></tr>";
                            }

                            var htmlfooter = "</tbody></table>";

                            // Add pagination container
                            htmlfooter += `<div id='inventory-pagination-container' class='mt-3'></div>`;

                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#inventory_list").html(htmlstringall);

                            // Initialize DataTable without default pagination
                            initializeDataTable();

                            // Create custom pagination
                            createPagination();
                        }
                    }
                })
                .catch(error => {
                    console.error("Fetch error:", error);
                });
        }

        // Function to initialize DataTable
        function initializeDataTable() {
            // Destroy existing DataTable instance if it exists
            if ($.fn.DataTable.isDataTable('#advance-1')) {
                $('#advance-1').DataTable().destroy();
            }

            // Initialize DataTable with pagination disabled
            $('#advance-1').DataTable({
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

        // Function to create custom pagination
        function createPagination() {
            if (totalPages <= 1) {
                $('#inventory-pagination-container').html('');
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

            $("#inventory-pagination-container").html(paginationHtml);
        }

        // Function to navigate to specific page
        function goToPage(page) {
            if (page < 1 || page > totalPages || page === currentPage) return;

            currentPage = page;
            all(currentBranchId, currentBrandId, currentCatId, currentProductId, currentPermission);
        }

        function status(id, status) {
            if (status == '1') {
                var inventory_status = 0;
            } else {
                var inventory_status = 1;
            }
            const token = sessionStorage.getItem('token');
            fetch(base_url + "inventory_status/" + id + '?status=' + inventory_status, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        $("#status_success").html("<div class='alert alert-success' role='alert'>Inventory Successfully Updated!</div>");
                        setTimeout(() => {
                            $("#status_success").html("");
                            // Refresh the table after status change
                            all(currentBranchId, currentBrandId, currentCatId, currentProductId, currentPermission);
                        }, 4000);
                    }
                });
        }

        var delete_id = '';

        function model(id) {
            $('#inventory_delete').modal('show');
            delete_id = id;
        }

        $('#delete').click(function() {
            const token = sessionStorage.getItem('token');
            fetch(base_url + "delete_inventory/" + delete_id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`,
                    },
                    method: "delete",
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == '200') {
                        $("#status_success").html("<div class='alert alert-success' role='alert'>Inventory Successfully Deleted!</div>");
                        setTimeout(() => {
                            $("#status_success").html("");
                            $('#inventory_delete').modal('hide');
                            all(currentBranchId, currentBrandId, currentCatId, currentProductId, currentPermission);
                        }, 4000);
                    }
                });
        })

        function add_inventory() {
            var inventory_date = document.getElementById("inventory_date").value;
            var company_name = sessionStorage.getItem('company');
            var branch_id = document.getElementById("branch_name").value;
            var brand_id = document.getElementById("brand_name").value;
            var prod_cat_id = document.getElementById("prod_cat_name").value;
            var product_id = document.getElementById("product_name").value;
            var stock_in_hand = document.getElementById("stock_in_hand").value;
            var stock_alert_count = document.getElementById("stock_alert_count").value;
            var description = document.getElementById("description").value;

            // Validation
            if (!inventory_date) {
                $("#error_inventory_date").html("Please select Date");
            } else {
                $("#error_inventory_date").html("");
            }

            if (company_name == '0') {
                $("#error_company_name").html("Please fill the  input feilds");
            } else {
                $("#error_company_name").html("");
            }

            if (branch_id == '0') {
                $("#error_branch_name").html("Please select Branch name");
            } else {
                $("#error_branch_name").html("");
            }

            if (brand_id == '0') {
                $("#error_brand_name").html("Please select Brand name");
            } else {
                $("#error_brand_name").html("");
            }

            if (prod_cat_id == '0') {
                $("#error_prod_cat_name").html("Please select Product Category");
            } else {
                $("#error_prod_cat_name").html("");
            }

            if (product_id == '0') {
                $("#error_product_name").html("Please select Product");
            } else {
                $("#error_product_name").html("");
            }

            if (!stock_in_hand) {
                $("#error_stock_in_hand").html("Please fill the  input feilds");
            } else {
                $("#error_stock_in_hand").html("");
            }

            if (!stock_alert_count) {
                $("#error_stock_alert_count").html("Please fill the  input feilds");
            } else {
                $("#error_stock_alert_count").html("");
            }

            if (inventory_date && company_name && branch_id && brand_id && prod_cat_id && product_id && stock_in_hand && stock_alert_count) {
                document.getElementById('add_int').style.pointerEvents = 'none';

                var data = "inventory_date=" + inventory_date + "&company_name=" + company_name + "&branch_id=" + branch_id + "&brand_id=" + brand_id + "&prod_cat_id=" + prod_cat_id + "&product_id=" + product_id + "&stock_in_hand=" + stock_in_hand + "&stock_alert_count=" + stock_alert_count + "&description=" + description;

                const token = sessionStorage.getItem('token');

                fetch(base_url + "add_inventory?" + data, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`,
                        },
                        method: "post",
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        document.getElementById('add_int').style.pointerEvents = 'auto';

                        if (data.status == '200') {
                            $("#status_success").html("<div class='alert alert-success' role='alert'>Inventory Successfully Added!</div>");
                            setTimeout(() => {
                                $("#status_success").html("");
                                window.location.href = "./inventory";
                            }, 4000);
                        } else {
                            $("#error_inventory_date").html(data.error_msg?.inventory_date?.[0] || "");
                            $("#error_stock_in_hand").html(data.error_msg?.stock_in_hand?.[0] || "");
                            $("#error_stock_alert_count").html(data.error_msg?.stock_alert_count?.[0] || "");
                            $("#error_description").html(data.error_msg?.description?.[0] || "");
                        }
                    })
                    .catch(error => {
                        console.error("Add inventory error:", error);
                        document.getElementById('add_int').style.pointerEvents = 'auto';
                    });
            }
        }
    }
</script>

