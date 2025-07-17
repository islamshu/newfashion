<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('الصورة') }}</th>
            <th>{{ __('الاسم') }}</th>
            <th>{{ __('السعر') }}</th>
            <th>{{ __('التصنيف') }}</th>
            <th>{{ __('الحالة') }}</th>
            <th>{{ __('مميز؟') }}</th>
            <th>{{ __('خيارات') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><img src="{{ asset('storage/' . $product->image) }}" width="60"></td>
                <td>{{ $product->getTranslation('name', app()->getLocale()) }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>
                    @if ($product->status)
                        <span class="badge badge-success">{{ __('نشط') }}</span>
                    @else
                        <span class="badge badge-danger">{{ __('غير نشط') }}</span>
                    @endif
                </td>
                <td>
                    @if ($product->is_featured)
                        <span class="badge badge-success">{{ __('مميز') }}</span>
                    @else
                        <span class="badge badge-danger">{{ __('غير مميز') }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info"><i class="ft-eye"></i></a>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning"><i class="ft-edit"></i></a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('هل أنت متأكد من الحذف؟')" class="btn btn-sm btn-danger"><i class="ft-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center">{{ __('لا توجد بيانات') }}</td></tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
    {!! $products->links() !!}
</div>
