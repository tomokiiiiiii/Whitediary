@extends('layouts.app')　　　　　　　　　　　　　　　　　

@section('content')
    <form action="/seach" method="POST">
            {{ csrf_field() }}
            <div class="search">
                <h2>友達検索</h2>
                <input name="search[user_id]" placeholder="user_id"/>
                <input name="search[name]" placeholder="name"/>
            </div>
            <input type="submit" value="OK"/>
        </form>
       

@endsection