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

    <title>{{ get_general_value('website_name_' . app()->getLocale()) }} - {{__('تسجيل الدخول')}}</title>
    <link rel="icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">

    <link rel="apple-touch-icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

<style>
  body {
    background: url('{{ asset('storage/' . get_general_value('website_logo')) }}') no-repeat center center fixed;
    background-size: cover;
    position: relative;
    font-family: 'Cairo', sans-serif;
  }

  body::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.4); /* تغطية بلون غامق شفاف */
    z-index: 0;
  }

  .login-wrapper {
    position: relative;
    z-index: 1;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .login-card {
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.95); /* لون أبيض شفاف */
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    padding: 2rem;
    width: 100%;
    max-width: 400px;
  }

  .login-logo img {
    max-width: 120px;
    border-radius: 12px;
  }

  .form-control {
    border-radius: 10px;
    padding: 0.75rem;
  }

  .btn-lg {
    border-radius: 10px;
  }

  .form-control-position i {
    color: #6c757d;
  }

  .login-title {
    font-size: 1.2rem;
    font-weight: bold;
    margin-top: 10px;
  }
</style>

<body class="blank-page" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
  <div class="app-content content login-wrapper">
    <div class="login-card">
  

      <h6 class="text-center text-dark login-title">
        {{ __('تسجيل دخول ') }} {{ get_general_value('website_name_' . app()->getLocale()) }}
      </h6>

      @include('dashboard.inc.alerts')

      <form method="POST" action="{{ route('post_login') }}" class="mt-3">
        @csrf

        <fieldset class="form-group position-relative has-icon-left">
          <input type="email" name="email" class="form-control form-control-lg" placeholder="{{ __('البريد الإلكتروني') }}" required>
          <div class="form-control-position">
            <i class="ft-user"></i>
          </div>
        </fieldset>

        <fieldset class="form-group position-relative has-icon-left mt-2">
          <input type="password" name="password" class="form-control form-control-lg" placeholder="{{ __('كلمة المرور') }}" required>
          <div class="form-control-position">
            <i class="ft-lock"></i>
          </div>
        </fieldset>

        <button type="submit" class="btn btn-info btn-lg btn-block mt-2">
          <i class="ft-unlock"></i> {{ __('تسجيل دخول') }}
        </button>
      </form>
    </div>
  </div>

  <!-- Scripts -->
  <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
  <script src="../../../app-assets/js/core/app-menu.js"></script>
  <script src="../../../app-assets/js/core/app.js"></script>
</body>
