<?php

namespace App\Http\Controllers;

use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class CookieController extends Controller
{
    public function setCookie(Request $request) {
        $minutes = 1;
        $response = new Response ('Cookie set Successfully.');
        $response->withCookie(cookie('name', 'LarareactJs', $minutes));
        return $response;
     }
     public function getCookie(Request $request) {
        $value = $request->cookie('name');
        echo $value;
}
}
