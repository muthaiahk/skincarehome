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
        // UI BYPASS: $("#add_payment").hide();
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

        permission_page("customer_payment").then(() => {
            try {
                console.log(permission);

                all(permission);

            } catch (error) {
                console.error(error);
            }
        });
        gettcategoryall(0);

        function gettcategoryall(id) {
            var attr_index = "";
            const token = sessionStorage.getItem('token');

            fetch(base_url + "customer_treatment_cat/" + id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
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

                            // var htmlhead ="<label class='form-label'>Treatment Categories</label><select class='form-select' id='tc_name' onchange='select_t_Category();'><option value=''>Select Treatment Categories</option>";

                            // for(var i = 0; i < value.length  ; i++){
                            //     if(value[i].status == '0'){

                            //       if(sessionStorage.getItem('treatment_id')){
                            //         if(sessionStorage.getItem('treatment_id') == value[i].treatment_id){
                            //             attr_index = i;

                            //         }
                            //     }

                            //         htmlString += "<div class='row  mb-3'><div class='col-lg-5 position-relative'>  <input class='form-control-plaintext fs-6' type='text' data-bs-original-title=''  id="+"'"+"treatment_name"+[i]+"'"+" placeholder='' name='"+value[i].treatment_id+"' value='"+value[i].treatment_name+"'"+"> <div class='row'><span>Fixed Amount : "+value[i].amount+" ,"+"Discount : "+value[i].discount+" , Paid Amount : "+value[i].pay_amount+" , Balance :"+value[i].balance+"</span></div></div><div class='col-lg-2 position-relative'><input class='form-control-plaintext text-center' type='text' data-bs-original-title=''  id="+"'"+"amount"+[i]+"'"+" placeholder='' value='"+value[i].balance+"'"+"></div><div class='col-lg-3 position-relative'> <div class='row'>                                  <div class='col-lg-4'>                                    <select class='form-select'  id="+"'"+"select_discount"+[i]+"'"+">                                    <option value='rupee' selected>&#8377; </option>                               <option value='percent'>&#37; </option>                                  </select>                                  </div>                                  <div class='col-lg-8'>                                  <input class='form-control' type='text' data-bs-original-title=''   id="+"'"+"discount"+[i]+"'"+" placeholder='' value='0'  onfocusout='discount_enter(event)' name="+"'"+[i]+"'" +">                              </div>                                </div>                              </div>                              <div class='col-lg-2 position-relative'>                                <input class='form-control' type='text' data-bs-original-title=''   id="+"'"+"final_amount"+[i]+"'"+" placeholder='' value='0' onfocusout='payment_enter(event)'  name="+"'"+[i]+"'" +" >   <input class='form-control' type='hidden' data-bs-original-title=''   id="+"'"+"cus_treat_id"+[i]+"'"+" placeholder='' value='"+value[i].cus_treat_id+"'  name="+"'"+[i]+"'" +" >  </div></div>";

                            //     }

                            // }
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

                            // var htmlfooter ="</select><div class='text-danger' id='error_tc_name'></div>";

                            var htmlstringall = htmlString;
                            $("#treatment_details").html(htmlstringall);


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

        // gettreatmentall();

        function gettreatmentall(id) {

            const token = sessionStorage.getItem('token');

            fetch(base_url + "customer_treatment_all/" + id + "?c_id=" + c_id, {
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

                            var htmlhead = "<label class='form-label'>Treatment Name</label><select class='form-select' id='treatment_name' onchange='cutomer_invoice();'><option value=''>Select Treatment Name</option>";

                            for (var i = 0; i < value.length; i++) {
                                if (value[i].status == '0') {
                                    htmlString += "<option value=" + value[i].treatment_id + ">" + value[i].treatment_name + "</option>"
                                }
                            }

                            var htmlfooter = "</select><div class='text-danger' id='error_treatment_name'></div>";

                            var htmlstringall = htmlhead + htmlString + htmlfooter;
                            $("#payment_treatment_list").html(htmlstringall);

                        }


                    }
                });
        }

        getcustomerall();

        function getcustomerall() {

            const token = sessionStorage.getItem('token');

            fetch(base_url + "customer_treatment_list", {
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

            // if(state_id == 23){
            //     $value = parseInt(t_amt)*(18/100);
            //     $value = Math.round($value/2);
            //     $('#cgst_value').val($value);
            //     $('#sgst_value').val($value);
            //     $('#igst_value').val(0);
            // }else{
            //     $value = parseInt(t_amt)*(18/100);
            //     $value = Math.round($value/1);
            //     $('#cgst_value').val(0);
            //     $('#sgst_value').val(0);
            //     $('#igst_value').val($value);
            // }

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

            var discount_type = select_discount === 'percent' ? 2 : 1; // Determine discount type (1 for rupees, 2 for percent)

            console.log('discount_type', discount_type);

            // Set the discount type in the corresponding hidden input
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
            // $value = parseInt(t_amt)*(18/100);
            // $value = Math.round($value/2);
            // $('#cgst_value').val($value);
            // $('#sgst_value').val($value);
            // $('#igst_value').val(parseInt(t_amt)*(18/100));
            $('#total_amount_value').val(sum(p_amt));




        }



        // cutomer_change();

        // function getSelectvalue( selectObj, select ){
        //   document.querySelect( select ).value = selectObj.value;
        // }
        var branch_ids = sessionStorage.getItem('branch_id');
        var branch_id = JSON.parse(branch_ids);
        getbranchall(branch_id);

        function getbranchall(branch_id) {

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

                            // function sel_status(value){
                            //     if(value == id){ return 'selected';}else{ return '';}
                            // }
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

                            var htmlhead = "<option value=''>Select Branch</option>";

                            for (var i = 0; i < value.length; i++) {

                                // if(value[i].status == '0'){
                                //     htmlString += "<option value='"+value[i].branch_id+"'"+sel_status(value[i].branch_id)+">"+ value[i].branch_name + "</option>";

                                //     // htmlString += "<option value="+value[i].branch_id+">"+ value[i].branch_name + "</option>"
                                // }
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

                            //  default branch_id[1] as selected value
                            $("#branch_name").val(branch_id[1]);

                            //  call the all() function AFTER setting value
                            all();

                            // if(sessionStorage.getItem('role') != 1){
                            //     $('#branch_name').prop('disabled', true);
                            //     $('.form-select').css('background-image', '');

                            // }
                        }


                    }
                });
        }


        function cattreatmentall(id = 0) {


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

        gettreatmentall();
        gettreatmentcatall();

        function gettreatmentall() {
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

                            var htmlhead = "<option value='0'>Select Treatment</option>";

                            for (var i = 0; i < value.length; i++) {
                                // if(value[i].status == '0'){
                                htmlString += "<option value=" + value[i].treatment_id + ">" + value[i].treatment_name + "</option>"
                                //}
                            }

                            var htmlstringall = htmlhead + htmlString;
                            $("#treatment_list").html(htmlstringall);

                        }

                    }
                });
        }

        function gettreatmentcatall() {
            const token = sessionStorage.getItem('token');

            fetch(base_url + "treatment_cat", {
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

            var tc_id = document.getElementById("treatment_cat_list").value;
            var t_id = document.getElementById("select_treatment").value;
            var branch_id = $('#branch_name').val();
            cattreatmentall(id, branch_id)
            all(tc_id, t_id, branch_id);

        });

        all();

        

        function all() {

            const token = sessionStorage.getItem('token');

            var branch_id = $('#branch_name').val();
            // var branch_ids = sessionStorage.getItem('branch_id');
            // var branch_id = JSON.parse(branch_ids);
            // var branch_id = branch_id[1];
            var tc_id = $('#treatment_cat_list').val();
            var t_id = $('#select_treatment').val();
            var search_input = $('#search_input').val();


            let params = new URLSearchParams();

            params.append('branch_id', branch_id);
            params.append('tc_id', tc_id);
            params.append('t_id', t_id);
            params.append('search_input', search_input);


            fetch(base_url + "payment", {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "post",
                    body: params
                })
                .then((response) => response.json())
                .then((data) => {

                    // if(data.status == '200'){

                    //     // if(data.data){

                    //     //     const value = data.data;

                    //     //     var htmlString = "";

                    //     //     var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Invoice No</th><th>Receipt No</th><th>Date</th><th>Treatment category</th><th>Treatment</th><th>Customer</th><th>Count of Sitting</th><th>Amount</th><th>Total Amount</th><th>Balance</th><th>Pay Status</th><th>Payment Mode</th><th>Status</th><th>Action</th></tr></thead><tbody>";

                    //     //     for(var i = 0; i < value.length  ; i++){

                    //     //         var  status = '';
                    //     //         if(value[i].status == '0'){
                    //     //             var status = 'checked';
                    //     //         }

                    //     //         $val =[];

                    //     //         $pay_modes = JSON.parse(value[i].payment_status);

                    //     //         $pay_modes.map((menu) =>

                    //     //             {
                    //     //                 if(menu.amount > 0){
                    //     //                     $val.push(menu.name);
                    //     //                 }

                    //     //             });

                    //     //         var mode_off = $val.join(", ");

                    //     //         var action = "";

                    //     //         if(permission){
                    //     //           //  console.log(permission)

                    //     //             var cama=stringHasTheWhiteSpaceOrNot(permission);
                    //     //             if(cama){
                    //     //                 var values = permission.split(",");
                    //     //                 if(values.length > 0){
                    //     //                     var add = values.includes('add');// true
                    //     //                     var edit = values.includes('edit');// true
                    //     //                     var view = values.includes('view'); // true
                    //     //                     var del = values.includes('delete'); // true
                    //     //                     var print = values.includes('print'); // true

                    //     //                     if(add){ 
                    //     //                         $( "#add_payment" ).show();}
                    //     //                     else{
                    //     //                         $( "#add_payment" ).hide();
                    //     //                     }
                    //     //                     if(edit){  
                    //     //                         action += "<a href='edit_payment?pay_id="+value[i].p_id+"'"+"><i class='fa fa-edit eyc'></i></a>";}
                    //     //                     else{
                    //     //                         action += "";}
                    //     //                     if(view){  
                    //     //                         action += "<a href='view_payment?pay_id="+value[i].p_id+"'"+"><i class='fa fa-eye eyc'></i></a>";}
                    //     //                     else{
                    //     //                         action += "";}
                    //     //                     if(del){  
                    //     //                         action += "<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='model("+value[i].p_id +")'><i class='fa fa-trash eyc'></i></a>";}
                    //     //                     else{
                    //     //                         action += "";
                    //     //                     }
                    //     //                     if(print){  
                    //     //                         action += "<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='on_print("+value[i].p_id +")'><i class='fa fa-print eyc'></i></a>";}
                    //     //                     else{
                    //     //                         action += "";
                    //     //                     }
                    //     //                 }

                    //     //                 function include(arr, obj) {
                    //     //                     for (var i = 0; i < arr.length; i++) {
                    //     //                         if (arr[i] == obj) return true;
                    //     //                     }
                    //     //                 }

                    //     //             } else {

                    //     //                 if(permission){
                    //     //                     $data += "";
                    //     //                 }else{
                    //     //                     $data += "";
                    //     //                 }
                    //     //             }

                    //     //             function stringHasTheWhiteSpaceOrNot(value){
                    //     //                 return value.indexOf(',') >= 0;
                    //     //             }

                    //     //         }else{
                    //     //             action = '';
                    //     //         }
                    //     //         var  paid_status = "<span class='bg-success p-1 rounded'>Paid<span>";
                    //     //                 if(value[i].balance > 0){
                    //     //                     paid_status = "<span class='bg-danger p-1 rounded'>Pending<span>";
                    //     //                 }

                    //     //           var invoice = value[i].invoice_no;
                    //     //         if (value[i].invoice_no == null) {
                    //     //             invoice = " ";
                    //     //         }
                    //     //         htmlString += "<tr>"+"<td>" + invoice + "</td><td>" + value[i].receipt_no + "</td><td>" +  value[i].payment_date + "</td><td>" +  value[i].tc_name + "</td><td>"+ value[i].treatment_name + "</td><td>"+ value[i].customer_first_name +'<br/>'+value[i].customer_phone + "</td><td>"+ value[i].sitting_count + "</td><td>"+ value[i].amount + "</td><td>"+ value[i].total_amount+ "</td><td>"+value[i].balance + "</td><td>"+paid_status +"</td><td>"+ mode_off  + "</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' "+status+" onclick='py_status("+value[i].p_id+','+value[i].status+")' ><span class='switch-state'></span></label>" + "</td><td>" +action  + "</td></tr>";

                    //     //     }

                    //     //     var htmlfooter ="</tbody></table>";

                    //     //     var htmlstringall = htmlhead+htmlString+htmlfooter;
                    //     //     $("#payment_list").html(htmlstringall);

                    //     //     datatable();

                    //     //     // var in_id = autoIncrementCustomId(data.numbers.invoice_no);
                    //     //     // var in_id = data.numbers.invoice_no;
                    //     //     // var re_id = autoIncrementreceipt(data.numbers.receipt_no);
                    //     //     //  var in_id = autoIncrementCustomId(data.data[0].invoice_no);
                    //     //     // var re_id = autoIncrementreceipt(data.data[0].receipt_no);
                    //     //     // document.getElementById("invoice_no").value = in_id;
                    //     //     // document.getElementById("receipt_no").value = re_id;

                    //     // }
                    //  if(data.data){

                    //         const value = data.data;

                    //         var htmlString = "";

                    //          var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Date</th><th>Receipt No</th><th>Customer/Lead</th><th>Paid Amount</th><th>Total Amount</th><th>Balance Amount</th><th>Status</th><th>Action</th></tr></thead><tbody>";

                    //         let totalAmount = 0;
                    //         let totalGst = 0;

                    //         for(var i = 0; i < value.length  ; i++){

                    //             var  status = '';
                    //             if(value[i].status == '0'){
                    //                 var status = 'checked';
                    //             }

                    //             $val =[];

                    //             $pay_modes = JSON.parse(value[i].payment_status);

                    //             $pay_modes.map((menu) =>

                    //                 {
                    //                     if(menu.amount > 0){
                    //                         $val.push(menu.name);
                    //                     }

                    //                 });

                    //             var mode_off = $val.join(", ");

                    //             var action = "";

                    //             if(permission){
                    //               //  console.log(permission)

                    //                 var cama=stringHasTheWhiteSpaceOrNot(permission);
                    //                 if(cama){
                    //                     var values = permission.split(",");
                    //                     if(values.length > 0){
                    //                         var add = values.includes('add');// true
                    //                         var edit = values.includes('edit');// true
                    //                         var view = values.includes('view'); // true
                    //                         var del = values.includes('delete'); // true
                    //                         var print = values.includes('print'); // true



                    //                         if(print){  
                    //                             action += "<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='on_print("+value[i].p_id +")'><i class='fa fa-print eyc'></i></a>";}
                    //                         else{
                    //                             action += "";
                    //                         }
                    //                     }

                    //                     function include(arr, obj) {
                    //                         for (var i = 0; i < arr.length; i++) {
                    //                             if (arr[i] == obj) return true;
                    //                         }
                    //                     }

                    //                 } else {

                    //                     if(permission){
                    //                         $data += "";
                    //                     }else{
                    //                         $data += "";
                    //                     }
                    //                 }

                    //                 function stringHasTheWhiteSpaceOrNot(value){
                    //                     return value.indexOf(',') >= 0;
                    //                 }

                    //             }else{
                    //                 action = '';
                    //             }
                    //             var  paid_status = "<span class='bg-success p-1 rounded'>Paid<span>";
                    //                     if(value[i].balance > 0){
                    //                         paid_status = "<span class='bg-danger p-1 rounded'>Pending<span>";
                    //                     }
                    //                     var invoice = value[i].invoice_no;
                    //                     if (value[i].invoice_no == null) {
                    //                         invoice = " ";
                    //                     }
                    //              htmlString += "<tr>"+"<td>" + value[i].payment_date + "</td><td>" + value[i].receipt_no + "</td><td>"+ value[i].customer_first_name +'<br/>'+value[i].customer_phone + "</td><td>"+ value[i].amount + "</td><td>"+ value[i].total_amount+ "</td><td>"+value[i].balance + "</td><td>"+paid_status +"</td><td>" +action  + "</td></tr>";
                    //             totalAmount += parseFloat(value[i].amount);
                    //             totalGst += parseFloat(value[i].total_amount);

                    //         }
                    //           var totalRow = "<tfoot><tr>" +
                    //             "<td colspan='2'><strong>Total</strong></td>" +
                    //             "<td></td>" +
                    //             "<td><strong>" + totalAmount.toFixed(2) + "</strong></td>" +
                    //             "<td><strong>" + totalGst.toFixed(2) + "</strong></td>" +
                    //             "<td></td>" +
                    //             "</tr></tfoot>";

                    //         var htmlfooter ="</tbody></table>";

                    //         var htmlstringall = htmlhead+htmlString+totalRow+htmlfooter;
                    //         $("#payment_list").html(htmlstringall);
                    //         pay_report = htmlstringall;

                    //         datatable();

                    //         // var in_id = autoIncrementCustomId(data.numbers.invoice_no);
                    //         // var in_id = data.numbers.invoice_no;
                    //         // var re_id = autoIncrementreceipt(data.numbers.receipt_no);
                    //         //  var in_id = autoIncrementCustomId(data.data[0].invoice_no);
                    //         // var re_id = autoIncrementreceipt(data.data[0].receipt_no);
                    //         // document.getElementById("invoice_no").value = in_id;
                    //         // document.getElementById("receipt_no").value = re_id;

                    //     }

                    // }
                    if (data.status == '200' && data.data) {
                        const value = data.data;
                        let htmlString = "";

                        const htmlHead = `
        <table class='display' id='advance-1'>
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
            <tbody>
    `;

                        let totalAmount = 0;
                        let totalGst = 0;

                        for (let i = 0; i < value.length; i++) {
                            const item = value[i];

                            const name = item.customer_first_name || item.lead_first_name || "N/A";
                            const phone = item.customer_phone || item.lead_phone || "N/A";
                            const paidStatus = item.balance > 0 ?
                                "<span class='bg-danger p-1 rounded'>Pending</span>" :
                                "<span class='bg-success p-1 rounded'>Paid</span>";

                            const action = `<a href='#' data-bs-toggle='modal' onclick='on_print(${item.p_id})'>
            <i class='fa fa-print eyc'></i>
        </a>`;

                            htmlString += `
            <tr>
                <td>${item.payment_date || "N/A"}</td>
                <td>${item.receipt_no || "N/A"}</td>
                <td>${name}<br/>${phone}</td>
                <td>${item.amount || 0}</td>
                <td>${item.total_amount || 0}</td>
                <td>${item.balance || 0}</td>
                <td>${paidStatus}</td>
                <td>${action}</td>
            </tr>
        `;

                            totalAmount += parseFloat(item.amount || 0);
                            totalGst += parseFloat(item.total_amount || 0);
                        }

                        const totalRow = `
        <tfoot>
            <tr>
                <td colspan='3'><strong>Total</strong></td>
                <td><strong>${totalAmount.toFixed(2)}</strong></td>
                <td><strong>${totalGst.toFixed(2)}</strong></td>
                <td colspan='2'></td>
            </tr>
        </tfoot>
    `;

                        const htmlFooter = "</tbody></table>";

                        const fullHtml = htmlHead + htmlString + totalRow + htmlFooter;
                        $("#payment_list").html(fullHtml);

                        // Initialize DataTable if required
                        if (typeof datatable === "function") {
                            datatable();
                        }
                    } else {
                        console.error("Data format error or no data to display");
                    }


                });
        }

        // function all(){

        //     const token = sessionStorage.getItem('token');

        //     var branch_id = $('#branch_name').val();
        //     // var branch_ids = sessionStorage.getItem('branch_id');
        //     // var branch_id = JSON.parse(branch_ids);
        //     // var branch = branch_id[1];
        //     var tc_id = $('#treatment_cat_list').val();
        //     var t_id = $('#select_treatment').val();

        //     let params = new URLSearchParams();

        //     params.append('branch_id', branch_id);
        //     params.append('tc_id', tc_id);
        //     params.append('t_id', t_id);

        //     fetch(base_url+"payment", {
        //             headers: {
        //                 "Content-Type": "application/x-www-form-urlencoded",
        //                 'Authorization': `Bearer ${token}`, // notice the Bearer before your token
        //             },
        //             method: "post",
        //             body:params
        //         })
        //             .then((response) => response.json())
        //             .then((data) => {

        //                 if(data.status == '200'){


        //                 if(data.data){

        //                         const value = data.data;

        //                         var htmlString = "";

        //                         var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Date</th><th>Receipt No</th><th>Customer/Lead</th><th>Paid Amount</th><th>Total Amount</th><th>Balance Amount</th><th>Status</th><th>Action</th></tr></thead><tbody>";

        //                         let totalAmount = 0;
        //                         let totalGst = 0;

        //                         for(var i = 0; i < value.length  ; i++){

        //                             var  status = '';
        //                             if(value[i].status == '0'){
        //                                 var status = 'checked';
        //                             }

        //                             $val =[];

        //                             $pay_modes = JSON.parse(value[i].payment_status);

        //                             $pay_modes.map((menu) =>

        //                                 {
        //                                     if(menu.amount > 0){
        //                                         $val.push(menu.name);
        //                                     }

        //                                 });

        //                             var mode_off = $val.join(", ");

        //                             var action = "";

        //                             if(permission){
        //                             //  console.log(permission)

        //                                 var cama=stringHasTheWhiteSpaceOrNot(permission);
        //                                 if(cama){
        //                                     var values = permission.split(",");
        //                                     if(values.length > 0){
        //                                         var print = values.includes('print'); // true


        //                                         if(print){  
        //                                             action += "<a href='#' data-bs-toggle='modal' data-bs-target='' onclick='on_print("+value[i].p_id +")'><i class='fa fa-print eyc'></i></a>";}
        //                                         else{
        //                                             action += "";
        //                                         }
        //                                     }

        //                                     function include(arr, obj) {
        //                                         for (var i = 0; i < arr.length; i++) {
        //                                             if (arr[i] == obj) return true;
        //                                         }
        //                                     }

        //                                 } else {

        //                                     if(permission){
        //                                         $data += "";
        //                                     }else{
        //                                         $data += "";
        //                                     }
        //                                 }

        //                                 function stringHasTheWhiteSpaceOrNot(value){
        //                                     return value.indexOf(',') >= 0;
        //                                 }

        //                             }else{
        //                                 action = '';
        //                             }
        //                             var  paid_status = "<span class='bg-success p-1 rounded'>Paid<span>";
        //                                     if(value[i].balance > 0){
        //                                         paid_status = "<span class='bg-danger p-1 rounded'>Pending<span>";
        //                                     }
        //                                     var invoice = value[i].invoice_no;
        //                                     if (value[i].invoice_no == null) {
        //                                         invoice = " ";
        //                                     }
        //                             htmlString += "<tr>"+"<td>" + value[i].payment_date + "</td><td>" + value[i].receipt_no + "</td><td>"+ value[i].customer_first_name +'<br/>'+value[i].customer_phone + "</td><td>"+ value[i].amount + "</td><td>"+ value[i].total_amount+ "</td><td>"+value[i].balance + "</td><td>"+paid_status +"</td><td>" +action  + "</td></tr>";
        //                             totalAmount += parseFloat(value[i].amount);
        //                             totalGst += parseFloat(value[i].total_amount);

        //                         }
        //                         var totalRow = "<tfoot><tr>" +
        //                             "<td colspan='6'><strong>Total</strong></td>" +
        //                             "<td></td>" +
        //                             "<td><strong>" + totalAmount.toFixed(2) + "</strong></td>" +
        //                             "<td><strong>" + totalGst.toFixed(2) + "</strong></td>" +
        //                             "<td></td>" +
        //                             "<td></td>" +
        //                             "<td></td>" +
        //                             "<td></td>" +
        //                             "<td></td>" +
        //                             "</tr></tfoot>";

        //                         var htmlfooter ="</tbody></table>";

        //                         var htmlstringall = htmlhead+htmlString+totalRow+htmlfooter;
        //                         $("#payment_list").html(htmlstringall);
        //                         pay_report = htmlstringall;

        //                         datatable();

        //                         // var in_id = autoIncrementCustomId(data.numbers.invoice_no);
        //                         // var in_id = data.numbers.invoice_no;
        //                         // var re_id = autoIncrementreceipt(data.numbers.receipt_no);
        //                         //  var in_id = autoIncrementCustomId(data.data[0].invoice_no);
        //                         // var re_id = autoIncrementreceipt(data.data[0].receipt_no);
        //                         // document.getElementById("invoice_no").value = in_id;
        //                         // document.getElementById("receipt_no").value = re_id;

        //                     }

        //                 }
        //             });
        // }
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
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
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
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
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

        // function on_print(id){

        //     const token = sessionStorage.getItem('token');
        //     fetch(base_url+"edit_payment/"+id, {
        //             headers: {
        //                 "Content-Type": "application/x-www-form-urlencoded",
        //                 'Authorization': `Bearer ${token}`, // notice the Bearer before your token
        //             },
        //             method: "get",
        //     })
        //     .then((response) => response.json())
        //     .then((data) => {

        //         if(data.status == '200'){

        //             //$val =[];
        //             $html_tr = "";
        //             $pay_modes = JSON.parse(data.data[0].payment_status);

        //             $pay_modes.map((menu) =>

        //             {
        //                 if(menu.amount > 0){
        //                     //$val.push(menu.name);

        //                   $html_tr += " <tr class='details'>	<td>"+menu.name+"</td>	<td>"+menu.amount+"</td>	</tr>	"
        //                 }

        //             });
        //             var amt = data.data[0].amount;
        //             var state_id =data.data[0].state_id;
        //             // console.log(state_id)




        //                 if(state_id==23){
        //                     var sgst = ((amt/100)*9)/2;
        //                     var cgst = ((amt/100)*9)/2;
        //                 }else{
        //                     var igst = ((amt)*18/100);

        //                 }

        //             var gst_tr ='';

        //               if(state_id==23){
        //                     gst_tr="</tr><tr class='total' style='font-size: 12px;'><td></td><td>Inc. CGST : "+sgst+"</td></tr><tr class='total' style='font-size: 12px;'><td></td><td>Inc. SGST : "+cgst+"</td></tr>";
        //                 }else{
        //                     gst_tr="<tr class='total' style='font-size: 12px;'><td></td><td>Inc. IGST : "+igst+"</td></tr>";

        //                 }
        //           //  $mode_off = $val.join(", ");

        //             //console.log($mode_off);



        //             // gettcatgoryall(data.data[0].tcategory_id);
        //             // gettreatmentall(data.data[0].treatment_id);
        //             // getcustomerall(data.data[0].customer_id);
        //             // document.getElementById("invoice_no").value = data.data[0].invoice_no;
        //             // document.getElementById("receipt_no").value = data.data[0].receipt_no;
        //             // document.getElementById("payment_date").value = data.data[0].payment_date;
        //             // document.getElementById("amount").value = data.data[0].amount;
        //             // document.getElementById("total_amount").value = data.data[0].total_amount;
        //             // document.getElementById("payment_status").value = data.data[0].payment_status;
        //             // document.getElementById("sitting_counts").value = data.data[0].sitting_count;
        //             // document.getElementById("tc_name").value = data.data[0].tc_name;
        //             // document.getElementById("treatment_name").value = data.data[0].treatment_name;
        //             // document.getElementById("customer_first_name").value = data.data[0].customer_first_name;


        //             var newWin=window.open('','Print-Window')

        //             newWin.document.open();
        //             var date = "<?php echo date('d-m-Y'); ?>";

        //             // var html_content = "<!DOCTYPE html><html lang='en'>  <head>  <meta charset='utf-8'><title>Payment Receipt</title>  <style>@font-face {  font-family: SourceSansPro;  src: url(SourceSansPro-Regular.ttf);}.clearfix:after {  content: '';  display: table;  clear: both;}a {  color: #0087C3;  text-decoration: none;}body {  position: elative;  width: 21cm;  height: 29.7cm;   margin: 0 auto;   color: #555555;  background: #FFFFFF; font-family: Arial, sans-serif;   font-size: 14px;   font-family: SourceSansPro;}header {  padding: 10px 0;  margin-bottom: 20px;  border-bottom: 1px solid #AAAAAA;}#logo {  float: left;  margin-top: 8px;}#logo img {  height: 70px;}#company {  float: right;  text-align: right;}#details {  margin-bottom: 50px;}#client {  padding-left: 6px;  border-left: 6px solid #0087C3;  float: left;}#client .to {  color: #777777;}h2.name {  font-size: 1.4em;  font-weight: normal;  margin: 0;}#invoice {  float: right;  text-align: right;}#invoice h1 {  color: #0087C3;  font-size: 2.1em;  line-height: 1em;  font-weight: normal;  margin: 0  0 10px 0;}#invoice .date {  font-size: 1.1em; color: #777777;}table { width: 100%;  border-collapse: revert;  border-spacing: 0;  margin-bottom:20px;}table th,table td {  padding: 20px;  background: #EEEEEE;  text-align: center;border-bottom: 1px solid #FFFFFF;}table th {  white-space: nowrap;          font-weight: normal;}table td {  text-align: right;}table td h3{  color: #57B223;  font-size: 1.2em;  font-weight: normal;  margin: 0 0 0.2em 0;}table .no {  color: #FFFFFF;  font-size: 1.6em;  background: #57B223;}table .desc {  text-align: left;table .unit {  background: #DDDDDD;}table  .qty {}table .total {  background: #57B223;  color: #FFFFFF;}table td.unit,table td.qty,table td.total {  font-size: 1.2em;}table tbody tr:last-child td {  border: 1px solid #000;}table tfoot td {  padding: 10px 20px;  background: #FFFFFF;  border-bottom: 1px solid #000;  font-size: 1.2em;  white-space:nowrap;   border-top: 1px solid #AAAAAA; }table tfoot tr:first-child td {  border-top: none; }table tfoot tr:last-child td {  color: #57B223;  font-size: 1.4em;  border-top: 1px solid #57B223; }table foot tr td:first-child {  border: none;}#thanks{  font-size: 2em;  margin-bottom: 50px;}#notices{  padding-left: px;  border-left: 6px solid #0087C3;  }#notices .notice {  font-size: 1.2em;}footer {  color: #777777;  width: 100%;  height: 30px;  position: absolute;  /* bottom: 0; */  border-top: 1px solid #AAAAAA;  padding: 8px 0;  text-align: center;}	</style>  </head>  <body onload='window.print()'>    <header class='clearfix'> <div id='logo'> <img src='https://crm.renewhairandskincare.com/renew_api/apiassets/logo/renew_1.png'>  </div>   <div id='company'><h2 class='name'>Renew+ Hair and Skin Care</h2>  <div>No.155, 2nd floor, 80 feet road,<br /> kk nagar, Madurai, Tami Nadu, India, 625020</div>   <div>+91 9150309990(M)</div>  <div><a href='mailto:company@example.com'>Email: renewhairskincare@gmail.com</a></div>    </div>    </div>  </header>  <main>    <div id='details' class='clearfix'>   <div id='client'>   <div class='to'>RECEIPT TO:</div>  <h2 class='name'>"+data.data[0].customer_first_name+"</h2>          <div class='address'>796 Silver Harbour, TX 79273, US</div>         <div class='email'><a href='mailto:john@example.com'>john@example.com</a></div>       </div>        <div id='invoice'>          <h1>"+data.data[0].receipt_no+"</h1>          <div class='date'>Invoice: "+data.data[0].invoice_no+"</div> <div class='date'>Date of Invoice: 11/01/2023</div>         <div class='date'>Due Date: 11/01/2023</div>        </div>      </div>      <table border='1' cellspacing='0' cellpadding='0'>        <thead>          <tr>            <th class='no'>#</th>            <th class='desc'>DESCRIPTION</th>            <!-- <th class='unit'>UNIT PRICE</th>            <th class='qty'>QUANTITY</th> -->            <th class='total'>TOTAL</th>          </tr>        </thead>        <tbody>          <tr>            <td class='no'>01</td>            <td class='desc'><h3>"+data.data[0].tc_name+"</h3>"+ data.data[0].treatment_name+"</td>            <!-- <td class='unit'>40.00</td>            <td class='qty'>30</td> -->            <td class='total'>"+data.data[0].amount+"</td>          </tr>          <!-- <tr>            <td class='no'>02</td>            <td class='desc'><h3>Website Development</h3>Developing a Content Management System-based Website</td> -->            <!-- <td class='unit'>$40.00</td>            <td class='qty'>80</td> -->            <!-- <td class='total'>$3,200.00</td>          </tr>          <tr>            <td class='no'>03</td>            <td class='desc'><h3>Search Engines Optimization</h3>Optimize the site for search engines (SEO)</td> -->            <!-- <td class='unit'>$40.00</td>            <td class='qty'>20</td> -->            <!-- <td class='total'>$800.00</td>          </tr> -->        </tbody>        <tfoot>          <tr>            <td colspan='2'></td>            <!-- <td colspan='2'>SUBTOTAL</td>    -->        <td>"+data.data[0].amount+"</td>               </tfoot>      </table>      <div id='thanks'>Thank you!</div>      <!-- <div id='notices'>        <div>NOTICE:</div>        <div class='notice'>A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>      </div> -->    </main>    <footer>      Receipt was created on a computer and is valid without the signature and seal.</footer>  </body></html>";

        //             var html_content =  "<!DOCTYPE html><html><head><meta charset='utf-8' /><title>PAYMENT RECEIPT</title><style>.invoice-box {	max-width: 800px;margin: auto;	padding: 0px;		border: 1px solid #eee;	box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);font-size: 16px;		line-height: 24px;	font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, ans-serif;color: #555;	}	.invoice-box table {width: 100%;line-height: inherit;		text-align: left;	}	.invoice-box table td {	padding: 5px;	vertical-align: top;}.invoice-box table tr td:nth-child(2) {text-align: right;}	.invoice-box table tr.top table td {padding-bottom: 20px;}	.invoice-box table tr.top table td.title {	font-size: 15px;line-height: 15px;	color: #333;}.invoice-box table tr.information table td {			padding-bottom: 40px;		}	.invoice-box table tr.heading td {	background: #eee;	border-bottom: 1px solid #ddd;	font-weight: bold;}	.invoice-box table tr.details td {	padding-bottom: 20px;}	.invoice-box table tr.item td {	border-bottom: 1px solid #eee;	}	.invoice-box table tr.item.last td {border-bottom: none;}	.invoice-box table tr.total td:nth-child(2) {	border-top: 2px solid #eee;	font-weight: bold;}		@media only screen and (max-width: 600px) {	.invoice-box table tr.top table td {width: 100%;	display: block;	text-align: center;	}.invoice-box table tr.information table td {		width: 100%;	display: block;		text-align: center;	}	}	.invoice-box.rtl {		direction: rtl;	font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, ans-serif;		}	.invoice-box.rtl table {	text-align: right;	}.invoice-box.rtl table tr td:nth-child(2) {text-align: left;		}	</style></head><body>		<div class='invoice-box' style='border: 1px solid #c6c6c6;'>            <h2 align='center'>PAYMENT RECEIPT</h2>			<hr>			<table cellpadding='0' cellspacing='0'>				<tr class='top ' >					<td colspan='2' style='border-bottom: 1px solid #c6c6c6';>						<table>							<tr >								<td class='title' ><img src='https://crm.renewhairandskincare.com/renew_api/public/logo/22626.png' style='float:left; width: 100%; max-width: 120px;    padding-top: 30px; margin-right:20px;' />		<div style='vertical-align:bottom ;'>					<h3>Renew+ Hair and Skin Care</h3>							<p>No.155, 2nd floor, 80 feet road,<br /> kk nagar, Madurai, Tami Nadu, India, 625020</p>			<p>+91 9150309990(M)</p>										<p>Email: renewhairskincare@gmail.com</p>									</div>						</td>								<td>									Receipt  #: "+data.data[0].receipt_no+"<br />									Created: "+data.data[0].payment_date+"<br />								Due: "+date+"							</td>							</tr>						</table>		</td>				</tr>				<tr class='information'>		<td colspan='2'>						<table>							<tr>								<td>		<h5>To:</h5>									<h3>Name : "+data.data[0].customer_first_name+"</h3>                                    <p style='margin:0px;'>"+data.data[0].customer_address+"</p>									<p style='margin:0px;'>+91 "+data.data[0].customer_phone+"(M)</p>                                    <p style='margin:0px;'>Email: "+data.data[0].customer_email+"</p>					</td>								<td>								</td>				</tr>					</table>			</td>	</tr>	<tr class='heading'>	<td>Payment Method</td>					<td>Cash #</td>		</tr>"	+$html_tr+		"<tr class='heading'>         <td>Description</td>		<td>Price</td>		</tr>	<tr class='item'>					<td>Hair Fall Treatement</td>				<td>"+data.data[0].amount+"</td>		</tr>		"+gst_tr+"		<tr class='total'>	<td></td>	<td>Total: "+data.data[0].amount+"</td>			</tr>  <tr style='height:100px'	<td></td><td></td>	</tr>				<tr >		<td>	Customer's Signatory	</td>	<td>			Authorised Signatory</td>	</tr>	<tr style='height:20px'>	<td></td><td></td>		</tr>	</table> </div></body></html>";                        
        //             newWin.document.write(html_content);
        //             newWin.print();
        //             newWin.document.close();



        //         }
        //     });
        // }

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


        function select_t_Category() {
            var tcategory_id = document.getElementById("tc_name").value;
            gettreatmentall(tcategory_id);

            //cutomer_invoice();
        }

        function cutomer_invoice() {

            var customer_id = document.getElementById("select_customer").value;
            var tcategory_id = document.getElementById("tc_name").value;
            var treatment_id = document.getElementById("treatment_name").value;

            if (!tcategory_id) {

                $("#error_tc_name").html("Please select Treatment_category name");
                var dropDown = document.getElementById("treatment_name");
                dropDown.selectedIndex = 0;
            } else {
                $("#error_tc_name").html("");
            }

            if (!treatment_id) {

                $("#error_treatment_name").html("Please select Treatment name");
                dropDown.selectedIndex = 0;

            } else {
                $("#error_treatment_name").html("");
            }
            if (!customer_id) {

                $("#error_customer_name").html("Please select Customer name");
                dropDown.selectedIndex = 0;

            } else {
                $("#error_customer_name").html("");
            }


            if (customer_id && tcategory_id && treatment_id) {

                var data = "customer_id=" + customer_id + '&tcategory_id=' + tcategory_id + '&treatment_id=' + treatment_id;

                const token = sessionStorage.getItem('token');

                fetch(base_url + "invoice_generator?" + data, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                        },
                        method: "get",
                    })
                    .then((response) => response.json())
                    .then((data) => {


                        if (data.status == '200') {

                            if (data.balance == 0) {

                                $("#status_success").html("<div class='alert alert-danger' role='alert'>Amount already paid !</div>");

                                setTimeout(() => {
                                    $("#status_success").html("");
                                }, 4000);

                            } else {

                                var numbers = data.numbers;
                                if (numbers) {



                                    if (data.used) {


                                        if (data.used == 'new') {

                                            var in_id = autoIncrementCustomId(numbers.invoice_no);
                                            var re_id = numbers.receipt_no;

                                            document.getElementById("invoice_no").value = in_id;
                                            document.getElementById("receipt_no").value = re_id;

                                        } else {
                                            var in_id = numbers.invoice_no;
                                            var re_id = autoIncrementreceipt(numbers.receipt_no);

                                            document.getElementById("invoice_no").value = in_id;
                                            document.getElementById("receipt_no").value = re_id;



                                        }



                                    } else {

                                        var dt = new Date();
                                        var val = dt.getFullYear().toString().substr(dt.getFullYear().toString().length - 2);

                                        var in_id = autoIncrementCustomId(numbers.invoice_no);
                                        var re_id = numbers.receipt_no;

                                        document.getElementById("invoice_no").value = in_id;
                                        document.getElementById("receipt_no").value = re_id;


                                    }




                                } else {
                                    var dt = new Date();
                                    var val = dt.getFullYear().toString().substr(dt.getFullYear().toString().length - 2);

                                    var in_id = autoIncrementCustomId('IN000/' + val);
                                    var re_id = autoIncrementreceipt('RP000/' + val);

                                    document.getElementById("invoice_no").value = in_id;
                                    document.getElementById("receipt_no").value = re_id;


                                }

                                document.getElementById("sitting_counts").value = data.sitting_count;
                                document.getElementById("total_amount").value = data.total_amount;
                                document.getElementById("balance_amount").value = data.balance;

                                total_balance = data.balance;
                            }
                        }
                    });
            }
        }

        function pay_amount(e) {

            if ($('#select_customer').val()) {


                var regex = /^\d+(\.\d{2,2})?$/;


                if (parseInt(total_balance) == 0) {

                    total_balance = $('#total_amount').val();

                }


                var amount = e.target.value;

                if (amount == '' || amount <= 0 || regex.test(amount) == false) {
                    $("#error_pay_amount").html("Please enter valid amount");

                } else {

                    //  var total_amount = $('#total_amount').val();

                    document.getElementById("cash").value = amount;
                    document.getElementById("card").value = 0;
                    document.getElementById("cheque").value = 0;
                    document.getElementById("upi").value = 0;


                    if (parseInt(amount) > parseInt(total_balance)) {

                        $("#error_pay_amount").html("your amount is excess paying amount");
                        document.getElementById("cash").value = 0;
                        document.getElementById("card").value = 0;
                        document.getElementById("cheque").value = 0;
                        document.getElementById("upi").value = 0;

                    } else {
                        var balance = parseInt(total_balance) - parseInt(amount);
                        $("#balance_amount").val(balance);

                        $val = parseInt(amount) * (18 / 100);
                        $val = Math.round($val / 2);
                        $('#cgst').html($val);
                        $('#sgst').html($val);


                        $("#error_pay_amount").html("");
                    }


                }
            } else {

                $("#error_customer_name").html("Please select User ");
                $("#select_customer").focus();

            }




        }

        //global variable



        function multi_payment(e) {

            // alert(e.target.value);
            // const permission = Array_obj.map((menu) =>

            //     {
            //         if(menu.name == e.target.id ){

            //             $value = menu.amount;

            //             arr = $value;

            //         }
            //     }


            // );


            var cash_amt = $('#cash').val();
            var card_amt = $('#card').val();
            var cheque_amt = $('#cheque').val();
            var upi_amt = $('#upi').val();



            var total_amt = parseInt(cash_amt) + parseInt(card_amt) + parseInt(cheque_amt) + parseInt(upi_amt);

            // var balance = parseInt($('#amount').val() - total_amt);

            //alert(total_amt+"=="+parseInt($('#amount').val()));

            if (total_amt > parseInt($('#total_amount_value').val())) {
                // $("#error_pay_amount").html("your amount is excess paying amount");
                alert("your amount is excess paying amount");
                $('#cash').val(0);
                $('#card').val(0);
                $('#cheque').val(0);
                $('#upi').val(0);
            } else {
                // $("#error_pay_amount").html('');

            }



            // const upd_obj = Array_obj.map((menu) =>
            //     menu.name == e.target.id // from state
            //     ? { ...menu, amount: e.target.value}
            //     : menu
            // );

            // Array_obj = upd_obj;

            //  console.log(Array_obj);

        }


        var final_arr = [];

        function add_payment() {

            //console.log(Array_ids);
            final_arr = [];
            // var invoice_no = document.getElementById("invoice_no").value;
            // var receipt_no = document.getElementById("receipt_no").value;
            // var tcategory_id     = document.getElementById("tc_name").value;
            // var treatment_id  = document.getElementById("treatment_name").value;
            // var customer_id = document.getElementById("select_customer").value;
            // var payment_date = document.getElementById("payment_date").value;
            // var amount = document.getElementById("amount").value;
            // var total_amount = document.getElementById("total_amount").value;
            // var balance_amount = document.getElementById("balance_amount").value;
            //var payment_status = document.getElementById("payment_status").value;
            //var sitting_counts = document.getElementById("sitting_counts").value;

            Array_ids.map((val, i) => {


                var dis = $('#' + val.discount).val();
                var amt = $('#' + val.final_amount).val();

                var discount_type = $('#discount_type' + i).val() || 0; // Retrieve discount_type
                // alert(discount_type);
                final_arr.push({
                    treatment_id: val.treatment_id, // Ensure treatment_id exists in val
                    discount: dis, // Discount value
                    amount: amt, // Final amount
                    cus_treat_id: val.cus_treat_id, // Customer treatment ID
                    discount_type: discount_type // Correct discount type
                });

            });


            //  console.log(final_arr);

            var invoice_no = "";
            var receipt_no = "";
            // var tcategory_id  = document.getElementById("tc_name").value;
            // var treatment_id  = document.getElementById("treatment_name").value;
            var customer_id = document.getElementById("select_customer").value;
            var payment_date = document.getElementById("payment_date").value;
            // var amount = document.getElementById("amount").value;
            // var total_amount = document.getElementById("total_amount").value;
            // var balance_amount = document.getElementById("balance_amount").value;
            // var sitting_counts = document.getElementById("sitting_counts").value;

            var cus_treat_id = document.getElementById('cus_treat_id').value;

            var cgst = $('#cgst_value').val();
            var sgst = $('#sgst_value').val();
            //$('#cgst').text();
            // alert("sitting_count")

            // if(!invoice_no){

            //     $("#error_invoice_no").html("Please fill the  input feilds");

            // }else{
            //     $("#error_invoice_no").html("");
            // }
            // if(!receipt_no){

            //     $("#error_receipt_no").html("Please fill the  input feilds");

            // }else{
            //     $("#error_receipt_no").html("");
            // }  
            // if(tcategory_id == '0'){

            //     $("#error_tc_name").html("Please select Treatment_category name");

            // }else{
            //     $("#error_tc_name").html("");
            // } 

            // if(treatment_id == '0'){

            //     $("#error_treatment_name").html("Please select Treatment name");

            // }else{
            //     $("#error_treatment_name").html("");
            // } 
            if (customer_id == '0') {

                $("#error_customer_name").html("Please select Customer name");

            } else {
                $("#error_customer_name").html("");
            }

            if (!payment_date) {

                $("#error_payment_date").html("Please fill the  input feilds");

            } else {
                $("#error_payment_date").html("");
            }
            // if(!amount){

            //     $("#error_amount").html("Please fill the  input feilds");

            // }else{
            //     $("#error_amount").html("");
            // } 
            // if(!total_amount){

            //     $("#error_total_amount").html("Please fill the  input feilds");

            // }else{
            //     $("#error_total_amount").html("");
            // } 
            // if(!payment_status){

            //     $("#error_payment_status").html("Please fill the  input feilds");

            // }else{
            //     $("#error_payment_status").html("");
            // } 
            // if(!sitting_counts){

            //     $("#error_sitting_counts").html("Please fill the  input feilds");

            // }else{
            //     $("#error_sitting_counts").html("");
            // }


            var cash_amt = $('#cash').val();
            var card_amt = $('#card').val();
            var cheque_amt = $('#cheque').val();
            var upi_amt = $('#upi').val();

            var Array_obj = [

                {
                    name: 'cash',
                    amount: cash_amt
                },
                {
                    name: 'card',
                    amount: card_amt
                },
                {
                    name: 'cheque',
                    amount: cheque_amt
                },
                {
                    name: 'upi',
                    amount: upi_amt
                },

            ];


            var multi_pay = JSON.stringify(Array_obj);




            if (customer_id && payment_date) {
                document.getElementById('add_pay').style.pointerEvents = 'none';
                var data = "customer_id=" + customer_id + "&payment_date=" + payment_date + "&treatment_details=" + JSON.stringify(final_arr) + "&cgst=" + cgst + "&sgst=" + sgst + "&payment_status=" + multi_pay + "&cus_treat_id=" + cus_treat_id;

                const token = sessionStorage.getItem('token');

                fetch(base_url + "add_payment?" + data, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                        },
                        method: "post",
                    })
                    .then((response) => response.json())
                    .then((data) => {


                        if (data.status == '200') {


                            $("#status_success").html("<div class='alert alert-success' role='alert'>Payment Successfully Added!</div>");

                            setTimeout(() => {
                                $("#status_success").html("");
                                window.location.href = "./payment";
                            }, 4000);


                        } else {


                            // $("#error_payment_date").html(data.error_msg.payment_date[0]);
                            // $("#error_amount").html(data.error_msg.amount[0]);
                            // $("#error_total_amount").html(data.error_msg.total_amount[0]);
                            // $("#error_payment_status").html(data.error_msg.payment_status[0]);
                            // $("#error_sitting_count").html(data.error_msg.sitting_count[0]);

                            $("#status_success").html("<div class='alert alert-danger' role='alert'>Payment Detial Wrongly Added!</div>");

                            setTimeout(() => {
                                $("#status_success").html("");
                            }, 4000);

                            document.getElementById('add_pay').style.pointerEvents = 'auto';
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
                    // "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                    // "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +

                    "<'table-responsive'tr>" +

                    "<'row'" +
                    // "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    // "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">"
            });

        }


        function autoIncrementCustomId(lastRecordId) {
            var id = lastRecordId.split("/");

            let increasedNum = Number(id[0].replace('IN', '')) + 1;
            let kmsStr = id[0].substr(0, 2);
            for (let i = 0; i < 3 - increasedNum.toString().length; i++) {
                kmsStr = kmsStr + '0';
            }
            kmsStr = kmsStr + increasedNum.toString() + "/" + id[1];

            return kmsStr;


        }

        function autoIncrementreceipt(lastId) {
            var id = lastId.split("/");

            let increasedNo = Number(id[0].replace('RP', '')) + 1;
            let kmsStr = id[0].substr(0, 2);
            for (let i = 0; i < 3 - increasedNo.toString().length; i++) {
                kmsStr = kmsStr + '0';
            }
            kmsStr = kmsStr + increasedNo.toString() + "/" + id[1];

            return kmsStr;


        }

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
        //   function showDropInfo() {
        //    var sT = dropForm.payment_status;

        //    var pT = document.getElementById('pT');

        //    pT.innerHTML = (sT[sT.selectedIndex].text);
        // }

    }


    function sum(arr) {
        return arr.reduce(function(a, b) {
            return a + b;
        }, 0);
    }
</script>

