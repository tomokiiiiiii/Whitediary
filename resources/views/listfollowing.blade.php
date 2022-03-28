@extends('layouts.app')

@section('content')
        <h1>見たい人の友達一覧</h1>
        <!--if機能してない-->
        @if(!isset($following_user_ids))
        <h4>友達を追加してください</h4>
        <p class='mypage'><a href="/mypage/{{Auth::id()}}">自分のページ</a></p>
        @else
        <div class='listfollowing'>
            @foreach($following_user_ids as $following_user_id)
                <div class='following_user_id'>
                    <a href="/mypage/{{ $following_user_id->id }}">{{ $following_user_id->name }}</a>
                </div>
                <form action="/listfollowing/{{ $following_user_id->id }}" id="form_{{ $following_user_id->id }}" method="post" style="display:inline">
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