@extends('layouts.signupin')

@section('content')
    @include('auth.modal-login')
@endsection
@section('scripts')
    <script>
        function renderCaptcha() {
            console.log("loading login..")
            if (typeof grecaptcha !== 'undefined') {
                try {
                    grecaptcha.render('recaptcha-signin', {
                        'sitekey': '{{ config('services.captcha.sitekey') }}' // Ensure you use your site key here
                    });
                }catch (error) {
                    console.log(error);
                    grecaptcha.reset();
                }
            } else {
                console.warn("grecaptcha not available, retrying...");

                // If grecaptcha is not yet loaded, check again after some time
                setTimeout(renderCaptcha, 1000); // Check every 500 milliseconds
            }
        }
        window.onload = function () {
            renderCaptcha();
        };
    </script>
@endsection
