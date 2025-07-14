@extends('layouts.master')
@section('title', __('المميزات'))
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('المميزات') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('المميزات') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('جميع المميزات') }}</h4>
                      
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <!-- صندوق الفلتر المحسن -->

                            <!-- جدول المميزات -->
                            @include('dashboard.inc.alerts')

                             <table class="table" id="storestable">
                                <thead>
                                    <tr>
                                        <td style="width: 40px;">{{__('ترتيب العرض')}}</td> <!-- Drag handle -->
                                        <th>#</th>
                                        <th>{{ __('الايقونة') }}</th>
                                        <th>{{ __('العنوان') }}</th>
                                        <th>{{ __('الوصف') }}</th>
                                        <th>{{ __('خيارات') }}</th>
                                    </tr>
                                </thead>
                               
                                        <tbody id="sortable">
                                    @foreach ($services->sortBy('order') as $key => $service)
                                        <tr data-id="{{ $service->id }}">

                                            <td class="drag-handle" style="cursor: move;">&#x2630;</td> <!-- ☰ icon -->
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{asset('storage/'.$service->icon)}}" width="80" height="50" alt=""></td>
                                            <td>{{ $service->getTranslation('title', app()->getLocale()) }}</td>
                                             <td>{{ $service->getTranslation('description', app()->getLocale()) }}</td>


                                            <td>
                                                <a href="{{ route('features.edit', $service->id) }}"
                                                    class="btn btn-sm btn-warning"><i class="ft-edit"></i></a>
                                               
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
                    url: '{{ route('features.updateOrder') }}',
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

       
    </script>
@endsection
