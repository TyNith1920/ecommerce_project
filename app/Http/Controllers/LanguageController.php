<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLanguage(Request $request)
{
    $request->validate(['language' => 'in:en,km']);
    session(['locale' => $request->language]);
    return redirect()->back();
    }
}