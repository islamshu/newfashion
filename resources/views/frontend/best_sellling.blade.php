<div class="best-selling-section mb-110">
    <div class="container">
        <div class="section-title2">
            <h3>Best Selling Product</h3>
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
        <div class="row gy-4">
            @foreach ($bestProduct as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="product-card hover-btn">
                        <div class="product-card-img {{ $product->thumbnails->count() > 1 ? 'double-img' : '' }}">
                            <a href="product-default.html">
                                @if ($product->thumbnails->count() > 0)
                                    @foreach ($product->thumbnails->take(2) as $key => $image)
                                        <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}"
                                            class="img{{ $key + 1 }}"
                                            onerror="this.onerror=null;this.src='{{ asset('storage/' . get_general_value('website_logo')) }}';">
                                    @endforeach
                                @else
                                    <img src="{{ asset('storage/' . get_general_value('website_logo')) }}"
                                        alt="{{ $product->name }}" class="img1">
                                @endif

                                @if ($product->is_new)
                                    <div class="batch">
                                        <span class="new">New</span>
                                    </div>
                                @endif

                                @if ($product->discount_price)
                                    <div class="batch">
                                        <span>-{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%</span>
                                    </div>
                                @endif
                            </a>

                            @if (!$product->isOutOfStock())
                                <div class="overlay">
                                    <div class="cart-area">
                                        <a href="#" class="hover-btn3 add-cart-btn"><i
                                                class="bi bi-bag-check"></i> {{__('أضف إلى المفضلة')}}</a>
                                    </div>
                                </div>
                            @else
                                <div class="out-of-stock">
                                    <span>{{__('نفذ من المخزون')}}</span>
                                </div>
                                {{-- <div class="overlay">
                                    <div class="cart-area">
                                        <a href="#" class="hover-btn3 add-cart-btn">Request Stock</a>
                                    </div>
                                </div> --}}
                            @endif

                            <div class="view-and-favorite-area">
                                <ul>
                                    <li>
                                        <button  class="add-to-wishlist btn view-wishlist-btn   {{ $product->isInWishlist() ? 'active' : '' }}" data-product-id="{{ $product->id }}"
                                            title="{{__('أضف إلى المفضلة')}}">
                                            <i class="fa fa-heart"></i>
                                        </button>
                                    </li>
                                    <li>
                                        <button class="btn  view-product-btn" data-id="{{ $product->id }}"
                                            data-bs-toggle="modal" data-bs-target="#product-view-modal">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="product-card-content">
                            <h6><a href="product-default.html" class="hover-underline">{{ $product->name }}</a></h6>
                            <p><a href="shop-list.html">{{ $product->category->name }}</a></p>


                            <p class="price">
                                ₪{{ number_format($product->price, 2) }}
                            </p>
                            {{-- <div class="rating">
                                <ul>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li>
                                            <i class="bi bi-star{{ $i <= $product->average_rating ? '-fill' : '' }}"></i>
                                        </li>
                                    @endfor
                                </ul>
                                <span>({{ $product->reviews_count }})</span>
                            </div> --}}
                        </div>
                        <span class="for-border"></span>
                    </div>
                </div>
            @endforeach
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
