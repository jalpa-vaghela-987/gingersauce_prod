@component('mail::message')
# {{$brandbook->brand}} brandbook @if($past){{trans('mail.expired')}}@else{{trans('mail.expires_in')}}@endif{{$term}}@if($past) {{trans('mail.ago')}}@endif

{{trans('mail.please_extend_expiration')}}

{{trans('mail.thanks')}},<br>
{{ config('app.name') }}
@endcomponent
