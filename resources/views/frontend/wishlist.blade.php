@extends('layouts.frontend')
@section('title', __('المنتجات المفضلة'))
@section('content')
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('المنتجات المفضلة') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="category-section mt-110 mb-110">
        <div class="container">


            <div class="row g-4 mb-70" id="whishlistContainer">
                @include('frontend.partials.product-list', ['products' => $products])
            </div>


        </div>
    </div>
    <div class="modal product-view-modal"id="product-view-modal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <!-- سيتم تعبئة المحتوى هنا عبر AJAX -->
                <div class="modal-body text-center p-5">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">{{ __('جاري التحميل ... ') }} </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
