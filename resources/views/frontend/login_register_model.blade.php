<style>
    .toggle-password {
        cursor: pointer;
        position: absolute;
        left: 10px;
        top: 43%;
        transform: translateY(-50%);
        direction: ltr;
    }

    /* إخفاء عداد الأحرف في حقول الإدخال */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    /* إخفاء العداد في حقول الـ input */
    input[type="tel"]::-webkit-credentials-auto-fill-button,
    input[type="tel"]::-webkit-contacts-auto-fill-button,
    input[type="tel"]::-webkit-strong-password-auto-fill-button {
        visibility: hidden;
        display: none !important;
        pointer-events: none;
        position: absolute;
        right: 0;
    }

    .nice-select.with-flags .option::before,
    .nice-select.with-flags .current::before {
        content: '';
        display: inline-block;
        width: 20px;
        height: 15px;
        margin-right: 8px;
        vertical-align: middle;
        background-size: cover;
        background-repeat: no-repeat;
    }


    /* تحسين مظهر الـ select */
    .nice-select {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px 15px;
        height: 50px;
        background-color: white;
        width: 120px;
    }

    /* ستايل موحد لمجموعة مقدمة الدولة ورقم الهاتف */
    .phone-input-group {
        display: flex;
        gap: 10px;
        align-items: center;
        width: 100%;
    }

    .phone-input-group .form-control {
        flex: 1;
        height: 50px;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 0 15px;
    }

    /* توحيد ستايل جميع حقول الإدخال */
    .form-inner input,
    .form-inner select,
    .phone-input-group input,
    .phone-input-group select {
        height: 50px;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 0 15px;
        width: 100%;
        transition: all 0.3s ease;
    }

    .form-inner input:focus,
    .form-inner select:focus,
    .phone-input-group input:focus,
    .phone-input-group select:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
        outline: none;
    }
</style>

