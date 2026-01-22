<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    private string $path = 'settings.json';

    public function index()
    {
        if (!Storage::exists($this->path)) {
            return response()->json([]);
        }

        $settings = json_decode(Storage::get($this->path), true);
        return response()->json($settings);
    }

    public function update(Request $request)
    {
        $data = [
            'posts_per_page'     => (int) $request->posts_per_page,
            'admin_email'        => $request->admin_email,
            'auto_approve_post'  => filter_var($request->auto_approve_post, FILTER_VALIDATE_BOOLEAN),
            'allow_comment'      => filter_var($request->allow_comment, FILTER_VALIDATE_BOOLEAN),
            'default_language'   => $request->default_language,
        ];

        Storage::put($this->path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return response()->json([
            'message' => 'Lưu cài đặt thành công',
            'data' => $data
        ]);
    }
}