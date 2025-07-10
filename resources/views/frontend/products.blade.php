@extends('layouts.frontend')
@section('content')
 <div class="just-for-section mb-110">
        <img src="assets/img/home1/icon/vector-1.svg" alt="" class="vector1">
        <img src="assets/img/home1/icon/vector-2.svg" alt="" class="vector2">
        <div class="container">
            <div class="section-title2 style-2">
                <h3>Just For You</h3>
                <div class="all-product hover-underline">
                    <a href="shop-list.html">*View All Product
                        <svg width="33" height="13" viewBox="0 0 33 13" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M25.5083 7.28L0.491206 7.25429C0.36093 7.25429 0.23599 7.18821 0.143871 7.0706C0.0517519 6.95299 0 6.79347 0 6.62714C0 6.46081 0.0517519 6.3013 0.143871 6.18369C0.23599 6.06607 0.36093 6 0.491206 6L25.5088 6.02571C25.6391 6.02571 25.764 6.09179 25.8561 6.2094C25.9482 6.32701 26 6.48653 26 6.65286C26 6.81919 25.9482 6.9787 25.8561 7.09631C25.764 7.21393 25.6386 7.28 25.5083 7.28Z" />
                            <path
                                d="M33.0001 6.50854C29.2204 7.9435 24.5298 10.398 21.623 13L23.9157 6.50034L21.6317 0C24.5358 2.60547 29.2224 5.06539 33.0001 6.50854Z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
    <div class="col-lg-3">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
               <button class="nav-link active" 
                    id="v-all-products-tab" 
                    data-bs-toggle="pill" 
                    data-bs-target="#v-all-products" 
                    type="button" role="tab" 
                    aria-controls="v-all-products" 
                    aria-selected="true">
                {{__('جميع المنتجات')}}
                <span>({{ $products->count() }})</span>

            </button>
            @foreach($categories as $category)
            
                <button class="nav-link " 
                        id="v-{{ Str::slug($category->name) }}-tab" 
                        data-bs-toggle="pill" 
                        data-bs-target="#v-{{ Str::slug($category->name) }}" 
                        type="button" role="tab" 
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
              <div class="tab-pane fade show active" id="v-all-products" role="tabpanel" aria-labelledby="v-all-products-tab">
                <div class="row gy-4">
                    @foreach($products as $product)
                        <div class="col-xl-4 col-md-6">
                            @include('frontend.partials.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>
            @foreach($categories as $category)
                <div class="tab-pane fade " 
                     id="v-{{ Str::slug($category->name) }}" 
                     role="tabpanel" 
                     aria-labelledby="v-{{ Str::slug($category->name) }}-tab">
                    <div class="row gy-4">
                        @foreach($category->products->take(6) as $product)
                            <div class="col-xl-4 col-md-6">
                                @include('frontend.partials.product-card', ['product' => $product])
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