<div class="d-block tabule">
    <div class="modal-subtitle text-center mb-4">
        <div>{{__('Create an account. its free.')}}</div>
        <div>{{__('Built by designers, For Designers.')}}</div>

    </div>
    <div class="text-center mb-4">
        <a class="btn btn-outline-secondary d-flex align-items-center" onClick="window.open(
                '{{ route('social.redirect', 'facebook') }}',
                'fb-window',
                'menubar=no,location=no,resizable=no,scrollbars=no,status=no,width=600,height=600,left='+((window.innerWidth/2)-400)
            );"
           href="#">
            <img src="{{url('/images/facebook-icon.png')}}" alt="Facebook" style="justify-self: start">
            <span style="text-align: center; display: block; flex-basis: 100%;">{{__('Sign up with')}} Facebook</span>
        </a>
    </div>
    <div class="text-center mb-4">
        <a class="btn btn-outline-secondary d-flex align-items-center" onClick="window.open(
                '{{ route('social.redirect', 'google') }}',
                'fb-window',
                'menubar=no,location=no,resizable=no,scrollbars=no,status=no,width=600,height=600,left='+((window.innerWidth/2)-400)
            );"
           href="#">
            <img src="{{url('/images/google-icon.png')}}" alt="Google"  style="justify-self: start">
            <span style="text-align: center; display: block; flex-basis: 100%;">{{__('Sign up with')}} Google</span>
        </a>
    </div>
    <div class="separator">
        <span>{{__('or')}}</span>
    </div>
    <button class="btn btn-danger d-flex justify-content-center align-content-center w-100 login-signup-switch-button">{{__('Sign up with email')}}</button>
    <div class="footer-form text-center mt-3">
        {{__('By signing up, you agree to Gingersauce’s Terms of use and Privacy Policy')}}
    </div>
    <div class="text-center mt-2">
        Already a user? <a href="{{route('login')}}">Log in here.</a>
    </div>
</div>
<div class="d-none tabule">
    <h3 class="back-arrow">{{__('Create your account')}}</h3>
    <div class="subtext">
        {{__('It will just take a sec')}}
    </div>
    <div class="login-form">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group mb-2">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{__('Name')}}">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-2">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('E-Mail') }}">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-2">
                <input id="su_password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-2">
            	<progress id="password_progress" value="0" max="100"></progress>
            	<div>
            		{{__('Use 8 or more chacters with a mix of letters, numbers & symbols.')}}
            	</div>
            </div>
            <input type="hidden" name="remember" value="1">
            <div class="form-group mb-0">
                <button type="submit" class="btn btn-danger w-100 d-block">
                    {{ __('Get started, it’s free!') }}
                </button>
            </div>
            <div class="footer-form text-center small">
            	By signing up, you agree to Gingersauce’s <a href="{{route('terms-of-use')}}" class="text-danger" target="_blank">Terms of use</a> and <a href="{{route('privacy-policy')}}" target="_blank" class="text-danger">Privacy Policy</a>.
				<br>Already signed up? <a href="{{route('login')}}" class="text-danger">Log in</a>
            </div>
        </form>
    </div>
</div>
