@extends('layouts.frontend')
@section('title',__('تواصل معنا'))

@section('content')
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('تواصل معنا') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="contact-page pt-100 mb-100">
        <div class="container">
            <div class="row g-4 mb-100 justify-content-center">
                <div class="col-lg-9">
                    <div class="inquiry-form">
                        <div class="section-title mb-20">
                            <h4>{{ __('تواصل معنا في أي وقت') }}</h4>
                        </div>
                        <form id="contactForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-inner mb-20">
                                        <label>{{ __('الاسم الكامل') }}*</label>
                                        <input type="text" name="name" placeholder="{{ __('مثال: محمد أحمد') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner mb-20">
                                        <label>{{ __('الهاتف') }}*</label>
                                        <input type="text" name="phone" placeholder="{{ __('مثال: +9725XXXXXXXX') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner mb-20">
                                        <label>{{ __('البريد الإلكتروني') }} <span>({{ __('اختياري') }})</span></label>
                                        <input type="email" name="email" placeholder="example@example.com">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-inner mb-20">
                                        <label>{{ __('الموضوع') }}*</label>
                                        <input type="text" name="subject" placeholder="{{ __('موضوع الرسالة') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-inner mb-30">
                                        <label>{{ __('محتوى الرسالة') }}*</label>
                                        <textarea name="message" placeholder="{{ __('اكتب رسالتك هنا...') }}"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <button type="submit" class="primary-btn1 hover-btn3">{{ __('إرسال الآن') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-success mt-3 d-none" id="successMsg">
                                {{ __('تم إرسال الرسالة بنجاح!') }}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    document.getElementById('contactForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const successMsg = document.getElementById('successMsg');

        // إزالة الأخطاء السابقة
        form.querySelectorAll('.text-danger').forEach(el => el.remove());

        submitBtn.disabled = true;
        submitBtn.innerHTML = "{{ __('جاري الإرسال...') }}";

        fetch("{{ route('contact.send') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": '{{ csrf_token() }}',
                "Accept": "application/json"
            },
            body: formData
        })
        .then(async res => {
            const data = await res.json();

            if (!res.ok) {
                if (data.errors) {
                    for (const [field, messages] of Object.entries(data.errors)) {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            const errorEl = document.createElement('div');
                            errorEl.classList.add('text-danger', 'mt-1');
                            errorEl.innerText = messages[0];
                            input.parentElement.appendChild(errorEl);
                        }
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: "{{ __('حدث خطأ غير متوقع') }}",
                        text: "{{ __('يرجى المحاولة لاحقًا.') }}"
                    });
                }
                throw new Error("Validation failed");
            }

            if (data.status === 'success') {
                form.reset();
                successMsg.classList.add('d-none');

                Swal.fire({
                    icon: 'success',
                    title: "{{ __('تم الإرسال بنجاح') }}",
                    text: "{{ __('شكراً لتواصلك معنا، سنرد عليك في أقرب وقت ممكن.') }}",
                    confirmButtonText: "{{ __('حسناً') }}"
                });
            }
        })
        .catch(err => {
            // لا حاجة لفعل شيء هنا لأن SweetAlert تعامل بالفعل مع الخطأ
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = "{{ __('إرسال الآن') }}";
        });
    });
</script>
@endsection

