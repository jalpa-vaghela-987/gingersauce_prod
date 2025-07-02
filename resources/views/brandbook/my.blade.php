@extends('layouts.app')
@section('content')
    @php
        $user = Auth::user();
    @endphp
    <div class="container-fluid" style="height: calc(100vh - 50px);overflow: auto;">
        <div class="row" id="my-brandbooks">
            @include('parts.aside.user')
            <div class="col-9 px-5 margined">
                <div class="row pt-5 pb-2">
                    <div class="col-8"><h1>{{__('My Brandbooks')}}</h1></div>
                    <?php
                    /*<div class="col-4 col-md-5 col-lh-6 d-none d-md-block">
                        <a href="{{route('brandbook.my')}}"
                        class="btn {{'btn-'}}@if(!empty($draft_filter)){{'outline-'}}@endif{{'secondary'}} font-weight-bold py-0 px-4"
                        style="border-radius: 30px;border-width: 2px;">
                            {{ __('All') }}</a>
                        <a href="{{route('brandbook.my')}}?draft_filter=draft"
                        class="btn {{'btn-'}}@if(empty($draft_filter) || $draft_filter!='draft'){{'outline-'}}@endif{{'secondary'}} font-weight-bold  py-0 px-4"
                        style="border-radius: 30px; border-width: 2px;">
                            {{ __('Draft') }}
                        </a>
                        <a href="{{route('brandbook.my')}}?draft_filter=official"
                        class="btn {{'btn-'}}@if(empty($draft_filter) || $draft_filter!='official'){{'outline-'}}@endif{{'secondary'}} font-weight-bold  py-0 px-4"
                        style="border-radius: 30px; border-width: 2px;">
                            {{ __('Official') }}</a>
                    </div>*/?>
                    <div class="col-4 col-md-3 col-lg-2 d-flex justify-content-end">
                        <div class="dropdown mr-3 d-none">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(isset($filter))
                                    {{__('Filter by')}}:
                                    @switch($filter)
                                        @case('open')
                                        {{__('Open project')}}
                                        @break
                                        @case('finished')
                                        {{__('Finished')}}
                                        @break
                                        @case('private')
                                        {{__('Private')}}
                                        @break
                                        @case('public')
                                        {{__('Public')}}
                                        @break
                                        @case('company')
                                        {{__('Company')}}
                                        @break
                                        @case('product')
                                        {{__('Product')}}
                                        @break
                                        @case('new')
                                        {{__('New Brand')}}
                                        @break
                                        @case('rebrand')
                                        {{__('Rebrand')}}
                                        @break
                                    @endswitch
                                @else
                                    {{__('Filter by')}}
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-right bg-danger-"
                                aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item text-white-"
                                href="{{request()->fullUrlWithQuery(['filter'=>'open'])}}">{{__('Open project')}}</a>
                                <a class="dropdown-item text-white-"
                                href="{{request()->fullUrlWithQuery(['filter'=>'finished'])}}">{{__('Finished')}}</a>
                                <a class="dropdown-item text-white-"
                                href="{{request()->fullUrlWithQuery(['filter'=>'private'])}}">{{__('Private')}}</a>
                                <a class="dropdown-item text-white-"
                                href="{{request()->fullUrlWithQuery(['filter'=>'public'])}}">{{__('Public')}}</a>
                                <a class="dropdown-item text-white-"
                                href="{{request()->fullUrlWithQuery(['filter'=>'company'])}}">{{__('Company')}}</a>
                                <a class="dropdown-item text-white-"
                                href="{{request()->fullUrlWithQuery(['filter'=>'product'])}}">{{__('Product')}}</a>
                                <a class="dropdown-item text-white-"
                                href="{{request()->fullUrlWithQuery(['filter'=>'new'])}}">{{__('New Brand')}}</a>
                                <a class="dropdown-item text-white-"
                                href="{{request()->fullUrlWithQuery(['filter'=>'rebrand'])}}">{{__('Rebrand')}}</a>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(isset($sort))
                                    @switch($sort)
                                        @case('name')
                                        {{__('Name')}}
                                        @break
                                        @case('updated')
                                        {{__('Last updated')}}
                                        @break
                                        {{-- @case('field') --}}
                                        {{-- {{__('Field')}} --}}
                                        {{-- @break --}}
                                    @endswitch
                                @else
                                    {{__('Last updated')}}
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-right bg-danger-"
                                aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item text-white-"
                                href="{{request()->fullUrlWithQuery(['sort'=>'name'])}}">{{__('Name')}}</a>
                                <a class="dropdown-item text-white-"
                                href="{{request()->fullUrlWithQuery(['sort'=>'updated'])}}">{{__('Last updated')}}</a>
                                {{-- <a class="dropdown-item text-white" href="{{request()->fullUrlWithQuery(['sort'=>'field'])}}">{{__('Field')}}</a> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach($brandbooks as $brandbook)
                        @include('parts.brandbookitem')
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    <div id="bb-pagnation-container" class="pagination">
                        {{$brandbooks->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal-confirm-wizard">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">{{trans('general.are_you_sure')}}</div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{trans('general.cancel')}}</button>
                    <a type="button" class="btn btn-danger btn-confirm">{{trans('general.yes_edit')}}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-confirm-download">
        <div class="modal-dialog">
            <div class="modal-content rounded-1">
                <div class="modal-header">
                    <a href="#" data-dismiss="modal" style="z-index:10">
                        <svg id="closeIcon" width="49" height="49" viewBox="0 0 49 49" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.1837 12.2347L36.9573 37.2595M36.2768 12.8601L13.1837 36.6341" stroke="black"
                                stroke-width="3"/>
                        </svg>
                    </a>
                    <h1>
                        {{ trans('general.remove_watermark') }}
                    </h1>
                </div>
                <div class="modal-body">
                    {{trans('general.remove_wm_message')}}
                </div>
                <div class="modal-footer justify-content-center">
                    <a type="button" class="btn btn-danger btn-confirm btn-block" id="confirm-download">
                        {{trans('general.yes')}}
                    </a>
                    <button type="button"
                            class="btn btn-outline-secondary btn-block feedback-modal">{{trans('general.not_yet')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal-confirm-share">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="#" data-dismiss="modal" style="z-index:10">
                        <svg class="closeIcon" width="49" height="49" viewBox="0 0 49 49" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.1837 12.2347L36.9573 37.2595M36.2768 12.8601L13.1837 36.6341" stroke="black"
                                stroke-width="3"/>
                        </svg>
                    </a>
                    <h1>{{trans('general.share_header')}}</h1>
                </div>
                <div class="modal-body">{{trans('general.promoting_this_will_cost')}}</div>
                <input type="hidden" id="id"/>
                <div class="modal-footer border-top-0">
                    <a type="button" class="btn btn-danger" id="confirm-share">{{trans('general.yes')}}</a>
                    <button type="button" class="btn btn-outline-secondary feedback-modal">{{trans('general.not_yet')}}</button>
                </div>
            </div>
        </div>
    </div>
    @include('brandbook.modal.modal_feedback')
    @include('brandbook.modal.share_book')
    @include('billing.buy_plan')
    @include('billing.choose_plan')
@endsection

{{--@if (Session::has('message'))--}}
{{--    @dd(Session::get('message'));--}}
{{--@endif--}}

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/detect-mobile-browser@5.0.0/detect-browser.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.dropdown-toggle, .bb-dropdown').dropdown();
        });
        window.onload = () => {
            if ( SmartPhone.isAny() ) {
                document.querySelectorAll( '.brandbook-block a' ).forEach( item => {
                    item.addEventListener( 'click', ( e ) => {
                        e.preventDefault();
                        window.location = item.dataset[ 'href' ];
                    } );
                } );
            }
            @if (Session::has('message'))
            new Noty( {
                          type   : 'success',
                          text   : '{{Session::get('message')}}',
                          timeout: 5000,
                      } ).show();
            @endif
        };
    </script>
    <link rel="stylesheet" href="{{url("/js/chromoselector/src/chromoselector.css")}}">
@endpush
