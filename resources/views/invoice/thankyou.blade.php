@extends('layouts.app')

@section('content')
    <div style="overflow: auto; height: calc(100vh - 50px)">
        <div class="container" id="invoice-checkout">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs my-3">
                        <div class="item"><a
                                href="{{route('profile.plans-pricing')}}">{{trans('general.view_cart')}}</a></div>
                        <div class="item">{{trans('general.checkout')}}</div>
                        <div class="item current">{{trans('general.confirmation')}}</div>
                    </div>
                </div>
            </div>
            @if($errors->any())
                <h4>{{$errors->first()}}</h4>
            @endif
            <form action="{{route('invoice.checkout', $invoice)}}" method="post">
                @csrf
                <div class="row justify-content-center" id="my-brandbooks">
                    <div class="col-6 text-center mt-5">
                        <h1>{{trans('general.order_confirmation')}}</h1>
                        <p class="mb-3"><strong>
                                {{trans('general.thank_you_for_purchase', ['description' => $invoice->description])}}
                            </strong></p>
                        <p class="mb-3"><small>
                            {{trans('general.a_new_invoice_has_been_sent')}}
                            </small></p>
                        <p>
                            <a href="{{route('brandbook.my')}}" class="btn btn-danger">
                                {{trans('general.go_to_my')}}
                            </a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
