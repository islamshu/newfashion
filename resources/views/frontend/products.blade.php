@extends('layouts.frontend')
@section('content')
    <div class="just-for-section mb-110">
        <img src="assets/img/home1/icon/vector-1.svg" alt="" class="vector1">
        <img src="assets/img/home1/icon/vector-2.svg" alt="" class="vector2">
        <div class="container">

            <div class="row gy-4 justify-content-center">
                <div class="col-lg-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-all-products-tab" data-bs-toggle="pill"
                            data-bs-target="#v-all-products" type="button" role="tab" aria-controls="v-all-products"
                            aria-selected="true">
                            {{ __('جميع المنتجات') }}
                            <span>({{ $products->count() }})</span>

                        </button>
                        @foreach ($categories as $category)
                            <button class="nav-link " id="v-{{ Str::slug($category->name) }}-tab" data-bs-toggle="pill"
                                data-bs-target="#v-{{ Str::slug($category->name) }}" type="button" role="tab"
                                aria-controls="v-{{ Str::slug($category->name) }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $category->name }}
                                <span>({{ $category->products_count }})</span>
                            </button>
                        @endforeach
                    </div>


                </div>

                <div class="col-lg-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-all-products" role="tabpanel"
                            aria-labelledby="v-all-products-tab">
                            <div class="row gy-4">
                                @foreach ($products as $product)
                                    <div class="col-xl-4 col-md-6">
                                        @include('frontend.partials.product-card', ['product' => $product])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @foreach ($categories as $category)
                            <div class="tab-pane fade " id="v-{{ Str::slug($category->name) }}" role="tabpanel"
                                aria-labelledby="v-{{ Str::slug($category->name) }}-tab">
                                <div class="row gy-4">
                                    @foreach ($category->products->take(6) as $product)
                                        <div class="col-xl-4 col-md-6">
                                            @include('frontend.partials.product-card', [
                                                'product' => $product,
                                            ])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
