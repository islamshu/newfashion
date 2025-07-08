<table class="table table-bordered" id="storestable">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('الصورة') }}</th>
            <th>{{ __('الاسم') }}</th>
            <th>{{ __('الحالة') }}</th>
            <th>{{ __('جعله مميز ؟') }}</th>
            <th>{{ __('عرض الفرعية') }}</th> <!-- عمود جديد لزر العرض -->
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
                    @if ($category->children->count() > 0)
                        <button class="btn btn-sm btn-info toggle-children" data-id="{{ $category->id }}">
                            {{ __('عرض الفرعية') }}
                        </button>
                    @else
                        {{ __('لا يوجد فرعية') }}
                    @endif
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
            {{-- صف خاص بالفرعية مخفي افتراضياً --}}
            <tr class="children-row-{{ $category->id }}"
                style="display: {{ isset($isSearch) && $isSearch && $category->children->isNotEmpty() ? 'table-row' : 'none' }}; background:#f7f7f7;">
                <td colspan="7">
                    <ul class="list-unstyled mb-0">
                        @foreach ($category->children as $child)
                            <li class="d-flex align-items-center justify-content-between border-bottom py-2 px-2">
                                <div>
                                    <strong>{{ $child->getTranslation('name', app()->getLocale()) }}</strong>
                                    @if ($child->status)
                                        <span class="badge badge-success">{{ __('نشط') }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ __('غير نشط') }}</span>
                                    @endif
                                </div>

                                <div class="btn-group">
                                    <a href="{{ route('categories.edit', $child->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="ft-edit"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $child->id) }}" method="POST"
                                        style="display:inline-block; margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('{{ __('هل أنت متأكد من الحذف؟') }}')"
                                            class="btn btn-sm btn-danger">
                                            <i class="ft-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="8" class="text-center">{{ __('لا توجد بيانات') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('.toggle-children').on('click', function() {
            let id = $(this).data('id');
            $('.children-row-' + id).toggle();
        });
    });
      $("#storestable").on("change", ".js-switch", function() {
            let is_featured = $(this).prop('checked') === true ? 1 : 0;
            let category_id = $(this).data('id');

            // تحقق من عدد العناصر المفعل بها is_featured
            let featuredCount = $(".js-switch:checked").length;

            // إذا كان عددهم >= 3 وأنت تحاول تفعيل رابع
            if (is_featured && featuredCount > 3) {
                $(this).prop("checked", false); // رجع التشيك
                toastr.error("لا يمكنك اختيار أكثر من 3 تصنيفات كمميزة");
                return;
            }

            // استمر في الإرسال للسيرفر
            $.ajax({
                type: "get",
                dataType: "json",
                url: '{{ route('update_status_category') }}',
                data: {
                    'is_featcher': is_featured,
                    'category_id': category_id
                },
                success: function(data) {
                    toastr.success("تم تعديل الحالة بنجاح");
                }
            });
        });
        
</script>
