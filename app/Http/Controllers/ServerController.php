<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function awake()
    {
        return response('server awaken', 200);
    }
}
