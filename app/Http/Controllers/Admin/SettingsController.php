<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        // Fetch existing settings (or use defaults)
        $settings = [
            'site_name' => Setting::get('site_name', 'Blonde Bakery'),
            'contact_email' => Setting::get('contact_email', 'admin@mycakes.com'),
            'contact_phone' => Setting::get('contact_phone', '+91 98765 43210'),
            'address' => Setting::get('address', 'Pune, India'),
            'delivery_fee' => Setting::get('delivery_fee', '50'),
            'free_delivery_threshold' => Setting::get('free_delivery_threshold', '500'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'address' => 'required|string',
            'delivery_fee' => 'required|numeric|min:0',
            'free_delivery_threshold' => 'required|numeric|min:0',
        ]);

        // Save each setting
        Setting::set('site_name', $request->site_name);
        Setting::set('contact_email', $request->contact_email);
        Setting::set('contact_phone', $request->contact_phone);
        Setting::set('address', $request->address);
        Setting::set('delivery_fee', $request->delivery_fee);
        Setting::set('free_delivery_threshold', $request->free_delivery_threshold);

        return redirect()->route('admin.settings.index')->with('success', 'Settings saved successfully!');
    }
}