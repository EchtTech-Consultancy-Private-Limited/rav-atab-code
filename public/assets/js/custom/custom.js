
/*Captcha codepen*/

    var code;
function createCaptcha() {
    //alert("yes");
  //clear the contents of captcha div first
  document.getElementById('captcha').innerHTML = "";
  var charsArray =
  "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!#$%^&*";
  var lengthOtp = 7;
  var captcha = [];
  for (var i = 0; i < lengthOtp; i++) {
    //below code will not allow Repetition of Characters
    var index = Math.floor(Math.random() * charsArray.length + 1); //get the next character from the array
    if (captcha.indexOf(charsArray[index]) == -1)
      captcha.push(charsArray[index]);
    else i--;
  }
  var canv = document.createElement("canvas");
  canv.id = "captcha";
  canv.width = 150;
  canv.height = 50;
  var ctx = canv.getContext("2d");
  ctx.font = "25px Georgia";
  ctx.strokeText(captcha.join(""), 0, 30);
  //storing captcha so that can validate you can save it somewhere else according to your specific requirements
  code = captcha.join("");
  document.getElementById("captcha").appendChild(canv); // adds the canvas to the body element
}

function validateCaptcha() {
  event.preventDefault();
  debugger
  if (document.getElementById("cpatchaTextBox").value == code) {
    alert("Valid Captcha")
  }else{
    alert("Invalid Captcha. try Again");
    createCaptcha();
  }
}

/*show and hide password*/
$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});




$(function(){

  $('#eye').click(function(){

        if($(this).hasClass('fa-eye-slash')){

          $(this).removeClass('fa-eye-slash');

          $(this).addClass('fa-eye');

          $('#password').attr('type','text');

        }else{

          $(this).removeClass('fa-eye');

          $(this).addClass('fa-eye-slash');

          $('#password').attr('type','password');
        }
    });
});

$(function(){

  $('#eye1').click(function(){

        if($(this).hasClass('fa-eye-slash')){

          $(this).removeClass('fa-eye-slash');

          $(this).addClass('fa-eye');

          $('#checkPassword').attr('type','text');

        }else{

          $(this).removeClass('fa-eye');

          $(this).addClass('fa-eye-slash');

          $('#checkPassword').attr('type','password');
        }
    });
});

/*email validation*/

$(document).ready(function(){
    var $psw=/^([a-z])/;
    var $regexname="^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$";
    $('#email').on('keypress keydown keyup',function(){
        //alert("yes");
                  $('#email-error').empty();
                  $('#password-error').empty();
                  $('#authencate-error').empty();
             if (!$(this).val().match($regexname)) {
              // there is a mismatch, hence show the error message
                 $('.emsg').removeClass('hidden');
                 $('.emsg').show();

             }
           else{
                // else, do not display message
                $('.emsg').addClass('hidden');
               }
         });

    /*$('#password').on('keypress keydown keyup',function(){
        //alert("yes");
                  $('#email-error').empty();
                  $('#password-error').empty();
                  $('#authencate-error').empty();
             if (!$(this).val().match($psw)) {
              // there is a mismatch, hence show the error message
                 $('.emsgpsw').removeClass('hidden');
                 $('.emsgpsw').show();
             }
           else{
                // else, do not display message
                $('.emsgpsw').addClass('hidden');
               }
         });*/
});

/*ajax code for login user*/

$(document).ready(function(){
    var $psw=/^([a-z])/;
    var $regexname="^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$";
    $('#firstname1').on('keypress keydown keyup',function(){
        //alert("yes");
                  $('#firstname-error').empty();
               if (!$(this).val().match($regexname)) {
              // there is a mismatch, hence show the error message
                 $('.emsg').removeClass('hidden');
                 $('.emsg').show();

             }
           else{
                // else, do not display message
                $('.emsg').addClass('hidden');
               }
         });

    /*$('#password').on('keypress keydown keyup',function(){
        //alert("yes");
                  $('#email-error').empty();
                  $('#password-error').empty();
                  $('#authencate-error').empty();
             if (!$(this).val().match($psw)) {
              // there is a mismatch, hence show the error message
                 $('.emsgpsw').removeClass('hidden');
                 $('.emsgpsw').show();
             }
           else{
                // else, do not display message
                $('.emsgpsw').addClass('hidden');
               }
         });*/
});



$('.assessment_type').on('change', function() {
  var data = $(this).val();
  ///  alert(data);
  if (data == 1) {
      //alert('1');
      $('.destop-id').show();
      $('.onsite-id').hide();
      $('.my-button').prop('disabled', false)
      $('.modal-footer').show();
  } else if (data == 2) {
      // alert('2');
      $('.destop-id').hide();
      $('.onsite-id').show();
      $('.modal-footer').show();
      $('.my-button').prop('disabled', false)
  } else {
      //alert('hii')
      $('.destop-id').hide();
      $('.onsite-id').hide();
      $('.my-button').attr('disabled', false)
      $('.modal-footer').hide();
  }
});


$(document).ready(function() {
  $('.destop-id').hide();
  $('.onsite-id').hide();
  $('.my-button').prop('disabled', true)
  $('.modal-footer').hide();
});

$('.assesorsid').on('click', function() {
  var application_id = $(this).data('application-id');
  var assessor_id = $(this).val();
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
 
  $.ajax({
      url: `${BASE_URL}/assigin-check-delete`,
      type: "get",
      data: {
          id: application_id,
          assessor_id
      },
      success: function(data) {
          //alert(data)
          if (data === 'success') {
              Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: 'Application has been unassigned from the assessor successfully.',
              }).then(() => {
                  location.reload(true);
              });
          }
      }
  });
});
function cancelAssign() {
  location.reload(true);
}
$('.dateID').click('on', function() {
  alert("alertssss")
  var $this = $(this);
  var dataVal = $(this).attr('data-id').split(',');
  var colorid = $(this).attr('date-color');
  // if(colorid ==undefined || colorid =='' || colorid =='false'){
  //     $(this).removeClass('btn-success').addClass('btn-danger');
  // }else{
  //     $(this).removeClass('btn-danger').addClass('btn-success');
  // }
  var data = {
      'applicationID': dataVal[0],
      'assessorID': dataVal[1],
      'assessmentType': dataVal[2],
      'selectedDate': dataVal[3]
  };
 
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $.ajax({
      type: 'POST',
      url: `${BASE_URL}/save-selected-dates}`,
      data: data,
      success: function(response) {
          if (response.message == 'deleted') {
              $this.removeClass('btn-danger').addClass('btn-success');
          } else {
              $this.removeClass('btn-success').addClass('btn-danger');
          }
          // if(response.status == 200){
          //     $this.removeClass('btn-danger').addClass('btn-success');
          // }else{
          //      $this.removeClass('btn-success').addClass('btn-success');
          // }
      },
      error: function(error) {
          console.error('Error:', error);
      }
  });
})