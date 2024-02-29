const curtain = () => {
  let curtain_input = document.getElementById('curtain');
 //  return   curtain_input.click();
   $('div.curtain__panel--left').css({'transform':'translateX(-100%)'});
   $('div.curtain__panel--right').css({'transform':'translateX(100%)'});

   $('.main-container').css({'display':'block'})
  //  setTimeout( ()=>{
  //  } ,1000);
}


