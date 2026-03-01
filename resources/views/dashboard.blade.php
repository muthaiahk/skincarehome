@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3>Dashboard</h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">
              <i data-feather="home"></i></a></li>
          <li class="breadcrumb-item">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
  <div class="row second-chart-list third-news-update">
    <div class="col-xl-8 xl-100 dashboard-sec box-col-12">
      <div class="card earning-card">
        <div class="card-body p-0">
          <div class="row m-0">
            <div class="col-xl-12 m-0" id="dashboard_list">
              <div class="row m-3">
                <div class="col-lg-9 m-0"></div>
                <div class="col-lg-3 m-0" id="dashboard_branch_list">
                  <label class="form-label">Branch</label>
                  <select class="form-select" id="branch_name" multiple onchange="selectbranch();">
                  </select>
                  <div class="invalid-feedback"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-xl-4 col-lg-12 lg-50 dashboard-sec box-col-12" id="dashboard_lead_list">
      <div class="card earning-card">
        <div class="card-body pb-0">
          <div class="col-xl-4 ps-0 col-md-6 col-sm-6">
            <div class="media p-0">
              <div class="media-left"><i class="icofont icofont-ui-user"></i></div>
              <div class="media-body">
                <h6 class="f-w-600 font-primary">LEADS</h6>
                <h4 class="f-w-500" id='d_lead'></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-xl-4 col-lg-12 lg-50 dashboard-sec box-col-12" id="dashboard_appointment_list">
      <div class="card earning-card">
        <div class="card-body pb-0">
          <div class="col-xl-4 ps-0 col-md-6 col-sm-6">
            <div class="media p-0">
              <div class="media-left"><i class="icofont icofont-ui-note"></i></div>
              <div class="media-body">
                <h6 class="f-w-600 font-primary">APPOINTMENTS</h6>
                <h4 class="f-w-500" id='d_app'></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-xl-4 col-lg-12 lg-50 dashboard-sec box-col-12" id="dashboard_payment_list">
      <div class="card earning-card">
        <div class="card-body pb-0">
          <div class="col-xl-4 ps-0 col-md-6 col-sm-6">
            <div class="media p-0">
              <div class="media-left"><i class="icofont icofont-cur-rupee"></i></div>
              <div class="media-body">
                <h6 class="f-w-600 font-primary">PAYMENTS</h6>
                <h4 class="f-w-500" id='d_payment'></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-xl-8 xl-100 dashboard-sec box-col-12">
      <div class="card earning-card">
        <div class="card-body p-0 chart-block">
          <div class="row m-0">
            <div class="earning-content p-0">
              <div class="row m-0 chart-left">
                <div class="col-xl-4 m-0">
                  <h5>Old vs New Customer Treatments</h5>
                </div>
                <div class="col-xl-1 m-0"></div>
                <div class="col-3">
                  <select class="form-select " id="date_select">
                    <option value=""> - Select -</option>
                    <option value="1"> Yeary </option>
                    <option value="2" selected> Monthly</option>
                    <option value="3"> Customer Range</option>
                  </select>
                </div>
                <div class="col-3 " id="treatment_year1">
                  <select class="form-select " id="treatment_year">
                    <option value="">Select Year</option>
                  </select>
                </div>

                <div class="col-3 d-none" id="monthly">
                  <input type="month" id="treatment_month" class="form-control" value="{{ date('Y-m') }}" max="{{ date('Y-m') }}">
                </div>
                <div class="col-4 d-none" id="customer_range">
                  <div class="input-group input-daterange">
                    <span class="input-group-addon p-2">From</span>
                    <input type="date" id="from_date" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                    <span class="input-group-addon p-2">To</span>
                    <input type="date" id="to_date" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-10 "></div>
                <div class="col-2 ">
                  <button id="goButton" class="btn btn-primary">Go</button>
                </div>
              </div>
            </div>
            <div id="loadingIndicator01" class="text-center">
              <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <p>Loading data, please wait...</p>
            </div>
            <div id="customer_chart"></div>
            <div class="row">
              <figure class="highcharts-figure">
                <div id="comparison_chart"></div>
                <p class="highcharts-description"></p>
              </figure>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-xl-8 xl-100 dashboard-sec box-col-12">
      <div class="card earning-card">
        <div class="card-body p-0 chart-block">
          <div class="row m-0">
            <div class="earning-content p-0">
              <div class="row m-0 chart-left">
                <div class="col-xl-4 m-0">
                  <h5>Female vs Male</h5>
                </div>
                <div class="col-xl-1 m-0"></div>
                <div class="col-3">
                  <select class="form-select " id="date_select_fm">
                    <option value=""> - Select -</option>
                    <option value="1" selected> Yeary </option>
                    <option value="2"> Monthly</option>
                    <option value="3"> Customer Range</option>
                  </select>
                </div>
                <div class="col-3 " id="treatment_year1_fm">
                  <select class="form-select " id="treatment_year_fm">
                    <option value="">Select Year</option>
                  </select>
                </div>

                <div class="col-3 d-none" id="monthly_fm">
                  <input type="month" id="treatment_month_fm" class="form-control" value="{{ date('Y-m') }}" max="{{ date('Y-m') }}">
                </div>
                <div class="col-4 d-none" id="customer_range_fm">
                  <div class="input-group input-daterange">
                    <span class="input-group-addon p-2">From</span>
                    <input type="date" id="from_date_fm" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                    <span class="input-group-addon p-2">To</span>
                    <input type="date" id="to_date_fm" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-10 "></div>
                <div class="col-2">
                  <button type="button" id="" class="btn btn-primary" onclick="goButtonFM_fm()">Go</button>
                </div>
              </div>
            </div>
            <div id="loadingIndicator02" class="text-center">
              <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <p>Loading data, please wait...</p>
            </div>
            <div id="customer_chart_fm"></div>
            <div class="row">
              <figure class="highcharts-figure">
                <div id="comparison_chart_fm"></div>
                <p class="highcharts-description"></p>
              </figure>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-xl-8 xl-100 dashboard-sec box-col-12 mt-10">
      <div class="card earning-card">
        <div class="card-body p-0 chart-block">
          <div class="row m-0">
            <div class="earning-content p-0">
              <div class="row m-0 chart-left">
                <div class="col-xl-4 m-0">
                  <h5>Schedule / Appointment</h5>
                </div>
                <div class="col-xl-3 m-0"></div>
              </div>
            </div>
            <div class="chart-overflow" id="dashboard-chart1"></div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-xl-8 xl-100 dashboard-sec box-col-12">
      <div class="card earning-card">
        <div class="card-body p-0 chart-block">
          <div class="row m-0">
            <div class="earning-content p-0">
              <div class="row m-0 chart-left">
                <div class="col-xl-4 m-0">
                  <h5>Treatments</h5>
                </div>
                <div class="col-xl-3 m-0"></div>
              </div>
            </div>
            <div class="chart-overflow" id="dashboard-chart2"></div>
            <div id="customer_chart"></div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-xl-8 xl-100 dashboard-sec box-col-12 mt-10">
      <div class="card earning-card">
        <div class="card-body p-0 chart-block">
          <div class="row m-0">
             <div class="earning-content p-0">
               <div class="row m-0 chart-left">
                 <div class="col-xl-4 m-0">
                   <h5>Sales / Receipt Report</h5>
                 </div>
                 <div class="col-xl-2 m-0"></div>
                 <div class="col-xl-5 m-0">
                   <div class="input-group input-daterange col-md-4">
                     <input type="date" id="sales_from_date" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                     <span class="input-group-addon p-2">To</span>
                     <input type="date" id="sales_to_date" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                   </div>
                 </div>
                 <div class="col-xl-1 m-0">
                   <span class="btn btn-primary" id="data_filter">Go</span>
                 </div>
               </div>
             </div>
             <div class="card-body">
               <div class="table-responsive product-table" id="sales_list">
               </div>
             </div>
             <div class="chart-overflow" id="dashboard-chart1"></div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- Container-fluid Ends-->
