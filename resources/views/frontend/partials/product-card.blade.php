<div class="product-card hover-btn">
    <div class="product-card-img {{ $product->thumbnails->count() > 1 ? 'double-img' : '' }}">
        <a href="{{ route('product.show', $product->id) }}">
            @if ($product->thumbnails->count() > 0)
                @foreach ($product->thumbnails->take(2) as $key => $image)
                    <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}"
                        class="img{{ $key + 1 }}"
                        onerror="this.onerror=null;this.src='{{ asset('storage/' . get_general_value('website_logo')) }}';">
                @endforeach
            @else
                <img src="{{ asset('storage/' . get_general_value('website_logo')) }}" alt="{{ $product->name }}"
                    class="img1">
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

        @if ($product->isOutOfStock())
            <div class="out-of-stock">
                <span>{{ __('نفذ من المخزون') }}</span>
            </div>
            {{-- <div class="overlay">
                                    <div class="cart-area">
                                        <a href="#" class="hover-btn3 add-cart-btn">Request Stock</a>
                                    </div>
                                </div> --}}
        @endif
        @if (!request()->routeIs('product.show'))
            <div class="view-and-favorite-area">
                <ul>
                    <li>
                        <button
                            class="add-to-wishlist btn view-wishlist-btn   {{ $product->isInWishlist() ? 'active' : '' }}"
                            data-product-id="{{ $product->id }}" title="{{ __('أضف إلى المفضلة') }}">
                            <i class="fa fa-heart"></i>
                        </button>
                    </li>
                    <li>
                        <button class="btn  view-product-btn" data-id="{{ $product->id }}" data-bs-toggle="modal"
                            data-bs-target="#product-view-modal">
                            <i class="bi bi-eye"></i>
                        </button>
                    </li>
                </ul>
            </div>
        @endif

    </div>

    <div class="product-card-content">
        <h6><a href="{{ route('product.show', $product->id) }}" class="hover-underline">{{ $product->name }}</a></h6>
        <p><a
                href="{{ route('products.all', ['category_id' => $product->category->id]) }}">{{ $product->category->name }}</a>
        </p>


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
