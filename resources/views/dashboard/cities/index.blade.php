@extends('layouts.master')

@section('title', __('إدارة المدن'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('إدارة المدن') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('المدن') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12 text-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addCityModal">
                        <i class="ft-plus"></i> {{ __('إضافة مدينة جديدة') }}
                    </button>
                </div>
            </div>

            <div class="content-body">
                <section id="cities-list">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('اسم المدينة بالعربية') }}</th>
                                            <th>{{ __('اسم المدينة بالعبرية') }}</th>
                                            <th>{{ __('سعر التوصيل') }}</th>
                                            <th class="text-center" style="width: 150px;">{{ __('الاجراءات') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cities as $city)
                                            <tr data-id="{{ $city->id }}">
                                                <td>{{ $city->getTranslation('name', 'ar') }}</td>
                                                <td class="text-right" dir="rtl">
                                                    {{ $city->getTranslation('name', 'he') }}</td>
                                                <td>{{ number_format($city->delivery_fee, 2) }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-info edit-city-btn"
                                                        data-id="{{ $city->id }}"
                                                        data-name-ar="{{ $city->getTranslation('name', 'ar') }}"
                                                        data-name-he="{{ $city->getTranslation('name', 'he') }}"
                                                        data-delivery-fee="{{ $city->delivery_fee }}">
                                                        <i class="ft-edit"></i> {{ __('تعديل') }}
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-city-btn"
                                                        data-id="{{ $city->id }}">
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

    <!-- Add Modal -->
    <div class="modal fade" id="addCityModal" tabindex="-1" role="dialog" aria-labelledby="addCityModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="addCityForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCityModalLabel">{{ __('إضافة مدينة جديدة') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('إغلاق') }}">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('اسم المدينة بالعربية') }}</label>
                            <input type="text" name="name[ar]" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('اسم المدينة بالعبرية') }}</label>
                            <input type="text" name="name[he]" class="form-control text-right" dir="rtl" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('سعر التوصيل') }}</label>
                            <input type="number" step="0.01" min="0" name="delivery_fee" class="form-control"
                                required>
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

    <!-- تعديل Modal -->
    <div class="modal fade" id="editCityModal" tabindex="-1" role="dialog" aria-labelledby="editCityModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="editCityForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="city_id" id="edit_city_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCityModalLabel">{{ __('تعديل المدينة') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('إغلاق') }}">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('اسم المدينة بالعربية') }}</label>
                            <input type="text" name="name[ar]" id="edit_name_ar" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('اسم المدينة بالعبرية') }}</label>
                            <input type="text" name="name[he]" id="edit_name_he" class="form-control text-right"
                                dir="rtl" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('سعر التوصيل') }}</label>
                            <input type="number" step="0.01" min="0" name="delivery_fee"
                                id="edit_delivery_fee" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('تعديل') }}</button>
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
            // Add new city
            $('#addCityForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('cities.store') }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        $('#addCityModal').modal('hide');
                        swal({
                            title: response.success,
                            icon: "success",
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });

            // Open edit modal with data
            $('.edit-city-btn').click(function() {
                var id = $(this).data('id');
                var nameAr = $(this).data('name-ar');
                var nameHe = $(this).data('name-he');
                var deliveryFee = $(this).data('delivery-fee');

                $('#edit_city_id').val(id);
                $('#edit_name_ar').val(nameAr);
                $('#edit_name_he').val(nameHe);
                $('#edit_delivery_fee').val(deliveryFee);

                $('#editCityModal').modal('show');
            });

            // 'اسم المدينة بالعبرية' city
            $('#editCityForm').submit(function(e) {
                e.preventDefault();
                var id = $('#edit_city_id').val();
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('cities.update', ':id') }}".replace(':id', id),
                    method: "POST", // Using POST with _method=PUT
                    data: formData,
                    success: function(response) {
                        $('#editCityModal').modal('hide');
                        swal({
                            title: response.success,
                            icon: "success",
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });

            // حذف city
            $('.delete-city-btn').click(function() {
                if (!confirm("{{ __('Are you sure you want to delete this city?') }}")) return;

                var id = $(this).data('id');

                $.ajax({
                    url: "{{ route('cities.destroy', ':id') }}".replace(':id', id),
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
                        });
                    },
                    error: function() {
                        swal({
                            title: "{{ __('Error occurred, please try again.') }}",
                            icon: "error",
                        });
                    }
                });
            });
        });
    </script>
@endsection
