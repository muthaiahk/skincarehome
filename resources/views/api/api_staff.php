<script>
    var a = sessionStorage.getItem('token');
    if (!a) {
        window.location.href = "./index";
    } else {
        var base_url = window.location.origin + '/api/';
        var permission = '';
        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);
        // permission_page("staff");

        // function permission_page(name){

        //     fetch(base_url+"role_permission_page/"+name, {
        //         headers: {
        //             "Content-Type": "application/x-www-form-urlencoded",
        //             'Authorization': `Bearer ${token}`, // notice the Bearer before your token
        //         },
        //         method: "get",
        //     })
        //     .then((response) => response.json())
        //     .then((data) => {

        //         if(data.status == '200'){


        //             permission = data.data.permission;


        //         }
        //     });

        // }


        getroleall();

        function getroleall() {



            const token = sessionStorage.getItem('token');

            fetch(base_url + "role", {
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

                            var htmlhead = "<option value='0'>Select Role</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0' && value[i].role_id != 1) {
                                    htmlString += "<option value=" + value[i].role_id + ">" + value[i].role_name + "</option>";
                                }
                            }
                            var htmlfooter = "";

                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#role_name").html(htmlstringall);


                        }


                    }
                });
        }


        getbranchall(branch_id);

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

        permission_page("staff").then(() => {
            try {
                // console.log(permission);

                if (sessionStorage.getItem('role') == 1) {
                    branch_id = 'all'
                    all(id = 0, branch_id, permission);
                } else {
                    all(id = 0, branch_id[1], permission);
                }
                // all(id=0,branch_id[1],permission);
            } catch (error) {
                console.error(error);
            }
        });
        console.log(permission);

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

                        // function sel_status(value){
                        //         if(value == id){ return 'selected';}else{ return '';}
                        //     }
                        function sel_status(value) {
                            // const = branch_id.length == 0
                            // const branc_ids =branch_id;
                            // if (value ==branch_id[1] ) {
                            //     return 'selected';
                            // } else {
                            //     return '';
                            // }
                            if (sessionStorage.getItem('role') == 1) {
                                if (value == 'all') {
                                    return 'selected';
                                } else {
                                    return '';
                                }
                            } else {
                                if (value == branch_id[1]) {
                                    return 'selected';
                                } else {
                                    return '';
                                }

                            }
                        }
                        if (data.data) {

                            const value = data.data;
                            var htmlString = "";

                            var htmlhead = "<option value='all' " + sel_status('all') + ">All Branch</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0') {
                                    htmlString += "<option value='" + value[i].branch_id + "'" + sel_status(value[i].branch_id) + ">" + value[i].branch_name + "</option>";
                                    // htmlString += "<option value="+value[i].branch_id+">"+ value[i].branch_name + "</option>"
                                }
                            }

                            var htmlfooter = "";

                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#branch_name").html(htmlstringall);

                            if (sessionStorage.getItem('role') > 2) {
                                $('#branch_name').prop('disabled', true);
                                $('.form-select').css('background-image', '');

                            }
                        }


                    }
                });
        }
        getdeprtmentall();

        function getdeprtmentall() {



            const token = sessionStorage.getItem('token');

            fetch(base_url + "department", {
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

                            var htmlhead = "<option value='0'>Select Department</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0') {
                                    htmlString += "<option value=" + value[i].department_id + ">" + value[i].department_name + "</option>"
                                }
                            }

                            var htmlfooter = "";

                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#department_name").html(htmlstringall);


                        }


                    }
                });
        }

        getdesgall();

        function getdesgall() {



            const token = sessionStorage.getItem('token');

            fetch(base_url + "designation", {
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

                            var htmlhead = "<option value='0'>Select Designation</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0') {
                                    htmlString += "<option value=" + value[i].job_id + ">" + value[i].designation + "</option>"
                                }
                            }

                            var htmlfooter = "";

                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#designation_name").html(htmlstringall);




                        }


                    }
                });
        }


        function filter_deprt() {
            var id = document.getElementById("department_name").value;
            var branch_id = $('#branch_name').val();
            all(id, branch_id, permission);
        }
        // $('#all_staff_list').on('click', function() {


        //     var branch_id = $('#branch_name').val();

        //     all(branch_id);

        // });

        if (sessionStorage.getItem('role') == 1) {
            branch_id == 'all'
            all(id = 0, branch_id);
        } else {
            all(id = 0, branch_id[1]);
        }
        // all(id=0,branch_id[1]);

        function all(id, branch_id, permission = '') {

            const token = sessionStorage.getItem('token');

            // if(branch_id == 'all'){


            //     var branch_ids = sessionStorage.getItem('branch_id');

            //     var branch_id_all = JSON.parse(branch_ids);

            //     data = "&department_id=" + id + "&branch_id=" + branch_id_all;
            // }else{
            //     data = "&department_id=" + id + "&branch_id=" + branch_id;
            // }

            data = "&department_id=" + id + "&branch_id=" + branch_id;

            fetch(base_url + "staff?" + data, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {

                    if (data.status == '200') {

                        //document.getElementById("company_name").value = sessionStorage.getItem('company');

                        if (data.data) {

                            const value = data.data;
                            var htmlString = "";

                            var htmlhead = "<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Staff Name</th><th>Department</th><th>Email/Mobile</th><th>Status</th><th>Action</th></tr></thead><tbody>";

                            for (var i = 0; i < value.length; i++) {


                                var status = '';
                                if (value[i].status == '0') {
                                    var status = 'checked';
                                }

                                var action = "";

                                if (permission) {
                                    console.log(permission, 'first')

                                    var cama = stringHasTheWhiteSpaceOrNot(permission);
                                    if (cama) {
                                        var values = permission.split(",");
                                        if (values.length > 0) {
                                            var add = include(values, 'add'); // true
                                            var edit = include(values, 'edit'); // true
                                            var view = include(values, 'view'); // true
                                            var del = include(values, 'delete'); // true

                                            if (add) {
                                                action += "";
                                            } else {
                                                action += "";
                                                // UI BYPASS: $("#add_staff").hide();
                                            }
                                            if (edit) {
                                                action += "<a href='edit_staff?st_id=" + value[i].staff_id + "'" + "><i class='fa fa-edit eyc'></i></a>";
                                            } else {
                                                action += "";
                                            }
                                            if (view) {
                                                action += "<a href='view_staff?st_id=" + value[i].staff_id + "'" + "><i class='fa fa-eye eyc'></i></a>";
                                            } else {
                                                action += "";
                                            }
                                            // if (del) {
                                            //     action += "<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model(" + value[i].staff_id + ")'><i class='fa fa-trash eyc'></i></a>";
                                            // } 
                                            // else {
                                            //     action += "";
                                            // }
                                        }

                                        function include(arr, obj) {
                                            for (var i = 0; i < arr.length; i++) {
                                                if (arr[i] == obj) return true;
                                            }
                                        }

                                    } else {

                                        if (permission) {
                                            $data += "";
                                        } else {
                                            $data += "";
                                        }
                                    }

                                    function stringHasTheWhiteSpaceOrNot(value) {
                                        return value.indexOf(',') >= 0;
                                    }

                                } else {
                                    action = '';
                                }


                                htmlString += "<tr><td>" + [i + 1] + "</td><td>" + value[i].name + "</td><td>" + value[i].department_name + "</td><td>" + value[i].phone_no + "<br>" + value[i].email + "</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' " + status + " onclick='st_status(" + value[i].staff_id + ',' + value[i].status + ")' ><span class='switch-state'></span></label>" + "</td><td>" + action + "</td></tr>";

                            }

                            var htmlfooter = "</tbody></table>";

                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#staff_list").html(htmlstringall);

                            datatable();

                        }


                    }
                });
        }

        function st_status(id, status) {

            if (status == '1') {
                var staff_status = 0;
            } else {
                var staff_status = 1;
            }
            const token = sessionStorage.getItem('token');
            fetch(base_url + "staff_status/" + id + '?status=' + staff_status, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
                })
                .then((response) => response.json())
                .then((data) => {

                    if (data.status == '200') {

                        $("#status_success").html("<div class='alert alert-success' role='alert'>Lead Successfully Updated!</div>");

                        setTimeout(() => {
                            $("#status_success").html("");
                            all(id = 0, branch_id[1]);
                        }, 4000);

                    }
                });

        }


        var delete_id = '';

        function model(id) {

            $('#staff_delete').modal('show');
            delete_id = id;
        }



        $('#delete').click(function() {

            const token = sessionStorage.getItem('token');

            fetch(base_url + "delete_staff/" + delete_id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "delete",
                })
                .then((response) => response.json())
                .then((data) => {

                    if (data.status == '200') {

                        all();

                        $("#status_success").html("<div class='alert alert-success' role='alert'>Staff Successfully Deleted!</div>");

                        setTimeout(() => {
                            $("#status_success").html("");
                        }, 4000);

                    }
                });
        })

        function add_staff() {


            var staff_name = document.getElementById("staff_name").value;
            var staff_dob = document.getElementById("staff_dob").value;
            var staff_gender = document.getElementById("staff_gender").value;
            var staff_email = document.getElementById("staff_email").value;
            var staff_phone = document.getElementById("staff_phone").value;
            var staff_emg_phone = document.getElementById("staff_emg_phone").value;
            var staff_address = document.getElementById("staff_address").value;
            var role_id = document.getElementById("role_name").value;
            var staff_doj = document.getElementById("staff_doj").value;
            var company_name = document.getElementById("company_name").value;
            // var branch_id = document.getElementById("branch_name").value;
            // var branch_id = Array.from(document.getElementById("branch_name").selectedOptions).map(option => option.value);
            var branch_id = Array.from(document.getElementById("branch_name").selectedOptions).map(option => parseInt(option.value));
            var department_id = document.getElementById("department_name").value;
            var designation_id = document.getElementById("designation_name").value;
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            // var branchIdString = JSON.stringify(branch_id);
            // var branchIdNumbers = branch_id.map(Number); // Convert values to numbers
            // var branchIdString = JSON.stringify(branchIdNumbers);
            // console.log(branch_id);

            var branchIdString = JSON.stringify(branch_id);
            // var branch_id = Array.from(document.getElementById("branch_name").selectedOptions).map(option => option.value);
            // var branchIdArray = branch_id.map(id => ({ id }));
            // var branchIdString = JSON.stringify(branchIdArray);
            if (!staff_name) {

                $("#error_staff_name").html("Please fill the input fields");

            } else {
                $("#error_staff_name").html("");
            }


            if (!staff_dob) {

                $("#error_staff_dob").html("Please fill the input fields");

            } else {
                $("#error_staff_dob").html("");
            }

            if (staff_gender == '0') {

                $("#error_staff_gender").html("Please select gender name");

            } else {
                $("#error_staff_gender").html("");
            }


            if (!staff_email) {

                $("#error_staff_email").html("Please fill the input fields");

            } else {
                $("#error_staff_email").html("");
            }


            if (staff_phone.length <= 9) {

                $("#error_staff_phone").html("Please fill the input fields");

            } else {
                $("#error_staff_phone").html("");
            }

            if (staff_emg_phone.length <= 9) {

                $("#error_staff_emg_phone").html("Please fill the input fields");

            } else {
                $("#error_staff_emg_phone").html("");
            }

            if (!staff_address) {

                $("#error_staff_address").html("Please fill the input fields");

            } else {
                $("#error_staff_address").html("");
            }

            if (role_id == '0') {

                $("#error_role_name").html("Please select staff role name");

            } else {
                $("#error_role_name").html("");
            }

            if (!staff_dob) {

                $("#error_staff_doj").html("Please fill the input fields");

            } else {
                $("#error_staff_doj").html("");
            }

            if (branch_id == '0') {

                $("#error_branch_name").html("Please select branch name");

            } else {
                $("#error_branch_name").html("");
            }

            if (department_id == '0') {

                $("#error_department_name").html("Please select department name");

            } else {
                $("#error_department_name").html("");
            }

            // if(designation_id == '0'){

            //     $("#error_designation_name").html("Please select designation name");

            // }else{
            //     $("#error_designation_name").html("");
            // } 

            if (!username) {

                $("#error_username").html("Please fill the input fields");

            } else {
                $("#error_username").html("");
            }

            if (!password) {

                $("#error_password").html("Please fill the input fields");

            } else {
                $("#error_password").html("");
            }


            if (company_name && branchIdString && staff_name && staff_address && staff_phone && staff_emg_phone && staff_email && staff_dob && staff_doj && staff_gender && department_id && designation_id && role_id && username && password) {

                document.getElementById('add_staff').style.pointerEvents = 'none';

                var data = "company_name=" + company_name + "&branch_id=" + branchIdString + "&name=" + staff_name + "&address=" + staff_address + "&phone_no=" + staff_phone + "&emergency_contact=" + staff_emg_phone + "&email=" + staff_email + "&date_of_birth=" + staff_dob + "&date_of_joining=" + staff_doj + "&gender=" + staff_gender + "&dept_id=" + department_id + "&desg_id=" + designation_id + "&role_id=" + role_id + "&username=" + username + "&password=" + password;

                const token = sessionStorage.getItem('token');

                fetch(base_url + "add_staff?" + data, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                        },
                        method: "post",
                    })
                    .then((response) => response.json())
                    .then((data) => {

                        if (data.status == '200') {

                            document.getElementById('add_staff').style.pointerEvents = 'auto';

                            $("#status_success").html("<div class='alert alert-success' role='alert'>Staff Successfully Added!</div>");

                            setTimeout(() => {
                                $("#status_success").html("");
                                window.location.href = "./staff";
                            }, 4000);


                        } else {

                            console.log(data.error_msg.phone_no[0])
                            $("#error_staff_phone").html(data.error_msg.phone_no[0]);
                        }
                    });
            }


        }

        function datatable() {
            $("#advance-1").DataTable({
                // "ordering": false,
                "responsive": true,
                "aaSorting": [],
                "language": {
                    "lengthMenu": "Show _MENU_",
                },
                // dom: 'Bfrtip',
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




        document.getElementById("company_name").value = sessionStorage.getItem('company');

    }
</script>
<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->

