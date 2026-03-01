@extends('layouts.app')

@section('content')
<?php include "common.php"; ?>
<!-- <body onload="startTime()"> -->

<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </fecolormatrix>
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
        <?php include "header.php"; ?>
        <!-- Page Header Ends-->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <?php include "sidebar.php"; ?>
            <!-- Page Sidebar Ends-->

            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3>Add Role</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="role_permission">Role Lists</a></li>
                                    <li class="breadcrumb-item">Add Role</li>
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
                                    <div class="row mb-3">
                                        <div class="col-lg-4 position-relative">
                                            <label class="form-label"><span style="font-size:17px;">Role
                                                    Name</span></label>
                                            <input class="form-control" type="text" placeholder="Role" id="pr_role_name"
                                                readonly>
                                        </div>
                                        <div class="col-lg-4 position-relative">

                                        </div>
                                        <div class="col-lg-4 position-relative">
                                            <!-- need to checkbox select all -->
                                            <label class="form-label"><span style="font-size:17px;">Select
                                                    All</span></label>
                                            <input class="checkbox_animated setting_checkbox" type="checkbox"
                                                placeholder="Select All" id="select_all">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="default-according style-1" id="accordion">
                                            <div class="card">
                                                <div class="card-header" id="headingOne">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_one" aria-expanded="false"
                                                            aria-controls="collapseOne">
                                                            <h6 class=" form-label">Dashboard</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_one" aria-labelledby="headingOne"
                                                    data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated dashboard_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="dashboard_list">List</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated dashboard_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="dashboard_view">View</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingtwo">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_two" aria-expanded="false"
                                                            aria-controls="collapsetwo">
                                                            <h6 class=" form-label">Lead</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_two" aria-labelledby="headingtwo"
                                                    data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated lead_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="lead_list">List</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated lead_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="lead_add">Add</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated lead_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="lead_edit">Edit</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated lead_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="lead_view">View</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated lead_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="lead_delete">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingtwo">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_twos" aria-expanded="false"
                                                            aria-controls="collapsetwos">
                                                            <h6 class=" form-label">Followup</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_twos"
                                                    aria-labelledby="headingtwos" data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated followup_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="followup_list">List</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated followup_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="followup_add">Add</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated followup_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="followup_edit">Edit</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated followup_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="followup_view">View</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated followup_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="followup_delete">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingthree">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_three" aria-expanded="false"
                                                            aria-controls="collapsethree">
                                                            <h6 class=" form-label">Customer</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_three"
                                                    aria-labelledby="headingthree" data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated customer_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="customer_list">List</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated customer_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="customer_add">Add</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated customer_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="customer_edit">Edit</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated customer_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="customer_view">View</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated customer_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="customer_delete">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingfour">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_fours" aria-expanded="false"
                                                            aria-controls="collapsefour">
                                                            <h6 class=" form-label">Customer Treatment</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_fours"
                                                    aria-labelledby="headingfours" data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated customer_treatment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title=""
                                                                        id="customer_treatment_list">List</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated customer_treatment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="customer_treatment_add">Add</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated customer_treatment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title=""
                                                                        id="customer_treatment_edit">Edit</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated customer_treatment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title=""
                                                                        id="customer_treatment_view">View</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated customer_treatment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title=""
                                                                        id="customer_treatment_delete">Delete</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated customer_treatment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title=""
                                                                        id="customer_treatment_print">Print</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingfour">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_four" aria-expanded="false"
                                                            aria-controls="collapsefour">
                                                            <h6 class=" form-label">Appointment</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_four"
                                                    aria-labelledby="headingfour" data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated appointment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="appointment_list">List</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated appointment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="appointment_add">Add</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated appointment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="appointment_edit">Edit</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated appointment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="appointment_view">View</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated appointment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="appointment_delete">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingfour">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_pay" aria-expanded="false"
                                                            aria-controls="collapsepay">
                                                            <h6 class=" form-label">Customer Payment</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_pay" aria-labelledby="headingpay"
                                                    data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated customer_payment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="customer_payment_list">List</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated customer_payment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="customer_payment_add">Add</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated customer_payment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="customer_payment_edit">Edit</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated customer_payment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="customer_payment_view">View</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated customer_payment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title=""
                                                                        id="customer_payment_delete">Delete</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated customer_payment_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title=""
                                                                        id="customer_payment_print">Print</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingfive">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_fives" aria-expanded="false"
                                                            aria-controls="collapsefive">
                                                            <h6 class=" form-label">Consultation</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_fives"
                                                    aria-labelledby="headingfives" data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated consultation_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="consultation_list">List</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated consultation_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="consultation_add">Add</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated consultation_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="consultation_edit">Edit</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated consultation_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="consultation_view">View</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated consultation_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="consultation_delete">Delete</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input
                                                                        class="checkbox_animated consultation_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="consultation_print">Print</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingfive">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_sales" aria-expanded="false"
                                                            aria-controls="collapsesales">
                                                            <h6 class=" form-label">Sales</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_sales"
                                                    aria-labelledby="headingsales" data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated sales_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="sales_list">List</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated sales_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="sales_add">Add</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated sales_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="sales_edit">Edit</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated sales_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="sales_view">View</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated sales_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="sales_delete">Delete</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated sales_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="sales_print">Print</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingfive">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_in" aria-expanded="false"
                                                            aria-controls="collapsefive">
                                                            <h6 class=" form-label">Invoice</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_in" aria-labelledby="headingin"
                                                    data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated invoice_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="invoice_list">List</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated invoice_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="invoice_add">Add</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated invoice_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="invoice_edit">Edit</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated invoice_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="invoice_view">View</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated invoice_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="invoice_delete">Delete</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated invoice_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="invoice_print">Print</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingeight">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_eight" aria-expanded="false"
                                                            aria-controls="collapseeight">
                                                            <h6 class=" form-label">Inventory</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_eight"
                                                    aria-labelledby="headingeight" data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated inventory_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="inventory_list">List</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated inventory_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="inventory_add">Add</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated inventory_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="inventory_edit">Edit</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated inventory_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="inventory_view">View</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated inventory_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="inventory_delete">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingfive">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_five" aria-expanded="false"
                                                            aria-controls="collapsefive">
                                                            <h6 class=" form-label">Staff</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_five"
                                                    aria-labelledby="headingfive" data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="staff_list">List</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated staff_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="staff_add">Add</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated staff_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="staff_edit">Edit</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated staff_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="staff_view">View</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated staff_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="staff_delete">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingsix">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_six" aria-expanded="false"
                                                            aria-controls="collapsesix">
                                                            <h6 class=" form-label">Attendance</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_six" aria-labelledby="headingsix"
                                                    data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated attendance_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="attendance_list">List</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated attendance_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="attendance_add">Add</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated attendance_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="attendance_edit">Edit</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated attendance_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="attendance_view">View</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated attendance_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="attendance_delete">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="card">
                          <div class="card-header" id="headingsevan">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon_sevan" aria-expanded="false" aria-controls="collapsesevan"><h6 class=" form-label">Payment</h6></button>
                            </h5>
                          </div>
                          <div class="collapse" id="collapseicon_sevan" aria-labelledby="headingsevan" data-bs-parent="#accordion">
                            <div class="card-body">
                              <div class="row mb-3">
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated setting_checkbox" type="checkbox" data-bs-original-title="" title="" id="payment_list">List</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated setting_checkbox" type="checkbox" data-bs-original-title="" title="" id="payment_add">Add</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated setting_checkbox" type="checkbox" data-bs-original-title="" title="" id="payment_edit">Edit</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated setting_checkbox" type="checkbox" data-bs-original-title="" title="" id="payment_view">View</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated setting_checkbox" type="checkbox" data-bs-original-title="" title="" id="payment_delete">Delete</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div> -->
                                            <div class="card">
                                                <div class="card-header" id="headingnine">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_nine" aria-expanded="false"
                                                            aria-controls="collapsenine">
                                                            <h6 class=" form-label">Report</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_nine"
                                                    aria-labelledby="headingnine" data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Lead Report</h6>
                                                            </div>
                                                            <!-- <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated setting_checkbox" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div> -->
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="lead_rpt_list">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="lead_rpt_view">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="lead_rpt_export">Export</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Appointment Report</h6>
                                                            </div>
                                                            <!-- <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated setting_checkbox" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated setting_checkbox" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div> -->
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="appointment_rpt_list">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="appointment_rpt_view">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title=""
                                                                        id="appointment_rpt_export">Export</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Stock Report</h6>
                                                            </div>
                                                            <!-- <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated setting_checkbox" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated setting_checkbox" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div> -->
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="stock_rpt_list">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="stock_rpt_view">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="stock_rpt_export">Export</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Attendance Report</h6>
                                                            </div>
                                                            <!-- <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated setting_checkbox" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated setting_checkbox" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div> -->
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="attendance_rpt_list">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="attendance_rpt_view">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title=""
                                                                        id="attendance_rpt_export">Export</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Payments Report</h6>
                                                            </div>
                                                            <!-- <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated setting_checkbox" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated setting_checkbox" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div> -->
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="payment_rpt_list">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="payment_rpt_view">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated report_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" id="payment_rpt_export">Export</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingten">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon_ten" aria-expanded="false"
                                                            aria-controls="collapseten">
                                                            <h6 class=" form-label">Settings</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon_ten" aria-labelledby="headingten"
                                                    data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">General Setting</h6>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="general_setting"
                                                                        id="st_general_setting_list" value="list"
                                                                        onchange="change(this)">List</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Department</h6>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="department"
                                                                        id="st_department_list" value="list"
                                                                        onchange="change(this)">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="department"
                                                                        id="st_department_add" value="add"
                                                                        onchange="change(this)">Add</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="department"
                                                                        id="st_department_edit" value="edit"
                                                                        onchange="change(this)">Edit</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="department"
                                                                        id="st_department_view" value="view"
                                                                        onchange="change(this)">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="department"
                                                                        id="st_department_delete" value="delete"
                                                                        onchange="change(this)">Delete</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Designation</h6>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="designation"
                                                                        id="st_designation_list" value="list"
                                                                        onchange="change(this)">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="designation"
                                                                        id="st_designation_add" value="add"
                                                                        onchange="change(this)">Add</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="designation"
                                                                        id="st_designation_edit" value="edit"
                                                                        onchange="change(this)">Edit</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="designation"
                                                                        id="st_designation_view" value="view"
                                                                        onchange="change(this)">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="designation"
                                                                        id="st_designation_delete" value="delete"
                                                                        onchange="change(this)">Delete</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Brand</h6>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="brand" id="st_brand_list"
                                                                        value="list"
                                                                        onchange="change(this)">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="brand" id="st_brand_add"
                                                                        value="add" onchange="change(this)">Add</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="brand" id="st_brand_edit"
                                                                        value="edit"
                                                                        onchange="change(this)">Edit</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="brand" id="st_brand_view"
                                                                        value="view"
                                                                        onchange="change(this)">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="brand" id="st_brand_delete"
                                                                        value="delete"
                                                                        onchange="change(this)">Delete</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Lead Source</h6>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="lead_source"
                                                                        id="st_lead_source_list" value="list"
                                                                        onchange="change(this)">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="lead_source"
                                                                        id="st_lead_source_add" value="add"
                                                                        onchange="change(this)">Add</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="lead_source"
                                                                        id="st_lead_source_edit" value="edit"
                                                                        onchange="change(this)">Edit</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="lead_source"
                                                                        id="st_lead_source_view" value="view"
                                                                        onchange="change(this)">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="lead_source"
                                                                        id="st_lead_source_delete" value="delete"
                                                                        onchange="change(this)">Delete</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Lead Status</h6>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="lead_status"
                                                                        id="st_lead_status_list" value="list"
                                                                        onchange="change(this)">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="lead_status"
                                                                        id="st_lead_status_add" value="add"
                                                                        onchange="change(this)">Add</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="lead_status"
                                                                        id="st_lead_status_edit" value="edit"
                                                                        onchange="change(this)">Edit</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="lead_status"
                                                                        id="st_lead_status_view" value="view"
                                                                        onchange="change(this)">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="lead_status"
                                                                        id="st_lead_status_delete" value="delete"
                                                                        onchange="change(this)">Delete</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Product</h6>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="product" id="st_product_list"
                                                                        value="list"
                                                                        onchange="change(this)">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="product" id="st_product_add"
                                                                        value="add" onchange="change(this)">Add</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="product" id="st_product_edit"
                                                                        value="edit"
                                                                        onchange="change(this)">Edit</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="product" id="st_product_view"
                                                                        value="view"
                                                                        onchange="change(this)">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="product" id="st_product_delete"
                                                                        value="delete"
                                                                        onchange="change(this)">Delete</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Product Category</h6>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="product_category"
                                                                        id="st_product_category_list" value="list"
                                                                        onchange="change(this)">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="product_category"
                                                                        id="st_product_category_add" value="add"
                                                                        onchange="change(this)">Add</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="product_category"
                                                                        id="st_product_category_edit" value="edit"
                                                                        onchange="change(this)">Edit</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="product_category"
                                                                        id="st_product_category_view" value="view"
                                                                        onchange="change(this)">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="product_category"
                                                                        id="st_product_category_delete" value="delete"
                                                                        onchange="change(this)">Delete</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Treatment</h6>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="treatment" id="st_treatment_list"
                                                                        value="list"
                                                                        onchange="change(this)">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="treatment" id="st_treatment_add"
                                                                        value="add" onchange="change(this)">Add</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="treatment" id="st_treatment_edit"
                                                                        value="edit"
                                                                        onchange="change(this)">Edit</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="treatment" id="st_treatment_view"
                                                                        value="view"
                                                                        onchange="change(this)">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="treatment"
                                                                        id="st_treatment_delete" value="delete"
                                                                        onchange="change(this)">Delete</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Treatment Category</h6>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="treatment_category"
                                                                        id="st_treatment_category_list" value="list"
                                                                        onchange="change(this)">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="treatment_category"
                                                                        id="st_treatment_category_add" value="add"
                                                                        onchange="change(this)">Add</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="treatment_category"
                                                                        id="st_treatment_category_edit" value="edit"
                                                                        onchange="change(this)">Edit</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="treatment_category"
                                                                        id="st_treatment_category_view" value="view"
                                                                        onchange="change(this)">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="treatment_category"
                                                                        id="st_treatment_category_delete" value="delete"
                                                                        onchange="change(this)">Delete</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <h6 class=" form-label">Role</h6>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="role" id="st_role_list"
                                                                        value="list"
                                                                        onchange="change(this)">List</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="role" id="st_role_add"
                                                                        value="add" onchange="change(this)">Add</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="role" id="st_role_edit"
                                                                        value="edit"
                                                                        onchange="change(this)">Edit</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="role" id="st_role_view"
                                                                        value="view"
                                                                        onchange="change(this)">View</label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="d-block">
                                                                    <input class="checkbox_animated setting_checkbox"
                                                                        type="checkbox" data-bs-original-title=""
                                                                        title="" name="role" id="st_role_delete"
                                                                        value="delete"
                                                                        onchange="change(this)">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="card-footer text-end">
                                            <button class="btn btn-secondary" type="button"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button class="btn btn-primary" type="submit" id="add_permission">
                                                Submit
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true" style="display: none;"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            // Function to handle select all checkboxes for a specific section
            function setupSelectAll(selectAllId, checkboxClass) {
                const selectAllCheckbox = document.getElementById(selectAllId);
                const checkboxes = document.querySelectorAll(`.${checkboxClass}`);
                // Set up the "Select All" checkbox
                selectAllCheckbox.addEventListener('change', function() {
                    const isChecked = this.checked; // Get the state of the Select All checkbox
                    checkboxes.forEach(checkbox => {
                        checkbox.checked =
                        isChecked; // Set each checkbox to the state of the Select All checkbox
                    });
                });

                // Set up individual checkboxes to update the Select All checkbox
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        // If any checkbox is unchecked, uncheck the Select All checkbox
                        if (!this.checked) {
                            selectAllCheckbox.checked = false; // Uncheck the Select All checkbox
                        } else {
                            // Check if all checkboxes are checked
                            const allChecked = Array.from(checkboxes).every(checkbox => checkbox
                                .checked);
                            selectAllCheckbox.checked =
                            allChecked; // Check the Select All checkbox if all are checked
                        }
                    });
                });
            }


            // Set up Select All functionality for Dashboard section
            setupSelectAll('select_all', 'dashboard_checkbox');
            setupSelectAll('select_all', 'lead_checkbox');
            setupSelectAll('select_all', 'followup_checkbox');
            setupSelectAll('select_all', 'customer_checkbox');
            setupSelectAll('select_all', 'customer_treatment_checkbox');
            setupSelectAll('select_all', 'appointment_checkbox');
            setupSelectAll('select_all', 'customer_payment_checkbox');
            setupSelectAll('select_all', 'consultation_checkbox');
            setupSelectAll('select_all', 'sales_checkbox');
            setupSelectAll('select_all', 'invoice_checkbox');
            setupSelectAll('select_all', 'inventory_checkbox');
            setupSelectAll('select_all', 'staff_checkbox');
            setupSelectAll('select_all', 'attendance_checkbox');
            setupSelectAll('select_all', 'report_checkbox');
            setupSelectAll('select_all', 'setting_checkbox');
            </script>

            <!-- footer start-->
            <?php include "footer.php"; ?>
            <!-- footer start-->
        </div>
    </div>
    <?php include "script.php"; ?>
    
    @include('api.api_permission')
    <!-- login js-->
    <!-- Plugin used-->
</body>

</html>
@endsection


