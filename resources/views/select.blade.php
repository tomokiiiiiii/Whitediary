@extends('layouts.app')

@section('content')
    <h1>全世界へ向けて発信</h1>
    <button><a href="/">投稿</a></button>
    <h1>現状の人から選ぶ</h1>
        <p>
            <button onclick="checked()">全選択</button>
            <button onclick="unChecked()">全解除</button>
        </p>
    　　<form action="/select_user" method="POST">
            {{ csrf_field() }}
            @foreach($followed_users_id as $followed_user_id)
                <label>
                    <input type="checkbox" value="{{ $followed_user_id->id }}" name="users_array[]">
                    {{$followed_user_id->name}}</input>
                    <p class="title__error" style="color:red">{{ $errors->first('post.title') }}</p>
                </label>
        　　@endforeach
        　　<input type="submit" value="親しい人">
    　　</form>
    　　<form action="/select_user"  method="post" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit">やめる</button> 
        </form>      
@endsection