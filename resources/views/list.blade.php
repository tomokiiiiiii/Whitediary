@extends('layouts.app')

@section('content')
        <h1>友達一覧</h1>
        <div class='list'>
            @foreach($following_user_ids->follows as $following_user_id)
                <div class='following_user_id'>
                    <a href="/mypage/{{$following_user_id->id}}">{{ $following_user_id->name }}</a>
                    {{--<p class='name'>{{ $following_user_id->name }}</p>--}}
                </div>
                <form action="/list/{{ $following_user_id->id }}" id="form_{{ $following_user_id->id }}" method="post" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit">友達削除</button> 
                </form>
            @endforeach
            <p class='mypage'><a href="/mypage/{{Auth::id()}}">自分のページ</a></p>
        </div>
        <p class='back'>[<a href='/'>日記画面</a>]</p>
@endsection