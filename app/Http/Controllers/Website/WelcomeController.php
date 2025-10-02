<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $topics = Topic::where('is_active', true)->get();

        return view('welcome', ['topics' => $topics]);
    }
}
