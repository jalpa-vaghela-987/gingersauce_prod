@extends('layouts.vueApp')
@section('content')
@php
    $user = Auth::user();

    if ($user) {
        $user->setRelation('completedBrandbooks', null);
        $user->setRelation('brandbooks', null);

        $user->append('avatar_url');

        $userData = $user->toArray();
    } else {
        $userData = $user;
    }

@endphp
<router-view></router-view>
@if ($user)
    @include('billing.buy_plan')
    @include('billing.choose_plan')
    @include('brandbook.modal.confirmRemoveWatermarkModal')
    @include('brandbook.modal.modal_feedback')
    @include('brandbook.modal.share_book')
@endif
@endsection
<script>
    window.user = @json(base64_encode(json_encode($userData)));
</script>
