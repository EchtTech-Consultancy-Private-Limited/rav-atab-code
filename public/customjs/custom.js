var handlePaymentReceived = () => {
    let urlObject = new URL(window.location.href);
    let encoded_application_id = urlObject.pathname.split("/").pop();
    const fileInput = document.getElementById("payment_proof");
    let payment_remark = $("#payment_remark").val();
    let payment_id = $("#payment_id").val();
    payment_remark = payment_remark ?? "";
    let formData = new FormData();
    if (fileInput.files.length > 0) {
        formData.append("payment_proof", fileInput.files[0]);
        formData.append("payment_remark", payment_remark);
        formData.append("payment_id", payment_id);
        formData.append("application_id", encoded_application_id);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/account-payment-received`,
            type: "post",
            datatype: "json",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $(".box-overlay-2").show();
            },
            complete: function () {
                $("#loading").hide();
            },
            success: function (resdata) {
                if (resdata.success) {
                    toastr.success(resdata.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });
                    $(".box-overlay-2").hide();
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    toastr.error(resdata.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });
                    $(".box-overlay-2").hide();
                }
            },
            error: (xhr, st) => {
                console.log(xhr, "st");
            },
        });
    } else {
        alert("Please select a document to upload.");
    }
};
function handlePaymentApproved() {
    let urlObject = new URL(window.location.href);
    let encoded_application_id = urlObject.pathname.split("/").pop();
    let final_payment_remark = $("#final_payment_remark").val();
    final_payment_remark = final_payment_remark ?? "";
    if (final_payment_remark === "") {
        $("#final_payment_remark_err").html(
            "Please enter the approve payment remark."
        );
        return false;
    }
    let formData = new FormData();
    formData.append("final_payment_remark", final_payment_remark);
    formData.append("application_id", encoded_application_id);
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: `${BASE_URL}/account-payment-approved`,
        type: "post",
        datatype: "json",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $(".box-overlay").show();
        },
        complete: function () {
            $("#loading").hide();
        },
        success: function (resdata) {
            if (resdata.success) {
                toastr.success(resdata.message, {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 0,
                });
                $(".box-overlay").hide();
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else {
                toastr.error(resdata.message, {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 0,
                });
                $(".box-overlay").hide();
            }
        },
        error: (xhr, st) => {
            console.log(st, "st");
        },
    });
}
function handleAcknowledgementPayment(id) {
    let is_acknowledged = confirm("Are you sure you want to acknowledge?");
    if (is_acknowledged) {
        $(".full_screen_loading").show();
        if (id == "" || id === null || id === undefined) {
            toastr.error("Application id not found", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 0,
            });
            $(".full_screen_loading").hide();
            return false;
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/admin-payment-acknowledge`,
            type: "post",
            datatype: "json",
            data: {
                application_id: id,
            },
            success: function (resdata) {
                if (resdata.success) {
                    toastr.success(resdata.message, {
                        timeOut: 1,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 1,
                    });
                    $("#acknowledgement_" + id).hide();
                    $(".full_screen_loading").hide();
                    window.location.reload();
                } else {
                    toastr.error(resdata.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });
                    $(".full_screen_loading").hide();
                }
            },
            error: (xhr, st) => {
                toastr.error("Something went wrong!", {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 0,
                });
                $(".full_screen_loading").hide();
            },
        });
    }
}

function desktopDocumentVerfiy() {
    let is_acknowledged = confirm("Are you sure you want to submit?");
    if (is_acknowledged) {
        $('.full_screen_loading').show();
        let urlObject = new URL(window.location.href);
        let urlPath = urlObject.pathname.split("/");

        let doc_sr_code = urlPath[3];
        let doc_file_name = urlPath[4];
        let application_id = urlPath[5];
        let doc_unique_id = urlPath[6];
        let application_courses_id = urlPath[7];
       
       if(urlPath[1]=="public"){
        doc_sr_code = urlPath[4];
        doc_file_name = urlPath[5];
        application_id = urlPath[6];
        doc_unique_id = urlPath[7];
        application_courses_id = urlPath[8];
       }else{
        doc_sr_code = urlPath[3];
        doc_file_name = urlPath[4];
        application_id = urlPath[5];
        doc_unique_id = urlPath[6];
        application_courses_id = urlPath[7];
       }
         

        let doc_comment = $("#comment_text").val();
        let nc_type = $("#status").find(":selected").val();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        const formData = new FormData();
        formData.append("application_id", application_id);
        formData.append("application_courses_id", application_courses_id);
        formData.append("doc_sr_code", doc_sr_code);
        formData.append("doc_unique_id", doc_unique_id);
        formData.append("nc_type", nc_type);
        formData.append("comments", doc_comment);
        formData.append("doc_file_name", doc_file_name);

        $.ajax({
            url: `${BASE_URL}/desktop/document-verfiy`,
            type: "post",
            datatype: "json",
            data: formData,
            contentType: false,
            processData: false,
            success: function (resdata) {
                if (resdata.success) {
                    toastr.success(resdata.message, {
                        timeOut: 1,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 1,
                    });
                    $('.full_screen_loading').hide();
                    setTimeout(() => {
                        window.location.href = resdata.redirect_to;
                    }, 1000);
                } else {
                    toastr.error(resdata.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });
                    $('.full_screen_loading').hide();
                }
            },
            error: (xhr, st) => {
                $('.full_screen_loading').hide();
                console.log(xhr, "st");
            },
        });
    }
}

