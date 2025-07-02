@extends('layouts.app')

@section('content')
    @include('profile.sidebar')
    <div class="plans-container">
        <div class="scrollable-container">
            <h1>@lang('profile.my_plans')</h1>
            @if(!empty($plan))
            <plan-item
                title="{{$plan['title']}}"
                expire_date="{{$plan['package_expiry']}}"
                books_remaining="{{$plan['books_remaining']}}"
                :_id="{{$plan['id']}}"
                plan
                {{$plan['autorenewal'] ? 'auto_renewal' : ''}}
            ></plan-item>
            @endif
            @foreach($books as $book)
                <plan-item
                    title="{{$book->brand}}"
                    expire_date="{{$book->expires_at}}"
                    :_id="{{$book->id}}"
                    preview_src="{{ $book->finished() ? route('pdf_preview', $book) : $book->logo_b64 }}"
                    book
                    {{$book->bookReccuringPayment ? 'auto_renewal' : ''}}
                    book_href="{{($book->completed>=20) ? route('brandbook.my').'/view/'.$book->id : route('brandbook.my').'/resume/'.$book->id}}"
                ></plan-item>
            @endforeach
        </div>
    </div>
@endsection
@section('modals')
    <extend-modal></extend-modal>
    <submit-modal></submit-modal>
    <upgrade-plan-modal></upgrade-plan-modal>
@endsection
