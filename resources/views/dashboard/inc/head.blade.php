<!DOCTYPE html>
<html class="loading" dir="rtl" lang="en-GB" data-textdirection="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords"
        content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">

    <title>{{ get_general_value('website_name_' . app()->getLocale()) }} - @yield('title')</title>

    <link rel="apple-touch-icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;600&display=swap" rel="stylesheet">

    <!-- BEGIN VENDOR CSS-->

    <!-- END MODERN CSS-->
    <!-- BEGIN Page Level CSS-->
    @if (app()->getLocale() == 'ar' || app()->getLocale() == 'he')
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/css-rtl/vendors.css') }}">
        <!-- END VENDOR CSS-->
        <!-- BEGIN MODERN CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/css-rtl/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/css-rtl/custom-rtl.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('backend/app-assets/css-rtl/core/menu/menu-types/horizontal-menu.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('backend/app-assets/css-rtl/core/colors/palette-gradient.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('backend/app-assets/css-rtl/core/colors/palette-gradient.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/style-rtl.css') }}">

        <style>
            body {
                font-family: 'Tajawal', sans-serif;
            }

            span,
            p,
            h1,
            h2,
            h3,
            ul,
            li {
                font-family: 'Tajawal', sans-serif !important;
            }

            .margin-right {
                margin-right: 60%
            }

            .required {
                color: red;
            }

            #clientResults a {
                padding: 10px;
                border-bottom: 1px solid #eee;
                cursor: pointer;
            }

            #clientResults a:hover {
                background-color: #f0f0f0;
            }

            /* تغيير مربع البحث */
            .dataTables_filter input {
                font-size: 14px !important;
                font-family: 'Tahoma', Arial, sans-serif !important;
            }

            /* تغيير عناصر التصفية */
            .dataTables_length select {
                font-size: 14px !important;
            }

            /* تغيير أرقام الصفحات */
            .dataTables_paginate .paginate_button {
                font-size: 14px !important;
            }
        </style>
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/css/vendors.css') }}">
        <!-- END VENDOR CSS-->
        <!-- BEGIN MODERN CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/css/custom.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('backend/app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('backend/app-assets/css/core/colors/palette-gradient.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('backend/app-assets/css/core/colors/palette-gradient.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/style.css') }}">
        <style>
            .margin-right {
                margin-left: 60%
            }
        </style>
    @endif
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/forms/selects/selectivity-full.min.css') }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/forms/tags/tagging.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/charts/morris.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/fonts/simple-line-icons/style.css') }}">

    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/vendors/css/extensions/sweetalert.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/css-rtl/core/colors/palette-gradient.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/css-rtl/plugins/forms/wizard.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/vendors/css/pickers/daterange/daterangepicker.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/css-rtl/plugins/pickers/daterange/daterange.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/css-rtl/core/menu/menu-types/horizontal-menu.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/css-rtl/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/css-rtl/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/fonts/simple-line-icons/style.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/vendors/css/cryptocoins/cryptocoins.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>

    <style>
        .select2-container {
            width: 100% !important;
        }

        .cke_notifications_area {
            display: none !important;
        }

        .search-label {
            font-size: 1.2rem;
            /* حجم الخط */
            font-weight: bold;
            /* سماكة الخط */
        }

        .search-label i.la.la-search {
            font-size: 1.4rem;
            /* حجم الأيقونة */
            margin-left: 5px;
            /* مسافة بين الأيقونة والنص */
            vertical-align: middle;
        }

        /* تعديل مربع البحث نفسه */
        .dataTables_filter input {
            font-size: 1.1rem;
            /* حجم نص البحث المدخل */
            padding: 0.4rem 0.8rem;
        }

        /* تنسيق متكامل */
        .dataTables_filter label {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-label {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2c3e50;
            display: flex;
            align-items: center;
        }

        .search-label i.la.la-search {
            font-size: 1.6rem;
            color: #3498db;
            transition: all 0.3s ease;
        }

        .dataTables_filter input {
            font-size: 1.1rem;
            padding: 0.5rem 1rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .dataTables_filter input:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .dataTables_filter:hover .la-search {
            transform: scale(1.1);
            color: #2980b9;
        }

        /* تعديلات RTL */
        .rtl .dataTables_filter label {
            flex-direction: row-reverse;
        }

        .rtl .search-label i {
            margin-left: 0;
            margin-right: 8px;
        }

        .form-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 25px;
            border-left: 4px solid #7367f0;
        }

        .section-title {
            color: #7367f0;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .custom-file-label::after {
            content: "تصفح";
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .input-group-text {
            background-color: #f8f9fa;
        }
    </style>
    @yield('style')

    <!-- END Page Level CSS-->

    <!-- END Custom CSS-->
</head>
