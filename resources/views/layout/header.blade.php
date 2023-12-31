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

    <!-- You can choose a theme from css/styles instead of getting all themes -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles/all-themes.css') }}">

    <!-- jQuery -->
    <script src="{{ asset('assets/js/atab-jquery-3.7.1.min.js') }}" ></script>

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">

    <!-- Template CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/plugins/dataTables.bootstrap4.min.css') }}"> --}}

    <!-- Custom JavaScript -->
    <link rel="stylesheet" href="{{ asset('custom/costam.js') }}" class="js">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.css') }}">

    <!-- SweetAlert2 -->
    <!-- <script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script> -->

    <!-- DataTables Buttons CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
    
    
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/magnific-popup.css') }}">

    <!-- <link rel="stylesheet" href="{{ asset('assets/css/toastify.min.css') }}"> -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">



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

    