@extends('layouts.app')

@section('content')
    <div class="split-box left-box">
        <h1>日記詳細</h1>
        <div class='diary'>
            <h2 class='user_id'>{{ $diary->user->name  }}</h2>
            <p class='updated_at'>{{ $diary->updated_at}}</p>
            @foreach($names as $name)
                <p class='name'>{{ $name }}</p>
            @endforeach
            
        </div>
            <a href="/mypage/{{$diary->user->id}}">ひとつ戻る</a>
            <div class='back'>[<a href='/'>日記画面</a>]</div>
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
            {{ $diary->likes->count() }}
        </div>
        @if($diary->image_path)
            <img src="{{ $diary->image_path }}">
        @endif
    </div>

@endsection

