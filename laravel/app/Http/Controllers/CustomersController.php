<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator,
    Input,
    Redirect;
use App\User;
use App\Address;
use Auth;
use Session;
use File;
use DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Functions\Functions;
use Intervention\Image\Facades\Image as Image;

class CustomersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    use AuthenticatesAndRegistersUsers;

    public function __construct() {
        $this->middleware('auth');
    }

    public function changepassword() {
        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id);
        return view('front.customers.change_password')->with('user_id', $user_id);
    }

    public function postchangepassword(Request $request) {
        $user_id = Auth::user()->id;
        $rules = array(
            'old_password' => 'required|min:6',
            'password' => 'required|min:6',
            'password_confirmation' => 'required_with:password|min:6',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            //d($request->all(),1);
            return redirect('changepassword')->withErrors($validator->errors());
            //return redirect('changepassword')->withInput();
        }

        $user = User::findOrFail($user_id);

        //if(bcrypt($request->old_password) == $user->password)
        //{
        $data = $request->all();
        array_forget($data, 'password_confirmation');
        array_forget($data, 'old_password');
        array_forget($data, '_token');
        $data['password'] = bcrypt($request->password);

        $user->update($data);
        Session::flash('success', 'Your password has been changed.');
        return redirect()->back();
        //}


        Session::flash('error', 'Old password is Incorrect.');
        return redirect()->back()->withError('Incorrect old password', 'changepassword');
    }

    public function profile() {

        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id);
        $age = Functions::getAge($user->dob);
        $address = Address::where('user_id', '=', $user_id)->first();



        return view('front.customers.profile', compact('user', 'age', 'address', 'role'))->with('user_id', $user_id);
    }

    public function editprofile() {

        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id);

        $address = Address::where('user_id', '=', $user_id)->first();

        return view('front.customers.edit_profile', compact('user', 'address'))->with('user_id', $user_id);
    }

    public function profilepicture() {
        $user_id = Auth::user()->id;
        $data['user'] = User::findOrFail($user_id);
        return view('front.customers.profile_picture', $data);
    }

    public function changeprofileimage(Request $request) {

        $rules['image'] = 'required|mimes:jpeg,bmp,png,gif,jpg';
        $validator = Validator::make($request->all(), $rules);
        $fileName = "";
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id);
        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/users/';
            $destinationPathThumb = $destinationPath . 'thumbnail/';

            $file1 = $destinationPath . $user->image;
            $file2 = $destinationPathThumb . $user->image;
            File::delete($file1, $file2);

            $fileName = Functions::saveImage($file, $destinationPath, $destinationPathThumb);
            $upload = Image::make($destinationPath . $fileName)->resize(270, 260)->save($destinationPathThumb . $fileName)->orientate();
            $ext = pathinfo(public_path() . '/uploads/users/' . $fileName, PATHINFO_EXTENSION);

            $input['image'] = $fileName;
        }

        $affectedRows = User::where('id', '=', $user_id)->update($input);
        Session::flash('success', 'Your profile picture has been updated.');
        return redirect()->back();
    }

    public function updateprofile(Request $request) {

        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id);
        $rules = array(
            'firstName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'email' => 'required|min:6|email|unique:users,email,' . $user->id,
            'phone' => 'required|min:8',
        );


        $validator = Validator::make($request->all(), $rules);
        // $checkEmail=User::where('email','!=',$user->email)->where('email',$request->email)->count();

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator, 'register')->withInput();
        } else {

            $user = User::findOrFail($user_id);

            $data = $request->all();
            $input['firstName'] = $request->firstName;
            $input['lastName'] = $request->lastName;
            $input['middleName'] = $request->middleName;
            $input['email'] = $request->email;
            $input['gender'] = $request->gender;


            array_forget($data, '_token');

            $address['phone'] = $request->phone;

            $affectedRows = User::where('id', '=', $user_id)->update($input);
            $affectedRows = Address::where('id', '=', $request->address_id)->update($address);
            Session::flash('success', 'Your profile has been updated.');
            return redirect()->back();
        }
    }

    public function available(Request $request, $id) {
        DB::table('users')->where('id', $id)->update([
            'availability' => 1,
            'updated_at' => date('Y-m-d'),
        ]);
        $request->session()->flash('success', 'Successfully Updated!');
        return back();
    }

    public function unavailable(Request $request, $id) {
        DB::table('users')->where('id', $id)->update([
            'availability' => 0,
            'updated_at' => date('Y-m-d'),
        ]);
        $request->session()->flash('success', 'Successfully Updated!');
        return back();
    }

}