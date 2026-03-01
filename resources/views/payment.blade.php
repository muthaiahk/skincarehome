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
                <h3>Payments Lists</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard">
                      <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Payments Lists</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="row card-header mt-4 mx-3" id="add_treatment">
                      <div class="col-md-3">
                        <div id="branch_list">
                          <select class="form-select" id="branch_name" onChange="selectbranch(event)">
                            <option value="0">All Branch</option>
                          </select>
                          <div class="invalid-feedback"></div>
                        </div>
                      </div>

                      <!-- <div class="col-md-3">
                        <select class="form-select" id="treatment_cat_list">
                          <option value="0">Select Category</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <select class="form-select" id="select_treatment">
                          <option value="0">Select Treatment</option>
                        </select>
                      </div> -->
                      <div class="col-lg-1">
                        <p class="btn btn-primary" id="all_payment_list">Go</p>
                      </div>
                      <div class="col-lg-3"></div>
                      <div class="col-lg-3"></div>
                      <div class="col-md-2">
                        <div class="text-end float-right">
                          <a href="add_payment.php" type="button" class="btn btn-primary" id='add_payment' type="submit" data-bs-original-title="">Add Payment</a>
                        </div>
                      </div>
                    </div>
                    <div id="status_success"></div>
                  </div>
                  <div class="card-body">
                    
                    <div class="d-flex justify-content-end mt-2 mb-2">
                      <div class="col-3">
                        <input class="form-control" type="text" placeholder="Search" id='search_input'>
                      </div>
                    </div>
                    <!-- Loading Indicator -->
                    <div id="loadingIndicator" class="text-center" style="display: none;">
                      <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                      </div>
                      <p>Loading data, please wait...</p>
                    </div>
                    
                    <!-- Table Container -->
                    <div class="table-responsive product-table" id="payment_list">
                      <!-- Table will be loaded here dynamically -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid Ends-->
      </div>
      <!-- footer start-->
      
      <!-- footer start-->
    </div>
  </div>

  <div class="modal fade" id="payment_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <br>
          <h5 style="text-align: center;">Delete ?</h5><br>
          <div class="mb-3">
            <p class="col-form-label" style="text-align: center !important;">Are you sure you want to delete this Data.</p>
          </div>
        </div>
        <div class="card-footer text-center mb-3">
          <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal" id="delete">Yes, delete</button>
        </div>
      </div>
    </div>
  </div>

  
  

  <!-- Updated API Script with Pagination -->
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
      $("#add_payment").hide();
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
        } catch (error) {
          console.error(error);
          throw error;
        }
      }

      permission_page("customer_payment").then(() => {
        try {
          all();
        } catch (error) {
          console.error(error);
        }
      });

      gettcategoryall(0);

      // Loading indicator functions
      function showLoading() {
        document.getElementById("loadingIndicator").style.display = "block";
        if (document.getElementById("payment_table")) {
          document.getElementById("payment_table").style.display = "none";
        }
      }

      function hideLoading() {
        document.getElementById("loadingIndicator").style.display = "none";
        if (document.getElementById("payment_table")) {
          document.getElementById("payment_table").style.display = "table";
        }
      }


      // Enter key in search input
      $('#search_input').keypress(function(e) {
        if (e.which == 13) { // Enter key
          var branch_id = $("#branch_name").val();
          // currentPage = 1;
          all();
        }
      });

      // Auto-search with delay (optional)
      let searchTimeout;
      $('#search_input').keyup(function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
          var branch_id = $("#branch_name").val();
          // currentPage = 1;
          all()
        }, 500); // 500ms delay
      });

      // Main payment list function with pagination
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


        showLoading();

        fetch(base_url + "payment", {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
              'Authorization': `Bearer ${token}`,
            },
            method: "post",
            body: params
          })
          .then((response) => response.json())
          .then((data) => {
            if (data.status == '200' && data.data) {
              totalRecords = data.total || 0;
              totalPages = Math.ceil(totalRecords / itemsPerPage);

              const value = data.data;
              let htmlString = "";

              const htmlHead = `<table class='display' id='payment_table'>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Receipt No</th>
                                <th>Customer/Lead</th>
                                <th>Paid Amount</th>
                                <th>Total Amount</th>
                                <th>Balance Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>`;

              let totalAmount = 0;
              let totalGst = 0;
              let balanceAmount = 0;

              for (let i = 0; i < value.length; i++) {
                const item = value[i];
                const name = item.customer_first_name || item.lead_first_name || "N/A";
                const phone = item.customer_phone || item.lead_phone || "N/A";
                const paidStatus = item.balance > 0 ?
                  "<span class='bg-danger p-1 rounded'>Pending</span>" :
                  "<span class='bg-success p-1 rounded'>Paid</span>";

                let action = "";
                if (permission) {
                  var values = permission.split(",");
                  if (values.length > 0) {
                    var print = values.includes('print');
                    if (print) {
                      action += `<a href='#' onclick='on_print(${item.p_id})'><i class='fa fa-print eyc'></i></a>`;
                    }
                  }
                }

                htmlString += `
                            <tr>
                                <td>${item.payment_date || "N/A"}</td>
                                <td>${item.receipt_no || "N/A"}</td>
                                <td>${name}<br/>${phone}</td>
                                <td>₹${item.amount || 0}</td>
                                <td>₹${item.total_amount || 0}</td>
                                <td>₹${item.balance || 0}</td>
                                <td>${paidStatus}</td>
                                <td>${action}</td>
                            </tr>
                        `;

                totalAmount += parseFloat(item.amount || 0);
                totalGst += parseFloat(item.total_amount || 0);
                balanceAmount += parseFloat(item.balance || 0);
              }

              const totalRow = `<tfoot>
                        <tr>
                            <td colspan='3' class="fs-4"><strong>Total (this page)</strong></td>
                            <td><strong class="text-info fs-4">₹${totalAmount.toFixed(2)}</strong></td>
                            <td><strong class="text-success fs-4">₹${totalGst.toFixed(2)}</strong></td>
                            <td><strong class="text-danger fs-4">₹${balanceAmount.toFixed(2)}</strong></td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>`;

              const htmlFooter = "</tbody></table>";

              // Create pagination HTML
              const paginationHtml = createCustomPagination();

              const fullHtml = htmlHead + htmlString + totalRow + htmlFooter + paginationHtml;
              $("#payment_list").html(fullHtml);

              // Initialize DataTable
              initializeDataTable();
            } else {
              $("#payment_list").html("<div class='text-center py-5'>No data found</div>");
            }
          })
          .catch(error => {
            console.error('Error fetching payment data:', error);
            $("#payment_list").html("<div class='text-center py-5 text-danger'>Error loading data</div>");
          })
          .finally(() => {
            hideLoading();
          });
      }

      // Function to navigate to specific page
      function goToPage(page) {
        if (page < 1 || page > totalPages || page === currentPage) return;

        currentPage = page;
        all();

        // Scroll to top of table
        $('html, body').animate({
          scrollTop: $("#payment_list").offset().top - 100
        }, 500);
      }

      // Create custom pagination HTML
      function createCustomPagination() {
        if (totalPages <= 1) {
          return '<div id="custom-pagination-container" class="mt-3"></div>';
        }

        let paginationHtml = `<div id="custom-pagination-container" class="mt-3">
                <div class="d-flex justify-content-between align-items-center">
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

        paginationHtml += `</ul></nav></div></div>`;

        return paginationHtml;
      }

      // Initialize DataTable with pagination disabled
      function initializeDataTable() {
        // Destroy existing DataTable instance if it exists
        if ($.fn.DataTable.isDataTable('#payment_table')) {
          $('#payment_table').DataTable().destroy();
        }

        // Initialize DataTable with custom DOM
        $('#payment_table').DataTable({
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

      function gettcategoryall(id) {
        var attr_index = "";
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
            if (data.status == '200') {
              if (data.data.length > 0) {
                state_id = data.data[0].state_id;
                var cus_treat_id = data.data[0].cus_treat_id;
                document.getElementById('cus_treat_id').value = cus_treat_id;
                const value = data.data;
                var htmlString = "";

                for (var i = 0; i < value.length; i++) {
                  if (value[i].status == '0') {
                    if (sessionStorage.getItem('treatment_id')) {
                      if (sessionStorage.getItem('treatment_id') == value[i].treatment_id) {
                        attr_index = i;
                      }
                    }

                    htmlString += "<div class='row  mb-3'>\
                                    <div class='col-lg-5 position-relative'>\
                                        <input class='form-control-plaintext fs-6' type='text' data-bs-original-title=''  id='treatment_name" + [i] + "' placeholder='' name='" + value[i].treatment_id + "' value='" + value[i].treatment_name + "'>\
                                        <div class='row'>\
                                            <span>Fixed Amount : " + value[i].amount + " , Discount : " + value[i].discount + " , Paid Amount : " + value[i].pay_amount + " , Balance :" + value[i].balance + "</span>\
                                        </div>\
                                    </div>\
                                    <div class='col-lg-2 position-relative'>\
                                        <input class='form-control-plaintext text-center' type='text' data-bs-original-title=''  id='amount" + [i] + "' placeholder='' value='" + value[i].balance + "'>\
                                    </div>\
                                    <div class='col-lg-3 position-relative'>\
                                        <div class='row'>\
                                            <div class='col-lg-4'>\
                                                <select class='form-select' id='select_discount" + [i] + "'>\
                                                    <option value='rupee' selected>&#8377;</option>\
                                                    <option value='percent'>&#37;</option>\
                                                </select>\
                                            </div>\
                                            <div class='col-lg-8'>\
                                                <input class='form-control' type='text' data-bs-original-title='' id='discount" + [i] + "' placeholder='' value='0' onfocusout='discount_enter(event)' name='" + [i] + "'>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class='col-lg-2 position-relative'>\
                                        <input class='form-control' type='text' data-bs-original-title='' id='final_amount" + [i] + "' placeholder='' value='0' onfocusout='payment_enter(event)' name='" + [i] + "'>\
                                        <input class='form-control' type='hidden' data-bs-original-title='' id='cus_treat_id" + [i] + "' placeholder='' value='" + value[i].cus_treat_id + "' name='" + [i] + "'>\
                                        <input type='hidden' id='discount_type" + [i] + "' name='discount_type" + [i] + "' value=''>\
                                    </div>\
                                </div>";
                  }
                }

                $("#treatment_details").html(htmlString);
                $('#final_amount' + attr_index).removeAttr('readonly');
                $('#discount' + attr_index).removeAttr('readonly');

                var arr = [];
                for (var i = 0; i < value.length; i++) {
                  if (value[i].status == '0') {
                    var amount = value[i].amount;
                    $('#final_amount' + [i]).val(0);
                    arr.push(amount);
                    Array_ids.push({
                      discount: "discount" + [i],
                      final_amount: "final_amount" + [i],
                      treatment_id: value[i].treatment_id,
                      cus_treat_id: value[i].cus_treat_id
                    });
                  }
                }

                var val = sum(arr);
                $('#taxtable_value').val(0);
                $value = parseInt(0) * (18 / 100);
                $value = Math.round($value / 2);
                $('#cgst_value').val($value);
                $('#sgst_value').val($value);
                $('#igst_value').val($value);
                $('#total_amount_value').val(0);

                $('#igst').css({
                  'display': 'none'
                });
                $('#igst_value').css({
                  'display': 'none'
                });
                $('#cgst').css({
                  'display': 'none'
                });
                $('#cgst_value').css({
                  'display': 'none'
                });
                $('#sgst').css({
                  'display': 'none'
                });
                $('#sgst_value').css({
                  'display': 'none'
                });
              } else {
                $("#treatment_details").html('');
              }
            }
          });
      }

      function getcustomerall() {
        const token = sessionStorage.getItem('token');
        fetch(base_url + "customer_treatment_list", {
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
                if (id > 0) {
                  var dis_st = "disabled";
                } else {
                  var dis_st = "";
                }
                var htmlhead = "<label class='form-label'>Customer Name</label><select class='form-select' id='select_customer' onchange='cutomer_change();' " + dis_st + "><option value='' >Select Customer Name</option>";
                for (var i = 0; i < value.length; i++) {
                  function user_status(value) {
                    if (value == id) {
                      return 'selected';
                    } else {
                      return '';
                    }
                  }
                  if (value[i].status == '0') {
                    htmlString += "<option value='" + value[i].customer_id + "'" + user_status(value[i].customer_id) + ">" + value[i].customer_first_name + " " + value[i].customer_last_name + ' - ' + value[i].customer_phone + "</option>"
                  }
                }
                var htmlfooter = "</select><div class='text-danger' id='error_customer_name'></div>";
                var htmlstringall = htmlhead + htmlString + htmlfooter;
                $("#payment_customer_list").html(htmlstringall);
              }
            }
          });
      }

      if (id > 0) {
        gettcategoryall(id);
      }

      function cutomer_change() {
        var cus_id = $('#select_customer').val();
        gettcategoryall(cus_id);
        c_id = cus_id;
      }

      var arr_treatment = [];

      function payment_enter(e) {
        var amount = e.target.value;
        var index = e.target.name;
        var total_amount = $('#amount' + index).val();
        var total_discount = $('#discount' + index).val();
        var treatment_id = $('#treatment_name' + index).val();
        var cus_treat_id = $('#cus_treat_id' + index).val();
        var select_discount = $('#select_discount' + index).val();

        arr_treatment.push({
          'id': treatment_id,
          'discount': total_discount,
          'amount': amount,
          'cus_treat_id': cus_treat_id,
        })

        var t_amt = parseInt(amount) + parseInt(total_discount);

        if (parseInt(t_amt) > total_amount) {
          alert('your amount is excess paying amount');
          $('#final_amount' + index).val(0);
        }

        var arr_amt = [];
        var p_amt = [];

        Array_ids.map((val, i) => {
          var dis = $('#' + val.discount).val();
          var amt = parseInt($('#' + val.final_amount).val());

          if (select_discount == 'percent') {
            var val_amt = (total_amount / 100) * dis;
          } else {
            var val_amt = dis;
          }

          $val = parseInt(val_amt) + parseInt(amt);
          arr_amt.push($val);
          p_amt.push(amt);
        });

        var t_amt = sum(arr_amt);
        $('#taxtable_value').val(t_amt);

        if (state_id == 23) {
          $value = parseInt(t_amt) * (18 / 100);
          $value = Math.round($value / 2);
          $('#cgst_value').val($value);
          $('#sgst_value').val($value);
          $('#igst_value').val(0);

          $('#igst').css({
            'display': 'none'
          });
          $('#igst_value').css({
            'display': 'none'
          });
          $('#cgst').css({
            'display': 'block'
          });
          $('#cgst_value').css({
            'display': 'block'
          });
          $('#sgst').css({
            'display': 'block'
          });
          $('#sgst_value').css({
            'display': 'block'
          });
        } else {
          $value = parseInt(t_amt) * (18 / 100);
          $value = Math.round($value / 1);
          $('#cgst_value').val(0);
          $('#sgst_value').val(0);
          $('#igst_value').val($value);

          $('#igst').css({
            'display': 'block'
          });
          $('#igst_value').css({
            'display': 'block'
          });
          $('#cgst').css({
            'display': 'none'
          });
          $('#cgst_value').css({
            'display': 'none'
          });
          $('#sgst').css({
            'display': 'none'
          });
          $('#sgst_value').css({
            'display': 'none'
          });
        }

        $('#total_amount_value').val(amount);
      }

      function discount_enter(e) {
        var amount = e.target.value;
        var index = e.target.name;
        var select_discount = $('#select_discount' + index).val();
        var discount_type = select_discount === 'percent' ? 2 : 1;
        $('#discount_type' + index).val(discount_type);
        var final_amount = $('#final_amount' + index).val();
        var total_amount = $('#amount' + index).val();

        var t_amt = parseInt(final_amount) + parseInt(amount);

        if (parseInt(t_amt) > total_amount) {
          alert('your amount is excess paying amount');
          $('#final_amount' + index).val(0);
        }

        var arr_amt = [];
        var p_amt = [];

        Array_ids.map((val, i) => {
          var dis = $('#' + val.discount).val();
          var amt = parseInt($('#' + val.final_amount).val());

          if (select_discount == 'percent') {
            var val_amt = (total_amount / 100) * dis;
          } else {
            var val_amt = dis;
          }

          $val = parseInt(val_amt) + parseInt(amt);
          arr_amt.push($val);
          p_amt.push(amt);
        });

        var t_amt = sum(arr_amt);
        $('#taxtable_value').val(t_amt);

        if (state_id == 23) {
          $value = parseInt(t_amt) * (18 / 100);
          $value = Math.round($value / 2);
          $('#cgst_value').val($value);
          $('#sgst_value').val($value);
          $('#igst_value').val(0);
        } else {
          $value = parseInt(t_amt) * (18 / 100);
          $value = Math.round($value / 1);
          $('#cgst_value').val(0);
          $('#sgst_value').val(0);
          $('#igst_value').val($value);
        }

        $('#total_amount_value').val(sum(p_amt));
      }

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

      // gettreatmentcatall();

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

      $('#all_payment_list').on('click', function() {
        currentPage = 1; // Reset to first page on filter
        // var tc_id = document.getElementById("treatment_cat_list").value;
        // var t_id = document.getElementById("select_treatment").value;
        var branch_id = $('#branch_name').val();
        // cattreatmentall(id, branch_id)
        all();
      });

      function py_status(id, status) {
        if (status == '1') {
          var payment_status = 0;
        } else {
          var payment_status = 1;
        }
        const token = sessionStorage.getItem('token');
        fetch(base_url + "payment_status/" + id + '?status=' + payment_status, {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
              'Authorization': `Bearer ${token}`,
            },
            method: "get",
          })
          .then((response) => response.json())
          .then((data) => {
            if (data.status == '200') {
              $("#status_success").html("<div class='alert alert-success' role='alert'>Payment Successfully Updated!</div>");
              setTimeout(() => {
                $("#status_success").html("");
              }, 4000);
            }
          });
      }

      var delete_id = '';

      function model(id) {
        $('#payment_delete').modal('show');
        delete_id = id;
      }

      $('#delete').click(function() {
        const token = sessionStorage.getItem('token');
        fetch(base_url + "delete_payment/" + delete_id, {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
              'Authorization': `Bearer ${token}`,
            },
            method: "delete",
          })
          .then((response) => response.json())
          .then((data) => {
            if (data.status == '200') {
              all();
              $("#status_success").html("<div class='alert alert-success' role='alert'>Payment Successfully Deleted!</div>");
              setTimeout(() => {
                $("#status_success").html("");
              }, 4000);
            }
          });
      })

      // ... (Keep all other existing functions like on_print, select_t_Category, etc.)
      // Add this CSS section at the end

      function on_print(id) {
        var branch_id = $('#branch_name').val();
        const token = sessionStorage.getItem('token');
        // fetch(base_url + "edit_payment/" + id, {
        fetch(base_url + "edit_payment/" + id + "?branch_id=" + branch_id, {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
              'Authorization': `Bearer ${token}`,
            },
            method: "get",
          })
          .then(response => response.json())
          .then(data => {
            if (data.status == '200') {
              const payment = data.data.payment;
              const treatment = data.data.treatments;
              const branch = data.data.branch;
              // Check if payment data is available
              if (!payment) {
                console.error("Payment details are missing.");
                return;
              }

              const paymentDetails = payment;

              // Dynamic fields handling with fallback to lead details
              const name = paymentDetails.customer_first_name || `${paymentDetails.lead_first_name} ${paymentDetails.lead_last_name}`;
              const phone = paymentDetails.customer_phone || paymentDetails.lead_phone;
              const email = paymentDetails.customer_email || paymentDetails.lead_email;
              const address = paymentDetails.customer_address || "N/A";

              // GST Calculation
              let gstDetails = '';
              const amt = parseFloat(paymentDetails.amount || 0);
              const state_id = paymentDetails.state_id;

              // if (state_id === 23) {
              //     const sgst = ((amt / 100) * 9).toFixed(2);
              //     const cgst = ((amt / 100) * 9).toFixed(2);
              //     gstDetails = `<tr class='total'><td></td><td>Inc. CGST: ₹${cgst}</td></tr>
              //                   <tr class='total'><td></td><td>Inc. SGST: ₹${sgst}</td></tr>`;
              // } else {
              //     const igst = ((amt * 18) / 100).toFixed(2);
              //     gstDetails = `<tr class='total'><td></td><td>Inc. IGST: ₹${igst}</td></tr>`;
              // }
              const basePrice = Math.round(amt / 1.18);
              const gstAmount = (amt - basePrice).toFixed(2);
              if (state_id === 23) {
                const cgst = (gstAmount / 2).toFixed(2);
                const sgst = (gstAmount / 2).toFixed(2);
                gstDetails = `<tr class='total'><td></td><td>Inc. CGST: ₹${cgst}</td></tr>
                      <tr class='total'><td></td><td>Inc. SGST: ₹${sgst}</td></tr>`;
              } else {
                const igst = gstAmount; // ✅ already string with 2 decimals
                gstDetails = `<tr class='total'><td></td><td>Inc. IGST: ₹${igst}</td></tr>`;
              }

              // Product details
              const products = paymentDetails.products || []; // Fallback to empty arra
              const productsHTML = products.map((product, index) => `
        <tr class='item'>
            <td>${index + 1}</td>
            <td>${product.product_name}</td>
            <td>₹${amt}</td>
        </tr>
    `).join("");
              const treatmentHTML = Array.isArray(treatment) ?
                treatment.map(t => `<p>Customer Service: ${t.treatment_name}</p>`).join('') :
                '<p>Customer Service: N/A</p>';

              // Payment Modes
              const paymentModes = JSON.parse(paymentDetails.payment_status || '[]'); // Fallback to empty array
              // const paymentModesHTML = paymentModes.map(mode => `
              //     <tr class='details'>
              //         <td>${mode.name}</td>
              //         <td>₹${mode.amount}</td>
              //     </tr>
              // `).join("");
              //  const paymentModesHTML = "Cash";
              // Parse the payment_mode JSON string
              const paymentMethods = JSON.parse(paymentDetails.payment_mode);

              // Find the method with the amount > 0 and display the corresponding method
              let paymentMethod = '';
              for (const method in paymentMethods) {
                if (paymentMethods[method] > 0) {
                  paymentMethod = method.charAt(0).toUpperCase() + method.slice(1); // Capitalize the first letter
                  break;
                }
              }

              // Display the payment method in the HTM
              const paymentMethodHTML = `<td>Payment Method: ${paymentMethod}</td>`;
              // HTML Content
              const receiptHTML = `
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>PAYMENT RECEIPT</title>
        <style>
            .invoice-box { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #eee; font-family: Arial, sans-serif; color: #555; }
            .invoice-box table { width: 100%; line-height: inherit; text-align: left; }
            .invoice-box table td { padding: 5px; vertical-align: top; }
            .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
            .invoice-box table tr.item td { border-bottom: 1px solid #eee; }
            .invoice-box table tr.total td { border-top: 2px solid #eee; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class="invoice-box">
            <h2 align="center">PAYMENT RECEIPT</h2>
            <hr>
            <table>
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    <img src="https://crm.renewhairandskincare.com/assets/logo/renew_1.png" style="width:100px;" />
                                    <h3>Renew Plus Hair and Skin Care</h3>
                                    <p>${branch.branch_location}, ${branch.branch_name},India</p>
                                    <p>+91 ${branch.branch_phone} | Email: ${branch.branch_email}</p>
                                </td>
                                <td>
                                    Receipt #: ${paymentDetails.invoice_no}<br>
                                    Date: ${paymentDetails.payment_date}<br>
                                    Total Amount: ₹${amt}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    <h4>Billed To:</h4>
                                    <p>Name: ${name}</p>
                                    <p>Phone: ${phone}</p>
                                    <p>Email: ${email}</p>
                                    <p>Address: ${address}</p>
                                     ${treatmentHTML}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="heading">
                    ${paymentMethodHTML}
                    <td>Amount</td>
                </tr>
             
                <tr class="heading">
                    <td>Description</td>
                    <td>Price (Without GST): ₹${basePrice}</td>
                </tr>
                ${productsHTML}
                ${gstDetails}
                <tr class="total">
                    <td></td>
                    <td>Total: ₹${amt}</td>
                </tr>
            </table>
            <p align="center">Thank you for your business!</p>
        </div>
    </body>
    </html>`;

              // Print the receipt
              const newWindow = window.open('', 'Print-Window');
              newWindow.document.open();
              newWindow.document.write(receiptHTML);
              newWindow.document.close();
              newWindow.print();
            }




          });
      }
    }

    function sum(arr) {
      return arr.reduce(function(a, b) {
        return a + b;
      }, 0);
    }

    // Add CSS for pagination
    document.addEventListener('DOMContentLoaded', function() {
      const style = document.createElement('style');
      style.textContent = `
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
        `;
      document.head.appendChild(style);
    });
  </script>
</body>

</html>
@endsection

