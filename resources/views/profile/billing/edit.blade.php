@extends('layouts.app')

@section('content')
    @include('profile.sidebar')
    <div class="billing-wrapper">
        <h1>@lang('profile.billing')</h1>
        <cc-form :user_id="{{Auth::id()}}" cvc_img="{{asset('/images/cvc.png')}}"
                 cards="{{asset('/images/payments.png')}}" cancel_href="{{route('billing.index')}}"></cc-form>
    </div>
@endsection
