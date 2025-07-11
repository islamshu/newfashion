@forelse ( $products as $product )
    <div class="col-lg-4 col-md-6">
                    @include('frontend.partials.product-card', ['product' => $product])

                </div>
@empty
    
    <div class="col-12 text-center py-5" style="font-size: 1.25rem; color: #888;">
        لا يوجد منتجات
    </div>
@endforelse
