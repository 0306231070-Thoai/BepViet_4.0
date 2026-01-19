<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    private $path = 'system_settings.json';

    public function index()
    {
        return json_decode(Storage::get($this->path), true);
    }

    public function update(Request $request)
    {
        Storage::put(
            $this->path,
            json_encode($request->all(), JSON_PRETTY_PRINT)
        );

        return response()->json(['message'=>'Settings updated']);
    }
}