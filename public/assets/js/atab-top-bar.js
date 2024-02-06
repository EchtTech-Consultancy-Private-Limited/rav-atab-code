$(".placeholder_input").mousedown(function() {

    var myData = ($(this).find("h5").data("value"));

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });

    // $.ajax({
    //     url: "{{ url('/notification') }}",
    //     type: "get",
    //     data: {
    //         myData: myData,
    //         _token: '{{ csrf_token() }}'
    //     },
    //     dataType: 'json',
    //     success: function(result) {

    //     }
    // });
});