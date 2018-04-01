<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 3/31/18
 * Time: 6:58 PM
 */

namespace App\Models;


use App\User;
use Illuminate\Support\Facades\Auth;
use App\UserInterests;
use DB;

class Profile
{
    public function updateUserDetails($name, $bio, $email, $school){
        $id = Auth::user()->id;
        $user = User::find($id);
        if(isset($name)){
            if(strpos($name,' ') === false){
                $user->first_name = $name;
            }else{
                $name = explode(' ', $name);
                $user->first_name = $name[0];
                $user->last_name = $name[1];
            }
        }else {
            $user->first_name = '';
            $user->last_name = '';
        }
        $user->email = isset($email)?$email:"";
        $user->short_bio = isset($bio)?$bio:"";
        $user->school = isset($school)?$school:" ";
        $result =$user->save();

        return $result;
    }

    public function updateUserInterests($interests){
        $email = Auth::user()->email;
        $result = null;
        $userInterests = new UserInterests;
        foreach ($interests as $interest => $condition){
            if($condition === true){
                $userInterests->email = $email;
                $userInterests->interest = $interest;
                $userInterests->save();
            }else{
                UserInterests::where('email', $email)
                    ->where('interest', $interest)
                    ->delete();
            }
        }

        return $result;
    }
}