@extends('layouts.app')

@section('content')
<h1>見せたい人の友達一覧</h1>
<div class="listsplit-box left-box">
    <p class='mypage'><a href="/mypage/{{Auth::id()}}">自分のページ</a></p>
    <p class='back'><a href='/'>日記画面</a></p>
</div>
<div class="listsplit-box right-box">
    @foreach($followed_user_ids as $followed_user_id)
        <div class='followedlist'>
            <p class='name'>{{ $followed_user_id->name }}</p>
        </div>
        <div class="delete">
            <form action="/listfollowed/{{ $followed_user_id->id }}" id="form_{{ $followed_user_id->id }}" method="post" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit" onClick="delete_alert(event);return false;">友達削除</button>
            </form>
        </div>
    @endforeach
</div>
@endsection