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

        .image-preview-container {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .image-preview {
            max-width: 100px;
            max-height: 100px;
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 4px;
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

        .btn-success {
            background-color: #38a169;
            border-color: #38a169;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-success:hover {
            background-color: #2f855a;
            border-color: #2f855a;
            transform: translateY(-2px);
        }

        .btn-primary {
            background-color: #4299e1;
            border-color: #4299e1;
        }

        .btn-danger {
            background-color: #e53e3e;
            border-color: #e53e3e;
        }

        .variation-row {
            background-color: white;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 10px;
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

        .image-preview-container {
            margin-top: 10px;
        }

        .image-preview {
            max-width: 150px;
            max-height: 150px;
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 5px;
            margin-top: 10px;
        }
    </style>
@endsection
@section('title', __('إضافة منتج جديد'))
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">{{ __('إضافة منتج جديد') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('المنتجات') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('إضافة منتج') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section id="product-create">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="ft-plus-circle"></i> {{ __('بيانات المنتج الأساسية') }}
                                    </h4>
                                </div>
                                <div class="card-content collapse show">
                                    @include('dashboard.inc.alerts')

                                    <div class="card-body">
                                        <form action="{{ route('products.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="row">
                                                <!-- الاسم -->
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="name_ar">{{ __('اسم المنتج (عربي)') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="name_ar" name="name[ar]"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="name_he">{{ __('اسم المنتج (عبري)') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="name_he" name="name[he]"
                                                            class="form-control text-right" dir="rtl" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- الفئة والصورة -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="category_id">{{ __('التصنيف') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select id="category_id" name="category_id" class="form-control"
                                                            required>
                                                            <option value="" disabled selected>--
                                                                {{ __('اختر التصنيف') }} --</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- صور المنتج -->
                                            <!-- صور المنتج -->


                                            <!-- صور الثامب -->
                                            <div class="form-group mb-3">
                                                <label for="thumbnails">{{ __('صور الثامب (متعددة)') }}</label>
                                                <input type="file" id="thumbnails" name="thumbnails[]"
                                                    class="form-control" multiple accept="image/*">
                                                <div id="thumbnails-preview-container"
                                                    class="image-preview-container d-flex flex-wrap"></div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="images">{{ __('صور المنتج (متعددة)') }}</label>
                                                <input type="file" id="images" name="images[]" class="form-control"
                                                    multiple accept="image/*">
                                                <div id="images-preview-container"
                                                    class="image-preview-container d-flex flex-wrap"></div>
                                            </div>



                                            <!-- السعر و SKU -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="price">{{ __('السعر') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" step="0.01" id="price" name="price"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="sku">{{ __('SKU') }}</label>
                                                        <input type="text" id="sku" name="sku"
                                                            class="form-control" placeholder="SKU12345">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- الوصف القصير -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label
                                                            for="short_description_ar">{{ __('الوصف القصير (عربي)') }}</label>
                                                        <textarea id="short_description_ar" name="short_description[ar]" class="form-control" rows="3"
                                                            placeholder="{{ __('وصف مختصر للمنتج') }}"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label
                                                            for="short_description_he">{{ __('الوصف القصير (عبري)') }}</label>
                                                        <textarea id="short_description_he" name="short_description[he]" class="form-control text-right" dir="rtl"
                                                            rows="3" placeholder="{{ __('وصف مختصر للمنتج') }}"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- الوصف الكامل -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label
                                                            for="description_ar">{{ __('الوصف الكامل (عربي)') }}</label>
                                                        <textarea id="description_ar" name="description[ar]" class="form-control" rows="5"
                                                            placeholder="{{ __('وصف تفصيلي للمنتج') }}"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label
                                                            for="description_he">{{ __('الوصف الكامل (عبري)') }}</label>
                                                        <textarea id="description_he" name="description[he]" class="form-control text-right" dir="rtl" rows="5"
                                                            placeholder="{{ __('وصف تفصيلي للمنتج') }}"></textarea>
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
                                                                    value="1" checked>
                                                                <span class="slider"></span>
                                                            </label>
                                                            <span class="text-success mr-2">{{ __('نشط') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="switch-container">
                                                            <label for="is_featured_switch">{{ __('منتج مميز') }}</label>
                                                            <label class="switch mb-0">
                                                                <input type="checkbox" id="is_featured_switch"
                                                                    name="is_featured" value="1">
                                                                <span class="slider"></span>
                                                            </label>
                                                            <span class="text-primary mr-2">{{ __('مميز') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- المتغيرات -->
                                            <div class="form-section mb-4">
                                                <h5 class="section-title"><i class="ft-layers"></i>
                                                    {{ __('إدارة المتغيرات') }}</h5>
                                                <p class="text-muted mb-3">
                                                    {{ __('أضف متغيرات مختلفة للمنتج مثل الألوان والمقاسات والكميات') }}
                                                </p>

                                                <div id="variations-container">
                                                    <div class="variation-row row align-items-center">
                                                        <div class="col-md-4">
                                                            <label class="d-block text-sm">{{ __('اللون') }}</label>
                                                            <select name="variations[0][color_id]" class="form-control">
                                                                <option value="">-- {{ __('اختر اللون') }} --
                                                                </option>
                                                                @foreach ($colors as $color)
                                                                    <option value="{{ $color->id }}">
                                                                        {{ $color->getTranslation('value', app()->getLocale()) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="d-block text-sm">{{ __('المقاس') }}</label>
                                                            <select name="variations[0][size_id]" class="form-control">
                                                                <option value="">-- {{ __('اختر المقاس') }} --
                                                                </option>
                                                                @foreach ($sizes as $size)
                                                                    <option value="{{ $size->id }}">
                                                                        {{ $size->getTranslation('value', app()->getLocale()) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="d-block text-sm">{{ __('الكمية') }}</label>
                                                            <input type="number" name="variations[0][stock]"
                                                                class="form-control" value="0" min="0"
                                                                placeholder="0">
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-end">
                                                            <button type="button" class="btn btn-danger remove-variation"
                                                                title="{{ __('حذف المتغير') }}">
                                                                <i class="ft-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="button" class="btn btn-primary mt-2" id="add-variation">
                                                    <i class="ft-plus"></i> {{ __('إضافة متغير جديد') }}
                                                </button>
                                            </div>

                                            <!-- زر الحفظ -->
                                            <div class="form-actions text-center mt-4">
                                                <button type="submit" class="btn btn-success btn-lg px-5">
                                                    <i class="la la-check-square-o"></i> {{ __('حفظ المنتج') }}
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
            function previewMultipleImages(input, containerId) {
                const container = document.getElementById(containerId);
                container.innerHTML = ''; // حذف الصور السابقة

                if (input.files) {
                    Array.from(input.files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'image-preview'; // تنسيق
                            container.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            }

            document.getElementById('images').addEventListener('change', function() {
                previewMultipleImages(this, 'images-preview-container');
            });

            document.getElementById('thumbnails').addEventListener('change', function() {
                previewMultipleImages(this, 'thumbnails-preview-container');
            });

            let variationIndex = 1;

            // إضافة متغير جديد
            $(document).on('click', '#add-variation', function() {
                let html = `
                <div class="variation-row row align-items-center mt-2">
                    <div class="col-md-4">
                        <select name="variations[${variationIndex}][color_id]" class="form-control">
                            <option value="">-- {{ __('اختر اللون') }} --</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->getTranslation('value', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="variations[${variationIndex}][size_id]" class="form-control">
                            <option value="">-- {{ __('اختر المقاس') }} --</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->getTranslation('value', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="variations[${variationIndex}][stock]" class="form-control" value="0" min="0" placeholder="0">
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

            // معاينة الصورة
            $('#image').change(function(e) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
        // معاينة صور متعددة
    </script>
@endsection
