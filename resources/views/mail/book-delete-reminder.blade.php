@component('mail::message')
# {{$brandbook->user->name}} . ' {{trans('mail.book_delete_reminder',['date'=>$brandbook->expires_at])}} '
### {{trans('mail.the_first_digital')}}

![Gingersauce]({{asset('images/gsrfeh.jpg')}} "Gingersauce")

{{trans('mail.at_gs_you_will_be_able')}}


{{trans('mail.thanks')}},<br>
{{ config('app.name') }}
@endcomponent
