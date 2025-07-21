@extends('layouts.frontend')
@section('title',__('الرئيسية'))

@section('content')
    @include('frontend.model_when_open')

    @include('frontend.sliders')
    {{-- @include('frontend.featchers') --}}
    @include('frontend.categorires')
    @include('frontend.best_sellling')
    {{-- @include('frontend.product_with_category') --}}
    @include('frontend.banners')
    {{-- @include('frontend.new_products') --}}
    {{-- @include('frontend.exclosive') --}}
    {{-- @include('frontend.offers') --}}
    {{-- @include('frontend.best_brands') --}}
    @include('frontend.say_about')
    {{-- @include('frontend.blogs') --}}
    @include('frontend.tackers')
@endsection