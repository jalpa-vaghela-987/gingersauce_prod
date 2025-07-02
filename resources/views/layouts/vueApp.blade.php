<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-fonts-key" content="{{config('services.google_fonts.key')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link rel="preload" href="/img/ginger_icon_color_loader.svg" as="image">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('parts.google_tag_head')
    <script>
        let endpoints = {
            create_payment_method: "{{route('billing.create')}}",
            form                 : {
                book_extend: "{{route('invoice.create')}}",
            },
            ajax                 : {
                get : {
                    industries        : '{{route('ajax.get.industries')}}',
                    industries_related: '{{route('ajax.get.industries.related')}}',

                    themes: '{{route('ajax.get.themes')}}',
                    theme : '{{route('ajax.get.theme')}}',

                    extends         : '{{route('profile.get_extends')}}',
                    upgrade_packages: '{{route('upgrade_packages_get')}}',
                    tabs : '{{url('my/tabs')}}',
                    new_view_page : '{{url('my/new-view-page')}}',
                    new_view_brandbook_v3_page : '{{url('my/new-view-brandbook-v3-page')}}',
                    header : {
                        'plans_pricing' : '{{route('profile.plans-pricing')}}',
                        'profile' : '{{route('profile.my')}}',
                        'plans' : '{{route('profile.plans')}}',
                        'billing' : '{{route('billing.index')}}',
                        'purchase_history' : '{{route('invoice.index')}}',
                        'logout': '{{ route('logout') }}'
                    },
                    author: {
                        dashboard: `{{url('author/dashboard')}}`,
                    }
                },
                put: {
                    'edit_custom_field' : '{{url('ajax/brandbook/edit-custom-field')}}'
                },
                post: {
                    upload_logo       : '{{route('ajax.post.upload_logo')}}',
                    old_upload_logo   : '{{route('ajax.post.old_upload_logo')}}',
                    upload_icon       : '{{route('ajax.post.upload_icon')}}',
                    upload_font       : '{{route('ajax.post.upload_font')}}',
                    upload_icon_adv   : '{{route('ajax.post.upload_icon_adv')}}',
                    upload_mockup     : '{{route('ajax.post.upload_mockup')}}',
                    upload_icon_family: '{{route('ajax.post.upload_icon_family')}}',
                    graphic_element_endpoint: '{{route('ajax.post.upload_graphic_element')}}',
                    upload_misuse     : '{{route('ajax.post.upload_misuse')}}',
                    remove_watermark  : '{{ route('ajax.post.remove_watermark') }}',

                    referafriend       : '{{route('ajax.post.referafriend')}}',
                    coupon             : '{{route('ajax.post.coupon')}}',
                    load_user          : '{{route('ajax.post.load_user')}}',
                    update_billing_info: '{{route('billing.info_update')}}',
                    cc_card_save       : '{{route('billing.store')}}',
                    toggle_reccuring   : "{{route('profile.toggle_reccuting')}}",

                    colormind: '{{route('ajax.post.colormind')}}',

                    brandbook: {
                        create       : '{{route('ajax.post.brandbook.create')}}',
                        save         : '{{route('ajax.post.brandbook.save')}}',
                        save_custom  : '{{ route('save_custom') }}',
                        saveSeparate : '{{route('ajax.post.brandbook.saveSeparate')}}',
                        generate     : '{{route('ajax.post.brandbook.generate_pdf')}}',
                        load         : '{{route('ajax.post.brandbook.load')}}',
                        resume       : '{{route('ajax.post.brandbook.resume')}}',
                        edit         : '{{route('ajax.post.brandbook.edit')}}',
                        save_field   : '{{route('ajax.post.brandbook.save_field')}}',
                        shares       : '{{route('ajax.post.brandbook.shares')}}',
                        shares_add   : '{{route('ajax.post.brandbook.shares_add')}}',
                        shares_edit  : '{{route('ajax.post.brandbook.shares_edit')}}',
                        shares_delete: '{{route('ajax.post.brandbook.shares_delete')}}',
                        shares_link  : '{{route('ajax.post.brandbook.shares_link')}}',
                        shares_code  : '{{route('ajax.post.brandbook.shares_code')}}',

                        list_item: '{{route('ajax.post.brandbook.list_item')}}',
                        save_customize:"{{route('ajax.post.brandbook.save_customize')}}",
                    },
                },
            },
        };
        let translations = {
            en: {!!  File::get(base_path() . '/resources/lang/en.json')  !!},
            ja: {!! File::get(base_path() . '/resources/lang/ja.json')  !!}
        };
    </script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}?version={{config('app.release_hash')}}" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"/>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Lobster|Montserrat:300,300i,400,400i,700,700i,900,900i&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}?version={{config('app.release_hash')}}" rel="stylesheet">

    <style type="text/css">
        .submenu:hover + .dropdown-menu {
            display: block;
        }
    </style>

    @stack('scripts')
</head>
<body class="@if(Auth::check()) authed @endif">
@include('parts.google_tag_body')
<div id="app" style="height: 100%">
        @if(Auth::check())
            @include('parts.headers.auth')
        @elseif (!((\Request::segment(2) ===  "view-new" && (int)\Request::segment(3)) || (\Request::segment(2) ===  "author-dashboard")))
            @include('parts.headers.default')
        @endif
    <main style="height: 100%">
        @yield('content')
    </main>
    @yield('modals')
    <already-have-subscription-modal></already-have-subscription-modal>

</div>

{{-- Login Modal --}}
<div class="modal" tabindex="-1" role="dialog" id="loginModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <img src="{{url('/images/ginger02.png')}}" class="logo">
            <div class="modal-body">
                @include('auth.modal-login')
            </div>
        </div>
    </div>
</div>
{{-- EO Login Modal --}}
{{-- Signup Modal --}}
<div class="modal" tabindex="-1" role="dialog" id="signupModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <img src="{{url('/images/ginger02.png')}}" class="logo">
            <div class="modal-body">
                @include('auth.modal-signup')
            </div>
        </div>
    </div>
</div>

{{-- EO Signup Modal --}}
@yield('scripts')
<style>
    .loading-main {
        background: url('/img/ginger_icon_color_loader.svg');
    }

    @media screen and (max-width: 768px) {
        #username {
            max-width: 85px;
            border-left: 0;
        }
    }
</style>
@if(\Request::route()->getName() != 'profile.start')
    <div class="mobile-overlay">
        <p class="overlay-title">My Brandbooks</p>
        <div>
            <img src="/images/laptop-2-1.svg" alt="">
            <p class="mb7 overlay-bold-title">Aw Shucks!</p>
            <p class="mb7">Our mobile version<br> isn’t ready yet. </p>
            <p class="mb7">Please access gingersauce<br> with a desktop.</p>
        </div>
    </div>
@endif
{{-- @include('parts.facebook_chat') --}}
{{-- @include('parts.tawkto_chat') --}}
</body>
</html>
