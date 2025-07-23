<footer class="footer-section">
    @php
        $categories = App\Models\Category::whereNull('parent_id')->take(6)->get();
        $pages = App\Models\Page::take(6)->get();

    @endphp
    <img src="{{ asset('front/assets/img/home1/icon/vector-2.svg') }}" alt="" class="vector1">
    <img src="{{ asset('front/assets/img/home1/icon/banner-vector1.svg') }}" alt="" class="vector2">
    <img src="{{ asset('front/assets/img/home1/icon/vector-4.svg') }}" alt="" class="vector3">
    <div class="container">
        <div class="footer-top">
            <div class="row g-lg-4 gy-5 justify-content-center">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="footer-widget">
                        <h3>{{ __('هل تريد') }} <span>{{ __('ان تأخذ') }} <br></span> {{ __('منتجاتنا المميزة') }}
                            <span>{{ __('من متجرنا') }} </span>?</h3>
                        <a href="{{ route('products.all') }}"
                            class="primary-btn1 hover-btn3">{{ __('*تسوق الآن*') }}</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-lg-start justify-content-sm-end">
                    <div class="footer-widget">
                        <div class="widget-title">
                            <h5>{{ __('الدعم') }}</h5>
                        </div>
                        <ul class="widget-list">
                            <li><a href="{{ route('contactUs') }}">{{ __('تواصل معنا') }}</a></li>
                            @foreach ($pages as $item)
                                <li><a href="{{ route('page', $item->slug) }}">{{ $item->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div
                    class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-lg-center justify-content-md-start justify-content-sm-end">
                    <div class="footer-widget">
                        <div class="widget-title">
                            <h5>{{ __('الفئات') }}</h5>
                        </div>

                        <ul class="widget-list">
                            @foreach ($categories as $item)
                                <li><a
                                        href="{{ route('products.all', ['category_id' => $item->id]) }}">{{ $item->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 d-flex justify-content-lg-end justify-content-md-center">
                    <div class="footer-widget">
                        <div class="widget-title style-2">
                            <h5>{{ __('تسوق بآمان معنا') }}</h5>
                        </div>

                        <div class="payment-gateway">
                            <div class="icons">
                                <img src="{{ asset('front/assets/img/home1/icon/visa.png') }}" alt="">
                                <img src="{{ asset('front/assets/img/home1/icon/mastercard.png') }}" alt="">
                                <img src="{{ asset('front/assets/img/home1/icon/american-express.png') }}"
                                    alt="">
                                <img src="{{ asset('front/assets/img/home1/icon/maestro.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="row">
                <div
                    class="col-lg-12 d-flex flex-md-row flex-column align-items-center justify-content-md-between justify-content-center flex-wrap gap-3">
                    <div class="footer-left">
                        <p>© {{ __('حقوق النشر') }} {{ Carbon\Carbon::now()->format('Y') }} {{ config('app.name') }}
                            | {{ __('تصميم بواسطة') }} <a href="https://www.bombastic.ps/">{{ __('Bombastic') }}</a>
                        </p>
                    </div>
                    <div class="footer-logo">
                        <a href="https://www.bombastic.ps/"><img width="200" height="80"
                                src="{{ asset('front/assets/img/bombastic.png') }}" alt="Logo"></a>
                    </div>
                    <div class="footer-contact">
                        <div class="logo">
                            {{-- SVG code --}}
                        </div>
                        <div class="content" style="z-index: 100">
                            <p>{{ __('للاستفسار') }}</p>
                            <h6><a href="tel:+970595135559">+970 595 135 559</a></h6>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</footer>
