var handlePaymentReceived = () => {
    let urlObject = new URL(window.location.href);
    let encoded_application_id = urlObject.pathname.split("/").pop();
    const fileInput = document.getElementById("payment_proof");
    let payment_remark = $("#payment_remark").val();
    let payment_id = $("#payment_id").val();
    if(payment_remark=="" || payment_remark==null){
        toastr.error("Please enter the remark.", {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 5000,
        });
        return false;
    }
    payment_remark = payment_remark ?? "";
    let formData = new FormData();
    if (fileInput.files.length > 0) {
        formData.append("payment_proof", fileInput.files[0]);
    }
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
                        closeDuration: 5000,
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
                        closeDuration: 5000,
                    });
                    $(".box-overlay-2").hide();
                }
            },
            error: (xhr, st) => {
                console.log(xhr, "st");
            },
        });
   
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
                    closeDuration: 5000,
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
                    closeDuration: 5000,
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
                closeDuration: 5000,
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
                        closeDuration: 5000,
                    });
                    $("#acknowledgement_" + id).hide();
                    $(".full_screen_loading").hide();
                    window.location.reload();
                } else {
                    toastr.error(resdata.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    $(".full_screen_loading").hide();
                }
            },
            error: (xhr, st) => {
                toastr.error("Something went wrong!", {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 5000,
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
        // let urlObject = new URL(window.location.href);
        // let urlPath = urlObject.pathname.split("/");

        let doc_sr_code = $('#desktop_application_doc_sr_code_nc').val();
        let doc_file_name = $('#desktop_application_doc_file_name_nc').val();
        let application_id = $('#desktop_application_id_nc').val();
        let doc_unique_id = $('#desktop_application_doc_unique_code_nc').val();
        let application_courses_id = $('#desktop_application_course_id_nc').val();

    //     let doc_sr_code = "";
    //     let doc_file_name = "";
    //     let application_id = "";
    //     let doc_unique_id = "";
    //     let application_courses_id = "";
       
    //    if(urlPath[1]=="public"){
    //     doc_sr_code = urlPath[4];
    //     doc_file_name = urlPath[5];
    //     application_id = urlPath[6];
    //     doc_unique_id = urlPath[7];
    //     application_courses_id = urlPath[8];
    //    }
    //    else{
    //     doc_sr_code = urlPath[3];
    //     doc_file_name = urlPath[4];
    //     application_id = urlPath[5];
    //     doc_unique_id = urlPath[6];
    //     application_courses_id = urlPath[7];
    //    }
         

        let doc_comment = $("#comment_text").val();
        let nc_type = $("#status").find(":selected").val();
       if(doc_comment=="" || nc_type=="" ){
        toastr.error("All fields are required", {
            timeOut: 1,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 5000,
        });
        $('.full_screen_loading').hide();
        return false;
       }
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
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
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
                        closeDuration: 5000,
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


function secretariatDocumentVerfiy() {
    let is_acknowledged = confirm("Are you sure you want to submit?");
    if (is_acknowledged) {
        $('.full_screen_loading').show();

        let doc_sr_code = $('#secretariat_application_doc_sr_code_nc').val();
        let doc_file_name = $('#secretariat_application_doc_file_name_nc').val();
        let application_id = $('#secretariat_application_id_nc').val();
        let doc_unique_id = $('#secretariat_application_doc_unique_code_nc').val();
        let application_courses_id = $('#secretariat_application_course_id_nc').val();


        let doc_comment = $("#comment_text").val();
        let nc_type = $("#status").find(":selected").val();
       if(doc_comment=="" || nc_type=="" ){
        toastr.error("All fields are required", {
            timeOut: 1,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 5000,
        });
        $('.full_screen_loading').hide();
        return false;
       }
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
            url: `${BASE_URL}/secretariat/document-verfiy`,
            type: "post",
            datatype: "json",
            data: formData,
            contentType: false,
            processData: false,
            success: function (resdata) {
                if (resdata.success) {
                    toastr.success(resdata.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
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
                        closeDuration: 5000,
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
        // let urlObject = new URL(window.location.href);
        // let urlPath = urlObject.pathname.split("/");

        let doc_sr_code = $('#onsite_desktop_application_doc_sr_code_nc').val();
        let doc_file_name = $('#onsite_desktop_application_doc_file_name_nc').val();
        let application_id = $('#onsite_desktop_application_id_nc').val();
        let doc_unique_id = $('#onsite_desktop_application_doc_unique_code_nc').val();
        let application_courses_id = $('#onsite_desktop_application_course_id_nc').val();
     
        
        // let doc_sr_code = "";
        // let doc_file_name = "";
        // let application_id = "";
        // let doc_unique_id = "";
        // let application_courses_id = "";

        // if(urlPath[1]=="public"){
        //      doc_sr_code = urlPath[5];
        //      doc_file_name = urlPath[6];
        //      application_id = urlPath[7];
        //      doc_unique_id = urlPath[8];
        //      application_courses_id = urlPath[9];
        // }else{
        //      doc_sr_code = urlPath[4];
        //      doc_file_name = urlPath[5];
        //      application_id = urlPath[6];
        //      doc_unique_id = urlPath[7];
        //      application_courses_id = urlPath[8];
        // }
        
        let doc_comment = $("#comment_text").val();
        let nc_type = $("#status").find(":selected").val();
        if(doc_comment=="" || nc_type=="" ){
            toastr.error("All fields are required", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 5000,
            });
            $('.full_screen_loading').hide();
            return false;
           }
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
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    setTimeout(() => {
                        window.location.href = resdata.redirect_to;
                    }, 1000);
                } else {
                    toastr.error(resdata.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                }
            },
            error: (xhr, st) => {
                console.log(xhr, "st");
            },
        });
    }
}

function adminCourseDocumentVerfiy(assessor_type) {
    let is_acknowledged = confirm("Are you sure you want to submit?");
    if (is_acknowledged) {

        let doc_sr_code = $('#secretariat_application_doc_sr_code_nc').val();
        let doc_file_name = $('#secretariat_application_doc_file_name_nc').val();
        let application_id = $('#secretariat_application_id_nc').val();
        let doc_unique_id = $('#secretariat_application_doc_unique_code_nc').val();
        let application_courses_id = $('#secretariat_application_course_id_nc').val();
     
        let doc_comment = $("#comment_text").val();
        let nc_type = $("#status").find(":selected").val();
        if(doc_comment=="" || nc_type=="" ){
            toastr.error("All fields are required", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 5000,
            });
            $('.full_screen_loading').hide();
            return false;
           }
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
            url: `${BASE_URL}/super-admin/document-verfiy`,
            type: "post",
            datatype: "json",
            data: formData,
            contentType: false,
            processData: false,
            success: function (resdata) {
                if (resdata.success) {
                    toastr.success(resdata.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    setTimeout(() => {
                        window.location.href = resdata.redirect_to;
                    }, 1000);
                } else {
                    toastr.error(resdata.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
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

        let doc_sr_code = $('#onsite_application_doc_sr_code_nc').val();
        let doc_file_name = $('#onsite_application_doc_file_name_nc').val();
        let application_id = $('#onsite_application_id_nc').val();
        let doc_unique_id = $('#onsite_application_doc_unique_code_nc').val();
        let application_courses_id = $('#onsite_application_course_id_nc').val();

        // let urlObject = new URL(window.location.href);
        // let urlPath = urlObject.pathname.split("/");
        // let doc_sr_code = "";
        // let doc_file_name = "";
        // let application_id = "";
        // let doc_unique_id = "";
        // let view_type = "";
        
        // if(urlPath[1]=='public'){
        //      doc_sr_code = urlPath[4];
        //      doc_file_name = urlPath[5];
        //      application_id = urlPath[6];
        //      doc_unique_id = urlPath[7];
        //      application_courses_id = urlPath[8];
        //      view_type = urlPath[9];
        // }else{
        //      doc_sr_code = urlPath[3];
        //      doc_file_name = urlPath[4];
        //      application_id = urlPath[5];
        //      doc_unique_id = urlPath[6];
        //      application_courses_id = urlPath[7];
        //      view_type = urlPath[8];
        // }
       
       
        let doc_comment = $("#comment_text").val();
        let nc_type = $("#status").find(":selected").val();
        if(doc_comment=="" || nc_type==""){
            toastr.error("All fields are required", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 5000,
            });
            $('.full_screen_loading').hide();
            return false;
           }
          
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
        formData.append("view_type", 'view_type');

        var allowedExtensions = ["pdf", "doc", "docx","jpg","jpeg","png"]; // Add more extensions if needed
        var uploadedFileName = fileInput.val();
        if(uploadedFileName==""){
            toastr.error("All fields are required", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 5000,
            });
            $('.full_screen_loading').hide();
            return false;
           }
        var fileExtension = uploadedFileName.split(".").pop().toLowerCase();
        if (allowedExtensions.indexOf(fileExtension) == -1) {
            toastr.error("Invalid file type", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 5000,
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
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
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
                        closeDuration: 5000,
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

        var allowedExtensions = ["pdf","jpg","jpeg","png"]; // Add more extensions if needed
        var uploadedFileName = fileInput.val();
        var fileExtension = uploadedFileName.split(".").pop().toLowerCase();
        if (allowedExtensions.indexOf(fileExtension) == -1) {
            toastr.error("Invalid file type", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 5000,
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
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
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
                        closeDuration: 5000,
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
                    closeDuration: 5000,
                });
            },
        });
    }else{
        $(".full_screen_loading").hide();
    }
}

const assessor_dates = [];
$(".dateID").click("on", function () {
    var $this = $(this);
    var dataVal = $(this).attr("data-id").split(",");
    console.log(dataVal,' data val ')
    assessor_dates.push(dataVal[3]);
    // $("#assessor_type_"+dataVal[0]).attr("required", true);

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
    var application_id = $(this).attr("application-id");
    var assessor_id = $(this).val();
    $(`#assessor_id_`).val(assessor_id);

    $(`.dateID_${application_id}`).addClass("disabled");

    $(`#assessor_assign_dates_${assessor_id} span.disabled`).removeClass("disabled");
    
    $('.assessor_name_with_email').attr('required',false);

    document.getElementById('assessor_type_' + assessor_id).setAttribute('required', true);
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
                    closeDuration: 5000,
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
        const pay_txn_no_bigint = pay_txn_no;
        const pay_ref_no_bigint = pay_ref_no;
        // Set the values of the elements with the BigInt values
        $("#payment_transaction_no").val(pay_txn_no_bigint.toString());
        $("#payment_reference_no").val(pay_ref_no_bigint.toString());
        $("#payment_info_id").val(id);
    } else {
        toastr.success("Something went wrong!", {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 5000,
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

        var allowedExtensions = ["pdf", "doc", "docx","jpeg","jpg","png"]; // Add more extensions if needed
        var uploadedFileName = fileInput.val();
        var fileExtension = uploadedFileName.split(".").pop().toLowerCase();
       
        if(payment_proof){
            var fileExtension = uploadedFileName.split(".").pop().toLowerCase();
            if (allowedExtensions.indexOf(fileExtension) == -1) {
                toastr.error("Invalid file type", {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 5000,
                });
                // Clear the file input
                fileInput.val("");
                $(".full_screen_loading").hide();
                return;
            }
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
                        closeDuration: 5000,
                    });
                    $(".full_screen_loading").hide();
                    location.reload();
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
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

        var allowedExtensions = ["pdf", "doc", "docx","jpeg","jpg","png"]; // Add more extensions if needed
        var uploadedFileName = fileInput.val();
       if(payment_proof_by_account){
            var fileExtension = uploadedFileName.split(".").pop().toLowerCase();
            if (allowedExtensions.indexOf(fileExtension) == -1) {
                toastr.error("Invalid file type", {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 5000,
                });
                // Clear the file input
                fileInput.val("");
                $(".full_screen_loading").hide();
                return;
            }
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
                        closeDuration: 5000,
                    });
                    $(".full_screen_loading").hide();
                    location.reload();
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
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
    const MIN_LENGTH = 9;
    const MAX_LENGTH = 18;
    let pay_txn_no = $("#payment_transaction_no").val();
    let pay_ref_no = $("#payment_reference_no").val();
    let flag = 0;
    if (pay_txn_no.length >= MIN_LENGTH && pay_txn_no.length<= MAX_LENGTH) {
        
    }else{
        flag = 1;
        $("#payment_transaction_no_err")
            .html("Please enter a valid transaction number")
            .show();
    }

    if (pay_ref_no.length >= MIN_LENGTH && pay_ref_no.length <= MAX_LENGTH) {
    
    }else{
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


function handleTransactionNumberValidation() {
    const payment_transaction_no = $("#payment_transaction_no").val();
    
        const formData = new FormData();
        formData.append("payment_transaction_no", payment_transaction_no);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/tp-payment-transaction-validation`, // Your server-side upload endpoint
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status=='error') {
                    $("#payment_transaction_no_err").html(response.message);
                  $('#update-payment_info').attr('disabled',true)
                }else{
                    $("#payment_transaction_no_err").html("");
                    $('#update-payment_info').attr('disabled',false)
                }
            },
            error: function (xhr, status, error) {
                // Handle errors
            },
        });
}

function debounceTxn(func, timeout = 300){
    let timer;
    return (...args) => {
      clearTimeout(timer);
      timer = setTimeout(() => { func.apply(this, args); }, timeout);
    };
  }

  const handleTransactionNumberValidationDebounce = debounceTxn(() => handleTransactionNumberValidation());


function handleReferenceNumberValidation() {
    const payment_reference_no = $("#payment_reference_no").val();
    
        const formData = new FormData();
        formData.append("payment_reference_no", payment_reference_no);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/tp-payment-reference-validation`, // Your server-side upload endpoint
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response, ' response222')
                if (response.status=='error') {
                    $("#payment_reference_no_err").html(response.message);
                    $('#update-payment_info').attr('disabled',true)
                    $('#submitBtn').attr('disabled',true);
                }else{
                    $("#payment_reference_no_err").html("");
                    $('#update-payment_info').attr('disabled',false)                
                    $('#submitBtn').attr('disabled',false)                
                }
            },
            error: function (xhr, status, error) {
                // Handle errors
            },
        });
}

function debounceRefe(func, timeout = 300){
    let timer;
    return (...args) => {
      clearTimeout(timer);
      timer = setTimeout(() => { func.apply(this, args); }, timeout);
    };
  }
  const handleReferenceNumberValidationDebounce = debounceRefe(() => handleReferenceNumberValidation());


function handleNotification(pay_id){

    if(pay_id!=null){
       $('.full_screen_loading').show();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/account-update-notification-status/${pay_id}`, // Your server-side upload endpoint
            type: "POST",
            data:{id:pay_id},
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    $('.full_screen_loading').hide();
                    setTimeout(()=>{
                        window.location.href=response.redirect_url;
                    },1000)
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
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
            closeDuration: 5000,
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
            url: `${BASE_URL}/admin-update-notification-status/${pay_id}`, // Your server-side upload endpoint
            type: "POST",
            data:{id:pay_id},
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    setTimeout(()=>{
                        window.location.href=response.redirect_url;
                    },1000);
                    
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
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
            closeDuration: 5000,
        });
    }
}

function handleSuperAdminNotification(pay_id){
    if(pay_id!=null){
        $('.full_screen_loading').show();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/super-admin-update-notification-status/${pay_id}`, // Your server-side upload endpoint
            type: "POST",
            data:{id:pay_id},
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    setTimeout(()=>{
                        window.location.href=response.redirect_url;
                    },1000);
                    
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
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
            closeDuration: 5000,
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
            url: `${BASE_URL}/assessor-desktop-update-notification-status/${pay_id}`, // Your server-side upload endpoint
            type: "POST",
            data:{id:pay_id},
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    setTimeout(()=>{
                        window.location.href=response.redirect_url;
                    },1000);

                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
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
            closeDuration: 5000,
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
            url: `${BASE_URL}/assessor-onsite-update-notification-status/${pay_id}`, // Your server-side upload endpoint
            type: "POST",
            data:{id:pay_id},
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    setTimeout(()=>{
                        window.location.href=response.redirect_url;
                    },1000)
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
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
            closeDuration: 5000,
        });
        $('.full_screen_loading').hide();
    }
}

