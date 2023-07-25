//  fetch user
var loadtable = 0;
var index = 0;
var dataTable;

function display_list() {

    if (loadtable != 0) {
        dataTable.fnClearTable();
        dataTable.fnDraw();
        dataTable.fnDestroy();
    }

    $(function() {

        dataTable = $('.yajra-datatable').DataTable({

            "paging": true,
            "ordering": true,
            "searching": true,
            dom: 'Bfrtip',


        });

        $.ajax({

            url: "/alluser",
            type: "GET",
            data: {},
            processData: false,
            dataType: 'json',
            contentType: false,
            success: function(response) {
                $('#successMsg').show();
                console.log(response);

                if (response) {
                    for (i = 0; i < response.length; i++) {

                        dataTable.row.add([
                            (i + 1),
                            response[i].firstname,
                            response[i].email,
                            response[i].user_type,

                            '<a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-report-edit"  onclick="edit_user(' + response[i].id + ',' + i + ')"><i class="feather icon-edit" aria-hidden="true"></i></a> <a class="btn btn-danger btn-sm" onclick="delete_user(' + response[i].id + ',' + i + ')"><i class="fa fa-trash" aria-hidden="true"></i></a>',



                        ]).draw(false);
                    }

                    index = i;

                }
            },

            error: function(response) {
                //alert("error");
                console.log('error');
            },
        });

        //script for get country list
        $.ajax({
            url: "/country-list",
            type: "GET",


            success: function(response) {

                $('#successMsg').show();
                console.log(response);
                if (response) {
                    $.each(response, function(key, value) {
                        $('#country-list').append("<option value='" + value.id + "'>" + value.name + "</option>");

                        $('#edit-country-list').append("<option value='" + value.id + "'>" + value.name + "</option>");
                    });
                }

            },

            error: function(response) {
                alert("error");
            },

        });

    });


    loadtable = 1;
}
display_list();

// for show and hide 
function toggle(id) {

    a = document.getElementById('toggle_' + id);
    b = document.getElementById('display_' + id);
    if (a.style.display == 'block') {
        a.style.display = 'none';
        b.innerHTML = 'show password policy';
    } else {
        a.style.display = 'block';
        b.innerHTML = 'hide password policy';
    }
}

// show hide password

$(".toggle-password").click(function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

//password and confirm psw match
var check = function() {
    if (document.getElementById('password').value ==
        document.getElementById('checkPassword').value) {
        document.getElementById('alertPassword').style.color = '#8CC63E';
        document.getElementById('alertPassword').innerHTML = '<span><i class="fas fa-check-circle"></i>Match !</span>';
    } else {
        document.getElementById('alertPassword').style.color = '#EE2B39';
        document.getElementById('alertPassword').innerHTML = '<span><i class="fas fa-exclamation-triangle"></i>not matching</span>';
    }
}


// Delete User Alert

  function delete_user() {
      if(!confirm("Are you sure to delete this user"))
      event.preventDefault();
  }