function adminDocumentVerfiy(assessor_type) {
    let is_acknowledged = confirm("Are you sure you want to submit?");
    if (is_acknowledged) {
        let urlObject = new URL(window.location.href);
        let urlPath = urlObject.pathname.split("/");

        let doc_sr_code = "";
        let doc_file_name = "";
        let application_id = "";
        let doc_unique_id = "";
        let application_courses_id = "";

        if(urlPath[1]=="public"){
             doc_sr_code = urlPath[5];
             doc_file_name = urlPath[6];
             application_id = urlPath[7];
             doc_unique_id = urlPath[8];
             application_courses_id = urlPath[9];
        }else{
             doc_sr_code = urlPath[4];
             doc_file_name = urlPath[5];
             application_id = urlPath[6];
             doc_unique_id = urlPath[7];
             application_courses_id = urlPath[8];
        }
        
        let doc_comment = $("#comment_text").val();
        let nc_type = $("#status").find(":selected").val();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        const formData = new FormData();
        formData.append("application_id", application_id);
        formData.append("application_courses_id", application_courses_id);
        formData.append("doc_sr_code", doc_sr_code);
        formData.append("doc_unique_id", doc_unique_id);
        formData.append("nc_type", nc_type);
        formData.append("comments", doc_comment);
        formData.append("doc_file_name", doc_file_name);
        formData.append("assessor_type", assessor_type);

        $.ajax({
            url: `${BASE_URL}/admin/document-verfiy`,
            type: "post",
            datatype: "json",
            data: formData,
            contentType: false,
            processData: false,
            success: function (resdata) {
                if (resdata.success) {
                    toastr.success(resdata.message, {
                        timeOut: 1,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 1,
                    });
                    setTimeout(() => {
                        window.location.href = resdata.redirect_to;
                    }, 1000);
                } else {
                    toastr.error(resdata.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });
                }
            },
            error: (xhr, st) => {
                console.log(xhr, "st");
            },
        });
    }
}

function onsiteDocumentVerfiy() {
    let is_acknowledged = confirm("Are you sure you want to submit?");

    if (is_acknowledged) {
        $('.full_screen_loading').show();
        let urlObject = new URL(window.location.href);
        let urlPath = urlObject.pathname.split("/");
        let doc_sr_code = "";
        let doc_file_name = "";
        let application_id = "";
        let doc_unique_id = "";
        let view_type = "";
        
        if(urlPath[1]=='public'){
             doc_sr_code = urlPath[4];
             doc_file_name = urlPath[5];
             application_id = urlPath[6];
             doc_unique_id = urlPath[7];
             view_type = urlPath[9];
        }else{
             doc_sr_code = urlPath[3];
             doc_file_name = urlPath[4];
             application_id = urlPath[5];
             doc_unique_id = urlPath[6];
             view_type = urlPath[8];

        }
       
        let application_courses_id = urlPath[7];
        let doc_comment = $("#comment_text").val();
        let nc_type = $("#status").find(":selected").val();

        var d = $(`#fileup_${doc_unique_id}`)[0].files[0];
        var fileInput = $(`#fileup_${doc_unique_id}`);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        const formData = new FormData();
        formData.append("application_id", application_id);
        formData.append("application_courses_id", application_courses_id);
        formData.append("doc_sr_code", doc_sr_code);
        formData.append("doc_unique_id", doc_unique_id);
        formData.append("nc_type", nc_type);
        formData.append("comments", doc_comment);
        formData.append("doc_file_name", doc_file_name);
        formData.append("fileup", d);
        formData.append("view_type", view_type);

        var allowedExtensions = ["pdf", "doc", "docx"]; // Add more extensions if needed
        var uploadedFileName = fileInput.val();
        var fileExtension = uploadedFileName.split(".").pop().toLowerCase();
        if (allowedExtensions.indexOf(fileExtension) == -1) {
            toastr.error("Invalid file type", {
                timeOut: 1,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 1,
            });
            // Clear the file input
            fileInput.val("");
            $('.full_screen_loading').hide();
            return;
        }

        $.ajax({
            url: `${BASE_URL}/onsite/document-verfiy`,
            type: "post",
            datatype: "json",
            data: formData,
            contentType: false,
            processData: false,
            success: function (resdata) {
                if (resdata.success) {
                    toastr.success(resdata.message, {
                        timeOut: 1,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 1,
                    });
                    $('.full_screen_loading').hide();
                    setTimeout(() => {
                        window.location.href = resdata.redirect_to;
                    }, 1000);
                } else {
                    toastr.error(resdata.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });
                    $('.full_screen_loading').hide();
                }
            },
            error: (xhr, st) => {
                $('.full_screen_loading').hide();
                console.log(xhr, "st");
            },
        });
    }
}

