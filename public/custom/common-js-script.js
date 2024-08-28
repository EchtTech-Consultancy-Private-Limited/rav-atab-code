
$(document).ready(function () {

    $("#regForm").validate({
        rules: {
            postal:{
                required: true,
                minlength: 6,
            },
            status:{
                required: true,
            },
            organization: {
                required: true,
                maxlength: 30,
            },
            title: {
                required: true,
                maxlength: 20,
            },
            firstname: {
                required: true,
                maxlength: 30,
            },
            lastname:{
                required: true,
                maxlength: 30,
            },
            designation:{
                required: true,
                maxlength: 30,
            },
            email: {
                required: true,
                email: true,
                maxlength: 50
            },
            mobile_no: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number: true
            },
            password: {
                minlength: 8,
                maxlength: 15
            },
            cpassword: {
                minlength: 8,
                maxlength: 15,
                equalTo: "#password"
            },
            gender: {
                required: true,
            },
            Country: {
                required: true,
            },
            address: {
                required: true,
            },
            course_name: {
                required: true,
            },
            state: {
                required: true,
                maxlength: 40
            },
            city: {
                required: true,
                maxlength: 40
            },
            payment_date: {
                required: true,
            },
            payment_transaction_no: {
                required: true,
            },
            payment_details_file: {
                required: true,
            },
            email_otp:{
                required: true,
            },



        },
        messages: {
            postal:{
                required: "Postal code is required",
                minlength: "Postal code must be of 6 digits"
            },
            payment_date:{
                required: "payment date is required",
            },
            payment_transaction_no:{
                required: "This Field is required",
            },
            payment_details_file:{
                required: "payment details file is required",
            },
            status:{
                required: "Status is required",

            },
            organization:{
                required: "Organization is required",
            },
            firstname: {
                required: "First name is required",
                maxlength: "First name cannot be more than 30 characters"
            },
            lastname: {
                required: "Last Name is required",
                maxlength: "Last Name cannot be more than 30 characters"
            },
            email: {
                required: "Email is required",
                email: "Email must be a valid email address",
                maxlength: "Email cannot be more than 50 characters"
            },
            mobile_no: {
                required: "mobile  number is required",
                minlength: "mobile number must be of 10 digits"
            },
            password: {
                maxlength: "password cannot be more than 15 characters",
                minlength: "Password must be at least 8 characters"
            },
            cpassword: {
                maxlength: "cpassword cannot be more than 15 characters",
                equalTo: "Password and confirm password should same",
                minlength: "Password must be at least 8 characters"
            },
            gender: {
                required:  "Please select the gender",
            },

            address: {
                required: "Address is required",

            },
            course_name: {
                required: "Course_name is required",
            },
            state: {
                required: "State is required",

            },
            address:{
                required: "Address is required",
            }

        }
    });


    $("#state").on('change',function(){

        $("#city").html('');

     // alert('hello');

        $.ajaxSetup({
            headers:
            {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var myVars=$("#state").val();

       
            $.ajax({
            url:  `${BASE_URL}/city-list`,
            type: "get",
            data:{"myData":myVars},
            success: function(resdata){

                //console.log(resdata);
                var formoption = "<option value=''>Select City</option>";
                for(i=0; i<resdata.length; i++)
                {
                formoption += "<option value='"+resdata[i].id+"'>"+resdata[i].name+"</option>";
                }
                $('#city').html(formoption);

              }

        });

    });


    $("#Country").on('change',function(){
        $("#city").html('');
        $("#state").html('');

     // alert('hello');

        $.ajaxSetup({
            headers:
            {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var myVar=$("#Country").val();

            $.ajax({
            url:`${BASE_URL}/state-list`,
            type: "get",
            data:{"myData":myVar},
            success: function(resdata){



                var formoption = "<option value=''>Select State</option>";
                var formoptioncity = "<option value=''>Select City</option>";
                for(i=0; i<resdata.length; i++)
                {
                formoption += "<option value='"+resdata[i].id+"' >"+resdata[i].name+"</option>";
                }
                $('#state').html(formoption);
                $('#city').html(formoptioncity);


              }

        });



  });


    let password = document.querySelector('#password');
    let togglePassword = document.querySelector('#togglepassword');
    togglePassword.addEventListener('click', (e) => {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classlist.toggle('fa fa-eye');
    });

    let cpassword = document.querySelector('#cpassword');
    let togglecPassword = document.querySelector('#togglecpassword');
    togglecpassword.addEventListener('click', (e) => {
        const type = cpassword.getAttribute('type') === 'password' ? 'text' : 'password';
        cpassword.setAttribute('type', type);

        this.classlist.toggle('fa-eye-slash');

    })

    $('.js-basic-example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel'
        ],
        lengthMenu: [
            [100, 25, 50, -1],
            [100, 25, 50, 'All']
        ],
    });

    $('#postal').keypress(function (e) {
        var regex = new RegExp("^[0-9_]");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });


    $('.file_size').on('change', function () {
        if (this.files[0].size > 5242880) {
            alert("Try to upload file less than 5MB!");
            $(".file_size").val("")
        } else {
            $('#GFG_DOWN').text(this.files[0].size + "bytes");
        }
    });

    // end point
});

function printDiv(divId) {
    var printContents = document.getElementById(divId).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}