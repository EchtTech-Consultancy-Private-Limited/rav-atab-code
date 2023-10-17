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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

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
    <script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/buttons.dataTables.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/magnific-popup.css') }}">