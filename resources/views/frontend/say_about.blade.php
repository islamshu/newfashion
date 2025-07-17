 <div class="say-about-section mb-110">
        <img src="{{asset('front/assets/img/home1/testimonial-vector-2.png')}}" alt="" class="vector3">
        <img src="{{asset('front/assets/img/home1/testimonial-vector-1.png')}}" alt="" class="vector4">
         <div class="container-fluid p-0">
            <div class="section-title2 style-3">
                <h3>They Say About Our Product</h3>
                <div class="slider-btn">
                    <div class="about-prev-btn">
                        <i class="bi bi-arrow-left"></i>
                    </div>
                    <div class="about-next-btn">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </div>
            </div>
            <div class="say-about-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="swiper say-about-slider">
                            <div class="swiper-wrapper">
                                @foreach ($reviews as $review)
                                    <div class="swiper-slide">
                                     <div class="say-about-card">
        <div class="say-about-card-top">
            <ul>
                @for($i = 1; $i <= 5; $i++)
                    <li>
                        <i class="bi {{ $i <= $review->stars ? 'bi-star-fill' : 'bi-star' }}"></i>
                    </li>
                @endfor
            </ul>
        </div>

        <p>
            “{!! $review->getTranslation('description', app()->getLocale()) !!}”
        </p>

        <div class="say-about-card-bottom">
            <div class="author-area">
                <div class="author-img">
                    <img src="{{ asset('storage/' . $review->image) }}" alt="{{ $review->name }}">
                </div>
                <div class="author">
                    <h5>{{ $review->name }}</h5>
                    <p>{{ $review->getTranslation('job', app()->getLocale()) }}</p>
                </div>
            </div>

            <div class="quote">
                <!-- رمز الاقتباس كما هو -->
                <svg width="59" height="41" viewBox="0 0 59 41" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.05">
                        <path d="M27.8217 13.4959C27.7944 13.2156 27.7396 12.9284 27.6712 12.6481C27.062 5.56517 21.1144 0 13.8664 0C6.2077 0 0 6.20099 0 13.8514C0 21.283 5.85865 27.3268 13.2093 27.6686C11.4367 30.4649 8.58264 32.7278 5.09894 33.7944L4.98259 33.8286C3.36735 34.3208 2.25175 35.8933 2.40232 37.6435C2.57342 39.6604 4.34608 41.1576 6.37196 40.9867C12.3333 40.4808 18.2946 37.4384 22.3464 32.4954C24.3791 30.0341 25.9533 27.1353 26.9114 23.9767C27.8765 20.8249 28.205 17.4202 27.8765 14.0633L27.8217 13.4959Z"></path>
                        <path d="M58.8217 13.4959C58.7944 13.2156 58.7396 12.9284 58.6712 12.6481C58.062 5.56517 52.1144 0 44.8664 0C37.2077 0 31 6.20099 31 13.8514C31 21.283 36.8586 27.3268 44.2093 27.6686C42.4367 30.4649 39.5826 32.7278 36.0989 33.7944L35.9826 33.8286C34.3674 34.3208 33.2517 35.8933 33.4023 37.6435C33.5734 39.6604 35.3461 41.1576 37.372 40.9867C43.3333 40.4808 49.2946 37.4384 53.3464 32.4954C55.3791 30.0341 56.9533 27.1353 57.9114 23.9767C58.8765 20.8249 59.205 17.4202 58.8765 14.0633L58.8217 13.4959Z"></path>
                    </g>
                </svg>
            </div>
        </div>
    </div>
                                </div>
                                @endforeach
                                
                              
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination2"></div>
            </div>
         </div>
    </div>