@endsection

@section('scripts')
<script src="{{ asset('api/api_dashboard.js') }}"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
<script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>

<script>
      var option = '<option value="">select Year</option>';
      var date = new Date();
      var year = date.getFullYear();

      var htmlhead = "<option value=''>All</option>";

      var htmlString = "";
      for (var i = year - 4; i <= year; i++) {
        htmlString += "<option value=" + i + ">" + i + "</option>"
      }

      Comparison();
      var htmlstringall = htmlhead + htmlString;
      $("#customer_year").html(htmlstringall);
      $("#appointment_year").html(htmlstringall);
      $("#treatment_year").html(htmlstringall);
      $("#treatment_year_fm").html(htmlstringall);

      $(document).ready(function() {
        var $val = $("#date_select").val();

        if ($val == 1) {
          $("#treatment_year1").removeClass('d-none').addClass('d-block');
          $("#monthly").addClass('d-none');
          $("#customer_range").addClass('d-none');
        } else if ($val == 2) {
          $("#treatment_year1").addClass('d-none');
          $("#monthly").removeClass('d-none').addClass('d-block');
          $("#customer_range").addClass('d-none');
        } else if ($val == 3) {
          $("#treatment_year1").addClass('d-none');
          $("#monthly").addClass('d-none');
          $("#customer_range").removeClass('d-none').addClass('d-block');
        }

        $("#date_select").change(function() {
          $val = $(this).val();

          if ($val == 1) {
            $("#treatment_year1").removeClass('d-none').addClass('d-block');
            $("#monthly").addClass('d-none');
            $("#customer_range").addClass('d-none');
          } else if ($val == 2) {
            $("#treatment_year1").addClass('d-none');
            $("#monthly").removeClass('d-none').addClass('d-block');
            $("#customer_range").addClass('d-none');
          } else if ($val == 3) {
            $("#treatment_year1").addClass('d-none');
            $("#monthly").addClass('d-none');
            $("#customer_range").removeClass('d-none').addClass('d-block');
          }
        });
      });

      $('#goButton').on('click', function() {
        var branch_id = $("#branch_name").val();
        var data = $("#date_select").val();
        var year = $('#treatment_year').val();
        var month = $('#treatment_month').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        Comparison(branch_id, data, year, month, from_date, to_date);
      });

      function Comparison(branch_id, data = "", year = "", month = "", from_date = "", to_date = "") {
        const token = sessionStorage.getItem('token');
        let params = new URLSearchParams();
        params.append('branch_id', branch_id);
        params.append('data', data);
        params.append('year', year);
        params.append('month', month);
        params.append('from_date', from_date);
        params.append('to_date', to_date);

        document.getElementById("loadingIndicator01").style.display = "block";
        document.getElementById("comparison_chart").style.display = "none";

        fetch(base_url + "dashboard_comparison", {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
              'Authorization': `Bearer ${token}`, 
            },
            method: "post",
            body: params
          })
          .then((response) => response.json())
          .then((data) => {
            if (data.status == '200') {
              let catory_list = data.categories;
              let old_new = data.old;
              let new_count = data.new;
              Barchart(catory_list, new_count, old_new);
            }
          })
          .finally(() => {
            document.getElementById("loadingIndicator01").style.display = "none";
            document.getElementById("comparison_chart").style.display = "block";
          });

        fetch(base_url + "dashboard_comparison_fm", {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
              'Authorization': `Bearer ${token}`, 
            },
            method: "post",
            body: params
          })
          .then((response) => response.json())
          .then((data) => {
            if (data.status == '200') {
              let catory_list = data.categories;
              let old_new = data.old;
              let new_count = data.new;
              BarchartFM(catory_list, new_count, old_new);
            }
          });

        fetch(base_url + "dashborad_customer?" + "branch_id=" + branch_id, {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
              'Authorization': `Bearer ${token}`, 
            },
            method: "get"
          })
          .then((response) => response.json())
          .then((data) => {
            if (data.status == '200') {
              arr_value = [];
              if (data.data) {
                var value = data.data;
                for (let i = 1; i <= 12; i++) {
                  arr_value.push(value[i].count);
                }
                linechartcustomer(arr_value);
              }
            }
          });
      }

      ComparisonFM();

      $("#date_select_fm").change(function() {
        $val2 = $(this).val();

        if ($val2 == 1) {
          $("#treatment_year1_fm").removeClass('d-none');
          $("#treatment_year1_fm").addClass('d-block');
          $("#monthly_fm").addClass('d-none');
          $("#customer_range_fm").addClass('d-none');
        } else if ($val2 == 2) {
          $("#treatment_year1_fm").addClass('d-none');
          $("#monthly_fm").removeClass('d-none');
          $("#monthly_fm").addClass('d-block');
          $("#customer_range_fm").addClass('d-none');
        } else if ($val2 == 3) {
          $("#treatment_year1_fm").addClass('d-none');
          $("#monthly_fm").addClass('d-none');
          $("#customer_range_fm").removeClass('d-none');
          $("#customer_range_fm").addClass('d-block');
        }
      });

      function ComparisonFM(branch_id_fm, data = "", year = "", month = "", from_date = "", to_date = "") {
        const token = sessionStorage.getItem('token');
        let params = new URLSearchParams();
        params.append('branch_id', branch_id_fm);
        params.append('data', data);
        params.append('year', year);
        params.append('month', month);
        params.append('from_date', from_date);
        params.append('to_date', to_date);

        document.getElementById("loadingIndicator02").style.display = "block";
        document.getElementById("comparison_chart_fm").style.display = "none"; 

        fetch(base_url + "dashboard_comparison_fm", {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
              'Authorization': `Bearer ${token}`,
            },
            method: "post",
            body: params
          })
          .then((response) => response.json())
          .then((data) => {
            if (data.status == '200') {
              let catory_list_fm = data.categories;
              let old_new_fm = data.male;
              let new_count_fm = data.female;
              BarchartFM(catory_list_fm, new_count_fm, old_new_fm);
            }
          })
          .finally(() => {
            document.getElementById("loadingIndicator02").style.display = "none";
            document.getElementById("comparison_chart_fm").style.display = "block"; 
          });
      }

      Customer();

      function Customer(data = "", year = "", month = "", from_date = "", to_date = "") {
        const token = sessionStorage.getItem('token');
        let params = new URLSearchParams();

        params.append('data', data);
        params.append('year', year);
        params.append('month', month);
        params.append('from_date', from_date);
        params.append('to_date', to_date);

        fetch(base_url + "dashborad_customer", {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
              'Authorization': `Bearer ${token}`,
            },
            method: "get",
            //body: params
          })
          .then((response) => response.json())
          .then((data) => {
            if (data.status == '200') {
              let catory_list = categories;
              let customer = data.data;
              linechartcustomer(catory_list, customer);
            }
          });
      }

      function Barchart(categorylist, new_count, old_count) {
        Highcharts.chart('comparison_chart', {
          chart: { type: 'column' },
          title: { text: 'Customer Treatments', align: 'left' },
          xAxis: { categories: categorylist, crosshair: true },
          yAxis: { min: 0, title: { text: 'Customer Count' } },
          tooltip: { valueSuffix: 'Count' },
          plotOptions: { column: { pointPadding: 0.2, borderWidth: 0 } },
          series: [
            { name: 'Old', data: old_count },
            { name: 'New', data: new_count }
          ]
        });
      }

      function BarchartFM(categorylist, new_count_fm, old_count_fm) {
        Highcharts.chart('comparison_chart_fm', {
          chart: { type: 'column' },
          title: { text: 'Customer Treatments', align: 'left' },
          xAxis: { categories: categorylist, crosshair: true },
          yAxis: { min: 0, title: { text: 'Customer Count' } },
          tooltip: { valueSuffix: 'Count' },
          plotOptions: { column: { pointPadding: 0.2, borderWidth: 0 } },
          series: [
            { name: 'Male', data: old_count_fm, color: 'blue' },
            { name: 'Female', data: new_count_fm, color: 'pink' }
          ]
        });
      }

      function linechartcustomer(customer, categorylist) {
        Highcharts.chart('customer_chart1', {
          chart: { type: 'area' },
          title: { text: 'Customer Chart', align: 'left' },
          xAxis: { categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], crosshair: true },
          yAxis: { min: 0, title: { text: 'Customer Count' } },
          tooltip: { valueSuffix: 'Count' },
          plotOptions: { column: { pointPadding: 0.2, borderWidth: 0 } },
          colors: ["#0071bc", "#f73164"],
          fill: {
            type: 'gradient',
            gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.5, stops: [0, 80, 100] }
          },
          series: [{ name: 'Customer', data: customer }]
        });
      }

      function goButtonFM_fm() {
        var branch_id_fm = $("#branch_name").val();
        var data = $("#date_select_fm").val();
        var yr2 = $('#treatment_year1_fm').val();
        var mn2 = $('#treatment_month_fm').val();
        var from_date2 = $('#from_date_fm').val();
        var to_date2 = $('#to_date_fm').val();
        ComparisonFM(branch_id_fm, data, yr2, mn2, from_date2, to_date2);
      }
</script>
<style>
  .highcharts-figure, .highcharts-data-table table {
    min-width: 100%; max-width: 100%; margin: 1em auto;
  }
  #container { height: 500px; }
</style>
@endsection
