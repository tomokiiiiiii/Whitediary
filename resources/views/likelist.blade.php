@extends('layouts.app')

@section('content')
    <div class="likelist">
        <div class="split-box left-box">
            <p><a href="/select/{{$diary->id}}">ひとつ戻る</a></p>
            <p><a href='/'>日記画面</a></p>
        </div>
        <div class="split-box right-box">
            <h1>いいねリスト</h1>
            @foreach($likelists as $likelist)
                <p>{{$likelist->user->name}}</p>
            @endforeach
        </div>
    </div>
@endsection