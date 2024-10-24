 <section>
     <div class="row" style="margin:auto;">
         <div class="col-lg-12 text-center mt-4 pb-3">
             <!-- 2023- --> © {{ date('Y') }} Ayurveda Training Accreditation Board. All Rights are Reserved.
         </div>
     </div>
 </section>

 {{-- state dropdown --}}
 <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
 <script src="{{ asset('assets/js/atab-popper.min.js') }}"
     integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
 </script>
 <script src="{{ asset('assets/js/atab-bootstrap.min.js') }}"
     integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
 </script>
 <script src="{{ asset('assets/js/atab-jquery.validate.min.js') }}"></script>
 <script src="{{ asset('customjs/custom.js') }}"></script>
 <script src="{{ asset('customjs/notification.js') }}"></script>

 <script>
     $(document).ready(function() {
         $("#regForm").validate({
             rules: {
                 postal: {
                     required: true,
                     minlength: 6,
                 },
                 status: {
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
                 lastname: {
                     required: true,
                     maxlength: 30,
                 },
                 designation: {
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
                 email_otp: {
                     required: true,
                 },



             },
             messages: {
                 postal: {
                     required: "Postal code is required",
                     minlength: "Postal code must be of 6 digits"
                 },
                 payment_date: {
                     required: "payment date is required",
                 },
                 payment_transaction_no: {
                     required: "This Field is required",
                 },
                 payment_details_file: {
                     required: "payment details file is required",
                 },
                 status: {
                     required: "Status is required",

                 },
                 organization: {
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
                     required: "Please select the gender",
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
                 address: {
                     required: "Address is required",
                 }

             }
         });
     });
 </script>

 <script>
     $(document).ready(function() {
         $("#Country").on('change', function() {
             $("#city").html('');
             $("#state").html('');

             // alert('hello');

             $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });

             var myVar = $("#Country").val();

             $.ajax({
                 url:`${BASE_URL}/state-list`,
                 type: "get",
                 data: {
                     "myData": myVar
                 },
                 success: function(resdata) {



                     var formoption = "<option value=''>Select State</option>";
                     var formoptioncity = "<option value=''>Select City</option>";
                     for (i = 0; i < resdata.length; i++) {
                         formoption += "<option value='" + resdata[i].id + "' >" + resdata[i]
                             .name + "</option>";
                     }
                     $('#state').html(formoption);
                     $('#city').html(formoptioncity);


                 }

             });



         });
     });
 </script>


 <script>
     $(document).ready(function() {
         $("#state").on('change', function() {

             $("#city").html('');

             // alert('hello');

             $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });

             var myVars = $("#state").val();


             $.ajax({
                 url:`${BASE_URL}/city-list`,
                 type: "get",
                 data: {
                     "myData": myVars
                 },
                 success: function(resdata) {

                     //console.log(resdata);
                     var formoption = "<option value=''>Select City</option>";
                     for (i = 0; i < resdata.length; i++) {
                         formoption += "<option value='" + resdata[i].id + "'>" + resdata[i]
                             .name + "</option>";
                     }
                     $('#city').html(formoption);

                 }

             });

         });
     });
 </script>



 <script>
     // disable alphate
     $('#mobile_no').keypress(function(e) {
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

     togglePassword.addEventListener('click', (e) => {       
         const type = password.getAttribute('type') == 'password' ? 'text' : 'password';
         password.setAttribute('type', type);
         e.target.classList.toggle('fa-eye');
    e.target.classList.toggle('fa-eye-slash');
     });

     let cpassword = document.querySelector('#cpassword');
     let togglecPassword = document.querySelector('#togglecpassword');
     togglecpassword.addEventListener('click', (e) => {
         const type = cpassword.getAttribute('type') == 'password' ? 'text' : 'password';
         cpassword.setAttribute('type', type);

         e.target.classList.toggle('fa-eye');
    e.target.classList.toggle('fa-eye-slash');

     })
 </script>


 <script> 
     $("document").ready(function() {
         setTimeout(function() {
             $("div.alert").remove();
         }, 5000); // 5 secs

     });
 </script>


 <script>
     // disable alphate
    

     $('#postal').keypress(function(e) {
         var regex = new RegExp("^[0-9_]");
         var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
         if (regex.test(str)) {
             return true;
         }
         e.preventDefault();
         return false;
     });
 </script>



 <script src="{{ asset('assets/js/app.min.js') }}"></script>
 <script src="{{ asset('assets/js/chart.min.js') }}"></script>
 <!-- Custom Js -->
 <script src="{{ asset('assets/js/admin.js') }}"></script>
 <script src="{{ asset('assets/js/bundles/apexcharts/apexcharts.min.js') }}"></script>
 <script src="{{ asset('assets/js/pages/index.js') }}"></script>
 <script src="{{ asset('assets/js/pages/todo/todo.js') }}"></script>
 <script src="{{ asset('assets/js/atab-fullcalendar.min.js') }}"></script>
 <script src="{{ asset('assets/js/table.min.js') }}"></script>

 <script src="{{ asset('assets/js/atab-moment.min.js') }}"></script>
 
 <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
 <!-- <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script> -->
 <script src="{{ asset('assets/js/atab-dataTables.buttons.min.js') }}"></script>
 <script src="{{ asset('assets/js/atab-jszip.min.js') }}"></script>
 <script src="{{ asset('assets/js/atab-pdfmake.min.js') }}"></script>
 <script src="{{ asset('assets/js/atab-vfs_fonts.js') }}"></script>
 <script src="{{ asset('assets/js/atab-buttons.html5.min.js') }}"></script>
 <script src="{{ asset('assets/js/atab-buttons.print.min.js') }}"></script>


<script>
     $(document).ready(function() {
     
         $('#dataTableMain').DataTable({
             dom: 'Bfrtip',
             order: [[0, 'asc']],
             lengthMenu: [
                 [10, 25, 50, -1],
                 ['10 rows', '25 rows', '50 rows', 'Show all']
             ],
             buttons: [
                 'pageLength', 'csv', 'excel'
             ]
         });
         $('#dataTableMain-admin').DataTable({
             dom: 'Bfrtip',
             order: [[0, 'desc']],
             lengthMenu: [
                 [10, 25, 50, -1],
                 ['10 rows', '25 rows', '50 rows', 'Show all']
             ],
             buttons: [
                 'pageLength', 'csv', 'excel'
             ]
         });
         $('#dataTableMain-account').DataTable({
             dom: 'Bfrtip',
             order: [[0, 'desc']],
             lengthMenu: [
                 [10, 25, 50, -1],
                 ['10 rows', '25 rows', '50 rows', 'Show all']
             ],
             buttons: [
                 'pageLength', 'csv', 'excel'
             ]
         });
         $('#dataTableMain-pending').DataTable({
             dom: 'Bfrtip',
             order: [[0, 'desc']],
             lengthMenu: [
                 [10, 25, 50, -1],
                 ['10 rows', '25 rows', '50 rows', 'Show all']
             ],
             buttons: [
                 'pageLength', 'csv', 'excel'
             ]
         });
     });
</script>

 <script>
    $(document).on('change', '.file_size', function() {
        let  fileInput = this;
        const file_name = this.files[0]?.name;
        var allowedExtensions = ["pdf"]; // Add more extensions if needed
        var fileExtension = file_name.split(".").pop().toLowerCase();
        if (allowedExtensions.indexOf(fileExtension) == -1) {
                toastr.error("Invalid file type", {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 5000,
                });
                // Clear the file input
                fileInput.value='';
                $(".full_screen_loading").hide();
                return;
        }
        
         if (this.files[0].size > 5242880) {
            toastr.error("Try to upload file less than 5MB!", {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 5000,
                });
             $(".file_size").val("")
         } else {
             $('#GFG_DOWN').text(this.files[0].size + "bytes");
         }
     
    });

    $(document).on('change', '.file_size_exl', function() {
        let  fileInput = this;
        const file_name = this.files[0].name;
        var allowedExtensions = ["xlsx","xls"]; // Add more extensions if needed
        var fileExtension = file_name.split(".").pop().toLowerCase();
        if (allowedExtensions.indexOf(fileExtension) == -1) {
                toastr.error("Invalid file type", {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 5000,
                });
                // Clear the file input
                fileInput.value='';
                $(".full_screen_loading").hide();
                return;
        }
        
         if (this.files[0].size > 5242880) {
            toastr.error("Try to upload file less than 5MB!", {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 5000,
                });
             $(".file_size_exl").val("")
         } else {
             $('#GFG_DOWN').text(this.files[0].size + "bytes");
         }

         
    });

     
 </script>

 </body>

 </html>
