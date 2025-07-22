@extends('layouts.master')
@section('title', __('الصفحات'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('الصفحات') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('الصفحات') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <div class="card">


                    <div class="card-body">
                        @include('dashboard.inc.alerts')

                        <div id="banners-container">
                            <table class="table" id="storestable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('العنوان') }}</th>
                                        <th>{{ __('إجراءات') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach ($pages as $page)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $page->title }}</td>
                                            <td> <a href="{{ route('pages.edit', $page->id) }}"
                                                    class="btn btn-sm btn-warning">{{ __('تعديل') }}</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
