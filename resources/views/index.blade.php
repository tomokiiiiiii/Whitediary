@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')
    <h1>日記</h1>
        <p class='follow'>[<a href='/search'>友達を追加</a>]</p>
        <p class='mypage'><a href="/mypage/{{Auth::id()}}">自分のページ</a></p>
　　　　<p class='create'>[<a href='/diaries/create'>書く</a>]</p>
        <div class='diaries'>
            @foreach($diaries as $diary)
                <a href="/mypage/{{$diary->user->id}}">{{ $diary->user->name  }}</a>
                <div class='diary'>
                    <p class='body'>{{ $diary->diary }}</p>
                    <p class='updated_at'>{{ $diary->updated_at}}</p>
                </div>
                @if($diary->image_path)
                <img width=60% src="{{ $diary->image_path }}" class="img-responsive">
                @endif
            @endforeach
        </div>
        <div class='paginate'>
            {{ $diaries->links() }}
        </div>

@endsection
