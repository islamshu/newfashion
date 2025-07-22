@extends('layouts.master')
@section('title', __('تقييمات المنتج'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('تقييمات المنتج') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('المنتجات') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('تقييمات المنتج') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('تقييمات المنتج: ') }} {{ $product->name }}</h4>
                        <div class="heading-elements">
                            <div class="btn-group">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-primary">
                                    <i class="ft-arrow-left"></i> {{ __('عودة للمنتج') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('dashboard.inc.alerts')

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="rating-summary">
                                    <h5>{{ __('ملخص التقييمات') }}</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="average-rating">
                                            <span
                                                class="display-4">{{ number_format($product->averageRating(), 1) }}</span>
                                            <div class="stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($product->averageRating()))
                                                        <i class="fas fa-star text-warning"></i>
                                                    @elseif($i == ceil($product->averageRating()) && $product->averageRating() - floor($product->averageRating()) >= 0.5)
                                                        <i class="fas fa-star-half-alt text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <p>{{ __('بناءً على') }} {{ $product->ratings->count() }} {{ __('تقييم') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="rating-distribution my-4">
                                    <h6 class="font-bold mb-3">توزيع التقييمات</h6>

                                    

                                    <!-- مخطط دائري -->
                                    <div class="my-6">
                                        <canvas id="ratingsChart" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped" id="reviews-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('المستخدم') }}</th>
                                        <th>{{ __('التقييم') }}</th>
                                        <th>{{ __('التعليق') }}</th>
                                        <th>{{ __('التاريخ') }}</th>
                                        <th>{{ __('إجراءات') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product->ratings as $rating)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span>{{ $rating->client->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="stars">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="la la-star{{ $i <= $rating->rating ? '' : '-o' }} text-warning"></i>
                                                    @endfor
                                                </div>
                                            </td>
                                            <td>{{ Str::limit($rating->review, 50) }}</td>
                                            <td>{{ $rating->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" data-toggle="modal"
                                                    data-target="#reviewModal{{ $rating->id }}">
                                                    <i class="ft-eye"></i> {{ __('عرض') }}
                                                </button>
                                                <form action="{{ route('products.ratings.destroy', $rating->id) }}"
                                                    method="POST" style="display:inline;"
                                                    onsubmit="return confirm('{{ __('هل أنت متأكد من حذف هذا التقييم؟') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="ft-trash"></i> {{ __('حذف') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Review Modal -->
                                        <div class="modal fade" id="reviewModal{{ $rating->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="reviewModalLabel">
                                                            {{ __('تفاصيل التقييم') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <h6>{{ __('المستخدم') }}:</h6>
                                                                    <p>{{ $rating->client->name }}</p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <h6>{{ __('التقييم') }}:</h6>
                                                                    <div class="stars">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <i
                                                                                class="la la-star{{ $i <= $rating->rating ? '' : '-o' }} text-warning"></i>
                                                                        @endfor
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <h6>{{ __('التعليق') }}:</h6>
                                                                    <p>{{ $rating->review }}</p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <h6>{{ __('التاريخ') }}:</h6>
                                                                    <p>{{ $rating->created_at->format('Y-m-d H:i') }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ __('إغلاق') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        
       $ratingCounts = [
        $product->ratings->where('rating', 5)->count(),
        $product->ratings->where('rating', 4)->count(),
        $product->ratings->where('rating', 3)->count(),
        $product->ratings->where('rating', 2)->count(),
        $product->ratings->where('rating', 1)->count(),
    ];
    @endphp
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ratingCounts = @json($ratingCounts);

        const ctx = document.getElementById('ratingsChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['5 نجوم', '4 نجوم', '3 نجوم', '2 نجوم', '1 نجمة'],
                datasets: [{
                    data: ratingCounts,
                    backgroundColor: [
                        '#facc15', // 5 نجوم
                        '#fde047', // 4 نجوم
                        '#fef08a', // 3 نجوم
                        '#fef9c3', // 2 نجوم
                        '#fefce8'  // 1 نجمة
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = ratingCounts.reduce((a, b) => a + b, 0);
                                const value = context.raw;
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${value} تقييم (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

@endsection

@section('styles')
    <style>
        .rating-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .average-rating {
            margin: 0 auto;
        }

        .stars {
            font-size: 1.5rem;
            margin: 5px 0;
        }

        .rating-bar .progress {
            background-color: #e9ecef;
        }

        .modal-body h6 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .modal-body p {
            margin-bottom: 15px;
        }
    </style>
@endsection
