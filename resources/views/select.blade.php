@extends('layouts.app')

@section('content')
<div class="split-select everyone">
    <div class="normalarea">皆</div>
    <a href="/" class="btn btn-primary btn-lg">投稿</a>
    <p>
    　  <form action="/select_user"  method="post" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit">やめる</button>
        </form>
    </p>
</div>
<div class="split-select choices">
    <div class="selectionarea">選ぶ</div>
    <p>
        <button onclick="checked()">全選択</button>
        <button onclick="unChecked()">全解除</button>
    </p>
    　　<form action="/select_user" method="POST">
        @csrf
        @foreach($followed_users_id as $followed_user_id)
            <label>
                <input type="checkbox" value="{{ $followed_user_id->id }}" name="users_array[]">
                {{$followed_user_id->name}}</input>
                <p class="title__error" style="color:red">{{ $errors->first('post.title') }}</p>
            </label>
        @endforeach
        <p>
            <input type="submit" class="btn btn-primary btn-lg" value="親しい人に投稿">
        </p>
    　　</form>
</div>
@endsection