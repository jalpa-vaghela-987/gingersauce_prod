@component('mail::message')
# {{$sender->name}} {{trans('mail.has_invited_you')}}

![Gingersauce]({{asset('images/gsrfeh.jpg')}} "Gingersauce")

{{trans('mail.at_gs_you_will_be_able')}}

@component('mail::button', ['url' => $link, 'color'=>'success'])
{{trans('mail.start_for_free')}}
@endcomponent

{{trans('mail.thanks')}},<br>
{{ config('app.name') }}
@endcomponent
