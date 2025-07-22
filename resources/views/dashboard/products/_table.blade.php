<table class="table table-bordered" id="storestable">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('الصورة') }}</th>
            <th>{{ __('الاسم') }}</th>
            <th>{{ __('السعر') }}</th>
            <th>{{ __('التصنيف') }}</th>
            <th>{{ __('التقييمات') }}</th>
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
                <td>{{ $product->reviews->count() }} @if($product->reviews->count() > 0 ) <a class="btn btn-info"  href="{{route('product_rating',$product->id)}}">{{__('مشاهدة التقييمات')}}</a>@endif</td>
                <td>
                    <input type="checkbox" data-id="{{ $product->id }}" name="status" class="js-switch status"
                        {{ $product->status == 1 ? 'checked' : '' }}>
                </td>
                <td>
                    <input type="checkbox" data-id="{{ $product->id }}" name="is_featured" class="js-switch featured"
                        {{ $product->is_featured == 1 ? 'checked' : '' }}>
                </td>
                <td>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info"><i
                            class="ft-eye"></i></a>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning"><i
                            class="ft-edit"></i></a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                        style="display:inline-block">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('هل أنت متأكد من الحذف؟')" class="btn btn-sm btn-danger"><i
                                class="ft-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">{{ __('لا توجد بيانات') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
{{ $products->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
</div>
<script>
        $("#storestable").on("change", ".status", function() {
            let status = $(this).prop('checked') === true ? 1 : 0;
            let product_id = $(this).data('id');



            $.ajax({
                type: "get",
                dataType: "json",
                url: '{{ route('update_status_product') }}',
                data: {
                    'status': status,
                    'product_id': product_id
                },
                success: function(data) {
                    toastr.success(data.message);
                }
            });
        });
        $("#storestable").on("change", ".featured", function() {
            let is_featured = $(this).prop('checked') === true ? 1 : 0;
            let product_id = $(this).data('id');



            $.ajax({
                type: "get",
                dataType: "json",
                url: '{{ route('update_featured_product') }}',
                data: {
                    'is_featured': is_featured,
                    'product_id': product_id
                },
                success: function(data) {
                    toastr.success(data.message);
                }
            });
        });
    </script>