function onsitePhotographUpload(question_id) {
    $(".full_screen_loading").show();

    let is_acknowledged = confirm("Are you sure you want to upload photograph");
    if (is_acknowledged) {
        var d = $(`#fileup_photograph_${question_id}`)[0].files[0];
        var fileInput = $(`#fileup_photograph_${question_id}`);

        let doc_sr_code = $(`#doc_sr_code_${question_id}`).val();
        let application_id = $(`#application_id`).val();
        let doc_unique_id = $(`#doc_unique_id_${question_id}`).val();
        let application_courses_id = $(`#application_courses_id`).val();
        let doc_file_name = d.name;

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        const formData = new FormData();
        formData.append("application_id", application_id);
        formData.append("application_courses_id", application_courses_id);
        formData.append("doc_sr_code", doc_sr_code);
        formData.append("doc_unique_id", doc_unique_id);
        formData.append("doc_file_name", doc_file_name);
        formData.append("fileup_photograph", d);

        var allowedExtensions = ["pdf", "doc", "docx"]; // Add more extensions if needed
        var uploadedFileName = fileInput.val();
        var fileExtension = uploadedFileName.split(".").pop().toLowerCase();
        if (allowedExtensions.indexOf(fileExtension) == -1) {
            toastr.error("Invalid file type", {
                timeOut: 1,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 1,
            });
            // Clear the file input
            fileInput.val("");
            $(".full_screen_loading").hide();
            return;
        }

        $.ajax({
            url: `${BASE_URL}/onsite/upload-photograph`,
            type: "post",
            datatype: "json",
            data: formData,
            contentType: false,
            processData: false,
            success: function (resdata) {
                if (resdata.success) {
                    toastr.success(resdata.message, {
                        timeOut: 1,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 1,
                    });
                    $(".full_screen_loading").hide();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    toastr.error(resdata.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });
                    $(".full_screen_loading").hide();
                }
            },
            error: (xhr, st) => {
                $(".full_screen_loading").hide();
                console.log(xhr, "st");
                toastr.error("Something went wrong!", {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 0,
                });
            },
        });
    }
}

const assessor_dates = [];
$(".dateID").click("on", function () {
    var $this = $(this);
    var dataVal = $(this).attr("data-id").split(",");

    assessor_dates.push(dataVal[3]);
    var colorid = $(this).attr("date-color");
    var data = {
        applicationID: dataVal[0],
        assessorID: dataVal[1],
        assessmentType: dataVal[2],
        selectedDate: dataVal[3],
    };

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        type: "POST",
        url: `${BASE_URL}/save-selected-dates`,
        data: data,
        success: function (response) {
            if (response.message == "deleted") {
                $this.removeClass("btn-danger").addClass("btn-success");
            } else {
                $this.removeClass("btn-success").addClass("btn-danger");
            }
        },
        error: function (error) {
            console.error("Error:", error);
        },
    });
});

