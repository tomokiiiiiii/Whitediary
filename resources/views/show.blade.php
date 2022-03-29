@extends('layouts.app')

@section('content')
    <div class="split-box left-box">
        <h1>日記詳細</h1>
        <div class='showdiary'>
            <h2 class='user_id'>{{ $diary->user->name  }}</h2>
            <p class='updated_at'>{{ $diary->updated_at}}</p>
            @foreach($names as $name)
                <p class='name'>{{ $name }}</p>
            @endforeach
            <p class='back'><a href="/mypage/{{$diary->user->id}}">ひとつ戻る</a></p>
            <p class='home'><a href='/'>日記画面</a></p>
        </div>
    </div>
    <div class="split-box right-box">
        <p class='body'>{{ $diary->diary }}</p>
        {{--like機能--}}
        <div>
            @if($diary->is_liked_by_auth_user())
                <a href="{{ route('diary.unlike', ['id' => $diary->id]) }}" class="btn btn-success btn-sm">いいね</a>
            @else
                <a href="{{ route('diary.like', ['id' => $diary->id]) }}" class="btn btn-secondary btn-sm">いいね</a>
            @endif
            <a href="/likelist/{{$diary->id}}">{{ $diary->likes->count() }}</a>
            
        </div>
        @if ($diary->image_path)
            <img width=60% src="{{ $diary->image_path }}" class="img-responsive">
        @endif
    </div>

@endsection

