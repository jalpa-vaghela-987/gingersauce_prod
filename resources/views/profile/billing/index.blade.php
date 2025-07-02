@extends('layouts.app')

@section('content')
    @php
        $user = Auth::user();
    @endphp
    @include('profile.sidebar')
    @if($cards->isNotEmpty())
        <div class="card-wrapper">
            <h1>@lang('profile.billing')</h1>
            <h2>@lang('profile.payment_methods')</h2>
            @foreach($cards as $card)
                <payment-method
                    :_collapsed="{{$loop->first ? 1 : 0}}"
                    :id="{{$card->id}}"
                    :_is_default="{{$card->default}}"
                    card_type='{{ucfirst(strtolower($card->cc_card_type))}}'
                    last4="{{substr($card->buyer_card_mask, -4)}}"
                    card_name="{{$card->name_on_card}}"
                    make_default_href="{{route('billing.make_default', $card->id)}}"
                    delete_href="{{route('billing.destroy', $card->id)}}"
                    create_href="{{route('billing.create')}}"
                ></payment-method>
            @endforeach

            <div class="row no-gutters" style="border-top: 1px solid #c7c7c7; width: 50%">
                <a class="add-payment-method" href="{{route('billing.create')}}">@lang('profile.add_payment_method')</a>
            </div>
            @if(!empty($user_info))
                <div class="billing-information">
                    <h2>@lang('profile.billing_information')</h2>
                    <div class="billing-info-wrapper">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-11">
                                <div class="card-info-label">@lang('profile.billing_address')</div>
                                <div class="card-info-value">{{ $user_info['address_1'] ?? ''}}</div>
                                <div class="card-info-value">{{ $user_info['address_2'] ?? ''}}</div>
                                <div class="card-info-value">{{ $user_info['address_3'] ?? ''}}</div>
                                <div class="edit-card-wrap" style="margin-top: 20px">
                                    <a href="{{route('billing.edit', Auth()->user()->id)}}" class="card-info-actions"
                                       style="margin-top: 20px">@lang('profile.edit')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @else
        @include('profile.billing.partials.empty')
    @endif
    @include('billing.buy_plan')
@endsection

@section('modals')
    <div class="modal" id="modal-confirm-delete-pm">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">{{trans('profile.delete_card')}}</div>
                <div class="modal-body">{{trans('profile.are_you_sure_del_card')}}</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                            data-dismiss="modal">{{trans('profile.cancel')}}</button>
                    <a type="button" class="btn btn-outline-secondary"
                       id="confirm-delete-pm">{{trans('profile.delete_card')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

