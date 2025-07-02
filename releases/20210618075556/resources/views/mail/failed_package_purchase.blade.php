@extends('layouts.mail')
@section('content')
    <div class="content" style="text-align: center; padding: 50px 0 0 50px;">
        <div class="icon">
            <img src="{{asset('img/icon.png')}}" title="icon" alt="icon-image"/>
        </div>
        <div class="brand">Gingersauce</div>
        <div class="bold-text">{{trans('mail.we_have_problems')}}</div>
        <div class="order-date" style="margin-top: 20px">{{trans('mail.ordered_on', ['date' => date('F j, Y')])}}</div>
        <div class="text">{!! trans('mail.to_avoid') !!}</div>
        <a href="{{route('billing.index')}}" class="change-pm-button" style="text-decoration: none;    color: white;    background: #29B473;    padding: 10px 50px;    border-radius: 5px;    margin-top: 20px;    display: inline-block;">{{trans('mail.change_payment_method_here')}}</a>
        <div class="text">{{trans('mail.if_after_cancel')}}</div>
        <div class="thanx" style="margin-top: 20px;">{{trans('mail.thx')}},</div>
        <div class="brand" style="margin-top: 0">Gingersauce</div>
        <div class="spice-up" style="border-top: 1px solid #C2C2C2; font-family: Lobster; font-size: 40px; font-weight: 400;color: #DEDEDE; padding-top: 30px; margin-top: 20px ">Spice Up Your Brand</div>
    </div>
@endsection
