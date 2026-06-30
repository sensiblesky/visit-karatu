<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $groups = Setting::orderBy('id')->get()->groupBy('group');
        return view('admin.settings.index', compact('groups'));
    }

    public function update(Request $request)
    {
        $values = $request->input('settings', []);

        foreach (Setting::all() as $setting) {
            if (array_key_exists($setting->key, $values)) {
                $setting->update(['value' => $values[$setting->key]]);
            }
        }

        return back()->with('success', 'Settings saved.');
    }
}
