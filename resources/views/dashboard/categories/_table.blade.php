<table class="table table-bordered" id="storestable">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('الصورة') }}</th>
            <th>{{ __('الاسم') }}</th>

            <th>{{ __('الحالة') }}</th>
            <td>{{ __('جعله مميز ؟') }}</td>
            <th>{{ __('خيارات') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $category)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><img src="{{ asset('storage/' . $category->image) }}" width="60"></td>
                <td>{{ $category->getTranslation('name', app()->getLocale()) }}</td>
                <td>
                    @if ($category->status)
                        <span class="badge badge-success">{{ __('نشط') }}</span>
                    @else
                        <span class="badge badge-danger">{{ __('غير نشط') }}</span>
                    @endif
                </td>
                <td>
                    <input type="checkbox" data-id="{{ $category->id }}" name="is_featured" class="js-switch allssee"
                        {{ $category->is_featured == 1 ? 'checked' : '' }}>
                </td>


                <td>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning"><i
                            class="ft-edit"></i></a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
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
    {!! $categories->links() !!}
</div>
