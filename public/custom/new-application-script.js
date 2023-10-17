$(document).ready(function() {

    $('.image-link').magnificPopup({

        type: 'image',

        mainClass: 'mfp-with-zoom',

        gallery: {

            enabled: true

        },
        zoom: {
            enabled: true,
            duration: 300, // duration of the effect, in milliseconds
            easing: 'ease-in-out', // CSS transition easing function
            opener: function(openerElement) {
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        }
    });
});


$(".payment_alert").click(function() {
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Document is pending for approval from Accounts department',
        showConfirmButton: true,
        timer: 5000
    });

});