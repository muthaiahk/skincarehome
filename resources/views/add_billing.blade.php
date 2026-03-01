@extends('layouts.app')

@section('content')

  <!-- <body onload="startTime()"> -->
    <body>
    <!-- loader starts-->
    <div class="loader-wrapper">
      <div class="loader-index"><span></span></div>
      <svg>
        <defs></defs>
        <filter id="goo">
          <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
          <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
        </filter>
      </svg>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <!-- <div class="tap-top"><i data-feather="chevrons-up"></i></div> -->
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      
      <!-- Page Header Ends-->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        
        <!-- Page Sidebar Ends-->

        <div class="page-body">
            <div class="container-fluid">        
                <div class="page-title">
                  <div class="row">
                    <div class="col-6">
                      <h3>Add Billing</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="payment">Billing Lists</a></li>
                        <li class="breadcrumb-item">Add Billing</li>
                      </ol>
                    </div>
                  </div>
                </div>
            </div>
            <form class="form wizard">
              <!-- Container-fluid starts-->
              <div class="container-fluid">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="card">
                      <div  id="status_success">
                     
                    </div> 
                      <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-6 position-relative">
                              <div class="row">
                                  <!-- Radio button for Lead or Customer -->
                                  <div class="col-lg-8 position-relative">
                                      <div class="row mb-6 m-t-5 custom-radio-ml">
                                        <!-- <div class="col-lg-4 form-check radio radio-primary">
                                          <input class="form-check-input" id="lead" type="radio" name="customer_type" data-bs-original-title="" title=""  checked onclick="toggleCustomerLead();">
                                          <label class="form-check-label" for="lead">Lead</span></label>
                                        </div> -->
                                        <div class="col-lg-6 ">
                                          <!-- <input class="form-check-input" id="customer" type="radio" name="customer_type" data-bs-original-title="" title=""   onclick="toggleCustomerLead();"> -->
                                          <label class="form-check-label" for="customer">Customer</span></label>
                                        </div>
                                      </div>
                                  </div>
                                  <!-- Current Date -->
                                  <div class="col-lg-4">
                                      <input class="form-control digits futuredate_disable" value="<?php echo date('Y-m-d'); ?>" onfocusout="check_date(event)" type="date" id="payment_date" placeholder="Payment Date">
                                      <div class="text-danger" id="error_payment_date"></div>
                                  </div>
                              </div>
                              <div class="row mb-2">
                                  <!-- To show here if radio button lead show lead or customer -->
                                  <div class="col-lg-6 position-relative" id="billing_lead_list" style="display: none;">
                                      <!-- Lead details will be populated here -->
                                  </div>
                                  <div class="col-lg-6 position-relative" id="payment_customer_list" >
                                      <!-- Customer details will be populated here -->
                                  </div>
                                  <div class="col-lg-6 position-relative mt-1">
                                      <select id="customer_treatment_details" class="form-control" multiple="multiple"></select>
                                  </div>

                                  <div id="selected_treatment_display" class="col-lg-6 mt-3">
                                      <!-- Selected treatments will be populated here -->
                                  </div>
                              </div>
                              <div class="row mb-3">
                                <div class="col-lg-12">
                                  <div class="table-responsive"  style='max-height: 150px; overflow-y: auto;'>
                                    <table class="table" id="billing-table" >
                                      <thead>
                                        <tr>
                                          <th>Sno</th>
                                          <th>Product/Treatment</th>
                                          <th>Qty</th>
                                          <th>Per Price</th>
                                          <th>Total</th>
                                        </tr>
                                      </thead>
                                      <tbody id="product-list">
                                        <!-- Product Rows Will Be Added Here Dynamically -->
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                  <!-- Header -->
                                  <div class="col-lg-6">
                                      <label class="form-label"><b>Billing Segment</b></label>
                                  </div>
                                  
                                  <!-- Total Amount Section -->
                                  <div class="col-lg-6 d-flex align-items-center justify-content-between p-2 bg-light rounded">
                                      <span class="text-dark font-weight-bold">Total Amount:</span>
                                      <span id="total_amount_without" class="badge badge-primary px-3 py-2 font-weight-bold" style="font-size: 1.2rem;">
                                          0.00
                                      </span>
                                  </div>

                                  <!-- Discount Type Section -->
                                  <div class="row">
                                      <!-- Discount Type Section -->
                                      <div class="col-lg-4">
                                          <div class="form-group">
                                              <span>Discount Type</span>
                                              <div class="d-flex align-items-center mt-2">
                                                  <label class="me-3">
                                                      <input type="radio" name="discount_type" id="rupees" checked value="1" onclick="calculateTotal()"> Rs.
                                                  </label>
                                                  <label class="me-3">
                                                      <input type="radio" name="discount_type" id="percentage" value="2" onclick="calculateTotal()"> %
                                                  </label>
                                                  <input type="text" class="form-control ms-2" id="discount" value="0" placeholder="Enter value" oninput="validateInterest(this)">
                                              </div>
                                          </div>
                                      </div>

                                      
                                      <!-- <div class="col-lg-4">
                                          <div class="d-flex flex-column align-items-end">
                                              <span class="fw-bold cgst_text">CGST</span>
                                              <span class="fw-bold sgst_text">SGST</span>
                                              <span class="fw-bold igst_text">IGST</span>
                                          </div>
                                      </div>

                                    <div class="col-lg-4 text-end">
                                        <div class="d-flex flex-column align-items-end">
                                            <span class="fw-bold cgst_text" id="cgst">0.00</span>
                                            <span class="fw-bold sgst_text" id="sgst">0.00</span>
                                            <span class="fw-bold igst_text" id="igst">0.00</span>
                                        </div>
                                    </div> -->
                                    <div class="col-lg-8 text-end">
                                      <div class="d-flex flex-column align-items-end">
                                          <div class="cgst_container">
                                              <label class="form-control-label">CGST:</label>
                                              <span class="fw-bold cgst_text_value">0.00</span>
                                          </div>
                                          <div class="sgst_container">
                                              <label class="form-control-label">SGST:</label>
                                              <span class="fw-bold sgst_text_value">0.00</span>
                                          </div>
                                          <div class="igst_container" style="display: none;"> <!-- Hide by default -->
                                              <label class="form-control-label">IGST:</label>
                                              <span class="fw-bold igst_text_value">0.00</span>
                                          </div>
                                      </div>
                                  </div>

                                  </div>

                                  <div class="col-lg-6 mb-0">
                                  </div>
                                  <!-- Payable Amount Section -->
                                  <div class="col-lg-6 d-flex align-items-center justify-content-between p-2 bg-light rounded">
                                      <span class="text-dark font-weight-bold">Payable Amount:</span>
                                      <span id="total_amount" class="badge badge-success px-3 py-2 font-weight-bold" style="font-size: 1.2rem;">
                                          0.00
                                      </span>
                                  </div>
                              </div>


                              <div class="row">
                                <div class="col-12">
                                    <label class="form-label"><b>Payment Details Entry!</b></label>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="col-form-label" for="cash">Cash</label>
                                        <input type="text" class="form-control" name="cash" id="cash" value="0" oninput="multi_payment(event)">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="col-form-label" for="card">Card</label>
                                        <input type="text" class="form-control" id="card" name="card" value="0" oninput="multi_payment(event)">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="col-form-label" for="upi">UPI</label>
                                        <input type="text" class="form-control" id="upi" name="upi" value="0" oninput="multi_payment(event)">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="col-form-label" for="loan">Loan</label>
                                        <input type="text" class="form-control" id="loan" name="loan"  value="0" oninput="multi_payment(event)">
                                    </div>
                                </div>
                              </div> 
                              <div class="col-12 mt-2">
                                    <label class="form-label text-danger" id="balance_amount_enter"><b></b></label>
                              </div>
                              
                              <div class="row mb-3">
                                <div class="card-footer text-end">
                                <input type="hidden" id="cus_treat_id" value=''>
                                  <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./billing'>Cancel</a></button>
                                  <button class="btn btn-primary" type="button" data-bs-original-title="" title=""  id="add_pay" onclick="add_payment()">Submit</button>
                                </div>
                              </div>
                            </div>
                            <!-- Vertical Line to Separate Divs -->
                            <div class="col-lg-6 position-relative" style="border-left: 1px solid #ccc; padding-left: 20px;">
                                <!-- Product List Dropdown -->
                                  <div class="row">
                                    <div class="col-lg-5 position-relative" >
                                      <label class="form-label" for="product">Product Category</label>
                                    </div>
                                    <div class="col-lg-7 position-relative" id="product_category_list">
                                            
                                    </div>
                                  </div>
                                <!-- Optional error message for products -->
                                <div class="text-danger" id="error_product" ></div>
                                
                                  <div  id="product_list" > 
                                  
                                  </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-lg-5 position-relative" >
                                      <label class="form-label" for="product">Treatment Category</label>
                                    </div>
                                    <div class="col-lg-7 position-relative" id="treatment_category_list_all">
                                            
                                    </div>
                                </div>
                                <div class="row mt-2" >
                                  <div  id="treatment_details">
                                  
                                  </div>
                                  <div  id="treatment_details_all" class="mt-2">
                                  
                                  </div>
                                </div>
                            </div>
                        </div>
                  
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Container-fluid Ends-->
            </form>
        </div>
        <script>

        function validateInterest(input) { 
            // Get the selected discount type
          const discountTypeElement = document.querySelector('input[name="discount_type"]:checked');
          const discount_type = discountTypeElement ? discountTypeElement.value : null;

          // Allow only numbers and a single decimal point
          input.value = input.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');

          const value = parseFloat(input.value);

          // If discount type is percentage, limit the value to 99.99
          if (discount_type === '2') {
            if (value >= 100) {
              input.value = '99.99'; // Set the value to the maximum allowed
            }
          }
        }

        // function toggleCustomerLead() {
        //     const isLead = document.getElementById('lead').checked;
        //     document.getElementById('billing_lead_list').style.display = isLead ? 'block' : 'none';
        //     document.getElementById('payment_customer_list').style.display = isLead ? 'none' : 'block';
           
        // }
          function updateAmount() {
              const productList = document.getElementById('product_list');
              const selectedOption = productList.options[productList.selectedIndex];
              const amountField = document.getElementById('total_amount');

              // Get the price from the selected option's data attribute
              const price = selectedOption ? selectedOption.dataset.price : 0;
              
              // Update the amount field
              amountField.value = price || 0; // Set to 0 if no product is selected
          }

          // Add a check_date function if needed
          function check_date(event) {
              // Your validation logic here
          }
        </script>
        <!-- footer start-->
        
        <!-- footer start-->
      </div>
    </div>
    
    
    @include('api.api_billing_add')
    <script>
      function calculateTotal2(){
        document.getElementById("discount").value = 0;
        calculateTotal();
      }
    </script>
      <script>
      
      $(document).ready(function() {
        $('.page-header').addClass('close_icon');
        $('.sidebar-wrapper').addClass('close_icon');
    });
    </script>
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>
<!-- $payment->invoice = 'IN/' -->
@endsection


