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
        <div class='own_diaries'>
            <h2>{{ $user->name }}</h2> 
            @foreach($diaries as $diary)
                <div class='diary'>
                    <p class='body'>{{ $diary->diary }}</p>
                    <p class='updated_at'>{{ $diary->updated_at}}</p>
                </div>
        　　@if($diary->user_id==$auth)
             <form action="/mypage/{{ $diary->id }}" id="form_{{ $diary->id }}" method="post" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit">記事削除</button> 
             </form>
            @endif
            @if ($diary->image_path)
                <img width=60% src="{{ $diary->image_path }}" class="img-responsive">
            @endif
            @endforeach
        </div>
        <p class='back'>[<a href='/'>日記画面</a>]</p>
        <div class='paginate'>
        　　{{ $diaries->links() }}
        </div>
    </body>
</html>

@endsection
