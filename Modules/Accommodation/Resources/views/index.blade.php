@extends('accommodation')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('accomodation.name') !!}
    </p>
@stop
