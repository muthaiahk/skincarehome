<script>
    var a = sessionStorage.getItem('token');
    if (!a) {
        window.location.href = "./index";
    } else {
        var base_url = window.location.origin + '/api/';
        var id = <?php if (isset($_GET['l_id'])) echo $_GET['l_id'];
                    else echo "" ?>;


        const token = sessionStorage.getItem('token');
        fetch(base_url + "edit_lead/" + id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
            })
            .then((response) => response.json())
            .then((data) => {

                if (data.status == '200') {

                    if (data.data[0].lead_gender == 1) {
                        var geneder = "male";
                    } else {
                        var geneder = "female";
                    }

                    document.getElementById("company_name").value = data.data[0].company_name;
                    document.getElementById("branch_name").value = data.data[0].branch_name;
                    document.getElementById("staff_name").value = data.data[0].staff_name;
                    document.getElementById("first_name").value = data.data[0].lead_first_name;
                    document.getElementById("last_name").value = data.data[0].lead_last_name;
                    document.getElementById("lead_dob").value = data.data[0].lead_dob;
                    document.getElementById("lead_gender").value = geneder;
                    document.getElementById("lead_age").value = data.data[0].lead_age;
                    document.getElementById("lead_phone").value = data.data[0].lead_phone;
                    document.getElementById("lead_email").value = data.data[0].lead_email;
                    document.getElementById("lead_source_name").value = data.data[0].lead_source_name;
                    document.getElementById("lead_status_name").value = data.data[0].lead_status_name;
                    document.getElementById("enquiry_date").value = data.data[0].enquiry_date;
                    document.getElementById("lead_status_name").value = data.data[0].lead_status_name;
                    document.getElementById("lead_address").value = data.data[0].lead_address;
                    document.getElementById("lead_treatment_name").value = data.data[0].treatment_name;
                    document.getElementById("lead_problem").value = data.data[0].lead_problem;
                    document.getElementById("lead_remark").value = data.data[0].lead_remark;
                    document.getElementById("state_name").value = data.data[0].name;


                    getbranchall(data.data[0].branch_id);
                    getstaffall(data.data[0].staff_id, data.data[0].branch_id);
                    getgenderall(data.data[0].lead_gender);
                    getloansourceall(data.data[0].lead_source_id);
                    getloanstatusall(data.data[0].lead_status_id);
                    gettreatmentall(data.data[0].treatment_id);
                    getstatesall(data.data[0].state_id);

                }
            });

        function update_lead() {

            var company_name = document.getElementById("company_name").value;
            var branch_id = document.getElementById("branch_name").value;
            var staff_id = document.getElementById("staff_name").value;
            var first_name = document.getElementById("first_name").value;
            var last_name = document.getElementById("last_name").value;
            var lead_dob = document.getElementById("lead_dob").value;
            var lead_gender = document.getElementById("lead_gender").value;
            var lead_age = document.getElementById("lead_age").value;
            var lead_phone = document.getElementById("lead_phone").value;
            var lead_email = document.getElementById("lead_email").value;
            var lead_source_id = document.getElementById("lead_source_name").value;
            var enquiry_date = document.getElementById("enquiry_date").value;
            var lead_status_id = document.getElementById("lead_status_name").value;
            var lead_address = document.getElementById("lead_address").value;
            var treatment_id = document.getElementById("lead_treatment_name").value;
            var lead_problem = document.getElementById("lead_problem").value;
            var lead_remark = document.getElementById("lead_remark").value;
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


            if (!lead_dob) {

                $("#error_lead_dob").html("Please fill the input fields");

            } else {
                $("#error_lead_dob").html("");
            }

            if (lead_gender == '0') {

                $("#error_lead_gender").html("Please select gender name");

            } else {
                $("#error_lead_gender").html("");
            }


            if (!lead_age) {

                $("#error_lead_age").html("Please select age");

            } else {
                $("#error_lead_age").html("");
            }


            if (lead_phone.length <= 9) {

                $("#error_lead_phone").html("Please fill the input fields");

            } else {
                $("#error_lead_phone").html("");
            }


            if (!lead_email) {

                $("#error_lead_email").html("Please fill the input fields");

            } else {
                $("#error_lead_email").html("");
            }

            if (lead_source_id == '0') {

                $("#error_source_name").html("Please select Lead Source name");

            } else {
                $("#error_source_name").html("");
            }


            if (!enquiry_date) {

                $("#error_enquiry_date").html("Please fill the input fields");

            } else {
                $("#error_enquiry_date").html("");
            }


            if (lead_status_id == '0') {

                $("#error_lead_status_name").html("Please select lead Status name");

            } else {
                $("#error_lead_status_name").html("");
            }


            if (!lead_address) {

                $("#error_lead_address").html("Please fill the input fields");

            } else {
                $("#error_lead_address").html("");
            }


            if (treatment_id == '0') {

                $("#error_treatment_name").html("Please select treatment name");

            } else {
                $("#error_treatment_name").html("");
            }

            if (state_id == '0') {

                $("#error_state_name").html("Please select State name");

            } else {
                $("#error_state_name").html("");
            }



            if (company_name && branch_id && staff_id && first_name && last_name && lead_dob && lead_gender && lead_age && lead_phone && lead_email && lead_source_id && enquiry_date && lead_status_id && lead_address && treatment_id && state_id) {

                document.getElementById('upd_lead').style.pointerEvents = 'none';

                var data = "company_name=" + company_name + "&branch_id=" + branch_id + "&staff_id=" + staff_id + "&lead_first_name=" + first_name + "&lead_last_name=" + last_name + "&lead_dob=" + lead_dob + "&lead_gender=" + lead_gender + "&lead_age=" + lead_age + "&lead_phone=" + lead_phone + "&lead_email=" + lead_email + "&lead_source_id=" + lead_source_id + "&enquiry_date=" + enquiry_date + "&lead_status_id=" + lead_status_id + "&lead_address=" + lead_address + "&lead_problem=" + lead_problem + "&lead_remark=" + lead_remark + "&treatment_id=" + treatment_id + "&state_id=" + state_id;

                const token = sessionStorage.getItem('token');

                fetch(base_url + "update_lead/" + id + "?" + data, {
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
                                window.location.href = "./lead";
                            }, 3000);



                        } else {
                            $("#error_treatment_name").html(data.error_msg.lead_name[0]);
                            document.getElementById('upd_lead').style.pointerEvents = 'auto';
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

        // function getstaffall(id,branch_id){

        //     const token = sessionStorage.getItem('token');

        //     fetch(base_url+"staff", {
        //             headers: {
        //                 "Content-Type": "application/x-www-form-urlencoded",
        //                 'Authorization': `Bearer ${token}`, // notice the Bearer before your token
        //             },
        //             method: "get",
        //         })
        //             .then((response) => response.json())
        //             .then((data) => {

        //                 if(data.status == '200'){

        //                     if(data.data){

        //                         const value = data.data;
        //                         var htmlString = "";

        //                         var htmlhead ="<option value='0'>Select staff name</option>";

        //                         for(var i = 0; i < value.length  ; i++){

        //                             function sel_status(value){
        //                                 if(value == id){ return 'selected';}else{ return '';}
        //                             }

        //                             if(value[i].status == '0'&& value[i].branch_id.includes(branch_id)){

        //                                 htmlString += "<option value='"+value[i].staff_id+"'"+sel_status(value[i].staff_id)+">"+ value[i].name + "</option>";

        //                             }
        //                         }

        //                         var htmlstringall = htmlhead+htmlString;
        //                         $("#staff_name").html(htmlstringall);


        //                     }


        //                 }
        //             });
        // }


        function getstaffall(id, branch_id) {
            const token = sessionStorage.getItem('token');

            fetch(base_url + "staff", {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "Authorization": `Bearer ${token}`,
                    },
                    method: "GET",
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === '200' && data.data) {
                        const value = data.data;
                        let htmlString = "";
                        const htmlHead = "<option value='0'>Select staff name</option>";

                        // ✅ STEP 1: Normalize branch_id safely
                        if (branch_id === null || branch_id === undefined || branch_id === "" || branch_id === "null") {
                            branch_id = []; // show all staff if no branch filter
                        } else if (typeof branch_id === "string") {
                            try {
                                // Case: '[1,2]'
                                const parsed = JSON.parse(branch_id);
                                branch_id = Array.isArray(parsed) ? parsed : [parsed];
                            } catch {
                                // Case: '1,2,3'
                                branch_id = branch_id.split(",").map(b => b.trim());
                            }
                        } else if (typeof branch_id === "number") {
                            branch_id = [String(branch_id)];
                        } else if (!Array.isArray(branch_id)) {
                            branch_id = [String(branch_id)];
                        }

                        // ✅ Guard before map (final safety)
                        if (!Array.isArray(branch_id)) branch_id = [];
                        branch_id = branch_id.map(b => String(b));

                        // ✅ STEP 2: Loop through staff list
                        for (let i = 0; i < value.length; i++) {
                            const staff = value[i];
                            const isSelected = staff.staff_id == id ? "selected" : "";

                            // Parse staff.branch_id safely
                            let staffBranches = [];
                            if (staff.branch_id) {
                                try {
                                    const parsedStaffBranch = JSON.parse(staff.branch_id);
                                    staffBranches = Array.isArray(parsedStaffBranch) ?
                                        parsedStaffBranch :
                                        [parsedStaffBranch];
                                } catch {
                                    staffBranches = [staff.branch_id];
                                }
                            }

                            // Convert to strings for comparison
                            staffBranches = staffBranches.map(b => String(b));

                            // ✅ STEP 3: Match branch
                            const branchMatch =
                                branch_id.length === 0 || // if no branch filter, show all
                                staffBranches.some(b => branch_id.includes(b));

                            if (staff.status == '0' && branchMatch) {
                                htmlString += `<option value="${staff.staff_id}" ${isSelected}>${staff.name}</option>`;
                            }
                        }

                        // ✅ STEP 4: Render dropdown
                        $("#staff_name").html(htmlHead + htmlString);
                    }
                })
                .catch(err => console.error("Error fetching staff:", err));
        }


        $('#branch_name').change(function() {
            var branch_id = $('#branch_name').val();
            var selectedStaffId = $('#staff_name').val(); // Get selected staff id
            getstaffall(selectedStaffId, branch_id); // Pass selected staff id and branch id
        });

        function getgenderall(value) {



            var gender = [{
                name: 'Male'
            }, {
                name: 'Female'
            }];

            var htmlhead = "<option value='0'>Select Gender name</option>";
            var htmlString = "";

            for (var i = 0; i < gender.length; i++) {


                function sel_status(values) {

                    if (values == value) {
                        return 'selected';
                    } else {
                        return '';
                    }
                }


                htmlString += "<option value='" + ([i + 1]) + "'" + sel_status(([i + 1])) + ">" + gender[i].name + "</option>";

            }

            var htmlstringall = htmlhead + htmlString;
            $("#lead_gender").html(htmlstringall);



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
                            $("#lead_treatment_name").html(htmlstringall);

                        }

                    }
                });
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
    }
</script>
