<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use DB;
use App\User;
use App\Orders;
use App\Transactions;
use Carbon\Carbon;
//use App\AmbassadorsSubscriptions;
use Illuminate\Http\Request;

class HomeController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = array();

        $data['totalUsers'] = array();

        $data['totalOrders'] = array();

        $data['totalSubscriptions'] = array();;

        $data['totalTransactions'] = array();;

        return view('admin.home', $data);
    }

    public function accept(Request $request, $id) {
        DB::table('users')->where('id', $id)->update([
            'status' => 1,
            'updated_at' => date('Y-m-d'),
        ]);
        $request->session()->flash('alert-success', 'Successfully Approved!');
        return back();
    }

    public function reject(Request $request, $id) {
        DB::table('users')->where('id', $id)->update([
            'status' => 0,
            'updated_at' => date('Y-m-d'),
        ]);
        $request->session()->flash('alert-success', 'Successfully Disapproved!');
        return back();
    }

    public function edit($id) {
        // $industries = DB::table('categories')->get();
        // $editmanageproducts = DB::table('products')->where('id', $id)->find($id);
        // return view('admin_pages.editmanageproducts',['editmanageproducts' => $editmanageproducts, 'industries' => $industries]);
        $ambassadorCheck = DB::table('ambassadors')->where('user_id', $id)->first();

        return view('admin.ambassador.edit', ['ambassadorCheck' => $ambassadorCheck, 'id' => $id]);
    }

}
