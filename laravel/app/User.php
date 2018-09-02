<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the phone record associated with the user.
     */
    public function role() {
        return $this->belongsTo('App\Role');
    }

    public function cafe() {
        return $this->hasOne('App\Cafe', 'created_by_user', 'id');
    }

    public static function unassignedAthlete() {

        $query = "SELECT * from users u where u.role_id=2 and u.status=1  and u.id not in (select athlete_id from ambassadors_subscriptions where `subscriptionStatus` = '1') ORDER BY u.id DESC";
        $result = DB::select($query);
        return $result;
    }

}
