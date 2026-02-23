<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show the settings page.
     */
    public function index()
    {
        return view('admin.settings.index');
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        // We will implement this after we create a settings table/model
        // For now, just return success message

        return redirect()->back()->with('success', 'Settings saved successfully!');
    }
}