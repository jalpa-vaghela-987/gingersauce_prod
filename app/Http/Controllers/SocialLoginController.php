<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\User;
use Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered;

class SocialLoginController extends Controller {
    //
    public function callback( $provider ) {
        $driver = Socialite::driver( $provider );

        if ( $provider == 'facebook' ) {
            $driver->usingGraphVersion( 'v6.0' );
        }

        $getInfo = $driver->stateless()->user();
        list($user, $is_new) = $this->createUser( $getInfo, $provider );

        auth()->login( $user );
        if($is_new){
            return view( 'auth.callback', ['route' => route('profile.start')] );
        } else {
            return view( 'auth.callback', ['route' => route('brandbook.my')] );
        }
    }

    public function redirect( $provider ) {
        $driver = Socialite::driver( $provider );

        if ( $provider == 'facebook' ) {
            $driver->usingGraphVersion( 'v6.0' );
        }

        return $driver->stateless()->redirect();
    }

    public function createUser( $getInfo, $provider ) {
        $user       = User::where( 'provider_id', $getInfo->id )->first();
        $email_user = User::where( 'email', $getInfo->email )->whereNotNull( 'email' )->first();
        $is_new     = false;
        if ( $email_user ) {
            $fileContents = file_get_contents( $getInfo->getAvatar() );
            Storage::put( 'avatars/' . $provider . '_' . $getInfo->id . '.jpg', $fileContents );
            $fileContents = file_get_contents( $getInfo->avatar_original );
            Storage::put( 'avatars/original/' . $provider . '_' . $getInfo->id . '.jpg', $fileContents );
            $email_user->avatar          = str_replace( 'public/', '/', Storage::url( 'avatars/' . $provider . '_' . $getInfo->id . '.jpg' ) );
            $email_user->avatar_original = str_replace( 'public/', '', Storage::url( 'avatars/original/' . $provider . '_' . $getInfo->id . '.jpg' ) );
            $email_user->save();
            return [$email_user, $is_new];
        }
        if ( !$user ) {
            $fileContents = file_get_contents( $getInfo->getAvatar() );
            Storage::put( 'avatars/' . $provider . '_' . $getInfo->id . '.jpg', $fileContents );
            $fileContents = file_get_contents( $getInfo->avatar_original );
            Storage::put( 'avatars/original/' . $provider . '_' . $getInfo->id . '.jpg', $fileContents );
            $user = User::create( [
                'name'            => $getInfo->name,
                'email'           => $getInfo->email,
                'password'        => Hash::make( uniqid() ),
                'provider'        => $provider,
                'provider_id'     => $getInfo->id,
                'avatar'          => str_replace( 'public/', '/', Storage::url( 'avatars/' . $provider . '_' . $getInfo->id . '.jpg' ) ),
                'avatar_original' => str_replace( 'public/', '', Storage::url( 'avatars/original/' . $provider . '_' . $getInfo->id . '.jpg' ) )
            ] );
            event( new Registered( $user ) );
            $is_new = true;
        }
        return [ $user, $is_new ];
    }
}
