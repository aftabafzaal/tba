<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Ambassadors;
use Input;
use App\Specialities;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class SearchController extends Controller {

    public function search(Request $request) {

        $data['search'] = $request['q'];

        $ambassadorData = Ambassadors::search($data['search']);
        $perPage = 6;
        $page = Input::get('page', 1);
        if ($page > count($ambassadorData) or $page < 1) {
            $page = 1;
        }
        $offset = ($page * $perPage) - $perPage;
        $tasks = array_slice($ambassadorData, $offset, $perPage);
        $model = new Paginator($tasks, count($ambassadorData), $perPage);
        $data['ambassadors'] = $model->setPath('search');
        $data['specialities'] = Specialities::get();

        return view('front.search', $data);
    }

}
