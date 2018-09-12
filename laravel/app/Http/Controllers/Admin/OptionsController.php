<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Options;
use App\Products;

use App\Functions\Functions;
use Illuminate\Http\Request;
use Validator,
    Input,
    Redirect;
use Intervention\Image\Facades\Image as Image;
use Config;

class OptionsController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function get($product_id) {

        $options = Options::where('product_id', $product_id)->get();
        $product = Products::find($product_id);
        return view('admin.options.index', compact('product', 'options', 'product_id'));
    }

    public function create($product_id) {
        $styles = Config::get('fonts');
        
        return view('admin.options.create', compact('styles','product_id'));
    }

    public function insert(Request $request) {

        $rules = [
            'name' => 'required|max:100',
            'topPosition' => 'required|numeric',
            'leftPosition' => 'required|numeric',
            'textLimit' => 'required|numeric'
        ];

        $validator = Validator::make($request->all(), $rules);
        $fileName = "";
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $model = new Options;
        $model->name = $request->name;
        $model->topPosition = $request->topPosition;
        $model->leftPosition = $request->leftPosition;
        $model->textLimit = $request->textLimit;
        $model->width = $request->width;
        $model->height = $request->height;
        $model->color = $request->color;
        $model->size = $request->size;
        $model->style_id = $request->style_id;
        $model->product_id = $request->product_id;
        $model->save();
        $product_id = $model->id;

        \Session::flash('success', 'Added Successfully!');

        return redirect('admin/options/' . $request->product_id);
    }

    public function edit($id) {
        $model = Options::findOrFail($id);
        $styles = Config::get('fonts');
        $product_id=$model->product_id;
        return view('admin.options.edit', compact('styles', 'model','product_id' ))->with('id', $id);
    }

    public function update($id, Request $request) {
        $rules = [
            'name' => 'required|max:100',
            'topPosition' => 'required|numeric',
            'leftPosition' => 'required|numeric',
            'textLimit' => 'required|numeric'
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $id = $request->id;
        $option = Options::findOrFail($id);
        $input = $request->all();
        unset($input['_token']);
        $affectedRows = Options::where('id', '=', $id)->update($input);

        \Session::flash('message', 'Updated Successfully!');
        return redirect('admin/options/'.$option->product_id);
    }

    public function delete($id) {
        $row = Options::where('id', '=', $id)->first();
        Options::where('id', '=', $id)->delete();
        return redirect('admin/options/'.$row->product_id);
    }

}
