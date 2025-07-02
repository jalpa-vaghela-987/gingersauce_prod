<div class="d-block tabule">
    <div class="modal-subtitle text-center mb-4">
        <div>{{__('login.title-1')}}</div>
        <div>{{__('login.title-2')}}</div>
    </div>
    <div class="text-center mb-4">
        <a 
            class="btn btn-outline-secondary d-flex align-items-center" 
            onClick="window.open(
                '{{ route('social.redirect', 'facebook') }}',
                'fb-window',
                'menubar=no,location=no,resizable=no,scrollbars=no,status=no,width=600,height=600,left='+((window.innerWidth/2)-400)
            );"
            href="#">
            <img src="{{url('/images/facebook-icon.png')}}" alt="Facebook" style="justify-self: start">
            <span style="text-align: center; display: block; flex-basis: 100%;">
                {{__('login.login-with-facebook')}} 
            </span>
        </a>
    </div>
    <div class="text-center mb-4">
        <a class="btn btn-outline-secondary d-flex align-items-center" 
            onClick="window.open(
                '{{ route('social.redirect', 'google') }}',
                'fb-window',
                'menubar=no,location=no,resizable=no,scrollbars=no,status=no,width=600,height=600,left='+((window.innerWidth/2)-400)
            );"
            href="#">
            <img src="{{url('/images/google-icon.png')}}" alt="Google"  style="justify-self: start">
            <span style="text-align: center; display: block; flex-basis: 100%;">
            {{__('login.login-with-google')}}
            </span>
        </a>
    </div>
    <div class="separator">
        <span>{{__('login.or')}}</span>
    </div>
    <button class="btn btn-danger d-flex justify-content-center align-content-center w-100 login-signup-switch-button">{{__('login.login-with-email')}}</button>
    <div class="text-center mt-2">
        {{ __('login.new-to-gingersause') }} 
        <a href="{{route('register')}}">
            {{ __('login.sign-up') }}
        </a>
    </div>
</div>
<div class="d-none tabule">
    <h3 class="back-arrow">{{__('Log in with social')}}</h3>
    <div class="subtext">
        {{__('It will just take a sec')}}
    </div>
    <div class="login-form">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('E-Mail Address') }}">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <input type="hidden" name="remember" value="1">
            <div class="form-group mb-0">
                <button type="submit" class="btn btn-danger w-100 d-block">
                    {{ __('Log in') }}
                </button>
            </div>
            <div class="form-group text-center pt-3">
                @if (Route::has('password.request'))
                    <a class="btn btn-link text-danger" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
