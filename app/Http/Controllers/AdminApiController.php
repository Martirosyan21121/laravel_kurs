<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminApiController extends Controller
{
    public function allUsersForAPI()
    {

        return response()->json('message');
    }

    function loginApi()
    {
            return response()->json([
                'message' => 'Admin login successful',
            ], 200);
        }
}
