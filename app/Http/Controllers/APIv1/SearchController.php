<?php

namespace App\Http\Controllers\APIv1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SearchController extends Controller
{
    function searchUsers(Request $request) {
        $users = \App\User::search($request->q)->get();
        return response()->json($users);
    }


}
