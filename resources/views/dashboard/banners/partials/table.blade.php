     <table class="table" id="storestable">
         <thead>
             <tr>
                 <td style="width: 40px;">{{ __('ترتيب العرض') }}</td>
                 <th>#</th>
                 <th>{{ __('الصورة') }}</th>
                 <th>{{ __('العنوان') }}</th>
                 <th>{{ __('الترتيب') }}</th>
                 <th>{{ __('الحالة') }}</th>
                 <th>{{ __('إجراءات') }}</th>
             </tr>
         </thead>
         <tbody id="sortable">
             @forelse ($banners->sortBy('order') as $key => $banner)
                 <tr data-id="{{ $banner->id }}">

                     <td class="drag-handle" style="cursor: move;">&#x2630;</td> <!-- ☰ icon -->
                     <td>{{ $key + 1 }}</td>
                     <td><img src="{{ asset('storage/' . $banner->image) }}" width="80"
                             alt="{{ $banner->getTranslation('title', app()->getLocale()) }}"></td>
                     <td>{{ $banner->getTranslation('title', app()->getLocale()) }}</td>
                     <td>{{ $banner->order }}</td>
                     <td>
                         <input type="checkbox" data-id="{{ $banner->id }}" name="status" class="js-switch allssee"
                             {{ $banner->status == 1 ? 'checked' : '' }}>
                     </td>
                     <td>
                         <a href="{{ route('banners.edit', $banner->id) }}"
                             class="btn btn-sm btn-warning">{{ __('تعديل') }}</a>
                         {{-- <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" class="d-inline">
                             @csrf @method('DELETE')
                             <button onclick="return confirm('{{ __('هل أنت متأكد؟') }}')"
                                 class="btn btn-sm btn-danger">{{ __('حذف') }}</button>
                         </form> --}}
                     </td>
                 </tr>
             @empty
                 <tr>
                     <td colspan="5">{{ __('لا توجد بيانات') }}</td>
                 </tr>
             @endforelse
         </tbody>
     </table>
