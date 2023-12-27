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
            url: "/account-payment-received",
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
                }
            },
            error: (xhr, st) => {
                console.log(st, "st");
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
        url: "/account-payment-approved",
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
        if (id == "" || id === null || id === undefined) {
            toastr.error("Application id not found", {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                closeDuration: 0,
            });
            return false;
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: "/admin-payment-acknowledge",
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
                    setTimeout(function () {}, 1000);
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
                console.log(st, "st");
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
        url: "/save-selected-dates",
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
        url: "/assigin-check-delete",
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

$(".remove_err").on("keyup", function () {
    let err_id = $(this).attr("id");
    $(`#${err_id}_err`).html("");
});
