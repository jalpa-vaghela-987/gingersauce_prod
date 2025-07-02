@component('mail::message')
# {{$sender->name}} {{trans('mail.has_shared')}} {{$brandbook->brand}} {{trans('mail.brandbook')}}

{{trans('mail.please_follow_link')}}

@component('mail::button', ['url' => $link, 'color'=>'success'])
{{trans('mail.sign_up_and_view')}}
@endcomponent

{{trans('mail.thanks')}},<br>
{{ config('app.name') }}
@endcomponent
