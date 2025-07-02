@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="hero">
            <div class="display-hero-lobster text-center text-lg-left mt-5">
                {{__('Spice Up Your Brand')}}
            </div>
            <div class="display-hero-subline my-4 text-center text-lg-left">
                {{__('Create, Manage & Present')}}<br>{{__('Digital Brand Books')}}
            </div>
            <div class="button mt-4">
                <button class="btn btn-success" data-toggle="modal" data-target="#signupModal">{{__('Try it for free')}}</button>
            </div>
        </div>
    </div>
@endsection