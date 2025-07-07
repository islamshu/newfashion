  <div class="banner-footer mb-110">
      <div class="container-fluid p-0">
          <div class="banner-footer-wrapper">
              <div class="row g-lg-4 gy-4">
                @foreach ($features as $service)
                   <div class="col-lg-3 col-sm-6 d-flex justify-content-lg-start justify-content-center">
                      <div class="banner-footer-item">
                          <div class="banner-footer-icon">
                            <img src="{{asset('storage/'.$service->icon)}}" width="80" height="80" alt="">
                          </div>
                          <div class="banner-footer-content">
                              <h5>{{$service->getTranslation('title', app()->getLocale())}}</h5>
                              <p>{{$service->getTranslation('description', app()->getLocale())}}</p>
                          </div>
                      </div>
                  </div> 
                @endforeach
                  
                
              </div>
          </div>
      </div>
  </div>
