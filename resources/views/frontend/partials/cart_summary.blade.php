<div class="added-product-summary mb-30">
    <h5>ملخص الطلب </h5>
    <ul class="added-products">
        @foreach ($cart as $index => $item)
            @php
                $product = \App\Models\Product::find($item['product_id']);
                $color = $item['color_id'] ? \App\Models\ProductAttribute::find($item['color_id']) : null;
                $size = $item['size_id'] ? \App\Models\ProductAttribute::find($item['size_id']) : null;
                $price = $product->price;
                $totalItemPrice = $price * $item['quantity'];
            @endphp
            <li class="single-product">
                <div class="product-area d-flex align-items-center">
                    <div class="product-img" style="flex-shrink: 0; width: 80px;">
                        <img src="{{ Storage::url($product->thumbnails->first()->image) }}" alt="{{ $product->name }}"
                            style="width: 100%; height: auto;">
                    </div>
                    <div class="product-info flex-grow-1 ms-3">
                        <h5>
                            <a target="_blank" href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
                        </h5>
                        <small class="text-muted d-block mb-1">
                            @if ($color)
                                <span>{{ __('اللون') }}:
                                    <span
                                        style="display:inline-block;width:15px;height:15px;background:{{ $color->code }};border-radius:4px;border:1px solid #ccc;"></span>
                                </span>
                            @endif
                            @if ($size)
                                <span class="ms-2">{{ __('المقاس') }}: {{ $size->value }}</span>
                            @endif
                        </small>
                        <div class="d-block">
                            <small>{{ __('الكمية') }}: {{ $item['quantity'] }}</small>
                            -
                            <small>{{ __('سعر القطعة') }}: {{ $product->price }}₪</small>

                        </div>

                        <strong class="d-block mt-1">
                            <span class="product-price">₪{{ number_format($totalItemPrice, 2) }}</span>
                        </strong>
                    </div>
                    <button class="close-btn remove-item-checkout" data-index="{{ $index }}">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </li>
        @endforeach
    </ul>
</div>
