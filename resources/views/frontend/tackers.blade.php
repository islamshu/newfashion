<div class="newsletter-section mb-110">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="newsletter-banner hover-img">
                    <div class="newsletter-content">
                        <h2 class="mb-4">{{ __('تتبع حالة الطلب') }}</h2>
                        <form id="orderTrackingForm">
                            <div class="row g-4">
                                <div class="col-md-8" dir="ltr">
                                    <div class="form-inner">
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white">ORD-</span>
                                            <input type="text" name="order_code"
                                                placeholder="{{ __('أدخل رقم الطلب') }}" 
                                                class="form-control border-dark" required>
                                        </div>
                                        <div class="invalid-feedback text-danger mt-1" id="tracking-error"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 d-grid">
                                    <button type="submit" class="btn btn-dark fw-bold">
                                        {{ __('تتبع الطلب') }} <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div> <!-- /newsletter-content -->
                </div> <!-- /newsletter-banner -->
            </div>
        </div>
    </div>
</div>
<style>
    .newsletter-banner{
         position: relative;
            background: url('{{ Storage::url(get_general_value('track_image')) }}') no-repeat center center !important;
            background-size: cover;
            background-attachment: fixed;
            background-color: #f9f9f9;
            z-index: 1;
            padding: 80px 0;
    }
</style>

<script>
document.getElementById('orderTrackingForm').addEventListener('submit', function (e) {
    e.preventDefault(); // منع الإرسال الافتراضي

    const input = this.querySelector('input[name="order_code"]');
    const trackingNumber = input.value.trim();

    if (!trackingNumber) {
        document.getElementById('tracking-error').textContent = '{{ __("يرجى إدخال رقم الطلب") }}';
        return;
    }

    // إعادة التوجيه إلى الرابط المطلوب
    const fullTrackingNumber = `ORD-${trackingNumber}`;
    window.location.href = `{{ url('/track') }}?order_code=${fullTrackingNumber}`;
});
</script>
