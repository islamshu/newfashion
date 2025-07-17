<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('الاسم') }}</th>
            <th>{{ __('رقم الهاتف') }}</th>
            <th>{{ __('الحالة') }}</th>
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
