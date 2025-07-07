@extends('layouts.master')

@section('title', __('خصائص المنتجات'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('خصائص المنتجات') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('خصائص المنتجات') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12 text-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addAttributeModal">
                        <i class="ft-plus"></i> {{ __('إضافة خاصية جديدة') }}
                    </button>
                </div>
            </div>

            <div class="content-body">
                <section id="attributes-list">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('النوع') }}</th>
                                            <th>{{ __('القيمة (عربي)') }}</th>
                                            <th>{{ __('القيمة (عبري)') }}</th>
                                            <th class="text-center" style="width: 150px;">{{ __('الإجراءات') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attributes as $attribute)
                                            <tr data-id="{{ $attribute->id }}">
                                                <td>{{ ucfirst($attribute->type) }}</td>
                                                <td>{{ $attribute->getTranslation('value', 'ar') }}
                                                    @if ($attribute->type == 'color' && $attribute->code)
                                                        <span
                                                            style="
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-right: 8px;
            background-color: {{ $attribute->code }};
        "
                                                            title="{{ $attribute->code }}"></span>
                                                    @endif
                                                </td>
                                                <td class="">{{ $attribute->getTranslation('value', 'he') }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-info edit-attribute-btn"
                                                        data-id="{{ $attribute->id }}" data-type="{{ $attribute->type }}"
                                                        data-value-ar="{{ $attribute->getTranslation('value', 'ar') }}"
                                                        data-code="{{ $attribute->code }}"
                                                        data-value-he="{{ $attribute->getTranslation('value', 'he') }}">
                                                        <i class="ft-edit"></i> {{ __('تعديل') }}
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-attribute-btn"
                                                        data-id="{{ $attribute->id }}">
                                                        <i class="ft-trash"></i> {{ __('حذف') }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- مودال الإضافة -->
    <div class="modal fade" id="addAttributeModal" tabindex="-1" role="dialog" aria-labelledby="addAttributeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="addAttributeForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAttributeModalLabel">{{ __('إضافة خاصية جديدة') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('إغلاق') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('النوع') }}</label>
                            <select name="type" id="create_type" class="form-control" required>
                                <option value="" selected disabled>{{ __('اختر النوع') }}</option>
                                <option value="color">{{ __('لون') }}</option>
                                <option value="size">{{ __('حجم') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('القيمة (عربي)') }}</label>
                            <input type="text" name="value[ar]" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('القيمة (عبري)') }}</label>
                            <input type="text" name="value[he]" class="form-control text-right" dir="rtl">
                        </div>
                        <div class="form-group color-picker-group" id="create_color_group" style="display: none;">
                            <label>{{ __('كود اللون') }}</label>
                            <input type="color" name="code" class="form-control" value="#000000">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('حفظ') }}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('إلغاء') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- مودال التعديل -->
    <div class="modal fade" id="editAttributeModal" tabindex="-1" role="dialog" aria-labelledby="editAttributeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="editAttributeForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="attribute_id" id="edit_attribute_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAttributeModalLabel">{{ __('تعديل الخاصية') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('إغلاق') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('النوع') }}</label>
                            <select name="type" id="edit_type" class="form-control" required>
                                <option value="color">{{ __('لون') }}</option>
                                <option value="size">{{ __('حجم') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('القيمة (عربي)') }}</label>
                            <input type="text" name="value[ar]" id="edit_value_ar" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('القيمة (عبري)') }}</label>
                            <input type="text" name="value[he]" id="edit_value_he" class="form-control text-right"
                                dir="rtl">
                        </div>
                        <div class="form-group color-picker-group" style="display: none;">
                            <label>{{ __('كود اللون') }}</label>
                            <input type="color" name="code" id="edit_color_code" class="form-control"
                                value="#000000">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('تحديث') }}</button>
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('إلغاء') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // إضافة خاصية جديدة
            $('#addAttributeForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('product_attributes.store') }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        alert(response.success);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('حدث خطأ، تحقق من البيانات وحاول مجددًا.');
                    }
                });
            });

            // فتح مودال التعديل مع تعبئة البيانات
            $('.edit-attribute-btn').click(function() {
                var id = $(this).data('id');
                var type = $(this).data('type');
                var valueAr = $(this).data('value-ar');
                var valueHe = $(this).data('value-he');
                var code = $(this).data('code');

                $('#edit_attribute_id').val(id);
                $('#edit_type').val(type);
                $('#edit_value_ar').val(valueAr);
                $('#edit_value_he').val(valueHe);
                if(type === 'color') {
                    $('#edit_color_code').closest('.color-picker-group').show();
                } else {
                    $('#edit_color_code').closest('.color-picker-group').hide();
                }
                $('#edit_color_code').val(code);

                $('#editAttributeModal').modal('show');
            });

            // تحديث الخاصية
            $('#editAttributeForm').submit(function(e) {
                e.preventDefault();

                var id = $('#edit_attribute_id').val();
                var formData = $(this).serialize();

                // نجهز رابط التحديث مع استبدال الـ placeholder
                var urlTemplate =
                    "{{ route('product_attributes.update', ['product_attribute' => '__id__']) }}";
                var url = urlTemplate.replace('__id__', id);

                $.ajax({
                    url: url,
                    method: "POST", // نستخدم POST مع _method=PUT في البيانات
                    data: formData,
                    success: function(response) {
                        swal({
                            title: response.success,
                            icon: "success",
                        }).then(() => {
                            location.reload();
                        })
                    },
                    error: function() {
                        swal({
                            title: __('حدث خطأ، تحقق من البيانات وحاول مجددًا.'),
                            icon: "danger",
                        });
                    }
                });
            });
            // إظهار/إخفاء كود اللون عند تغيير النوع - مودال الإضافة
            $('#create_type').on('change', function() {
                if ($(this).val() === 'color') {
                    $('#create_color_group').show();
                } else {
                    $('#create_color_group').hide();
                }
            }).trigger('change');

            // إظهار/إخفاء كود اللون عند تغيير النوع - مودال التعديل
            $('#edit_type').on('change', function() {
                if ($(this).val() === 'color') {
                    $('#edit_color_code').closest('.color-picker-group').show();
                } else {
                    $('#edit_color_code').closest('.color-picker-group').hide();
                }
            }).trigger('change');


            // حذف الخاصية
            $('.delete-attribute-btn').click(function() {
                if (!confirm("{{ __('هل أنت متأكد من حذف هذه الخاصية؟') }}")) return;

                var id = $(this).data('id');
                var urlTemplate =
                    "{{ route('product_attributes.destroy', ['product_attribute' => '__id__']) }}";
                var urldelete = urlTemplate.replace('__id__', id);

                $.ajax({
                    url: urldelete,
                    method: "POST",
                    data: {
                        _method: 'DELETE',
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        swal({
                            title: response.success,
                            icon: "success",
                        }).then(() => {
                            location.reload();
                        })
                    },
                    error: function() {
                        swal({
                            title: __('حدث خطأ، تحقق من البيانات وحاول مجددًا.'),
                            icon: "danger",
                        });
                    }
                });
            });
        });
    </script>
@endsection
