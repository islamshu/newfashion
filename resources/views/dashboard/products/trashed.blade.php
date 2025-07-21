@extends('layouts.master')
@section('title', __('المنتجات المحذوفة'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('المنتجات المحذوفة') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('قائمة المنتجات المحذوفة') }}</h4>
                        </div>
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('اسم المنتج') }}</th>
                                        <th>{{ __('الفئة') }}</th>
                                        <th>{{ __('تاريخ الحذف') }}</th>
                                        <th>{{ __('الإجراءات') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                                            </td>
                                            <td>{{ $product->category->name ?? '-' }}</td>
                                            <td>{{ $product->deleted_at->format('Y-m-d') }}</td>
                                            <td>
                                                <form action="{{ route('products.restore', $product->id) }}" method="POST"
                                                    style="display:inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm">استرجاع</button>
                                                </form>
                                                <form action="{{ route('products.forceDelete', $product->id) }}"
                                                    method="POST" style="display:inline"
                                                    onsubmit="return confirm('هل أنت متأكد من الحذف النهائي؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">حذف نهائي</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $products->links() }}

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
