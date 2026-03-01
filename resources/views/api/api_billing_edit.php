<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
 var a = sessionStorage.getItem('token');
    if(!a){
        window.location.href = "./index";
    }else{
        var base_url = window.location.origin+'/api/';
        var id=<?php if(isset($_GET['pay_id'])) echo $_GET['pay_id']; else echo ""?>;

    
     const token = sessionStorage.getItem('token');
        fetch(base_url+"edit_billing/"+id, {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    'Authorization': `Bearer ${token}`, // notice the Bearer before your token
                },
                method: "get",
        })
        .then((response) => response.json())
        .then((data) => {
                
        if(data.status == '200'){
            
            
            document.getElementById("invoice_no").value = data.data[0].invoice_no;
            document.getElementById("receipt_no").value = data.data[0].receipt_no;
            document.getElementById("payment_date").value = data.data[0].payment_date;
            document.getElementById("amount").value = data.data[0].amount;
           
            document.getElementById("total_amount").value = data.data[0].total_amount;
            document.getElementById("balance").value = data.data[0].balance;
            document.getElementById("payment_status").value = data.data[0].payment_status;
           
            // document.getElementById("sitting_counts").value = data.data[0].sitting_count;
           
            // document.getElementById("tc_name").value = data.data[0].tc_name;
            // document.getElementById("treatment_name").value = data.data[0].treatment_name;
            // document.getElementById("customer_first_name").value = data.data[0].customer_first_name;

            // document.getElementById("cgst").html((data.data[0].amount/100)*18)/2;
            // document.getElementById("sgst").html((data.data[0].amount/100)*18)/2;
            $val =((data.data[0].amount/100)*18)/2;
            $("#cgst").html($val);
            $("#sgst").html($val);

            gettcatgoryall(data.data[0].tcategory_id);
            gettreatmentall(data.data[0].treatment_id);
            getcustomerall(data.data[0].customer_id);

            view(data.data[0]);
           
            

       

            
            

            function view(data){
                document.getElementById("tcat_name").value = data.tc_name;
                document.getElementById("treatment_name_v").value = data.treatment_name;
                document.getElementById("first_name").value = data.customer_first_name;
            }

          


            
            

      
        }
    });

  

   
}


</script>

<style>
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }

    .page-button {
        padding: 5px 10px;
        margin: 0 5px;
        border: 1px solid #007bff;
        background-color: #ffffff;
        color: #007bff;
        cursor: pointer;
    }

    .page-button:hover {
        background-color: #007bff;
        color: #ffffff;
    }

    .page-button:focus {
        outline: none;
    }
    .page-button.active {
        background-color: #007bff; /* Change to the desired active color */
        color: #ffffff; /* Change text color for active button */
        font-weight: bold; /* Optional: make the active button bold */
    }

    .treatment-item {
        border: 1px solid #ccc; /* Light gray border */
        border-radius: 5px; /* Rounded corners */
        padding: 15px; /* Spacing inside the box */
        background-color: #f9f9f9; /* Light background color */
        transition: box-shadow 0.3s; /* Smooth transition for hover effect */
    }

    .treatment-item:hover {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow on hover */
    }

    .treatment-label {
        font-size: 14px; /* Font size for treatment name */
    }

    .amount-details {
        color: #555; /* Darker color for amount details */
        font-size: 14px; /* Font size for amount text */
    }

   /* Remove borders, make items more compact */
.product-item {
    background-color: #f9f9f9;  /* Light background color */
    border-radius: 8px;         /* Rounded corners */
    padding: 8px;               /* Reduced padding */
    transition: box-shadow 0.2s ease, transform 0.2s ease;  /* Smooth transition for hover */
    min-height: 70px;           /* Consistent height */
    display: flex;              /* Flexbox for alignment */
    align-items: center;        /* Center items vertically */
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);  /* Light shadow for subtle definition */
}

/* Hover effect for interactivity */
.product-item:hover {
    transform: scale(1.05);      /* Slight zoom on hover */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);  /* Slightly stronger shadow */
}


.product-name {
    font-size: 14px;
    color: #333;
    display: block;
    max-width: 150px; /* Adjust this width according to your layout */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.product-name:hover {
    cursor: pointer;
}

/* Amount styling */
.product-amount {
    color: #3db082;              /* Green color for amount */
    font-size: 13px;             /* Slightly smaller font size */
    font-weight: 500;            /* Font weight for better readability */
}

/* Image Styling */
.product-item img {
    width: 40px;                 /* Smaller image size */
    height: 40px;                /* Height consistent with width */
    object-fit: cover;           /* Maintain aspect ratio */
    border-radius: 50%;          /* Circular image */
    margin-right: 12px;          /* Space between image and text */
}

/* Flexbox container for product details */
.product-item label {
    display: flex;               /* Flex for horizontal layout */
    align-items: center;         /* Center vertically */
    justify-content: space-between;  /* Space between checkbox and text */
    width: 100%;
}


    .form-check-label {
        width: 100%; /* Make the label full width */
        display: flex;
        align-items: center;
        justify-content: space-between;
    }




</style>


