<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('dashboard.clients.index', compact('clients'));
    }
    public function ajax(Request $request)
    {
        $query = Client::query();

        if ($request->name) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->phone_number) {
            $query->where('phone_number', 'LIKE', '%' . $request->phone_number . '%');
        }

        if ($request->filled('verified')) {
            if ($request->verified == 1) {
                $query->whereNull('otp');
            } else {
                $query->whereNotNull('otp');
            }
        }
        if ($request->filled('is_active')) {
            if ($request->is_active == 1) {
                $query->where('is_active',1);
            } else {
                 $query->where('is_active',0);
            }
        }

        $clients = $query->latest()->paginate(10);

        return response()->json([
            'html' => view('dashboard.clients._table', compact('clients'))->render()
        ]);
    }
     public function update_status_client(Request $request)
    {
        $client = Client::findOrFail($request->client_id);
        $client->is_active  = $request->is_active ; // Toggle status
        $client->save();

        return response()->json(['success' => true, 'status' => $client->is_active,'message'=>__('تم تحديث حالة العميل')]);
    }

    public function show(Client $client)
    {
        return view('dashboard.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('dashboard.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:clients,phone_number,' . $client->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'تم تحديث بيانات العميل بنجاح');
    }
}
