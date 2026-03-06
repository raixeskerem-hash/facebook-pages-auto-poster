<?php

namespace App\Http\Controllers;

use App\Models\Proxy;
use Illuminate\Http\Request;

class ProxyController extends Controller
{
    public function index()
    {
        $proxies = Proxy::all();
        return view('proxies.index', compact('proxies'));
    }

    public function create()
    {
        return view('proxies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ip_address' => 'required|string|max:255',
            'port'       => 'required|integer|min:1|max:65535',
            'username'   => 'nullable|string|max:255',
            'password'   => 'nullable|string|max:255',
            'status'     => 'required|in:active,inactive',
        ]);

        Proxy::create($validated);
        return redirect()->route('proxies.index')->with('success', 'Proxy başarıyla oluşturuldu.');
    }

    public function edit(Proxy $proxy)
    {
        return view('proxies.edit', compact('proxy'));
    }

    public function update(Request $request, Proxy $proxy)
    {
        $validated = $request->validate([
            'ip_address' => 'required|string|max:255',
            'port'       => 'required|integer|min:1|max:65535',
            'username'   => 'nullable|string|max:255',
            'password'   => 'nullable|string|max:255',
            'status'     => 'required|in:active,inactive',
        ]);

        $proxy->update($validated);
        return redirect()->route('proxies.index')->with('success', 'Proxy başarıyla güncellendi.');
    }

    public function destroy(Proxy $proxy)
    {
        $proxy->delete();
        return redirect()->route('proxies.index')->with('success', 'Proxy başarıyla silindi.');
    }
}
