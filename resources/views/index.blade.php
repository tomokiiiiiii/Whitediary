@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>みんなの日記</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    </head>
    <body>
        <h1>日記</h1>
         <p class='create'>[<a href='/diaries/create'>書く</a>]</p>
        <div class='diaries'>
            @foreach($diaries as $diary)
                <a href="/mypage/{{$diary->user->id}}">{{ $diary->user->name  }}</a>
                <div class='diary'>
                    <p class='body'>{{ $diary->diary }}</p>
                    <p class='updated_at'>{{ $diary->updated_at}}</p>
                </div>
                @if ($diary->image_path)
                <img src="{{ $diary->image_path }}">
                @endif
            @endforeach
        </div>
        <div class='paginate'>
        　　{{ $diaries->links() }}
        </div>
    </body>
</html>

@endsection
