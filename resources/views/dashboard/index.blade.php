@extends('layouts.master')
@section('title', 'الرئيسية')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">

            <div class="content-header row mb-2">
                <div class="col-12">
                    <h3 class="content-header-title">{{ __('لوحة التحكم') }}</h3>
                </div>
            </div>

            <div class="content-body">

                <!-- إحصائيات -->
                <div class="row match-height">

                    <!-- المنتجات -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="la la-cube fa-3x text-primary mb-1 animate__animated animate__bounceIn"></i>
                                <h5 class="mb-0">{{ $productsCount }}</h5>
                                <p class="text-muted">{{ __('عدد المنتجات') }}</p>
                                <div class="progress mt-1">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- التصنيفات -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card text-center">
                            <div class="card-body">
                                <i
                                    class="la la-folder-open fa-3x text-success mb-1 animate__animated animate__bounceIn"></i>
                                <h5 class="mb-0">{{ $categoriesCount }}</h5>
                                <p class="text-muted">{{ __('عدد التصنيفات') }}</p>
                                <div class="progress mt-1">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 55%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- المستخدمين -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="la la-users fa-3x text-danger mb-1 animate__animated animate__bounceIn"></i>
                                <h5 class="mb-0">{{ $usersCount }}</h5>
                                <p class="text-muted">{{ __('عدد المستخدمين') }}</p>
                                <div class="progress mt-1">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 90%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- إشعار ثابت -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <i class="la la-bell fa-2x mb-1"></i>

                                @if ($latestProductToday)
                                    <p>{{ __('تمت إضافة منتج جديد اليوم:') }}</p>
                                    <strong>{{ $latestProductToday->name }}</strong>
                                    <br>
                                    <small>{{ $latestProductToday->created_at->format('H:i') }} -
                                        {{ $latestProductToday->created_at->format('Y-m-d') }}</small>
                                @else
                                    <p>{{ __('لم يتم إضافة أي منتج اليوم.') }}</p>
                                    <small>{{ now()->format('Y-m-d') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <!-- مخطط دائري ثابت -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('نسبة التوزيع') }}</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="pieChart" style="width: 150px; height: 150px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- مكتبة الرسوم البيانية -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- أنميشن -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script>
        const ctx = document.getElementById('pieChart').getContext('2d');
        ctx.canvas.width = 150;
ctx.canvas.height = 150;
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['منتجات', 'تصنيفات', 'مستخدمين'],
                datasets: [{
                    data: [{{ $productsCount }}, {{ $categoriesCount }}, {{ $usersCount }}],
                    backgroundColor: ['#007bff', '#28a745', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection
