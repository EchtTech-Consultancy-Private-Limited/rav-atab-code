<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">

    <!-- Plugins Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/styles/all-themes.css') }}">

    <!-- jQuery -->
    <script src="{{ asset('assets/js/atab-jquery-3.7.1.min.js') }}" ></script>

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">

    <!-- Template CSS -->
   

    <!-- Custom JavaScript -->
    <link rel="stylesheet" href="{{ asset('custom/costam.js') }}" class="js">

    <meta name="csrf-token" content="{{ csrf_token() }}">           

    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>  
    <script>
      const BASE_URL = {!! json_encode(url('/')) !!}
    </script>


    <style>
       .docBtn{
        padding: 6px;
        color: #fff;
       
        border-radius: 4px;
        margin-right: 5px;
    }
    .docBtn:hover{
        color: #fff;
    }
    </style>

<!-- <script type="text/javascript"> 
  window.history.forward(); 
  function noBack() { 
    window.history.forward(); 
  } 
</script>  -->