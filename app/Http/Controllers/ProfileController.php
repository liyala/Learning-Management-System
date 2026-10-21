<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Ambil seluruh data user yang sedang login saat ini
        $user = Auth::user();

        // Kirim data user ke tampilan (view)
        return view('profile.index', compact('user'));
    }
}