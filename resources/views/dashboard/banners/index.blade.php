@extends('layouts.master')
@section('title', 'البانرات')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">البانرات</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item active">البانرات</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <div class="card">
              

                <div class="card-body">
                    @include('dashboard.inc.alerts')

                    <div id="banners-container">
                        @include('dashboard.banners.partials.table', ['banners' => $banners])
                    </div>
                </div>
            </div>
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
                    url: '{{ route('banners.updateOrder') }}',
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
            let banner_id = $(this).data('id');
            $.ajax({
                type: "get",
                dataType: "json",
                url: '{{ route('update_status_banner') }}',
                data: {
                    'status': status,
                    'banner_id': banner_id
                },
                success: function(data) {
                    toastr.success("تم تعديل الحالة بنجاح");
                }
            });
        });
    </script>
@endsection