$(".assesorsid").on("click", function () {
    var application_id = $(this).data("application-id");
    var assessor_id = $(this).val();
    $(`#assessor_id_`).val(assessor_id);

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: `${BASE_URL}/assigin-check-delete`,
        type: "get",
        data: {
            id: application_id,
            assessor_id,
        },
        success: function (data) {
            //alert(data)
            if (data === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Application has been unassigned from the assessor successfully.",
                }).then(() => {
                    location.reload(true);
                });
            }
        },
    });
});

/*Upload file from onsite assessor for nc's*/
$("#upload_onstie_nc_file").change(function () {

    var fileInput = $(this);
    var questionId = fileInput.data("question-id");
    var form = $("#submitform_doc_form_" + questionId)[0];
    var formData = new FormData(form);
    var allowedExtensions = ["pdf", "doc", "docx"]; // Add more extensions if needed
    var uploadedFileName = fileInput.val();
    

    var fileExtension = uploadedFileName.split(".").pop().toLowerCase();
    if (allowedExtensions.indexOf(fileExtension) == -1) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Invalid File Type",
            text: "Please upload a PDF or DOC file.",
            showConfirmButton: true,
        });
        // Clear the file input
        fileInput.val("");
        return;
    }
    $("#loader").removeClass("d-none");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        url: `${BASE_URL}/tp-add-document`, // Your server-side upload endpoint
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $("#loader").addClass("d-none");
            if (response.success) {
                toastr.success(response.message, {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 0,
                });
                location.reload();
            }
        },
        error: function (xhr, status, error) {
            // Handle errors
            console.error(error);
        },
    });
});

/*nc's end here*/

function handlePdfOrImageForPhotograph(path) {
    let MAIN_URL = BASE_URL + "/level/";
    const fileExtension = path.split(".").pop().toLowerCase();
    $("#view_photograph_onsite").html("");
    if (fileExtension === "pdf") {
        const html =
            '<object data="' +
            MAIN_URL +
            path +
            '" type="application/pdf" width="100%" height="700px"></object>';
        $("#view_photograph_onsite").html(html);
    } else {
        const html =
            '<img src="' +
            MAIN_URL +
            path +
            '" alt="Photograph" title="Photograph" class="img img-responsive"/>';
        $("#view_photograph_onsite").html(html);
    }
}
function handleShowPaymentInformation(pay_txn_no, pay_ref_no, id) {
    $("#payment_transaction_no_err").html("");
    $("#payment_reference_no_err").html("");
    
    if (pay_txn_no != null && pay_ref_no != null && id != null) {
        $("#payment_transaction_no").val("");
        $("#payment_reference_no").val("");

        // Convert the strings to BigInt
        const pay_txn_no_bigint = BigInt(pay_txn_no);
        const pay_ref_no_bigint = BigInt(pay_ref_no);
        console.log(pay_txn_no_bigint.toString(),' skdkd sls ')
        // Set the values of the elements with the BigInt values
        $("#payment_transaction_no").val(pay_txn_no_bigint.toString());
        $("#payment_reference_no").val(pay_ref_no_bigint.toString());
        $("#payment_info_id").val(id);
    } else {
        toastr.success("Something went wrong!", {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 0,
        });
    }
}

