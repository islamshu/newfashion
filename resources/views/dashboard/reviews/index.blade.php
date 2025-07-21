@extends('layouts.master')
@section('title', __('قائمة التقييمات'))

@section('style')
    {{-- استخدم نفس التنسيقات من صفحة التصنيفات --}}
    @parent
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('قائمة التقييمات') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('التقييمات') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('جميع التقييمات') }}</h4>
                        <a href="{{ route('reviews.create') }}" class="btn btn-primary btn-sm float-right">
                            <i class="ft-plus"></i> {{ __('إضافة جديد') }}
                        </a>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <!-- صندوق الفلتر -->

                            <!-- عرض الرسائل -->
                            @include('dashboard.inc.alerts')

                            <!-- جدول التقييمات -->
                            <table class="table table-bordered table-striped align-middle text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('الصورة') }}</th>
                                        <th>{{ __('الاسم') }}</th>
                                        <th>{{ __('الوظيفة') }}</th>
                                        <th>{{ __('عدد النجوم') }}</th>
                                        <th>{{ __('الاجراءات') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reviews as $review)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($review->image)
                                                    <img src="{{ asset('storage/' . $review->image) }}" width="60"
                                                        height="60" class="rounded-circle" alt="image">
                                                @else
                                                    <span class="text-muted">{{ __('لا يوجد') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $review->name }}</td>
                                            <td>{{ $review->getTranslation('job', app()->getLocale()) }}</td>
                                            <td>
                                                {{ $review->stars }}
                                            </td>
                                            <td>
                                                <a href="{{ route('reviews.edit', $review->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fa fa-edit"></i> {{ __('تعديل') }}
                                                </a>
                                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('{{ __('هل أنت متأكد؟') }}')"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i> {{ __('حذف') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">{{ __('لا توجد تقييمات حتى الآن.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
