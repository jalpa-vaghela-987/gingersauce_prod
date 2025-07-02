@component('mail::message')
# {{$invoice->user->name}} . ' {{trans('mail.just_made_a_checkout')}} '
### {{trans('mail.the_first_digital')}}

![Gingersauce]({{asset('images/gsrfeh.jpg')}} "Gingersauce")

{{trans('mail.at_gs_you_will_be_able')}}


{{trans('mail.thanks')}},<br>
{{ config('app.name') }}
@endcomponent
