<?php

namespace App\Http\Controllers;

use App\Http\Resources\Filter\Filters;
use App\Models\Tenant;
use Illuminate\Http\Request;

class FiltersController extends Controller
{
    public function index()
    {
        return new Filters(Tenant::find(2)->load('product_categories'));
    }
}
