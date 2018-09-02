<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Categories;
use App\ProductsCategories;
use App\Products;
use App\Urls;
use App\Functions\Functions;
use Illuminate\Http\Request;
use Validator,
    Input,
    Redirect;
use Intervention\Image\Facades\Image as Image;
use App\Attributes;
use App\ProductsAttributes;
use App\ProductsImages;
use App\Attributesvalues;
use Config;
class ProductsController extends AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $products = Products::where('deleted', '0')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create() {
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
        } else {
            $type = 'simple';
        }
        $attributes = Attributes::lists('name', 'id');

        $productAttributes = NULL;
        $productsCategories = NULL;
        $url = NULL;

        $selectedAttributes = Attributes::where("id", "=", "1")->get();
        
        $styles = Config::get('fonts');
        $productAttributes = array();
        foreach ($selectedAttributes as $a) {
            $productAttributes[] = $a->id;
        }
        return view('admin.products.create', compact('styles','productAttributes', 'categories', 'attributes', 'productAttributes', 'productsCategories', 'type', 'categories', 'url'));
    }

    public function insert(Request $request) {

        $rules = [
            'name' => 'required|max:100',
            'price' => 'required|numeric',
            'top' => 'required|numeric',
            'left' => 'required|numeric',
            'textLimit' => 'required|numeric',
            'key' => 'required|unique:urls'
        ];

        $rules['image'] = 'required|mimes:jpeg';

        $validator = Validator::make($request->all(), $rules);
        $fileName = "";
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/products/';
            $destinationPathThumb = $destinationPath . 'thumbnail/';
            $fileName = Functions::saveImage($file, $destinationPath, $destinationPathThumb);
            $data = getimagesize($destinationPath . $fileName);
            $width = (int) $data[0] / 2;
            $height = (int) $data[1] / 2;
            $upload = Image::make($destinationPath . $fileName)->resize($width, $height)->save($destinationPathThumb . $fileName);
        }


        $model = new Products;
        $model->name = $request->name;
        $model->price = $request->price;
        $model->keywords = $request->keywords;
        $model->top = $request->top;
        $model->left = $request->left;
        $model->textLimit = $request->textLimit;
        $model->textWidth = $request->textWidth;
        $model->image = $fileName;
        $model->save();
        $product_id = $model->id;

        if (!empty($request['attributes'])) {
            foreach ($request['attributes'] as $attribute_id) {
                $attributeModel = new ProductsAttributes;
                $attributeModel->product_id = $product_id;
                $attributeModel->attribute_id = 65;
                $attributeModel->save();
            }

            if (Input::hasFile('image')) {

                $model = new ProductsImages;
                $newDestinationPath = public_path() . '/uploads/products_images/';
                $newDestinationPathThumb = $newDestinationPath . 'thumbnail/';
                $newImage = $destinationPath . '/' . $fileName;

                copy($destinationPath . '/' . $fileName, $newDestinationPath . '/' . $fileName);
                copy($destinationPathThumb . '/' . $fileName, $newDestinationPathThumb . '/' . $fileName);
                $model->image = $fileName;
                $model->attribute_value_id = 1;
                $model->product_id = $product_id;

                $model->save();
            }
        }

        $input['type'] = \Config::get('params.type.product');
        $input['type_id'] = $product_id;
        $input['key'] = $request->key;
        $url = Urls::saveUrl($input);

        \Session::flash('success', 'Added Successfully!');

        return redirect('admin/products?type=' . $request->type);
    }

    public function edit($id) {
        $product = Products::findOrFail($id);
        $selectedCategories = ProductsCategories::where('product_id', $id)->get();
        $productsCategories = array();
        foreach ($selectedCategories as $pc) {
            $productsCategories[] = $pc->category_id;
        }

        $attributes = Attributes::lists('name', 'id');
        $selectedAttributes = ProductsAttributes::where('product_id', $id)->orderBy('id')->get();
        $productAttributes = array();
        foreach ($selectedAttributes as $a) {
            $productAttributes[] = $a->attribute_id;
        }

        $urls = Urls::where('type_id', $id)->first();
        if (!empty($urls)) {
            $url = $urls->key;
        } else {
            $url = null;
        }
        $styles = Config::get('fonts');
        $categories = Categories::lists('name', 'id');
        return view('admin.products.edit', compact('styles','product', 'categories', 'productsCategories', 'productAttributes', 'attributes', 'url'))->with('id', $id);
    }

    public function update($id, Request $request) {
        $rules = [
            'name' => 'required|max:100',
            'price' => 'required|numeric',
            'top' => 'required|numeric',
            'left' => 'required|numeric',
            'textLimit' => 'required|numeric',
            'key' => 'required|unique:urls,type_id,' . $request->id
        ];

        $rules['image'] = 'mimes:jpeg|jpg';


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $id = $request->id;
        $product = Products::findOrFail($id);
        $input = $request->all();

        if (Input::hasFile('image')) {

            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/products/';
            $destinationPathThumb = $destinationPath . 'thumbnail/';

            $extension = $file->getClientOriginalExtension();
            $fileName = rand(111, 999) . time() . '.' . $extension;
            $image = $destinationPath . '/' . $fileName;
            $upload_success = $file->move($destinationPath, $fileName);
            $upload = Image::make($image)->resize(512, 662)->save($destinationPathThumb . $fileName);
            $input['image'] = $fileName;
        }

        unset($input['_token']);
        unset($input['attributes']);
        unset($input['categories']);
        unset($input['key']);
        $affectedRows = Products::where('id', '=', $id)->update($input);

        if (!empty($request['key'])) {
            $input['type_id'] = $id;
            $input['type'] = 'product';
            $input['key'] = $request->key;
            Urls::saveUrl($input);
        }
        if (!empty($request['categories'])) {
            $productsCategories = ProductsCategories::where('product_id', $id)->delete();
            foreach ($request['categories'] as $category_id) {
                $categoryModel = new ProductsCategories;
                $categoryModel->product_id = $id;
                $categoryModel->category_id = $category_id;
                $categoryModel->save();
            }
        }

        if (!empty($request['attributes'])) {

            $deleteAttributes = ProductsAttributes::where('product_id', $id)->delete();

            foreach ($request['attributes'] as $attribute_id) {
                $attributeModel = new ProductsAttributes;
                $attributeModel->product_id = $id;
                $attributeModel->attribute_id = $attribute_id;
                $attributeModel->save();
            }
        }
        \Session::flash('message', 'Updated Successfully!');
        return redirect('admin/products');
    }

    public function delete($id) {

        $row = Products::where('id', '=', $id)->delete();
        Urls::deleteUrl($id);

        return redirect('admin/products');
    }

}