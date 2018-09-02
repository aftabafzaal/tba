<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;

class AjaxController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function __construct() {
//        $this->middleware('auth');
    }

    public function getState($countryid) {
        //print_r()
        $states = DB::table('states')->where('country_id', $countryid)->get();

        return json_encode($states);
    }

    public function getCity($stateid) {

        $cities = DB::table('cities')->where('state_id', $stateid)->get();
        //print_r($cities);
        return json_encode($cities);
    }

}
