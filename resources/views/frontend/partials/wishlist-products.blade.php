@forelse($products as $product)
    @include('frontend.partials.product-card')
@empty
    <p class="text-center">{{ __('لا توجد منتجات في المفضلة.') }}</p>
@endforelse
