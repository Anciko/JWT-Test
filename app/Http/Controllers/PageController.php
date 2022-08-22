<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    public function hehe()
    {
        return Http::post('https://verify.smspoh.com/api/v2/send', [
            "to" => "09963356789",
            "message" => "Hello World",
            "sender" => "SMSPoh"
        ]);
    }
}
