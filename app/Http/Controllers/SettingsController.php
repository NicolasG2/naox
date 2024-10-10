<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.settings');
    }

    public function mesasSettings()
    {
        $mesas = Mesa::all();
        return view('settings.mesas.index', compact('mesas'));
    }
}
