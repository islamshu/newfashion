 <div class="choose-product-section mb-110">
        <div class="container">
            <div class="section-title text-center">
                <h3>Choose What You Want</h3>
            </div>
            <div class="row gy-4 justify-content-center">
                @foreach ($featchersCategories as $item)
                    <div class="col-lg-4 col-md-6">
                    <div class="choose-product-card hover-img style-2" >
                        <a href="shop-list.html">
                            <img src="{{asset('storage/'.$item->image)}}" height="700" alt="">
                        </a>
                        <div class="choose-product-card-content">
                            <h2 class="first-text" style="color: {{getColor($item)}}" >{{$item->getTranslation('name', app()->getLocale())}}</h2>
                        </div>
                    </div>
                </div>
                @endforeach
                
              
             
            </div>
        </div>
    </div>