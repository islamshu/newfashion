@extends('layouts.master')
@section('title', __('قائمة المنتجات'))
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('قائمة المنتجات') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('المنتجات') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('جميع المنتجات') }}</h4>
                        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm float-right"><i
                                class="ft-plus"></i> {{ __('إضافة جديد') }}</a>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body table-responsive">
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
                                    @foreach ($products as $product)
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
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="btn btn-sm btn-warning"><i class="ft-edit"></i></a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                    style="display:inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('هل أنت متأكد من الحذف؟')"
                                                        class="btn btn-sm btn-danger"><i class="ft-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
