@extends('layouts.app')　　　　　　　　　　　　　　　　　

@section('content')
        <form action="/search" method="POST">
            {{ csrf_field() }}
            <div class="search">
                <h1>友達追加</h1>
                <input name="search[user_id]" placeholder="user_id"/>
                <input name="search[name]" placeholder="name"/>
                 <input type="submit" class="btn btn-primary" value="OK"/>
            </div>
            <div class='listsplit-box left-box'>
                <p class='back'><a href='/'>日記画面</a></p>
                </div>
        </form>

@endsection