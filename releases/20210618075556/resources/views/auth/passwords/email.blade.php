@extends('layouts.signupin')

@section('content')
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

        <div class="form-group text-center">
            <label for="email" class="">{{ __('E-Mail Address') }}</label>

            <div class="">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

        <div class="form-group mb-0">
            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
@endsection
