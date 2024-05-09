@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach ($urls as $url)
            <div class="card">
                <span>Url: {{ $url['original_url'] }}</span>
                <span>Shortened: {{ $url['shortened_url'] }}</span>
                <span>Redirect: {{ $url['redirect_url'] }}</span>
                <span>Created at: {{ $url['created_at'] }}</span>
                <span>Updated at: {{ $url['updated_at'] }}</span>
            </div>
        @endforeach
    </div>
@endsection