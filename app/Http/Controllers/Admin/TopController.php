<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TopController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.top', compact('admin'));
    }
}