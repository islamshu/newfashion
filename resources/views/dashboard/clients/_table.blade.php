<table class="table table-bordered" id="storestable">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('الاسم') }}</th>
            <th>{{ __('رقم الهاتف') }}</th>
            <th>{{ __('الحالة') }}</th>
            <th>{{__('تعطيل العميل')}}</th>
            <th>{{ __('خيارات') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($clients as $client)
            <tr>
                <td>{{ $client->id }}</td>
                <td>{{ $client->name }}</td>
                <td>{{ $client->phone_number }}</td>
                <td>
                    @if(empty($client->otp))
                        <span class="badge badge-success">تم التحقق</span>
                    @else
                        <span class="badge badge-warning">غير محقق</span>
                    @endif
                </td>
                <td>
                    <input type="checkbox" data-id="{{ $client->id }}" name="is_active" class="js-switch allssee"
                        {{ $client->is_active == 1 ? 'checked' : '' }}>
                </td>
                <td>
                    <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-info"><i class="ft-eye"></i></a>
                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning"><i class="ft-edit"></i></a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">{{ __('لا يوجد عملاء') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $clients->links() }}
</div>
<script>
      $("#storestable").on("change", ".js-switch", function() {
        let is_active = $(this).prop('checked') === true ? 1 : 0;
        let client_id = $(this).data('id');

       

        // استمر في الإرسال للسيرفر
        $.ajax({
            type: "get",
            dataType: "json",
            url: '{{ route('update_status_client') }}',
            data: {
                'is_active': is_active,
                'client_id': client_id
            },
            success: function(data) {
                toastr.success(data.message);
            }
        });
    });
</script>
