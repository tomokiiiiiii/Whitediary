@extends('layouts.app')

@section('content')
<div class="split-box left-box">
    <div class="left-top">
        <h1>日記詳細</h1>
    </div>
    <div class="left-bottom"> 
        <div class='diary'>
            <div class='showinguser_id'>{{ $diary->user->name  }}</div>
        </div>
        @foreach($names as $name)
            <p class='name'>{{ $name }}</p>
        @endforeach
        <p class='back'><a href="/mypage/{{$diary->user->id}}">ひとつ戻る</a></p>
        <p class='home'><a href='/'>日記画面</a></p>
        </div>
    </div>
<div class="split-box right-box">
    <div class='showdiary'>
        <p class='body'>{{ $diary->diary }}</p>
        <p class='updated_at'>{{ $diary->updated_at}}</p>
        {{--like機能--}}
        <div class="like">
            <div class="likecount">
                <a href="/likelist/{{$diary->id}}">{{ $diary->likes->count() }}件のいいね</a>
            </div>
            @if($diary->is_liked_by_auth_user())
                <a href="{{ route('diary.unlike', ['id' => $diary->id]) }}" class="btn btn-success btn-lg">いいね</a>
            @else
                <a href="{{ route('diary.like', ['id' => $diary->id]) }}" class="btn btn-secondary btn-lg">いいね</a>
            @endif
        </div>
        @if($diary->image_path)
            <img width=60% src="{{ $diary->image_path }}" class="img-responsive">
        @endif
    </div>
</div>
@endsection

