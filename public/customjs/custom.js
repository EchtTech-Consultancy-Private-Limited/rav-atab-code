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
    if (final_payment_remark == "") {
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


var handleAdditionalPaymentReceived = () => {
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
            url: `${BASE_URL}/account-additional-payment-received`,
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
function handleAdditionalPaymentApproved() {
    let urlObject = new URL(window.location.href);
    let encoded_application_id = urlObject.pathname.split("/").pop();
    let final_payment_remark = $("#final_payment_remark").val();
    final_payment_remark = final_payment_remark ?? "";
    if (final_payment_remark == "") {
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
        url: `${BASE_URL}/account-additional-payment-approved`,
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
        if (id == "" || id == null || id == undefined) {
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
    
        let doc_sr_code = $('#desktop_application_doc_sr_code_nc').val();
        let doc_file_name = $('#desktop_application_doc_file_name_nc').val();
        let application_id = $('#desktop_application_id_nc').val();
        let doc_unique_id = $('#desktop_application_doc_unique_code_nc').val();
        let application_courses_id = $('#desktop_application_course_id_nc').val();


        let doc_comment = $("#comment_text").val();
        let nc_type = $("#status").find(":selected").val();
        if(doc_comment=="" && nc_type=="Accept"){
            
        }else if(doc_comment=="" || nc_type==""){
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

function secretariatDocumentVerfiyLevel2() {
    let is_acknowledged = confirm("Are you sure you want to submit?");
    if (is_acknowledged) {
        $('.full_screen_loading').show();
        // let urlObject = new URL(window.location.href);
        // let urlPath = urlObject.pathname.split("/");

        let doc_sr_code = $('#secretariat_application_doc_sr_code_nc').val();
        let doc_file_name = $('#secretariat_application_doc_file_name_nc').val();
        let application_id = $('#secretariat_application_id_nc').val();
        let doc_unique_id = $('#secretariat_application_doc_unique_code_nc').val();
        let application_courses_id = $('#secretariat_application_course_id_nc').val();

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
    if(doc_comment=="" && nc_type=="Accept"){
        
    }else if(doc_comment=="" || nc_type==""){
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
            url: `${BASE_URL}/secretariat/document-verfiy-level-2`,
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
        if(doc_comment=="" && nc_type=="Accept"){
            
        }else if(doc_comment=="" || nc_type==""){
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

function superAdminDocumentVerfiy(assessor_type) {
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

function superadminCourseDocumentVerfiy(assessor_type) {
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
            url: `${BASE_URL}/super-admin/document-verfiy-level-2`,
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
        let doc_comment = $("#comment_text").val();
        let nc_type = $("#status").find(":selected").val();
        if(doc_comment=="" && nc_type=="Accept"){
            
        }else if(doc_comment=="" || nc_type==""){
            toastr.error("All fields are required", {
                timeOut: 1,
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
                $("#onsite_date_selection_footer").show();
            } 
            else if(response.message=="failed"){
                $this.removeClass("btn-danger").addClass("btn-success");
                toastr.error("Please select consecutive dates", {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 5000,
                });
                $("#onsite_date_selection_footer").hide();
            }
            else if(response.message=="all_deleted"){
                document.querySelectorAll('.dateID').forEach(function(element) {
                    element.classList.remove("btn-danger");
                    element.classList.add("btn-success");
                });
                toastr.error("Please select consecutive dates", {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 5000,
                });
                $("#onsite_date_selection_footer").hide();
            }
            else {
                if(dataVal[2]==1){
                    document.querySelectorAll('.dateID').forEach(function(element) {
                        element.classList.remove("btn-danger");
                        element.classList.add("btn-success");
                    });
                    $this.removeClass("btn-success").addClass("btn-danger");
                }else{
                    $("#onsite_date_selection_footer").show();    
                    $this.removeClass("btn-success").addClass("btn-danger");
                }
                
            }
            
        },
        error: function (error) {
            console.error("Error:", error);
        },
    });
});
$(document).ready(()=>{
    $('#level_proceed').on('click',function(){
        const isChecked = $('input[name="level_proceed"]:checked').val();
        if(isChecked=='on'){
            $("#t_a_c").attr('disabled',false);
        }else{
            $("#t_a_c").attr('disabled',true);
        }

    })
    
})
$(".assesorsid").on("click", function () {
    var application_id = $(this).attr("application-id");
    var assessor_id = $(this).val();
    $(`#assessor_id_`).val(assessor_id);
    const assessor_type = $(`#assessor_types_${application_id}`).val();
    if(assessor_type!="onsite"){
        $(`.dateID_${application_id}`).addClass("disabled");
    }

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
            if (data == "success") {
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
    if (fileExtension == "pdf") {
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

function handleShowAdditionalPaymentInformation(pay_txn_no, pay_ref_no, id) {
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

function handleUpdateAdditionalPaymentInformationOfAccount() {
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
            url: `${BASE_URL}/account-update-additional-payment`, // Your server-side upload endpoint
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
                        window.location.href=BASE_URL+response.redirect_url;
                    },1000)
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    setTimeout(()=>{
                        window.location.href=response.redirect_url;
                    },1000)
                    $('.full_screen_loading').hide();
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
                        window.location.href=`${BASE_URL}${response.redirect_url}`;
                    },2000);
                    
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    $('.full_screen_loading').hide();
                    setTimeout(()=>{
                        window.location.href=response.redirect_url;
                    },1000)
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
                        window.location.href=BASE_URL+response.redirect_url;
                    },2000);
                    
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    $('.full_screen_loading').hide();
                    setTimeout(()=>{
                        window.location.href=BASE_URL+response.redirect_url;
                    },1000)
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
                        window.location.href=BASE_URL+response.redirect_url;
                    },2000);

                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    $('.full_screen_loading').hide();
                    setTimeout(()=>{
                        window.location.href=BASE_URL+response.redirect_url;
                    },1000)
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
                        window.location.href=BASE_URL+response.redirect_url;
                    },1000)
                }else{
                    toastr.error(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    $('.full_screen_loading').hide();
                    setTimeout(()=>{
                        window.location.href=BASE_URL+response.redirect_url;
                    },1000)
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
$(document).on('keyup change', '[name="months[]"]', function() {
    var monthsInputs = document.getElementsByName('months[]');
    // Validate Months
    for (var i = 0; i < monthsInputs.length; i++) {
        if (!isValidNumber(monthsInputs[i].value, 0, 11)) {
            monthsInputs[i].value="";
            // return false;
        }
    }
    return true;
});

$(document).on('keyup', '[name="days[]"]', function() {
    var daysInputs = document.getElementsByName('days[]');
    for (var i = 0; i < daysInputs.length; i++) {
        if (!isValidNumber(daysInputs[i].value, 0, 29)) {
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
    const brief_open_meeting = $("#brief_open_meeting").val();
    const brief_summary = $("#brief_summary").val();
    const brief_closing_meeting = $("#brief_closing_meeting").val();
    const sr_no = $("#sr_no").val();
    const improvement_form = $("#improvement_form").val();
    const standard_reference = $("#standard_reference").val();
    const improve_assessee_org = $("#improve_assessee_org").val();
    const comment_text = $("#comment_text").val();

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
    if(comment_text==""){
        $("#comment_text_err").html("Please enter remarks.");
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

    mode_of_course.forEach((elem) => {
        if (elem.value == "") {
            $(elem).addClass('courses_error');
        } else {
            $(elem).removeClass('courses_error'); // Optionally remove the error class if it's not empty
        }
    });

    $("select.remove_err_input_error option").each(function (index, elem) {
        if (mode_of_course[index] == "") {
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



  function handleImporveMentForm(){
    const sr_no = $("#serial_number").val();
    const improvement_form = $("#improvement_form").val();
    const standard_reference = $("#standard_reference").val();
    const improve_assessee_org = $("#improve_assessee_org").val();
    const formType = $("#formType").val();

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
    if(comment_text==""){
        $("#comment_text_err").html("Please enter remarks.");
        flag=1;
    }
    if(flag==1){
        return false;
    }else{
        return true;
    }
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

function handleShowCoursePaymentFee(){
    const payments = $("#payments option:selected").val();
    const payment_transaction_no = $("#payment_transaction_no").val();
    const payment_reference_no = $("#payment_reference_no").val();
    const payment_details_file = $("#payment_details_file").val();
    const amount = $("#fee_amount").val();
    const payment_type = $("#payment_type option:selected").val();
    
    if(payments!="" && payment_transaction_no!="" && payment_reference_no!="" && payment_details_file!="" && amount!="" && payment_type!=""){
        $("#submitBtn").attr('disabled',true);
        return true;
    }
    return false;
}
$('.show_hide_amt').hide();
function getAdditionalPaymentDetails(){
    const payments = $("#payment_type option:selected").val();
    const application_id = $('#application_id').val();
    if(payments!=null){
        $('.full_screen_loading').show();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        
        if(payments=="OTHER"){
            $('.show_hide_amt').show();
            $('#fee_amount').attr('required',true)
        }else{
            $('.show_hide_amt').hide();
        }
        $.ajax({
            url: `${BASE_URL}/tp/get-total-amount`,
            type: "POST",
            data:{level:payments,application_id:application_id},
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    $('#total_add_fee').html(response.total);
                    $('#secretariat_amount').html(response.total);

                }else{
                    $('.full_screen_loading').hide();
                    $('#total_add_fee').html("N/A");
                    $('#secretariat_amount').html("N/A");
                    // toastr.error(response.message, {
                    //     timeOut: 0,
                    //     extendedTimeOut: 0,
                    //     closeButton: true,
                    //     closeDuration: 5000,
                    // });

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

function handleOnChange(){
    const total = $('#fee_amount').val();
    $('#total_add_fee').html(total);
    $('#secretariat_amount').html(total);
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
                    },2000);
                    
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


function setRejectionCourseId(application_id,course_id,course_name){
   $("#reject_app_id").val(application_id);
   $('#reject_course_id').val(course_id);
   document.getElementById('rejectionCourseName').innerHTML = course_name
}



function handleRejectCourse(){
    const application_id = $('#reject_app_id').val();
    const course_id = $('#reject_course_id').val();
    

    if(application_id!=null && course_id!=null ){
        $('.full_screen_loading').show();
        const rejectCourseRemark = $("#rejectionCouurseReasonRemark").val();
        if(rejectCourseRemark==""){
            $('.full_screen_loading').hide();
            toastr.error("Please enter the remarks first.", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 5000,
            });
            return false;
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/secretariat/reject-course/${application_id}/${course_id}`,
            type: "POST",
            data:{application_id:application_id,course_id:course_id,reject_remark:rejectCourseRemark},
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    $("#rejectionCouurseReasonRemark").val("");
                    setTimeout(()=>{
                        window.location.reload();
                    },2000);
                    
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


function setModelData(application_id,course_id,course_name,action){
    $("#reject_app_id").val(application_id);
    $('#reject_course_id').val(course_id);
    document.getElementById('rejectionCourseName').innerHTML = course_name
    document.getElementById('approveCourseName').innerHTML = course_name
 }
 
function handleRejectCourseByAdmin(){
    const application_id = $('#reject_app_id').val();
    const course_id = $('#reject_course_id').val();
    
    if(application_id!=null && course_id!=null ){
        $('.full_screen_loading').show();
        const courseRemark = $("#rejectionCourseReasonRemark").val();
        if(courseRemark==""){
            $('.full_screen_loading').hide();
            toastr.error("Please enter the remarks first.", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 5000,
            });
            return false;
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/super-admin-reject-course`,
            type: "POST",
            data:{application_id:application_id,course_id:course_id,remark:courseRemark},
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    $("#rejectionCouurseReasonRemark").val("");
                    setTimeout(()=>{
                        window.location.reload();
                    },2000);
                    
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

function handleAcceptCourseByAdmin(){
    const application_id = $('#reject_app_id').val();
    const course_id = $('#reject_course_id').val();
   
    if(application_id!=null && course_id!=null ){
        $('.full_screen_loading').show();
        const approveCourseRemark = $("#approveCourseReasonRemark").val();
        if(approveCourseRemark==""){
            $('.full_screen_loading').hide();
            toastr.error("Please enter the remarks first.", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 5000,
            });
            return false;
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/super-admin-approved-course`,
            type: "POST",
            data:{application_id:application_id,course_id:course_id,approve_remark:approveCourseRemark},
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    $("#approveCourseReasonRemark").val("");
                    setTimeout(()=>{
                        window.location.reload();
                    },2000);
                    
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

function handleRejectApplicationByAdmin(){

    const application_id = $('#reject_app_id').val();
    const course_id = $('#reject_course_id').val();
    
    if(application_id!=null && course_id!=null ){
        $('.full_screen_loading').show();
        const applicationRemark = $("#rejectionApplicationReasonRemark").val();
        if(applicationRemark==""){
            $('.full_screen_loading').hide();
            toastr.error("Please enter the remarks first.", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 5000,
            });
            return false;
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/super-admin-reject-application/${application_id}`,
            type: "POST",
            data:{application_id:application_id,course_id:course_id,remark:applicationRemark},
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    $("#rejectionCouurseReasonRemark").val("");
                    setTimeout(()=>{
                        window.location.reload();
                    },2000);
                    
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

function handleAcceptApplicationByAdmin(){
    const application_id = $('#reject_app_id').val();
    const course_id = $('#reject_course_id').val();
   
    if(application_id!=null && course_id!=null ){
        $('.full_screen_loading').show();
        const approveApplicationRemark = $("#approveApplicationReasonRemark").val();
        if(approveApplicationRemark==""){
            $('.full_screen_loading').hide();
            toastr.error("Please enter the remarks first.", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 5000,
            });
            return false;
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/super-admin-approved-application`,
            type: "POST",
            data:{application_id:application_id,course_id:course_id,approve_remark:approveApplicationRemark},
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    $("#approveCourseReasonRemark").val("");
                    setTimeout(()=>{
                        window.location.reload();
                    },2000);
                    
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



function handleRaiseQueryForAdditionalPayment(){
    const application_id = $('#application_id').val();
    const payment_type = $('select#payment_type option:selected').val();
    const raise_query_remark = $('#raise_query_remark').val();
    let fee_amount = $('#fee_amount').val();
    if(!fee_amount){
        fee_amount=0;
    }

    if(application_id!=null && raise_query_remark!=null){
        $('.full_screen_loading').show();
        if(raise_query_remark==""){
            $('.full_screen_loading').hide();
            toastr.error("Please enter query raise remark.", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 5000,
            });
            return false;
        }
        if(payment_type==""){
            $('.full_screen_loading').hide();
            toastr.error("Please select payment type.", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 5000,
            });
            return false;
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/admin/raise/payment/query`,
            type: "POST",
            data:{application_id:application_id,raise_query_remark:raise_query_remark,level:payment_type,fee_amount:fee_amount},
            success: function (response) {
                if (response.success) {
                    $('.full_screen_loading').hide();
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    $("#raise_query_remark").val("");
                    setTimeout(()=>{
                        window.location.reload();
                    },2000);
                    
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


function setPayModalData(application_id){
    $("#application_id").val(application_id);
 }


 var handleAdditionalPaymentReceived = () => {
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
            url: `${BASE_URL}/account-additional-payment-received`,
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
function handleAdditionalPaymentApproved() {
    let urlObject = new URL(window.location.href);
    let encoded_application_id = urlObject.pathname.split("/").pop();
    let final_payment_remark = $("#final_payment_remark").val();
    final_payment_remark = final_payment_remark ?? "";
    if (final_payment_remark == "") {
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
        url: `${BASE_URL}/account-additional-payment-approved`,
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



function handleRevertAction(application_id,course_id,doc_file_name){
    const is_confirm = confirm('Are you sure to revert the action?');
    if(is_confirm){
        const formData = new FormData();

        formData.append('application_id',application_id);
        formData.append('course_id',course_id);
        formData.append('doc_file_name',doc_file_name);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/secretariat-revert-course-doc-action`,
            type: "post",
            datatype: "json",
            data:formData,
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
    
}


function handleRevertActionOnDocList(application_id,course_id,doc_file_name){
    const is_confirm = confirm('Are you sure to revert the action?');
    if(is_confirm){
        const formData = new FormData();

        formData.append('application_id',application_id);
        formData.append('course_id',course_id);
        formData.append('doc_file_name',doc_file_name);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/secretariat-revert-doc-list-action`,
            type: "post",
            datatype: "json",
            data:formData,
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
    
}


function handleTPRevertAction(application_id,course_id,doc_file_name,doc_sr_code){
    const is_confirm = confirm('Are you sure to revert the action?');
    if(is_confirm){
        const formData = new FormData();

        formData.append('application_id',application_id);
        formData.append('course_id',course_id);
        formData.append('doc_file_name',doc_file_name);
        formData.append('doc_sr_code',doc_sr_code);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/tp-revert-course-doc-action`,
            type: "post",
            datatype: "json",
            data:formData,
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
    
}

function handleTPRevertActionOnDocList(application_id,course_id,doc_file_name,doc_sr_code){
    const is_confirm = confirm('Are you sure to revert the action?');
    if(is_confirm){
        const formData = new FormData();

        formData.append('application_id',application_id);
        formData.append('course_id',course_id);
        formData.append('doc_file_name',doc_file_name);
        formData.append('doc_sr_code',doc_sr_code);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/tp-revert-doc-list-action`,
            type: "post",
            datatype: "json",
            data:formData,
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
    
}



function handleRevertActionOnDocListDesktop(application_id,course_id,doc_file_name){
    const is_confirm = confirm('Are you sure to revert the action?');
    if(is_confirm){
        const formData = new FormData();

        formData.append('application_id',application_id);
        formData.append('course_id',course_id);
        formData.append('doc_file_name',doc_file_name);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/desktop-revert-doc-list-action`,
            type: "post",
            datatype: "json",
            data:formData,
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
    
}


function handleRevertActionOnDocListOnsite(application_id,course_id,doc_file_name){
    
    const is_confirm = confirm('Are you sure to revert the action?');
    if(is_confirm){
        const formData = new FormData();

        formData.append('application_id',application_id);
        formData.append('course_id',course_id);
        formData.append('doc_file_name',doc_file_name);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/onsite-revert-doc-list-action`,
            type: "post",
            datatype: "json",
            data:formData,
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
    
}



function handleRevertRejectAction(application_id,course_id){
    const is_confirm = confirm('Are you sure to revert the action?');
    if(is_confirm){
        const formData = new FormData();
        formData.append('application_id',application_id);
        formData.append('course_id',course_id);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: `${BASE_URL}/secretariat-revert-course-reject`,
            type: "post",
            datatype: "json",
            data:formData,
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
    
}

function handleSecretariatFinalSummary(){
    const remark = $("#comment_text").val();
    if(remark==""){
        toastr.error("Please enter the remark", {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 5000,
        });
    }else{
        const form = document.getElementById('secretariatForm');
        var newInput1 = document.createElement('input');
        newInput1.setAttribute('type', 'hidden');
        newInput1.setAttribute('name', 'comment_text');
        newInput1.setAttribute('value', remark);
        form.appendChild(newInput1);
        return true;

    }
    return false;
}

function handleAssignBothAssessor(application_id){
        window.localStorage.setItem('assessor',true);
        window.localStorage.setItem('application_id',application_id);
        window.location.href=BASE_URL+"/admin/application-list";
}
function handleAdminAssignAssessorValidation(){
    window.localStorage.setItem('assessor',false);
    window.localStorage.setItem('application_id',null);
}
function beforeSubmit(){
    var fileInput = $(`#mom`).val();
    if(fileInput==""){
        toastr.error("Please first upload MoM", {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 5000,
        });
        return false;
    }else{
        return true
    }
    
}

function handleLevel(){
    const value = $(`#level_proceed`).val();
    alert(value)
    if(value==""){
        toastr.error("Please first accept terms and conditions", {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 5000,
        });
        return false;
    }else{
        return true
    }
    
}

function adminMomOrApproveApplication() {
    let is_acknowledged = confirm("Are you sure you want to submit?");
    if (is_acknowledged) {
        $('.full_screen_loading').show();

        let doc_comment = $("#comment_text").val();
        let action = $("#status").find(":selected").val();
        const application_id = $('#application_id').val();
        const mom_id = $('#mom_id').val();

        if(doc_comment=="" || action==""){
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
        formData.append('application_id',application_id);
        formData.append('action',action);
        formData.append('comment',doc_comment);
        formData.append('mom_id',mom_id);
        $.ajax({
            url: `${BASE_URL}/admin/return/mom`,
            type: "post",
            datatype: "json",
            data:formData,
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
                        window.location.href = resdata.redirectTo;
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

$(document).ready(function() {
    $('#mom').change(function() {
      $('.full_screen_loading').show();
       const mom = $(`#mom`)[0].files[0];
       const application_id = $('#application_id').val();
       const fileInput = $(`#mom`);

        const formData = new FormData();
        formData.append("application_id", application_id);
        formData.append("mom", mom);
        
        var allowedExtensions = ['pdf', 'doc', 'docx']; // Add more extensions if needed
        var uploadedFileName = fileInput.val();
        var fileExtension = uploadedFileName.split('.').pop().toLowerCase();
        if (allowedExtensions.indexOf(fileExtension) == -1) {
            toastr.error("Please upload a PDF or DOC file.", "Invalid file type",{
                      timeOut: 0,
                      extendedTimeOut: 0,
                      closeButton: true,
                      closeDuration: 5000,
                  });
            $('.full_screen_loading').hide();
            fileInput.val('');
            return;
        }
      //   $("#loader").removeClass('d-none');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `${BASE_URL}/secretariat/upload-mom`, // Your server-side upload endpoint
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
               //  $("#loader").addClass('d-none');
               $('.full_screen_loading').hide();
                if (response.success) {
                  toastr.success(response.message, {
                      timeOut: 0,
                      extendedTimeOut: 0,
                      closeButton: true,
                      closeDuration: 5000,
                  });
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                $('.full_screen_loading').hide();
                toastr.error("Something went wrong!", {
                      timeOut: 0,
                      extendedTimeOut: 0,
                      closeButton: true,
                      closeDuration: 5000,
                  });
            }
        });
    });

});



$(document).ready(function() {
// signed copy
$('#sigend_copy_').change(function() {
    $('.full_screen_loading').show();
    const course_id = $(this).attr('data-course-id');

     const signed_copy = $(this)[0].files[0];
     const fileInput = $(this);
     console.log(fileInput,' file input');
     
      const formData = new FormData();
      formData.append("course_id", course_id);
      formData.append("signed_copy_desktop", signed_copy);
      
      var allowedExtensions = ['pdf', 'jpeg', 'jpg','png']; // Add more extensions if needed
      var uploadedFileName = fileInput.val();
      var fileExtension = uploadedFileName.split('.').pop().toLowerCase();
      if (allowedExtensions.indexOf(fileExtension) == -1) {
          toastr.error("Please upload a PDF or image.", "Invalid file type",{
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 5000,
                });
          $('.full_screen_loading').hide();
          fileInput.val('');
          return;
      }
    //   $("#loader").removeClass('d-none');
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
          url: `${BASE_URL}/desktop/upload/signed-copy`, // Your server-side upload endpoint
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
             //  $("#loader").addClass('d-none');
             $('.full_screen_loading').hide();
              if (response.success) {
                toastr.success(response.message, {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 5000,
                });
                setTimeout(()=>{
                    window.location.reload();
                },500)
              }
          },
          error: function(xhr, status, error) {
              console.error(error);
              $('.full_screen_loading').hide();
              toastr.error("Something went wrong!", {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 5000,
                });
          }
      });
  });



});


$(document).ready(function() {
    // signed copy
    $('#signed_copy').change(function() {
        
        $('.full_screen_loading').show();
        const application_id = $(this).attr('data-app-id');
    
         const signed_copy = $(this)[0].files[0];
         const fileInput = $(this);
         
         
          const formData = new FormData();
          formData.append("application_id", application_id);
          formData.append("signed_copy_onsite", signed_copy);
          
          var allowedExtensions = ['pdf', 'jpeg', 'jpg','png']; // Add more extensions if needed
          var uploadedFileName = fileInput.val();
          var fileExtension = uploadedFileName.split('.').pop().toLowerCase();
          if (allowedExtensions.indexOf(fileExtension) == -1) {
              toastr.error("Please upload a PDF or image.", "Invalid file type",{
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
              $('.full_screen_loading').hide();
              fileInput.val('');
              return;
          }
        //   $("#loader").removeClass('d-none');
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
    
          $.ajax({
              url: `${BASE_URL}/onsite/upload/signed-copy`, // Your server-side upload endpoint
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function(response) {
                 //  $("#loader").addClass('d-none');
                 $('.full_screen_loading').hide();
                  if (response.success) {
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                    setTimeout(()=>{
                        window.location.reload();
                    },500)
                  }else{
                    $('.full_screen_loading').hide();
                    toastr.success(response.message, {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                  }
              },
              error: function(xhr, status, error) {
                  $('.full_screen_loading').hide();
                  toastr.error("Something went wrong!", {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
              }
          });
      });
    
    
    
    });
    


$(document).on('keyup change', '.remove_err_input_error', function () {
    $(this).removeClass('courses_error');
});


$(document).on('change', '.select2-selection select2-selection--multiple', function () {
    $(this).removeClass('courses_error');
});



$(document).ready(function(){
    document.querySelector('.add-row-btn').addEventListener('click', function () {
        var newRow = `
        <tr>
            <td><input type="text" class="form-control" name="serial_number[]" placeholder="Enter Serial number" required></td>
            <td><input type="text" class="form-control" name="standard_reference[]" placeholder="Enter Standard Reference" required></td>
            <td><input type="text" class="form-control" name="improvement_form[]" placeholder="Enter Improvement form" required></td>
            <td><input type="text" class="form-control" name="improve_assessee_org[]" placeholder="Enter improve assessee org" required></td>
            <td><button type="button" class="btn btn-danger remove-row-btn">-</button></td>
        </tr>`;
        document.querySelector('#form-body').insertAdjacentHTML('beforeend', newRow);
        attachRemoveRowEvent();
    });

    function attachRemoveRowEvent() {
        document.querySelectorAll('.remove-row-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                btn.closest('tr').remove();
            });
        });
    }
    attachRemoveRowEvent();
})
$(document).ready(function(){
    document.querySelector('.add-row-btn-update').addEventListener('click', function () {
        var newRow = `
        <tr>
            <td><input type="text" class="form-control" name="serial_number[]" placeholder="Enter Serial number" required></td>
            <td><input type="text" class="form-control" name="standard_reference[]" placeholder="Enter Standard Reference" required></td>
            <td><input type="text" class="form-control" name="improvement_form[]" placeholder="Enter Improvement form" required></td>
            <td><input type="text" class="form-control" name="improve_assessee_org[]" placeholder="Enter improve assessee org" required></td>
            <td><button type="button" class="btn btn-danger remove-row-btn-update">-</button></td>
        </tr>`;
        document.querySelector('#form-body-update').insertAdjacentHTML('beforeend', newRow);
        attachRemoveRowEvent();
    });

    function attachRemoveRowEvent() {
        document.querySelectorAll('.remove-row-btn-update').forEach(function (btn) {
            btn.addEventListener('click', function () {
                btn.closest('tr').remove();
            });
        });
    }
    attachRemoveRowEvent();
})

    

$(document).ready(function() {
    $("#dateInput").datepicker({
        minDate: 0,
        dateFormat: 'yy-mm-dd'
    });

    $("#timeInput").timepicker({
        timeFormat: 'hh:mm TT',
        onSelect: function(timeText) {
            // Convert timeText to 24-hour format
            let [time, period] = timeText.split(' ');
            let [hours, minutes] = time.split(':');
            if (period === 'PM' && hours < 12) {
                hours = parseInt(hours, 10) + 12;
            } else if (period === 'AM' && hours == 12) {
                hours = 0;
            }
            hours = hours.toString().padStart(2, '0');
            $("#timeInput").val(`${hours}:${minutes}:00`);
        }
    });
});

function handleToGiveExtraDates(){
    let application_id = $("#application_id").val();
    const date = $("#dateInput").val();
    const time = $("#timeInput").val();
    const extra_dates = `${date} ${time}`;
    if(!date || !time){
        toastr.error("Please select date and time", {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 5000,
        });
        return false;
    }
    const formData = new FormData();
    formData.append("application_id",application_id);
    formData.append("extra_dates", extra_dates);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `${BASE_URL}/super-admin/assign-extra-dates`, // Your server-side upload endpoint
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
           $('.full_screen_loading').hide();
            if (response.success) {
              toastr.success(response.message, {
                  timeOut: 0,
                  extendedTimeOut: 0,
                  closeButton: true,
                  closeDuration: 5000,
              });
              setTimeout(()=>{
                  window.location.reload();
              },500)
            }else{
              $('.full_screen_loading').hide();
              toastr.success(response.message, {
                  timeOut: 0,
                  extendedTimeOut: 0,
                  closeButton: true,
                  closeDuration: 5000,
              });
            }
        },
        error: function(xhr, status, error) {
            $('.full_screen_loading').hide();
            toastr.error("Something went wrong!", {
                  timeOut: 0,
                  extendedTimeOut: 0,
                  closeButton: true,
                  closeDuration: 5000,
              });
        }
    });
}



function handleUpdateCourse(){
    const course_names = document.getElementById('Course_Names');
    const years = document.getElementById('years');
    const months = document.getElementById('months');
    const days = document.getElementById('days');
    const hours = document.getElementById('hours');
    const eligibility = document.getElementById('Eligibilitys');
    
    const mode_of_course = document.getElementsByName('mode_of_course[]');
    const course_brief = document.getElementById('course_brief');
    let flag = 0;
    if(course_names.value==""){
        flag=1;
        $(course_names).addClass('courses_error');
    }
    if(years.value==""){
        flag=1;
        $(years).addClass('courses_error');
    }
    if(months.value==""){
        flag=1;
        $(months).addClass('courses_error');
    }
    if(days.value==""){
        flag=1;
        $(days).addClass('courses_error');
    }
    
    if(hours.value==""){
        flag=1;
        $(hours).addClass('courses_error');
    }
    if(eligibility.value==""){
        flag=1;
        $(eligibility).addClass('courses_error');
    }
    
    if(course_brief.value==""){
        flag=1;
        $(course_brief).addClass('courses_error');
    }

    let isAnyChecked = false;
    mode_of_course.forEach((elem) => {
        if (elem.checked) {
            isAnyChecked = true; // At least one checkbox is selected
        }
    });

    if(!isAnyChecked) return false;
    return flag!=1

    
}




function validateMobileNumber(mobileNumber) {
    const mobileRegex = /^[6-9]\d{9}$/;
    return mobileRegex.test(mobileNumber);
}
function validateEmail(email) {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|in|org|net|gov|edu)$/;
    return emailRegex.test(email);
}
$('#email_id').on('blur', function() {
    const email = $("#email_id").val();
    const contactNumber = $("#Contact_Number").val();
    const isValidEmail = validateEmail(email);
    const isValidMobile = contactNumber == "" || validateMobileNumber(contactNumber);
    const errorOptions = {
        timeOut: 0,
        extendedTimeOut: 0,
        closeButton: true,
        closeDuration: 5000,
    };

    if (!isValidEmail) {
        toastr.error("Please enter valid email", errorOptions);
    }
    
    if (!isValidMobile) {
        toastr.error("Please enter valid mobile number", errorOptions);
    }

    $("#nextBtn").attr('disabled', !(isValidEmail && isValidMobile));
});

$('#Contact_Number').on('blur', function() {
    const email = $("#email_id").val();
    const mobile_number = $("#Contact_Number").val();
    const isValidMobile = validateMobileNumber(mobile_number);
    const isValidEmail = email == "" || validateEmail(email);
    const errorOptions = {
        timeOut: 0,
        extendedTimeOut: 0,
        closeButton: true,
        closeDuration: 5000,
    };

    if (!isValidMobile) {
        toastr.error("Please enter valid mobile number", errorOptions);
    }
    
    if (!isValidEmail) {
        toastr.error("Please enter valid email", errorOptions);
    }

    $("#nextBtn").attr('disabled', !(isValidMobile && isValidEmail));
});


