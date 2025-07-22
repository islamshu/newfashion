<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
    role="navigation" data-menu="menu-wrapper">
    <div class="navbar-container main-menu-content" data-menu="menu-container">
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">

            <!-- الرئيسية -->
            <li class="dropdown nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-menu="dropdown">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="la la-home"></i>
                    <span>{{ __('الرئيسية') }}</span>
                </a>
            </li>

            <!-- الإعدادات -->
            <li class="dropdown nav-item {{ request()->routeIs('setting') ? 'active' : '' }}" data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                    <i class="la la-cogs"></i>
                    <span>{{ __('الإعدادات') }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('setting') ? 'active' : '' }}"
                            href="{{ route('setting') }}">
                            <i class="la la-sliders"></i> {{ __('الإعدادات الاساسية للنظام') }}
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item {{ request()->routeIs('show_translate') && request()->route('locale') === 'ar' ? 'active' : '' }}"
                            href="{{ route('show_translate', 'ar') }}">
                            PS {{ __('الملف الخاص باللغة العربية') }}
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item {{ request()->routeIs('show_translate') && request()->route('locale') === 'he' ? 'active' : '' }}"
                            href="{{ route('show_translate', 'he') }}">
                            🇮🇱 {{ __('الملف الخاص باللغة العبرية') }}
                        </a>
                    </li>
                </ul>

            </li>

            <!-- الخصائص والتصنيفات -->
            <li class="dropdown nav-item {{ request()->routeIs('categories.index') || request()->routeIs('product_attributes.index') ? 'active' : '' }}"
                data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                    <i class="la la-tags"></i>
                    <span>{{ __('التصنيفات والخصائص') }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('categories.index') ? 'active' : '' }}"
                            href="{{ route('categories.index') }}">
                            <i class="la la-folder-open"></i> {{ __('التصنيفات') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('product_attributes.index') ? 'active' : '' }}"
                            href="{{ route('product_attributes.index') }}">
                            <i class="la la-th-list"></i> {{ __('الخصائص (الالوان والاحجام)') }}
                        </a>
                    </li>
                </ul>
            </li>

            <!-- المنتجات -->
            <li class="dropdown nav-item {{ request()->routeIs('products.index') || request()->routeIs('products.create') || request()->routeIs('products.trashed') ? 'active' : '' }}"
                data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                    <i class="la la-box"></i>
                    <span>{{ __('المنتجات') }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('products.index') ? 'active' : '' }}"
                            href="{{ route('products.index') }}">
                            <i class="la la-list"></i> {{ __('كل المنتجات') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('products.create') ? 'active' : '' }}"
                            href="{{ route('products.create') }}">
                            <i class="la la-plus-circle"></i> {{ __('إضافة منتج جديد') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('products.trashed') ? 'active' : '' }}"
                            href="{{ route('products.trashed') }}">
                            <i class="la la-trash"></i> {{ __('المنتجات المحذوفة') }}
                        </a>
                    </li>

                </ul>
            </li>

            <!-- كوبونات الخصم -->
            <li class="dropdown nav-item {{ request()->routeIs('coupons.index') || request()->routeIs('coupons.create') ? 'active' : '' }}"
                data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                    <i class="la la-ticket"></i>
                    <span>{{ __('كوبونات الخصم') }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('coupons.index') ? 'active' : '' }}"
                            href="{{ route('coupons.index') }}">
                            <i class="la la-list"></i> {{ __('كل الكوبونات') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('coupons.create') ? 'active' : '' }}"
                            href="{{ route('coupons.create') }}">
                            <i class="la la-plus-circle"></i> {{ __('إضافة كوبون جديد') }}
                        </a>
                    </li>
                </ul>
            </li>
            <!-- الطلبات -->
            <li class="dropdown nav-item {{ request()->routeIs('orders.index') || request()->routeIs('orders.show') ? 'active' : '' }}"
                data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                    <i class="la la-shopping-cart"></i>
                    <span>{{ __('الطلبات') }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('orders.index') ? 'active' : '' }}"
                            href="{{ route('orders.index') }}">
                            <i class="la la-list"></i> {{ __('جميع الطلبات') }}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown nav-item {{ request()->routeIs('clients.index') || request()->routeIs('clients.show') ||  request()->routeIs('clients.trashed') ? 'active' : '' }}"
                data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                    <i class="la la-users"></i>
                    <span>{{ __('العملاء') }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('clients.index') ? 'active' : '' }}"
                            href="{{ route('clients.index') }}">
                            <i class="la la-list"></i> {{ __('جميع العملاء') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('clients.trashed') ? 'active' : '' }}"
                            href="{{ route('clients.trashed') }}">
                            <i class="la la-trash"></i> {{ __('العملاء المحذوفة') }}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown nav-item 
                      {{ request()->routeIs('sliders.index') || request()->routeIs('features.index') || request()->routeIs('banners.index') || request()->routeIs('popup_model') || request()->routeIs('trake_page') || request()->routeIs('reviews.index') ? 'active' : '' }}"
                data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                    <i class="la la-image"></i>
                    <span>{{ __('الواجهة الأمامية') }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('popup_model') ? 'active' : '' }}"
                            href="{{ route('popup_model') }}">
                            <i class="la la-bullhorn"></i> {{ __('الإعلان المنبثق') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('sliders.index') ? 'active' : '' }}"
                            href="{{ route('sliders.index') }}">
                            <i class="la la-sliders"></i> {{ __('السلايدرز') }}
                        </a>
                    </li>
                    {{-- <li>
                        <a class="dropdown-item {{ request()->routeIs('features.index') ? 'active' : '' }}"
                            href="{{ route('features.index') }}">
                            <i class="la la-star"></i> {{ __('المميزات') }}
                        </a>
                    </li> --}}
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('banners.index') ? 'active' : '' }}"
                            href="{{ route('banners.index') }}">
                            <i class="la la-image"></i> {{ __('البنرات') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('trake_page') ? 'active' : '' }}"
                            href="{{ route('trake_page') }}">
                            <i class="la la-cog"></i> {{ __('إعدادات صفحة تتبع الطلب') }}
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item {{ request()->routeIs('reviews.index') ? 'active' : '' }}"
                            href="{{ route('reviews.index') }}">
                            <i class="la la-comments"></i> {{ __('الآراء') }}
                        </a>
                    </li>
                </ul>
            </li>
            <!-- الصفحات -->
<li class="dropdown nav-item {{ request()->routeIs('pages.index') || request()->routeIs('pages.create') ? 'active' : '' }}"
    data-menu="dropdown">
    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
        <i class="la la-file-text"></i>
        <span>{{ __('الصفحات') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item {{ request()->routeIs('pages.index') ? 'active' : '' }}"
                href="{{ route('pages.index') }}">
                <i class="la la-list"></i> {{ __('كل الصفحات') }}
            </a>
        </li>
        
    </ul>
</li>




        </ul>
    </div>
</div>
