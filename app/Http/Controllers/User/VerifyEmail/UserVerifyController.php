<?php

namespace App\Http\Controllers\User\VerifyEmail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserVerifyController extends Controller
{
    public function index()
    {
        return view('user.verify.index');
    }
}
