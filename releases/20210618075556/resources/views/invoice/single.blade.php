@extends('layouts.app')

@section('content')
    <div style="overflow: auto; height: calc(100vh - 50px)">
        <div class="container" id="invoice-checkout">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs my-3">
                        <div class="item"><a
                                href="{{route('profile.plans-pricing')}}">{{trans('general.view_cart')}}</a></div>
                        <div class="item current">{{trans('general.checkout')}}</div>
                        <div class="item">{{trans('general.confirmation')}}</div>
                    </div>
                </div>
            </div>
            <form action="{{route('invoice.checkout', $invoice)}}" method="post">
                @csrf
                <div class="row" id="my-brandbooks">
                    @if($errors->any())
                        <div class="col-12">
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{$error}}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="col-6">
                        <checkout
                            :id="{{$invoice->id}}"
                            :user_id="{{Auth::id()}}"
                            cvc_img="{{asset('/images/cvc.png')}}"
                            cards="{{asset('/images/payments.png')}}"
                            {{$invoice->token_id ? 'token' : ''}}
                            card_type="{{$card_type}}"
                            last_4="{{$last_4}}"
                        >
                        </checkout>
                    </div>
                    <div class="col-6">
                        <h1 class="mb-2">{{trans('general.order_summary')}}</h1>
                        <order-summary
                            name="{{$order['name']}}"
                            :credits="{{$order['credits']}}"
                            :extend_duration="{{intval($order['extend_duration'])}}"
                            upper_title="{{$order['upper_title']}}"
                            :price="{{$invoice->price}}"
                            {{!empty($order['refund']) ? 'refund' : ''}}
                            refund_name="{{$order['refund_name'] ?? ''}}"
                            refund_upper_title="{{$order['refund_title'] ?? ''}}"
                            :refund_price="{{$order['refund_cost'] ?? 0}}">
                        </order-summary>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
