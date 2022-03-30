@extends('layouts.app')

@section('content')
    <h1>見たい人の友達一覧</h1>
    <div class="split-box left-box">
        <p class='mypage'><a href="/mypage/{{Auth::id()}}">自分のページ</a></p>
        <p class='back'><a href='/'>日記画面</a></p>
    </div>
    <div class="split-box right-box">
        <div class='listfollowing'>
            @foreach($following_user_ids as $following_user_id)
                <div class='followinglist'>
                    <a href="/mypage/{{ $following_user_id->id }}">{{ $following_user_id->name }}</a>
                </div>
                <div class="delete">
                    <form action="/listfollowing/{{ $following_user_id->id }}" id="form_{{ $following_user_id->id }}" method="post" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onClick="delete_alert(event);return false;">友達削除</button> 
                    </form>
                </div>
            @endforeach
        </div>
    </div>
    
@endsection