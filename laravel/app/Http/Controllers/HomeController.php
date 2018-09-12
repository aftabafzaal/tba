<?php

namespace App\Http\Controllers;

use App\Attributesvalues;
use App\Categories;
use App\Content;
use App\Functions\Functions;
use App\Products;
use App\ProductsImages;
use App\Specialities;
use App\States;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;
use App\Options;
class HomeController extends Controller {

    protected $categories = array();
    protected $layout = 'layouts.search';

    public function __construct() {
        $this->categories = 1;
        session_start();
        $this->sessionId = session_id();
    }

    public function makeorderimage(Request $request) {

        $post = $request->all();

        $data = $post['photo'];
        $fileName = $post['time'] . '.jpg';
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);
        $destinationPath = public_path() . '/' . config('params.image_path.cart') . $this->sessionId;
        $destinationPathThumb = $destinationPath . '/thumbnail';

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
            mkdir($destinationPathThumb, 0777, true);
        }
        file_put_contents($destinationPath . '/' . $fileName, $data);
        Image::make($destinationPath . '/' . $fileName)->fit(180)->save($destinationPathThumb . '/' . $fileName);
        echo $fileName;
    }

    public function index() {

        $data['model'] = array();
        ;

        $data['specialities'] = array();
        $data['states'] = array();

        $products = array();
        $data['products'] = Products::getProducts();;
        return view('front.index', $data);
    }

    public function page() {

        $model = Content::where('code', 'home')->first();
        $model->body = Functions::setTemplate($model->body, array());
        return view('front.page', compact('model'));
    }

    public function aboutus() {
        $model = Content::where('code', 'aboutus')->first();
        $model->body = Functions::setTemplate($model->body, array());
        return view('front.page', compact('model'));
    }

    public function privacy() {
        $model = Content::where('code', 'privacy')->first();
        $model->body = Functions::setTemplate($model->body, array());
        return view('front.page', compact('model'));
    }

    public function terms() {
        $model = Content::where('code', 'terms')->first();
        $model->body = Functions::setTemplate($model->body, array());
        return view('front.page', compact('model'));
    }

    public function agreement() {
        $model = Content::where('code', 'agreement')->first();
        $model->body = Functions::setTemplate($model->body, array());
        return view('front.page', compact('model'));
    }

    public function getstarted() {
        $model = Content::where('code', 'get-started')->first();
        $model->body = Functions::setTemplate($model->body, array());
        return view('front.page', compact('model'));
    }

    public function contact() {
        $model = Content::where('code', 'contact')->first();
        $model->body = Functions::setTemplate($model->body, array());
        return view('front.page', compact('model'));
    }

    public function getproduct($id) {
        $product = Products::find($id);
        $productImages = ProductsImages::where('product_id', '=', $id)->get();
        $default = Attributesvalues::getDefault($id);
        $options = Options::where('product_id', '=', $id)->get();
        return view('front.product', compact('product', 'default', 'productImages', 'options'))->with('id', $id);
    }

    public function sale() {
        $category = "";
        $products = Products::where('sale', '=', 1)->where('price', '>', 'salePrice')->get();
        return view('front.products', compact('products', 'category'));
    }

    public function products() {
        $products = Products::getProducts();
        return view('front.products', compact('products', 'category'));
    }

    public function messagePost(Request $request) {
        $validation = array('name' => 'required|max:30',
            'email' => 'required|email|max:30',
            'captcha' => 'required|captcha',
            'message' => 'required|min:6|max:200');

        $messages = [
            'captcha' => 'The :attribute field is invalid.',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $guestbook = new Guestbook;
        $guestbook->name = $request->name;
        $guestbook->email = $request->email;
        $guestbook->message = $request->message;
        $guestbook->save();
        return redirect('guestbook')->withInput();
    }

}
