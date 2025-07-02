@extends('layouts.app')

@section('content')
    @include('profile.sidebar')
    <div class="plans-container">
        <div class="scrollable-container">
            <div class="row">
                <div class="col-12 pl-4">
                    <h1>@lang('Current Plan')</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <current-plan-card :plan="{{ json_encode($plan) }}" expire_date="{{ $plan['package_expiry'] }}"></current-plan-card>
                </div>
            </div>
            @foreach($books as $book)
                <plan-item
                    title="{{$book->brand}}"
                    expire_date="{{$book->expires_at}}"
                    :_id="{{$book->id}}"
                    preview_src="{{ $book->finished() ? route('pdf_preview', $book) : $book->logo_b64 }}"
                    book
                    {{$book->bookReccuringPayment ? 'auto_renewal' : ''}}
                    book_href="{{($book->completed>=20) ? ($book->bb_version == 1) ? route('brandbook.my').'/view/'.$book->id : route('brandbook.my').'/view-new/'.$book->id : route('brandbook.my').'/resume/'.$book->id}}"
                ></plan-item>
            @endforeach
        </div>
    </div>
    @php
        $user = Auth::user();
    @endphp
    @include('billing.buy_plan')
@endsection
@section('modals')
    <extend-modal></extend-modal>
    <submit-modal></submit-modal>
    <upgrade-plan-modal></upgrade-plan-modal>
@endsection
