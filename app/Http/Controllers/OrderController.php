<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::latest();

        if ($request->filled('search')) {
            $orders->where(function ($q) use ($request) {
                $q->where('fname', 'like', '%' . $request->search . '%')
                    ->orWhere('lname', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $orders->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $orders->whereDate('created_at', $request->date);
        }

        $orders = $orders->paginate(10);

        // AJAX Response
        if ($request->ajax()) {
            $html = view('dashboard.orders._table', compact('orders'))->render();
            return response()->json(['html' => $html]);
        }

        return view('dashboard.orders.index', compact('orders'));
    }
    public function changeStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => __('تم تحديث حالة الطلب بنجاح.'),
            'status' => $order->status,
        ]);
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('dashboard.orders.show', compact('order'));
    }
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', __('تم حذف الطلب بنجاح.'));
    }
}
