@extends('layouts.app')

@section('content')
    <h1>選ぶ</h1>
        <p>
            <button onclick="checked()">全選択</button>
            <button onclick="unChecked()">全解除</button>
        </p>
    　　<form action="/select_user" method="POST"　enctype="multipart/form-data">
            {{ csrf_field() }}
            @foreach($followed_users_id as $followed_user_id)
                <label>
                    <input type="checkbox" value="{{ $followed_user_id->id }}" name="users_array[]">
                    {{$followed_user_id->name}}</input>
                    <p class="title__error" style="color:red">{{ $errors->first('post.title') }}</p>
                </label>
        　　@endforeach
        　　<input type="submit" value="投稿">
    　　</form>
    　　<form action="/select_user"  method="post" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit">やめる</button> 
        </form>      
@endsection