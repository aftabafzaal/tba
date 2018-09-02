<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\Countries;
use App\States;
use App\Ambassadors;
use App\AmbassadorsSubscriptions;
use App\Address;
use DB;
use App\Shows;
use App\MealPlans;
use App\AthleteMp;
use App\WorkoutPlans;
use App\AthleteWp;
use App\Results;
use App\Messages;
use Auth;
use Session;
use App\Certifications;
use App\Specialities;
use App\Functions\Functions;
use Illuminate\Http\Request;
use App\Functions\Payflow;
use File;

class ProfileController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index($id) {
        $auth_id = Auth::user()->id;
        $user_id = $id;
        $data['user'] = User::findOrFail($user_id);
        $data['shows'] = Shows::where('user_id', '=', $user_id)->get();
        $data['age'] = Functions::getAge($data['user']['dob']);

        if (isset($user->dob)) {
            list($year, $month, $date) = explode('-', $user->dob);
            $user->date = $date;
            $user->month = $month;
            $user->year = $year;
        }

        $exists = Ambassadors::where('user_id', '=', $id)->exists();
        $data['exists'] = $exists;
        $role = \App\Role::find($data['user']['role_id']);
        $data['role'] = $role->role;

        if ($exists) {
            $data['rate'] = Ambassadors::where('user_id', $id)->first();
        } else {
            $data['rate'] = NULL;
        }
        if (AmbassadorsSubscriptions::where('athlete_id', '=', $auth_id)->exists()) {
            $data['subscribed'] = AmbassadorsSubscriptions::where([
                        'athlete_id' => $auth_id,
                        'subscriptionStatus' => 1,
                    ])->first();
        } elseif (AmbassadorsSubscriptions::where('ambassador_id', '=', $auth_id)->exists()) {
            $data['subscribed'] = AmbassadorsSubscriptions::where([
                        'athlete_id' => $id,
                        'ambassador_id' => $auth_id,
                        'subscriptionStatus' => 1,
                    ])->first();
        } else {
            $data['subscribed'] = NULL;
        }
        $data['shows'] = Shows::where('user_id', '=', $user_id)
                ->orderBy('date', 'desc')
                ->first();
        //d($data['shows'],1);

        $data['states'] = States::get();
        $data['address'] = Address::where('user_id', '=', $user_id)->first();
        $data['countries'] = Countries::get();
        $data['speciality'] = DB::table('ambassadors_specialities')
                ->join('specialities', 'ambassadors_specialities.speciality_id', '=', 'specialities.id')
                ->select('specialities.id')
                ->where('ambassadors_specialities.ambassador_id', '=', $user_id)
                ->first();
        //d($data['speciality'],1);
        if (isset($data['speciality'])) {
            $data['specialities'] = Specialities::where('id', $data['speciality']->id)->first();
        } else {
            $data['specialities'] = NULL;
        }

        $data['certifications'] = Certifications::where('user_id', '=', $user_id)->first();
        //d($data['certifications'],1);
        $data['results'] = Results::
                where('user_id', '=', $user_id)
                ->orderBy('date', 'desc')
                ->get();
        $data['messages'] = Messages::get();
        $data['users'] = User::where('status', 1)->where('deleted', 0)->get();
        //d($results,1);
        $data['athleteWp'] = WorkoutPlans::join('athlete_wp', 'athlete_wp.wp_id', '=', 'workout_plans.id')
                ->select('workout_plans.*', 'athlete_wp.athlete_id as a_wid')
                ->where([
                    'athlete_wp.athlete_id' => $user_id,
                    'workout_plans.deleted' => 0,
                ])
                ->orderBy('athlete_wp.id', 'desc')
                ->get();
        $data['athleteMp'] = MealPlans::join('athlete_mp', 'athlete_mp.mp_id', '=', 'meal_plans.id')
                ->select('meal_plans.*', 'athlete_mp.athlete_id as a_mid')
                ->where([
                    'meal_plans.deleted' => 0,
                    'athlete_mp.athlete_id' => $user_id,
                ])
                ->orderBy('athlete_mp.id', 'desc')
                ->get();

