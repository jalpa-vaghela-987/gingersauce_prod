<?php

namespace App\Http\Controllers\Voyager;

use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerAuthController as BaseVoyagerAuthController;

class VoyagerAuthController extends BaseVoyagerAuthController
{
    protected function validateLogin(Request $request)
    {
        // Validate reCAPTCHA along with other form fields
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha', // reCAPTCHA validation
        ], $this->messages());
    }

    protected function messages()
    {
        return [
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA to prove you are not a robot.',
            'g-recaptcha-response.captcha' => 'ReCAPTCHA verification failed. Please try again.',
        ];
    }
}
