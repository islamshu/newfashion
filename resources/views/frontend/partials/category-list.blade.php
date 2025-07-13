@foreach ($categories as $category)
    <div class="col-lg-3 col-sm-6">
        <div class="category-card">
            <div class="category-card-img hover-img">
                <a href="{{ route('products.all', ['category_id' => $category->id]) }}">
                    <img src="{{ asset('storage/' . $category->image) }}" class="category-img" alt="{{ $category->name }}">
                </a>
            </div>
            <div class="category-card-content text-center">
                <a href="{{ route('products.all', ['category_id' => $category->id]) }}">
                    {{ $category->getTranslation('name', app()->getLocale()) }}
                </a>
            </div>
        </div>
    </div>
@endforeach
