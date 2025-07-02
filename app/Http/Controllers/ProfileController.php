<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Auth;
use App\Package;
use App\User;
use App\CreditLog;
use NZTim\Mailchimp\Mailchimp;

class ProfileController extends Controller{
    public function index(){

        return view( 'profile.index' )->with( [ 'user' => Auth::user() ] );
    }

    public function start(){

        return view( 'profile.start' )->with( [ 'user' => Auth::user() ] );
    }

    public function plans_pricing(){

        return view( 'profile.pricing' )->with(
            [
                'packages'             => Package::with( 'translations' )->orderBy( 'position', 'asc' )->get(),
            ] );
    }

    public function save( Request $request ){

        if ( Auth::check() && Auth::user()->id == $request->user_id ){
            $user = Auth::user();
            if ( $user->email != $request->email_mf_da ){
                $request->validate( [ 'email_mf_da' => 'email|unique:users,email' ] );
            }

            $user->name     = $request->name;
            $user->position = $request->position;
            if ( !$request->has( 'from_start' ) ){
                $user->email           = $request->email_mf_da;
                $user->description     = $request->description;
                $user->company_web     = $request->company_web;
                $user->company_dribble = $request->company_dribble;
                $user->company_behance = $request->company_behance;
                $user->company_phone   = $request->company_phone;
                $user->company_email   = $request->company_email;
                $user->company         = $request->company;
                $user->location        = $request->location;
                $user->linkedin        = $request->linkedin;
                $user->twitter         = $request->twitter;
            }
            $user->save();
        }
        if ( $request->has( 'from_start' ) )
            return redirect()->route( 'brandbook.my' );
        return redirect()->back();
    }

    public function upload_avatar( Request $request ){

        if ( Auth::check() ){
            $user_id       = Auth::user()->id;
            $uploaded_file = $request->file( 'file' );
            $file_name     = '_avatar_'.time().'.jpg';
            $file          = Storage::putFileAs( 'avatars/' . $user_id, $uploaded_file, $file_name );
            // $file = Storage::get('/avatars/'.$user_id.'/'.$file_name);
            $user         = Auth::user();
            $user->avatar = url( 'storage/' . $file );
            $user->save();
            return response()->json( [
                                         'file'   => $user->avatar,
                                         'avatar' => true
                                     ] );
        }
        return response()->json( [] );
    }

    public function upload_logo( Request $request ){

        if ( Auth::check() ){
            $user_id                 = Auth::user()->id;
            $uploaded_file           = $request->file( 'file' );
            $file_name               = '_logo.svg';
            $file                    = Storage::putFileAs( '/logos/' . $user_id, $uploaded_file, $file_name );
            $file                    = Storage::get( '/logos/' . $user_id . '/' . $file_name );
            $user                    = Auth::user();
            $user->company_logo_full = 'data:image/svg+xml;base64,' . base64_encode( $file );
            $file                    = preg_replace( '/#([0-9A-Za-z]{3,6})/m', '#ffffff', $file );
            $user->company_logo      = 'data:image/svg+xml;base64,' . base64_encode( $file );
            $user->save();
            return response()->json( [
                                         'file'   => $user->company_logo_full,
                                         'avatar' => false
                                     ] );
        }
        return response()->json( [] );
    }

    public function plans(){

        echo 'plans';
    }

    public function change_credits( Request $request ){

        if ( Auth::check() ){
            $user               = User::findOrFail( $request->user_id );
            $user->left_credits += $request->credits;
            $user->save();
            CreditLog::create( [
                                   'comment' => $request->comment,
                                   'credits' => $request->credits,
                                   'type'    => 'manually given by admin',
                                   'user_id' => $request->user_id,
                               ] );

            $mc_list = config( 'services.mc.list' );
            $mc_key  = config( 'services.mc.key' );

            $server = explode( '-', $mc_key );
            $server = $server[ 1 ];

            $ch = curl_init();

            curl_setopt( $ch, CURLOPT_URL, "https://{$server}.api.mailchimp.com/3.0/lists/" . $mc_list . '/members/' . md5( $user->email ) );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PUT' );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, '{"email_address": "' . $user->email . '", "status_if_new": "subscribed", "merge_fields": {"CRCH": "' . $request->credits . '", "CRLE":"' . $user->left_credits . '", "CRCO": "' . $request->comment . '"}}' );

            $headers   = array();
            $headers[] = 'Authorization: Basic ' . $mc_key;
            $headers[] = 'Content-Type: application/json';
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

            $result = curl_exec( $ch );

            curl_close( $ch );


            $ch = curl_init();

            curl_setopt( $ch, CURLOPT_URL, "https://{$server}.api.mailchimp.com/3.0/lists/" . $mc_list . '/members/' . md5( $user->email ) . '/events' );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_POST, 1 );

            curl_setopt( $ch, CURLOPT_POSTFIELDS, "{\"email_address\": \"" . $user->email . "\", \"name\": \"credit_changed\"}" );

            $headers   = array();
            $headers[] = 'Authorization: Basic ' . $mc_key;
            $headers[] = 'Content-Type: application/json';
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

            $result = curl_exec( $ch );

            curl_close( $ch );
            return redirect()->back();
        }
    }
}
