<div class="cart-body">
    <ul>
        @forelse ($cart as $item)
            @php
                $product = \App\Models\Product::find($item['product_id']);
                $color = $item['color_id'] ? \App\Models\ProductAttribute::find($item['color_id']) : null;
                $size = $item['size_id'] ? \App\Models\ProductAttribute::find($item['size_id']) : null;
                $image = $product->thumbnail->url ?? asset('default.jpg');
                $price = $product->price;
                $totalItemPrice = $price * $item['quantity'];
            @endphp

            <li class="single-item">
                <div class="item-area">
                    <div class="item-img">
                        <img src="{{ $image }}" alt="{{ $product->name }}">
                    </div>
                    <div class="content-and-quantity">
                        <div class="content">
                            <div class="price-and-btn d-flex justify-content-between align-items-center">
                                <span>${{ number_format($totalItemPrice, 2) }}</span>
                                <button class="close-btn remove-item" data-id="{{ $item['product_id'] }}">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            <p>{{ $product->name }}</p>
                            @if($color || $size)
                                <small>
                                    @if($color)
                                        <span>اللون: {{ $color->code }}</span>
                                    @endif
                                    @if($size)
                                        <span> - المقاس: {{ $size->value }}</span>
                                    @endif
                                </small>
                            @endif
                        </div>
                        <div class="quantity-area mt-1">
                            <div class="quantity">
                                <span>{{ $item['quantity'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="text-center py-3">السلة فارغة</li>
        @endforelse
    </ul>
</div>

<div class="cart-footer">
    <div class="pricing-area">
        <ul>
            <li><span>المجموع الفرعي</span><span>${{ number_format($subTotal, 2) }}</span></li>
            <li><span>الخصم (20%)</span><span>${{ number_format($discount, 2) }}</span></li>
        </ul>
        <ul class="total">
            <li><span>الإجمالي</span><span>${{ number_format($total, 2) }}</span></li>
        </ul>
    </div>
    <div class="footer-button">
        <ul>
            <li><a class="primary-btn1 hover-btn4" href="">متابعة التسوق</a></li>
            <li><a class="primary-btn1 hover-btn3" href="">إتمام الشراء</a></li>
        </ul>
    </div>
</div>
