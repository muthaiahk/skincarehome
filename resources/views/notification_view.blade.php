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
                      <h3>Notification Lists</h3>
                    </div>
                    
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Notification Lists</li>
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
                    <!-- <div class="card-header">
                      <h5>Lead Lists</h5>
                    </div> -->
                    
                    <div  id="status_success">
                     
                    </div> 
                    <div class="card-body">
                      <!-- <div class="row card-header ">
                        <div class="col-md-3">
                            <div  id="dashboard_branch_list">
                              <select class="form-select"  id="branch_name" multiple onchange="selectbranch();">
                                
                              </select>
                              <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-9">
                          <div class=" text-end">
                            <a href="add_lead.php" type="button" class="btn btn-primary" type="submit" data-bs-original-title=""  id="add_lead">Add Lead</a>
                          </div>
                        </div>
                      
                      </div> -->
                      
                      <div class="card-body table-responsive" id="notification_list">
                        
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
    
    
    
    <script>
      $("#lead_lists").kendoTooltip({
        filter: "td",
        show: function(e){
          if(this.content.text() !=""){
            $('[role="tooltip"]').css("visibility", "visible");
          }
        },
        hide: function(){
          $('[role="tooltip"]').css("visibility", "hidden");
        },
        content: function(e){
          var element = e.target[0];
          if(element.offsetWidth < element.scrollWidth){
            return e.target.text();
          }else{
            return "";
          }
        }
      })
    </script>
    <script>
       notification();
   
   function notification() {
       var a = sessionStorage.getItem('token');
       if (!a) {
           window.location.href = "./index";
       } else {
           const token = sessionStorage.getItem('token');
           fetch(base_url + "all_notification", {
                   headers: {
                       "Content-Type": "application/x-www-form-urlencoded",
                       'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                   },
                   method: "get",
               })
               .then((response) => response.json())
               .then((data) => {

                   if (data.status == '200') {

                       if (data.data) {

                           const value = data.data;
                           var htmlString = "";

                           var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Date/Time</th><th>Title</th><th>Content</th><th>Created By</th></tr></thead><tbody>";

                                for(var i = 0; i < value.length  ; i++){

                                    var  status = '';
                                    if(value[i].status == '0'){
                                        var status = 'checked';
                                    }

                                    var action = "";
                                    // console.log(permission)
                                    // if(permission){
                                       

                                    //     var cama=stringHasTheWhiteSpaceOrNot(permission);
                                    //     if(cama){
                                    //         var values = permission.split(",");
                                    //         if(values.length > 0){
                                    //             // var add  = values.includes('add');// true
                                    //             var edit = values.includes('edit');// true
                                    //             var view = values.includes('view'); // true
                                    //             var del  = values.includes('delete'); // true

                                        
                                    //             // if(add){ 
                                                    
                                    //             //     $( "#add_inventory" ).show();
                                                    
                                    //             // }
                                    //             // else{
                                    //             //     $( "#add_inventory" ).hide();
                                    //             // }
                                    //             if(edit){  
                                    //                 action += "<a href='edit_inventory?in_id="+value[i].inventory_id+"'"+"><i class='fa fa-edit eyc'></i></a>";}
                                    //             else{
                                    //                 action += "";}
                                    //             if(view){  
                                    //                 action += "<a href='view_inventory?in_id="+value[i].inventory_id+"'"+"><i class='fa fa-eye eyc'></i></a>";}
                                    //             else{
                                    //                 action += "";}
                                    //             if(del){  
                                    //                 action += "<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model("+value[i].inventory_id +")'><i class='fa fa-trash eyc'></i></a>";}
                                    //             else{
                                    //                 action += "";}
                                    //         }
                                        
                                    //         function include(arr, obj) {
                                    //             for (var i = 0; i < arr.length; i++) {
                                    //                 if (arr[i] == obj) return true;
                                    //             }
                                    //         }

                                    //     } else {

                                    //         if(permission){
                                    //             $data += "";
                                    //         }else{
                                    //             $data += "";
                                    //         }
                                    //     }

                                    //     function stringHasTheWhiteSpaceOrNot(value){
                                    //         return value.indexOf(',') >= 0;
                                    //     }

                                    // }else{
                                    //     action = '';
                                    // }

                                    htmlString += "<tr>"+"<td>" + value[i].created_at + "</td><td>" + value[i].title + "</td><td>" +  value[i].content + "</td><td>" +  value[i].staff_name + "</td></tr>";
                                    
                                }

                                var htmlfooter ="</tbody></table>";
                           
                           var htmlstringall = htmlhead + htmlString + htmlfooter;
                           $("#notification_list").html(htmlstringall);


                       }
                       
                     
                      
                   }
               });
       }
   }
   
   function datatable(){
            $("#advance-1").DataTable({
                            // "ordering": false,
                            "responsive": true,
                            "aaSorting":[],
                            "language": {
                                "lengthMenu": "Show _MENU_",
                            },
                            // dom: 'Bfrtip',
                            "dom":
                                "<'row'" +
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
    </script>
    <!-- <script>
          (function($) 
          {
              $('#basic-3').DataTable();
          })(jQuery);
    </script> -->
    <!-- login js-->
    <!-- Plugin used-->
    @include('api.api_lead')
  </body>
</html>
@endsection


