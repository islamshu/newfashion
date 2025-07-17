@extends('layouts.master')
@section('title', __('تعديل العميل'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('تعديل العميل') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('العملاء') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('تعديل العميل') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section id="validation">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('بيانات العميل') }}</h4>
                                </div>

                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @include('dashboard.inc.alerts')

                                        <form action="{{ route('clients.update', $client->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-section mb-4">
                                                <h5 class="form-section-title"><i class="ft-user"></i> {{ __('البيانات الأساسية') }}</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('الاسم') }}</label>
                                                            <input type="text" name="name" value="{{ old('name', $client->name) }}" required class="form-control" placeholder="الاسم الكامل">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('رقم الجوال') }}</label>
                                                            <input type="text" name="phone_number" value="{{ old('phone_number', $client->phone_number) }}" required class="form-control" placeholder="05xxxxxxxx">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-section mb-4">
                                                <h5 class="form-section-title"><i class="ft-lock"></i> {{ __('كلمة المرور') }}</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('كلمة مرور جديدة (اختياري)') }}</label>
                                                            <input type="password" name="password" class="form-control" placeholder="اتركه فارغاً إن لم ترغب بالتغيير">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions text-center mt-3">
                                                <button type="submit" class="btn btn-primary btn-lg">
                                                    <i class="la la-check-square-o"></i> {{ __('حفظ التغييرات') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
