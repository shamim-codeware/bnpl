<!doctype html>
<html lang=""{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ Session::get('layout') == 'rtl' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@yield('description')" />
    <title>Buy Now Pay Later - Rangs</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/plugin' . Helper::rlt_ext() . '.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style' . Helper::rlt_ext() . '.min.css?v=0.7') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/variables' . Helper::rlt_ext() . '.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app' . Helper::rlt_ext() . '.min.css') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/rangs-icon.png') }}">


    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js?v=34.77"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <style>
        .ui-datepicker {
            position: absolute !important;
            z-index: 9999 !important;
        }
    </style>

</head>
