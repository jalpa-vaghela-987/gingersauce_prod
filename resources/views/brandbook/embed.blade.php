@extends('layouts.embed')

@section('content')
<preview :is_embed='true' embed={{$data->id}}></preview>
@endsection