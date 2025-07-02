<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller {
    public function store( Request $request ) {
        if(empty($request->feedback)){
            return redirect()->back()->with( [ 'error' => 'Error' ] );
        }
        $user = \Auth::user();
        $user->feedback()->create( $request->all() );
        \Mail::raw( $request->feedback, function ( $message ) use ( $user ) {
            $message->from( $user->email );
            $message->to( 'support@gingersauce.co' );
            $message->subject( 'Feedback from user ' . $user->name );
        } );
        return redirect()->back()->with( [ 'message' => trans( 'general.feedback_sent' ) ] );
    }
}
