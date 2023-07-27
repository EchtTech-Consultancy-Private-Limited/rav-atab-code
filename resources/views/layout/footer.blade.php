 <section>
            <div class="row" style="margin:auto;">
                <div class="col-lg-12 text-center pb-3">
                    <!-- 2023- --> © {{date('Y')}} Ayurveda Training Accreditation Board. All Rights are Reserved.
                </div>
            </div>
        </section>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
{{-- state dropdown --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
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
                    required: "Address is Must",
                }

            }
        });
    });
</script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script>

    $(document).ready(function(){
        new DataTable('#DtTable', {
            dom: 'RlBfrtip',
            lengthMenu: [
                [100, 25, 50, -1],
                [100, 25, 50, 'All']
            ],
            buttons: [
                    'csvHtml5','excelHtml5'
                ],
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
            url: "{{url('/state-list')}}",
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
});


</script>


{{-- city dropdown --}}

<script>

    $(document).ready(function(){
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


       //  alert(myVars);

            $.ajax({
            url: "{{url('/city-list')}}",
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
});

</script>



<script>
    // disable alphate
    $('#mobile_no').keypress(function (e) {
       // alert('hello');
        var regex = new RegExp("^[0-9_]");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });
</script>


<script>
    let password = document.querySelector('#password');
    let togglePassword = document.querySelector('#togglepassword');

    togglePassword.addEventListener('click', (e)=>{
        const type = password.getAttribute('type') === 'password' ? 'text' :'password';
        password.setAttribute('type', type);
        this.classlist.toggle('fa fa-eye');
    });

    let cpassword = document.querySelector('#cpassword');
    let togglecPassword = document.querySelector('#togglecpassword');
    togglecpassword.addEventListener('click', (e)=>{
    const type = cpassword.getAttribute('type') === 'password' ? 'text' :'password';
    cpassword.setAttribute('type', type);

    this.classlist.toggle('fa-eye-slash');

    })


</script>


<script>

$("document").ready(function(){
    setTimeout(function(){
       $("div.alert").remove();
    }, 5000 ); // 5 secs

});

</script>

{{-- back button  disable  --}}
{{--
<script>
    $(document).ready(function() {
        function disableBack() {
            window.history.forward()
        }
        window.onload = disableBack();
        window.onpageshow = function(e) {
            if (e.persisted)
                disableBack();
        }
    });
</script> --}}



<script>
    // disable alphate
    $('#postal').keypress(function (e) {
        var regex = new RegExp("^[0-9_]");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });




</script>



<script src="{{asset('assets/js/app.min.js')}}"></script>
<script src="{{asset('assets/js/chart.min.js')}}"></script>
<!-- Custom Js -->
<script src="{{asset('assets/js/admin.js')}}"></script>
<script src="{{asset('assets/js/bundles/echart/echarts.js')}}"></script>
<script src="{{asset('assets/js/bundles/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/js/pages/index.js')}}"></script>
<script src="{{asset('assets/js/pages/todo/todo.js')}}"></script>


{{-- <script src="../../assets/js/table.min.js"></script>
<!-- Custom Js -->
<script src="../../assets/js/admin.js"></script>
<script src="../../assets/js/pages/tables/jquery-datatable.js"></script> --}}


<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.0.3/fullcalendar.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>  -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</body>

</html>
