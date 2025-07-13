<div class="offer-banner mb-110">
    <div class="container">
        <div class="row justify-content-center gy-4">
            @php
                $count = $banners->count();
                $colClass = 'col-lg-4'; // 3 banners
                if ($count == 1) {
                    $colClass = 'col-lg-6  text-center'; // center one banner
                } elseif ($count == 2) {
                    $colClass = 'col-lg-6'; // 2 banners
                }
            @endphp

            @foreach ($banners as $banner)
                <div class="{{ $colClass }}">
                    <div class="offer-banner-right hover-img">
                        <img src="{{ asset('storage/' . $banner->image) }}" alt="">
                        <div class="offer-banner-right-content">
                            <h5>{{ $banner->getTranslation('title', app()->getLocale()) }}</h5>
                            <p>{{ $banner->getTranslation('description', app()->getLocale()) }}</p>
                            @if($banner->getTranslation('button_text', app()->getLocale()))
                                <a href="{{ $banner->link }}" class="buy-btn2 hover-btn3">
                                    {{ $banner->getTranslation('button_text', app()->getLocale()) }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
