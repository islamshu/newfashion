@extends('layouts.frontend')
@section('title', __('الملف الشخصي'))
@section('content')

<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --text-color: #2b2d42;
        --light-bg: #f8f9fa;
        --card-shadow: 0 10px 30px -15px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    
    .profile-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }
    
    .profile-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transform: translateY(0);
        transition: var(--transition);
        animation: fadeInUp 0.6s ease-out;
    }
    
    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px -15px rgba(0, 0, 0, 0.15);
    }
    
    .profile-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .profile-header::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: -50px;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .profile-header::before {
        content: '';
        position: absolute;
        top: -30px;
        right: -30px;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }
    
    .profile-title {
        font-size: 1.8rem;
        margin: 0;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .profile-body {
        padding: 2rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
        animation: fadeIn 0.5s ease-out;
        animation-fill-mode: both;
    }
    
    .form-group:nth-child(1) { animation-delay: 0.2s; }
    .form-group:nth-child(2) { animation-delay: 0.3s; }
    .form-group:nth-child(3) { animation-delay: 0.4s; }
    .form-group:nth-child(4) { animation-delay: 0.5s; }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-color);
        transition: var(--transition);
    }
    
    .form-input {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 1rem;
        transition: var(--transition);
        background-color: #f8f9fa;
    }
    
    .form-input:focus {
        border-color: var(--primary-color);
        background-color: white;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        outline: none;
    }
    
    .form-divider {
        border: none;
        height: 1px;
        background: linear-gradient(to right, transparent, #e9ecef, transparent);
        margin: 2rem 0;
        position: relative;
    }
    
    .form-divider::after {
        content: attr(data-text);
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 0 1rem;
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .submit-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        padding: 1rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        width: 100%;
        transition: var(--transition);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .submit-btn::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        opacity: 0;
        transition: var(--transition);
    }
    
    .submit-btn:hover::after {
        opacity: 1;
    }
    
    .submit-btn span {
        position: relative;
        z-index: 1;
    }
    
    .submit-btn i {
        margin-left: 0.5rem;
        transition: var(--transition);
    }
    
    .submit-btn:hover i {
        transform: translateX(5px);
    }
    
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        position: relative;
        animation: slideIn 0.5s ease-out;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .alert-close {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.2rem;
        color: inherit;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    /* Breadcrumb styles */
    .breadcrumb-container {
        background-color: var(--light-bg);
        padding: 1rem 0;
        margin-bottom: 2rem;
    }
    
    .breadcrumb-nav {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .breadcrumb-list {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .breadcrumb-item {
        margin-right: 0.5rem;
        font-size: 0.9rem;
    }
    
    .breadcrumb-item:not(:last-child)::after {
        content: '/';
        margin-left: 0.5rem;
        color: #6c757d;
    }
    
    .breadcrumb-link {
        color: var(--primary-color);
        text-decoration: none;
        transition: var(--transition);
    }
    
    .breadcrumb-link:hover {
        color: var(--secondary-color);
        text-decoration: underline;
    }
    
    .breadcrumb-active {
        color: #6c757d;
    }
</style>

<div class="breadcrumb-container">
    <nav class="breadcrumb-nav">
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="/" class="breadcrumb-link">{{ __('الرئيسية') }}</a>
            </li>
            <li class="breadcrumb-item breadcrumb-active">{{ __('الملف الشخصي') }}</li>
        </ul>
    </nav>
</div>

<div class="profile-container">
    <div class="profile-card">
        <div class="profile-header">
            <h1 class="profile-title">{{ __('الملف الشخصي') }}</h1>
        </div>
        
        <div class="profile-body">
            @if(session('success'))
                <div class="alert alert-success">
                    <button class="alert-close">&times;</button>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <button class="alert-close">&times;</button>
                    <ul style="margin: 0; padding-left: 1.2rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="" method="POST" id="profileForm">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name" class="form-label">{{ __('الاسم') }}</label>
                    <input type="text" id="name" name="name" class="form-input" 
                        value="{{ old('name', auth()->user()->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">{{ __('رقم الهاتف') }}</label>
                    <input type="text" id="phone" name="phone" class="form-input" 
                        value="{{ old('phone', auth()->user()->phone_number ?? '') }}">
                </div>

                <hr class="form-divider" data-text="{{ __('تغيير كلمة المرور') }}">

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('كلمة المرور الجديدة') }}</label>
                    <input type="password" id="password" name="password" class="form-input" autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">{{ __('تأكيد كلمة المرور الجديدة') }}</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" autocomplete="new-password">
                </div>

                <button type="submit" class="submit-btn">
                    <span>{{ __('تحديث البيانات') }}</span>
                    <i class="fas fa-arrow-left"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Close alert buttons
        document.querySelectorAll('.alert-close').forEach(button => {
            button.addEventListener('click', function() {
                this.parentElement.style.opacity = '0';
                setTimeout(() => {
                    this.parentElement.remove();
                }, 300);
            });
        });
        
        // Form submission animation
        const form = document.getElementById('profileForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('.submit-btn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `<span>${submitBtn.querySelector('span').textContent}</span> <i class="fas fa-spinner fa-spin"></i>`;
                }
            });
        }
    });
</script>

@endsection