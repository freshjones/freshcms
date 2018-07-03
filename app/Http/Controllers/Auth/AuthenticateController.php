<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthenticateController extends Controller
{
    public function getAuthentication(){

        if(!$check = Auth::check())
          return [
            "authenticated" => false,
            "user" => null,
            "email" => null,
          ];

        $user = Auth::user();

        return [
          "authenticated" => true,
          "user" => $user->name,
          "email" => $user->email,
        ];

    }
}
