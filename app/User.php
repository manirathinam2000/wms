<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','username', 'email', 'password', 'new_password','role_users_id','contact_no','profile_photo','profile_bg','is_active','last_login_ip','last_login_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


	public function RoleUser()
	{
		// return $this->hasone('App\Role_User','id',"role_users_id");
        return $this->hasone('Spatie\Permission\Models\Role','id',"role_users_id");
	}

//	public function scopeActive($query)
//	{
//		return $query->where('is_active',1);
//	}
//	public function scopeMonthly($query)
//	{
//		return $query->whereMonth('created_at','4');
//	}



	public function getLastLoginDateAttribute($value)
	{
		if ($value)
		{
			return Carbon::parse($value)->format(env('Date_Format').'--H:i');
		}
		else {
			return null;
		}
	}

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function checkToken($token){
        if($token->token){
            return true;
        }
        return false;
    }
    public static function getCurrentUser($request){
        if(!User::checkToken($request)){
            return response()->json([
             'message' => 'Token is required'
            ],422);
        }
         
        $user = JWTAuth::parseToken()->authenticate();
        return $user;
     }

}


