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
                <h3>Inventory Lists</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard">
                      <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Inventory Lists</li>
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
                <div id="status_success">

                </div>
                <div class="card-body">
                  <div class="row card-header ">
                    <div class="col-md-3 position-relative" id="inventory_branch_list">
                      
                      <label class='form-label'>Branch</label>
                      <!-- multiple -->
                      <select class='form-select' id='branch_id' >
                        <option value='0'>Select Branch</option>
                      </select>
                      <div class="text-danger" id="error_branch_id"></div>
                    </div>
                    <div class="col-md-2 position-relative" id="inventory_brand_list">

                      <label class='form-label'>Brand</label>
                      <select class='form-select' id='brand_id'>
                        <option value='0'>Select Brand</option>
                      </select>
                      <div class="text-danger" id="error_brand_id"></div>
                    </div>
                    <div class="col-md-2 position-relative" id="inventory_prod_cat_list">

                      <label class='form-label'>Product Categories</label>
                      <select class='form-select' id='product_category_id'>
                        <option value='0'>Select Category</option>
                      </select>
                      <div class="text-danger" id="error_product_category_id"></div>
                    </div>
                    <div class="col-md-2 position-relative" id="inventory_product_list">
                      <label class='form-label'>Product</label>

                      <select class='form-select' id='product_id'>
                        <option value='0'>Select Product</option>
                      </select>
                      <div class="text-danger" id="error_Product_id"></div>
                    </div>
                    <div class="col-md-3">

                      <div class="text-end">
                        <a href="add_inventory.php" type="button" id="add_inventory" class="btn btn-primary" type="submit" data-bs-original-title="">Add Inventory</a>
                      </div>
                    </div>

                  </div>
                  <div class="card-body">
                    <div class=" display table-responsive product-table" id="inventory_list">

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
  <div class="modal fade" id="inventory_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
  
  
  @include('api.api_inventory')
  <script>
    // $("#inventory_lists").kendoTooltip({
    //   filter: "td",
    //   show: function(e){
    //     if(this.content.text() !=""){
    //       $('[role="tooltip"]').css("visibility", "visible");
    //     }
    //   },
    //   hide: function(){
    //     $('[role="tooltip"]').css("visibility", "hidden");
    //   },
    //   content: function(e){
    //     var element = e.target[0];
    //     if(element.offsetWidth < element.scrollWidth){
    //       return e.target.text();
    //     }else{
    //       return "";
    //     }
    //   }
    // })
  </script>

  <!-- login js-->
  <!-- Plugin used-->
</body>

</html>
@endsection


