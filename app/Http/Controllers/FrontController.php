<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Service;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->take(8)->get();
        $bestProduct = Product::Active()->Featured()->take(9)->get();
        $categories = Category::get();
        $featchersCategories = Category::Featcher()->get();
        $sliders = Slider::active()->ordered()->get();
        $features = Service::ordered()->get();
        return view('layouts.frontend', [
            'products' => $products,
            'categories' => $categories,
            'sliders' => $sliders,
            'features' => $features,
            'featchersCategories' => $featchersCategories,
            'bestProduct' => $bestProduct

        ]);
    }
    public function dashboard(){
        dd('login');
    }
    public function modal($id)
    {
        $product = Product::findOrFail($id);

        return view('frontend.product_model', compact('product'));
    }
    public function addWishlist(Request $request)
    {
        $user = Auth::guard('client')->user();
        $productId = $request->product_id;

        // تحقق إن المنتج موجود مسبقاً في المفضلة
        $exists = $user->wishlist()->where('product_id', $productId)->exists();

        if ($exists) {
        $user->wishlist()->detach($productId);
            return response()->json([
                'success' => false,
                'message' =>__('تم حذف المنتج من المفضلة .')
            ]);
        }

        // أضف المنتج إلى المفضلة (افترض أن لديك علاقة wishlist)
        $user->wishlist()->attach($productId);

        return response()->json([
            'success' => true,
                'message' =>__('تم إضافة المنتج إلى المفضلة .')
        ]);
    }
    public function ajaxRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|digits:10',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $existing = Client::where('phone_number', $request->phone_number)->first();

        if ($existing) {
            if (empty($existing->otp)) { // otp فارغ → تم التحقق
                return response()->json([
                    'success' => false,
                    'errors' => ['phone_number' => [__('رقم الهاتف مستخدم بالفعل.')]],
                ]);
            } else {
                // العميل موجود لكن لم يتم التحقق من الـ OTP بعد
                $otp = rand(100000, 999999);
                $existing->update([
                    'otp' => $otp,
                    'name' => $request->name,
                    'password' => bcrypt($request->password),
                ]);

                session(['pending_client_id' => $existing->id]);

                // إرسال OTP (اختياري)

                return response()->json([
                    'success' => true,
                    'message' => __('تم إرسال رمز التحقق مجددًا.'),
                    'show_otp' => true,
                ]);
            }
        }


        // إنشاء جديد
        $otp = rand(100000, 999999);
        $client = Client::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'country_code' => $request->country_code,
            'password' => bcrypt($request->password),
            'otp' => $otp,
        ]);

        session(['pending_client_id' => $client->id]);

        return response()->json([
            'success' => true,
            'message' => __('تم إرسال رمز التحقق.'),
            'show_otp' => true,
        ]);
    }
    public function resendOtp(Request $request)
    {
        $clientId = session('pending_client_id');
        $client = Client::find($clientId);

        if (!$client || $client->is_verified) {
            return response()->json([
                'success' => false,
                'message' => __('لا يمكن إعادة إرسال الرمز.'),
            ], 404);
        }

        $otp = rand(100000, 999999);
        $client->update(['otp' => $otp]);

        // إرسال SMS إن أردت

        return response()->json([
            'success' => true,
            'message' => __('تم إعادة إرسال رمز التحقق.'),
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string|max:6',
        ]);

        $clientId = session('pending_client_id');

        if (!$clientId) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على بيانات التسجيل.',
            ], 419);
        }

        $client = Client::find($clientId);

        if (!$client || $client->otp !== $request->otp_code) {
            return response()->json([
                'success' => false,
                'message' => 'رمز التحقق غير صحيح.',
            ], 401);
        }

        // إزالة الـ OTP
        $client->otp = null;
        $client->save();

        // تسجيل دخول العميل
        auth('client')->login($client);

        session()->forget('pending_client_id');

        return response()->json([
            'success' => true,
            'redirect_to' => route('client.dashboard'),
        ]);
    }
    public function ajaxLogin(Request $request)
{
    $request->validate([
        'login' => 'required|digits:10',
        'password' => 'required|string',
    ]);

    $client = Client::where('phone_number', $request->login)->first();

    if (!$client) {
        return response()->json([
            'success' => false,
            'message' => __('رقم الهاتف غير مسجل.'),
        ]);
    }

    // التصحيح هنا: تغيير ترتيب البارامترات
    if (!Hash::check($request->password, $client->password)) {
        return response()->json([
            'success' => false,
            'message' => __('كلمة المرور غير صحيحة.'),
        ]);
    }

    if (!empty($client->otp)) {
        session(['pending_client_id' => $client->id]);
        return response()->json([
            'success' => false,
            'requires_otp' => true,
            'message' => __('حسابك غير مفعل، يرجى إدخال رمز التحقق.'),
        ]);
    }

    Auth::guard('client')->login($client);

    return response()->json([
        'success' => true,
        'message' => __('تم تسجيل الدخول بنجاح.'),
        'redirect_to' => route('client.dashboard'),
    ]);
}









    public function test_vue()
    {
        return Inertia::render('Home');
    }

    public function shop()
    {
        return Inertia::render('Shop');
    }

    public function contact()
    {
        return Inertia::render('Contact');
    }
}
