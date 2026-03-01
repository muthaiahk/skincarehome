<script>
     var id = sessionStorage.getItem('staff_id');
    all();
    function all(){
        var a = sessionStorage.getItem('token');
        if(!a){
            window.location.href = "./index";
        }else{
            var base_url = window.location.origin+'/api/';
            const token = sessionStorage.getItem('token');
            var id = sessionStorage.getItem('staff_id');
           

            fetch(base_url+"user_profile/"+id, {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                    },
                    method: "get",
            })
            .then((response) => response.json())
            .then((data) => {
                    

            if(data.status == '200'){
                
                const value = data.data[0] ;
                document.getElementById("staff_name").value = value.name;
                document.getElementById("staff_dob").value = value.date_of_birth;
                document.getElementById("staff_email").value = value.email;
                document.getElementById("staff_phone").value = value.phone_no;
                document.getElementById("staff_address").value = value.address;
                document.getElementById("profile_pic").src = value.profile_pic;
                // document.getElementById("role_name").value = data.data[0].role_name;
                // document.getElementById("staff_doj").value = data.data[0].date_of_joining;
                // document.getElementById("company_name").value = 'Renewhairandskincare';
                // document.getElementById("username").value = data.data[0].username;
                // document.getElementById("password").value = data.data[0].password;      
      
            }
        });
        }
    }
   var base_url = window.location.origin+'/new/api/';
    function Update_user(){
        var staff_name      = document.getElementById("staff_name").value;
        var staff_dob       = document.getElementById("staff_dob").value;
        var staff_email     = document.getElementById("staff_email").value;
        var staff_phone     = document.getElementById("staff_phone").value;
        var staff_address   = document.getElementById("staff_address").value;

    
        const token = sessionStorage.getItem('token');
        var formData = new FormData();

   
        formData.append('profile_pic', profile_p);
        formData.append('name', staff_name);
        formData.append('date_of_birth', staff_dob);
        formData.append('email', staff_email);
        formData.append('phone_no', staff_phone);
        formData.append('address', staff_address);
     
        // var data = "&profile_pic="+profile_pic+"&name="+staff_name+"&address="+staff_address+"&phone_no="+staff_phone+"&email="+staff_email+"&date_of_birth="+staff_dob;
        fetch(base_url+"update_user/"+id, {
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

               // document.getElementById('upd_staff').style.pointerEvents = 'auto';
                
                if(data.status == '200'){

                    

                    $("#status_success").html("<div class='alert alert-success' role='alert'>Staff Successfully Updated!</div>");
                    
                    setTimeout(() => {
                        // Reload the page after the success message is cleared
                        location.reload(); 
                    }, 2000);  
                    
                    

                }else{
               
                
                }
            });
            }


       
         

                
  
    
</script>
