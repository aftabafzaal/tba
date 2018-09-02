<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MealPlans;
use App\Functions\Functions;

class MealPlanReminderToCoach extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mealplan:remindertocoach';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'After 28 Days Meal Plan Reminder To The Coach To Update.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
//        echo 'Hello World';
        $dateTime = date('Y-m-d H:i:s', strtotime('-28 day'));
        $mealPlans = MealPlans::join('athlete_mp as amp', 'mp_id', '=', 'meal_plans')
                ->select('meal_plans.*', 'amp.*')
                ->where('meal_plans.deleted',0)
                ->where('amp.created_at', '=', $dateTime)
                ->get();
        foreach ($mealPlans as $row) {
            $user = User::where('id', $row->user_id)->first();
                $subject = view('emails.crons.user_register_one_day.subject');
                $body = view('emails.crons.user_register_one_day.body', compact('value'));
                Functions::sendEmail($value->email, $subject, $body);
        }





        $adminUser = User::where('role_id', 1)->get();
        foreach ($adminUser as $value) {
            
        }
    }

}
