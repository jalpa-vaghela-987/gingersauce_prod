@extends('layouts.mail')
@section('content')
    <div class="content" style="text-align: center; padding: 50px 0 0 50px;">
        <div class="icon">
            <img src="{{asset('img/icon.png')}}" title="icon" alt="icon-image"/>
        </div>
        <div class="brand">Gingersauce</div>
        <div class="bold-text">Congrats!</div>
        <div class="bold-text">Your "{{$brandbook->brand}}" Brand Book is ready.</div>
        <div class="order-date" style="margin-top: 20px">To view it, please click on the button below.</div>
        <a href="{{route('brandbook.my')}}" class="change-pm-button" style="text-decoration: none;    color: white;    background: #29B473;    padding: 10px 50px;    border-radius: 5px;    margin-top: 20px;    display: inline-block;">View Brand Book</a>
        <div class="text">If you need any assistance please email us at support@gingersauce.co.</div>
        <div class="thanx" style="margin-top: 20px;">{{trans('mail.thx')}},</div>
        <div class="brand" style="margin-top: 0">Gingersauce</div>
        <div class="spice-up" style="border-top: 1px solid #C2C2C2; border-bottom: 1px solid #C2C2C2; font-family: Lobster; font-size: 40px; font-weight: 400;color: #DEDEDE; padding: 30px 0; margin-top: 20px ">Spice Up Your Brand</div>
        <div class="text">To unsubscribe from our mailing list please reply "Unsubscribe" </div>
    </div>
@endsection
