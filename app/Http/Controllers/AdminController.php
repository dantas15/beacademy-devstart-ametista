<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('admin.index');
    }

    public function orders()
    {
        return view('admin.orders.index', [
            'orders' => Order::orderBy('created_at', 'desc')->paginate(10)
        ]);
    }
}
