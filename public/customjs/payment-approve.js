
   var handlePaymentReceived = ()=>{
        let urlObject = new URL(window.location.href);
        let encoded_application_id = urlObject.pathname.split('/').pop();
        const fileInput = document.getElementById('payment_proof');
        let payment_remark = $('#payment_remark').val();
        let payment_id = $('#payment_id').val();
        payment_remark= payment_remark??"";
        let formData = new FormData();
        if (fileInput.files.length > 0) {
            formData.append("payment_proof",fileInput.files[0]);
            formData.append("payment_remark",payment_remark);
            formData.append("payment_id",payment_id);
            formData.append("application_id",encoded_application_id);
           
                $.ajaxSetup({
                headers:
                {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/account-payment-received",
                type: "post",
                datatype: "json",
                data:formData,

                contentType: false,
                processData: false,
                beforeSend: function(){
                    $("#loading").show();
                },
                complete: function(){
                    $("#loading").hide();
                },
                success: function(resdata){
                    if(resdata.success){
                        toastr.success(
                            "New Page Content added successfully!", 
                            "New Page Content!", 
                            {timeOut: 0, extendedTimeOut: 0, closeButton: true, closeDuration: 0}
                         );  
                        window.location.reload();
                    }else{

                    }
                },
                error:(xhr,st)=>{
                    console.log(st,'st')
                },
               
            });


        } else {
            alert('Please select a document to upload.');
        }
    }

function handlePaymentApproved(){
    let urlObject = new URL(window.location.href);
    let encoded_application_id = urlObject.pathname.split('/').pop();
    let final_payment_remark = $('#final_payment_remark').val();
    final_payment_remark= final_payment_remark??"";

    if(final_payment_remark===""){
        $("#final_payment_remark_err").html("Please enter the approve payment remark.")
        return false;
    }
    let formData = new FormData();

    formData.append("final_payment_remark",final_payment_remark);
    formData.append("application_id",encoded_application_id);
       
            $.ajaxSetup({
            headers:
            {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/account-payment-approved",
            type: "post",
            datatype: "json",
            data:formData,

            contentType: false,
            processData: false,
            beforeSend: function(){
                $("#loading").show();
            },
            complete: function(){
                $("#loading").hide();
              },
            success: function(resdata){
                if(resdata.success){
                    window.location.reload();
                }else{

                }
            },
            error:(xhr,st)=>{
                console.log(st,'st')
            },
           
        });
}



$(".remove_err").on("keyup",function(){
    let err_id = $(this).attr('id');
    $(`#${err_id}_err`).html("");
});