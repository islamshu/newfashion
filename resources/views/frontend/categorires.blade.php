 <div class="choose-product-section mb-110">
     <div class="container">
         <div class="section-title2">
            <h3>{{__('التصنيفات المميزة')}}</h3>
            
            <div class="all-product hover-underline">
                <a href="{{route('categories.all')}}">*{{__('جميع التصنيفات')}}
                    <svg width="33" height="13" viewBox="0 0 33 13" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M25.5083 7.28L0.491206 7.25429C0.36093 7.25429 0.23599 7.18821 0.143871 7.0706C0.0517519 6.95299 0 6.79347 0 6.62714C0 6.46081 0.0517519 6.3013 0.143871 6.18369C0.23599 6.06607 0.36093 6 0.491206 6L25.5088 6.02571C25.6391 6.02571 25.764 6.09179 25.8561 6.2094C25.9482 6.32701 26 6.48653 26 6.65286C26 6.81919 25.9482 6.9787 25.8561 7.09631C25.764 7.21393 25.6386 7.28 25.5083 7.28Z" />
                        <path
                            d="M33.0001 6.50854C29.2204 7.9435 24.5298 10.398 21.623 13L23.9157 6.50034L21.6317 0C24.5358 2.60547 29.2224 5.06539 33.0001 6.50854Z" />
                    </svg>
                </a>
            </div>
        </div>
         <div class="row gy-4 justify-content-center">
             @foreach ($featchersCategories as $item)
                 <div class="col-lg-4 col-md-6">
                     <div class="choose-product-card hover-img style-2">
                         <a href="{{ route('products.all', ['category_id' => $item->id]) }}">
                             <img src="{{ asset('storage/' . $item->image) }}" height="700" alt="">
                         </a>
                         <div class="choose-product-card-content">
                             <h2 class="first-text" style="color: {{ getColor($item) }}">
                                 {{ $item->getTranslation('name', app()->getLocale()) }}</h2>
                         </div>
                     </div>
                 </div>
             @endforeach



         </div>
     </div>
 </div>
