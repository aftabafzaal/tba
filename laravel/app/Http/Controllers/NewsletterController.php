<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Newsletter;

class NewsletterController extends Controller {

    private $sessionId;

    public function __construct() {
        session_start();
        $this->sessionId = session_id();
        // $this->middleware('auth');
    }

    public function store(Request $request) {
        $rules = array(
            'name' => 'required|max:150',
            'email' => 'required|email|max:255|unique:newsletter',
        );
        $response['error'] = 0;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['error'] = 1;
            $response['errors'] = $errors;
        } else {
            $input = $request->all();
            unset($input['_token']);
            $model = new Newsletter();
            $model->name = $input['name'];
            $model->email = $input['email'];
            $model->save();
        }
        return json_encode($response);
    }
}