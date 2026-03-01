<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    var a = sessionStorage.getItem('token');
    
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
        var base_urlimage = window.location.origin+'/renew_api/';
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

     
        // Function to get URL parameter by name
        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }
        
        // Pre-select the radio button on page load
        window.onload = function () {
            const type = getUrlParameter('type'); // Get 'type' from the URL
        
            if (type === 'customer') {
                document.getElementById('customer').checked = true; // Select Customer radio button
            } else if (type === 'lead') {
                document.getElementById('lead').checked = true; // Select Lead radio button
            }
        
            toggleCustomerLead(); // Ensure the toggle function reflects the initial state
        };


        function gettreatmentall(id){

            const token = sessionStorage.getItem('token');

            fetch(base_url+"customer_treatment_all/"+id+"?c_id="+c_id, {
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

                            var htmlhead ="<label class='form-label'>Treatment Name</label><select class='form-select' id='treatment_name' onchange='cutomer_invoice();'><option value=''>Select Treatment Name</option>";

                            for(var i = 0; i < value.length  ; i++){
                                if(value[i].status == '0'){
                                    htmlString += "<option value="+value[i].treatment_id+">"+ value[i].treatment_name + "</option>"
                                }
                            }

                            var htmlfooter ="</select><div class='text-danger' id='error_treatment_name'></div>";
                            
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#payment_treatment_list").html(htmlstringall); 
                                        
                        }
                    

                    }
                });
        }
        // this customer treatment list to add on  billing
        gettcategoryall(0); // Call to fetch treatment categories

   

        let selectedTreatments = []; // Store selected treatments for dynamic updates
        let selectedTreatmentsall = []; // Store selected treatments for dynamic updates

   

        function gettcategoryall(id) {
            const token = sessionStorage.getItem('token');

            fetch(base_url + "customer_treatment_cat/" + id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`,
                },
                method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.status == '200' && data.data) {
                    let optionsHtml = "";

                    data.data.forEach((treatment) => {
                        if (treatment.status == '0') {
                            const defaultImage = "assets/logo/renew_logo.png";
                            const imagePath = treatment.treatment_image ? base_urlimage + "public/treatment_image/" + treatment.treatment_image : defaultImage;
                            const truncatedName = treatment.treatment_name.length > 10 ? treatment.treatment_name.substring(0, 10) + "..." : treatment.treatment_name;

                            optionsHtml += `
                                <option value="${treatment.treatment_id}" 
                                        data-amount="${treatment.amount}" data-image="${imagePath}"
                                        data-name="${treatment.treatment_name}">
                                    ${truncatedName} - ₹${treatment.amount}
                                </option>`;
                        }
                    });

                    // Set the options HTML for the select element
                    const treatmentSelect = document.getElementById("customer_treatment_details");
                    treatmentSelect.innerHTML = optionsHtml;

                    // Initialize Select2 only if it hasn't been initialized before
                    if (!$('#customer_treatment_details').data('select2')) {
                        $('#customer_treatment_details').select2({
                            placeholder: "Select treatments",
                            templateResult: formatTreatment,
                            templateSelection: formatTreatmentSelection,
                            allowClear: true,
                            width: '100%'
                        });
                    }

                    // Event listener for selecting a treatment
                    $('#customer_treatment_details').off('select2:select').on('select2:select', function (e) {
                        const treatmentId = e.params.data.id;
                        const treatmentName = $(e.params.data.element).data('name') || $(e.params.data.element).attr('title');
                        const treatmentAmount = $(e.params.data.element).data('amount');

                        console.log('Selected:', treatmentId);

                        // Call updateSelectedTreatment only when the treatment is selected
                        updateSelectedTreatment(treatmentId, treatmentName, treatmentAmount);
                    });

                    // Event listener for unselecting a treatment
                    $('#customer_treatment_details').off('select2:unselect').on('select2:unselect', function (e) {
                        const treatmentId = e.params.data.id;
                        const treatmentName = $(e.params.data.element).data('name') || $(e.params.data.element).attr('title');
                        const treatmentAmount = $(e.params.data.element).data('amount');

                        console.log('Unselected:', treatmentId);

                        // Call updateSelectedTreatment only when the treatment is deselected
                        updateSelectedTreatment(treatmentId, treatmentName, treatmentAmount);
                    });
                }
            });
        }

        // Function to format each treatment item in the dropdown
        function formatTreatment(treatment) {
            if (!treatment.id) return treatment.text;

            // Use data attributes to fetch image and amount details
            const amount = $(treatment.element).data('amount');
            const image = $(treatment.element).data('image');
            
            return $(`
                <div class="d-flex align-items-center">
                    <img src="${image}" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                    <div>
                        <strong>${treatment.text}</strong><br>
                        <span style="color: #3db082;">₹${amount}</span>
                    </div>
                </div>
            `);
        }

        // Function to format selected items
        function formatTreatmentSelection(treatment) {
            return treatment.text;
        }

      

        getcustomerall();

        function getcustomerall(){

            const token = sessionStorage.getItem('token');

            fetch(base_url+"customer_treatment_list", {
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

                               if(id > 0){
                                    var dis_st = "disabled";
                               }else{
                                    var dis_st = "";
                               }

                                var htmlhead ="<select class='form-select' id='select_customer' onchange='cutomer_change();' "+dis_st+"><option value='' >Select Customer Name</option>";

                                for(var i = 0; i < value.length  ; i++){


                                    function user_status(value){

                                        if(value == id){ return 'selected';}else{ return '';}
                                    }

                                    if(value[i].status == '0'){
                                        htmlString += "<option value='"+value[i].customer_id+"'"+user_status(value[i].customer_id)+">"+ value[i].customer_first_name + " "+ value[i].customer_last_name + ' - '+value[i].customer_phone +  "</option>"
                                    }

                                }

                                var htmlfooter ="</select><div class='text-danger' id='error_customer_name'></div>";
                                
                                var htmlstringall = htmlhead+htmlString+htmlfooter;
                                $("#payment_customer_list").html(htmlstringall);

                                // Initialize Select2
                                $('#select_customer').select2({
                                    placeholder: "Select Customer Name",
                                    allowClear: true
                                });

                                
                                            
                            }
                        

                        }
                    });
        }
       

        getleadall();

        function getleadall(){

            const token = sessionStorage.getItem('token');

            fetch(base_url+"lead_list", {
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

                               if(id > 0){
                                    var dis_st = "disabled";
                               }else{
                                    var dis_st = "";
                               }

                                var htmlhead ="<select class='form-select' id='select_lead' "+dis_st+"><option value='' >Select Lead Name</option>";

                                for(var i = 0; i < value.length  ; i++){


                                    function user_status(value){

                                        if(value == id){ return 'selected';}else{ return '';}
                                    }

                                    if(value[i].status == '0'){
                                        htmlString += "<option value='"+value[i].lead_id+"'"+user_status(value[i].lead_id)+">"+ value[i].lead_first_name + " "+ value[i].lead_last_name + ' - '+value[i].lead_phone +  "</option>"
                                    }

                                }

                                var htmlfooter ="</select><div class='text-danger' id='error_customer_name'></div>";
                                
                                var htmlstringall = htmlhead+htmlString+htmlfooter;
                                $("#billing_lead_list").html(htmlstringall);
                                // Initialize Select2
                                $('#select_lead').select2({
                                    placeholder: "Select Lead Name",
                                    allowClear: true
                                });
                                            
                            }
                        

                        }
                    });
        }

       
       // Function to fetch and display product categories without a label
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
                if (data.status == '200' && data.data) {
                    const categories = data.data;

                    // Create the select element without a label
                    let htmlString = "<select class='form-select' id='select_product_category'><option value=''>Select Product Category</option>";

                    // Append category options
                    categories.forEach((category) => {
                        if (category.status == '0') {
                            htmlString += `<option value='${category.prod_cat_id}'>${category.prod_cat_name}</option>`;
                        }
                    });

                    htmlString += "</select><div class='text-danger' id='error_product_name'></div>";
                    $("#product_category_list").html(htmlString);

                    // Event listener for category selection
                    $('#select_product_category').on('change', function() {
                        const selectedCategoryId = $(this).val();
                        if (selectedCategoryId) {
                            getproductall(selectedCategoryId);
                        }
                    });
                }
            });
        }


        
        function getproductall(categoryId) {
            const token = sessionStorage.getItem('token');

            fetch(base_url + "product_list?category_id=" + categoryId, {  
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`,
                },
                method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.status == '200' && data.data) {
            const products = data.data;  // Assuming products are in the `data.data` field
            let htmlString = "<label class='form-label mt-3'>Products</label><div class='row' style='max-height: 200px; overflow-y: auto;'>";

            products.forEach((product, index) => {
                if (product.status == '0') {
                    // Create a new row for every 3 products
                    if (index % 3 === 0) {
                        htmlString += "<div class='row' style='width: 100%'>";
                    }

                    // Set the base image path
                    const defaultImage = "assets/logo/renew_logo.png";
                    const imag = product.product_image ? base_urlimage + "public/product_image/" + product.product_image : defaultImage;

                    // Image path for each product
                    const imagePath = imag;

                    // Calculate the truncated product name and add title for tooltip
                    const truncatedName = product.product_name.length > 10 ? product.product_name.substring(0, 10) + "..." : product.product_name;
                    const productNameTitle = product.product_name;  // Full name for tooltip

                    htmlString += `
                        <div class='col-lg-4 col-md-4 col-sm-6 mb-3'>
                            <div class='product-item mt-3 d-flex flex-column align-items-center' 
                                onclick="updateSelectedProduct(${product.product_id}, '${product.product_name}', ${product.amount})"
                                style='cursor: pointer; background-color: #f9f9f9; border-radius: 8px; padding: 10px; transition: transform 0.3s, box-shadow 0.3s;'>

                                <!-- Hidden checkbox to retain functionality if needed -->
                                <input type='checkbox' id='product_${product.product_id}' value='${product.product_id}' style="display: none;">
                                
                                <!-- Image at the top -->
                                <img src='${imagePath}' alt='product-image' class='image-preview' 
                                    style='width: 60px; height: 60px; object-fit: cover; margin-bottom: 8px; border-radius: 50%;' />
                                
                                <!-- Name and amount below the image -->
                                <div class='text-center >
                                    <strong class='product-name' 
                                            style='font-size: 14px; color: #333; display: block; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;' 
                                            title='${productNameTitle}'>${truncatedName}</strong><br>
                                    <label class='text-end mb-0' style='color: #3db082;'>Amount: <span class='product-amount'>${product.amount}</span></label>
                                </div>
                            </div>
                        </div>`;

                    // Close the row after every 3 products
                    if (index % 3 === 2) {
                        htmlString += "</div>";
                    }
                }
            });

            // If the number of products is not a multiple of 3, close the last row
            if (products.length % 3 !== 0) {
                htmlString += "</div>";
            }

            htmlString += "<div class='text-danger' id='error_product_list'></div></div>";
            document.getElementById("product_list").innerHTML = htmlString;
        }

            });
        }


        // Initial call to load product categories
        getproductcatall();
        gettreatmentcatallnew();
        // Function to fetch and display product categories without a label
        function gettreatmentcatallnew() {
            const token = sessionStorage.getItem('token');

            fetch(base_url + "treatment_category", {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`,
                },
                method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.status == '200' && data.data) {
                    const categories = data.data;

                    // Create the select element without a label
                    let htmlString = "<select class='form-select' id='select_treatment_category_all'><option value=''>Select Treatment Category</option>";

                    // Append category options
                    categories.forEach((category) => {
                        if (category.status == '0') {
                            htmlString += `<option value='${category.tcategory_id}'>${category.tc_name}</option>`;
                        }
                    });

                    htmlString += "</select><div class='text-danger' id='error_product_name'></div>";
                    $("#treatment_category_list_all").html(htmlString);

                    // Event listener for category selection
                    $('#select_treatment_category_all').on('change', function() {
                        const selectedCategoryId = $(this).val();
                        if (selectedCategoryId) {
                            gettreatmentallNew(selectedCategoryId);
                        }
                    });
                }
            });
        }

        function gettreatmentallNew(id){
            const token = sessionStorage.getItem('token');

            fetch(base_url+"treatment_all/" + id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                
                if (data.status == '200' && data.data) {
                    let htmlString = "<div class='row' style='max-height: 200px; overflow-y: auto;'>";

                    data.data.forEach((treatment, index) => {
                        if (treatment.status == '0') {
                            // Open a new row every 3 items
                            if (index % 3 === 0) {
                                htmlString += "<div class='row' style='width: 100%'>";
                            }

                            // Treatment image (use default if not provided)
                            // const imagePath = base_urlimage + "public/treatment_image/" + (treatment.treatment_image || "default.png");
                            const defaultImage = "assets/logo/renew_logo.png";
                            const imag = treatment.treatment_image ? base_urlimage + "public/product_image/" + treatment.treatment_image : defaultImage;
                            
                            // Image path for each product
                            const imagePath = imag;
                            // Calculate the truncated product name and add title for tooltip
                            const truncatedName = treatment.treatment_name.length > 10 ? treatment.treatment_name.substring(0, 10) + "..." : treatment.treatment_name;
                            const treatmentNameTitle = treatment.treatment_name;  // Full name for tooltip
                            htmlString += `
                                <div class='col-lg-4 col-md-4 col-sm-6 mb-3'>
                                    <div class='product-item mt-3 d-flex flex-column align-items-center' 
                                        onclick="updateSelectedTreatmentall(${treatment.treatment_id}, '${treatment.treatment_name}', ${treatment.amount})"
                                        style='cursor: pointer; background-color: #f9f9f9; border-radius: 8px; padding: 10px; transition: transform 0.3s, box-shadow 0.3s;'>
                                        
                                        <!-- Hidden checkbox to retain functionality if needed -->
                                        <input type='checkbox' id='treatment_${treatment.treatment_id}' value='${treatment.treatment_id}' 
                                            style="display: none;">
                                        
                                        <!-- Treatment image at the top -->
                                        <img src='${imagePath}' alt='treatment-image' class='image-preview' 
                                            style='width: 60px; height: 60px; object-fit: cover; margin-bottom: 8px; border-radius: 50%;' />
                                        
                                        <!-- Name and amount below the image -->
                                        <div class='text-center'>
                                            <strong class='product-name' 
                                                    style='font-size: 14px; color: #333; display: block; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;' 
                                                    title='${treatmentNameTitle}'>${truncatedName}</strong><br>
                                            <label class='text-end mb-0' style='color: #3db082;'>Amount: <span class='product-amount'>${treatment.amount}</span></label>
                                        </div>
                                    </div>
                                </div>`;

                            // Close the row after every 3 treatments
                            if (index % 3 === 2) {
                                htmlString += "</div>";
                            }
                        }
                    });

                    // If the number of treatments is not a multiple of 3, close the last row
                    if (data.data.length % 3 !== 0) {
                        htmlString += "</div>";
                    }

                    htmlString += "<div class='text-danger' id='error_treatment_list'></div></div>";
                    document.getElementById("treatment_details_all").innerHTML = htmlString;
                }
            });
        }
    
       

        let selectedStateId = 23;

        function customerChange() {
            const selectedCustomerId = document.getElementById('select_customer').value;
          
            // Assuming `data.data[i].state_id` holds the `state_id`
            const selectedCustomer = customerData.find(customer => customer.customer_id == selectedCustomerId);

            if (selectedCustomer) {
                selectedStateId = selectedCustomer.state_id; // Set the state_id for GST calculation
            }
            calculateTotal(); // Recalculate total based on new selection
        }

        function leadChange() {
            const selectedLeadId = document.getElementById('select_lead').value;

            // Assuming `data.data[i].state_id` holds the `state_id`
            const selectedLead = leadData.find(lead => lead.lead_id == selectedLeadId);

            if (selectedLead) {
                selectedStateId = selectedLead.state_id; // Set the state_id for GST calculation
            }
            calculateTotal(); // Recalculate total based on new selection
        }

    
        // Sample Data  here i need selected treatmnet or product should fetch here how ?
        let selectedProducts = []; // Store selected products for dynamic updates

        function updateSelectedProduct(productId, productName, productAmount) {
            // Check if the product is already selected
            const index = selectedProducts.findIndex(p => p.id === productId);

            if (index === -1) {
                // If not selected, add it to the selected products array
                selectedProducts.push({ id: productId, name: productName, price: productAmount, qty: 1 });
            } else {
                // If already selected, remove it from the list
                selectedProducts.splice(index, 1);
            }

            // Update the product table
            updateTable();
        }
        function updateSelectedTreatment(treatmentId, treatmentName, treatmentAmount) {
            // console.log('treatmenyt dup',treatmentId);
            const treatmentIdInt = parseInt(treatmentId, 10);  // Convert to integer
            // console.log('treatmenyt dup',treatmentIdInt);
            const index = selectedTreatments.findIndex(t => t.id === treatmentIdInt);
            // console.log('treatmenyt',index);
            if (index === -1) {
                selectedTreatments.push({
                    id: treatmentIdInt,
                    name: treatmentName,
                    price: treatmentAmount,
                    qty: 1  // Set initial quantity
                });
            }else {
                selectedTreatments.splice(index, 1); // Deselect/remove treatment
            }
            // console.log('treatmenyt',selectedTreatments);
            updateTable();  // Refresh the table after each selection/deselection
        }

        function updateSelectedTreatmentall(treatmentId, treatmentName, treatmentAmount) {
            // Check if the treatment is already selected
            const index = selectedTreatmentsall.findIndex(t => t.id === treatmentId);
            // console.log('treatmenyt',selectedTreatmentsall);

            if (index === -1) {
                // If not selected, add it to the selected treatments array with quantity 1
                selectedTreatmentsall.push({ 
                    id: treatmentId, 
                    name: treatmentName, 
                    price: treatmentAmount, 
                    qty: 1 // Initialize quantity to 1
                });
            } else {
                // If already selected, remove it from the list
                selectedTreatmentsall.splice(index, 1);
            }
            // console.log('treatmenyt',selectedTreatmentsall);
            // Update the treatment table
            updateTable();
        }


        function updateTable() {
            let tableBody = document.getElementById("product-list");
            tableBody.innerHTML = ''; // Clear previous rows

            let totalAmount = 0;

            // Update table for products
            selectedProducts.forEach((product, index) => {
                let row = document.createElement("tr");

                let snoCell = document.createElement("td");
                snoCell.textContent = index + 1;

                let nameCell = document.createElement("td");
                nameCell.textContent = product.name;

                let qtyCell = document.createElement("td");
                qtyCell.innerHTML = `
                    <span onclick="adjustQty(${index}, -1)" style="color: red; font-size: 16px; cursor: pointer; margin-right: 8px;">−</span> 
                    <span style="font-size: 14px; font-weight: bold;">${product.qty}</span>
                    <span onclick="adjustQty(${index}, 1)" style="color: green; font-size: 16px; cursor: pointer; margin-left: 8px;">+</span>
                `;

                let priceCell = document.createElement("td");
                priceCell.textContent = product.price;

                let totalCell = document.createElement("td");
                let productTotal = product.qty * product.price;
                totalCell.textContent = productTotal.toFixed(2);

                row.append(snoCell, nameCell, qtyCell, priceCell, totalCell);
                tableBody.appendChild(row);

                totalAmount += productTotal;
            });
            // console.log(selectedTreatments);
            // Update table for selected treatments
            selectedTreatments.forEach((treatment, index) => {
                // alert(treatment);
                // console.log(treatment);
                let row = document.createElement("tr");

                let snoCell = document.createElement("td");
                snoCell.textContent = selectedProducts.length + index + 1;  // Increment serial number

                let nameCell = document.createElement("td");
                nameCell.textContent = treatment.name;

                let qtyCell = document.createElement("td");
                qtyCell.innerHTML = `
                    <span onclick="adjustTreatmentQty(${index}, -1)" style="color: red; font-size: 16px; cursor: pointer; margin-right: 8px;">−</span> 
                    <span style="font-size: 14px; font-weight: bold;">${treatment.qty}</span>
                    <span onclick="adjustTreatmentQty(${index}, 1)" style="color: green; font-size: 16px; cursor: pointer; margin-left: 8px;">+</span>
                `;

                let priceCell = document.createElement("td");
                priceCell.textContent = treatment.price;

                let totalCell = document.createElement("td");
                let treatmentTotal = treatment.qty * treatment.price;
                totalCell.textContent = treatmentTotal.toFixed(2);

                row.append(snoCell, nameCell, qtyCell, priceCell, totalCell);
                tableBody.appendChild(row);

                totalAmount += treatmentTotal;
            });
            // console.log(selectedTreatmentsall);
            // Update table for all treatments
            selectedTreatmentsall.forEach((treatment, index) => {
                // console.log(index);
                let row = document.createElement("tr");

                let snoCell = document.createElement("td");
                snoCell.textContent = selectedProducts.length + selectedTreatments.length + index + 1;

                let nameCell = document.createElement("td");
                nameCell.textContent = treatment.name;

                let qtyCell = document.createElement("td");
                qtyCell.innerHTML = `
                    <span onclick="adjustTreatmentQtyall(${index}, -1)" style="color: red; font-size: 16px; cursor: pointer; margin-right: 8px;">−</span> 
                    <span style="font-size: 14px; font-weight: bold;">${treatment.qty}</span>
                    <span onclick="adjustTreatmentQtyall(${index}, 1)" style="color: green; font-size: 16px; cursor: pointer; margin-left: 8px;">+</span>
                `;

                let priceCell = document.createElement("td");
                priceCell.textContent = treatment.price;

                let totalCell = document.createElement("td");
                let treatmentTotal = treatment.qty * treatment.price;
                totalCell.textContent = treatmentTotal.toFixed(2);

                row.append(snoCell, nameCell, qtyCell, priceCell, totalCell);
                tableBody.appendChild(row);

                totalAmount += treatmentTotal;
            });

            // Update the total amount
            document.getElementById("total_amount_without").textContent = totalAmount.toFixed(2);
          
            // Calculate additional totals based on total amount
            calculateTotal(totalAmount);
        }

        function adjustQty(index, change) {
            selectedProducts[index].qty += change;
            if (selectedProducts[index].qty < 1) selectedProducts[index].qty = 1; // Ensure qty is not less than 1
            updateTable();
        }
        // Function to adjust the quantity for treatments
        function adjustTreatmentQty(index, change) {
            selectedTreatments[index].qty += change;

            if (selectedTreatments[index].qty < 1) {
                selectedTreatments[index].qty = 1; // Ensure the quantity doesn't go below 1
            }

            // Re-render the table with updated quantities
            updateTable();
        }
        function adjustTreatmentQtyall(index, change) {
            selectedTreatmentsall[index].qty += change;

            if (selectedTreatmentsall[index].qty < 1) {
                selectedTreatmentsall[index].qty = 1; // Ensure the quantity doesn't go below 1
            }

            // Re-render the table with updated quantities
            updateTable();
        }

        function calculateTotal() {
            let totalAmount = parseFloat(document.getElementById("total_amount_without").textContent) || 0;

            // Apply discount logic if discount elements exist
            const discountValue = parseFloat(document.getElementById("discount")?.value) || 0;
            const isDiscountInRupees = document.getElementById("rupees")?.checked;
            const isDiscountInPercentage = document.getElementById("percentage")?.checked;

            if (isDiscountInPercentage) {
                totalAmount -= totalAmount * (discountValue / 100);
            } else if (isDiscountInRupees) {
                totalAmount -= discountValue;
            }

            totalAmount = Math.max(0, totalAmount); // Ensure total amount does not go below zero

            // Tax calculations
            let cgst = 0, sgst = 0, igst = 0;
            if (selectedStateId == 23) { // Adjust for state ID conditions
                cgst = totalAmount * 0.09; // 9% CGST
                sgst = totalAmount * 0.09; // 9% SGST
            } else {
                igst = totalAmount * 0.18; // 18% IGST
            }

            // Update display with calculated GST totals
            // document.getElementById("cgst").textContent = cgst.toFixed(2);
            // document.getElementById("sgst").textContent = sgst.toFixed(2);
            // document.getElementById("igst").textContent = igst.toFixed(2);
            // Update display with calculated GST totals
            document.querySelector(".cgst_text_value").textContent = cgst.toFixed(2);
            document.querySelector(".sgst_text_value").textContent = sgst.toFixed(2);
            document.querySelector(".igst_text_value").textContent = igst.toFixed(2);
            // Show IGST only if it is greater than 0; hide CGST and SGST if IGST is present
            if (igst > 0) {
                document.querySelector(".cgst_container").style.display = 'none'; // Hide CGST
                document.querySelector(".sgst_container").style.display = 'none'; // Hide SGST
                document.querySelector(".igst_container").style.display = 'block'; // Show IGST
            } else {
                document.querySelector(".cgst_container").style.display = 'block'; // Show CGST
                document.querySelector(".sgst_container").style.display = 'block'; // Show SGST
                document.querySelector(".igst_container").style.display = 'none'; // Hide IGST
            }

            // Add GST (CGST, SGST, or IGST) to total amount
            let gstAmount = cgst + sgst + igst;

            // Final payable amount
            let payableAmount = totalAmount + gstAmount;

            // Update the payable amount in the UI
            document.getElementById("total_amount").textContent = payableAmount.toFixed(2);
        }


        // Attach updateTable to checkbox and discount input events
        document.addEventListener("change", (event) => {
            if (event.target.classList.contains("checkbox_animated") || event.target.classList.contains("treatment-checkbox") || event.target.id === "rupees" || event.target.id === "percentage") {
                updateTable();
            }
        });

        document.getElementById("discount").addEventListener("input", updateTable);

        function cutomer_change(){
            var cus_id = $('#select_customer').val();
            gettcategoryall(cus_id);
            c_id= cus_id;
            
        }
        function add_payment() {
            // Gather selected values
            const customer_id = document.getElementById("select_customer").value;
            const selectedLeadId = document.getElementById("select_lead").value; // Added for lead_id
            const selectedProductCategoryId = document.getElementById('select_product_category').value;
            const selectedTreatmentCategoryId = document.getElementById('select_treatment_category_all').value;
            const selectedTreatmentIds = selectedTreatmentsall.map(t => t.id);  // Get IDs from selected treatments
            const selectedTreatmentIdsCus = selectedTreatments.map(t => t.id);  // Get IDs from selected treatments
            const selectedProductIds = selectedProducts.map(p => p.id);
            console.log(selectedTreatmentIds);
            const payment_date = document.getElementById("payment_date").value;
            const cgst = parseFloat($('#cgst').text()) || 0;
            const sgst = parseFloat($('#sgst').text()) || 0;
            const discount_type = $('input[name="discount_type"]:checked').val();
            const discount_amount = parseFloat($('#discount').val()) || 0;
            const treatment_amount = parseFloat($('#treatment_amount').text()) || 0;
            const product_amount = parseFloat($('#product_amount').text()) || 0;
            const igst = parseFloat($('#igst').text()) || 0;
            const total_amount = parseFloat($('#total_amount').text()) || 0;

            const cash_amt = parseFloat($('#cash').val()) || 0;
            const card_amt = parseFloat($('#card').val()) || 0;
            const cheque_amt = parseFloat($('#loan').val()) || 0;
            const upi_amt = parseFloat($('#upi').val()) || 0;

            // Validation checks
            if (customer_id === '0') {
                $("#error_customer_name").html("Please select a customer.");
                return;
            } else {
                $("#error_customer_name").html("");
            }

            if (!payment_date) {
                $("#error_payment_date").html("Please select a payment date.");
                return;
            } else {
                $("#error_payment_date").html("");
            }

            if (cash_amt + card_amt + cheque_amt + upi_amt === 0) {
                alert("Please enter at least one payment method amount.");
                return;
            }

            const multi_pay = JSON.stringify([
                { name: 'cash', amount: cash_amt },
                { name: 'card', amount: card_amt },
                { name: 'upi', amount: upi_amt },
                { name: 'loan', amount: cheque_amt }
            ]);

            // Create the data object with gathered values
            const data = {
                customer_id,
                lead_id: selectedLeadId,  // Include lead_id
                treatment_category_id: selectedTreatmentCategoryId,  
                treatment_ids: selectedTreatmentIds,  // Include treatment_ids
                treatment_ids_cus: selectedTreatmentIdsCus,  // Include treatment_ids
                product_category_id: selectedProductCategoryId,  // Include product_category_id
                product_ids: selectedProductIds,  // Include product_ids
                payment_date,
                cgst,
                sgst,
                discount_type,
                discount_amount,
                treatment_amount,
                product_amount,
                igst,
                total_amount,
                cash: cash_amt,
                card: card_amt,
                cheque: cheque_amt,
                upi: upi_amt
            };

            const token = sessionStorage.getItem('token');
            if (!token) {
                alert("Authorization token is missing. Please log in again.");
                return;
            }

            document.getElementById('add_pay').style.pointerEvents = 'none';

            fetch(base_url + "add_billing", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${token}`
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data.status === 200);
                if (data.status === 200) {
                    $("#status_success").html("<div class='alert alert-success'>Billing Successfully Added!</div>");
                    setTimeout(() => { $("#status_success").html(""); window.location.href = "./billing"; }, 4000);
                } else {
                    $("#status_success").html("<div class='alert alert-danger'>Error adding payment: " + (data.message || "Payment details were added incorrectly.") + "</div>");
                    document.getElementById('add_pay').style.pointerEvents = 'auto';
                }
            })
            .catch(error => {
                console.error("Error:", error);
                $("#status_success").html("<div class='alert alert-danger'>There was an error processing the payment.</div>");
                document.getElementById('add_pay').style.pointerEvents = 'auto';
            });
        }


        function multi_payment(event) {
            // Parse the values from each payment method input
            const cash = parseFloat(document.getElementById('cash').value) || 0;
            const card = parseFloat(document.getElementById('card').value) || 0;
            const cheque = parseFloat(document.getElementById('loan').value) || 0;
            const upi = parseFloat(document.getElementById('upi').value) || 0;

            // Calculate the total payment made
            const totalPayment = cash + card + cheque + upi;

            // Get the total amount from the element
            const totalAmount = parseFloat(document.getElementById('total_amount').textContent) || 0;

            // Calculate the balance amount
            const balanceAmount = totalAmount - totalPayment;

            // Get reference to elements
            const balanceLabel = document.getElementById('balance_amount_enter');
            const submitButton = document.getElementById('add_pay');

            // Check if payment exceeds total amount
            if (totalPayment > totalAmount) {
                // Hide submit button and show warning
                submitButton.style.display = 'none';
                balanceLabel.innerHTML = `<b>Warning: Payment exceeds the total amount!</b>`;
                balanceLabel.style.color = 'red';
            } else {
                // Show submit button and update balance amount
                submitButton.style.display = 'inline-block';

                // Show balance only if it's positive, hide if balance is zero
                if (balanceAmount > 0) {
                    balanceLabel.innerHTML = `<b>Balance Amount: ${balanceAmount.toFixed(2)}</b>`;
                    balanceLabel.style.color = 'red';
                } else {
                    balanceLabel.innerHTML = '';
                }
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


      

        function on_print(id){
           
            const token = sessionStorage.getItem('token');
            fetch(base_url+"edit_payment/"+id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                    
                if(data.status == '200'){

                    //$val =[];
                    $html_tr = "";
                    $pay_modes = JSON.parse(data.data[0].payment_status);

                    $pay_modes.map((menu) =>

                    {
                        if(menu.amount > 0){
                            //$val.push(menu.name);

                           $html_tr += " <tr class='details'>	<td>"+menu.name+"</td>	<td>"+menu.amount+"</td>	</tr>	"
                        }

                    });
                    var amt = data.data[0].amount;
                    var state_id =data.data[0].state_id;
                    // console.log(state_id)                

                        if(state_id==23){
                            var sgst = ((amt/100)*9)/2;
                            var cgst = ((amt/100)*9)/2;
                        }else{
                            var igst = ((amt)*18/100);

                        }

                    var gst_tr ='';

                       if(state_id==23){
                            gst_tr="</tr><tr class='total' style='font-size: 12px;'><td></td><td>Inc. CGST : "+sgst+"</td></tr><tr class='total' style='font-size: 12px;'><td></td><td>Inc. SGST : "+cgst+"</td></tr>";
                        }else{
                            gst_tr="<tr class='total' style='font-size: 12px;'><td></td><td>Inc. IGST : "+igst+"</td></tr>";

                        }
                  //  $mode_off = $val.join(", ");

                    //console.log($mode_off);


                    
                    // gettcatgoryall(data.data[0].tcategory_id);
                    // gettreatmentall(data.data[0].treatment_id);
                    // getcustomerall(data.data[0].customer_id);
                    // document.getElementById("invoice_no").value = data.data[0].invoice_no;
                    // document.getElementById("receipt_no").value = data.data[0].receipt_no;
                    // document.getElementById("payment_date").value = data.data[0].payment_date;
                    // document.getElementById("amount").value = data.data[0].amount;
                    // document.getElementById("total_amount").value = data.data[0].total_amount;
                    // document.getElementById("payment_status").value = data.data[0].payment_status;
                    // document.getElementById("sitting_counts").value = data.data[0].sitting_count;
                    // document.getElementById("tc_name").value = data.data[0].tc_name;
                    // document.getElementById("treatment_name").value = data.data[0].treatment_name;
                    // document.getElementById("customer_first_name").value = data.data[0].customer_first_name;

                    
                    var newWin=window.open('','Print-Window');

                    newWin.document.open();
                    var date = "<?php echo date('d-m-Y'); ?>";
                    
                    // var html_content = "<!DOCTYPE html><html lang='en'>  <head>  <meta charset='utf-8'><title>Payment Receipt</title>  <style>@font-face {  font-family: SourceSansPro;  src: url(SourceSansPro-Regular.ttf);}.clearfix:after {  content: '';  display: table;  clear: both;}a {  color: #0087C3;  text-decoration: none;}body {  position: elative;  width: 21cm;  height: 29.7cm;   margin: 0 auto;   color: #555555;  background: #FFFFFF; font-family: Arial, sans-serif;   font-size: 14px;   font-family: SourceSansPro;}header {  padding: 10px 0;  margin-bottom: 20px;  border-bottom: 1px solid #AAAAAA;}#logo {  float: left;  margin-top: 8px;}#logo img {  height: 70px;}#company {  float: right;  text-align: right;}#details {  margin-bottom: 50px;}#client {  padding-left: 6px;  border-left: 6px solid #0087C3;  float: left;}#client .to {  color: #777777;}h2.name {  font-size: 1.4em;  font-weight: normal;  margin: 0;}#invoice {  float: right;  text-align: right;}#invoice h1 {  color: #0087C3;  font-size: 2.1em;  line-height: 1em;  font-weight: normal;  margin: 0  0 10px 0;}#invoice .date {  font-size: 1.1em; color: #777777;}table { width: 100%;  border-collapse: revert;  border-spacing: 0;  margin-bottom:20px;}table th,table td {  padding: 20px;  background: #EEEEEE;  text-align: center;border-bottom: 1px solid #FFFFFF;}table th {  white-space: nowrap;          font-weight: normal;}table td {  text-align: right;}table td h3{  color: #57B223;  font-size: 1.2em;  font-weight: normal;  margin: 0 0 0.2em 0;}table .no {  color: #FFFFFF;  font-size: 1.6em;  background: #57B223;}table .desc {  text-align: left;table .unit {  background: #DDDDDD;}table  .qty {}table .total {  background: #57B223;  color: #FFFFFF;}table td.unit,table td.qty,table td.total {  font-size: 1.2em;}table tbody tr:last-child td {  border: 1px solid #000;}table tfoot td {  padding: 10px 20px;  background: #FFFFFF;  border-bottom: 1px solid #000;  font-size: 1.2em;  white-space:nowrap;   border-top: 1px solid #AAAAAA; }table tfoot tr:first-child td {  border-top: none; }table tfoot tr:last-child td {  color: #57B223;  font-size: 1.4em;  border-top: 1px solid #57B223; }table foot tr td:first-child {  border: none;}#thanks{  font-size: 2em;  margin-bottom: 50px;}#notices{  padding-left: px;  border-left: 6px solid #0087C3;  }#notices .notice {  font-size: 1.2em;}footer {  color: #777777;  width: 100%;  height: 30px;  position: absolute;  /* bottom: 0; */  border-top: 1px solid #AAAAAA;  padding: 8px 0;  text-align: center;}	</style>  </head>  <body onload='window.print()'>    <header class='clearfix'> <div id='logo'> <img src='https://crm.renewhairandskincare.com/renew_api/apiassets/logo/renew_1.png'>  </div>   <div id='company'><h2 class='name'>Renew+ Hair and Skin Care</h2>  <div>No.155, 2nd floor, 80 feet road,<br /> kk nagar, Madurai, Tami Nadu, India, 625020</div>   <div>+91 9150309990(M)</div>  <div><a href='mailto:company@example.com'>Email: renewhairskincare@gmail.com</a></div>    </div>    </div>  </header>  <main>    <div id='details' class='clearfix'>   <div id='client'>   <div class='to'>RECEIPT TO:</div>  <h2 class='name'>"+data.data[0].customer_first_name+"</h2>          <div class='address'>796 Silver Harbour, TX 79273, US</div>         <div class='email'><a href='mailto:john@example.com'>john@example.com</a></div>       </div>        <div id='invoice'>          <h1>"+data.data[0].receipt_no+"</h1>          <div class='date'>Invoice: "+data.data[0].invoice_no+"</div> <div class='date'>Date of Invoice: 11/01/2023</div>         <div class='date'>Due Date: 11/01/2023</div>        </div>      </div>      <table border='1' cellspacing='0' cellpadding='0'>        <thead>          <tr>            <th class='no'>#</th>            <th class='desc'>DESCRIPTION</th>            <!-- <th class='unit'>UNIT PRICE</th>            <th class='qty'>QUANTITY</th> -->            <th class='total'>TOTAL</th>          </tr>        </thead>        <tbody>          <tr>            <td class='no'>01</td>            <td class='desc'><h3>"+data.data[0].tc_name+"</h3>"+ data.data[0].treatment_name+"</td>            <!-- <td class='unit'>40.00</td>            <td class='qty'>30</td> -->            <td class='total'>"+data.data[0].amount+"</td>          </tr>          <!-- <tr>            <td class='no'>02</td>            <td class='desc'><h3>Website Development</h3>Developing a Content Management System-based Website</td> -->            <!-- <td class='unit'>$40.00</td>            <td class='qty'>80</td> -->            <!-- <td class='total'>$3,200.00</td>          </tr>          <tr>            <td class='no'>03</td>            <td class='desc'><h3>Search Engines Optimization</h3>Optimize the site for search engines (SEO)</td> -->            <!-- <td class='unit'>$40.00</td>            <td class='qty'>20</td> -->            <!-- <td class='total'>$800.00</td>          </tr> -->        </tbody>        <tfoot>          <tr>            <td colspan='2'></td>            <!-- <td colspan='2'>SUBTOTAL</td>    -->        <td>"+data.data[0].amount+"</td>               </tfoot>      </table>      <div id='thanks'>Thank you!</div>      <!-- <div id='notices'>        <div>NOTICE:</div>        <div class='notice'>A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>      </div> -->    </main>    <footer>      Receipt was created on a computer and is valid without the signature and seal.</footer>  </body></html>";

                    var html_content =  "<!DOCTYPE html><html><head><meta charset='utf-8' /><title>PAYMENT RECEIPT</title><style>.invoice-box {	max-width: 800px;margin: auto;	padding: 0px;		border: 1px solid #eee;	box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);font-size: 16px;		line-height: 24px;	font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, ans-serif;color: #555;	}	.invoice-box table {width: 100%;line-height: inherit;		text-align: left;	}	.invoice-box table td {	padding: 5px;	vertical-align: top;}.invoice-box table tr td:nth-child(2) {text-align: right;}	.invoice-box table tr.top table td {padding-bottom: 20px;}	.invoice-box table tr.top table td.title {	font-size: 15px;line-height: 15px;	color: #333;}.invoice-box table tr.information table td {			padding-bottom: 40px;		}	.invoice-box table tr.heading td {	background: #eee;	border-bottom: 1px solid #ddd;	font-weight: bold;}	.invoice-box table tr.details td {	padding-bottom: 20px;}	.invoice-box table tr.item td {	border-bottom: 1px solid #eee;	}	.invoice-box table tr.item.last td {border-bottom: none;}	.invoice-box table tr.total td:nth-child(2) {	border-top: 2px solid #eee;	font-weight: bold;}		@media only screen and (max-width: 600px) {	.invoice-box table tr.top table td {width: 100%;	display: block;	text-align: center;	}.invoice-box table tr.information table td {		width: 100%;	display: block;		text-align: center;	}	}	.invoice-box.rtl {		direction: rtl;	font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, ans-serif;		}	.invoice-box.rtl table {	text-align: right;	}.invoice-box.rtl table tr td:nth-child(2) {text-align: left;		}	</style></head><body>		<div class='invoice-box' style='border: 1px solid #c6c6c6;'>            <h2 align='center'>PAYMENT RECEIPT</h2>			<hr>			<table cellpadding='0' cellspacing='0'>				<tr class='top ' >					<td colspan='2' style='border-bottom: 1px solid #c6c6c6';>						<table>							<tr >								<td class='title' ><img src='https://crm.renewhairandskincare.com/renew_api/public/logo/22626.png' style='float:left; width: 100%; max-width: 120px;    padding-top: 30px; margin-right:20px;' />		<div style='vertical-align:bottom ;'>					<h3>Renew+ Hair and Skin Care</h3>							<p>No.155, 2nd floor, 80 feet road,<br /> kk nagar, Madurai, Tami Nadu, India, 625020</p>			<p>+91 9150309990(M)</p>										<p>Email: renewhairskincare@gmail.com</p>									</div>						</td>								<td>									Receipt  #: "+data.data[0].receipt_no+"<br />									Created: "+data.data[0].payment_date+"<br />								Due: "+date+"							</td>							</tr>						</table>		</td>				</tr>				<tr class='information'>		<td colspan='2'>						<table>							<tr>								<td>		<h5>To:</h5>									<h3>Name : "+data.data[0].customer_first_name+"</h3>                                    <p style='margin:0px;'>"+data.data[0].customer_address+"</p>									<p style='margin:0px;'>+91 "+data.data[0].customer_phone+"(M)</p>                                    <p style='margin:0px;'>Email: "+data.data[0].customer_email+"</p>					</td>								<td>								</td>				</tr>					</table>			</td>	</tr>	<tr class='heading'>	<td>Payment Method</td>					<td>Cash #</td>		</tr>"	+$html_tr+		"<tr class='heading'>         <td>Description</td>		<td>Price</td>		</tr>	<tr class='item'>					<td>Hair Fall Treatement</td>				<td>"+data.data[0].amount+"</td>		</tr>		"+gst_tr+"		<tr class='total'>	<td></td>	<td>Total: "+data.data[0].amount+"</td>			</tr>  <tr style='height:100px'	<td></td><td></td>	</tr>				<tr >		<td>	Customer's Signatory	</td>	<td>			Authorised Signatory</td>	</tr>	<tr style='height:20px'>	<td></td><td></td>		</tr>	</table> </div></body></html>";   
                        
                        
                    newWin.document.write(html_content);
                   
                    // newWin.document.write('<html><head><title>Print</title></head><body>' + html_content + '</body></html>');
                   newWin.print();
                    
                newWin.document.close();

                   // window.jsPDF = window.jspdf.jsPDF;

                    // var pdf = new jsPDF('p', 'pt', 'letter');
                        
                    // Source HTMLElement or a string containing HTML.
                    // var elementHTML = document.querySelector("#contnet");

                    // pdf.html(html_content, {
                    //     callback: function(pdf) {
                    //         // Save the PDF
                    //         pdf.save('sample-document.pdf');
                    //     },
                    //     x: 15,
                    //     y: 15,
                    //     width: 170, //target width in the PDF document
                    //     windowWidth: 650 //window width in CSS pixels
                    // });

                    // var myBlob;

                    // // $('#cmd').click(function () {
                    //     doc.fromHTML(html_content, 15, 15, {
                    //         'width': 170,
                    //             'elementHandlers': specialElementHandlers
                    //     });
                    //     myBlob = doc.save('blob');
                    // // });

              
                    // var pdf = new jsPDF({
                    //     unit: 'px',
                    //     format: 'A4' === 'A4' ? [595, 842] : [842, 1191]
                    //     });
                    // var pdf = new jsPDF({
                    //         unit: 'px',
                    //         format: 'a4' // You can specify format directly
                    //     });
                    // pdf.canvas.height = 72 * 11;
                    // pdf.canvas.width = 72 * 8.5;

                    // pdf.fromHTML('<p>Hello</P>');

                    // pdf.save(data.data[0].customer_first_name+'.pdf');
                    // pdf.fromHTML(htmlContent, 15, 15, {}, function() {
                    //     // Save PDF
                    //     pdf.save(data.data[0].customer_first_name + '.pdf');
                    // }, {allowTaint:true});
                    // pdf.html(htmlContent, {
                    //     callback: function(pdf) {
                    //         // Save PDF
                    //         pdf.save(data.data[0].customer_first_name + '.pdf');
                    //     }
                    // });
                    // var element = document.getElementById("clickbind");
                    // element.addEventListener("click", onClick);
                    


                    // const doc = new jsPDF({
                    //     unit: 'px',
                    //     format: 'A4' === 'A4' ? [595, 842] : [842, 1191]
                    //     });

                    //     doc.html(html_content, {
                    //     callback: (doc) => {
                    //         doc.deletePage(doc.getNumberOfPages());
                    //         doc.save('pdf-export');
                    //     }
                    //     });
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

   /* Remove borders, make items more compact */
.product-item {
    background-color: #f9f9f9;  /* Light background color */
    border-radius: 8px;         /* Rounded corners */
    padding: 8px;               /* Reduced padding */
    transition: box-shadow 0.2s ease, transform 0.2s ease;  /* Smooth transition for hover */
    min-height: 70px;           /* Consistent height */
    display: flex;              /* Flexbox for alignment */
    align-items: center;        /* Center items vertically */
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);  /* Light shadow for subtle definition */
}

/* Hover effect for interactivity */
.product-item:hover {
    transform: scale(1.05);      /* Slight zoom on hover */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);  /* Slightly stronger shadow */
}


.product-name {
    font-size: 14px;
    color: #333;
    display: block;
    max-width: 150px; /* Adjust this width according to your layout */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.product-name:hover {
    cursor: pointer;
}

/* Amount styling */
.product-amount {
    color: #3db082;              /* Green color for amount */
    font-size: 13px;             /* Slightly smaller font size */
    font-weight: 500;            /* Font weight for better readability */
}

/* Image Styling */
.product-item img {
    width: 40px;                 /* Smaller image size */
    height: 40px;                /* Height consistent with width */
    object-fit: cover;           /* Maintain aspect ratio */
    border-radius: 50%;          /* Circular image */
    margin-right: 12px;          /* Space between image and text */
}

/* Flexbox container for product details */
.product-item label {
    display: flex;               /* Flex for horizontal layout */
    align-items: center;         /* Center vertically */
    justify-content: space-between;  /* Space between checkbox and text */
    width: 100%;
}


    .form-check-label {
        width: 100%; /* Make the label full width */
        display: flex;
        align-items: center;
        justify-content: space-between;
    }




</style>


