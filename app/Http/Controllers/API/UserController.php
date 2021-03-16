<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function show($id)
    {
        return User::where('id', $id)->with(['companies'])->first();
    }
}
