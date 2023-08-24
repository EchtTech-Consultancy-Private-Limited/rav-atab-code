@include('layout.header') <style>
  .activeDay {
    background-color: #FF3131 !important;
  }

  .fc-future {
    background-color: #fcf8e3;
  }

  .activeDaygreen {
    background-color: #00800080;
  }

  .fc-ltr .fc-event-hori.fc-event-end,
  .fc-rtl .fc-event-hori.fc-event-start {
    border-right-width: 1px;
    border-top-right-radius: 3px;
    border-bottom-right-radius: 3px;
    /*display: none;*/
  }

  .d-flex.btn-m {
    margin-top: 10px;
    justify-content: center;
  }

  button#modal-btn-delete,
  #modal-btn-edit {
    margin-right: 15px;
  }

  .modal .modal-body .edit-pop-cal {
    border-bottom: 1px solid #9e9e9e !important;
    text-align: left !important;
    height: 4rem !important;
    font-size: 20px !important;
  }
</style>
<title>RAV Accreditation</title>undefined</head>undefined<body class="light">

  <!-- Page Loader -->
  <div class="page-loader-wrapper">
    <div class="loader">
      <div class="m-t-30">
        <img class="loading-img-spin" src="{{asset('assets/images/favicon.png')}}" alt="admin">
      </div>
      <p>Please wait...</p>
    </div>
  </div>
  <!-- #END# Page Loader -->
  <!-- Overlay For Sidebars -->
  <div class="overlay"></div>
  <!-- #END# Overlay For Sidebars --> @include('layout.topbar') <div> @if (Auth::user()->role == '1') @include('layout.sidebar') @elseif(Auth::user()->role == '2') @include('layout.siderTp') @elseif(Auth::user()->role == '3') @include('layout.sideAss') @elseif(Auth::user()->role == '4') @include('layout.sideprof') @endif @include('layout.rightbar') </div>
  <section class="content">
    <div class="container-fluid">
      <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">My Availability</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/') }}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>   
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="{{ url('/dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">My Availability</li>
                            <li class="breadcrumb-item active">Desktop Assessment</li>
                        </ul>
                    </div>
                </div>
            </div>
      <div class="block-header">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!--  <ul class="breadcrumb breadcrumb-style "><li class="breadcrumb-item"><h4 class="page-title">All Users</h4></li><li class="breadcrumb-item bcrumb-1"><a href="{{url('/dashboard')}}"><i class="fas fa-home"></i> Home</a></li><li class="breadcrumb-item bcrumb-2"><a href="#" onClick="return false;">Users</a></li><li class="breadcrumb-item active">All Users</li></ul> -->
          </div>
        </div>
      </div> @if ($message = Session::get('success')) <div class="alert alert-success">
        <p>{{ $message }}</p>
      </div> @endif <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card">
            <div class="header"></div>
            <div class="body">
              <div class="container">
                <h3>Manage your calendar for Desktop Assessment</h3><br>
                <div id="schedule-calendar"></div>
              </div>
              <!--   <script>
                        $(document).ready(function(){
                            $('.activeDay div').on('click',function(e)
                                               {

                                               $(".activeDay").addClass('active');
                                                   $('#schedule-add').modal('hide');
                                                    $('#schedule-edit').modal('show');

                                              }
                                              )
                        })
                     </script> -->
              <!-- Confirm Modal  -->
              <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal-confirm">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <h5 class="text-center mt-5">Please Select your Action to Procced</h5>
                    <div class="d-flex btn-m pb-4">
                      <button type="button" class="btn btn-default" id="modal-btn-delete" onclick="return confirm_option('delete')">Delete</button>
                      <!-- <button type="button" class="btn btn-primary" id="modal-btn-edit">Edit</button> -->
                      <!-- <button type="button" class="btn btn-danger modal-close" id="modal-btn-close">Close</button> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="alert" role="alert" id="result"></div>
              <!-- Add Modal  -->
              <div class="modal fade" id="schedule-add" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title text-center">Add Your Schedule</h4>
                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <!-- Modal body  -->
                    <div class="modal-body">
                      <form id="add_event">
                        <input type="hidden" name="asesrar_id" id="asesrar_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="start_date" id="start_date">
                        <input type="hidden" name="end_date" id="end_date">
                       
                        <input type="hidden" name="available_date" value="<?php echo date('Y-m-d'); ?>" onfocus="focused(this)">
                        <div class="form-group">
                          <!-- <label>Select Option</label> -->
                          <!-- <select name="availability" id="availability" class="form-control"><option value="">Select Option</option><option value="1">Available</option><option value="2">Not Available</option></select> -->
                          <input type="hidden" name="availability" id="availability" value="2">
                        </div>
                        <!-- <div class="form-group"><label>Description:</label><textarea name="add_event_descp" id="add_event_descp" class="form-control"></textarea></div> -->
                        <input type="hidden" name="type" value="add">
                        <input type="hidden" name="event_type" value="1" id="event_type">
                        <!-- Modal footer -->
                        <!--  <div class="modal-footer"><button type="button" class="btn btn-success" id="add_date">Add Your Schedule</button><button type="button" class="btn btn-success" id="add_date">Available</button><button type="button" class="btn btn-success" id="add_date">UnAvailable</button></div> -->
                        <h5 class="text-center mt-5 ">Please Select your Action to Procced</h5>
                        <div class="d-flex btn-m pb-4">
                          <!--  <button type="button" class="btn btn-default" id="modal-btn-delete" onclick="return confirm_option('delete')">Delete</button> -->
                          <button type="button" class="btn btn-primary m-2 add_schedule" id="add_date" name="available">Available</button>
                          <button type="button" class="btn btn-danger modal-close m-2 add_schedule" id="add_date_unavailable" name="unavailable">UnAvailable</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Edit Modal  -->
              <div class="modal fade" id="schedule-edit">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Your Schedule</h4>
                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                      <form>
                        <!--   <input type="hidden" name="type"  value="update"> -->
                        <input type="hidden" name="event_type" value="1" id="event_type">
                        <div class="form-group">
                          <label>Schedule Description:</label>
                          <input type="text" class="form-control" name="edit_event_descp" id="edit_event_descp">
                        </div>
                        <div class="form-group">
                          <!--  <label>Schedule id:</label> -->
                          <input type="hidden" class="form-control" name="event_id" id="event_id">
                        </div>
                      </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-success" id="edit_date">Update Your Schedule</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> @include('layout.footer')


  
  <script>
    $(document).ready(function() {
      var SITEURL = "{{ url('/') }}";
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var calendar = $('#schedule-calendar').fullCalendar({
        editable: true,
        events: SITEURL + "/assessor-desktop-assessment",
        displayEventTime: false,
        editable: true,
        /*eventRender: function (event, element, view) {
         
            if (event.allDay === 'true') {
                    event.allDay = true;
            } else {
                    event.allDay = false;
            }
        },*/
        selectable: true,
        selectHelper: true,
        select: function(start, end, allDay) {
          $('#schedule-add').modal('show');
          var newstart = moment(start).format('YYYY-MM-DD');
          var newend = moment(end).format('YYYY-MM-DD')
          // alert(newend);
          $('#start_date').val(newstart);
          $('#end_date').val(newend);
          //alert(newstart);
        },
        eventRender: function(event, element) {
          //console.log(event.id);
          var dataToFind = moment(event.start).format('YYYY-MM-DD');
          /*$("td[data-date='"+dataToFind+"']").addClass('activeDay');*/
          var availability = event.availability;
          if (availability == 1) {
            $("td[data-date='" + dataToFind + "']").addClass('activeDaygreen');
          } else if (availability == 2) {
            $("td[data-date='" + dataToFind + "']").addClass('activeDay');
          }
        },
        eventDrop: function(start, end, event, delta) {
          /*var newstart = moment(start).format('YYYY-MM-DD');
                                                var newend = moment(end).format('YYYY-MM-DD')
                                                
                                                $('#edit_date12').on('click',function(e) {
                                                   alert("yes");
                                                   var add_event_descp = $('#add_event_descpe').val();
                                                   var event_id = $('#event_id').val();
                                                $.ajax({
                                                    url: SITEURL + '/fullcalenderAjax',
                                                    data: {
                                                       
                                                        start: add_event_descp,
                                                        type: 'update'
                                                    },
                                                    type: "POST",
                                                    success: function (response) {
                                                        displayMessage("Event Updated Successfully");
                                                    }
                                                });
                                             });*/
        },
        eventClick: function(event) {
          //alert("yes");
          $(".activeDay1").each(function(i, key) {
            //$('#schedule-edit').modal('show');
            //$('#event_id').val(event.id);
            //Confirmation box for delete or edit
            $("#mi-modal-confirm").modal('show');
            $("#modal-btn-edit").on("click", function() {
              //Edit the event
              $('#schedule-edit').modal('show');
              $('#event_id').val(event.id);
              $('#edit_event_descp').val(event.title);
            });
          });
          $("#modal-btn-delete").on("click", function() {
            var deleteMsg = confirm("Are you sure to delete this record!");
            if (deleteMsg) {
              //Delete the event
              $.ajax({
                type: "POST",
                url: SITEURL + '/fullcalenderAjax',
                data: {
                  id: event.id,
                  type: 'delete'
                },
                success: function(response) {
                  //calendar.fullCalendar('removeEvents', event.id);
                  displayMessage("Event Deleted Successfully");
                  window.location.href = "{{ url('/assessor-desktop-assessment') }}";
                }
              });
              $("#modal-btn-delete").reset();
            }
          });
          $('#edit_date').on('click', function(e) {
            var edit_event_descp = $('#edit_event_descp').val();
            // alert(edit_event_descp);
            var event_id = $('#event_id').val();
            $.ajax({
              url: SITEURL + '/fullcalenderAjax',
              data: {
                event_id: event_id,
                edit_event_descp: edit_event_descp,
                type: 'update'
              },
              type: "POST",
              success: function(response) {
                window.location.href = "{{ url('/assessor-desktop-assessment') }}";
                displayMessage("Event Updated Successfully");
              }
            });
          });
          // $('.activeDay').on('click',function(e)
          //   {
          //       //$('#schedule-add').modal('hide');
          //       $('#schedule-edit').modal('show');
          //  }
          //  );
          // var deleteMsg = confirm("Do you really want to delete?");
          //     if (deleteMsg) {
          //         $.ajax({
          //             type: "POST",
          //             url: SITEURL + '/fullcalenderAjax',
          //             data: {
          //                     id: event.id,
          //                     type: 'delete'
          //             },
          //             success: function (response) {
          //                 calendar.fullCalendar('removeEvents', event.id);
          //                 displayMessage("Event Deleted Successfully");
          //             }
          //         });
          //     }
        }
      });
    });

    function displayMessage(message) {
      toastr.success(message, 'Event');
    }
  </script>
  <script>
    $(document).ready(function() {
      $('.add_schedule').on('click', function(e) {
        var SITEURL = "{{ url('/') }}";
        var event_type = $('#event_type').val();
        var availability = $('#availability').val();
        var asesrar_id = $('#asesrar_id').val();
        var id = $(this).attr('id');
        if (id == "add_date") {
          var add_event_availability = 1;
        } else {
          var add_event_availability = 2;
        }
        var newstart = $('#start_date').val();
        var newend = $('#end_date').val();
        $.ajax({
          url: SITEURL + "/fullcalenderAjax",
          data: {
            event_type: event_type,
            asesrar_id: asesrar_id,
            availability: availability,
            add_event_availability: add_event_availability,
            start: newstart,
            end: newend,
            type: 'add'
          },
          type: "POST",
          //processData:false,
          //dataType:'json',
          //contentType:false,
          success: function(data) {
            //alert("Event Created Successfully");
            // $(".modal").trigger('click');
            //$("#add_date").reset();
            window.location.href = "{{ url('/assessor-desktop-assessment') }}";
            displayMessage("Event Created Successfully");
            /*calendar.fullCalendar('renderEvent',
                {

                    availability:availability,
                    allDay: allDay
                },true);*/
            // calendar.fullCalendar('unselect');
          }
        });
      });
      $('#add_date_unavailable12').on('click', function(e) {
        var SITEURL = "{{ url('/') }}";
        //alert("unavailable");
        var event_type = $('#event_type').val();
        var availability = $('#availability').val();
        var asesrar_id = $('#asesrar_id').val();
        var add_event_descp = 2;
        var newstart = $('#start_date').val();
        var newend = $('#end_date').val();
        $.ajax({
          url: SITEURL + "/fullcalenderAjax",
          data: {
            event_type: event_type,
            asesrar_id: asesrar_id,
            availability: availability,
            add_event_descp: add_event_descp,
            start: newstart,
            end: newend,
            type: 'add'
          },
          type: "POST",
          //processData:false,
          //dataType:'json',
          //contentType:false,
          success: function(data) {
            alert("Event Created Successfully");
            $(".modal").trigger('click');
            $("#add_event")[0].reset();
            window.location.href = "{{ url('/assessor-desktop-assessment') }}";
            displayMessage("Event Created Successfully");
            calendar.fullCalendar('renderEvent', {
              availability: availability,
              allDay: allDay
            }, true);
            calendar.fullCalendar('unselect');
          }
        });
        $("#add_date_unavailable").reset();
      });
    });
  </script>

<script>
  
  $(document).ready(function(){
    var count = 0;
  $("span.fc-button.fc-button-next.fc-state-default.fc-corner-right").click(function() {
      
    count++;
   
    if(count <= 6){
      alert(count)
    }else{
      alert("not click")
    }
       
  });

});




 
</script>
