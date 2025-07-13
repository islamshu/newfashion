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
            <li class="dropdown nav-item {{ request()->routeIs('products.index') || request()->routeIs('products.create') ? 'active' : '' }}"
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
            <li class="dropdown nav-item 
    {{ request()->routeIs('sliders.index') || request()->routeIs('features.index') || request()->routeIs('banners.index') || request()->routeIs('popup_model') ? 'active' : '' }}"
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
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('features.index') ? 'active' : '' }}"
                            href="{{ route('features.index') }}">
                            <i class="la la-star"></i> {{ __('المميزات') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('banners.index') ? 'active' : '' }}"
                            href="{{ route('banners.index') }}">
                            <i class="la la-image"></i> {{ __('البنرات') }}
                        </a>
                    </li>
                </ul>
            </li>


        </ul>
    </div>
</div>
