<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\Address;
use App\Products;
use App\Cart;
use Session;
use App\Functions\Functions;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class SignupController extends Controller {

    use AuthenticatesAndRegistersUsers;

    protected $loginPath = 'signup';

    public function __construct(Guard $auth, Registrar $registrar) {
        $this->auth = $auth;
        $this->registrar = $registrar;
        $this->middleware('guest', ['except' => 'success,getState,getCity']);
    }

    public function login() {
        return view('front.customers.login');
    }

    public function register() {
        $pathInfo = (explode("/", $_SERVER['REQUEST_URI']));
        $view = 'front.customers.register_' . end($pathInfo);
        $states = \App\States::get();
        $countries = DB::table('countries')->get();
        //Functions::dob('type','start','end');
        $years = Functions::dob('year', '1950', date('Y'));
        $months = Functions::dob('month', '1', '12');
        $days = Functions::dob('day', '1', '31');
        $getAmbassador = User::where(['role_id' => 3, 'status' => 1, 'deleted' => 0, 'availability' => 1])->get();
        return view($view, compact('specialities', 'states', 'getAmbassador', 'countries', 'years', 'days', 'months'));
    }

    public function signup() {
        return view('front.customers.signup');
    }

    public function forgot_password() {
        return view('front.customers.forgot');
    }

    public function postLogin(Request $request) {


        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            session_start();
            $role = Auth::user()->role->role;
            $cart = Cart::countCart(session_id());
            if ($cart > 0) {
                $cart = Cart::where('session_id', '=', session_id())->get();
                foreach ($cart as $product) {
                    $model = Products::find($product->product_id);
                    $price = Functions::getPrice(Auth::user(), $model);
                    Cart::where('id', $product->id)->update(array('totalPrice' => $price));
                }
                return redirect('cart/view');
                die;
            }
            if ($role == 'user') {
                return redirect('/');
            }
            if ($role == 'admin') {
                return redirect('admin');
            }
            return redirect()->intended($this->redirectPath());
        }

        return redirect($this->loginPath())
                        ->withInput($request->only('email', 'remember'))
                        ->withErrors([
                            'email' => $this->getFailedLoginMessage(),
        ]);
    }

    public function store(Request $request) {
        $validation = array(
            'firstName' => 'required|max:20',
            'lastName' => 'required|max:20',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|confirmed|min:6',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|max:15',
            'address' => 'required|max:100',
            'address2' => 'max:100',
            'phone' => 'required|max:16',
        );
        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors(), 'register');
        }
        $confirmation_code = str_random(30);
        $user = new User;
        $user->firstName = $request->firstName;
        $user->middleName = $request->middleName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->role_id = 2;
        $user->password = bcrypt($request->password);
        $user->status = 1;
        $user->confirmationCode = $confirmation_code;
        $user->save();

        $address = new Address;
        $address->user_id = $user->id;
        $address->phone = $request->phone;
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->address2 = $request->address2;
        $address->zip = $request->zip;
        $address->save();

        $credentials = $request->only('email', 'password');

        $subject = view('emails.confirm_email.subject');
        $body = view('emails.confirm_email.body', compact('confirmation_code'));
        Functions::sendEmail($request->email, $subject, $body);

        if (Auth::attempt($credentials, 1)) {
            session_start();
            $role = Auth::user()->role->role;
            if ($role == 'user') {
                Session::flash('success', 'Thanks for signing up! Please check your email.');
                return redirect('profile');
            } else {
                Session::flash('success', 'Thanks for signing up! Please check your email.');
                return redirect('profile');
            }
        }
    }

    public function confirmEmail($confirmation_code) {
        if (!$confirmation_code) {
            return 'Error! Confirmation Key missing.';
        }
        $user = User::where('confirmationCode', $confirmation_code)->first();
        if (!$user) {
            return 'Error! Confirmation Key missing.';
        }
        $user->isConfirmed = 1;
        $user->save();
        return redirect('register/success/' . $user->id);
    }

    public function success($id) {
        //$this->middleware('auth');
        $user = User::findOrFail($id);
        $data['user'] = $user;
        return view('front.customers.register_success', $data);
    }

}