function updateFileName(input) {
    var selectedFileName = "";
    if (input.files && input.files.length > 0) {
        selectedFileName = input.files[0].name;
    }
    var allowedExtensions = ["pdf", "doc", "docx","jpg","png","jpeg"]; // Add more extensions if needed
    var fileExtension = selectedFileName.split(".").pop().toLowerCase();
    if (allowedExtensions.indexOf(fileExtension) == -1) {
        toastr.error("Invalid file type", {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 5000,
        });
        // Clear the file input
        input.value = ""; // Set the value to an empty string
        // Update the displayed file name
        $("#selectedFileName").text("");
        return;
    }
    $("#selectedFileName").text(selectedFileName);
}

$(document).on('keyup', '[name="years[]"]', function() {
    var yearsInputs = document.getElementsByName('years[]');
   
    for (var i = 0; i < yearsInputs.length; i++) {

        if (!isValidNumber(yearsInputs[i].value, 1, 12)) {
            yearsInputs[i].value="";
            // return false;
        }
    }
    return true;
});
$(document).on('keyup', '[name="months[]"]', function() {
    var monthsInputs = document.getElementsByName('months[]');
    // Validate Months
    for (var i = 0; i < monthsInputs.length; i++) {
        if (!isValidNumber(monthsInputs[i].value, 1, 12)) {
            monthsInputs[i].value="";
            // return false;
        }
    }
    return true;
});

