<script>
    var a = sessionStorage.getItem('token');
    if (!a) {
        window.location.href = "./index";
    } else {
        var base_url = window.location.origin + '/api/';
        var id = <?php if (isset($_GET['c_id'])) echo $_GET['c_id'];
                    else echo "" ?>;


        const token = sessionStorage.getItem('token');


        fetch(base_url + "edit_customer/" + id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
            })
            .then((response) => response.json())
            .then((data) => {

                if (data.status == '200') {
                    treamentview(data.treatment);
                    appointmentview(data.appointment);
                    paymentview(data.payment);

                    document.getElementById("company_name").value = sessionStorage.getItem('company');


                    document.getElementById("first_name").value = data.data[0].customer_first_name;
                    document.getElementById("last_name").value = data.data[0].customer_last_name;
                    document.getElementById("customer_dob").value = data.data[0].customer_dob;

                    document.getElementById("customer_age").value = data.data[0].customer_age;
                    document.getElementById("customer_phone").value = data.data[0].customer_phone;
                    document.getElementById("customer_email").value = data.data[0].customer_email;

                    document.getElementById("enquiry_date").value = data.data[0].enquiry_date;
                    document.getElementById("customer_address").value = data.data[0].customer_address;

                    document.getElementById("customer_problem").value = data.data[0].customer_problem;
                    document.getElementById("customer_remark").value = data.data[0].customer_remark;

                    document.getElementById("lead_source_name").value = data.data[0].lead_source_id;
                    document.getElementById("lead_status_name").value = data.data[0].lead_status_id;
                    document.getElementById("customer_treatment_name").value = data.data[0].treatment_id;

                    getbranchall(data.data[0].branch_id);
                    getstaffall(data.data[0].staff_id);
                    getgenderall(data.data[0].customer_gender);
                    getstatesall(data.data[0].state_id);

                    // getloansourceall(data.data[0].lead_source_id);
                    // getloanstatusall(data.data[0].lead_status_id);
                    // gettreatmentall(data.data[0].treatment_id);
                    //  all_data(data.data[0]);

                }
            });

        view_data();

        function view_data() {

            fetch(base_url + "edit_customer/" + id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {

                    if (data.status == '200') {



                        //  all_data(data.data[0]);
                        var my_data = data.data[0];
                        var gen = "female";
                        if (data.data[0].customer_gender == 1) {
                            gen = "male"
                        }

                        console.log(my_data);

                        document.getElementById("company_name").value = sessionStorage.getItem('company');
                        document.getElementById("customer_branch_name").value = my_data.branch_name;
                        document.getElementById("customer_staff_name").value = my_data.staff_name;
                        document.getElementById("customer_first_name").value = my_data.customer_first_name;
                        document.getElementById("customer_last_name").value = my_data.customer_last_name;
                        document.getElementById("customer_dob").value = my_data.customer_dob;
                        document.getElementById("customer_gender").value = gen;
                        document.getElementById("customer_age").value = my_data.customer_age;
                        document.getElementById("customer_phone").value = my_data.customer_phone;
                        document.getElementById("customer_email").value = my_data.customer_email;

                        document.getElementById("address").value = data.data[0].customer_address;
                        document.getElementById("state_name").value = data.data[0].state_name;



                    }
                });






        }

        function treamentview(data) {

            var htmlheader = "<table  class='display'  id='treatment_list'><thead><tr><th class='min-w-25px'>Sno</th><th class='min-w-100px'>Treatment Categories</th><th class='min-w-100px'>Treatment Name</th><th class='min-w-100px'>Customer Name</th><th class='min-w-100px'>Treatment STatus</th><th class='min-w-100px'>Invoice</th><th class='min-w-100px'>Amount</th><th class='min-w-100px'>Discount</th><th class='min-w-100px'>Paid Amount</th><th class='min-w-100px'>Balance</th></tr> </thead><tbody>";

            data.map((it, index) => {
                if (it.complete_status === 0) { // Use strict equality to check for number 0
                    var status = "<span class='text-primary'>Progress</span>";
                } else {
                    var status = "<span class='text-success'>Completed</span>";
                }

                htmlheader += "<tr><td>" + (index + 1) + "</td><td>" + it.tc_name + "<br/>" + (it.treatment_auto_id ? it.treatment_auto_id : '') + "</td><td>" + it.treatment_name + "</td><td>" + it.customer_first_name + "</td><td>" + status + "</td><td>" + it.invoice_no + "</td><td>" + it.amount + "</td><td>" + it.discount + "</td><td>" + it.paid_amount + "</td><td>" + it.balance + "</td></td></tr>";
            })

            htmlheader += "</tbody></table>";

            $('#customer_treatment_details_view').html(htmlheader);

            datatable_trm();


        }

        function appointmentview(data) {
            var htmlheader = "<table  class='display'  id='appointment_list'><thead><tr><th class='min-w-25px'>Sno</th><th class='min-w-100px'>Date</th><th class='min-w-100px'>Treatment Name</th><th class='min-w-100px'>Staff Name</th><th class='min-w-100px'>Remarks</th></tr> </thead><tbody>";

            data.map((it, index) => {
                htmlheader += "<tr><td>" + (index + 1) + "</td><td>" + it.date + "</td><td>" + it.treatment_name + "</td><td>" + it.staff_name + "</td><td>" + it.remark + "</td></tr>";
            })

            htmlheader += "</tbody></table>";

            $('#customer_appointment_details_view').html(htmlheader);

            datatable_app();
        }

        function paymentview(data) {
            var htmlheader = "<table  class='display'  id='payment_list'><thead><tr><th class='min-w-25px'>Sno</th><th class='min-w-100px'>Invoice</th><th class='min-w-100px'>Receipt</th><th class='min-w-100px'>Date</th><th class='min-w-100px'>Amount</th><th class='min-w-100px'>Balance</th></tr> </thead><tbody>";

            data.map((it, index) => {
                htmlheader += "<tr><td>" + (index + 1) + "</td><td>" + it.invoice_no + "</td><td>" + it.receipt_no + "</td><td>" + it.payment_date + "</td><td>" + it.amount + "</td><td>" + it.balance + "</td></tr>";
            })

            htmlheader += "</tbody></table>";

            $('#customer_payment_details_view').html(htmlheader);

            datatable_pay();
        }

        function update_customer() {
            var company_name = document.getElementById("company_name").value;
            var branch_id = document.getElementById("branch_name").value;
            var staff_id = document.getElementById("staff_name").value;
            var first_name = document.getElementById("first_name").value;
            var last_name = document.getElementById("last_name").value;
            var customer_dob = document.getElementById("customer_dob").value;
            var customer_gender = document.getElementById("customer_gender").value;
            var customer_age = document.getElementById("customer_age").value;
            var customer_phone = document.getElementById("customer_phone").value;
            var customer_email = document.getElementById("customer_email").value;
            var customer_address = document.getElementById("customer_address").value;

            var lead_source_id = document.getElementById("lead_source_name").value;
            var enquiry_date = document.getElementById("enquiry_date").value;
            var lead_status_id = document.getElementById("lead_status_name").value;
            var treatment_id = document.getElementById("customer_treatment_name").value;
            var customer_problem = document.getElementById("customer_problem").value;
            var customer_remark = document.getElementById("customer_remark").value;
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


            if (!customer_dob) {

                $("#error_customer_dob").html("Please fill the input fields");

            } else {
                $("#error_customer_dob").html("");
            }

            if (customer_gender == '0') {

                $("#error_customer_gender").html("Please select gender name");

            } else {
                $("#error_customer_gender").html("");
            }


            if (!customer_age) {

                $("#error_customer_age").html("Please select age");

            } else {
                $("#error_customer_age").html("");
            }


            if (customer_phone.length <= 9) {

                $("#error_customer_phone").html("Please fill the input fields");

            } else {
                $("#error_customer_phone").html("");
            }


            if (!customer_email) {

                $("#error_customer_email").html("Please fill the input fields");

            } else {
                $("#error_customer_email").html("");
            }

            // if (lead_source_id == '0') {

            //     $("#error_source_name").html("Please select Lead Source name");

            // } else {
            //     $("#error_source_name").html("");
            // }


            if (!enquiry_date) {

                $("#error_enquiry_date").html("Please fill the input fields");

            } else {
                $("#error_enquiry_date").html("");
            }


            // if (lead_status_id == '0') {

            //     $("#error_lead_status_name").html("Please select lead Status name");

            // } else {
            //     $("#error_lead_status_name").html("");
            // }


            if (!customer_address) {

                $("#error_customer_address").html("Please fill the input fields");

            } else {
                $("#error_customer_address").html("");
            }


            // if (treatment_id == '0') {

            //     $("#error_treatment_name").html("Please select treatment name");

            // } else {
            //     $("#error_treatment_name").html("");
            // }

            if (state_id == '0') {

                $("#error_state_name").html("Please select state name");

            } else {
                $("#error_state_name").html("");
            }




            if (company_name && branch_id && staff_id && first_name && last_name && customer_dob && customer_gender && customer_age && customer_phone && customer_email  && enquiry_date  && customer_address && state_id) {

                document.getElementById('upd_customer').style.pointerEvents = 'none';

                var data = "company_name=" + company_name + "&branch_id=" + branch_id + "&staff_id=" + staff_id + "&customer_first_name=" + first_name + "&customer_last_name=" + last_name + "&customer_dob=" + customer_dob + "&customer_gender=" + customer_gender + "&customer_age=" + customer_age + "&customer_phone=" + customer_phone + "&customer_email=" + customer_email + "&lead_source_id=" + 1 + "&enquiry_date=" + enquiry_date + "&lead_status_id=" + 1 + "&customer_address=" + customer_address + "&customer_problem=" + customer_problem + "&customer_remark=" + customer_remark + "&treatment_id=" + treatment_id + "&state_id=" + state_id;

                const token = sessionStorage.getItem('token');

                fetch(base_url + "update_customer/" + id + "?" + data, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                        },
                        method: "get",
                    })
                    .then((response) => response.json())
                    .then((data) => {

                        if (data.status == '200') {



                            $("#status_success").html("<div class='alert alert-success' role='alert'>Customer Successfully Updated!</div>");

                            setTimeout(() => {
                                $("#status_success").html("");
                                window.location.href = "./customer";
                            }, 4000);



                        } else {
                            $("#error_treatment_name").html(data.error_msg.lead_name[0]);
                            document.getElementById('upd_customer').style.pointerEvents = 'auto';
                        }
                    });
            }

        }

        function getbranchall(id) {

            const token = sessionStorage.getItem('token');

            fetch(base_url + "branch", {
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

                            var htmlhead = "<option value='0'>Select Branch</option>";

                            for (var i = 0; i < value.length; i++) {


                                function sel_status(value) {
                                    if (value == id) {
                                        return 'selected';
                                    } else {
                                        return '';
                                    }
                                }

                                if (value[i].status == '0') {

                                    htmlString += "<option value='" + value[i].branch_id + "'" + sel_status(value[i].branch_id) + ">" + value[i].branch_name + "</option>";

                                }
                            }

                            var htmlstringall = htmlhead + htmlString;
                            $("#branch_name").html(htmlstringall);

                            if (sessionStorage.getItem('role') != 1) {
                                $('#branch_name').prop('disabled', true);
                                $('.form-select').css('background-image', '');

                            }
                        }


                    }
                });
        }



        function getstaffall(id) {

            const token = sessionStorage.getItem('token');

            fetch(base_url + "staff", {
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

                            var htmlhead = "<option value='0'>Select staff name</option>";

                            for (var i = 0; i < value.length; i++) {

                                function sel_status(value) {
                                    if (value == id) {
                                        return 'selected';
                                    } else {
                                        return '';
                                    }
                                }

                                if (value[i].status == '0') {

                                    htmlString += "<option value='" + value[i].staff_id + "'" + sel_status(value[i].staff_id) + ">" + value[i].name + "</option>";

                                }
                            }

                            var htmlstringall = htmlhead + htmlString;
                            $("#staff_name").html(htmlstringall);


                        }


                    }
                });
        }



        function getgenderall(value) {


            var gender = ['male', 'female'];

            var htmlhead = "<option value='0'>Select Gender name</option>";
            var htmlString = "";

            //  for(var i = 0; i < gender.length  ; i++){


            function sel_status(values) {
                if (values == value) {
                    return 'selected';
                } else {
                    return '';
                }
            }


            htmlString = "<option value='" + 1 + "'" + sel_status(1) + ">" + "male" + "</option><option value='" + 2 + "'" + sel_status(2) + ">" + "female" + "</option>";

            // }

            var htmlstringall = htmlhead + htmlString;
            $("#customer_gender").html(htmlstringall);



        }


        function getstatesall(id) {



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

                        var htmlhead = "<option value='0'>Select State</option>";

                        for (var i = 0; i < value.length; i++) {

                            function sel_status(value) {
                                if (value == id) {
                                    return 'selected';
                                } else {
                                    return '';
                                }
                            }

                            htmlString += "<option value='" + value[i].state_id + "'" + sel_status(value[i].state_id) + ">" + value[i].name + "</option>";

                        }

                        var htmlstringall = htmlhead + htmlString;
                        $("#state_name").html(htmlstringall);

                    }


                });
        }

        function getloansourceall(id) {

            const token = sessionStorage.getItem('token');

            fetch(base_url + "lead_source", {
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

                            var htmlhead = "<option value='0'>Select Lead Source name</option>";

                            for (var i = 0; i < value.length; i++) {


                                function sel_status(value) {
                                    if (value == id) {
                                        return 'selected';
                                    } else {
                                        return '';
                                    }
                                }

                                if (value[i].status == '0') {

                                    htmlString += "<option value='" + value[i].lead_source_id + "'" + sel_status(value[i].lead_source_id) + ">" + value[i].lead_source_name + "</option>";
                                }
                            }

                            var htmlstringall = htmlhead + htmlString;
                            $("#lead_source_name").html(htmlstringall);


                        }


                    }
                });
        }




        function getloanstatusall(id) {

            const token = sessionStorage.getItem('token');

            fetch(base_url + "lead_status", {
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

                            var htmlhead = "<option value='0'>Select Lead Status</option>";

                            for (var i = 0; i < value.length; i++) {

                                function sel_status(value) {
                                    if (value == id) {
                                        return 'selected';
                                    } else {
                                        return '';
                                    }
                                }

                                if (value[i].status == '0') {
                                    htmlString += "<option value='" + value[i].lead_status_id + "'" + sel_status(value[i].lead_status_id) + ">" + value[i].lead_status_name + "</option>";
                                }
                            }

                            var htmlstringall = htmlhead + htmlString;
                            $("#lead_status_name").html(htmlstringall);

                        }


                    }
                });
        }

        function gettreatmentall(id) {

            const token = sessionStorage.getItem('token');

            fetch(base_url + "treatment", {
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

                            var htmlhead = "<option value='0'>Select Lead Status</option>";

                            for (var i = 0; i < value.length; i++) {

                                function sel_status(value) {
                                    if (value == id) {
                                        return 'selected';
                                    } else {
                                        return '';
                                    }
                                }

                                if (value[i].status == '0') {
                                    htmlString += "<option value='" + value[i].treatment_id + "'" + sel_status(value[i].treatment_id) + ">" + value[i].treatment_name + "</option>";
                                }
                            }

                            var htmlstringall = htmlhead + htmlString;
                            $("#customer_treatment_name").html(htmlstringall);

                        }

                    }
                });
        }


        function datatable_trm() {
            $("#treatment_list").DataTable({
                // "ordering": false,
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

        function datatable_app() {
            $("#appointment_list").DataTable({
                // "ordering": false,
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

        function datatable_pay() {
            $("#payment_list").DataTable({
                // "ordering": false,
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

    }
</script>