function handleUpdatePaymentInformation() {
    const payment_transaction_no = $("#payment_transaction_no").val();
    const payment_reference_no = $("#payment_reference_no").val();
    const payment_info_id = $("#payment_info_id").val();
    var payment_proof = $(`#payment_proof`)[0].files[0];
    var fileInput = $(`#payment_proof`);
    const isValidated = validateForm();
    
    
    if (isValidated) {
        $(".full_screen_loading").show();
        const formData = new FormData();
        formData.append("payment_transaction_no", payment_transaction_no);
        formData.append("payment_reference_no", payment_reference_no);
        formData.append("payment_proof", payment_proof);
        formData.append("id", payment_info_id);

        var allowedExtensions = ["pdf", "doc", "docx"]; // Add more extensions if needed
        var uploadedFileName = fileInput.val();
        var fileExtension = uploadedFileName.split(".").pop().toLowerCase();
        if (allowedExtensions.indexOf(fileExtension) == -1) {
            toastr.error("Invalid file type", {
                timeOut: 1,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 1,
            });
            // Clear the file input
            fileInput.val("");
            $(".full_screen_loading").hide();
            return;
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/tp-update-payment`, // Your server-side upload endpoint
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });
                    $(".full_screen_loading").hide();
                    location.reload();
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });

                    $(".full_screen_loading").hide();
                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                $(".full_screen_loading").hide();
            },
        });
    }else{
        $(".full_screen_loading").hide();
    }
}

function handleUpdatePaymentInformationOfAccount() {
    const payment_transaction_no = $("#payment_transaction_no").val();
    const payment_reference_no = $("#payment_reference_no").val();
    const payment_info_id = $("#payment_info_id").val();
    var payment_proof_by_account = $(`#payment_proof_by_account`)[0].files[0];
    var fileInput = $(`#payment_proof_by_account`);
    const isValidated = validateForm();
  
    if (isValidated) {
        $(".full_screen_loading").show();
        const formData = new FormData();
        formData.append("payment_transaction_no", payment_transaction_no);
        formData.append("payment_reference_no", payment_reference_no);
        formData.append("payment_proof_by_account", payment_proof_by_account);
        formData.append("id", payment_info_id);

        var allowedExtensions = ["pdf", "doc", "docx"]; // Add more extensions if needed
        var uploadedFileName = fileInput.val();
        var fileExtension = uploadedFileName.split(".").pop().toLowerCase();
        if (allowedExtensions.indexOf(fileExtension) == -1) {
            toastr.error("Invalid file type", {
                timeOut: 1,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 1,
            });
            // Clear the file input
            fileInput.val("");
            $(".full_screen_loading").hide();
            return;
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/account-update-payment`, // Your server-side upload endpoint
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });
                    $(".full_screen_loading").hide();
                    location.reload();
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });

                    $(".full_screen_loading").hide();
                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                $(".full_screen_loading").hide();
            },
        });
    }else{
        $(".full_screen_loading").hide();
    }
}

function validateForm() {
    const MIN_MAX_LENGTH = 18;
    let pay_txn_no = $("#payment_transaction_no").val();
    let pay_ref_no = $("#payment_reference_no").val();
    let flag = 0;
    if (pay_txn_no.length != MIN_MAX_LENGTH) {
        flag = 1;
        $("#payment_transaction_no_err")
            .html("Please enter a valid transaction number")
            .show();
    }
    if (pay_ref_no.length != MIN_MAX_LENGTH) {
        flag = 1;
        $("#payment_reference_no_err")
            .html("Please enter a valid reference number")
            .show();
    }

    if (flag == 1) {
        return false;
    } else {
        return true;
    }
}

function handleNotification(pay_id){

    if(pay_id!=null){
       $('.full_screen_loading').show();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/account-update-notification-status/`, // Your server-side upload endpoint
            type: "POST",
            data:{id:pay_id},
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });
                    $('.full_screen_loading').hide();
                    window.location.href=response.redirect_url;
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });

                }
            },
            error: function (xhr, status, error) {
                $('.full_screen_loading').hide();
                // Handle errors
            },
        });
    }else{
        toastr.error("Something went wrong!", {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 0,
        });
        $('.full_screen_loading').hide();
    }
}

function handleAdminNotification(pay_id){
    if(pay_id!=null){
        $('.full_screen_loading').show();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/admin-update-notification-status/`, // Your server-side upload endpoint
            type: "POST",
            data:{id:pay_id},
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    window.location.href=response.redirect_url;
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });

                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                $('.full_screen_loading').hide();
            },
        });
    }else{
        toastr.error("Something went wrong!", {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 0,
        });
    }
}

function handleDesktopNotification(pay_id){
    if(pay_id!=null){
        $('.full_screen_loading').show();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/assessor-desktop-update-notification-status/`, // Your server-side upload endpoint
            type: "POST",
            data:{id:pay_id},
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    window.location.href=response.redirect_url;
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });

                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                $('.full_screen_loading').hide();
            },
        });
    }else{
        toastr.error("Something went wrong!", {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 0,
        });
        $('.full_screen_loading').hide();
    }
}

function handleOnsiteNotification(pay_id){
    if(pay_id!=null){
        $('.full_screen_loading').show();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/assessor-onsite-update-notification-status/`, // Your server-side upload endpoint
            type: "POST",
            data:{id:pay_id},
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    window.location.href=response.redirect_url;
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 0,
                    });

                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                $('.full_screen_loading').hide();
            },
        });
    }else{
        toastr.error("Something went wrong!", {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 0,
        });
        $('.full_screen_loading').hide();
    }
}


$(".remove_err").on("keyup", function () {
    let err_id = $(this).attr("id");
    $(`#${err_id}_err`).html("");
});

