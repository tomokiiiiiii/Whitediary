@extends('layouts.app')

@section('content')
        <h1>日記</h1>
        <div class='diary'>
            <h2 class='user_id'>{{ $diary->user->name  }}</h2>
            <p class='body'>{{ $diary->diary }}</p>
            <p class='updated_at'>{{ $diary->updated_at}}</p>
            @foreach($names as $name)
            <p class='name'>{{ $name }}</p>
            @endforeach
        </div>
        @if($diary->image_path)
            <img src="{{ $diary->image_path }}">
        @endif
        <div class='back'>[<a href='/'>日記画面</a>]</div>
@endsection

