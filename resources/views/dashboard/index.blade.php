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
                <div class="row match-height">

                    <!-- العملاء -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="la la-user fa-3x text-info mb-1 animate__animated animate__bounceIn"></i>
                                <h5 class="mb-0">{{ $clientsCount }}</h5>
                                <p class="text-muted">{{ __('عدد العملاء') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- الطلبات -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card text-center">
                            <div class="card-body">
                                <i
                                    class="la la-shopping-cart fa-3x text-primary mb-1 animate__animated animate__bounceIn"></i>
                                <h5 class="mb-0">{{ $ordersCount }}</h5>
                                <p class="text-muted">{{ __('عدد الطلبات') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- الطلبات حسب الحالة -->
                    @php
                        $statuses = [
                            'pending' => 'قيد المراجعة',
                            'processing' => 'قيد التنفيذ',
                            'completed' => 'مكتملة',
                            'cancelled' => 'ملغاة',
                        ];

                        $colors = [
                            'pending' => 'warning',
                            'processing' => 'info',
                            'completed' => 'success',
                            'cancelled' => 'danger',
                        ];
                    @endphp

                    @foreach ($statuses as $status => $label)
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i
                                        class="la la-list fa-3x text-{{ $colors[$status] }} mb-1 animate__animated animate__bounceIn"></i>
                                    <h5 class="mb-0">{{ $ordersByStatus[$status] ?? 0 }}</h5>
                                    <p class="text-muted">{{ __($label) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <!-- الرسم البياني وإجمالي الأرباح -->
                <div class="row">
                    <!-- رسم بياني -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('عدد الطلبات خلال هذا الأسبوع') }}</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="weeklyOrdersBarChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- إجمالي الأرباح -->
                    <div class="col-md-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4>{{ __('إجمالي الأرباح') }}</h4>
                                <p>{{ __('هذا الشهر') }}:
                                    <strong>{{ number_format($totalEarningsCurrentMonth, 2) }} ₪</strong>
                                </p>
                                <p>{{ __('الشهر السابق') }}:
                                    <strong>{{ number_format($totalEarningsLastMonth, 2) }} ₪</strong>
                                </p>
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
    <!-- مكتبة الأنيميشن -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('weeklyOrdersBarChart').getContext('2d');
        const weeklyOrdersBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($ordersPerDay->toArray())) !!}, // مثل ['2025-07-18', '2025-07-19', ...]
                datasets: [{
                    label: '{{ __('عدد الطلبات') }}',
                    data: {!! json_encode(array_values($ordersPerDay->toArray())) !!}, // مثل [5, 2, 0, 3, ...]
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'عدد الطلبات: ' + context.parsed.y;
                            }
                        }
                    }
                }
            }
        });
    </script>

@endsection
