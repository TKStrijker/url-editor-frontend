<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class UrlController extends Controller
{
    public function index(Request $request): View
    {
        $response = Http::get(config('app.api_base_uri') . "/url/", ['user_id' => $request->user()->id]);

        $urls = $response->json();

        return view('url.index', [
            'urls' => $urls
        ]);
    }
}
