<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function __invoke(Request $request, $language, $default = null)
    {
        return view('language.index');
    }
}
