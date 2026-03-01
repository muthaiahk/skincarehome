<script>
    all();
    function all(){
        var a = sessionStorage.getItem('token');
        if(!a){
            window.location.href = "./index";
        }else{
           var base_url = window.location.origin+'/api/';
            const token = sessionStorage.getItem('token');
        
            fetch(base_url+"general", {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                    
                if(data.status == '200'){
                            
                    //   console.log(data.data);
                    const value = data.data[0] ;
                    document.getElementById("logo_gs").src=value.logo;
                    document.getElementById("fav_gs").src=value.favicon;
                    document.getElementById("default_gs").src=value.default_pic;
                    document.getElementById("company_name").value = value.company_name;
                    document.getElementById("mobile").value = value.phone_no;

                    //document.getElementById("default_pic").src=value.default_pic;
                   // document.getElementById("default_pic").src = 'https://media.geeksforgeeks.org/wp-content/uploads/20190529122826/bs11.png';
                    document.getElementById("default_pic").src = value.default_pic;
                    document.getElementById("c_logo").src = value.logo;
                    document.getElementById("fav_icon1").href = value.favicon;
                    document.getElementById("fav_icon2").href = value.favicon;
                }
            });
        }
    }

    function upd_general(){
        var company_name    = document.getElementById("company_name").value;
        var Select_date     = document.getElementById("Select_date").value;
        var Select_time     = document.getElementById("Select_time").value;
        var mobile          = document.getElementById("mobile").value;
        var website         = document.getElementById("website").value;
        // var Select_region   = document.getElementById("Select_region").value;
        // var Select_language = document.getElementById("Select_language").value;
        // var Select_currency = document.getElementById("Select_currency").value;
        var opening_date    = document.getElementById("opening_date").value;

        var formData = new FormData();
        formData.append('logo',logo_img);
        formData.append('fav', fav_img);
        formData.append('default', default_img);

        if(!company_name){
            $("#status_success").html("<div class='alert alert-danger' role='alert'>Company input  feild is required</div>");
                        
            setTimeout(() => { $("#status_success").html("");}, 2000);  
        }

        // var data = "company_name="+company_name+"&date_format="+Select_date+"&timezone="+Select_time+"&mobile="+mobile+"&website="+website+"region="+Select_region+"&language="+Select_language+"&currency="+Select_currency+"&opening_date="+opening_date+"&logo_img="+logo_img+"&fav_img="+fav_img+"&default_img="+default_img+"&images="+formData;

        const token = sessionStorage.getItem('token');
        sessionStorage.setItem("company", company_name);


        // Create form data object and append the values into it
        var formData = new FormData();

        formData.append('logo',logo_img);
        formData.append('favicon', fav_img);
        formData.append('default_pic', default_img);

        formData.append('company_name', company_name);
        formData.append('date_format', Select_date);
        formData.append('timezone', Select_time);
        formData.append('mobile', mobile);
        formData.append('website', website);
        // formData.append('region', Select_region);
        // formData.append('language', Select_language);
        // formData.append('currency', Select_currency);
        formData.append('opening_date', opening_date);
     

        // add as many variables you want

        // $.ajax({
        // url: $('meta[name="route"]').attr('content') + '/your_route',
        // method: 'post',
        // data: formData,
        // contentType : false,
        // processData : false,
        // headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // },
        // success: function(response){

        // });



        // fetch(base_url+"update_general/1?"+data, {
        fetch(base_url+"update_general/1", {
                body:formData,
                headers: {
                   
                    // "Content-Type": "multipart/form-data",
                    // 'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "post",
                
        })
        .then((response) => response.json())
        .then((data) => {
                
            if(data.status == '200'){

                sessionStorage.setItem("company", company_name);
                //console.log(data.data);
                $("#status_success").html("<div class='alert alert-success' role='alert'>General Setting Successfully Updated!</div>");
                setTimeout(() => { $("#status_success").html("");}, 4000);


                all();
                
                
            }
        });


       
         

                
    }
    
</script>
