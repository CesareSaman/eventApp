<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store()
    {
        Category::create(request()->only([
            'name'
        ]));
    }
}
