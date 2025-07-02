<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Share;
use Auth;
use App\Brandbook;
use App\User;
use Mail;
use App\Mail\ShareByEmailNotification;

class ShareController extends Controller {
    public function load( Request $request ) {

        if ( Auth::check() ) {
            $bb     = Brandbook::find( $request->id );
            $shares = Share::where( 'brandbook_id', $request->id )->get();
            return response()->json( [
                'shares'   => $shares->map( function ( $item ) {

                    if ( $item->user != null ) {
                        $item->user->avatar = url( $item->user->avatar );
                    }
                    return $item;
                } ),
                'owner_id' => Brandbook::findOrFail( $request->id )->user_id,
                'user_id'  => Auth::user()->id,
                'can_edit' => ( Auth::user()->can_do( 'edit', $bb ) ),
            ] );
        }
    }

    public function add( Request $request ) {

        if ( Auth::check() ) {
            $bb = Brandbook::find( $request->id );
            if ( $request->action == 'edit' && !Auth::user()->can_do( 'edit', $bb ) ) {
                throw new \Exception( 'You don\'t have access' );
            }

            if ( User::where( 'email', $request->email )->exists() ) {
                $user             = User::where( 'email', $request->email )->firstOrFail();
                $sh               = new Share;
                $sh->user_id      = $user->id;
                $sh->owner_id     = Auth::user()->id;
                $sh->brandbook_id = $request->id;
                $sh->action       = $request->action;
                $sh->save();
            } else {
                $sh               = new Share;
                $sh->user_email   = $request->email;
                $sh->owner_id     = Auth::user()->id;
                $sh->brandbook_id = $request->id;
                $sh->action       = $request->action;
                $sh->save();
            }
            //send email notification
            Mail::to( $request->email )->send( new ShareByEmailNotification( Auth::user(), Brandbook::findOrFail( $request->id ), route( 'brandbook.shared', $this->get_link( $request ) ) ) );
            return 'success';
        }
    }

    public function edit( Request $request ) {

        if ( Auth::check() ) {
            $bb = Brandbook::find( $request->id );
            if ( $request->action == 'edit' && !Auth::user()->can_do( 'edit', $bb ) ) {
                throw new \Exception( 'You don\'t have access' );
            }
            $share         = Share::where( 'brandbook_id', $request->id )->where( 'user_id', $request->user_id )->firstOrFail();
            $share->action = $request->action;
            $share->save();
        }
    }

    public function delete( Request $request ) {

        if ( Auth::check() ) {
            $bb = Brandbook::findOrFail( $request->id );
            if ( $bb->user_id == Auth::user()->id ) {
                $sh = Share::where( 'owner_id', Auth::user()->id )->where( 'user_id', $request->user_id )->firstOrFail();
                $sh->delete();
            }
        }
    }

    public function get_link( Request $request ) {

        $bb = Brandbook::findOrFail( $request->id );

        if ( empty( $bb->shared_link ) ) {
            $bb->shared_link = sha1( time() );
            $bb->save();
        }

        return $bb->shared_link;
    }


    public function link( Request $request ) {

        if ( Auth::check() ) {
            $link = $this->get_link( $request );
            return response( route( 'brandbook.shared', $link ) );
        }
    }

    public function code( Request $request ) {

        if ( Auth::check() ) {
            $bb = Brandbook::findOrFail( $request->id );
            if ( empty( $bb->shared_link ) ) {
                $bb->shared_link = sha1( time() );
                $bb->save();
            }
            $code = "<script src='" . route( 'brandbook.embed', $bb->shared_link ) . "'></script><div id='gsec'></div>";
            return response( $code );
        }
    }
}
