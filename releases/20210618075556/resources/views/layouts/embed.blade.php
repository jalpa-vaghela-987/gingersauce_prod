<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('parts.google_tag_head')
     <script>
        let endpoints = {
            ajax: {
                {{--get: {
                    industries: '{{route('ajax.get.industries')}}',
                    industries_related: '{{route('ajax.get.industries.related')}}',
                },--}}
                post: {
                    {{--upload_logo: '{{route('ajax.post.upload_logo')}}',
                    upload_icon: '{{route('ajax.post.upload_icon')}}',
                    upload_font: '{{route('ajax.post.upload_font')}}',
                    upload_icon_adv: '{{route('ajax.post.upload_icon_adv')}}',
--}}
                    brandbook: {
   {{--                     create: '{{route('ajax.post.brandbook.create')}}',
                        save: '{{route('ajax.post.brandbook.save')}}',
                        generate: '{{route('ajax.post.brandbook.generate_pdf')}}',
                        load: '{{route('ajax.post.brandbook.load')}}',--}}
                        load_embed: '{{route('ajax.post.brandbook.load_embed')}}',
                        {{--edit: '{{route('ajax.post.brandbook.edit')}}',
                        save_field: '{{route('ajax.post.brandbook.save_field')}}',
                        shares: '{{route('ajax.post.brandbook.shares')}}',
                        shares_add: '{{route('ajax.post.brandbook.shares_add')}}',
                        shares_edit: '{{route('ajax.post.brandbook.shares_edit')}}',
                        shares_delete: '{{route('ajax.post.brandbook.shares_delete')}}',
                        shares_link: '{{route('ajax.post.brandbook.shares_link')}}',
                        shares_code: '{{route('ajax.post.brandbook.shares_code')}}',--}}
                    }
                },
            },
        }
    </script>
    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"/>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Montserrat:300,300i,400,400i,700,700i,900,900i&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    @stack('scripts')
</head>
<body>
@include('parts.google_tag_body')
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
    @yield('scripts')
</body>
</html>
