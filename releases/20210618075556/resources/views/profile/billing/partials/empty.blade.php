<div class="empty-cards-wrapper">
    <div class="empty-cards-header">@lang('profile.no_payment_method')</div>
    <div class="empty-card-sub-header">{{trans('profile.payment_method_will_appear')}}</div>
    <div class="button-wrapper"><a class="add-payment-method" href="{{route('billing.create')}}">{{trans('profile.add_payment_method')}}</a></div>
    <img src="{{asset('images/card_types.jpg')}}" />
</div>
