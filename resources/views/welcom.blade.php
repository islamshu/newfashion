<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قريباً - موقعنا قيد الإنشاء</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', sans-serif;
        }
        
        body {
            height: 100vh;
            overflow: hidden;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }
        
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }
        
        .content {
            position: relative;
            z-index: 2;
            padding: 2rem;
            max-width: 800px;
        }
        
        h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        p {
            font-size: 1.5rem;
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }
        
        .countdown {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .countdown-item {
            background: rgba(255, 255, 255, 0.2);
            padding: 1rem;
            border-radius: 10px;
            min-width: 100px;
            backdrop-filter: blur(5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .countdown-number {
            font-size: 2.5rem;
            font-weight: bold;
        }
        
        .countdown-label {
            font-size: 1rem;
        }
        
        .btn {
            display: inline-block;
            background: white;
            color: #333;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 7px 20px rgba(0, 0, 0, 0.3);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .rocket {
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 5rem;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateX(-50%) translateY(0);
            }
            50% {
                transform: translateX(-50%) translateY(-20px);
            }
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }
            
            p {
                font-size: 1.2rem;
            }
            
            .countdown {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="content">
        <h1>نحن قادمون قريباً!</h1>
        <p>نعمل بجد لإطلاق موقعنا الجديد. ابقَ على اتصال!</p>
        
        <div class="countdown">
            <div class="countdown-item">
                <div class="countdown-number" id="days">00</div>
                <div class="countdown-label">أيام</div>
            </div>
            <div class="countdown-item">
                <div class="countdown-number" id="hours">00</div>
                <div class="countdown-label">ساعات</div>
            </div>
            <div class="countdown-item">
                <div class="countdown-number" id="minutes">00</div>
                <div class="countdown-label">دقائق</div>
            </div>
            <div class="countdown-item">
                <div class="countdown-number" id="seconds">00</div>
                <div class="countdown-label">ثواني</div>
            </div>
        </div>
        
        <a href="{{route('dashboard')}}" class="btn">الانتقال إلى لوحة التحكم</a>
        
        <div class="rocket">🚀</div>
    </div>
    
    <script>
        // تاريخ الإطلاق (يمكن تغييره)
        const launchDate = new Date(2025, 6, 25); // 20 يوليو 2025
        
        function updateCountdown() {
            const now = new Date();
            const diff = launchDate - now;
            
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            document.getElementById('days').textContent = days.toString().padStart(2, '0');
            document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
        }
        
        // تحديث العد التنازلي كل ثانية
        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>
</body>
</html>