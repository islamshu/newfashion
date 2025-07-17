@extends('layouts.master')
@section('title', __('تفاصيل استخدام الكود: ') . $coupon->code)

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row mb-2">
            <div class="col-12">
                <h3 class="content-header-title">{{ __('تفاصيل استخدام الكود: ') }} <span class="text-primary">{{ $coupon->code }}</span></h3>
            </div>
        </div>

        <div class="content-body">
            <section class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('سجل الاستخدامات') }}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('اسم العميل') }}</th>
                                 <th>{{ __('رقم الطلب') }}</th>
                                <th>{{__('كود الكوبون')}}</th>
                                <th>{{__('قيمة الخصم')}}</th>
                                <th>{{ __('تاريخ الاستخدام') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($usages as $index => $usage)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><a target="_blank" href="{{route('clients.show',$usage->client->id)}}">{{ $usage->client->name }}</a></td>
                                    <td><a target="_blank" href="{{route('orders.show',$usage->order->id)}}">#{{ $usage->order->code }}</a></td>
                                    <td>{{$usage->coupon_code}}</td>
                                    <td>{{$usage->discount}}</td>
                                    <td>{{ $usage->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">{{ __('لا يوجد استخدامات حتى الآن.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $usages->links() }}
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
