<table class="table table-hover table-bordered text-center align-middle">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>{{ __('العميل') }}</th>
            <th>{{ __('اسم المستلم') }}</th>
            <th>{{ __('البريد الإلكتروني') }}</th>
            <th>{{ __('الهاتف') }}</th>
            <th>{{ __('الإجمالي') }}</th>
            <th>{{ __('الحالة') }}</th>
            <th>{{ __('تاريخ الإنشاء') }}</th>
            <th>{{ __('الخيارات') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($orders as $order)
            <tr>
                <td>{{ $loop->iteration  }}</td>
                <td class="text-nowrap">{{ $order->client->name }}</td>
                <td class="text-nowrap">{{ $order->fname }} {{ $order->lname }}</td>
                <td class="text-nowrap">{{ $order->email }}</td>
                <td class="text-nowrap">{{ $order->phone }}</td>
                <td><strong>{{ number_format($order->total, 2) }} ₪</strong></td>
                <td>
                    <div class="d-flex align-items-center justify-content-center gap-1">
                        <i
                            class="la {{ match ($order->status) {
                                'pending' => 'la-clock text-warning',
                                'processing' => 'la-cogs text-primary',
                                'completed' => 'la-check-circle text-success',
                                'cancelled' => 'la-times-circle text-danger',
                                default => 'la-question-circle text-muted',
                            } }}"></i>

                        <select class="form-control form-control-sm order-status" data-id="{{ $order->id }}">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                {{ __('قيد المعالجة') }}
                            </option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                {{ __('قيد التنفيذ') }}
                            </option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                {{ __('مكتمل') }}
                            </option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                {{ __('ملغي') }}</option>
                        </select>
                    </div>
                </td>
                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                <td class="text-nowrap">
                    <a target="_blank" href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-info mb-1">
                        <i class="ft-eye"></i> {{ __('عرض') }}
                    </a>
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger mb-1"
                            onclick="return confirm('{{ __('هل أنت متأكد من الحذف؟') }}');">
                            <i class="ft-trash"></i> {{ __('حذف') }}
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">{{ __('لا توجد طلبات') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $orders->links() }}
</div>
