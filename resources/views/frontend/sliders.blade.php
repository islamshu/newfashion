<div class="banner-section">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="swiper banner1-slider">
                    <div class="swiper-wrapper">
                      @foreach ($sliders as $item)
                            <div class="swiper-slide">
                            <a @if($item->link) href="{{ $item->link }}" @endif>
                                <img src="{{ asset('storage/'.$item->image_ar) }}" alt="Banner 1"class="banner-fixed-img">
                            </a>
                        </div>
                      @endforeach
                      
                       
                       
                    </div>

                    <!-- إذا أردت مؤشرات للسلايدر -->
                    <div class="swiper-pagination1"></div>
                </div>
            </div>
        </div>
    </div>
</div>
