@extends('layouts.app')

@section('content')
        <h1>見せたい人の友達一覧</h1>
        <!--if機能してない-->
        @if(!isset($followed_user_ids))
        <h4>誰もいないようです</h4>
        <p class='mypage'><a href="/mypage/{{Auth::id()}}">自分のページ</a></p>
        @else
        <div class='listfollowed'>
            @foreach($followed_user_ids as $followed_user_id)
                <div class='followed_user_id'>
                    {{--ここおかしい全部同じ日記に飛ぶ--}}
                    {{--<a href="/mypage/{{$following_user_id->id}}">{{ $following_user_id->name }}</a>--}}
                    <p class='name'>{{ $followed_user_id->name }}</p>
                </div>
                <form action="/listfollowed/{{ $followed_user_id->id }}" id="form_{{ $followed_user_id->id }}" method="post" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" onClick="delete_alert(event);return false;">友達削除</button>
                </form>
            @endforeach
            <p class='mypage'><a href="/mypage/{{Auth::id()}}">自分のページ</a></p>
        </div>
        <p class='back'><a href='/'>日記画面</a></p>
        @endif    
@endsection