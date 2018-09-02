<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Validator;
use Auth;
use App\User;
use App\Orders;
use App\Address;
use App\Countries;
use App\OrdersProducts;
use App\OrderProductAttributes;
use App\PaymentPayflow;
use App\Transactions;
use Session;
use Illuminate\Http\Request;
use App\Functions\Payflow;
use App\Functions\Functions;
use Config;
use DB;

class CheckoutController extends Controller {

    public $auth;
    private $sessionId;

    public function __construct() {
        session_start();
        $this->sessionId = session_id();
        $this->middleware('auth');
    }

    public function index() {
        $shippings = array();

        $coupon = array();
        $validDiscount = Session::get('validDiscount');

        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);
        $address = Address::where('user_id', '=', $userId)->first();
        $countries = Countries::get();
        $states = \App\States::get();
        $cart = Session::get('cart');
        if ($validDiscount == 1) {
            $coupon = Session::get('coupon');
        }
        return view('front.checkout.index', compact('countries', 'user', 'cart', 'address', 'coupon', 'shippings', 'states'));
    }

    public function order(Request $request) {

        $currency = Config('params.currency_default');
        $validationArray = array(
            'billingFirstName' => 'required|max:255',
            'billingLastName' => 'required|max:255',
            'billingEmail' => 'required|email',
            'billingCountry' => 'required',
            'billingState' => 'required',
            'billingCity' => 'required',
            'billingAddress1' => 'required',
            'billingZip' => 'required',
            'billingPhone' => 'required',
            'cc' => 'required',
            'cvc' => 'required',
            'expMonth' => 'required',
            'expYear' => 'required',
            'message' => 'max:200',
        );



        //d($request->all(),1);
        $validator = Validator::make($request->all(), $validationArray);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors(), 'checkout');
        }

        DB::beginTransaction();
        try {

            $orderModel = new Orders();
            $orderModel->billingFirstName = $request->billingFirstName;
            $orderModel->billingLastName = $request->billingLastName;
            $orderModel->email = $request->billingEmail;
            $orderModel->user_id = Auth::user()->id;
            $orderModel->grandTotal = $request->grandTotal;
            $orderModel->paymentType = 'cod';
            $orderModel->save();

            $order_id = $orderModel->id;
            $data['orderModel'] = $orderModel;
            // $request->billing_country_id = 230;

            $address1 = new Address();
            $address1->country = $request->billingCountry;
            $address1->city = $request->billingCity;
            $address1->state = $request->billingState;
            $address1->address = $request->billingAddress1;
            $address1->address2 = $request->billingAddress2;
            $address1->order_id = $order_id;
            $address1->user_id = Auth::user()->id;
            $address1->zip = $request->billingZip;
            $address1->phone = $request->billingPhone;
            $address1->addressType = 'billing';
            $address1->save();

            $cart = Session::get('cart');

            $i = 1;
            $sum = 0;
            $quantity = 0;
            $destinationPath = public_path() . '/' . config('params.image_path.cart') . $this->sessionId;
            $destinationPathThumb = $destinationPath . '/thumbnail';

            $newDestinationPath = public_path() . '/uploads/orders/' . $order_id;
            $newDestinationPathThumb = $newDestinationPath . '/thumbnail/';

            if (!file_exists($newDestinationPath)) {
                mkdir($newDestinationPath, 0777, true);
                mkdir($newDestinationPathThumb, 0777, true);
            }

            foreach ($cart as $product) {

                $opModel = new OrdersProducts();
                $opModel->product_id = $product->product_id;
                $opModel->price = $product->total_price;
                $opModel->order_id = $order_id;
                $opModel->quantity = 1;
                $opModel->image = $product->image;
                $opModel->save();

                $description = "";
                $sum += $product->total_price * $product->quantity;
                $quantity += $product->quantity;
                // d($product, 1);
                $opaModel = new OrderProductAttributes();
                $opaModel->attribute_id = $product->attribute_id;
                $opaModel->attribute = $product->attribute;
                $opaModel->value_id = $product->value_id;
                $opaModel->orders_prodrocts_id = $opModel->id;
                $opaModel->save();
                $i++;

                //echo $destinationPath . '/' . $product->image;
                //echo $newDestinationPath . '/' . $product->image;

                copy($destinationPath . '/' . $product->image, $newDestinationPath . '/' . $product->image);
                copy($destinationPathThumb . '/' . $product->image, $newDestinationPathThumb . '/' . $product->image);
            }

            self::sendOrderMail($order_id);

            DB::commit();
            return redirect('checkout/success/' . $order_id);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('checkout/fail');
        }
    }

    public function success($id) {
        return view('front.checkout.success')->with('id', $id);
    }

    public function sendOrderMail($order_id) {
        $id = $order_id;

        $order_email = Config('params.order_email');

        try {
            $orders = Orders::getOrderDetailByPk($id);

            $addresses = Address::where('order_id', $id)->orderBy('addressType', 'shipping')
                    ->leftJoin('countries as c', 'c.id', '=', 'address.country')
                    ->leftJoin('states as s', 's.id', '=', 'address.state')
                    ->select('address.*', 'c.name as country', 's.name as state')
                    ->first();
            $data['orders'] = $orders;
            $data['addresses'] = $addresses;

            $subjectUser = view('emails.order_user.order_subject');
            $bodyUser = view('emails.order_user.order_body', $data);
            Functions::sendEmail(Auth::user()->email, $subjectUser, $bodyUser);

            $subject = view('emails.order_system.order_subject');
            $body = view('emails.order_system.order_body', $data);
            Functions::sendEmail($order_email, $subject, $body);
            return TRUE;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return FALSE;
        }
    }

}