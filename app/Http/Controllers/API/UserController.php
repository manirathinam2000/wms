<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Attendance;
use Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use DB;
use Mail;
use App\Mail\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->guard = "api"; // add
    }

    public function register(Request $request){
        $plainPassword=$request->password;
        $password=bcrypt($request->password);
        $request->request->add(['password' => $password]);
        // create the user account 
        $created=User::create($request->all());
        $request->request->add(['password' => $plainPassword]);
        // login now..
        return $this->login($request);
    }

    public function clients()
	{
		
        $data = User::where('role_users_id', '3')->take('100')->get();

        return response()->json($data);
		
	}

    public function employees()
	{
		
        //$data = User::where('role_users_id', '2')->take('100')->get();

        $data = DB::select("SELECT u.*, a.attendance_date, a.latitude, a.longitude FROM users u left join (SELECT t1.* FROM attendances t1 WHERE t1.id = (SELECT MAX(t2.id) FROM attendances t2 WHERE t2.employee_id = t1.employee_id)) as a ON a.employee_id = u.id");

        return response()->json($data);
		
	}



    public function login(Request $request, $role_id)
    {
        
        /*$input = $request->only('username', 'password');
        $jwt_token = null;
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Username or Password',
            ], 401);
        }
        // get the user 
        $user = Auth::user();*/

        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            //return response()->json($validator->errors(), 422);
            return response()->json([
                'success' => false,
                'message' => 'Invalid Username or Password',
            ], 401);
        }

        $user = User::where([
            'username' => $request->username,
            'role_users_id' => $role_id,
        ])->first();

        if($user){

            if(Hash::check($request->password, $user->password)){

                $jwt_token = JWTAuth::fromUser($user);
            
                return response()->json([
                    'success' => true,
                    'token' => $jwt_token,
                    'user' => $user
                ]);

            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid Username or Password',
        ], 401);
    }
    public function login_customer(Request $request)
    {
        
        /*$input = $request->only('username', 'password');
        $jwt_token = null;
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Username or Password',
            ], 401);
        }
        // get the user 
        $user = Auth::user();*/

        $validator = Validator::make($request->only('username', 'password'), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            //return response()->json($validator->errors(), 422);
            return response()->json([
                'success' => false,
                'message' => 'Invalid Username or Password',
            ], 401);
        }

        $user = User::where([
            'username' => $request->username,
            'role_users_id' => 3,
        ])->first();

        if($user){

            if(Hash::check($request->password, $user->password)){
                $myTTL = 365 * 24 * 60;
                JWTAuth::factory()->setTTL($myTTL);
                $jwt_token = JWTAuth::fromUser($user);
            
                return response()->json([
                    'success' => true,
                    'token' => $jwt_token,
                    'user' => $user
                ]);

            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid Username or Password',
        ], 401);
    }

    public function login_emp(Request $request)
    {
        
        /*$input = $request->only('username', 'password');
        $jwt_token = null;
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Username or Password',
            ], 401);
        }
        // get the user 
        $user = Auth::user();*/

        $validator = Validator::make($request->only('username', 'password'), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            //return response()->json($validator->errors(), 422);
            return response()->json([
                'success' => false,
                'message' => 'Invalid Username or Password',
            ], 401);
        }

        $user = User::where([
            'username' => $request->username,
            'role_users_id' => 2,
        ])->first();

        if($user){

            if(Hash::check($request->password, $user->password)){
                $myTTL = 3000;
                JWTAuth::factory()->setTTL($myTTL);
                $jwt_token = JWTAuth::fromUser($user);
            
                return response()->json([
                    'success' => true,
                    'token' => $jwt_token,
                    'user' => $user
                ]);

            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid Username or Password',
        ], 401);
    }

    public function login_admin(Request $request)
    {
        
        /*$input = $request->only('username', 'password');
        $jwt_token = null;
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Username or Password',
            ], 401);
        }
        // get the user 
        $user = Auth::user();*/

        $validator = Validator::make($request->only('username', 'password'), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            //return response()->json($validator->errors(), 422);
            return response()->json([
                'success' => false,
                'message' => 'Invalid Username or Password',
            ], 401);
        }

        $user = User::where([
            'username' => $request->username,
            'role_users_id' => 1,
        ])->first();

        if($user){

            if(Hash::check($request->password, $user->password)){
                $myTTL = 3000;
                JWTAuth::factory()->setTTL($myTTL);
                $jwt_token = JWTAuth::fromUser($user);
            
                return response()->json([
                    'success' => true,
                    'token' => $jwt_token,
                    'user' => $user
                ]);

            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid Username or Password',
        ], 401);
    }

    public function logout(Request $request)
    {
        if(!User::checkToken($request)){
            return response()->json([
             'message' => 'Token is required',
             'success' => false,
            ],422);
        }
        
        try {
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    public function getCurrentUser(Request $request){
        if(!User::checkToken($request)){
           return response()->json([
            'message' => 'Token is required'
           ],422);
        }
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user is be logged out'
            ], 500);
        }
       // add isProfileUpdated....
       $isProfileUpdated=false;
        if($user->isPicUpdated==1 && $user->isEmailUpdated){
            $isProfileUpdated=true;
            
        }
        $user->isProfileUpdated=$isProfileUpdated;

        return $user;
}

   
public function update(Request $request){
    $user=$this->getCurrentUser($request);
    if(!$user){
        return response()->json([
            'success' => false,
            'message' => 'User is not found'
        ]);
    }
   
    unset($data['token']);

    $updatedUser = User::where('id', $user->id)->update($data);
    $user =  User::find($user->id);

    return response()->json([
        'success' => true, 
        'message' => 'Information has been updated successfully!',
        'user' =>$user
    ]);
}



}