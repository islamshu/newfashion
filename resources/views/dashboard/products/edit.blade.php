@extends('layouts.master')
@section('style')
    <style>
        /* Switch styling */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        .switch input:checked+.slider {
            background-color: #28a745;
        }

        .switch input:checked+.slider:before {
            transform: translateX(24px);
        }

        /* Form styling */
        .card {
            box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 1.5rem;
            border-radius: 10px 10px 0 0 !important;
        }

        .card-header h4 {
            color: #333;
            font-weight: 600;
        }

        .card-body {
            padding: 2rem;
        }

        .form-section {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            padding: 1.5rem;
        }

        .section-title {
            color: #3d4852;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .form-group label {
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 6px;
            padding: 10px 15px;
            border: 1px solid #d2d6dc;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea.form-control {
            min-height: 100px;
        }

        .btn-primary {
            background-color: #4299e1;
            border-color: #4299e1;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #3182ce;
            border-color: #3182ce;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #718096;
            border-color: #718096;
        }

        .btn-danger {
            background-color: #e53e3e;
            border-color: #e53e3e;
        }

        /* Image styling */
        .image-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
        }

        .image-wrapper {
            position: relative;
            width: 150px;
            height: 150px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background-color: #e53e3e;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.3s;
        }

        .remove-btn:hover {
            opacity: 1;
        }

        .variation-row {
            background-color: white;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .switch-container {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .switch-container label {
            margin-right: 10px;
            margin-bottom: 0;
        }

        .required-field::after {
            content: " *";
            color: #e53e3e;
        }
    </style>
@endsection
@section('title', __('تعديل المنتج'))
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">{{ __('تعديل المنتج') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('المنتجات') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('تعديل المنتج') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section id="product-edit">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="ft-edit-2"></i> {{ __('تعديل بيانات المنتج') }}</h4>
                                </div>
                                <div class="card-content collapse show">

                                    @include('dashboard.inc.alerts')
                                    <div class="card-body">
                                        <form action="{{ route('products.update', $product->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="row">
                                                <!-- الاسم -->
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="name_ar"
                                                            class="required-field">{{ __('اسم المنتج (عربي)') }}</label>
                                                        <input type="text" id="name_ar" name="name[ar]"
                                                            class="form-control"
                                                            value="{{ old('name.ar', $product->getTranslation('name', 'ar')) }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="name_he"
                                                            class="required-field">{{ __('اسم المنتج (عبري)') }}</label>
                                                        <input type="text" id="name_he" name="name[he]"
                                                            class="form-control text-right" dir="rtl"
                                                            value="{{ old('name.he', $product->getTranslation('name', 'he')) }}"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- الفئة والصورة -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="category_id"
                                                            class="required-field">{{ __('التصنيف') }}</label>
                                                        <select id="category_id" name="category_id" class="form-control"
                                                            required>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- صور المصغرات -->
                                            <div class="form-group mb-4">
                                                <label>{{ __('صور المصغرات') }}</label>
                                                <input type="file" name="thumbnails[]" class="form-control" multiple>
                                                <div class="image-container" id="thumbnails-container">
                                                    @foreach ($product->thumbnails as $thumb)
                                                        <div class="image-wrapper" data-id="{{ $thumb->id }}">
                                                            <img src="{{ asset('storage/' . $thumb->image) }}"
                                                                alt="صورة مصغرة">
                                                            <div class="remove-btn remove-thumbnail">
                                                                <i class="ft-trash"></i>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="image-container" id="new-thumbnails-preview"></div>
                                            </div>

                                            <!-- صور المنتج الإضافية -->
                                            <div class="form-group mb-4">
                                                <label>{{ __('صور إضافية') }}</label>
                                                <input type="file" name="images[]" class="form-control" multiple>
                                                <div class="image-container" id="images-container">
                                                    @foreach ($product->images as $image)
                                                        <div class="image-wrapper" data-id="{{ $image->id }}">
                                                            <img src="{{ asset('storage/' . $image->image) }}"
                                                                alt="صورة إضافية">
                                                            <div class="remove-btn remove-image">
                                                                <i class="ft-trash"></i>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="image-container" id="new-images-preview"></div>
                                            </div>

                                            <!-- السعر والخصم -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="price">{{ __('السعر') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" step="0.01" id="price" name="price"
                                                            class="form-control"
                                                            value="{{ old('price', $product->price) }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="sku">{{ __('SKU') }}</label>
                                                        <input type="text" id="sku" name="sku"
                                                            class="form-control" value="{{ old('sku', $product->sku) }}"
                                                            placeholder="SKU12345">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- الوصف القصير -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label
                                                            for="short_description_ar">{{ __('الوصف القصير (عربي)') }}</label>
                                                        <textarea id="short_description_ar" name="short_description[ar]" class="form-control" rows="3">{{ old('short_description.ar', $product->getTranslation('short_description', 'ar')) }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label
                                                            for="short_description_he">{{ __('الوصف القصير (عبري)') }}</label>
                                                        <textarea id="short_description_he" name="short_description[he]" class="form-control text-right" dir="rtl"
                                                            rows="3">{{ old('short_description.he', $product->getTranslation('short_description', 'he')) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- الوصف الكامل -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label
                                                            for="description_ar">{{ __('الوصف الكامل (عربي)') }}</label>
                                                        <textarea id="description_ar" name="description[ar]" class="form-control" rows="5">{{ old('description.ar', $product->getTranslation('description', 'ar')) }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label
                                                            for="description_he">{{ __('الوصف الكامل (عبري)') }}</label>
                                                        <textarea id="description_he" name="description[he]" class="form-control text-right" dir="rtl" rows="5">{{ old('description.he', $product->getTranslation('description', 'he')) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- الخيارات -->
                                            <div class="form-section mb-4">
                                                <h5 class="section-title"><i class="ft-settings"></i>
                                                    {{ __('خيارات المنتج') }}</h5>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="switch-container">
                                                            <label for="status_switch">{{ __('حالة المنتج') }}</label>
                                                            <label class="switch mb-0">
                                                                <input type="checkbox" id="status_switch" name="status"
                                                                    value="1"
                                                                    {{ old('status', $product->status) ? 'checked' : '' }}>
                                                                <span class="slider"></span>
                                                            </label>
                                                            <span
                                                                class="{{ $product->status ? 'text-success' : 'text-secondary' }} mr-2">
                                                                {{ $product->status ? __('نشط') : __('غير نشط') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="switch-container">
                                                            <label for="is_featured_switch">{{ __('منتج مميز') }}</label>
                                                            <label class="switch mb-0">
                                                                <input type="checkbox" id="is_featured_switch"
                                                                    name="is_featured" value="1"
                                                                    {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                                                <span class="slider"></span>
                                                            </label>
                                                            <span
                                                                class="{{ $product->is_featured ? 'text-primary' : 'text-secondary' }} mr-2">
                                                                {{ $product->is_featured ? __('مميز') : __('عادي') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- المتغيرات -->
                                            <div class="form-section mb-4">
                                                <h5 class="section-title"><i class="ft-layers"></i>
                                                    {{ __('إدارة المتغيرات') }}</h5>
                                                <p class="text-muted mb-3">
                                                    {{ __('أضف/عدّل متغيرات المنتج مثل الألوان والمقاسات والكميات') }}</p>

                                                <div id="variations-container">
                                                    @foreach (old('variations', $product->variations->toArray()) as $index => $variation)
                                                        <div class="variation-row row align-items-center">
                                                            <div class="col-md-4">
                                                                <label class="d-block text-sm">{{ __('اللون') }}</label>
                                                                <select name="variations[{{ $index }}][color_id]"
                                                                    class="form-control">
                                                                    <option value="">{{ __('-- بلا لون --') }}
                                                                    </option>
                                                                    @foreach ($colors as $color)
                                                                        <option value="{{ $color->id }}"
                                                                            {{ (int) ($variation['color_id'] ?? 0) === $color->id ? 'selected' : '' }}>
                                                                            {{ $color->getTranslation('value', app()->getLocale()) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="d-block text-sm">{{ __('المقاس') }}</label>
                                                                <select name="variations[{{ $index }}][size_id]"
                                                                    class="form-control">
                                                                    <option value="">{{ __('-- بلا مقاس --') }}
                                                                    </option>
                                                                    @foreach ($sizes as $size)
                                                                        <option value="{{ $size->id }}"
                                                                            {{ (int) ($variation['size_id'] ?? 0) === $size->id ? 'selected' : '' }}>
                                                                            {{ $size->getTranslation('value', app()->getLocale()) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="d-block text-sm">{{ __('الكمية') }}</label>
                                                                <input type="number"
                                                                    name="variations[{{ $index }}][stock]"
                                                                    class="form-control"
                                                                    value="{{ $variation['stock'] ?? 0 }}"
                                                                    min="0">
                                                            </div>
                                                            <div class="col-md-1 d-flex align-items-end">
                                                                <button type="button"
                                                                    class="btn btn-danger remove-variation"
                                                                    title="{{ __('حذف المتغير') }}">
                                                                    <i class="ft-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <button type="button" class="btn btn-secondary mt-2" id="add-variation">
                                                    <i class="ft-plus"></i> {{ __('إضافة متغير جديد') }}
                                                </button>
                                            </div>

                                            <!-- زر التحديث -->
                                            <div class="form-actions text-center mt-4">
                                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                                    <i class="la la-check-square-o"></i> {{ __('تحديث المنتج') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let variationIndex = {{ count(old('variations', $product->variations)) }};

            // إضافة متغير جديد
            $('#add-variation').click(function() {
                let html = `
                <div class="variation-row row align-items-center mt-2">
                    <div class="col-md-4">
                        <label class="d-block text-sm">{{ __('اللون') }}</label>
                        <select name="variations[${variationIndex}][color_id]" class="form-control">
                            <option value="">{{ __('-- بلا لون --') }}</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->getTranslation('value', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="d-block text-sm">{{ __('المقاس') }}</label>
                        <select name="variations[${variationIndex}][size_id]" class="form-control">
                            <option value="">{{ __('-- بلا مقاس --') }}</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->getTranslation('value', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="d-block text-sm">{{ __('الكمية') }}</label>
                        <input type="number" name="variations[${variationIndex}][stock]" class="form-control" value="0" min="0">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-variation" title="{{ __('حذف المتغير') }}">
                            <i class="ft-trash"></i>
                        </button>
                    </div>
                </div>`;
                $('#variations-container').append(html);
                variationIndex++;
            });

            // حذف متغير
            $(document).on('click', '.remove-variation', function() {
                if ($('.variation-row').length > 1) {
                    $(this).closest('.variation-row').remove();
                } else {
                    toastr.error('{{ __('يجب أن يحتوي المنتج على متغير واحد على الأقل') }}');
                }
            });

            // معاينة الصور المصغرات الجديدة عند الرفع
            $('input[name="thumbnails[]"]').change(function(e) {
                if (this.files && this.files.length > 0) {
                    Array.from(this.files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const randomId = 'thumb-' + Math.random().toString(36).substr(2, 9);
                            $('#new-thumbnails-preview').append(`
                                <div class="image-wrapper" id="${randomId}">
                                    <img src="${e.target.result}" alt="صورة مصغرة جديدة">
                                    <div class="remove-btn remove-new-thumbnail" data-target="${randomId}">
                                        <i class="ft-trash"></i>
                                    </div>
                                </div>
                            `);
                        }
                        reader.readAsDataURL(file);
                    });
                }
            });

            // معاينة الصور الإضافية الجديدة عند الرفع
            $('input[name="images[]"]').change(function(e) {
                if (this.files && this.files.length > 0) {
                    Array.from(this.files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const randomId = 'img-' + Math.random().toString(36).substr(2, 9);
                            $('#new-images-preview').append(`
                                <div class="image-wrapper" id="${randomId}">
                                    <img src="${e.target.result}" alt="صورة إضافية جديدة">
                                    <div class="remove-btn remove-new-image" data-target="${randomId}">
                                        <i class="ft-trash"></i>
                                    </div>
                                </div>
                            `);
                        }
                        reader.readAsDataURL(file);
                    });
                }
            });

            // حذف الصور المصغرات القديمة
            $(document).on('click', '.remove-thumbnail', function() {
                const wrapper = $(this).closest('.image-wrapper');
                const thumbId = wrapper.data('id');

                // إضافة حقل مخفي للإشارة إلى الصور المحذوفة
                $('<input>').attr({
                    type: 'hidden',
                    name: 'deleted_thumbnails[]',
                    value: thumbId
                }).appendTo('form');

                wrapper.remove();
            });

            // حذف الصور الإضافية القديمة
            $(document).on('click', '.remove-image', function() {
                const wrapper = $(this).closest('.image-wrapper');
                const imgId = wrapper.data('id');

                // إضافة حقل مخفي للإشارة إلى الصور المحذوفة
                $('<input>').attr({
                    type: 'hidden',
                    name: 'deleted_images[]',
                    value: imgId
                }).appendTo('form');

                wrapper.remove();
            });

            // حذف الصور المصغرات الجديدة قبل الرفع
            $(document).on('click', '.remove-new-thumbnail', function() {
                const targetId = $(this).data('target');
                $('#' + targetId).remove();
            });

            // حذف الصور الإضافية الجديدة قبل الرفع
            $(document).on('click', '.remove-new-image', function() {
                const targetId = $(this).data('target');
                $('#' + targetId).remove();
            });

            // تغيير حالة السويتش
            $('input[type="checkbox"][name="status"], input[type="checkbox"][name="is_featured"]').change(
                function() {
                    const statusSpan = $(this).closest('.switch-container').find('span');
                    if ($(this).is(':checked')) {
                        statusSpan.removeClass('text-secondary').addClass($(this).attr('name') === 'status' ?
                            'text-success' : 'text-primary');
                        statusSpan.text($(this).attr('name') === 'status' ? '{{ __('نشط') }}' :
                            '{{ __('مميز') }}');
                    } else {
                        statusSpan.removeClass($(this).attr('name') === 'status' ? 'text-success' :
                            'text-primary').addClass('text-secondary');
                        statusSpan.text($(this).attr('name') === 'status' ? '{{ __('غير نشط') }}' :
                            '{{ __('عادي') }}');
                    }
                });
        });
    </script>
@endsection
