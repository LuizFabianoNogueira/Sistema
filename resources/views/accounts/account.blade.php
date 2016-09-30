@extends('layouts.app')

@section('content')

    @foreach($accounts as $account)
        {{ $account->name }}
    @endforeach

@endsection
