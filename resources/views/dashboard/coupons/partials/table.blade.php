<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th>{{ __('الكود') }}</th>
                <th>{{ __('الخصم') }}</th>
                <th>{{ __('الحالة') }}</th>
                <th width="20%">{{ __('الفترة') }}</th>
                <th>{{ __('المستخدم') }}</th>
                <th width="15%">{{ __('الإجراءات') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coupons as $coupon)
                <tr>
                    <td>{{ ($coupons->currentPage() - 1) * $coupons->perPage() + $loop->iteration }}</td>
                    <td>
                        <strong>{{ $coupon->code }}</strong>

                    </td>
                    <td>
                        {{ $coupon->discount_type == 'percentage' ? $coupon->discount_value . '%' : $coupon->discount_value }}
                        @if ($coupon->min_order_amount)
                            <br><small class="text-muted">{{ __('الحد الأدنى') }}:
                                {{ $coupon->min_order_amount }}</small>
                        @endif
                    </td>
                    <td>
                        @if ($coupon->isCurrentlyActive())
                            <span class="badge badge-success">{{ __('نشط') }}</span>
                        @else
                            <span class="badge badge-danger">{{ __('منتهي') }}</span>
                        @endif
                    </td>
                    <td>
                        {{ $coupon->start_date->format('Y-m-d') }}
                        {{ __('إلى') }} {{ $coupon->end_date->format('Y-m-d') }}
                    </td>
                    <td>
                        {{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-sm btn-primary"
                                title="{{ __('تعديل') }}">
                                <i class="la la-edit"></i>
                            </a>
                            <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="{{ __('حذف') }}"
                                    onclick="return confirm('{{ __('هل أنت متأكد من حذف هذا الكوبون؟') }}')">
                                    <i class="la la-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">{{ __('لا توجد كوبونات متاحة') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center mt-3">
    {!! $coupons->links() !!}
</div>

