<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\GeneralInfo;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashbaordController extends Controller
{

    public function about_page()
    {
        return view('dashboard.about_page');
    }
    public function trake_page()
    {
        return view('dashboard.trackOrder');
    }

    public function dashboard()
    {
        $startOfWeek = Carbon::now()->subWeek()->startOfWeek(Carbon::FRIDAY); // 2025-07-11
        $endOfWeek = $startOfWeek->copy()->addDays(6)->endOfDay(); // 2025-07-17 23:59:59

        $orders = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();

        $clientsCount = Client::count();
        $ordersCount = Order::count();

        $ordersByStatus = Order::selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status');

        $ordersPerDay = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->groupBy('date')
            ->pluck('count', 'date');

        $totalEarningsCurrentMonth = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('total');

        $totalEarningsLastMonth = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total');
        return view('dashboard.index', compact(
            'clientsCount',
            'ordersCount',
            'ordersByStatus',
            'ordersPerDay',
            'totalEarningsCurrentMonth',
            'totalEarningsLastMonth'
        ));
    }



    public function setting()
    {
        return view('dashboard.setting');
    }
    public function add_general(Request $request)
    {
        if ($request->hasFile('general_file')) {
            foreach ($request->file('general_file') as $name => $value) {
                if ($value == null) {
                    continue;
                }
                // Save the uploaded file to the 'general' directory in storage and store the path in the database
                $path = $value->store('general', 'public');
                GeneralInfo::setValue($name, $path);
            }
        }
        if ($request->has('general')) {

            foreach ($request->input('general') as $name => $value) {
                if ($value == null) {
                    continue;
                }
                GeneralInfo::setValue($name, $value);
                if ($name == 'country_code' || $name == 'whataspp') {
                    GeneralInfo::setValue('whatsapp_number', get_general_value('country_code') . get_general_value('whataspp'));
                }
            }
        }

        return redirect()->back()->with(['success' => trans('Edit Successfuly')]);
    }
    public function edit_profile()
    {
        return view('dashboard.edit_profile');
    }
    public function edit_profile_post(Request $request)
    {
        $id = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        if ($request->password != null) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);
        }
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => 'false'], 422);
        }
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }

        if ($request->image != null) {
            $user->image = $request->image->store('/users');
        }
        $user->save();
        return response()->json(['success' => 'true'], 200);
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
    public function login()
    {
        if (auth()->check() == true) {
            return redirect()->route('dashboard');
        } else {
            return view('auth.login');
        }
    }
    public function post_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }
        return redirect()->back()->with(['error' => trans('البريد اللاكتروني او كلمة المرور غير صحيحة')]);
    }
    public function change_lang($locale)
    {
        if (!in_array($locale, ['en', 'ar', 'he'])) {
            abort(400);
        }

        session()->put('locale', $locale);
        app()->setLocale($locale);

        return redirect()->back();
    }
    public function show_translate($lang)
    {
        $language = $lang;
        return view('dashboard.languages.language_view', compact('language'));
    }
    public function key_value_store(Request $request)
    {
        $data = openJSONFile($request->id);
        foreach ($request->key as $key => $key) {
            $data[$key] = $request->key[$key];
        }
        saveJSONFile($request->id, $data);
        return back();
    }
    public function popup_model()
    {
        return view('dashboard.popup_model');
    }
}
