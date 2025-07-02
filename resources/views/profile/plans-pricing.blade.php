@extends('layouts.app')

@section('content')
    @include('profile.sidebar')
    <div class="plans-container">
        <div class="row">
            <div class="col-4 no-gutters"><h1>@lang('profile.plans_and_pricing')</h1></div>
            <div class="col-8 no-gutters">
                <div class="switch-block my-3 d-flex justify-content-center">
                    <div class="font-weight-bold mx-2">
                        {{trans('general.monthly_billing')}}
                    </div>
                    <div>
                        <switch-toggle></switch-toggle>
                    </div>
                    <div class="font-weight-bold mx-2">{{trans('general.annual_billing')}}</div>
                    <div class="text-success"><i class="fa fa-check"></i>{{trans('general.youre_saving')}}</div>
                </div>
            </div>
        </div>
        <div class="plans-pricing-container row">
            <div class="col-4 no-gutters">
                <div class="plans-pricing-header row grey">
                    <div class="row" style="border: none">@lang('profile.avaiable_features')</div>
                </div>

                <div class="plans-row grey row text-center">@lang('profile.brand_books')</div>
                <div class="plans-row row">@lang('profile.book_storage')</div>
                <div class="plans-row grey row">@lang('profile.unlimited_editors')</div>
                <div class="plans-row row">@lang('profile.unlimited_sharing')</div>
                <div class="plans-row grey row">@lang('profile.pdf_version')</div>
                <div class="plans-row row">@lang('profile.brand_assets_download')</div>
                <div class="plans-row grey row">@lang('profile.personal_support')</div>
                <div class="plans-row row">@lang('profile.support')</div>
                <div class="plans-row row"></div>
            </div>
            @foreach($packages as $package)
                <div class="col-2 no-gutters">
                    <div class="plans-pricing-header">
                        <div class="row package-title" style="background-color: {{$package->color}}">
                            {{$package->name}}
                        </div>
                        <div class="row">
                            @if($package->price > 0)
                                <span class="currency-small">$</span>
                                <span class="price-bold">                                        <animated-integer
                                        value={{$package->annual_price}} contr_value={{$package->price}}></animated-integer></span>
                                <div class="price-a-month">
                                    @if($package->alias == 'free')
                                    @elseif($package->alias == 'brand_manager')
                                        /@lang('profile.one_time')
                                    @else
                                        /@lang('profile.month')
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <div
                        class="plans-row grey row">
                        @if($package->alias == 'free')
                            @lang('profile.personal_use_only')
                        @elseif($package->alias == 'brand_manager')
                            {{$package->credits}} @lang('profile.year')
                        @else
                            {{$package->credits}}(@lang('profile.every_month'))
                        @endif
                    </div>
                    <div class="plans-row row">
                        @if($package->alias == 'free')
                            14 @lang('days')
                        @elseif($package->alias == 'brand_manager')
                            1 @lang('year')
                        @else
                            @if($package->book_expiry == 12)
                                1 @lang('year')
                            @else
                                {{$package->book_expiry}} @lang('month')
                            @endif
                        @endif
                    </div>
                    <div
                        class="plans-row grey row">{!! $package->alias == 'free' ? '<i class="fas fa-times" style="color:red;"></i>' : '<i class="fas fa-check" style="color:#38f146"></i>'!!}</div>
                    <div
                        class="plans-row row">{!! $package->alias == 'free' ? '<i class="fas fa-times" style="color:red;"></i>' : '<i class="fas fa-check" style="color:#38f146"></i>' !!}</div>
                    <div
                        class="plans-row grey row">{!!$package->alias == 'free' ? '<i class="fas fa-times" style="color:red;"></i>' : '<i class="fas fa-check" style="color:#38f146"></i>'!!}</div>
                    <div
                        class="plans-row row">{!!$package->alias == 'free' ? '<i class="fas fa-times" style="color:red;"></i>' : '<i class="fas fa-check" style="color:#38f146"></i>'!!}</div>
                    <div
                        class="plans-row grey row">{!! $package->alias == 'brand_manager' ?  '<i class="fas fa-check" style="color:#38f146"></i>' : '<i class="fas fa-times" style="color:red;"></i>' !!}</div>
                    <div class="plans-row row">
                        @if($package->alias == 'free')
                            @lang('profile.community')
                        @elseif($package->alias == 'professional')
                            @lang('profile.by_email')
                        @else
                            @lang('profile.priority_support')
                        @endif
                    </div>
                    <div class="plans-row grey row">
                        @if($package->alias != 'free')
                            @if($has_active_package)
                                <button class="btn"
                                   style="background-color: {{$package->color}}; color: #fff;" data-toggle="modal"
                                   @if($active_package_alias == 'brand_manager')
                                        data-target="#already-has-package-modal-1"
                                   @else
                                        data-target="#already-has-package-modal-2"
                                    @endif
                                >{{__('Upgrade')}}
                                </button>
                            @else
                                <form action="{{route('invoice.create')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="package" value="{{$package->id}}">
                                    <input type="hidden" name="invoice_type" value="package"/>
                                    <hidden-input name="type"></hidden-input>
                                    <button class="btn"
                                            style="background-color: {{$package->color}}; color: #fff;">{{__('Upgrade')}}
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('modals')
    <div class="modal" id="already-has-package-modal-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">@lang('profile.already_have_plan')</div>
                <div class="modal-body">@lang('profile.please_use_credit')</div>
                <div class="modal-footer">
                    <a class="btn btn-danger" href="{{route('brandbook.my')}}"
                       id="confirm-delete-pm">@lang('profile.my_brandbooks')</a>
                    <button type="button" class="btn btn-outline-secondary"
                            data-dismiss="modal">@lang('profile.cancel')
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="already-has-package-modal-2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">@lang('profile.already_have_plan')</div>
                <div class="modal-body">@lang('profile.in_order_to_upgrade')</div>
                <div class="modal-footer">
                    <a class="btn btn-danger" href="{{route('profile.plans')}}"
                       id="confirm-delete-pm">@lang('profile.my_plans_page')</a>
                    <button type="button" class="btn btn-outline-secondary"
                            data-dismiss="modal">@lang('profile.cancel')
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
