<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderDetail;

class HomeController extends Controller
{
    public function changeLanguage($language)
    {
        Session::put('website_language', $language);
        
        return redirect()->back();
    }
}
