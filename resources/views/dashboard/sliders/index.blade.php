@extends('layouts.master')
@section('title', __('السلايدرات'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('السلايدرات') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('قائمة السلايدرات') }}</h4>
                            <a href="{{ route('sliders.create') }}" class="btn btn-primary">{{ __('إضافة سلايدر جديد') }}</a>
                        </div>
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <table class="table" id="storestable">
                                <thead>
                                    <tr>
                                        <td style="width: 40px;">{{__('ترتيب العرض')}}</td> <!-- Drag handle -->
                                        <td>#</td>
                                        <th>{{ __('الصورة بالعربية') }}</th>
                                        <th>{{ __('الصورة بالعبرية') }}</th>
                                        <th>{{ __('الحالة') }}</th>
                                        <th>{{ __('الإجراءات') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach ($sliders->sortBy('order') as $key => $slider)
                                        <tr data-id="{{ $slider->id }}">

                                            <td class="drag-handle" style="cursor: move;">&#x2630;</td> <!-- ☰ icon -->
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ asset('storage/' . $slider->image_ar) }}" width="120"
                                                    height="80" alt=""></td>
                                            <td><img src="{{ asset('storage/' . $slider->image_he) }}" width="120"
                                                    height="80" alt=""></td>
                                            <td>
                                                <input type="checkbox" data-id="{{ $slider->id }}" name="status"
                                                    class="js-switch allssee" {{ $slider->status == 1 ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <a href="{{ route('sliders.edit', $slider->id) }}"
                                                    class="btn btn-warning">{{ __('تعديل') }}</a>
                                                <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('{{ __('هل أنت متأكد؟') }}')">{{ __('حذف') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $("#sortable").sortable({
            update: function(event, ui) {
                let order = [];
                $('#sortable tr').each(function() {
                    order.push($(this).data('id'));
                });

                $.ajax({
                    url: '{{ route('sliders.updateOrder') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order: order
                    },
                    success: function(data) {
                        toastr.success("تم تحديث الترتيب بنجاح");
                    }
                });
            }
        });

        // existing status toggle logic
        $("#storestable").on("change", ".js-switch", function() {
            let status = $(this).prop('checked') === true ? 1 : 0;
            let slider_id = $(this).data('id');
            $.ajax({
                type: "get",
                dataType: "json",
                url: '{{ route('update_status_slider') }}',
                data: {
                    'status': status,
                    'slider_id': slider_id
                },
                success: function(data) {
                    toastr.success("تم تعديل الحالة بنجاح");
                }
            });
        });
    </script>
@endsection
