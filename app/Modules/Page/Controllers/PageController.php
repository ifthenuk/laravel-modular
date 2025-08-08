<?php

namespace App\Modules\Page\Controllers;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index()
    {
        return view('page::index');
    }
}