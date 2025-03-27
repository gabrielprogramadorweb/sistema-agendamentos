<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WebHomeController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $title = 'Home';

        $imageUrl = asset('front/image/default-profile.png');

        if ($user && $user->profile_image && Storage::exists('public/' . $user->profile_image)) {
            $imageUrl = asset('storage/' . $user->profile_image);
        }

        return view('Front.Home.index', compact('user', 'imageUrl', 'title'));
    }

}
