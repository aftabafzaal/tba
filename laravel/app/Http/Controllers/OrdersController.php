<?php

namespace App\Http\Controllers;


use Auth;
use App\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class OrdersController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function order($id) {
        $order = Orders::getOrderDetailByPk($id);
        //d($order,1);
        return view('front.orders.order', compact('order'));
    }

    public function myorders() {
        $user_id = Auth::user()->id;
        $orders = Orders::where('user_id', $user_id)->orderBy('id')->get();

        return view('front.orders.index', compact('orders'));
    }

}
