@if ($paginator->hasPages())
    <ul class="pagination justify-content-center">
        {{-- زر السابق --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link"><i class="la la-angle-double-right"></i></span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="#" data-page="{{ $paginator->currentPage() - 1 }}">
                    <i class="la la-angle-double-right"></i>
                </a>
            </li>
        @endif

        {{-- أرقام الصفحات --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="{{ $page }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- زر التالي --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="#" data-page="{{ $paginator->currentPage() + 1 }}">
                    <i class="la la-angle-double-left"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link"><i class="la la-angle-double-left"></i></span>
            </li>
        @endif
    </ul>
@endif