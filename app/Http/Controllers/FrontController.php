<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Page;
use App\Models\Slider;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductThumbnail;
use App\Models\ProductVariation;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Service;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class FrontController extends Controller
{
    public function index()
    {
       
        $products = Product::with('category')->take(8)->get();
        $bestProduct = Product::Active()->Featured()->take(9)->get();
        $featchersCategories = Category::Featcher()->get();
        $sliders = Slider::active()->ordered()->get();
        $features = Service::ordered()->get();
        $baneers = Banner::active()->ordered()->get();
        $reviews = Review::orderby('id', 'desc')->get();
        return view('frontend.index', [
            'products' => $products,
            'sliders' => $sliders,
            'features' => $features,
            'featchersCategories' => $featchersCategories,
            'bestProduct' => $bestProduct,
            'banners' => $baneers,
            'reviews' => $reviews

        ]);
    }
    // OrderController.php
    public function fetchOrders(Request $request)
    {
        $user = auth('client')->user();
        $limit = intval($request->input('limit', 5));
        $page = intval($request->input('page', 1));

        $orders = $user->orders()
            ->orderBy('created_at', 'desc')
            ->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'orders' => $orders->items(),
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'total' => $orders->total(),
                'per_page' => $orders->perPage()
            ]
        ]);
    }
    public function LoginRegister()
    {
        return view('frontend.login_register');
    }

    public function order($code)
    {

        if ($code) {
            $order = Order::with('items.product')->where('code', $code)->first();
        } else {
            abort(404);
        }

        return view('frontend.order', compact('order'));
    }


    public function get_track()
    {
        return view('frontend.track_order');
    }

    public function quickSearch(Request $request)
    {
        $locale = app()->getLocale();

        $products = Product::with('images')
            ->active()
            ->when($request->filled('name'), function ($query) use ($request, $locale) {
                $locale = app()->getLocale();

                $query->where("name->{$locale}", 'like', '%' . $request->name . '%');
            })
            ->limit(10)
            ->get();

        // إعادة تنسيق البيانات
        $results = $products->map(function ($product) use ($locale) {
            $imagePath = $product->images->first()?->image; // مثلاً: products/image.jpg
            return [
                'id' => $product->id,
                'slug' => $product->slug ?? $product->id, // تأكد من وجود slug
                'name' => $product->getTranslation('name', $locale),
                'price' => $product->price,
                'image' => $imagePath ? Storage::url($imagePath) : asset('placeholder.jpg'),
            ];
        });

        return response()->json($results);
    }

    public function about()
    {
        return view('frontend.about');
    }


    public function dashboard()
    {
        $user = auth('client')->user();

        return view('frontend.profile')->with('user', $user);
    }
    public function updateProfile(Request $request)
    {
        $user = $user = auth('client')->user();;

        $rules = [
            'name' => 'required|string|max:255',
        ];

        if ($request->phone !== $user->phone_number) {
            $rules['phone'] = 'required|string|max:20|unique:clients,phone_number';
        }

        if ($request->filled('password')) {
            $rules['password'] = [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ];
        }

        $validator = Validator::make($request->all(), $rules, [
            'name.required' => 'حقل الاسم مطلوب',
            'phone.required' => 'حقل رقم الهاتف مطلوب',
            'phone.unique' => 'هذا الرقم مستخدم بالفعل',
            'password.required' => 'حقل كلمة المرور مطلوب عند التغيير',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // إذا تغير رقم الهاتف، نرسل OTP ونخزن في قاعدة البيانات
        if ($request->phone !== $user->phone_number) {
            $otp = rand(100000, 999999);

            // تخزين الرقم الجديد مؤقتاً في حقل منفصل مثلا phone_new أو في حقل مخصص (إذا موجود)
            // أو ممكن تضيف حقل جديد مثل phone_new في جدول المستخدمين

            // هنا نفترض أنك أضفت حقل phone_new لتخزين الرقم الجديد مؤقتًا
            $user->phone_new = $request->phone;
            $user->otp = $otp;
            $user->save();

            // إرسال رمز التحقق عبر SMS (استبدل هذا السطر بخدمة إرسال SMS فعلية)
            \Log::info("OTP to send: $otp for phone: " . $request->phone);

            return response()->json([
                'status' => 'otp_sent',
                'message' => 'تم إرسال رمز التحقق إلى رقم الهاتف الجديد. يرجى إدخاله لتأكيد التغيير.'
            ]);
        }

        // إذا الرقم لم يتغير يحدث البيانات مباشرةً
        $user->update([
            'name' => $request->name,
            'phone_number' => $user->phone_number,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث الملف الشخصي بنجاح',
            'user_email' => $user->email
        ]);
    }


    public function verifyPhoneOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = $user = auth('client')->user();;

        if (!$user->otp || !$user->phone_new) {
            return response()->json([
                'status' => 'error',
                'message' => 'لم يتم إرسال رمز تحقق أو انتهت صلاحيته، الرجاء المحاولة مجدداً.'
            ], 422);
        }

        if ($request->otp != $user->otp) {
            return response()->json([
                'status' => 'error',
                'message' => 'رمز التحقق غير صحيح.'
            ], 422);
        }

        // رمز التحقق صحيح، حدث رقم الهاتف وامسح OTP والرقم المؤقت
        $user->phone_number = $user->phone_new;
        $user->phone_new = null;
        $user->otp = null;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'تم تأكيد رقم الهاتف وتحديثه بنجاح.'
        ]);
    }
    public function reviewstore(Request $request){
          $request->validate([
        'product_id' => 'required|exists:products,id',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:1000',
    ]);

    Rating::create([
        'client_id' => auth('client')->id(),
        'product_id' => $request->product_id,
        'rating' => $request->rating,
        'review' => $request->comment,
    ]);

    return response()->json(['success' => true]);
    }

    public function contactUs()
    {
        return view('frontend.contactUs');
    }
    public function sendContactUs(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($data);

        return response()->json(['status' => 'success']);
    }
    public function page($slug){
        return view('frontend.page')->with('page',Page::where('slug',$slug)->first());
    }
    public function getSizes(Request $request)
    {
        $query = ProductVariation::where('product_id', $request->product_id);

        if ($request->has('color_id')) {
            $query->where('color_id', $request->color_id);
        }

        $sizes = $query->whereNotNull('size_id')
            ->with('sizeAttribute')
            ->get()
            ->unique('size_id')
            ->map(function ($variation) {
                return [
                    'id' => $variation->size_id,
                    'value' => $variation->sizeAttribute->value ?? 'بدون اسم'
                ];
            });

        return response()->json($sizes);
    }


    public function getStock(Request $request)
    {
        $query = ProductVariation::where('product_id', $request->product_id);

        $query->when($request->filled('color_id'), fn($q) => $q->where('color_id', $request->color_id));
        $query->when($request->filled('size_id'), fn($q) => $q->where('size_id', $request->size_id));

        $variation = $query->first();

        return response()->json(['stock' => $variation?->stock ?? 0]);
    }
    public function products(Request $request)
    {
        $categories = Category::withCount('products')->active()->orderBy('id', 'desc')->get();

        // عند طلب AJAX (فلترة أو Scroll أو اختيار فئة)
        if ($request->ajax()) {
            $query = Product::with(['category', 'images'])->active();

            if ($request->filled('name')) {
                $locale = app()->getLocale();
                $query->where("name->{$locale}", 'like', '%' . $request->name . '%');
            }

            if ($request->filled('price_min')) {
                $query->where('price', '>=', $request->price_min);
            }

            if ($request->filled('price_max')) {
                $query->where('price', '<=', $request->price_max);
            }

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            $products = $query->latest()->paginate(9);
            return view('frontend.partials.product-list', compact('products'))->render();
        }

        // تحميل عادي للصفحة بدون أي فلتر => جلب كل المنتجات
        $hasFilters = $request->filled('category_id') || $request->filled('name') || $request->filled('price_min') || $request->filled('price_max');

        $products = !$hasFilters ? Product::with(['category', 'images'])->active()->latest()->paginate(9) : null;

        return view('frontend.products', compact('categories', 'products'));
    }


    public function categories(Request $request)
    {
        $categories = Category::active()->latest()->paginate(8);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.partials.category-list', compact('categories'))->render(),
                'hasMore' => $categories->hasMorePages(),
            ]);
        }


        return view('frontend.category_list', compact('categories'));
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
                'message' => __('تم حذف المنتج من المفضلة .')
            ]);
        }

        // أضف المنتج إلى المفضلة (افترض أن لديك علاقة wishlist)
        $user->wishlist()->attach($productId);

        return response()->json([
            'success' => true,
            'message' => __('تم إضافة المنتج إلى المفضلة .')
        ]);
    }
    public function wishlist()
    {
        $user = Auth::guard('client')->user();
        return view('frontend.wishlist')->with('products', $user->wishlist);
    }
    public function reloadWishlist()
    {
        $user = Auth::guard('client')->user();
        $products = $user->wishlist;

        $html = view('frontend.partials.product-list', compact('products'))->render();

        return response()->json(['html' => $html]);
    }


    public function ajaxRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => [
                'required',
                'digits:10',
                Rule::unique('clients')->whereNull('deleted_at')
            ],
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // البحث عن العميل بما في ذلك المحذوفين
        $existing = Client::withTrashed()
            ->where('phone_number', $request->phone_number)
            ->first();

        if ($existing) {
            // الحالة 1: العميل محذوف (Soft Deleted)
            if ($existing->trashed()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['phone_number' => [
                        __('هذا الحساب محذوف. يرجى التواصل مع الدعم لاستعادته.')
                    ]],
                ], 403);
            }

            // الحالة 2: العميل غير محذوف ولكن غير نشط
            if (!$existing->is_active) {
                return response()->json([
                    'success' => false,
                    'errors' => ['phone_number' => [
                        __('تم تعطيل حسابك. يرجى التواصل مع الدعم.')
                    ]],
                ], 403);
            }

            // الحالة 3: العميل موجود ولم يتم التحقق من OTP
            if (empty($existing->otp)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['phone_number' => [
                        __('رقم الهاتف مستخدم بالفعل.')
                    ]],
                ]);
            } else {
                // العميل موجود ولم يتم التحقق بعد
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
                    'otp' => $otp
                ]);
            }
        }

        // إنشاء حساب جديد
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
            'otp' => $otp
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
            'otp' => $otp,
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
        if (!$client->is_active) {
            return response()->json([
                'success' => false,
                'message' => __('هذا الحساب معطل'),
            ]);
        }

        if (!empty($client->otp)) {
            session(['pending_client_id' => $client->id]);
            return response()->json([
                'success' => false,
                'requires_otp' => true,
                'otp' => $client->otp,
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
    public function product($id)
    {
        $product = Product::with(['category', 'images', 'variations.colorAttribute', 'variations.sizeAttribute'])
            ->findOrFail($id);
        $colors = ProductAttribute::where('type', 'color')->get();
        $sizes = ProductAttribute::where('type', 'size')->get();

        // جميع المتغيرات (لون + مقاس + مخزون)
        $variations = $product
            ->variations()
            ->with(['colorAttribute', 'sizeAttribute'])
            ->where('stock', '>', 0)
            ->get();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->take(4)
            ->get();

        return view('frontend.single_product', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'colors' => $colors,
            'sizes' => $sizes,
            'variations' => $variations
        ]);
    }
    public function track(Request $request)
    {
        $request->validate([
            'order_code' => 'required|string'
        ]);

        $order = Order::where('code', $request->order_code)->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'لم يتم العثور على طلب بهذا الرقم'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'order' => $order
        ]);
    }

    public function track_single(Request $request)
    {
        $request->validate([
            'order_code' => 'required|string'
        ]);

        // استخدام with('items') لتحميل المنتجات المرتبطة
        $order = Order::with('items')->where('code', $request->order_code)->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'لم يتم العثور على طلب بهذا الرقم'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'order' => $order
        ]);
    }

    public function details(Order $order)
    {
        $order->load('items');

        return response()->json([
            'status' => 'success',
            'order' => $order
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
