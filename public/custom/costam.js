
//alert masseage remove

$("document").ready(function(){
    setTimeout(function(){
       $("div.alert").remove();
    }, 5000 ) // 5 secs

    $(".tooltip-btn-pay").on('click',function(){
        alert("hhhhh")
        $(this).toggleClass('active')
      })
      
    
});

function f1(){
    alert("ffff")
  }
//password policy 



