@extends('layouts.frontend')
@section('title',__('من نحن'))

@section('content')
<div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('من نحن') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="contact-page pt-100 mb-100">
        <div class="container">
            <div class="row g-4 mb-100 justify-content-center">
                <div class="col-lg-9">
                        
                            {!!get_general_value('about_'.app()->getLocale())!!}

                </div>
            </div>
        </div>
    </div>
@endsection