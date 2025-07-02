<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Share;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/profile/start';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],//, 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $shares = Share::where('user_email', $data['email'])->get();

        foreach($shares as $share){
            $share->user_id = $user->id;
            $share->save();
        }

        if(session()->has('url.ginger.shared'))
            $this->redirectTo = session('url.ginger.shared');

        return $user;
    }

//     public function register(Request $request)
//     {
//         $this->validator($request->all())->validate();
//
//         $user = $this->create($request->all());
//
//         $shares = Share::where('user_email', $request->email)->get();
//
//         foreach($shares as $share){
//             $share->user_id = $user->id;
//             $share->save();
//         }
//
//
//         dd($this->registered($request, $user));
//         return $this->registered($request, $user) ?: redirect($this->redirectTo);
//     }


    // public function postRegister(Request $request)
    //  {
    //     $validator = $this->registrar->validator($request->all());
    //     if ($validator->fails())
    //     {
    //         $this->throwValidationException(
    //             $request, $validator
    //         );
    //     }
    //     $this->auth->login($this->registrar->create($request->all()));

    //     $shares = Share::where('user_email', $request->email)->get();

    //     foreach($shares as $share){
    //         $share->user_id = Auth::id();
    //         $share->save();
    //     }
    //     // Now you can redirect!
    //     return redirect($this->redirectTo);
    //  }

}
