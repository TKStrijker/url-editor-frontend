@extends('layouts.app')

@section('content')
    <div class="container">
        <urls-component
            :urls={{ json_encode($urls) }}
            :authenticated_user_id={{ json_encode(Auth::user()->id )}}
        >
        </url-component>
    </div>
@endsection