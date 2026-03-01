<script>
        var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
    all();

    function all(){

        const token = sessionStorage.getItem('token');
    
        fetch(base_url+"company", {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
            })
                .then((response) => response.json())
                .then((data) => {
                
                    if(data.status == '200'){

                        if(data.data){
                            
                            const value = data.data;
                            var htmlString = "";

                           // htmlString += "<tr><td>" + value[i].company_name + "</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox'  checked><span class='switch-state'></span></label>" + "</td><td>" + "<a href='edit_company' onclick='edit()' ><i class='fa fa-edit eyc'></i></a>" + "</td></tr>";
                            var htmlhead ="<table class='display' id='advance-1'><thead><tr><th>Sl no</th><th>Company name</th><th>Status</th><th>Action</th></tr></thead><tbody>";

                            for(var i = 0; i < value.length  ; i++){

                                htmlString += "<tr><td>"+(i+1)+"</td><td>" + value[i].company_name + "</td><td class='media-body switch-sm'>" + "<label class='switch'><input type='checkbox' disabled  checked><span class='switch-state'></span></label>" + "</td><td>" + "<a  onclick='edit("+value[i].company_id+")' ><i class='fa fa-edit eyc'></i></a>" + "</td></tr>";
                                
                            }

                            // $("#company_list").html(htmlString);

                            var htmlfooter ="</tbody></table>";
                        
                            var htmlstringall = htmlhead+htmlString+htmlfooter;
                            $("#company_list").html(htmlstringall);

                            datatable();
                           
                        }
                       

                    }
                });
    }

    function edit(id){

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

                        window.location.href = "./edit_company?c_id="+id;
                    }
                });
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

}   

</script>