$(document).on('keyup', '[name="days[]"]', function() {
    var daysInputs = document.getElementsByName('days[]');
    for (var i = 0; i < daysInputs.length; i++) {
        if (!isValidNumber(daysInputs[i].value, 1, 31)) {
            daysInputs[i].value="";
            // return false;
        }
    }
    return true;
});
$(document).on('keyup', '[name="hours[]"]', function() {
    var hoursInputs = document.getElementsByName('hours[]');
    for (var i = 0; i < hoursInputs.length; i++) {
        if (!isValidNumber(hoursInputs[i].value, 0, 23)) {
            hoursInputs[i].value="";
            // return false;
        }
    }
    return true;
});

function isValidNumber(value, min, max) {
    var number = parseInt(value, 10);
    if((!isNaN(number) && number >= min && number <= max) && isValidInput(value)){
        return true;
    }
    return false;
}
function isValidInput(value) {
    var regex = /^[0-9]+$/;
    return regex.test(value);
}

function handleAssessorDesignation(id, application_id) {
    console.log(id,' first id ')
    const assessor_designation = $('#' + id + ' option:selected').val();
    $("#assessor_category_" + application_id).val(assessor_designation);
    $("#assessor_designation_" + application_id).val("atab_assessor");
 }
 


 $(document).ready(() => {
    const today = new Date();
    
    const day = today.getDate();
    const month = today.getMonth() + 1;
    const year = today.getFullYear();
    const output =(day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + year;
    $('#summary_date').val(output);
    $('#payment_date').val(output);
  
});


$(document).on('change focus','.select2-selection--multiple',function(){
    $(".select2.remove_err_input_error.courses_error").removeClass('courses_error');
})

  function handleOnsiteSummerySubmitReport(){
    const assessee_org = $("#assessee_org").val();
    const improve_assessee_org = $("#improve_assessee_org").val();
    const brief_open_meeting = $("#brief_open_meeting").val();
    const brief_summary = $("#brief_summary").val();
    const brief_closing_meeting = $("#brief_closing_meeting").val();
    const sr_no = $("#sr_no").val();
    const improvement_form = $("#improvement_form").val();
    const standard_reference = $("#standard_reference").val();

    let flag = 0;
    if(assessee_org==""){
        $("#assessee_org_err").html("Please enter the assessee org value");
        flag=1;
    }
    if(brief_open_meeting==""){
        $("#brief_open_meeting_err").html("Please enter the brief open meeting value");
        flag=1;
    }
    if(brief_summary==""){
        $("#brief_summary_err").html("Please enter the brief summary value");
        flag=1;
    }
    if(brief_closing_meeting==""){
        $("#brief_closing_meeting_err").html("Please enter the brief closing value");
        flag=1;
    }
    if(sr_no==""){
        $("#sr_no_err").html("Please enter serial number");
        flag=1;
    }
    if(improvement_form==""){
        $("#improvement_form_err").html("Please enter improvement form value");
        flag=1;
    }
    if(standard_reference==""){
        $("#standard_reference_err").html("Please enter standard reference value");
        flag=1;
    }
    if(improve_assessee_org==""){
        $("#improve_assessee_org_err").html("Please enter imporve assessee org value");
        flag=1;
    }
    if(flag==1){
        return false;
    }else{
        return true;
    }

  }

  function handleCourseValidation() {
    const course_names = document.getElementsByName('course_name[]');
    const years = document.getElementsByName('years[]');
    const months = document.getElementsByName('months[]');
    const days = document.getElementsByName('days[]');
    const hours = document.getElementsByName('hours[]');
    const eligibility = document.getElementsByName('eligibility[]');
    const mode_of_course = document.getElementsByName('mode_of_course[1][]');
    const course_brief = document.getElementsByName('course_brief[]');
    const docs1 = document.getElementsByName('doc1[]');
    const docs2 = document.getElementsByName('doc2[]');
    const docs3 = document.getElementsByName('doc3[]');
    course_names.forEach((elem,i)=>{
        if(elem.value==""){
            $(elem).addClass('courses_error');
        }
    });
    years.forEach((elem)=>{
        if(elem.value==""){
            $(elem).addClass('courses_error');
        }
    });
    months.forEach((elem)=>{
        if(elem.value==""){
            $(elem).addClass('courses_error');
        }
    });
    days.forEach((elem)=>{
        if(elem.value==""){
            $(elem).addClass('courses_error');
        }
    });
    hours.forEach((elem)=>{
        if(elem.value==""){
            $(elem).addClass('courses_error');
        }
    });
    eligibility.forEach((elem)=>{
        if(elem.value==""){
            $(elem).addClass('courses_error');
        }
    });

    mode_of_course.forEach((elem)=>{
        console.log(elem,' element')
        if(elem.value==""){
            $('[name="mode_of_course[1][]"]').addClass('courses_error');
        }
    });

    $("select.remove_err_input_error option").each(function (index, elem) {
        if (mode_of_course[index] === "") {
            $(elem).addClass('courses_error');
        }
  })

    course_brief.forEach((elem)=>{
        if(elem.value==""){
            $(elem).addClass('courses_error');
        }
    });

    docs1.forEach((elem)=>{
        if(elem.value==""){
            $(elem).addClass('courses_error');
        }
    });

    docs2.forEach((elem)=>{
        if(elem.value==""){
            $(elem).addClass('courses_error');
        }
    });

    docs3.forEach((elem)=>{
        if(elem.value==""){
            $(elem).addClass('courses_error');
        }
    });
  }

  $("#tp_remark").on('keyup',function(){
        const value = $(this).val();
        if(value.length>100){
            $('#tp_remark_err').html('The max character of the length is 100');
            $("#tp_remark_sb_btn").attr('disabled',true);
        }else{
            $("#tp_remark_sb_btn").attr('disabled',false);
        }
  });

$(".remove_err").on("keyup", function () {
    let err_id = $(this).attr("id");
    $(`#${err_id}_err`).html("");
});

function handleShowCoursePayment(){
    const payments = $("#payments option:selected").val();
    const payment_transaction_no = $("#payment_transaction_no").val();
    const payment_reference_no = $("#payment_reference_no").val();
    const payment_details_file = $("#payment_details_file").val();
    if(payments!="" && payment_transaction_no!="" && payment_reference_no!="" && payment_details_file!=""){
        $("#submitBtn").attr('disabled',true);
        return true;
    }
    return false;
}



function removeCourseByTP(app_id,course_id){
    const delete_course_flag = window.confirm("Are you sure to delete course");
    if(app_id!=null && delete_course_flag){
        $('.full_screen_loading').show();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/tp-delete-course/${app_id}/${course_id}`, // Your server-side upload endpoint
            type: "post",
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    setTimeout(()=>{
                        window.location.reload();
                    },1000);
                    
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });

                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                $('.full_screen_loading').hide();
                toastr.error("Something went wrong!", {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 5000,
                });
            },
        });
    }
}


$(document).on('keyup change', '.remove_err_input_error', function () {
    $(this).removeClass('courses_error');
});


$(document).on('change', '.select2-selection select2-selection--multiple', function () {
    $(this).removeClass('courses_error');
});