        return view('front.profile.index', $data)->with('user_id', $user_id);
    }

    public function store(Request $request) {


        $currency = Config('params.currency_default');
        $rules = array(
            'cc' => 'required',
            'cvc' => 'required',
            'expMonth' => 'required',
            'expYear' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }


        $user_id = Auth::user()->id;
        $address = Address::where('user_id', '=', $user_id)->first();

        $PayFlow = new PayFlow(env('PAYFLOW_VENDOR'), env('PAYFLOW_PARTNER'), env('PAYFLOW_USER'), env('PAYFLOW_PASSWORD'), 'recurring');

        $PayFlow->setEnvironment(env('PAYFLOW_ENV'));                           // test or live
        $PayFlow->setTransactionType('R');
        $PayFlow->setPaymentMethod('C');
        $PayFlow->setPaymentCurrency($currency);
        $expDate = $request->expMonth . '' . substr($request->expYear, 2, 3);
        $PayFlow->setAmount($request->subscriptionRate, FALSE);
        $PayFlow->setCCNumber('4222222222222');
        //$PayFlow->setCCNumber($request->cc);
        $PayFlow->setCVV($request->cvc);
        $PayFlow->setExpiration($expDate);
        $PayFlow->setCreditCardName($request->name);

        // Only used for recurring transactions
        $PayFlow->setProfileAction('A');
        $PayFlow->setProfileName(Auth::user()->firstName . '_' . Auth::user()->lastName);
        $PayFlow->setProfileStartDate(date('mdY', strtotime("+1 day")));
        $PayFlow->setProfilePayPeriod('MONT');
        $PayFlow->setProfileTerm(0);

        $PayFlow->setCustomerFirstName(Auth::user()->firstName);
        $PayFlow->setCustomerLastName(Auth::user()->lastName);
        $PayFlow->setCustomerAddress($address->address . ' - ' . $address->address2);
        $PayFlow->setCustomerCity($address->city);
        $PayFlow->setCustomerState($address->state);
        $PayFlow->setCustomerZip($address->zip);
        $PayFlow->setCustomerCountry('US');
        $PayFlow->setCustomerPhone($address->phone);
        $PayFlow->setCustomerEmail(Auth::user()->email);
        $PayFlow->setPaymentComment('user ID # ' . Auth::user()->id);
        $PayFlow->setPaymentComment2('Subscribe to ' . $request->ambassador_id);

        if ($PayFlow->processTransaction()) {
            $response = $PayFlow->getResponse();
            d($response, 1);
            $model = new Transactions();
            $model->referenceId = $response['PNREF'];
            $model->gateway = 'payflow';
            $model->type_id = Auth::user()->id;
            $model->type = 'subscription';
            $model->amount = $request->subscriptionRate;
            $model->created_at = date('Y-m-d H:i:s');
            $model->save();

            $modelPaypal = new PaymentPayflow();
            $modelPaypal->transaction_id = $model->id;
            $modelPaypal->pnref = $response['PNREF'];
            $modelPaypal->ppref = $response['PPREF'];
            $modelPaypal->correlationId = $response['CORRELATIONID'];
            $model->created_at = date('Y-m-d H:i:s');
            $modelPaypal->save();

            $subscribed = new AmbassadorsSubscriptions;
            $subscribed->ambassador_id = $request->ambassador_id;
            $subscribed->athlete_id = $request->athlete_id;
            $subscribed->subscriptionRate = $request->subscriptionRate;
            $subscribed->subscriptionComission = $request->subscriptionComission;
            $subscribed->subscriptionDate = date('Y-m-d H:i:s');
            $subscribed->save();

            Session::flash('success', 'Successfully Subscribed.');
            return back();
        } else {
            $response = $PayFlow->getResponse();
            echo "response";
            d($response, 1);
            $response['RESPMSG'] = isset($response['RESPMSG']) ? $response['RESPMSG'] : "";
            $validator->errors()->add('error_response', $response['RESPMSG']);
            return redirect()->back()->withErrors($validator->errors());
        }
    }

    public function saveReview(Request $request) {
        //  d($_POST,1);
        $user_id = Auth::user()->id;
        $messages = new Messages;
        $messages->user_id = $user_id;
        $messages->message = $request->message;
        $messages->result_id = $request->result_id;
        $messages->type = $request->type;
        $messages->save();

        if ($user_id != $request->athlete_id) {
            $getAthlete = User::where('id', $request->athlete_id)->where('status', 1)->where('deleted', 0)->first();
            $getAmbassador = User::where('id', $request->ambassador_id)->where('status', 1)->where('deleted', 0)->first();

            $data['athleteName'] = $getAthlete->firstName . ' ' . $getAthlete->lastName;
            $data['ambassadorName'] = $getAmbassador->firstName . ' ' . $getAmbassador->lastName;

            //Email sent to Athlete that tells the Athlete, Coach has commented on his/her progress update
            $subjectAthlete = view('emails.post_comment_mailto_athlete.subject');
            $bodyAthlete = view('emails.post_comment_mailto_athlete.body', compact('data'));
            Functions::sendEmail($getAthlete->email, $subjectAthlete, $bodyAthlete);
        }

        $request->session()->flash('success', 'Successfully Submitted!');
        return redirect()->back();
    }

    public function update($id) {
        AmbassadorsSubscriptions::where('id', '=', $id)->update([
            'subscriptionStatus' => '2',
        ]);
        Session::flash('success', 'Successfully Unsubscribed.');
        return back();
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
            return view('front.collage.index', $data);
        }

        $request->session()->flash('danger', 'Invalid selection to compare images.');
        return redirect()->back();
        //d($data,1);
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

}
