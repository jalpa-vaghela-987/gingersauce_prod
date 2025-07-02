@extends('layouts.app')

@section('content')
    @php
        $user = Auth::user();
    @endphp
    @include('profile.sidebar')
    <packages action="{{route('invoice.create')}}" :has_package="{{json_encode($user->package !== null)}}" :package="{{json_encode($user->package?$user->package->id:0)}}"></packages>
@endsection
