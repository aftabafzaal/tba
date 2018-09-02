<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Auth;
use DB;
use App\Results;
use App\Shows;
use App\MealPlans;
use App\AthleteMp;
use App\WorkoutPlans;
use App\AthleteWp;
use App\Certifications;
use App\User;
use App\Countries;
use App\RequestedCoaches;
use App\States;
use App\Messages;
use Illuminate\Http\Request;
use App\Orders;
use File;

class ClientsController extends AdminController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if (Auth::user()->role->role == 'admin') {

            $model = User::where('users.role_id', '!=', 1)
                    ->orderBy('users.id', 'desc')
                    ->paginate(10);
            //d($model,1);
            return view('admin.clients', compact('model'));
        } else {
            return redirect('home');
        }
    }

    public function userDetail(Request $request) {
        $userId = $request->id;
        $countries = Countries::get();
        $states = States::get();
        //d($userId,1);
        if ($userId > 0) {
            if (Auth::user()->role->role == 'admin') {
                $data = User::join('address', 'address.user_id', '=', 'users.id')
                        ->leftJoin('countries as c', 'c.id', '=', 'address.country')
                        ->leftJoin('states as s', 's.id', '=', 'address.state')
                        ->select('users.*', 'address.phone', 'address.city', 'c.name as countryName', 's.name as stateName', 'address.address', 'address.zip', 'address.created_at', 'address.addressType', 'address.address2', 'address.mobile', 'address.status as addStatus')
                        ->where('users.id', '=', $userId)
                        ->where('address.user_id', '=', $userId)
                        ->whereNull('address.order_id')
                        ->first();
                
                $orders = Orders::where('orders.user_id', '=', $userId)
                        ->orderBy('orders.id', 'desc')
                        ->get();

                return view('admin.client', [
                    'data' => $data,
                    'orders' => $orders,
                    'countries' => $countries,
                    'states' => $states,
                ]);
            } else {
                return redirect('home');
            }
        } else {
            return redirect('home');
        }
    }

    public function delete($id, Request $request) {
        User::where('id', '=', $id)->delete();
        $request->session()->flash('success', 'Successfully Deleted!');
        return redirect()->back();
    }

    public function makeCollage(Request $request) {
        $data = array();
        //d($request->all(),1);
        //d(count($request->image),1);
        if (count($request->image) > 2) {

            $request->session()->flash('danger', 'Invalid selection!');
            return redirect()->back();
        }
        if (!empty($request->image)) {
            $keys = array_keys($request->image);
            if (isset($keys[0])) {
                $values[0] = array_values($request->image);
                $data['first'] = $values[0][0];
            }
            if (isset($keys[1])) {
                $values[1] = array_values($request->image);
                $data['second'] = $values[1][1];
            }
            return view('admin.collage.index', $data);
        }

        $request->session()->flash('danger', 'Invalid selection to compare images.');
        return redirect()->back();
        //d($data,1);
    }

    public function deleteResult($id, Request $request) {
        $results = Results::where('id', '=', $id)->first();

        if (isset($results->frontImage) && $results->frontImage != "") {
            $destinationPath = public_path() . '/uploads/users/results/front_images/';
            $destinationPathThumb = $destinationPath . 'thumbnail/';
            $destinationPathOrig = $destinationPath . 'original/';

            $file1 = $destinationPath . $results->frontImage;
            $file2 = $destinationPathThumb . $results->frontImage;
            $file3 = $destinationPathOrig . $results->frontImage;
            File::delete($file1, $file2, $file3);
        }
        if (isset($results->sideImage) && $results->sideImage != "") {
            $destinationPath = public_path() . '/uploads/users/results/side_images/';
            $destinationPathThumb = $destinationPath . 'thumbnail/';
            $destinationPathOrig = $destinationPath . 'original/';

            $file1 = $destinationPath . $results->sideImage;
            $file2 = $destinationPathThumb . $results->sideImage;
            $file3 = $destinationPathOrig . $results->sideImage;
            File::delete($file1, $file2, $file3);
        }
        if (isset($results->backImage) && $results->backImage != "") {
            $destinationPath = public_path() . '/uploads/users/results/back_images/';
            $destinationPathThumb = $destinationPath . 'thumbnail/';
            $destinationPathOrig = $destinationPath . 'original/';

            $file1 = $destinationPath . $results->backImage;
            $file2 = $destinationPathThumb . $results->backImage;
            $file3 = $destinationPathOrig . $results->backImage;
            File::delete($file1, $file2, $file3);
        }

        Results::where('id', '=', $id)->delete();
        $request->session()->flash('success', 'Successfully Deleted!');
        return redirect()->back();
    }

    public function deleteMealPlan($id, Request $request) {
        $mp = MealPlans::where('id', '=', $id)->first();

        $path = public_path() . '/uploads/users/meal-plans/';
        $file1 = $path . $mp->file;
        File::delete($file1);

        MealPlans::where('id', '=', $id)->delete();
        AthleteMp::where('mp_id', '=', $id)->delete();

        $request->session()->flash('success', 'Successfully Deleted!');
        return redirect()->back();
    }

    public function deleteWorkoutPlan($id, Request $request) {
        $wp = WorkoutPlans::where('id', '=', $id)->first();

        $path = public_path() . '/uploads/users/workout-plans/';
        $file1 = $path . $wp->file;
        File::delete($file1);

        MealPlans::where('id', '=', $id)->delete();
        AthleteWp::where('wp_id', '=', $id)->delete();

        $request->session()->flash('success', 'Successfully Deleted!');
        return redirect()->back();
    }

    public function available(Request $request, $id) {
        DB::table('users')->where('id', $id)->update([
            'availability' => 1,
            'updated_at' => date('Y-m-d'),
        ]);
        $request->session()->flash('alert-success', 'Successfully Updated!');
        return back();
    }

    public function unavailable(Request $request, $id) {
        DB::table('users')->where('id', $id)->update([
            'availability' => 0,
            'updated_at' => date('Y-m-d'),
        ]);
        $request->session()->flash('alert-success', 'Successfully Updated!');
        return back();
    }

}
