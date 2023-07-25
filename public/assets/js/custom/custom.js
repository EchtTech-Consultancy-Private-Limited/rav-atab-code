
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

