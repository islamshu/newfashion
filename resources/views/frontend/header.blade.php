<header class="header-area">
    <div
        class="container-xxl container-fluid position-relative  d-flex flex-nowrap align-items-center justify-content-between">
        <div class="header-logo d-lg-none d-flex">
            <a href="/"><img alt="image" class="img-fluid"
                    src="{{ asset('storage/' . get_general_value('website_logo')) }}"></a>
        </div>
        <div class="category-dropdown">
            <div class="category-button">
                <img src="{{ asset('front/assets/img/home1/icon/category-icon.svg') }}" alt="">
                <span>{{ __('التصنيفات') }}</span>
            </div>
            <div class="category-menu">
                <ul>
                    @foreach (App\Models\Category::active()->main()->get() as $main)
                        <li class="{{ $main->children->count() ? 'category-has-child' : '' }}">
                            <a href="">
                                {{ $main->getTranslation('name', app()->getLocale()) }}
                            </a>
                            @if ($main->children->count())
                                <i class='bx bx-chevron-right'></i>
                                <ul class="sub-menu">
                                    @foreach ($main->children as $child)
                                        <li>
                                            <a href="{{ route('products.all', ['category_id' => $child->id]) }}">
                                                {{ $child->getTranslation('name', app()->getLocale()) }}

                                                @if ($child->children->count())
                                                    <i class='bx bx-chevron-right'></i>
                                                @endif
                                            </a>

                                            {{-- المستوى الثالث --}}
                                            @if ($child->children->count())
                                                <ul class="sub-menu">
                                                    @foreach ($child->children as $subchild)
                                                        <li>
                                                            <a
                                                                href="{{ route('products.all', ['category_id' => $subchild->id]) }}">
                                                                {{ $subchild->getTranslation('name', app()->getLocale()) }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
        <div class="main-menu">
            <!-- زر إغلاق القائمة الجانبية للموبايل -->
<div class="d-lg-none d-flex justify-content-end px-3">
    <button type="button" id="closeMobileMenu" class="btn btn-light btn-sm rounded-circle mt-2 shadow-sm"
        style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
        <i class="bi bi-x-lg"></i>
    </button>
</div>


            <div class="mobile-logo-area d-lg-none d-flex justify-content-between align-items-center">
                <div class="mobile-logo-wrap">
                    <a href="{{route('home')}}"><img alt="image" src="{{ Storage::url(get_general_value('website_logo')) }}"></a>
                </div>
            </div>
            <ul class="menu-list">
                <!-- الرئيسية -->
                <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}">{{ __('الرئيسية') }}</a>
                </li>

                <!-- من نحن -->
                <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                    <a href="{{ route('about') }}">{{ __('من نحن') }}</a>
                </li>

                <!-- المنتجات -->
                <li class="{{ request()->routeIs('products.all') ? 'active' : '' }}">
                    <a href="{{ route('products.all') }}">{{ __('المنتجات') }}</a>
                </li>
                <li class="{{ request()->routeIs('orders.get_track') ? 'active' : '' }}">
                    <a href="{{ route('orders.get_track') }}">{{ __('تتبع الطلب') }}</a>
                </li>
                <!-- تواصل معنا -->
                <li class="{{ request()->routeIs('contactUs') ? 'active' : '' }}">
                    <a href="{{ route('contactUs') }}">{{ __('تواصل معنا') }}</a>
                </li>
            </ul>

            <div class="d-lg-none d-block">
                <form class="mobile-menu-form d-lg-none d-block pt-50" onsubmit="return false;">
                    <div class="input-with-btn d-flex flex-column position-relative">
                        <input type="text" id="mobileSearchInput" placeholder="{{ __('ابحث عن منتج...') }}"
                            class="form-control">

                        {{-- نتائج البحث --}}
                        <div id="search-results"
                            class="search-results-list position-absolute w-100 bg-white border rounded mt-1 z-3 d-none"
                            style="max-height: 300px; overflow-y: auto;z-index: 1000; margin-top: 50% !important">
                            <ul class="list-group mb-0"></ul>
                        </div>

                        <button type="submit" class="primary-btn1 hover-btn3 mt-2">{{ __('أبحث') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="nav-right d-flex jsutify-content-end align-items-center">
            <!-- Button trigger modal -->
            <div class="dropdown">
                <button type="button" class="modal-btn header-cart-btn position-relative">
                    🛒 <!-- أيقونة رمزية بسيطة أو استخدم font icon -->
                    <span id="cart-count"
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ count(Session::get('cart') ?? []) }}
                        <!-- عرض عدد العناصر في السلة -->
                    </span>
                </button>

                <div class="cart-menu">

                </div>
            </div>
            <div class="save-btn">
                <a href="{{ route('client.wishlist') }}">
                    <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/.svg')}}">
                        <g clip-path="url(#clip0_68_10)">
                            <path
                                d="M16.528 2.20922C16.0674 1.71414 15.5099 1.31909 14.8902 1.04862C14.2704 0.778143 13.6017 0.638026 12.9255 0.636976C12.2487 0.637756 11.5794 0.777669 10.959 1.04803C10.3386 1.31839 9.78042 1.71341 9.31911 2.20857L9.00132 2.54439L8.68352 2.20857C6.83326 0.217182 3.71893 0.102819 1.72758 1.95309C1.63932 2.0351 1.5541 2.12032 1.47209 2.20857C-0.490696 4.32568 -0.490696 7.59756 1.47209 9.71466L8.5343 17.1622C8.77862 17.4201 9.18579 17.4312 9.44373 17.1869C9.45217 17.1789 9.46039 17.1707 9.46838 17.1622L16.528 9.71466C18.4907 7.59779 18.4907 4.32609 16.528 2.20922ZM15.5971 8.82882H15.5965L9.00132 15.7849L2.40553 8.82882C0.90608 7.21116 0.90608 4.71143 2.40553 3.09377C3.76722 1.61792 6.06755 1.52538 7.5434 2.88706C7.61505 2.95317 7.68401 3.02213 7.75012 3.09377L8.5343 3.92107C8.79272 4.17784 9.20995 4.17784 9.46838 3.92107L10.2526 3.09441C11.6142 1.61856 13.9146 1.52602 15.3904 2.8877C15.4621 2.95381 15.531 3.02277 15.5971 3.09441C17.1096 4.71464 17.1207 7.21893 15.5971 8.82882Z" />
                        </g>
                    </svg>
                </a>
            </div>
            <div class="user-login">
                @if (Auth::guard('client')->check())
                    <!-- المستخدم مسجل دخول -->
                    <div class="dropdown">
                        <button class="user-btn dropdown-toggle" type="button" id="userDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::guard('client')->user()->name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item"
                                    href="{{ route('client.dashboard') }}">{{ __('لوحة التحكم') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('client.logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('تسجيل الخروج') }}</a>
                            </li>
                        </ul>

                        <!-- فورم تسجيل الخروج -->
                        <form id="logout-form" action="{{ route('client.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                @else
                    <!-- المستخدم غير مسجل -->
                    <button type="button" class="user-btn" data-bs-toggle="modal" data-bs-target="#user-login">
                        <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_122_313)">
                                <path
                                    d="M15.364 11.636C14.3837 10.6558 13.217 9.93013 11.9439 9.49085C13.3074 8.55179 14.2031 6.9802 14.2031 5.20312C14.2031 2.33413 11.869 0 9 0C6.131 0 3.79688 2.33413 3.79688 5.20312C3.79688 6.9802 4.69262 8.55179 6.05609 9.49085C4.78308 9.93013 3.61631 10.6558 2.63605 11.636C0.936176 13.3359 0 15.596 0 18H1.40625C1.40625 13.8128 4.81279 10.4062 9 10.4062C13.1872 10.4062 16.5938 13.8128 16.5938 18H18C18 15.596 17.0638 13.3359 15.364 11.636ZM9 9C6.90641 9 5.20312 7.29675 5.20312 5.20312C5.20312 3.1095 6.90641 1.40625 9 1.40625C11.0936 1.40625 12.7969 3.1095 12.7969 5.20312C12.7969 7.29675 11.0936 9 9 9Z" />
                            </g>
                        </svg>
                    </button>
                @endif
            </div>

            <div class="sidebar-button mobile-menu-btn ">
                <span></span>
            </div>
        </div>
    </div>
</header>
