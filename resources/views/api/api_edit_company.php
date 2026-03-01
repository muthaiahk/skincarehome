<script>

var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
     
            var id = document.getElementById("edit_company_name").name;
            const token = sessionStorage.getItem('token');
                fetch(base_url+"edit_company/"+id, {
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                        },
                        method: "get",
                })
                .then((response) => response.json())
                .then((data) => {
                        
                if(data.status == '200'){
                    document.getElementById("edit_company_name").value = data.data.company_name;
                                
                }
            });
  
  
    

    }
    

    

</script>
