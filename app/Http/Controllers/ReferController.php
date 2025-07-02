<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Referrers;
use Mail;
use App\Mail\ReferAFriend;
use Auth;
use App\User;

class ReferController extends Controller
{
    public function refer(Request $request){
    	if(Auth::check()){
            if(!User::where('email', $request->email)->exists()){
                $link = $this->get_link();
                Referrers::create(['email'=>$request->email, 'user_id'=>Auth::id(), 'link'=>$link]);
                Mail::to($request->email)->send(new ReferAFriend(Auth::user(), route('user.invite', $link)));
                return response(':)');
            }else{
                return response('exists');
            }
    	}
    }

    public function invite(string $link){
    	$ref = Referrers::where('link', $link)->firstOrFail();
        session(['ginger.referrer'=>$ref->id, '_old_input.email'=>$ref->email]);
        return redirect()->route('register');
    }

    public function get_link(){
    	return sha1(time());
    }
}