<div class="modal login-modal fade" id="user-login" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login"
                            type="button" role="tab" aria-controls="login" aria-selected="true">
                            {{ __('تسجيل الدخول') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register"
                            type="button" role="tab" aria-controls="register" aria-selected="false">
                            {{ __('التسجيل') }}
                        </button>
                    </li>
                </ul>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="myTabContent">

                    {{-- نموذج تسجيل الدخول --}}
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <div class="login-registration-form">
                            <div class="form-title">
                                <h3>{{ __('تسجيل الدخول') }}</h3>
                            </div>
                            <form id="login-form" method="POST" action="{{ route('login.ajax') }}">
                                @csrf

                                <div class="form-inner mb-25">
                                    <div class="phone-input-group">
                                        <input type="tel" style="direction: rtl" name="login"
                                            placeholder="{{ __('رقم الهاتف') }} *" value="{{ old('login') }}" required
                                            class="form-control" pattern="[0-9]*" inputmode="numeric" maxlength="10"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    </div>
                                    @error('login')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-inner position-relative mb-25">
                                    <input id="login_password" type="password" name="password"
                                        placeholder="{{ __('كلمة المرور') }} *" required>
                                    <i class="bi bi-eye-slash toggle-password" data-target="login_password"></i>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div
                                    class="form-remember-forget d-flex justify-content-between align-items-center mt-3 mb-3">
                                    <div class="remember">
                                        <input type="checkbox" class="custom-check-box" id="remember" name="remember">
                                        <label for="remember">{{ __('تذكرني') }}</label>
                                    </div>
                                    <a href=""
                                        class="forget-pass hover-underline">{{ __('نسيت كلمة المرور؟') }}</a>
                                </div>

                                <button type="submit"
                                    class="primary-btn1 hover-btn3 w-100">{{ __('تسجيل الدخول') }}</button>

                                <p class="member mt-3">{{ __('ليس لديك حساب؟') }}
                                    <a href="#" data-bs-toggle="tab" data-bs-target="#register" role="tab"
                                        aria-controls="register" aria-selected="false">{{ __('إنشاء حساب') }}</a>
                                </p>
                            </form>

                        </div>
                        <div id="otp-section-login" style="display: none;">
                            <div class="form-title">
                                <h3>{{ __('أدخل رمز التحقق') }}</h3>
                            </div>
                            <form id="otp-form-login">
                                @csrf
                                <div class="form-inner mb-25">
                                    <input type="text" name="otp_code" placeholder="{{ __('رمز التحقق') }} *"
                                        required maxlength="6">
                                </div>
                                <button type="submit" class="primary-btn1 w-100">{{ __('تحقق') }}</button>
                            </form>
                            <button type="button" id="resend-otp-btn" style="display: none;">
                                🔁 {{ __('إعادة إرسال الرمز') }}
                            </button>
                        </div>

                    </div>

                    {{-- نموذج التسجيل --}}
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <div class="login-registration-form">
                            <div class="form-title">
                                <h3>{{ __('التسجيل') }}</h3>
                            </div>
                            <form id="register-form" method="POST" action="{{ route('register.ajax') }}">
                                @csrf

                                <div class="form-inner mb-25">
                                    <input type="text" name="name" placeholder="{{ __('اسم المستخدم') }} *"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-inner mb-25">
                                    <div class="phone-input-group">
                                        <input type="tel" style="direction: rtl" name="phone_number"
                                            placeholder="{{ __('رقم الهاتف') }} *" value="{{ old('phone_number') }}"
                                            required class="form-control" pattern="[0-9]*" inputmode="numeric"
                                            maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">


                                    </div>
                                    @error('phone_number')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-inner mb-25 position-relative">
                                    <input id="register_password" type="password" name="password"
                                        placeholder="{{ __('كلمة المرور') }} *" required>
                                    <i class="bi bi-eye-slash toggle-password" data-target="register_password"></i>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-inner mb-35 position-relative">
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                        placeholder="{{ __('تأكيد كلمة المرور') }} *" required>
                                    <i class="bi bi-eye-slash toggle-password"
                                        data-target="password_confirmation"></i>
                                </div>

                                <button type="submit"
                                    class="primary-btn1 hover-btn3 w-100">{{ __('التسجيل') }}</button>
                            </form>
                        </div>
                        <div id="otp-section-register" style="display: none;">
                            <div class="form-title">
                                <h3>{{ __('أدخل رمز التحقق') }}</h3>
                            </div>
                            <form id="otp-form-register">
                                @csrf
                                <div class="form-inner mb-25">
                                    <input type="text" name="otp_code" placeholder="{{ __('رمز التحقق') }} *"
                                        required maxlength="6">
                                </div>
                                <button type="submit" class="primary-btn1 w-100">{{ __('تحقق') }}</button>
                            </form>
                            <button type="button" id="resend-otp-btn" style="display: none;">
                                🔁 {{ __('إعادة إرسال الرمز') }}
                            </button>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    /* إضافة ستايل لأيقونات الأعلام */
    .flag-icon {
        margin-right: 8px;
        vertical-align: middle;
        width: 20px;
        height: 15px;
        border-radius: 2px;
    }

    /* تعديل مظهر الـ select ليعرض الأيقونات */
    .nice-select {
        padding-left: 35px;
        position: relative;
    }

    .nice-select option {
        padding-left: 35px;
    }

    /* تعديلات إضافية لتحسين المظهر */
    .phone-input-group select {
        background-repeat: no-repeat;
        background-position: 10px center;
        background-size: 20px 15px;
    }

    /* لكل دولة خلفية مختلفة */
    .phone-input-group select option[value="+970"] {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 480"><rect width="640" height="160" y="0" fill="#000"/><rect width="640" height="160" y="160" fill="#fff"/><rect width="640" height="160" y="320" fill="#009639"/><path fill="#ce1126" d="M0 0h250v480H0z"/></svg>');
    }

    .phone-input-group select option[value="+972"] {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 480"><path fill="#fff" d="M0 0h640v480H0z"/><path fill="#0038b8" d="M0 0h640v144H0zm0 336h640v144H0z"/></svg>');
    }
</style>

<!-- تأكد من تضمين مكتبة flag-icon-css -->
