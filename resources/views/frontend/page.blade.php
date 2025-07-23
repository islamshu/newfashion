@extends('layouts.frontend')
@section('title',$page->title)

@section('content')
<div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$page->title }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="contact-page pt-100 mb-100">
        <div class="container">
            <div class="row g-4 mb-100 justify-content-center">
                <div class="col-lg-9">
                        
                            {!!$page->text!!}

                </div>
            </div>
        </div>
    </div>
@endsection